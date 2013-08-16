<?
defined('_FRM') or die('No direct script access.');

interface IController
{
    /*
     * Before action
     */
    public function before();
    
    /**
     * After action
     */
    public function after();
}