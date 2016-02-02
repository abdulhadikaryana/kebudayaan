<?php
/**
 * Budpar_Controller_Plugin_Resources
 *
 * Resources Loader Initiation
 *
 * @package Budpar Library
 * @copyright Copyright (c) 2011 LAPI Divusi
 * @author Sangkuriang International
 */
 
 class Budpar_Controller_Plugin_Resources
    extends Zend_Controller_Plugin_Abstract
{
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
                'namespace' => '',
                'basePath'  => APPLICATION_PATH));		

		switch($request->getModuleName())
		{
			case 'admin' : 
				$moduleLoader->addResourceType('adminLibrary', 'modules/admin/library', 'Library_');
		        $moduleLoader->addResourceType('adminForms', 'modules/admin/forms', 'Admin_Form_');
			break;
	        
	        case 'manage' :
		        $moduleLoader->addResourceType('manageLibrary', 'modules/manage/library', 'Manage_');
		        $moduleLoader->addResourceType('manageForms', 'modules/manage/models/forms', 'Manage_Model_Form_');
		        $moduleLoader->addResourceType('manageTable', 'modules/manage/models/DbTable', 'Manage_Model_DbTable_');
		        $moduleLoader->addResourceType('manageObject', 'modules/manage/models/object', 'Manage_Model_Object_');
		        $moduleLoader->addResourceType('manageTools', 'modules/manage/models/tools', 'Manage_Model_Tools_');
			    $moduleLoader->addResourceType('miceLibrary', 'modules/mice/library', 'Mice_');
		        $moduleLoader->addResourceType('miceTable', 'modules/mice/models/DbTable', 'Mice_Model_DbTable_');
            break;
	        
	        case 'mice' :
			    $moduleLoader->addResourceType('miceLibrary', 'modules/mice/library', 'Mice_');
		        $moduleLoader->addResourceType('miceTable', 'modules/mice/models/DbTable', 'Mice_Model_DbTable_');
			break;
		}

    	
    }
}