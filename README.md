Site + blog (wordpress)
=============

Juste dupliquer le wp-config-sample.php en wp-config.php, le remplir correctement,
me demander la BDD (si l'url en local est différente de http://localhost:8888/urbantraps, il faut faire un chercher/remplacer de cette url par son url locale dans le script SQL) et les uploads.
Faire aussi un petit 

    chmod -R 777 

sur le dossier wp-content, pour ne pas avoir de pb en local

(si accès a aucunes pages avec l'url rewritting, juste le désactiver dans le BO de WP, il marchera en prod)

/iphone
=============
La partie de l'application Iphone qui est appelée en UIWebView

/api
===========
L'api web utilisée par le site, par l'application iphone, et par la UIWebView,
juste installer la base de données. Se sert de wp-config.php pour s'y connecter