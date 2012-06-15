

(function(gm) {
    if(!gm) throw ("googlemap missing");
    
    Math.linearEquation =  function(x1, x2, y1, y2) {
        var coeff = (y2 -y1) / (x2 - x1), 
        a = y1 - coeff * x1;
        return function(t) {
           return coeff * t + a;
        };
    }

    Math.easeInCubic = function (t, b, c, d) {
            t /= d ;
            return c*t*t*t + b ;
    }
      

     /**
      * @params to : object google.maps.LatLng
      * @params time : time of the anim, default : 1000 (in millisecond)
      * @params callBack : function called at the end ot the animation
      */
     gm.Map.prototype.panTo = function(to, time, callBack) {
         
                if(!to) return;
                time = time || 1000;
                callBack = callBack || function() {};
                var that = this, 
                i = 0,
                from = that.getCenter(),
                eq = {lat : Math.linearEquation(0, time, from.lat(), to.lat()), lng : Math.linearEquation(0, time, from.lng(), to.lng())},
                interval = setInterval(function() {
                    i+=1000/25;
                    
                    that.setCenter(new gm.LatLng(
                        eq.lat(i), 
                        eq.lng(i)
                    ));
                    /*that.setCenter(new gm.LatLng(
                        Math.easeInCubic(i, from.lat(), to.lat(), time), 
                        Math.easeInCubic(i, from.lng(), to.lng(), time)
                    ));*/
                    if(i >= time) {
                        clearInterval(interval);
                        interval = null;
                        callBack();
                    }
                }, 1000/25);
        };
        
        
        
})(google.maps);



