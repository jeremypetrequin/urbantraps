/**
 * Abstract class for the trap
 */
;(function($, w) {
    
    var ATrap = w.ATrap = function(id, setup) {
            this.posInRenderList = false;
            this.id = id;
            
            
            this.e = document.getElementById(id);
            this.cpt = 0;
            var defaultSettings = {
                width : 0,
                url : '',
                frames : 0
            } ;
            
            this.settings = $.extend({}, defaultSettings, setup || {});
            return this;
    }
    
    ATrap.prototype.render = function() {
        this.cpt = (this.cpt >= this.settings.frames-1) ? 0 : this.cpt+1;
        this.e.style.backgroundPosition = '-'+this.cpt*this.settings.width+'px 0px';
    }
    
    ATrap.prototype.goToAndPlay = function(frame, loop) {
        MovieClipRenderer.addItem(this);
        return this;
    }
    
    ATrap.prototype.goToAndStop = function(frame) {
        MovieClipRenderer.removeItem(this);
        return this;
    }
    
    ATrap.prototype.play = function(that) {
        MovieClipRenderer.addItem(this);
        return this;
    }
    
    ATrap.prototype.stop = function(that) {
        MovieClipRenderer.removeItem(this);
        return this;
    }
    
})($, window);