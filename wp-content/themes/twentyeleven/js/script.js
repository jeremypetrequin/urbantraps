;(function($) {
    var toggleConnect = $('#toggleConnec'),
    toggleForm = $('#toggleForm'),
    body = $('body'),
    onglet = $('#formulaire_connexion'),
    height = onglet.outerHeight(),
    open = false,
    menu = $('#menu ul.nav'),
    count = menu.children('li').length;
    
    $('ul.nav').children('li').width(100/count+'%');
    
    
    toggleConnect.click(function() {
        if(open) {
            onglet.animate({'margin-top' : - (height - 4)}, 300);
        } else{
            onglet.animate({'margin-top' : 0}, 300);
        }
        open =! open;
    })



})(jQuery);