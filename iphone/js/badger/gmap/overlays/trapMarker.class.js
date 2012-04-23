;(function($, doc, _gm) {

    window.TrapMarker = function(opt_options, content) {
        // Initialization
        this.setValues(opt_options);
        this.listeners_ = []; 
        // popin specific
        
        this.marker = content.marker;
        this.id = 'trap_'+content.id;
        this.position = content.position;
        this.div_ = doc.createElement('div');
        
        this.div_.id = this.id;
        this.div_.style.cssText = 'position: absolute; display: none; background:url(img/chat.png) no-repeat 0 0; width:250px; height:100px;';
        this.div_.className = 'trap-layer';
        
        
        /*
        url : 'chat_1.png',
            width : 250,
            way : '*',
            framesTab : frames,
            framerate : 25,
            frames : 13,
            debug : true*/
    };

    TrapMarker.prototype = new _gm.OverlayView;

    // Implement onAdd
    TrapMarker.prototype.onAdd = function() {
         var pane = this.getPanes().floatPane, me = this;
         pane.appendChild(this.div_);
         // si on a des Ã©couteurs a mettre dans la popin

         this.mc = new ATrap(this.id, {
            url : 'img/chat.png',
            frames : 13,
            width : 250
        }).play();
        
         this.div_.style.visibility = "visible";
         this.div_.style.display = "block"
    };

    TrapMarker.prototype.hide = function() {
        if (this.div_) this.div_.style.visibility = "hidden";
    };

    TrapMarker.prototype.show = function() {
        if (this.div_)  this.div_.style.visibility = "visible";
    };

    TrapMarker.prototype.toggle = function() {
        if (this.div_) this.div_.style.visibility == "hidden" ? this.show() : this.hide();
    };

    // Implement onRemove
    TrapMarker.prototype.onRemove = function() {
         this.div_.parentNode.removeChild(this.div_);
         var i = this.listeners_.length;
         while(i--) {
           _gm.event.removeListener(this.listeners_[i]);
         }
    };

    // Implement draw
    TrapMarker.prototype.draw = function() {
         var projection = this.getProjection(),
         position = projection.fromLatLngToDivPixel(this.position);
         
         this.div_.style.left = position.x - 125+'px';
         this.div_.style.top = position.y - 50+'px';
         

    };

})($, document, google.maps);
