/**
 * fevrier 2012
 * class pour gerer les googlemaps (V2)
 *
 * @changelog
 *  - reecriture + propre (POO)
 *  - methodes/parametres privï¿½s et publics
 *  - l'instanciation "plugin like" return directement l'object, plus besoin de fait $(elmt).data('gmap');
 *  - nouveau parametre : call back : function appelï¿½ quand la map (les tuiles) est chargï¿½e
 *  - optimisation, surtout clustering, boucles + rapides
 *  - suppression du map picker qui ne marchait plus, il est dispo seulement en BO
 *  - ajout mï¿½thodes KML
 *  - nomenclature : l'objet noeGooglemap._map devient noeGooglemap.map (objet _gm.Map)
 *
 *  @todo
 *   - changer le tableau de markeurs, pour ne plus avoir ï¿½ faire de for in
 *   - rï¿½ecrire le map picker, dans un objet ï¿½ part
 *   - setter & getter for privates var
 *
 *  /!\ version BETA
 *
 */
;(function($, _gm){

window.Gmap = function(elmt, options, style, callBack) {
     "use strict";
     /**
      * privates properties
      * U can't acces then!
      */
     var _style = null,
     _elmt = null,
     _divId = null,
     _name = 'noe',
     _myOptions = {
            zoom: 14,
            center: '',
            mapTypeId: _gm.MapTypeId.ROADMAP
     },
     _debugData = {rectangleCluster : []}; //usefull for stored diferent data, debug for clustering for example //

     /**
      * publics properties
      * modify at your own risk
      */
     this.map = null;
     this.geocoder = null;
     this.directionsService = null;
     this.directionsDisplay = null;
     this.tabMarkers = []; //tableau contenant tout les markers
     this.lastWindow = null;
     this.tabwindows = [];
     this.clustering = {clusters : [], collections : []};
     this.clusteringActive = false;
     this.kmls = [];


    /**
     * constructeur
     */
    _construct(elmt, options, style, callBack, this);

    /**
     * publics method
     */

    /*
     * permet le calcul d'itineraire sur la carte
     * divRecherche => id de la div ou mettre le rÃ©sultat
     * formRecherche => selecteur de btn de soumission
     * fromRecherche => selecteur de l'input ou on rentre son depart
     * toRecherche => selecteur de l'input ou on rentre son arrivee
     * btnEffacer => selecteur d'un bouton pour effacer la recherche
     * autoGeoloc : boolean
     * that
     * cb => callback appelÃ© Ã  chaque fois
     */
    this.calculItineraire = function(divRecherche, formRecherche, fromRecherche, toRecherche, btnEffacer, autoGeoloc, that, cb) {
        that = that || this;
        cb = cb || null;

        var from = '', to = '', directionsDisplay = new _gm.DirectionsRenderer();

        if(btnEffacer && jQuery(btnEffacer).length != 0) {
            jQuery(btnEffacer).click(function() {

                that.directionsDisplay.setMap(null);
               // var t = $(toRecherche).val().split(',');
           //    to = new _gm.LatLng(t[0], t[1]);
                that.map.setCenter(_myOptions.center);
                that.map.setZoom(_myOptions.zoom);
                jQuery("#"+divRecherche).html('');
                return false;
            });
        }

        if(autoGeoloc) {
            if (navigator.geolocation) { //si on est en HTML5, avec navigateur qui gï¿½olocalise
                navigator.geolocation.getCurrentPosition(function (position){
                             if (position != null) {
                                  var latitude = position.coords.latitude,
                                  longitude = position.coords.longitude;
                                  if (latitude && longitude){
                                      jQuery(fromRecherche).val(latitude+' '+longitude);
                                  }
                             }
                       });
            }
        }

        /*
         * trace l'itinï¿½raire ï¿½ la soumission du form
         */
        jQuery(formRecherche).submit(function() {
            that.triggerCalculItineraire(divRecherche,$(fromRecherche).val(),$(toRecherche).val(), that, cb);
            return false;
         });
    }

    /*
     * Le mecanisme de calcul de l'itineraire
     */
    this.triggerCalculItineraire = function(divRecherche, from, to, that, cb){
    	that = that || this;
    	var  directionDisplayContainer=null;

    	//Instanciation
    	directionDisplayContainer = document.getElementById(divRecherche);
        $(directionDisplayContainer).html('');
    	that.directionsDisplay.setPanel(directionDisplayContainer);
        that.directionsDisplay.setMap(that.map);

        $(directionDisplayContainer).html('<img id="wpajaxloadingsmall" src="http://'+window.location.hostname+'/wp-content/noewp/plugins/analytics360/images/working-small.gif" alt="Chargement" />');

        var requeteItineraire = {
            origin: from,
            destination: to,
            region: 'fr',
            travelMode: _gm.DirectionsTravelMode.DRIVING
         };

        that.directionsService.route(requeteItineraire, function(response, status) {
            $('#wpajaxloadingsmall').remove();
            if (status == _gm.DirectionsStatus.OK) {
            	that.directionsDisplay.setDirections(response);
                if(cb) cb(true);
            } else {
                $(directionDisplayContainer).html('<span class="itineraireError">Itin&eacute;raire non trouv&eacute;. Merci de modifier votre recherche et de recommencer.</span>');
                if(cb) cb(false);
            }
        });
    }

    /*
     * si on est sur mobile,
     * affiche des boutons spÃ©ciaux
     * dï¿½sactive le double click
     */
    this.detectBrowser = function(that) {
        that = that || this;
        var useragent = navigator.userAgent, myOptions;
        if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1) {
          myOptions = {
            navigationControlOptions: {
              style: _gm.NavigationControlStyle.ANDROID
            },
            mapTypeControlOptions: {
              style: _gm.MapTypeControlStyle.DROPDOWN_MENU
            },
            disableDoubleClickZoom: true,
            scaleControl: false
          };
          that.map.setOptions(myOptions);
        }
    }

    /*
     * ajoute un kml
     * url : url du KML. Attention, l'URL doit etre sur un serveur en ligne : exemple http://www.noe-interactive.com/monkml.kml
     */
    this.addKML = function(url, that) {
        that = that || this;
        
        
        var kmlLayer = new _gm.KmlLayer(url);
        kmlLayer.setMap(that.map);
        _gm.event.addListener(kmlLayer, 'status_changed', function(kmlEvent) {
              if(kmlLayer.getStatus() != 'OK') { //si pb avec le KML
                  throw "Pb KML : "+kmlLayer.getStatus()+" : "+url;
              } else {
                  that.kmls.push(kmlLayer);
              }
        });
        
    }

    /*
     * supprime les kmls presents sur la map
     */
    this.removeKMLs = function(that) {
        that = that || this;
        var i = that.kmls.length;
        while(i--) {
            that.kmls[i].setMap(null);
        }
    }

    /*
     * create a marker
     * point : obj (see object defaultPoint)
     * that : current object noeGooglemap, default : this
     */
    this.createMarker  = function(point, that) {
        that = that || this;
    	var defaultPoint = {
			'id':0,
			'title':'',
			'content':'',
			'icon': '',
			'iconSize': [],
			'infoWindowType': 'defaut',
			'data':{},
			'draggable': false,
                                                            'position' : [],
			'collection':'all'
    	};

    	point = $.extend({},defaultPoint,point);

    	//position
        //if($.isArray(point.localisation)) {
            point.position = new _gm.LatLng(point.position[0], point.position[1]);
        //}

            //Creation du marker
            var marker = new UrbanMarker({map: that.map}, point);
            
            
            /*_gm.event.addListener(marker, 'click', function() {
                alert(point.id);
            });*/
            
            return marker;
        

        //Enregistrement dans le tableau des markers
        /*
        that.tabMarkers[point.collection] = that.tabMarkers[point.collection] || [];
        that.tabMarkers[point.collection].push(marker); //on stock tous les markers dans ce tableau (par collection)*/

    }

    /**
     * ouvre une fenetre custom,
     *
     * voir =>
     * http://code.google.com/intl/fr/apis/maps/documentation/javascript/overlays.html#AddingOverlays
     * http://blog.mridey.com/2009/09/label-overlay-example-for-google-maps.html
     * http://lookmywebpage.com/api/google/google-map-custom-overlay-using-javascript-api-v3/
     */
    this.openOverlay  = function(that, content) {
        that = that || this;
        if(that.lastWindow) that.lastWindow.hide();
        if(that.tabwindows[content.id]) {
             that.tabwindows[content.id].toggle();
         } else {
             var popin = null;
             eval('popin = new '+content.className+'({map: that.map }, content);');
             popin.bindTo('position', content.marker, 'position');
             that.tabwindows[content.id] = popin;
         }
         that.lastWindow = that.tabwindows[content.id];
    }

    /**
     * affiche/cache une collection de point
     * id : id de la collection
     * bool : boolean, affiche ou cache
     */
    this.manageCollection = function(id, bool, that) {
        that = that || this;
        if(!that.tabMarkers[id]) return;
        var i = that.tabMarkers[id].length, win;
        while(i--) {that.tabMarkers[id][i].setMap(bool ? that.map : null);}
        for(win in that.tabwindows) {that.tabwindows[win].hide();}
    }

    /*
     * adapte le zoom aux points prï¿½sents sur la map
     * si un seul point, zoom par defaut, avec ce point en centre
     * zoomMaxi : zoom maximun autorisï¿½, par dï¿½faut : le zoom maxi dispo pour la map
     * zoomMini : zoom minimum autorisï¿½, par dï¿½faut : le zoom mini dispo pour la map
     */
    this.fitZoom = function(zoomMaxi, zoomMini, that) {
        that = that || this;

      //if(this.tabMarkers.length == 0) return;
       zoomMaxi = zoomMaxi || that.map.maxZoom;
       zoomMini = zoomMini || that.map.minZoom;

       var bounds = new _gm.LatLngBounds(), i = 0, collec = null;

       for(collec in that.tabMarkers) {
           i = that.tabMarkers[collec].length;
           while(i--) {
               bounds.extend(that.tabMarkers[collec][i].position);
           }
       }

       /* Ici, on ajuste le zoom de la map en fonction des limites  */
       that.map.fitBounds(bounds);
       //marche pas encore =>
       //that.map.setZoom(Math.max(zoomMini, Math.min(zoomMaxi, that.map.zoom)));


    }

    this.setCenter = function(position, that){
        that = that || this;
        //position
        if($.isArray(position)) {
            position = new _gm.LatLng(position[0], position[1]);
        }
    	that.map.setCenter(position);
    }

    this.setZoom = function(zoom, that){
        that = that || this;
        that.map.setZoom(zoom);
    }

    this.resize = function(that){
        that = that || this;
        _gm.event.trigger(that.map, 'resize');
    }

    this.activeClustering = function(collection, opt, that) {
        that = that || this;
        collection = collection || '*';
        that.clustering.collections = that.clustering.collections || [];

        var optDefault = {
            debug : false,
            maxZoom : 15,
            gridSize : 10,
            className : 'Clust',
            clusterIcon : ''
        }, col, e;

        opt = $.extend({},optDefault, opt);

        if(collection == '*') {
            for(col in that.tabMarkers) {
                that.clustering.collections.push({'collection' : col, opt : opt});
            }
        } else {
            that.clustering.collections.push({'collection' : collection, opt : opt});
        }


        if(that.clusteringActive === false) { // si on a pas encore activï¿½ le clustering, on met l'ï¿½vï¿½nement
            _gm.event.addListener(that.map, 'zoom_changed', function(){
                var e, col;
                //on vide les donnÃ©es du prÃ©cÃ©dent Ã©tat de zoom
                if(_debugData.rectangleCluster) {
                    e = _debugData.rectangleCluster.length;
                    while(e--) {
                        _debugData.rectangleCluster[e].setMap(null);
                    }
                }

                if(that.clustering.clusters) {
                    e = that.clustering.clusters.length;
                    while(e--) {
                        that.clustering.clusters[e].setMap(null);
                    }
                }
                //on set default
                _debugData.rectangleCluster = [];
                that.clustering.clusters = [];

                //on clusterise pour chaque collection dÃ©mandÃ©e si on est en dessous du zoom max.
                //if(thisZoom<opt.maxZoom){
                e = that.clustering.collections.length;
                while(e--) {
                    _clustered(that.clustering.collections[e].collection, that.clustering.collections[e].opt, that);
                }
                //}
            });
        }
        if(collection == '*') {
            for(col in that.tabMarkers) {
                _clustered(col, opt, that);
            }
        } else {
            _clustered(collection, opt, that);
        }

    }

    /*
     * enleve tout les Overlay
     * - marker (si bien contenu dans this.tabMarker)
     * - KML
     * - debug
     * - popin
     */
    this.clearOverlay = function(that) {
        that = that || this;
        var tabMarker = that.tabMarkers,
        tabWindow = that.tabwindows,
        i = that.tabwindows.length,
        cat = null;

        while(i--) {
            (tabWindow[i] && tabWindow[i] !== 'undefined') ? tabWindow[i].setMap(null) : '';
        }
        that.tabwindows = [];
        that.lastWindow = null;

        for(cat in tabMarker) {
            i = tabMarker[cat].length;
            while(i--) {
                tabMarker[cat][i].setMap(null);
            }
        }
        that.tabMarkers = [];
        //on vide les donnÃ©es du clustering si il y a
        if(_debugData.rectangleCluster) {
            i = _debugData.rectangleCluster.length;
            while(i--) {
                _debugData.rectangleCluster[i].setMap(null);
            }
        }

        if(that.clustering.clusters) {
            i = that.clustering.clusters.length;
            while(i--) {
                that.clustering.clusters[i].setMap(null);
            }
        }
        //on reset
        _debugData.rectangleCluster = [];
        that.clustering.clusters = [];
        that.removeKMLs(that);
    }

    
    /**
     * privates methods
     */

    /**
     * contructor
     */
    function _construct(elmt, options, style, callback, that) {
        that = that || this;
        options = options || {};
        var loaded = false;
        options.center = new _gm.LatLng(options.center[0], options.center[1]);

        _myOptions = $.extend({},_myOptions,options);
        that.geocoder = new _gm.Geocoder();

        _elmt = $(elmt);
        _divId = _elmt.attr('id');

        _style = style || null;

        if(_style) {
            var noeStyle = new _gm.StyledMapType(_style, {name: _name});
            _myOptions.mapTypeControlOptions = {mapTypeIds: [_gm.MapTypeId.SATELLITE, _name]}
        }

        that.map = new _gm.Map(_elmt[0], _myOptions);
        if(_style) {
          that.map.mapTypes.set(_name, noeStyle);
          that.map.setMapTypeId(_name);
        }
        if(callback) _gm.event.addListener(that.map, 'tilesloaded', function() {if(!loaded){callback();}loaded = true;});
        that.directionsDisplay = new _gm.DirectionsRenderer();
        that.directionsService = new _gm.DirectionsService();
    }

    /**
     * calcul du clustering
     */
    function _clustered(col, opt, that) {
        that = that || this;
        col = col || '*';

        var mapBounds = that.map.getBounds(), points = [], d = 0, cat = null;

        if(col == '*') {// si on clusterise tous les points ensembles
            for(cat in that.tabMarkers) {
                d = that.tabMarkers[cat].length;
                while(d--) {
                    points.push(this.tabMarkers[cat][d]);
                }
            }
        } else { //si on gere par collection
            points = that.tabMarkers[col];
        }
        if(!points || !points.length) return;

        if(!mapBounds || mapBounds == 'undefined') return;

        var sw = mapBounds.getSouthWest(), // coordonnÃ©es SW de la map
        ne = mapBounds.getNorthEast(), // coordonnÃ©es NE de la map
        size = mapBounds.toSpan(), // Size est une aire reprÃ©sentant les dimensions du rectangle de la map en degrÃ©s
        gridSize = opt.gridSize, // crÃ©Ã© une cellule de 10x10 pour constituer notre "grille"
        gridCellSizeLat = size.lat()/gridSize,
        gridCellSizeLng = size.lng()/gridSize,
        cellGrid = [], //tableau avec l'ensemble des points
        maxByClust = 0,
        clusterIcon = opt.clusterIcon, // le nb de point max qu'il y a dans un cluster
        thisZoom = that.map.getZoom(),
        k = points.length,
        latlng, testBounds, testSize, i, j, cell, lat_cellSW, lng_cellSW, cellSW, lat_cellNE, lng_cellNE, cellNE,
        bounds = null, c = null, marker, param = null, clus;
        //if(opt.debug) {console.log(thisZoom+'/'+opt.maxZoom); }

        //Parcours l'ensemble des points et les assigne ï¿½ la cellule concernï¿½e
        while(k--) {
             latlng = new _gm.LatLng(points[k].position.lat(),points[k].position.lng());
             testBounds = new _gm.LatLngBounds(sw,latlng);
             testSize = testBounds.toSpan();
             i = Math.ceil(testSize.lat()/gridCellSizeLat);
             j = Math.ceil(testSize.lng()/gridCellSizeLng);
             cell = [i,j];

             if(thisZoom > opt.maxZoom) {
            	 points[k].setMap(that.map);
            	 continue
             } else {
            	 points[k].setMap(null);
             }

             // Si cette case (cellule) n'a pas encore ï¿½tï¿½ crï¿½ï¿½e (undefined)
             // on l'ajoute ï¿½ notre grille ( = tableau de cellules = ï¿½chiquier)
             if(typeof cellGrid[cell] == 'undefined') {
                   lat_cellSW = sw.lat()+((i-1)*gridCellSizeLat);
                   lng_cellSW =  sw.lng()+((j-1)*gridCellSizeLng);
                   cellSW = new _gm.LatLng(lat_cellSW, lng_cellSW);
                   lat_cellNE = cellSW.lat()+gridCellSizeLat;
                   lng_cellNE =  cellSW.lng()+gridCellSizeLng;
                   cellNE = new _gm.LatLng(lat_cellNE, lng_cellNE);

                   // DÃ©claration de la cellule et de ses propriÃ©tÃ©s (cluster ou non, points ...)
                   cellGrid[cell] = {
                     GLatLngBounds : new _gm.LatLngBounds(cellSW,cellNE),
                       cluster : false,
                       markers:[],
                       length: 0
                   };

                   /*
                   // Ajoute la cellule (rectangle bleu) Ã  la carte
                   // utile en phase de test
                   if(opt.debug) {
                       var t = new _gm.Rectangle({
                            map: that.map,
                            bounds : cellGrid[cell].GLatLngBounds,
                            fillOpacity: 0,
                            strokeColor: '#0000FF',
                            strokeOpacity: 0.5,
                            strokeWeight: 2
                        });
                        _debugData.rectangleCluster.push(t);
                   }*/
                }

                 // augmentation du nombre de cellules sur la grille ( = 1 cellule en plus)
                 cellGrid[cell].length++;

                 // Si la cellule a au moins 2 marker, clusterisation
                 cellGrid[cell].cluster = cellGrid[cell].markers.length > 1 ? true : false;
                 cellGrid[cell].markers.push(points[k]);
                 maxByClust = Math.max(cellGrid[cell].markers.length, maxByClust);
           }

           for (k in cellGrid) {
                //Si les markers de la cellule doivent apparaitre sous forme de cluster
                if(cellGrid[k].cluster == true) {
                    bounds = new _gm.LatLngBounds();
                    i = cellGrid[k].markers.length;
                    while(i--) {
                        bounds.extend(cellGrid[k].markers[i].position);
                    }
                    if(clusterIcon.length==0){clusterIcon = cellGrid[k].markers[0].getIcon();}
                    c = bounds.getCenter();
                    marker = new _gm.Marker({draggable: false,position : c});
                    param = {
                       max : maxByClust, //nb maxi de point qu'il y a dans un cluster
                       marker : marker, //un marker fake au centre de la zone
                       nb : cellGrid[k].markers.length, // nb de points dans le cluster
                       bounds : cellGrid[k].GLatLngBounds, // le bounds de la zone
                       icon : clusterIcon //L'icone du cluster
                    };
                    if(col != '*') param.collection = col;
                    /**
                     * refaire les 3 lignes suivantes, sans le bindTo
                     * voir sur videoturismo
                    */
                    eval('clus = new '+opt.className+'({map: that.map}, param)');
                    clus.bindTo('position', param.marker, 'position');
                    that.clustering.clusters.push(clus);
                } else {
                   // Sinon, on affiche le marker
                   i = cellGrid[k].markers.length;
                    while(i--) {
                      cellGrid[k].markers[i].setMap(that.map);
                    }
                }
        }
    }


}

})(window.jQuery || $, google.maps);