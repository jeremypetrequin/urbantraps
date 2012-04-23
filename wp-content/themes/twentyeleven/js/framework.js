// usage: log('inside coolFunc', this, arguments);
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
      arguments.callee = arguments.callee.caller;
      console.log( Array.prototype.slice.call(arguments) );
  }
};
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});

var CONF = {

},
framework = {
  /**
   * replace mutliple
   * @params str string où effectuer le remplacement
   * @params math string à chercher
   * @params repl string à mettre à la place
   * @return string 
   */
  replace : function(str, match, repl) {
        do {
            str = str.replace(match, repl);
        } while(str.indexOf(match) !== -1);
        return str;
   },
   /**
    * netoie un string en enlevant les scripts
    * @params string string à nettoyer
    * @return string netoyé
    */
   removeScript : function (string) {
	return string.replace(new RegExp('\\s*<script[^>]*>[\\s\\S]*?</script>\\s*','ig'),'');
   },
   /**
    * verifie un ou plusieurs mails (si séparé pas des virgules
    * @params mail string l'email a vérifier
    * @return boolean
    */
   checkMail : function(mail) {
       var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
       if(mail.indexOf(',')) {
           mail = framework.replace(mail, ' ', '');
           var mails = mail.split(','),
           i = mails.length,
           er = false;
           while(i--) {
               if(!reg.test(mails[i]))return false;
           }
           return true;
       } else {
            return(reg.test(mail));
       }
   },
   scrollBarWidth : function() { 
      $('body').css('overflow', 'hidden');
      var width = $('body').width(); 
      $('body').css('overflow', 'scroll');
      width -= $('body').width();  
      if(!width) width = document.body.offsetWidth - document.body.clientWidth; 
      $('body').css('overflow', '');
      return width;  
   },
   open : function() { // ouvrture de a Ligthbox
       
   },
   close : function() { //fermeture
        
   }
};

var Math2 = {
   equationDroite : function(xA, yA, xB, yB) {
       var m = (yB-yA)/(xB-xA),
       p = -m*xA+yA
       return function(time) {
           return m*time + p;
       }
   }
   


}