<?
defined('_FRM') or die('No direct script access.');

class ControllerFactory
{
    static public function make($sController, Request $oRequest)
    {
        $sController = 'Controller'.ucfirst($sController);
        return new $sController($oRequest);
    }
}