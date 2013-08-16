<?
define('_FRM',true);
define('DOCROOT',  dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR);
define('SYSPATH', DOCROOT.'system'.DIRECTORY_SEPARATOR);

require_once SYSPATH.'Bootstrap.php';
$oB = new Bootstrap();
$oB->run();