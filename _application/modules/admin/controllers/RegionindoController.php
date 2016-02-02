<?php 
/**
 * RegionController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - region/area
 */
require_once 'Zend/Controller/Action.php';

class Admin_RegionindoController extends Library_Controller_Backend
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
     * IS: Terdeklarasinya filter dan param di session, dan page_row
     * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
     *     panel_data, dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index region
     */
    public function indexAction()
    {
        //variable initiation and instance creation
        $this->view->cleanurl = $this->_cleanUrl;
        $language_id = 2;
        $table_area  = new Model_DbTable_Area;
        $parent_data = $table_area->getAllIslandAndProvince($language_id);
        $filter_data = array('area' => $parent_data);

        //get messages from CRUD process
        $message = $this->_flash->getMessages();
        if(!empty($message))
        {
            $this->view->message = $message;
        }

        $filter     = null;
        $new_search = FALSE;

        if ($this->getRequest()->isPost())
        {
            $filter = $_POST['filterPage'];
            $new_search = TRUE;
            switch ($filter)
            {
                case 0 : $param = null;
                    break;
                case 1 : $param = $_POST['filterTitle'];
                    break;
                case 2 : $param = $_POST['filterParent'];
                    break;
            }
            $this->_paginator_sess->filter = $filter;
            $this->_paginator_sess->param  = $param;
        }

        //get the params from session and create paginator
        $filter =  $this->_paginator_sess->filter;
        $param  =  $this->_paginator_sess->param;

        /** Return alert to view on filter selected */
        switch ($filter)
        {
            case 0 : $filter_alert = "Show all regions";
                break;
            case 1 : $filter_alert = "Regions which name with keyword '"
                        . $param . "'";
                break;
            case 2 : foreach ($filter_data['area'] as $area)
                {
                    $parent[$area['area_id']] = $area['name'];
                }
                $filter_alert = "Regions that located in '"
                        . $parent[$param] . "' area";
                break;
        }
        $this->view->alert = $filter_alert;

        $select =
                $table_area->getQueryAllByLanguage($filter, $param, $language_id);

        //get pagerow setting and send to the paginator control
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

        if ($page_row != null)
        {
            $paginator = parent::setPaginator($select, $page_row);
        } else
        {
            $paginator = parent::setPaginator($select);
        }

        //if this is a new search then return the page number back to the 1st page
        if ($new_search)
        {
            $paginator->setCurrentPageNumber(1);
        }

        //send data to the view
        $this->view->panel_data = $filter_data;
        $this->view->paginator = $paginator;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form, language_id, parent_data
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        $language_id = 2;
        $form = new Admin_Form_AreaForm;
        $table_area = new Model_DbTable_Area;
        $table_regionalinfo = new Model_DbTable_Regional;
        $parent_data = $table_area->getAllParentArea(array('area_id'),$language_id);

        //if the page request is a Post Request
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                //get the parent area for determine area type
                $area_type = $table_area->getAreaTypeById($_POST['parentArea']);

                //preparing data for insert process
                $data = array(
                        'pointX' => $_POST['pointx'],
                        'pointY' => $_POST['pointy'],
                        'parent_id' => $_POST['parentArea'],
                        'area_type' => $area_type,
                );
                $area_id = $table_area->insertArea($data);

                //if the insert process is succeed
                if (!empty($area_id))
                {
                    $data = array(
                            'area_id' => $area_id,
                            'language_id' => $language_id,
                            'area_name' => $_POST['areaNameLan'],
                            'regional_description' => $_POST['areaDescription'],
                            'history' => $_POST['areaHistory'],
                            'people_and_customs' => $_POST['areaPeople'],
                            'entry' => $_POST['areaEntry'],
                            'cuisine' => $_POST['areaCuisine'],
                            'tourism_office' => $_POST['areaTourismOffice']
                    );
                    $table_regionalinfo->insertArea($data);
                    $this->loggingaction('region', 'create', $area_id, $language_id);
                    $this->_flash->addMessage('1\Region Insert Success!');
                } else
                {
                    $this->_flash->addMessage('2\Region Insert Failed!');
                }
                $this->_redirect($this->view->rootUrl('/admin/regionindo/'));
            }
        }
        //send data to the view
        $this->view->language_id = $language_id;
        $this->view->parent_data = $parent_data;
        $this->view->form = $form;
        $this->view->gkey = Zend_Registry::get('gmap_key');
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form, language_id, parent_id, parent_data
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        //variable and class initiation
        $area_id = $this->_getParam('id');
        $language_id = $this->_getParam('lang');
        $form = new Admin_Form_AreaForm;
        $table_area = new Model_DbTable_Area;
        $table_regionalinfo = new Model_DbTable_Regional;
        $parent_data = $table_area->getAllParentArea(array('area_id'));

        //if this is a post request
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {

                if($language_id==1)
                {
                    $indo = $table_regionalinfo->checkForIndo($area_id,$language_id);
                    if($indo)
                    {
                        $data = array(
                                'area_id' => $area_id,
                                'language_id' => $language_id,
                                'area_name' => $_POST['areaNameLan'],
                                'regional_description' => $_POST['areaDescription'],
                                'history' => $_POST['areaHistory'],
                                'people_and_customs' => $_POST['areaPeople'],
                                'entry' => $_POST['areaEntry'],
                                'cuisine' => $_POST['areaCuisine'],
                                'tourism_office' => $_POST['areaTourismOffice'],
                        );
                        $table_regionalinfo->updateArea($area_id,$data,$language_id);
                    }else
                    {
                        
                        $data = array(
                                'area_id' => $area_id,
                                'language_id' => $language_id,
                                'area_name' => $_POST['areaNameLan'],
                                'regional_description' => $_POST['areaDescription'],
                                'history' => $_POST['areaHistory'],
                                'people_and_customs' => $_POST['areaPeople'],
                                'entry' => $_POST['areaEntry'],
                                'cuisine' => $_POST['areaCuisine'],
                                'tourism_office' => $_POST['areaTourismOffice'],
                        );
                        $table_regionalinfo->insertArea($data);
                    }
                }else
                {
                    //get the parent area for determine area type
                    $area_type = $table_area->getAreaTypeById($_POST['parentArea'])+1;

                    //preparing data for insert process
                    $data = array(
                            'pointX' => $_POST['pointx'],
                            'pointY' => $_POST['pointy'],
                            'parent_id' => $_POST['parentArea'],
                            'area_type' => $area_type,
                    );
                    $table_area->updateArea($area_id, $data);

                    $data = array(
                            'area_id' => $area_id,
                            'language_id' => $language_id,
                            'area_name' => $_POST['areaNameLan'],
                            'regional_description' => $_POST['areaDescription'],
                            'history' => $_POST['areaHistory'],
                            'people_and_customs' => $_POST['areaPeople'],
                            'entry' => $_POST['areaEntry'],
                            'cuisine' => $_POST['areaCuisine'],
                            'tourism_office' => $_POST['areaTourismOffice'],
                    );
                    $table_regionalinfo->updateArea($area_id,$data,2);
                }
                $this->loggingaction('region', 'edit', $area_id, $language_id);
                $this->_flash->addMessage('1\Region Update Success!');
                $this->_redirect($this->view->rootUrl('/admin/regionindo/'));
            }
        }


        if($language_id==1)
        {
            $indo = $table_regionalinfo->checkForIndo($area_id,$language_id);
            if($indo)
            {
                $area_data = $table_area->getAllById($area_id, $language_id);
            }
        }else
        {
            $area_data = $table_area->getAllById($area_id, $language_id);
        }

        //get data from the database and load it to the view
        
        $this->view->parent_id = $area_data['parent_id'];
        //set element value
        $form->areaDescription->setvalue($area_data['regional_description']);
        $form->areaEntry->setvalue($area_data['entry']);
        $form->areaHistory->setvalue($area_data['history']);
        $form->areaPeople->setvalue($area_data['people_and_customs']);
        $form->areaCuisine->setvalue($area_data['cuisine']);
        $form->areaTourismOffice->setvalue($area_data['tourism_office']);
        $form->areaNameLang->setvalue($area_data['area_name']);
        $form->Poi_x->setvalue($area_data['pointX']);
        $form->Poi_y->setvalue($area_data['pointY']);
        //send data to the view
        $this->view->language_id = $language_id;
        $this->view->parent_data = $parent_data;
        $this->view->form = $form;
        $this->view->gkey = Zend_Registry::get('gmap_key');
    }
}