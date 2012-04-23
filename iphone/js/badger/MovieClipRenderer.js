/**
 * render queue for MovieClip object
 * static object
 */
;(function($, w) {
    
    w.MovieClipRenderer =  {
        renderList : [],
        paused : false,
        
        render : function() {
            if(MovieClipRenderer.paused) return
            var i = MovieClipRenderer.renderList.length;
            if(i == 0) return;
            while(i--) {
                MovieClipRenderer.renderList[i].render();
            }
        },
        
        addItem : function(item) {
            if(item.posInRenderList) return;
            MovieClipRenderer.renderList.push(item);
            item.posInRenderList = MovieClipRenderer.renderList.length-1;
        },
        
        pause : function() {
            MovieClipRenderer.paused = false;
        },
        resume : function() {
            MovieClipRenderer.paused = true;
        },
        toggle : function() {
            MovieClipRenderer.paused =! MovieClipRenderer.paused;
        },
        hasItem : function(item) {
            return item.posInRenderList !== false;
        },
        
        dequeuAll : function() {
            var i = MovieClipRenderer.renderList.length;
            if(i == 0) return;
            while(i--) {
                this.removeItem(MovieClipRenderer.renderList[i]);
            }
        },
        
        posItem : function(item) {
            return item.posInRenderList;
        },
        
        getItem : function(i) {
            return MovieClipRenderer.renderList[i] || false;
        },
        
        removeItem : function(item) {
            if(!item || item.posInRenderList === false) return;
            MovieClipRenderer.renderList.splice(item.posInRenderList, 1);
            item.posInRenderList = false;
        }
    }

})($, window);