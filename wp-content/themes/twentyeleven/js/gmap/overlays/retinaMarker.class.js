;(function($, doc, _gm) {

    window.RetinaMarker = function(opt_options, content) {
        // Initialization
        this.setValues(opt_options);
        this.listeners_ = []; 
        // popin specific
        
        this.marker = content.marker;
        this.position = content.position;
        this.div_ = doc.createElement('div');
        this.option = content;
        this.div_.setAttribute('href', "#!/"+this.id);
        this.div_.style.cssText = 'position: absolute; display: none; width:'+content.size.width+'px; height:'+content.size.height+'px;';
        this.div_.className = 'marker-retina';
        this.div_.innerHTML = '<img width="100%" height="100%" src="'+content.img+'" alt="retina marker" />';
    };

    RetinaMarker.prototype = new _gm.OverlayView;

    // Implement onAdd
    RetinaMarker.prototype.onAdd = function() {
         var pane = this.getPanes().overlayMouseTarget, me = this;
         pane.appendChild(this.div_);

       /*  $(this.div_).on('click', function() {
             alert(me.id);
             return false;
         });*/
         this.div_.style.visibility = "visible";
         this.div_.style.display = "block"
    };

    RetinaMarker.prototype.hide = function() {
        if (this.div_) this.div_.style.visibility = "hidden";
    };

    RetinaMarker.prototype.show = function() {
        if (this.div_)  this.div_.style.visibility = "visible";
    };

    RetinaMarker.prototype.toggle = function() {
        if (this.div_) this.div_.style.visibility == "hidden" ? this.show() : this.hide();
    };

    // Implement onRemove
    RetinaMarker.prototype.onRemove = function() {
         this.div_.parentNode.removeChild(this.div_);
         var i = this.listeners_.length;
         while(i--) {
           _gm.event.removeListener(this.listeners_[i]);
         }
    };

    // Implement draw
    RetinaMarker.prototype.draw = function() {
         var position = this.getProjection().fromLatLngToDivPixel(this.position);
         
         this.div_.style.left = position.x - this.option.size.width /2+'px';
         this.div_.style.top = position.y - this.option.size.height /2+'px';
         

    };

})($, document, google.maps);