;(function($, window) {
   
    
    var $map = $('#gmap'), 
    $w = $(window),
    googlemap = null,
    pages = [],
    previousPage = null,
    polyglote;

    //resize the map's div to fullscreen, and dispatch the event resize on googlemap
     function _r() {
        $map[0].style.width = $w.width()+'px';
        $map[0].style.height = $w.height()+'px';
        googlemap && googlemap.resize();
    }

    
    //init
    $w.resize(_r); //listen resize for a full screen map
    _r(); //launch resize first time
    googlemap = new Gmap($map, {
        center : [43.60544274006872, 1.4487576484680176],
        zoom : 16
    });
    
    function CustomMarker(latlng,  map) {
    this.latlng_ = latlng;

    // Once the LatLng and text are set, add the overlay to the map.  This will
    // trigger a call to panes_changed which should in turn call draw.
    this.setMap(map);
  }

  CustomMarker.prototype = new google.maps.OverlayView();

  CustomMarker.prototype.draw = function() {
    var me = this;

    // Check if the div has been created.
    var div = this.div_;
    if (!div) {
      // Create a overlay text DIV
      div = this.div_ = document.createElement('DIV');
      // Create the DIV representing our CustomMarker
      div.style.border = "none";
      div.style.position = "absolute";
      div.style.paddingLeft = "0px";
      div.style.cursor = 'pointer';

      var img = document.createElement("img");
      img.src = "http://gmaps-samples.googlecode.com/svn/trunk/markers/circular/bluecirclemarker.png";
      div.appendChild(img);
      google.maps.event.addDomListener(div, "click", function(event) {
        google.maps.event.trigger(me, "click");
      });

      // Then add the overlay to the DOM
      var panes = this.getPanes();
      panes.overlayImage.appendChild(div);
    }

    // Position the overlay 
    var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (point) {
      div.style.left = point.x + 'px';
      div.style.top = point.y + 'px';
    }
  };
    
    
    
    
   //console.log(window.CONF);
   //var first = true;
    $.ajax({
        url: "http://localhost:8888/urbantraps/?page_id=414",
      dataType: 'JSON',
      success: function(d) {
        //console.log(data);
                //alert(data[0].id+''+data[0].title+' '+data[0].content+' '+data[0].perso_fields["latitude"]+' '+data[0].perso_fields["longitude"]);
                //console.log(data);
                pages = d;
                previousPage = pages[0];
               
         },
      error : function(msg) {
          console.log("ERROR : "+msg.statusText);
      }
  });
  

function drawWay(from, to, speedPan){
        
          //console.log(from);
          //console.log('SPEED PAN : '+speedPan);
            googlemap.calculItineraire(from.perso_fields.latitude+', '+from.perso_fields.longitude, to.perso_fields.latitude+', '+to.perso_fields.longitude, googlemap, function(data) {
                        //console.log(data);
                      
                      //if(first === true) {
                       var tab = data.routes[0].overview_path,
                       equation = [],
                       time = 0;
                       
                       //console.log(tab.length-1);
                       for(var j=0, L = tab.length-1; j<L; j++){ 
                           //console.log(j);
                           time = j; //test
                           equation[j] = {
                             lat : Math.linearEquation(
                                    time,
                                    time+1, //1 = remplacer par le temps de l'anim de ce bout
                                    tab[j].lat(),
                                    tab[j+1].lat()
                                ),
                             lng : Math.linearEquation(
                                    time, //meme
                                    time+1,//meme
                                    tab[j].lng(),
                                    tab[j+1].lng()
                                )
                           };
                           //time = time + temps de l'anim
                       //}
                       
                       var color = "#0025ED";
                       var opt = {
                            strokeColor: color,
                            strokeOpacity : 1,
                            strokeWeight : color == "#0025ED" ? 3 : 5, 
                            path : [],
                            map : googlemap.map
                        };
                        //if(polyglote) polyglote.setMap(null);
                        if(!polyglote) {
                            polyglote = new google.maps.Polyline(opt);
                        }
                       
                       
                        var t = 0, interval = 1000/25, tabLenght = tab.length; //speedPan/(tab.length-1);
                        
                        function animatePoly() {
                            var floorT = Math.floor(t), path = [];
                            
                            for(var i = 0; i <=floorT; i++) {
                               //console.log("setInterval2");
                               if(floorT <  tabLenght) {
                                    path.push(tab[i]);
                               }
                             }
                             
                             if(floorT < equation.length) {
                                path.push(new google.maps.LatLng(
                                    equation[floorT].lat(t),
                                    equation[floorT].lng(t)
                                ));
                             }
                                    
                             if(floorT <  tab.length) {
                                setTimeout(animatePoly, interval);
                             }
                             
                            /*for(var i = 0; i<=floorT; i++) {
                                ;
                            }*/
                            
                            
                            t+=(interval/1000);
                            if(path.length) polyglote.setPath(path);
                            
                            
                        }
                        
                        
                        animatePoly();
                        
                        /*var timer;
                        timer = setInterval(function() {
                            //console.log("setInterval");
                            var toto = Math.floor(t), path = [];
                            //console.log(toto);
                           for(var i = 0; i <=toto; i++) {
                               //console.log("setInterval2");
                               if(toto <  tab.length) {
                                //console.log(i);
                                    path.push(tab[i]);
                               }else{
                                    //console.log("ma bite");
                                    clearInterval(timer); 
                                    timer = null;
                               }
                           }
                           
                           t+= (interval/1000);*/
                           
                           //Problème avec la longueur du tableau ?
                          // path.push(
                                /*new google.maps.LatLng(
                                    equation[toto].lat(t),
                                    equation[toto].lng(t)
                                )*/
                          // );
                           
                           
                          // if(path.length) polyglote.setPath(path);
                           
                         //  console.log("TOTO = " +toto);
                       //    console.log("TAB LENGTH = " +tab.length);
                           
                           /*if(toto >=  tab.length) {
                               console.log("timer");
                               clearInterval(timer); 
                               timer = null;
                           }*/
                            //console.log('INTERVAL');
                      // }, interval);
                     var toto = Math.floor(t), path = [];
                       function timer() {
                                
                           for(var i = 0; i <=toto; i++) {
                               //console.log("setInterval2");
                               if(toto <  tab.length) {
                                //console.log(i);
                                    path.push(tab[i]);
                                    //setTimeout(timer, interval);
                               }else{
                                    
                               }
                           }
                           
                       }
                       
                        setTimeout(timer, interval);


                       //console.log(equation);
                       
                       
                       //var tab = data.routes[0].overview_path;
                      // console.log(data);
                      // drawItineraire(tab, "#000000");
                        
                     
                        
                       }
                       //first = false;
                    });
                
                
                /*googlemap.calculItineraire(pages[0].perso_fields.latitude+', '+pages[0].perso_fields.longitude, pages[pages.length-1].perso_fields.latitude+', '+pages[pages.length-1].perso_fields.longitude, googlemap, function(data) {
                    
                });*/
}    
  

  

function drawItineraire(tab, color) {
    color = color || "#000000";
    var opt = {
            strokeColor: color,
            strokeOpacity : 1,
            strokeWeight : color == "#000000" ? 10 : 5, 
            path : tab,
            map : googlemap.map
        }
     new google.maps.Polyline(opt);
     //polygame.setMap(null);
                        
                        
} 
  
  //interval qui écoute
var _history = [location.href];
listenChange(_history);
function listenChange(history) {
    if(history[history.length-1] != location.href) {
        history.push(location.href);
        $(window).trigger('urlchange');
    }
    setTimeout(function() {listenChange(history);}, 20);
}


//ecouter l'event de changement :  

$(window).bind('urlchange', urlChange);
var $menu = $('#menu');

function urlChange(){
    var param = location.href.split('#!/'), //on recupere le hash
    currentLat = googlemap.map.center.$a,
    currentLng = googlemap.map.center.ab,
    speedPan = 0;
    if(param.length > 1) {

        var t = param[1].split('/'),
        i = pages.length; //on le découpe
//on fait des trucs avec!

        while(i--){
            if(pages[i].id == t[1]){
                speedPan = Math.sqrt(((pages[i].perso_fields.latitude -currentLat)*(pages[i].perso_fields.latitude -currentLat))+((pages[i].perso_fields.longitude -currentLng)*(pages[i].perso_fields.longitude -currentLng)))*(1600000/googlemap.map.zoom);
                //console.log(speedPan);
                    googlemap.map.panTo(new google.maps.LatLng(pages[i].perso_fields.latitude, pages[i].perso_fields.longitude), speedPan, function() {

                    });
                    $menu[0].className = 'page-item-'+pages[i].id;
                
                drawWay(previousPage, pages[i], speedPan);
                previousPage = pages[i];
                break;
            }
        }
    }
    //console.log(pages[1], pages[2]); 
    //console.log(pages[0], pages[1]);
}

//location.href = '#!/page/401';
   
})(jQuery, window);