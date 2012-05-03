;(function($, window) {
    
    var $map = $('#gmap'), 
    $w = $(window),
    googlemap = null,
    pages = Array();

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
        center : [6.1, 40.2],
        zoom : 6
    });
    
    
   //console.log(window.CONF);
    $.ajax({
        url: "http://localhost:8888/urbantraps/?page_id=414",
      dataType: 'JSON',
      success: function(data) {
        //console.log(data);
                //alert(data[0].id+''+data[0].title+' '+data[0].content+' '+data[0].perso_fields["latitude"]+' '+data[0].perso_fields["longitude"]);
                pages = data;
                
         },
      error : function(msg) {
          console.log("ERROR : "+msg.statusText);
      }
  });
  
  
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

$(window).bind('urlchange', function() {
var param = location.href.split('#!/'); //on recupere le hash
        if(param.length > 1) {
       
            var t = param[1].split('/'),
            i = pages.length; //on le découpe
//on fait des trucs avec!

            while(i--){
                if(pages[i].id == t[1]){
                    console.log(pages[i].lat, pages[i].lng)
                    googlemap.map.panTo(new google.maps.LatLng(pages[i].perso_fields["latitude"], pages[i].perso_fields["longitude"]), 2000, function() {
                
                    });
                }
            }
            
            
            
    }
});


   
})(jQuery, window);













(function(gm) {
    if(!gm) throw ("googlemap missing");
    
    Math.linearEquation =  function(x1, x2, y1, y2) {
        var coeff = (y2 -y1) / (x2 - x1), 
        a = y1 - coeff * x1;
        return function(t) {
           return coeff * t + a;
        };
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
                    that.setCenter(new gm.LatLng(eq.lat(i), eq.lng(i)));
                    if(i >= time) {
                        clearInterval(interval);
                        interval = null;
                        callBack();
                    }
                }, 1000/25);
        };
})(google.maps);





