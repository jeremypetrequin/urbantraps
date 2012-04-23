function Popin(opt_options, content) {
    // Initialization
    this.setValues(opt_options);
    this.listeners_ = []; 
    // popin specific
    this.marker = content.marker;
    this.id = content.id;
    var html = '<a href="#" id="close-'+this.id+'">X</a>'+content.content;
    this.div_ = document.createElement('div');
    this.div_.style.cssText = 'position: absolute; display: none; width:166px; height:auto; background:white';
    this.div_.innerHTML = html;
    this.div_.className = 'noe-map-layer';
};

Popin.prototype = new google.maps.OverlayView;

// Implement onAdd
Popin.prototype.onAdd = function() {
     var pane = this.getPanes().floatPane, me = this;
     pane.appendChild(this.div_);
     // si on a des Ã©couteurs a mettre dans la popin
     $('#close-'+this.id).click(function() {me.hide(); return false; }); // fermeture

     this.div_.style.visibility = "visible";
};

Popin.prototype.hide = function() {
  if (this.div_) this.div_.style.visibility = "hidden";
};

Popin.prototype.show = function() {
  if (this.div_)  this.div_.style.visibility = "visible";
};

Popin.prototype.toggle = function() {
  if (this.div_) this.div_.style.visibility == "hidden" ? this.show() : this.hide();
};

// Implement onRemove
Popin.prototype.onRemove = function() {
 this.div_.parentNode.removeChild(this.div_);
 var i = 0, I = this.listeners_.length;
 for (i = 0; i < I; ++i) {
   google.maps.event.removeListener(this.listeners_[i]);
 }
};

// Implement draw
Popin.prototype.draw = function() {
 var projection = this.getProjection(),
 position = projection.fromLatLngToDivPixel(this.get('position')),
 div = this.div_,
 x = position.x - (jQuery(div).outerWidth() / 2),
 y = position.y - jQuery(div).outerHeight() - 47;
 $(div).css({'left' : x, top : y, display : 'block'});

};
