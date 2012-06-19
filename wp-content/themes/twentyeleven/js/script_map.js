

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
    $b = $('body'),
    googlemap = null,
    pages = [],
    previousPage = null,
    $content = $('#content'),
    center = new google.maps.LatLng(45.90857343579082, 6.125575304031372),
    polyglote,
    panneaux = null,
    panneauDejaDisplay = false;
    
    $.ajax({
        url : "api/?p=panneau&task=getAllPanneau",
        dataType : 'json',
        success : function(data) {
            panneaux = data;
            $w.trigger('data-loaded');
        },
        error : function() {
            
        }
    });
    
    //UI
     function _r() {
        $map[0].style.width = $w.width()+'px';
        $map[0].style.height = $b.height() - 49+'px';
        googlemap && googlemap.resize();
    }
    
     function _wr() {
        $content.css('min-height', $w.height() - 310);
    }
    
    //listener
    $w.resize(function() {
        _wr();
        $w.trigger('size-change');
        
    })
    $w.bind('size-change', _r);
    
    _wr();
    _r();
    
    
    var style =[
  {
    featureType: "administrative.province",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "administrative.land_parcel",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "administrative.province",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "administrative.locality",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "water",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "road",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "poi",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  },{
    featureType: "poi",
    elementType: "geometry",
    stylers: [
      { saturation: -100 },
      { lightness: 94 }
    ]
  },{
    featureType: "landscape",
    stylers: [
      { saturation: -74 },
      { lightness: 94 }
    ]
  },{
    featureType: "water",
    stylers: [
      { saturation: 24 },
      { lightness: -9 },
      { hue: "#00f6ff" }
    ]
  },{
    featureType: "road.highway",
    stylers: [
      { saturation: -98 },
      { lightness: 68 }
    ]
  },{
    featureType: "road.arterial",
    stylers: [
      { saturation: -100 },
      { lightness: 65 }
    ]
  },{
    featureType: "administrative.country",
    elementType: "geometry",
    stylers: [
      { visibility: "on" },
      { saturation: -99 },
      { lightness: 37 }
    ]},{featureType: "landscape",elementType: "labels",stylers: [{ visibility: "off" }]},{elementType: "labels",stylers: [{ visibility: "off" }]},{featureType: "administrative.country",elementType: "labels",stylers: [{ visibility: "on" }]}];
    //init
    //$w.resize(_r); //listen resize for a full screen map
    
   // _r(); //launch resize first time
    googlemap = new Gmap($map, {
        center : [center.lat(), center.lng()],
        zoom : 16
    }, style);
    


    
    
    
    
   //console.log(window.CONF);
   //var first = true;

  
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


function displayMap() {
    if(panneauDejaDisplay) {
        googlemap.setZoom(6);
        googlemap.setCenter([48.3416461723746, 2.724609375]);
        return;
    }
    var i = panneaux.length;
    while(i--) {
        googlemap.createMarker({position : new google.maps.LatLng(panneaux[i][0], panneaux[i][1])});
    }
    
    googlemap.activeClustering('*', {maxZoom : 13});
    googlemap.setZoom(6);
    googlemap.setCenter([48.3416461723746, 2.724609375]);
    
    panneauDejaDisplay = true;
}
//ecouter l'event de changement :  

$(window).bind('urlchange', urlChange);
var $menu = $('#menu');
var pages = [],
menus = [],
geoloc = [];

function urlChange(){
    
    var param = location.href.split('#!/'),
    page = param[1] || 'home';
   
    
    pages[page] = pages[page] || $('#'+page+'-tpl').html();
    menus[page] = menus[page] || $('#'+page);
    if(page != 'invasion') {
        geoloc[page] = geoloc[page] || new google.maps.LatLng($('#'+page+'-tpl').attr('data-lat'), $('#'+page+'-tpl').attr('data-lng'));
        googlemap.map.panTo(geoloc[page], 400);
    } else {
        if(!panneaux) {
            $w.bind('data-loaded', function() {
                $w.unbind('data-loaded');
                displayMap();
            });
        } else {
            displayMap();
        }
    }
    
    $menu.find('li.active').removeClass('active');
    menus[page].addClass('active');
    
    $content.height($content.height()).fadeOut(450, function() {
        $content.html(pages[page]).fadeIn(450, function() {
            $content.height('');
            
            //setTimeout(function() {$w.trigger('size-change');}, 500);
            if(page == 'home') {
                $('#slider').cycle({ 
                    fx: 'scrollHorz',
                    pager : $('#pager')
                });
            } 
            if(page == 'invasion') {
                $content[0].className = 'wrapper invasion';
                $b.addClass('b-invasion');
                
            } else {
                if(googlemap.map.getZoom() < 15) {
                    googlemap.map.setZoom(15);
                }
                $content[0].className = 'wrapper';
                $b.removeClass('b-invasion');
            }
            $w.trigger('size-change');
        });
    });
}

urlChange();


$("#city_button").click(function() {
    googlemap.setZoom(15);
    googlemap.map.setCenter(center);
});

$("#france_button").click(function() {
    googlemap.setZoom(6);
    googlemap.setCenter([48.3416461723746, 2.724609375]);
});


})(jQuery, window);



