/**
 * javascript error catching
 * @author badger
 * @website http://jeremypetrequin.fr
 */
;(function(w) {
    w.ErrorCatching = function(url) {
       var that = this,
       domain = location.host;

       w.onerror = function(message, url, lineNumber) {  
          console.log("you've got an error \""+message+"\" on line "+lineNumber+" in file "+url);
          that.send(message, lineNumber, url);
          return true;
        }
        
        this.send = function(message, lineNumber, urlFile, cb) {
               lineNumber = lineNumber || 0;
               urlFile = urlFile || '';
               var xdr = null;
                if (w.XDomainRequest) {
                     xdr = new XDomainRequest(); 
                } else if (w.XMLHttpRequest) {
                     xdr = new XMLHttpRequest(); 
                } else {
                    return false;
                }
                
                var browser = navigator.appVersion;
                
                var rwebkit = /(webkit)[ \/]([\w.]+)/;
                var ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/;
				var rmsie = /(msie) ([\w.]+)/;
				var rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/;
				
				console.log(browser.match(rwebkit));// ? var nav = "Webkit" : 0 ;
				console.log(browser.match(ropera));// ? var nav = "Opera" : 0 ;
				console.log(browser.match(rmsie)); //? var nav = "MSIE" : 0 ;
				console.log(browser.match(rmozilla)); //? var nav = "Mozilla" : 0 ;
                
                xdr.onload = cb || function() {}
                //xdr.open("GET", url+'?domain='+domain+'&msg='+message+'&line='+lineNumber+'&file='+urlFile+'&title='+document.title+'&nav='+nav);
              //  xdr.send();           
                return true;
        }
    }
})(window);

/* regex pour navigateur
rwebkit = /(webkit)[ \/]([\w.]+)/,
 ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/,
 rmsie = /(msie) ([\w.]+)/,
 rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/,
 */
