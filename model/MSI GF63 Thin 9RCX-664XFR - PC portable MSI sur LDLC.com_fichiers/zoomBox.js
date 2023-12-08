"use strict";

//if (!window.console) console = { log: function () { } };

/**
 * Zoombox class
 */

/**
 * Crée un nouvel objet ZoomBox.
 * @param HTMLElement previewDiv Conteneur de la liste de preview
 * @param HTMLElement zoomDiv    Conteneur de la version zoomée de l'image
 */
function ZoomBox(previewDiv, zoomDiv) {
  this.previewDiv = previewDiv;
  this.zoomDiv = zoomDiv;
  this.items = [];

  // On considère un pseudo-cadre à l'intérieur du div conteneur. Dans
  // la fonction pan, on considère les calculs et la position de la souris
  // à l'intérieur de ce cadre pour permettre d'atteindre plus facilement le
  // bord de l'image en déplacant la souris. Cela évite de devoir se positionner
  // sur le premier/dernier pixel du div pour voir le bord de l'image.
  // Cette taille correspond à la zone tampon
  this.panBorderSize = 20;
}

/**
 * Ajoute un nouvel élément zoomable
 * @param {ZoomItem} zoomItem un objet ZoomItem
 */
ZoomBox.prototype.addItem = function (zoomItem) {
  this.items.push(zoomItem);
  var self = this;

  // On crée la zone de preview : une <img> contenue dans
  // un <a> 
  var anchor = $("<a />");
  anchor.attr("href", "#");
  if (zoomItem.zoomType === "frame") {
    anchor.addClass('frame');
  }

  anchor.click(function (ev) {
    ev.preventDefault();
    self.itemClick(ev, zoomItem);
  });

  var image = $("<img />");
  image.attr("src", zoomItem.previewUrl);
  anchor.append(image);

  // On associe l'élément HTML cré�é à l'item
  zoomItem.previewBox = anchor;
  $(this.previewDiv).append(anchor);
};

/**
 * Evenement click d'un élément de preview
 * @param  {Event} ev       
 * @param  {ZoomItem} zoomItem L'item recevant le click
 */
ZoomBox.prototype.itemClick = function (ev, zoomItem) {
  ev.preventDefault();
  var self = this;

  // On récupère l'élément de preview pour le tagger
  var currentTarget = $(ev.currentTarget);
  $(this.previewDiv).find('a.selected div').remove();
  $(this.previewDiv).find('a.selected').removeClass('selected');
  currentTarget.addClass('selected');

  var jqZoom = $(this.zoomDiv);

  // Vide la zone Zoom
  jqZoom.empty();

  if (zoomItem.zoomType === "image") {
    // ajoute l'image zoomé au conteneur

    if (zoomItem.image) {
      // Si l'image a déjà été chargée précédement, on a
      // plus qu'à l'initialiser
      self.initializeImage(zoomItem.image);
    } else {
      // On prépare l'objet image
      var image = new Image()
      image.src = zoomItem.zoomUrl;
      image.previewBox = zoomItem.previewBox;
      // On charge l'image de maniàre asynchrone
      $(image).on('load', function () {
        zoomItem.image = image;

        // On récupàre la taille réelle de l'image
        image.maxWidth = image.width;
        image.maxHeight = image.height;
        // Calcul du ratio de l'image
        image.ratio = image.width / image.height;

        // Chargement de l'image dans le div
        self.initializeImage(image);

      });

    }

  } else if (zoomItem.zoomType === "frame") {
    // add iframe as zoom content
    var frame = $("<iframe />");
    frame.attr("src", zoomItem.zoomUrl);
    frame.css("height", jqZoom.innerHeight());
    frame.css("width", jqZoom.innerWidth());
    // append content to zoom div
    jqZoom.append(frame);
  }

};

