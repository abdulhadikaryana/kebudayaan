<?php

class Budpar_Controller_Plugin_LoginPlugin extends Zend_Controller_Plugin_Abstract
{
    
    public function __construct()
    {
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        
        $module = $request->getModuleName();
        if($module == "manage")
        {

            $controller = $request->getControllerName();
            $action = $request->getActionName();
            
            if($controller == "login")
            {
                //ga di cek
                
            }
            else
            {
                $userStatus = new Zend_Session_Namespace("userstatus");
                
                if(!$userStatus->user_id AND !$userStatus->password)
                {
                    $request->setModuleName("manage");
                    $request->setControllerName('index');
                    $request->setActionName('index');
                }

            }


        }
    }
}