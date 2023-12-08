
window.addEventListener("load", function(event) {
var optionsParameters="";

if (screen) {
    if (screen.colorDepth) {
        optionsParameters+="&sd="+screen.colorDepth+"-bits";
    }
    if ((screen.width) && (screen.height)) {
        optionsParameters+="&sr="+screen.width+"x"+screen.height;
    }
}

if (window) {
    if ((window.width) && (window.height)) {
        optionsParameters+="&vp="+window.width+"x"+window.height;
    } else if ((window.innerWidth) && (window.innerHeight)) {
        optionsParameters+="&vp="+window.innerWidth+"x"+window.innerHeight;
    } 
}
if (document) {
    if (document.inputEncoding) {
        optionsParameters+="&de="+document.inputEncoding;
    }
    if (document.title) {
        if (encodeURI) {
            optionsParameters+="&dt="+encodeURI(document.title);
        }
    }
    if (document.referrer) {
        if (document.referrer.length > 0) {
            if (encodeURI) {
                optionsParameters+="&dr="+encodeURI(document.referrer);
            }
        }
    }
}

if (navigator) {
    if (navigator.language) {
        optionsParameters+="&ul="+navigator.language.toLowerCase();
    }
}

if (optionsParameters.length > 0) {
    if (optionsParameters.substr(0, 1) == "&") {
        optionsParameters="?"+optionsParameters.substr(1);
    }
}
if ((Math) && (Math.floor) && (Math.random)) {
    var zRnd=Math.floor(Math.random() * 1E10)+1E9;
    optionsParameters+="&z="+zRnd;
}

if (dataLayer) {
    var purchase=null;
    for(var i=0;i<dataLayer.length;i++) {
        if ((dataLayer[i].event) && (dataLayer[i].event.toLowerCase()=="purchase") && (dataLayer[i].ecommerce) && (dataLayer[i].ecommerce.purchase)) {
            optionsParameters+="&pa=purchase";
            purchase=dataLayer[i].ecommerce.purchase;
        }
    }
    if ((purchase != null) && (purchase.actionField)) {
        
        if (purchase.actionField.id) {
            optionsParameters+="&ti="+purchase.actionField.id;
        }
        if (purchase.actionField.revenue) {
            optionsParameters+="&tr="+purchase.actionField.revenue;
        }
        if (purchase.actionField.tax) {
            optionsParameters+="&tt="+purchase.actionField.tax;
        }
        if (purchase.actionField.shipping) {
            optionsParameters+="&ts="+purchase.actionField.shipping;
        }

        if (purchase.products) {
            for(var p=0;p<purchase.products.length;p++) {
                var product=purchase.products[p];
                if (product.id) {
                    optionsParameters+="&pr"+(p+1)+"id="+encodeURI(product.id);
                }
                if (product.name) {
                    optionsParameters+="&pr"+(p+1)+"nm="+encodeURI(product.name);
                }
                if (product.category) {
                    optionsParameters+="&pr"+(p+1)+"ca="+encodeURI(product.category);
                }
                if (product.brand) {
                    optionsParameters+="&pr"+(p+1)+"br="+encodeURI(product.brand);
                }
                if (product.price) {
                    optionsParameters+="&pr"+(p+1)+"pr="+product.price;
                }
                if (product.quantity) {
                    optionsParameters+="&pr"+(p+1)+"qt="+product.quantity;
                }
            }
        }
    }
}

var machineImageUrl="/V4px/imgs/machine.gif"+optionsParameters;

if ((document) && (document.createElement)) {
    var machineImage=document.createElement("img");
    machineImage.src=machineImageUrl;
    machineImage.style.display="none";

    if ((document.body) && (document.body.appendChild)) {
        document.body.appendChild(machineImage);
    }
}

});
