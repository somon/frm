<?
defined('_FRM') or die('No direct script access.');

class ControllerIndex extends ControllerTemplate
{
    public function __construct(\Request $oRequest) {
        parent::__construct($oRequest);
        echo 'OK';
    }
    public function actionIndex()
    {
        echo 'Hello World!';
    }
}