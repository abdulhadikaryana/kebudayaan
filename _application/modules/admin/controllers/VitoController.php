<?php
/**
 * TourismoperatorController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - tourism operator
 */
require_once 'Zend/Controller/Action.php';

class Admin_VitoController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
    {
            parent::init();
    }

    /**
     * IS: Terdeklarasinya page_row 
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, paginator,
     *     classification_list, island_list
     * Desc: Mengatur aksi yang dilakukan untuk halaman index tourism operator
     */
    public function indexAction()
    {
        //send this page url to the view
        $this->view->cleanurl = $this->_cleanUrl;
        
        //get messages from CRUD process
        $message = $this->_flash->getMessages();
        if(!empty($message))
        {
            $this->view->message = $message;
        }

        //create table instance
        $table_tourismoperator = new Model_DbTable_TourismOperator;
        $table_classification = new Model_DbTable_Classification;
        $table_area = new Model_DbTable_Area;

        //set the variable initial value
        $filter = null;
        $new_search = FALSE;
       
        //get the filter params
		if($this->getRequest()->isPost())
		{
			$filter = $_POST['filterPage'];
            $new_search = TRUE;
            $this->_paginator_sess->filter = $filter;
            switch($filter)
			{
				case 1 : $param = $_POST['filtertitle'];
						 break;
				case 2 : $param = $_POST['filterclass'];
						 break;
				case 3 : $param = $_POST['filterarea'];
						 break;
			}
            $this->_paginator_sess->param = $param; 
   		}

        //get the params from session and create paginator
        $filter =  $this->_paginator_sess->filter;
        $param =  $this->_paginator_sess->param;
        
        $select = $table_tourismoperator->getQueryVitoByLang($filter,$param);

        //get pagerow setting and send to the paginator control
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;
        
		if($page_row != null)
        {
    		$paginator = parent::setPaginator($select,$page_row);
        }
        else
        {
    		$paginator = parent::setPaginator($select);
        }        

        //if this is a new search then return the page number back to the 1st page
        if($new_search){$paginator->setCurrentPageNumber(1);}

        //Processing data for view element
        $classification_list = $table_classification->getAllClassification();
        $column = array('id' => 'area_id');
        $island_list = $table_area->getAllParentArea($column);

        //send data to the view
		$this->view->classification_list = $classification_list;
        $this->view->island_list = $island_list;
        $this->view->paginator = $paginator;
        
        /** Return alert to view on filter selected */
        switch ($filter) {
            case 0 : $filter_alert = "Show all VITO";
                     break;
            case 1 : $filter_alert = "VITO which name with keyword '" 
                        . $param . "'";
					 break;
			case 2 : foreach ($classification_list as $class) {
                        $parent[$class['id']] = $class['name'];
                     }
                     $filter_alert = "VITO with '" 
                        . $parent[$param] . "' classification";
					 break;
        }
        $this->view->alert = $filter_alert;
    }
    
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form, gkey
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        /*Create table and form instance*/
        $table_classification = new Model_DbTable_Classification;
        $table_area = new Model_DbTable_Area;
        $table_tourism = new Model_DbTable_TourismOperator;
        $table_tourismdescription = new Model_DbTable_TourismOperatorDescription;
        $table_classtotourism = new Model_DbTable_ClassificationToTourismOperator;
        $table_coveragearea = new Model_DbTable_CoverageArea;
        $form = new Admin_Form_VitoForm;
        $island_list = $table_area->getAllParentArea();
        
        /*check if this page is a posted page*/
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                /*preparing data for tourismoperator table*/
                $data = array(
                    'area_id' => 0,
                    'phone' => $_POST['TourismOperatorPhone'],
                    'website' => $_POST['TourismOperatorWebsite'],
                    'address' => $_POST['TourismOperatorAddress'],
                    'pointX' => 0,
                    'pointY' => 0,
                    'star' => 0,
                    'fax' => $_POST['TourismOperatorFax'],
                    'email' => $_POST['TourismOperatorEmail'],
                );
                /*inserting data to the tourismoperator table*/
                $tourism_id = $table_tourism->insertTourismOperator($data);
                /*if the insert process is success then insert the tourism description*/
                if(!empty($tourism_id))
                {
                    /*preparing data for tourismoperatordescription table*/
                    $data = array(
                        'tourismoperator_id' => $tourism_id,
                        'language_id' => 1,
                        'name' => $_POST['TourismOperatorRegion'],
                        'description' => $_POST['TourismOperatorLangName'],
                    );
                    /*inserting data to the tourismopeprator description table*/
                    $table_tourismdescription->insertTourismOperatorDescription($data);
                    
                    /*insert all classification to the database*/
                    $class_tourism = array(
                        'classification_id' => 6,
                        'tourismoperator_id'  => $tourism_id,
                    );
                    $table_classtotourism->insertClassificationTourism($class_tourism);

                    $this->loggingaction('vito', 'create', $tourism_id);
                    $this->_flash->addMessage('1\Vito Insert Success!');
                } else {
                    $this->_flash->addMessage('2\Vito Operator Insert Failed!');
                }
                $this->_redirect($this->view->rootUrl('/admin/vito/'));
            }
        }
        /*send variable to the view*/
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form, gkey, area, data, tourismid
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        /*Creating table instances*/
        $table_classification = new Model_DbTable_Classification;
        $table_area = new Model_DbTable_Area;
        $table_tourism = new Model_DbTable_TourismOperator;
        $table_tourismdescription = new Model_DbTable_TourismOperatorDescription;
        $table_classtotourism = new Model_DbTable_ClassificationToTourismOperator;
        $table_coveragearea = new Model_DbTable_CoverageArea;
        $form = new Admin_Form_VitoForm;
        $island_list = $table_area->getAllParentArea();
        $tourism_id = $this->_getParam('id');
        $this->view->state_edit = TRUE;
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                /*preparing data for tourismoperator table*/
                
                $data = array(
                    'area_id' => $_POST['TourismArea'],
                    'phone' => $_POST['TourismOperatorPhone'],
                    'website' => $_POST['TourismOperatorWebsite'],
                    'address' => $_POST['TourismOperatorAddress'],
                    'pointX' => 0,
                    'pointY' => 0,
                    'star' => 0,
                    'fax' => $_POST['TourismOperatorFax'],
                    'email' => $_POST['TourismOperatorEmail'],
                );
                /*updating data to the tourismoperator table*/
                $table_tourism->updateTourismOperator($data,$tourism_id);
                /*preparing data for tourismoperatordescription table*/
                    $data = array(
                        'tourismoperator_id' => $tourism_id,
                        'language_id' => 1,
                        'name' => $_POST['TourismOperatorRegion'],
                        'description' => $_POST['TourismOperatorLangName'],
                );
                /*updating data to the tourismoperator description table*/
                $table_tourismdescription->updateTourismOperatorDescription($data,$tourism_id);
            
            $this->loggingaction('vito', 'edit', $tourism_id);
            $this->_flash->addMessage('1\Vito Update Success!');
            $this->_redirect($this->view->rootUrl('/admin/vito/'));
            }
        }        

        $data_amount = $table_classtotourism->countClassByTourismId($tourism_id);
        $data = $table_tourism->getAllTourismDataByIdLang($tourism_id,1);

        /**
        *Set every element Value
        *Below are standard element value set that doesnt require any further database select operation
        */
        
        $form->TourismOperatorEmail->setValue($data['email']);
        $form->TourismOperatorPhone->setValue($data['phone']);
        $form->TourismOperatorArea->setValue($data['area_id']);
        $form->TourismOperatorWebsite->setValue($data['website']);
        $form->TourismOperatorAddress->setValue($this->view->HtmlDecode($data['address']));
        $form->TourismOperatorFax->setValue($data['fax']);
        $form->TourismOperatorRegion->setValue($data['langname']);
        $form->TourismOperatorLangName->setValue($this->view->HtmlDecode($data['description']));
        /*Count tourismoperator classification*/
        
        /*Send variable to the view*/
        $this->view->form = $form;
        $this->view->gkey = Zend_Registry::get('gmap_key');
        $this->view->tourismid = $tourism_id;
    }
    
    /**
     * IS: Nama file terdeklarasi
     * FS: File extention terdeklarasi
     * Desc: Mengembalikan file extention untuk berkas gambar
     */
    protected function get_file_extension($file_name) {
	   return substr(strrchr($file_name,'.'),1);
    }
    
    /**
     * IS: -
     * FS: -
     * Desc: Mengembalikan file-file dari direktori tertentu
     */
    protected function get_files($images_dir,$exts = array('jpg','jpeg','png','gif')) {
    	$files = array();
    	if($handle = opendir($images_dir)) {
    		while(false !== ($file = readdir($handle))) {
    			$extension = strtolower($this->get_file_extension($file));
    			if($extension && in_array($extension,$exts)) {
    				$files[] = $file;
    			}
    		}
    		closedir($handle);
    	}
    	return $files;
    }    
    
    /**
     * IS: -
     * FS: -
     * Desc: Mengatur aksi yang dilakukan untuk image browser
     */
    public function imagebrowserAction()
    {
        $this->_helper->layout()->disableLayout();
        $images_dir = UPLOAD_FOLDER.'tourismoperator/';
        $thumbs_width = 200;
        $images_per_row = 3;
        $image_files = $this->get_files($images_dir);
        if(count($image_files)) {
        	$index = 0;
        	foreach($image_files as $index=>$file) {
        		$index++;
                $source_url = $this->view->serverUrl().$this->view->imageUrl('/upload/poi/'.$file);
        		if(!file_exists($thumbnail_image)) {
        			$extension = $this->get_file_extension($thumbnail_image);
        		}
        		echo '<div class="photo-link smoothbox"><img width="100px" height="100px" src="'.$source_url.'" onclick="FileBrowserDialogue.mySubmit($(this));" /></div>';
        		if($index % $images_per_row == 0) { echo '<div class="clear"></div>'; }
        	}
        	echo '<div class="clear"></div>';
        }
        else {
        	echo '<p>There are no images in this gallery.</p>';
        }
    }
    
}