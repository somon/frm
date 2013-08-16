<?

defined('_FRM') or die('No direct script access.');

spl_autoload_register(array('Bootstrap','autoload'));
class Bootstrap {

    public function __construct() {
        ;
    }

    public function run()
    {
        $oRequest = new Request();
        $oRequest->parseRequestUri();
        $oController = ControllerFactory::make($oRequest->getController(), $oRequest);
        $sAction = 'action'.$oRequest->getAction();
        $oController->{$sAction()};
    }

    public static function autoload($sClassName)
    {
        if(file_exists(SYSPATH.$sClassName.'.php'))
        {
            require_once SYSPATH.$sClassName.'.php';
        }else{
            
            if( strpos($sClassName,'Controller') !== false )
            {
                $sClassName = substr_replace($sClassName, '',0,10);
                if(file_exists(APPPATH.'controller'.DIRECTORY_SEPARATOR.$sClassName.'.php'))
                {
                    require_once APPPATH.'controller'.DIRECTORY_SEPARATOR.$sClassName.'.php';
                }
            }
        }
    }
}

