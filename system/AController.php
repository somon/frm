<?
defined('_FRM') or die('No direct script access.');

abstract class AController implements IController
{
    protected $oRequest;
    
    public function __construct(Request $oRequest) 
    {
        $this->oRequest = $oRequest;
    }
    
    public function before() 
    {
        ;
    }
    
    public function after()
    {}
}