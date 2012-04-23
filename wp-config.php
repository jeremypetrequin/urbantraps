<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/Editing_wp-config.php Modifier
 * wp-config.php} (en anglais). C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'urbantraps');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'e5P{-A=UR.9{9sjrtslu>njGD>.R.J^6U9i(;M[;Fxi9kI6%o6Au8J&r067jqd=t'); 
define('SECURE_AUTH_KEY',  'IiD9ucS0_r)(*^?iB`UhF^?}r z;9/cuii8}R2B/iODZsM;@HBq=9M1cfge7L=aa'); 
define('LOGGED_IN_KEY',    'ym|Vt I0#[Jw(4(J$dj2SHDbu#i{iv0[0B;#jv7?B(Im(j3=yuyr$j=e6<<|G;jz'); 
define('NONCE_KEY',        'M`mSE3@6IZq8KhKTO] w#[pw-8.4X1:@%m!oX!2uj54M4t7y2W;v}Splu@bcgplQ'); 
define('AUTH_SALT',        'i`q?Lb9VidObt_VEx{a>6D2B6pispfb$]9QFgY*?@=JY9BrNoqd)C/:FeudKV}M]'); 
define('SECURE_AUTH_SALT', 'mLm}<x-w@RZohXoH/(lNyG(rCsa[Wu:2f8{Ft64dywm]lf%{:KTIg1C1VNCF *6D'); 
define('LOGGED_IN_SALT',   '$Xp4`%MpV|Kq5%<-L+8]cv;k}.r(n8IZY&UT}U!0fC$PWH:V*FO}9SKuGAwVq%M?'); 
define('NONCE_SALT',       '_k+&Rx)&$Gv+p8fgEtiq#C((HOW]nXczsc4;7vi]7$`K_&cTKv8z/X~4HJY}XT-x'); 
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');