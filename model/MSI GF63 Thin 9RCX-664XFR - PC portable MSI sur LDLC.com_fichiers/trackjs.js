function rpap(a){PostAffTracker._processFlashCookies(a)}function setVisitor(a){PostAffTracker.setVisitorId(a)}function trackingFinished(){PostAffTracker.onTrackingFinished()}function setAffiliateInfo(a,b){PostAffTracker._setAffiliateInfo(a,b)}function papTrack(){PostAffTracker.track()}if(PostAssoc=function(){},PostAffAction=function(a){void 0==a&&(a=""),this.ac=a},PostAffAction.prototype.quote=function(a){var b=/[\\\"\/\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,c={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\","/":"\\/"};return b.lastIndex=0,b.test(a)?'"'+a.replace(b,function(a){var b=c[a];return"string"==typeof b?b:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'},PostAffAction.prototype.toString=function(){var a="";for(var b in this){var c=this[b];"string"==typeof c&&(a+='"'+b+'":'+this.quote(c)+",")}return"{"+a.substring(0,a.length-1)+"}"},PostAffAction.prototype._correctString=function(a,b){if("undefined"==typeof a)return null;var c=new String(a);c=c.replace(/,/g,"."),c=this._removeDotButFirst(c);var d=new RegExp("["+b+"]","gi");return c=c.replace(d,""),c=c.replace(/^[0]+/g,"")},PostAffAction.prototype._correctCurrency=function(a){var b=this._correctString(a,"^0-9.-");return 0==b.indexOf("-")?"-"+this._correctString(b.substring(1),"^0-9."):this._correctString(b,"^0-9.")},PostAffAction.prototype._removeDotButFirst=function(a){return pos=a.indexOf("."),a.substring(0,pos+1)+a.substring(pos+1).replace(/\./gi,"")},PostAffAction.prototype._correctCommission=function(a){return"0"==a?a:(a=this._correctString(a,"^-0-9.%"),null==a?null:0==a.indexOf("%")?"%"+this._correctCurrency(a.substring(1)):"%"==a.charAt(a.length-1)?this._correctCurrency(a.substring(0,a.length-1))+"%":this._correctCurrency(a))},PostAffAction.prototype._correctText=function(a){if("undefined"==typeof a)return null;var b=new String(a);return b.toString()},PostAffAction.prototype.setTotalCost=function(a){this.t=this._correctCurrency(a)},PostAffAction.prototype.setCoupon=function(a){this.cp=this._correctText(a)},PostAffAction.prototype.setFixedCost=function(a){this.f=this._correctCommission(a)},PostAffAction.prototype.setOrderID=function(a){this.o=this._correctText(a)},PostAffAction.prototype.setProductID=function(a){this.p=this._correctText(a)},PostAffAction.prototype.setAffiliateID=function(a){this.a=this._correctText(a)},PostAffAction.prototype.setBannerID=function(a){this.b=this._correctText(a)},PostAffAction.prototype.setCampaignID=function(a){this.c=this._correctText(a)},PostAffAction.prototype.setChannelID=function(a){this.ch=this._correctText(a)},PostAffAction.prototype.setCurrency=function(a){this.cr=this._correctText(a)},PostAffAction.prototype.setCustomCommission=function(a){var b=a.split(";");this.cc="";for(var c=0;c<b.length;c++)this.cc+=this._correctCommission(b[c]),c+1<b.length&&(this.cc+=";")},PostAffAction.prototype.setCustomCommissionNextTiersFromCampaign=function(a){this.ccfc=a},PostAffAction.prototype.setStatus=function(a){this.s=a},PostAffAction.prototype.setData1=function(a){this.d1=this._correctText(a)},PostAffAction.prototype.setData2=function(a){this.d2=this._correctText(a)},PostAffAction.prototype.setData3=function(a){this.d3=this._correctText(a)},PostAffAction.prototype.setData4=function(a){this.d4=this._correctText(a)},PostAffAction.prototype.setData5=function(a){this.d5=this._correctText(a)},PostAffAction.prototype.setTimeStamp=function(a){this.ts=this._correctText(a)},PostAffAttributeWriter=function(a,b,c,d){function j(a){return void 0==a||""==a?null:a}var i,e=a,f=b,g=c,h=j(d);i="string"==typeof g&&""!=g?new PostUrlReplacer(g,h,!0):new PostValueReplacer(h),this.getElementsById=function(a){for(var b=new Array,c=document.getElementById(a);c;){b.push(c),c.id="",c=document.getElementById(a);for(var d=0;d<b.length;d++)b[d]==c&&(c=!1)}for(var d=0;d<b.length;d++)b[d].id=a;return b},this.getElementsByClassName=function(a){var b=document.getElementsByClassName(a);return b},this.writeAttribute=function(a){if(null!=a&&""!=a){var b=this.getElementsById(e);0==b.length&&(b=this.getElementsByClassName(e));for(var c=0;c<b.length;c++)switch(f){case"href":b[c].href=i.replace(b[c].href,a);break;case"value":b[c].value=i.replace(b[c].value,a);break;case"action":b[c].action=i.replace(b[c].action,a);break;default:b[c].setAttribute(f,i.replace(b[c].getAttribute(f),a))}}}},PostUrlReplacer=function(a,b,c){var d=!1,e=a,f=b,c=c;this.replace=function(a,b){var g=PostAffParams.parse(a);if(oldParamValue=g.getParamValue(e),null==f)return oldParamValue!=b&&g.addParam(e,b),d=!0,g.toString(c);void 0==oldParamValue&&(oldParamValue=""),d&&(oldParamValue.indexOf(f)!=-1?oldParamValue=oldParamValue.substring(0,oldParamValue.lastIndexOf(f)):oldParamValue="");var h=b;return""!=oldParamValue&&(h=oldParamValue+f+b),""!=b&&void 0!=b||(h=oldParamValue),g.addParam(e,h),d=!0,g.toString()}},PostValueReplacer=function(a){var b=!1,c=a;this.replace=function(a,d){return null==c||""==a?(b=!0,d):(b&&(a=a.substring(0,a.lastIndexOf(c))),b=!0,""==d||void 0==d?a:""==a||void 0==a?d:a+c+d)}},PostAffCookieManager=function(){function addOldCookie(a){oldCookies[a.name]=a}function loadOldHttpCookies(){for(var a in oldCookies)try{oldCookies[a].load()}catch(a){}}function getFlashVersion(){var version="",n=navigator;if(n.plugins&&n.plugins.length){for(var i=0;i<n.plugins.length;i++)if(n.plugins[i].name.indexOf("Shockwave Flash")!=-1){version=n.plugins[i].description.split("Shockwave Flash ")[1];break}}else if(window.ActiveXObject)for(var j=10;j>=4;j--)try{var result=eval("new ActiveXObject('ShockwaveFlash.ShockwaveFlash."+j+"');");if(result){version=j+".0";break}}catch(a){}return version}var flash=null,flashVersion=null,_domain=null,visitorCookie=new PostAffCookie("PAPVisitorId"),_doNotUseFlashCookie=!1,oldCookies=new PostAssoc;addOldCookie(new PostAffCookie("PAPCookie_Sale")),addOldCookie(new PostAffCookie("PAPCookie_FirstClick")),addOldCookie(new PostAffCookie("PAPCookie_LastClick")),this.setDoNotUseFlashCookie=function(a){this._doNotUseFlashCookie=a},this.setCookieDomain=function(a){this._domain=a},this.isFlashActive=function(){return!this._doNotUseFlashCookie&&(!(!PostAffTracker.isCustomFlashUrl()&&window.location.hostname!=PostAffTracker.getScriptDomain())&&(null==flashVersion&&(flashVersion=getFlashVersion()),!(""==flashVersion||flashVersion.localeCompare("19")<0)))},this.callFlash=function(a){this.removeFlashElement(),this.insertFlashElement(a)},this.deleteOldCookies=function(){for(var a in oldCookies)try{oldCookies[a].deleteCookie()}catch(a){}},this.readAllFlashCookies=function(){var a=new Array(visitorCookie.name),b=1;for(var c in oldCookies)a[b]=oldCookies[c].name,b++;this.readFlashCookies(a)},this.loadHttpCookies=function(){loadOldHttpCookies(),visitorCookie.load()},this.loadRestoreHtmlStorageCookies=function(){window.localStorage&&(null!=localStorage.getItem("PAPVisitorId")&&"null"!=localStorage.getItem("PAPVisitorId")?null==visitorCookie.value&&(visitorCookie.value=localStorage.getItem("PAPVisitorId"),visitorCookie.trackingMethod="S"):null!=visitorCookie.value&&localStorage.setItem("PAPVisitorId",visitorCookie.value))},this.removeFlashElement=function(){if(null!=flash)try{flash.parentNode.removeChild(flash),flash=null}catch(a){}},this.insertFlashElement=function(a){if(this.isFlashActive()){var b=a.toString();b=b.replace(/&/g,"&amp;");var c="papswf",d="<object"+(window.ActiveXObject?' id="'+c+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" data="'+PostAffTracker.getFlashUrl()+b+'"':"");d+=' width="1px" height="1px">',d+='<param name="movie" value="'+PostAffTracker.getFlashUrl()+b+'" />',d+='<param name="AllowScriptAccess" value="always" />',d+='<embed src="'+PostAffTracker.getFlashUrl()+b+'" type="application/x-shockwave-flash" width="1px" height="1px" AllowScriptAccess="always"></embed>',d+="</object>",flash=document.createElement("div"),flash.setAttribute("style","position:absolute;bottom:0px;left:0px;"),flash.innerHTML=d;var e=document.getElementById(PostAffTracker.getIntegrationElementId());e.parentNode.insertBefore(flash,e.nextSibling)}},this.saveVisitorToHttpCookie=function(a){PostAffCookie.setHttpCookie(visitorCookie.name,a,null,this._domain)},this.writeVisitorIdToHTMLStorage=function(a){window.localStorage&&localStorage.setItem("PAPVisitorId",a)},this.getOldCookiesSerialized=function(){var a="";for(var b in oldCookies)""!=oldCookies[b].value&&null!=oldCookies[b].value&&(a+="||"+oldCookies[b].name+"="+oldCookies[b].value);return a},this.readFlashCookies=function(a){var b=new PostAffParams(this.getSwfFileName());b.addParam("a","r");for(var c=0;c<a.length;c++)b.addParam("n"+c,a[c]);this.callFlash(b)},this.deleteFlashCookies=function(a){var b=new PostAffParams(this.getSwfFileName());b.addParam("a","r");for(var c in a)b.addParam("n"+c,a[c]),b.addParam("d"+c,"1");this.callFlash(b)},this.writeFlashCookies=function(a){var b=new PostAffParams(this.getSwfFileName());b.addParam("a","w");for(var c=0;c<a.length;c++)b.addParam("n"+c,a[c].name),b.addParam("v"+c,a[c].value),"1"==a[c].getOverwrite()&&b.addParam("ne"+c,a[c].getOverwrite());this.callFlash(b)},this.getSwfFileName=function(){if(PostAffTracker.isCustomFlashUrl()){var a=PostAffTracker.getFullFlashUrl();if(".swf"==a.substr(a.length-4))return a.substr(a.lastIndexOf("/")+1)}return PostAffTracker.isScriptNameHashed()?PostAffTracker.getScriptName()+".swf":"pap.swf"},this.getFlashCookies=function(a){for(var c,b=new PostAssoc,d=a.split("_,_"),e=0;e<d.length;e++){var f=d[e].indexOf("=");f<0||d[e].length==f+1||(c=new PostAffCookie(d[e].substr(0,f)),c.value=d[e].substr(f+1),b[c.name]=c)}return b},this.parseFlashCookies=function(a){this.processFlashCookies(this.getFlashCookies(a))},this.getVisitorCookie=function(){return visitorCookie},this.processFlashCookie=function(a){return"object"==typeof oldCookies[a.name]?void(oldCookies[a.name].value=a.value):void(a.name==visitorCookie.name&&(null!=visitorCookie.value&&""!=visitorCookie.value||(visitorId=visitorCookie.value=a.value,visitorCookie.trackingMethod="F")))},this.getVisitorId=function(){return this.getVisitorCookie().value},this.getVisitorIdOrSaleCookieValue=function(){return null!=this.getVisitorCookie().value?this.getVisitorCookie().value:oldCookies.PAPCookie_Sale.value},this.writeVisitorIdToFlash=function(){var a=new Array;a[0]=visitorCookie,this.writeFlashCookies(a)},this.setVisitorId=function(a){visitorCookie.value=a,visitorCookie.trackingMethod="",this.saveVisitorToHttpCookie(a),this.writeVisitorIdToFlash(),this.writeVisitorIdToHTMLStorage(a)}},PostAffCookieManager.prototype.processFlashCookies=function(a){for(var b in a)this.processFlashCookie(a[b]);"object"!=typeof a[this.getVisitorCookie().name]&&null!=this.getVisitorCookie().value&&this.writeVisitorIdToFlash()},PostAffParams=function(a){var b=new PostAssoc;this.script=a,this.addParam=function(a,c,d){"undefined"!=typeof b[a]&&1==d||(b[a]=[]),b[a].push(c)},this.getParamValue=function(a){return b[a]instanceof Array?b[a][0]:b[a]},this.encodeParams=function(a){var c="?";for(var d in b)for(var e=0;e<b[d].length;e++){if(null==a||0==a)var f=encodeURIComponent(b[d][e]);else var f=b[d][e];c+=d+"="+f+"&"}return c.substr(0,c.length-1)},this.toString=function(a){return this.script+this.encodeParams(a)}},PostAffParams.parse=function(a){var b,c=a.split("?"),d=new PostAffParams(c[0]);if(c.length>1){parameters=c[1].split("&");for(var e=0;e<parameters.length;e++)b=parameters[e].split("="),d.addParam(b[0],b[1],!0)}return d},PostAffParams.replaceHttpInText=function(a){return a=a.replace("http://","H_"),a=a.replace("https://","S_")},PostAffParams.getReferrer=function(){var a=PostAffParams.parse(document.location.search).getParamValue("refx2s6d");return null!=a&&""!=a?a:document.location.href.split("refx2s6d=")[1]?document.location.href.split("refx2s6d=")[1]:document.referrer},PostAffCookie=function(a){this.name=a,this.value=null,this.trackingMethod="";var b="1";this.load=function(){this.value=PostAffCookie.getHttpCookie(this.name),null!=this.value&&(this.trackingMethod="1")},this.setOverwrite=function(){b="0"},this.getOverwrite=function(){return b},this.deleteCookie=function(){PostAffCookie.deleteHttpCookie(this.name,this._domain)}},PostAffCookie.getHttpCookie=function(a){var b=document.cookie.match("(^|;) ?"+a+"=([^;]*)(;|$)");return b&&""!=b[2]?decodeURIComponent(b[2]):null},PostAffCookie.setHttpCookie=function(a,b,c,d){if(null==c)var e=new Date,c=new Date(e.getTime()+33696000000);d=null==d?"":";domain="+d,document.cookie=a+"="+encodeURIComponent(b)+";expires="+c.toGMTString()+d+";path=/"},PostAffCookie.deleteHttpCookie=function(a,b){expired=new Date(0),PostAffCookie.setHttpCookie(a,"",expired,b)},PostAffRequest=function(a){this.cookieManager=a,this.sendCalled=!1,this.send=function(){if(this.sendCalled=!0,this.loadHttpCookies(),this.loadRestoreHtmlStorageCookies(),this.cookieManager.isFlashActive()){var a=this;return PostAffTracker.pendingCallbacksFlashCookies.push(function(){a.callTrackScript()}),this.cookieManager.readAllFlashCookies(),void setTimeout(function(){PostAffTracker.onFlashCookiesReceived()},2e3)}this.callTrackScript()}},PostAffRequest.prototype.accountId,PostAffRequest.prototype.setAccountId=function(a){this.accountId=a},PostAffRequest.prototype.loadHttpCookies=function(){this.cookieManager.loadHttpCookies()},PostAffRequest.prototype.loadRestoreHtmlStorageCookies=function(){this.cookieManager.loadRestoreHtmlStorageCookies()},PostAffRequest.prototype.getTrackingParams=function(){console.log("getTrackingParams parent")},PostAffRequest.prototype.fillTrackingParams=function(){var a=this.getTrackingParams(),b=this.cookieManager.getVisitorId();return null!=b&&"null"!=b&&a.addParam("visitorId",b),null!=this.accountId&&"null"!=this.accountId&&""!=this.accountId&&a.addParam("accountId",this.accountId),a},PostAffRequest.prototype.callTrackScript=function(){var a=this.fillTrackingParams(),b=document.createElement("script");b.type="text/javascript",b.src=PostAffTracker.getRequestUrl()+a.toString(),scriptElement=document.getElementById(PostAffTracker.getIntegrationElementId()),scriptElement.parentNode.insertBefore(b,scriptElement.nextSibling)},PostAffInfo=function(a){this.cookieManager=a;var b,c,e=!1,f=new Array;this.onResponseReceived=function(){e=!0;for(var a=0;a<f.length;a++)f[a]();f=new Array},this.call=function(a){return e?void a():(f[f.length]=a,void(this.sendCalled||this.send()))},this.setAccountId=function(a){this.accountId=a},this.setAffiliateInfo=function(a,d){b=a,c=d,this.onResponseReceived()},this.getAffiliateId=function(){return b},this.getCampaignId=function(){return c}},PostAffInfo.prototype=new PostAffRequest,PostAffInfo.prototype.constructor=PostAffInfo,PostAffInfo.prototype.getTrackingParams=function(){return new PostAffParams("get_affinfo.php")},PostAffInfo.prototype.fillTrackingParams=function(){var a=PostAffRequest.prototype.fillTrackingParams.call(this);return a},PostAffInfo.prototype.callTrackScript=function(){visitorId=this.cookieManager.getVisitorId(),void 0!=visitorId&&""!=visitorId&&PostAffRequest.prototype.callTrackScript.call(this)},PostAffTrackingRequest=function(a,b,c,d){this.cookieManager=a,this.actions=b,this.accountId=c,this.skipIframeCheck=d},PostAffTrackingRequest.prototype=new PostAffRequest,PostAffTrackingRequest.prototype.constructor=PostAffTrackingRequest,PostAffTrackingRequest.prototype.loadHttpCookies=function(){this.cookieManager.loadHttpCookies(),this.cookieManager.deleteOldCookies()},PostAffTrackingRequest.prototype.getTrackingParams=function(){return new PostAffParams(PostAffTrackingRequest.getTrackFileName())},PostAffTrackingRequest.getTrackFileName=function(){return PostAffTracker.isScriptNameHashed()?PostAffTrackingRequest.correctHashName(PostAffTracker.getScriptName(),"r"):"track.php"},PostAffTrackingRequest.correctHashName=function(a,b){return a.replace("j",b).replace("p",b)},PostAffTrackingRequest.prototype.fillTrackingParams=function(){var a=PostAffRequest.prototype.fillTrackingParams.call(this),b=this.cookieManager.getVisitorId();null!=b&&"null"!=b&&a.addParam("tracking",this.cookieManager.getVisitorCookie().trackingMethod);var c="/"==window.location.pathname.charAt(0)?window.location.pathname:"/"+window.location.pathname;if(a.addParam("url",PostAffParams.replaceHttpInText(window.location.protocol+"//"+window.location.host+c)),a.addParam("referrer",PostAffParams.replaceHttpInText(PostAffParams.getReferrer())),a.addParam("getParams",PostAffTrackingRequest.getGetParams().toString()),a.addParam("anchor",PostAffTrackingRequest.getAnchorParams()),a.addParam("isInIframe",!this.skipIframeCheck&&window.location!=window.parent.location),void 0!=this.accountId&&a.addParam("accountId",this.accountId),"object"==typeof this.actions&&this.actions.length>0){for(var d="",e=0;e<this.actions.length;e++)d+=this.actions[e].toString()+",";a.addParam("sale","["+d.substring(0,d.length-1)+"]")}return a.addParam("cookies",this.cookieManager.getOldCookiesSerialized()),a},PostAffTrackingRequest.getGetParams=function(){var a=PostAffParams.parse(document.location.search);return"string"==typeof AffiliateID&&a.addParam("AffiliateID",AffiliateID),"string"==typeof BannerID&&a.addParam("BannerID",BannerID),"string"==typeof CampaignID&&a.addParam("CampaignID",CampaignID),"string"==typeof Channel&&a.addParam("Channel",Channel),"string"==typeof Data1&&a.addParam("pd1",Data1),"string"==typeof Data2&&a.addParam("pd2",Data2),a},PostAffTrackingRequest.getAnchorParams=function(){return document.location.href.split("#")[1]?document.location.href.split("#")[1].split("refx2s6d=")[0]:""},void 0==PostAffTracker)var PostAffTracker=new function(){function o(){b=d="https://affiliation.groupe-ldlc.com/scripts/"}function p(a,b,c,d,e){var f=new PostAffAttributeWriter(b,c,d,e);f.writeAttribute(a)}var b,c,d,e,f,a="pap_x2s6df8d",g=!1;this._cmanager=new PostAffCookieManager;var i,k,h=new PostAffInfo(this._cmanager),j=new Array;this.executeOnResponce=new Array,this.executeOnResponceFinished=new Array;var l=new Array;this.pendingCallbacksFlashCookies=new Array,this.flashCookiesReceivedExecuting=!1;var m=!1,n=!1;this.afterSetAffResponseCounter=0,o(),this.getIntegrationElementId=function(){return a},this.setSkipIframeCheck=function(a){m=a},this.getRequestUrl=function(){return d},this.isCustomFlashUrl=function(){return null!=c&&""!=c},this.getFlashUrl=function(){return this.isCustomFlashUrl()?".swf"==c.substr(c.length-4)?c.substr(0,c.lastIndexOf("/")+1):c:b},this.getFullFlashUrl=function(){return c},this.getScriptName=function(){return e},this.getScriptDomain=function(){return f},this.isScriptNameHashed=function(){return g},this.setRequestUrl=function(a){d=a},this.setAccountId=function(a){k=a},this.setCookieDomain=function(a){this._cmanager.setCookieDomain(a)},this.setFlashUrl=function(a){c=a},this.disableTrackingMethod=function(a){"F"==a&&this._cmanager.setDoNotUseFlashCookie(!0)},this.track=function(){var a=new PostAffTrackingRequest(this._cmanager,j,k,m);n=!0,a.send(),j=new Array},this.register=function(){return this.track()},this.createAction=function(a){var b=new PostAffAction(a);return j[j.length]=b,b},this.createSale=function(){return this.createAction()},this.notifySale=function(){return this.writeVisitorIdToAttribute("pap_dx8vc2s5","value")},this.writeVisitorIdToAttribute=function(a,b,c,d,e){this._cmanager.loadHttpCookies(),this._cmanager.loadRestoreHtmlStorageCookies();var f=new PostAffAttributeWriter(a,b,c,this._getSeparator(d),e);if(f.writeAttribute(this._getAccountId()+this._cmanager.getVisitorIdOrSaleCookieValue()),!this._cmanager.isFlashActive())return void(null!=this._cmanager.getVisitorIdOrSaleCookieValue()&&"null"!=this._cmanager.getVisitorIdOrSaleCookieValue()||this.executeOnResponceFinished.push(function(){f.writeAttribute(PostAffTracker._getAccountId()+PostAffTracker._cmanager.getVisitorIdOrSaleCookieValue())}));var g=this;PostAffTracker.pendingCallbacksFlashCookies.push(function(){f.writeAttribute(g._getAccountId()+g._cmanager.getVisitorIdOrSaleCookieValue())}),this._cmanager.readAllFlashCookies(),this.executeOnResponce.push(function(){f.writeAttribute(g._getAccountId()+g._cmanager.getVisitorIdOrSaleCookieValue())})},this.writeCookieToCustomField=function(a,b,c){void 0==c&&(c=null),this.writeVisitorIdToAttribute(a,"value",c,b)},this.writeCookieToLink=function(a,b,c){this.writeVisitorIdToAttribute(a,"href",b,c)},this.setVisitorId=function(a){this._cmanager.setVisitorId(a),this.afterSetVisitorId()},this.afterSetVisitorId=function(){for(var a=0;a<this.executeOnResponce.length;a++)this.executeOnResponce[a]()},this.onTrackingFinished=function(){n=!1;for(var a=0;a<this.executeOnResponceFinished.length;a++)this.executeOnResponceFinished[a]()},this.onFlashCookiesReceived=function(){if(!this.flashCookiesReceivedExecuting){this.flashCookiesReceivedExecuting=!0;for(var a=0;a<this.pendingCallbacksFlashCookies.length;a++)this.pendingCallbacksFlashCookies[a]();this.pendingCallbacksFlashCookies=new Array,this.flashCookiesReceivedExecuting=!1}},this.writeAffiliateToCustomFieldNow=function(a){h.setAccountId(this._getAccountId()),h.call(function(){p(h.getAffiliateId(),a,"value",null,i)})},this.writeAffiliateToCustomField=function(a){return n?void this.executeOnResponceFinished.push(function(){PostAffTracker.writeAffiliateToCustomFieldNow(a)}):void PostAffTracker.writeAffiliateToCustomFieldNow(a)},this.writeCampaignToCustomFieldNow=function(a){h.setAccountId(this._getAccountId()),h.call(function(){p(h.getCampaignId(),a,"value",null,i)})},this.writeCampaignToCustomField=function(a){return n?void this.executeOnResponceFinished.push(function(){PostAffTracker.writeCampaignToCustomFieldNow(a)}):void PostAffTracker.writeCampaignToCustomFieldNow(a)},this.writeAffiliateToLinkNow=function(a,b,c){var d=this._getSeparator(c);h.setAccountId(this._getAccountId()),h.call(function(){p(h.getAffiliateId(),a,"href",b,d)})},this.writeAffiliateToLink=function(a,b,c){return n?void this.executeOnResponceFinished.push(function(){PostAffTracker.writeAffiliateToLinkNow(a,b,c)}):void PostAffTracker.writeAffiliateToLinkNow(a,b,c)},this._setAffiliateInfo=function(a,b){h.setAffiliateInfo(a,b),this.afterSetAffiliate()},this.afterSetAffiliate=function(){for(var a=0;a<this.afterSetAffResponseCounter;a++)try{l["PostAff_"+a]()}catch(a){console.log("Error during running user function after setAffInfo callback: "+a)}},this.addAfterSetAffiliateFunction=function(a){a instanceof Function&&(l["PostAff_"+this.afterSetAffResponseCounter]=a,this.afterSetAffResponseCounter++)},this._getSeparator=function(a){return null==a||void 0==a||""==a?i:a},this._getAccountId=function(){return void 0!=k&&null!=k?k:""},this._processFlashCookies=function(a){this._cmanager.parseFlashCookies(a),this.onFlashCookiesReceived()},this.setAppendValuesToField=function(a){return i=a}};