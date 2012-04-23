/**
 * TO LOOK
 * http://blackberry.github.com/Alice/demos/index.html
 */

;(function($, w) {
    
     var lng = 4.817676544189453;
    var lat = 45.73841707992849;
    
    var style = [
  {
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "water",
    stylers: [
      { saturation: 39 },
      { hue: "#00ccff" },
      { lightness: -12 }
    ]
  },{
    featureType: "road",
    stylers: [
      { hue: "#ff0008" },
      { saturation: -100 },
      { lightness: -7 }
    ]
  },{
    featureType: "road.local",
    stylers: [
      { visibility: "simplified" },
      { lightness: -8 },
      { saturation: -85 }
    ]
  },{
    featureType: "landscape",
    stylers: [
      { visibility: "simplified" },
      { saturation: -100 },
      { lightness: 49 }
    ]
  },{
    featureType: "poi",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "transit",
    stylers: [
      { visibility: "off" }
    ]
  }
];
    
    var $map = $('#map'),
    gmap = new Gmap($('#map'), {
        center : [lat, lng],
        zoom : 14
    }, style),
    doit = null;

    var i = 1, a = 1;
    
    
   
 
    var marker = gmap.createMarker({id : i+'_'+a, position : [lat, lng]});
    i++;
    var marker1 = gmap.createMarker({id : i+'_'+a, position : [lat, lng+0.01]});
    i++;
    var marker2 = gmap.createMarker({id : i+'_'+a, position : [lat+0.01, lng]});
    i++;
    var marker2 = gmap.createMarker({id : i+'_'+a, position : [lat+0.01, lng+0.02]});
    i++;
    var marker2 = gmap.createMarker({id : i+'_'+a, position : [lat+0.06, lng]});
    i++;
    var marker2 = gmap.createMarker({id : i+'_'+a, position : [lat+0.1, lng+0.2]});
            
   /*         
    
    setInterval(function() {
        //MovieClipRenderer.render();
        if(marker.mc) {
            marker.mc.render();
            marker.position = new google.maps.LatLng(marker.position.lat(), marker.position.lng()+0.002);
            marker.draw();
            gmap.setCenter(marker.position);
        }
    }, 1000/31);
    */
    
    
    function _r() {
        $map.css({width : $(w).width(), height : $(w).height()});
        gmap.resize();
    }
    
    var _history = [location.href];
    listenChange(_history);
    function listenChange(history) {
        if(history[history.length-1] != location.href) {
            history.push(location.href);
            var param = location.href.split('#!/');
            if(param.length > 1) {
                alert(param[1]);
            }   
        }
        setTimeout(function() {listenChange(history);}, 20);
    }
    
    //listeners
    w.onresize = function() {//end resize
        if(doit) {clearTimeout(doit);doit = null;}
        doit = setTimeout(_r, 400);
    };
    _r();
    
    
    
    //function called from the objective C
    w.dezoom = function() {
        if(!gmap) return;
        gmap.setZoom(gmap.map.getZoom() -1, gmap);
    }
    
    w.zoom = function() {
        if(!gmap) return;
        gmap.setZoom(gmap.map.getZoom() +1, gmap);
    }
    
   w.filtre = function(filtre) {
       alert(filtre);
   }
   
   
})($, window);