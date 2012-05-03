;(function($, doc, _gm) {

    window.UrbanMarker = function(opt_options, content) {
        // Initialization
        this.setValues(opt_options);
        this.listeners_ = []; 
        // popin specific
        
        this.marker = content.marker;
        this.id = 'trap_'+content.id;
        this.position = content.position;
        this.div_ = doc.createElement('a');
        
        this.div_.id = this.id;
        this.div_.setAttribute('href', "#!/"+this.id);
        this.div_.style.cssText = 'position: absolute; display: none; width:32px; height:32px;';
        this.div_.className = 'marker-layer leader';
        this.div_.innerHTML = '<div><div class="content-marker">30I3</div></div>';
    };

    UrbanMarker.prototype = new _gm.OverlayView;

    // Implement onAdd
    UrbanMarker.prototype.onAdd = function() {
         var pane = this.getPanes().overlayMouseTarget, me = this;
         pane.appendChild(this.div_);

       /*  $(this.div_).on('click', function() {
             alert(me.id);
             return false;
         });*/
         this.div_.style.visibility = "visible";
         this.div_.style.display = "block"
    };

    UrbanMarker.prototype.hide = function() {
        if (this.div_) this.div_.style.visibility = "hidden";
    };

    UrbanMarker.prototype.show = function() {
        if (this.div_)  this.div_.style.visibility = "visible";
    };

    UrbanMarker.prototype.toggle = function() {
        if (this.div_) this.div_.style.visibility == "hidden" ? this.show() : this.hide();
    };

    // Implement onRemove
    UrbanMarker.prototype.onRemove = function() {
         this.div_.parentNode.removeChild(this.div_);
         var i = this.listeners_.length;
         while(i--) {
           _gm.event.removeListener(this.listeners_[i]);
         }
    };

    // Implement draw
    UrbanMarker.prototype.draw = function() {
         var position = this.getProjection().fromLatLngToDivPixel(this.position);
         
         this.div_.style.left = position.x - 16+'px';
         this.div_.style.top = position.y - 16+'px';
         

    };

})($, document, google.maps);