/**
* Initialisation de l'image zoom
* @param {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.initializeImage = function (image) {
  var self = this;

  image.zoom = 0;
  image.nonzoomable = 0;
  image.offsetZoomX = 0, image.offsetZoomY = 0;
  image.mousePositionX = 0, image.mousePositionY = 0;

  // Compute correct image size based on image aspect ratio
  self.adaptImageZoom(image);

  var jqZoom = $(this.zoomDiv);
  var jqImage = $(image);

  function is_touch_device() {
    try {
      document.createEvent("TouchEvent");
      return true;
    } catch (e) {
      return false;
    }
  }

  if (!image.nonzoomable) {
    // TODO Connect event

    if (is_touch_device()) { // tactile
      jqImage.hammer().on("tap", function (ev) {
        self.zoomTap(ev, image);
      });

      jqImage.hammer().on("transformstart", function (ev) {
        self.zoomPinchStart(ev, image);
      });

      jqImage.hammer({ transform_min_scale: 0.2, transform_always_block: true }).on("pinch", function (ev) {
        self.zoomPinch(ev, image);
      });

      jqImage.hammer({ drag_max_touches: 0, drag_min_distance: 0, drag_lock_to_axis: true }).on("touch drag", function (ev) {
        self.zoomDrag(ev, image);
      });
    } else { // pc
      jqImage.click(function (ev) {   
        self.zoomClick(ev, image);
      });

      jqImage.bind('mousewheel DOMMouseScroll', function (ev) {
        self.zoomScroll(ev, image);
      });

      jqImage.mousemove(function (ev) {
        self.zoomMove(ev, image);
      });
    }
  }

  $(window).resize(function (ev) {
    self.adaptImageZoom(image);
  })

  jqZoom.append(jqImage);
}
/**
 * Traitements sur l'image (taille, position)
 * @param {Image} image L'image à afficher dans le zoom
 */
