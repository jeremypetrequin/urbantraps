
function Clust(opt_options, p) {
    // Initialization
    this.setValues(opt_options);
    this.params = p;
    
    // popin specific
    var html = '<div class="pulse"></div><span class="inner-cluster"><span class="clusterNumber">'+p.nb+'</span></span>'; 
    var div = this.div_ = document.createElement('div');
    div.style.cssText = 'position: absolute; display: none; width:100px; height:100px;';
    div.innerHTML = html;
    div.className = 'cluster-number';
    div.className = p.collection ? div.className+' cluster-collection-'+p.collection : div.className;
};
Clust.prototype = new google.maps.OverlayView;

// Implement onAdd
Clust.prototype.onAdd = function() {
     var pane = this.getPanes().floatPane;
     pane.appendChild(this.div_);
     var me = this;
     this.div_.style.visibility = "visible";
     $(this.div_).click(function() {
        me.map.setCenter(me.get('position'));
        me.map.setZoom(me.map.getZoom() + 1); 
        
     });
};

Clust.prototype.hide = function() {
    if (this.div_) this.div_.style.visibility = "hidden";  
}

Clust.prototype.show = function() {
    if (this.div_) this.div_.style.visibility = "visible";
}

Clust.prototype.toggle = function() {
    if (this.div_) this.div_.style.visibility == "hidden" ? this.show() : this.hide();
}

// Implement onRemove
Clust.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
};

// Implement draw
Clust.prototype.draw = function() {
    var proj = this.getProjection(),
    pos = proj.fromLatLngToDivPixel(this.get('position')),
    p2 = proj.fromLatLngToDivPixel(this.params.bounds.getSouthWest()),
    p1 = proj.fromLatLngToDivPixel(this.params.bounds.getNorthEast()),
    div = this.div_;

    var w = p2.x - p1.x, h = p2.y - p1.y,
    p = this.params.nb / this.params.max;

    h*= (p < 0.50) ? 0.50 : p;

    //div.style.width = w+'px';
    div.style.height = Math.floor(h)+'px';
    div.style.width = Math.floor(h)+'px';

    var x = pos.x - $(div).outerWidth() / 2,
    y = pos.y - $(div).outerHeight() / 2;

    $(div).css({'left' : x, 'top' : y, 'display' : 'block'});
};