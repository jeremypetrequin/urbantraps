Javascript error Catching
=========
 import javascript file, and instanciate it
    
    var er = new ErrorCatching('http://otherdomain.com/api.php');

the param is the url of the domain where save the error, it may be usefull il you yant to log all the javascript errors of all yours visitors in a database, or send them by email..

the url is called in ajax at each error, and receive
    
    $_GET['domain'] => domain from, usefull on case of multiple domain
    $_GET['msg'] => error message
    $_GET['line'] => line of error, may be empty
    $_GET['file'] => url of file, may be empty
    
don't forget to put a header at the begin of your php, if it is on another domain than javascript.

    header("Access-Control-Allow-Origin: *"); 

it may be usefull if you want to save errors of all yours sites on the same domain.

you can send an error manualy

    er.send(message,  lineNumber, urlFile, callback when the error is sended); 