ZoomBox.prototype.adaptImageZoom = function (image) {
  var jqZoom = $(this.zoomDiv);
  var jqImage = $(image);

  var divWidth = jqZoom.innerWidth();
  var divHeight = jqZoom.innerHeight();

  var maxWidth = image.maxWidth;
  var maxHeight = image.maxHeight;
  var minWidth = divWidth;
  var minHeight = divHeight;

  var currentWidth = 0, currentHeight = 0;


  var divRatio = divWidth / divHeight;
  var offsetTop = 0, offsetLeft = 0;

  // On s'assure que le zoom est dans les bornes
  // attendues [0..100]
  if (image.zoom > 100) {
    image.zoom = 100;
  }
  if (image.zoom < 0) {
    image.zoom = 0;
  }

  // Si l'image tient dans le div conteneur
  if (maxWidth < divWidth &&
    maxHeight < divHeight) {

    offsetTop = Math.ceil((divHeight - maxHeight) / 2);
    offsetLeft = Math.ceil((divWidth - maxWidth) / 2);
    jqImage.css('top', offsetTop);
    jqImage.css('left', offsetLeft);
    image.className = "nonzoomable";
    image.nonzoomable = 1;
    return;
  }

  // On redimensionne l'image si elle ne tient pas dans le div
  if (image.ratio > divRatio) {
    minHeight = minWidth / image.ratio;
  } else {
    minWidth = minHeight * image.ratio;
  }

  var previousLeft = parseFloat(jqImage.css('left')) || 0;
  var previousTop = parseFloat(jqImage.css('top')) || 0;
  var previousWidth = parseFloat(jqImage.css('width')) || minWidth;
  var previousHeight = parseFloat(jqImage.css('height')) || minHeight;

  currentWidth = minWidth + (maxWidth - minWidth) * image.zoom / 100;
  currentHeight = minHeight + (maxHeight - minHeight) * image.zoom / 100;

  // le panFactor est calculé relativement à un cadre plus petit que le
  // div conteneur pour permettre de se déplacer jusqu'au bord de l'image
  var panFactorWidth = (currentWidth - divWidth + 2*this.panBorderSize) / divWidth;
  var panFactorHeight = (currentHeight - divHeight + 2*this.panBorderSize) / divHeight;

  // Crée ou récupère le repère visuel
  //var jqPreview = $(image.previewBox);
  var jqPreview = $(this.previewDiv).find('a.selected');
  var divRepere;
  if(jqPreview.find("div").length > 0) {
    divRepere = $(jqPreview.find("div")[0]);
  } else {
    divRepere = $("<div />");
    jqPreview.append(divRepere);
  }
 

  if (image.zoom === 0) {
    // Si pas de zoom, on centre simplement l'image dans le 
    // conteneur
    offsetLeft = Math.ceil((divWidth - currentWidth) / 2);
    offsetTop = Math.ceil((divHeight - currentHeight) / 2);
    divRepere.css("display", "none");

  } else { 
    // On va positionner l'image en fonction de la position de la souris
    // dans le div conteneur réduit de 'panBorderSize'.
    var previewBoxWidth = parseFloat(jqPreview.css("width")) - 4;
    var previewBoxHeight = parseFloat(jqPreview.css("height")) - 4;
    var repereWidth = 0;
    var repereHeight = 0;
    var repereOffsetLeft = 0;
    var repereOffsetTop = 0;
    
    if(panFactorWidth > 0) {
      offsetLeft = -(image.mousePositionX-this.panBorderSize)*panFactorWidth;
      // Controle des limites : on vérifie que l'image n'est pas trop déplacée
      // pour éviter les "bandes blanches" entre l'image et le div conteneur
      if(offsetLeft > 0) {
        offsetLeft = 0;
      } else if(offsetLeft < (divWidth - currentWidth)) {
        offsetLeft = divWidth - currentWidth;
      }

      // On reporte les infos pour le repère visuel
      repereWidth = previewBoxWidth * divWidth / currentWidth;
      repereOffsetLeft = -previewBoxWidth * offsetLeft / currentWidth;
    } else {
      offsetLeft = Math.ceil((divWidth - currentWidth) / 2);
      repereWidth = previewBoxWidth;
      repereOffsetLeft = 0;
    }

    if(panFactorHeight > 0) {
      offsetTop = -(image.mousePositionY-this.panBorderSize)*panFactorHeight;
      // Controle des limites : on vérifie que l'image n'est pas trop déplacée
      // pour éviter les "bandes blanches" entre l'image et le div conteneur
      if(offsetTop > 0) {
        offsetTop = 0;
      } else if(offsetTop < (divHeight - currentHeight)) {
        offsetTop = divHeight - currentHeight;
      }

      // On reporte les infos pour le repère visuel
      repereHeight = previewBoxHeight* divHeight / currentHeight;
      repereOffsetTop = -previewBoxHeight * offsetTop / currentHeight;
    } else {
      offsetTop = Math.ceil((divHeight - currentHeight) / 2);   
      repereHeight = previewBoxHeight;
      repereOffsetTop = 0;
    }

    divRepere.css("display", "block");
    divRepere.css("width", repereWidth);
    divRepere.css("height", repereHeight);
    divRepere.css("left", repereOffsetLeft);
    divRepere.css("top", repereOffsetTop);
  }

  jqImage.css('width', currentWidth);
  jqImage.css('height', currentHeight);
  
  jqImage.css('top', offsetTop);
  jqImage.css('left', offsetLeft);

  if (image.zoom > 0) {
    image.className = "zoomed";
  } else {
    image.className = "";
  }
};

/**
 * Evenement click de l'image zoom�e
 * @param  {Event} ev 
 * @param  {Image} image L'image à afficher dans le zoom
 */
ZoomBox.prototype.zoomClick = function (ev, image) {
  ev.preventDefault();

  image.zoom = image.zoom > 0 ? 0 : 100;

  // Coordonnées de la souris dans le div conteneur
  image.mousePositionX = ev.clientX - $(this.zoomDiv).offset().left + $(window).scrollLeft();
  image.mousePositionY = ev.clientY - $(this.zoomDiv).offset().top + $(window).scrollTop();
  
  this.adaptImageZoom(image);
};

