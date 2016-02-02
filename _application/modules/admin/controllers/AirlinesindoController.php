<?php 
/**
 * AirlinesController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - airlines
 */
require_once 'Zend/Controller/Action.php';

class Admin_AirlinesindoController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
    {
        parent::init();
        $this->view->image_dir_type = 7;
    }

    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, paginator,
     *     dan filter_alert
     * Desc: Mengatur aksi yang dilakukan untuk halaman index
     */
    public function indexAction()
    {
        //get messages from CRUD process
        $airlines = new Model_DbTable_Airlines();
        $message = $this->_flash->getMessages();
        $this->view->cleanurl = $this->_cleanUrl;
        if(!empty($message))
        {
            $this->view->message = $message;
        }
        $filter = null;
        $new_search = FALSE;

        //get params for the filter
        if($this->getRequest()->isPost())
        {
            $filter = $_POST['filterPage'];
            $new_search = TRUE;
            $this->_paginator_sess->filter = $filter;
            switch($filter)
            {
                case 0 : $param = null;
                    break;
                case 1 : $param = $this->_getParam('filterName');
                    break;
            }
            $this->_paginator_sess->param = $param;
        }

        switch ($filter)
        {
            case 0 : $filter_alert = "Show all airlines";
                break;
            case 1 : $filter_alert = "airlines which name with keyword '"
                        . $param . "'";
                break;
        }
        $this->view->alert = $filter_alert;


        $select =  $airlines->getAllQuery($filter, $param,2);

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
        if($new_search)
        {
            $paginator->setCurrentPageNumber(1);
        }

        $this->view->paginator = $paginator;

    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        $form  =  new Admin_Form_AirlinesForm;
        $airline = new Model_DbTable_Airlines();
        $airlinedesc = new Model_DbTable_AirlinesDescription();
        $airlinetelp = new Model_DbTable_AirlinesTelephone();
        $langId = '2';
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $numbCtr = $_POST['linkCtr'];

                $data = array(
                        'website' => $_POST['linkWebsite'],
                        'email' => $_POST['linkEmail'],
                        'fax' => $_POST['linkFax'],
                        'image' => $_POST['airlineImage'],
                );
                $airline_id = $airline->insertAirlines($data);

                if(!empty($airline_id))
                {
                    $data2 = array(
                            'airline_id' => $airline_id,
                            'language_id' => $langId,
                            'name' => $_POST['linkName'],
                            'description' => $_POST['linkDescription'],
                    );
                    $airlinedesc->insertAirlinesDesc($data2);

                    for($i=0;$i<=$numbCtr;$i++)
                    {
                        if($_POST['linkTelephone'.$i]!= null)
                        {
                            $data3 = array(
                                    'airline_id' => $airline_id,
                                    'telephone' => $_POST['linkTelephone'.$i],
                            );
                            $airlinetelp->insertAirlinesTelp($data3);
                        }
                    }
                    $this->loggingaction('airlines','create',$airline_id);
                    $this->_flash->addMessage('1\Airlines Insert Success!');
                } else
                {
                    $this->_flash->addMessage('2\Airlines Insert Failed!');
                }
                $this->_redirect($this->view->rootUrl('/admin/airlinesindo/'));
            }
        }
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form, numbCtr2, dataTelp
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        $air_id = $this->_getParam('id');
        $language_id = $this->_getParam('lang');
        $form  =  new Admin_Form_AirlinesForm;
        $airline = new Model_DbTable_Airlines();
        $airlinedesc = new Model_DbTable_AirlinesDescription();
        $airlinetelp = new Model_DbTable_AirlinesTelephone();

        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                if($language_id==1)
                {
                    $indo = $airlinedesc->checkForIndo($air_id,1);
                    if($indo)
                    {
                        $data2 = array(
                                'airline_id' => $air_id,
                                'language_id' => 1,
                                'name' => $_POST['linkName'],
                                'description' => $_POST['linkDescription'],
                        );
                        $airlinedesc->updateAirlineDesc($data2, $air_id, $language_id);
                    }else
                    {
                        $data2 = array(
                                'airline_id' => $air_id,
                                'language_id' => 1,
                                'name' => $_POST['linkName'],
                                'description' => $_POST['linkDescription'],
                        );
                        $airlinedesc->insertAirlinesDesc($data2);
                    }
                }else
                {
                    $numbCtr = $_POST['linkCtr'];
                    $data = array(
                            'website' => $_POST['linkWebsite'],
                            'email' => $_POST['linkEmail'],
                            'fax' => $_POST['linkFax'],
                            'image' => $_POST['airlineImage'],
                    );
                    $airline->updateAirline($data, $air_id);

                    $data2 = array(
                            'airline_id' => $air_id,
                            'language_id' => $language_id,
                            'name' => $_POST['linkName'],
                            'description' => $_POST['linkDescription'],
                    );
                    $airlinedesc->updateAirlineDesc($data2, $air_id, $language_id);

                    $airlinetelp->deleteAirlineTelephone($air_id);
                    for($i=0;$i<=$numbCtr;$i++)
                    {
                        if($_POST['linkTelephone'.$i]!= null)
                        {
                            $data3 = array(
                                    'airline_id' => $air_id,
                                    'telephone' => $_POST['linkTelephone'.$i],
                            );
                            $airlinetelp->insertAirlinesTelp($data3);
                        }
                    }
                }
                $this->loggingaction('airlines','edit',$air_id);
                $this->_flash->addMessage('1\Airlines Update Success!');
                $this->_redirect($this->view->rootUrl('/admin/airlinesindo/'));
            }
        }

        $new = new Model_DbTable_Airlines();

        if($language_id==1)
        {
            $indo = $airlinedesc->checkForIndo($air_id,1);
            if($indo)
            {
                $airline_data = $new->getAllQueryByIdLang($air_id, $language_id);
            }
        }else
        {
           $airline_data = $new->getAllQueryByIdLang($air_id, $language_id);
        }

        
        $count = $airlinetelp->getCountTelephoneById($air_id);
        $data_telp = $airlinetelp->getAllDataById($air_id);
        $numb = $count - 1;
        $this->view->numbCtr2 = $numb;
        $this->view->datatelp = $data_telp;
        $form->linkName->setValue($airline_data['name']);
        $form->airlineImage->setValue($airline_data['image']);
        $form->linkWebsite->setValue($airline_data['website']);
        $form->linkEmail->setValue($airline_data['email']);
        $form->linkFax->setValue($airline_data['fax']);
        $form->linkDescription->setValue($airline_data['description']);
        $form->linkCtr->setValue($numb);
        $this->view->form = $form;
        $this->view->language_id = $language_id;
    }

}