/**
* Evenement scroll de l'image zoom�e
* @param  {Event} ev 
* @param  {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.zoomScroll = function (ev, image) {
  ev.preventDefault();

  var delta = ev.originalEvent.wheelDelta > 0 ? 1 : -1; //IE, Chrome
  if (ev.originalEvent.detail)  // Mozilla
    delta = -ev.originalEvent.detail > 0 ? 1 : -1;

  image.zoom += delta * 10;
  
  // Coordonnées de la souris dans le div conteneur
  image.mousePositionX = ev.originalEvent.clientX - $(this.zoomDiv).offset().left + $(window).scrollLeft();
  image.mousePositionY = ev.originalEvent.clientY - $(this.zoomDiv).offset().top + $(window).scrollTop();

  this.adaptImageZoom(image);
};

/**
* Evenement pinchStart de l'image zoom�e
* @param  {Event} ev 
* @param  {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.zoomPinchStart = function (ev, image) {
  
  // On sauvegarde le centre du pinch au début de la gesture
  image.pinchCenterX = ev.gesture.center.pageX;
  image.pinchCenterY = ev.gesture.center.pageY;
  image.zoomStart = image.zoom;

//  this.adaptImageZoom(image);
};

/**
* Evenement pinch de l'image zoom�e
* @param  {Event} ev 
* @param  {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.zoomPinch = function (ev, image) {
  ev.gesture.preventDefault();

  // Calcul le centre du pinch dans le div conteneur
  image.mousePositionX = image.pinchCenterX - $(this.zoomDiv).offset().left;
  image.mousePositionY = image.pinchCenterY - $(this.zoomDiv).offset().top;

  image.zoom = (50 + image.zoomStart) * ev.gesture.scale - 50;

  this.adaptImageZoom(image);
};

/**
* Evenement tap (click tactile) de l'image zoomée
* @param  {Event} ev 
* @param  {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.zoomTap = function (ev, image) {
  ev.gesture.preventDefault();

  image.zoom = image.zoom > 0 ? 0 : 100;

  // Calcul le centre du tap dans le div conteneur
  image.mousePositionX = ev.gesture.center.pageX - $(this.zoomDiv).offset().left;
  image.mousePositionY = ev.gesture.center.pageY - $(this.zoomDiv).offset().top;

  image.zoom = (50 + image.zoom) * ev.gesture.scale - 50;

  this.adaptImageZoom(image);
};

/**
* Evenement drag (move tactile) de l'image zoomée
* @param  {Event} ev 
* @param  {Image} image L'image à afficher dans le zoom
*/
ZoomBox.prototype.zoomDrag = function (ev, image) {
  ev.gesture.preventDefault();

  // Coordonnées du touch dans le div conteneur
  image.mousePositionX = ev.gesture.center.pageX - $(this.zoomDiv).offset().left;
  image.mousePositionY = ev.gesture.center.pageY - $(this.zoomDiv).offset().top;

  this.adaptImageZoom(image);
};

/**
 * Evenement move de l'image zoomée
 * @param  {Event} ev 
 * @param  {Image} image L'image à afficher dans le zoom
 */
ZoomBox.prototype.zoomMove = function (ev, image) {

  // Coordonnée de la souris dans le div conteneur
  image.mousePositionX = ev.clientX - $(this.zoomDiv).offset().left + $(window).scrollLeft();
  image.mousePositionY = ev.clientY - $(this.zoomDiv).offset().top + $(window).scrollTop();

  this.adaptImageZoom(image);


};


/**
 * ZoomItem Class
 * @param {String} previewUrl The url of the preview image
 * @param {String} zoomUrl    The url of the zoomed image or the frame content url
 * @param {String} zoomType   The type of zoom content. Either 'image' for 
 *                            image content or 'frame' for external HTML content 
 */
function ZoomItem(previewUrl, zoomUrl, zoomType) {
  this.previewUrl = previewUrl;
  this.zoomUrl = zoomUrl;
  this.zoomType = zoomType;
}