<?php 
/**
 * MaterialpromotionController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - promotional materials
 */
require_once 'Zend/Controller/Action.php';

class Admin_MaterialpromotionindoController extends Library_Controller_Backend
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
     *     dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index promotional
     *       materials
     */
    public function indexAction()
    {
        $this->view->cleanurl = $this->_cleanUrl;

        /** get messages from CRUD process */
        $message = $this->_flash->getMessages();
        if (!empty($message))
        {
            $this->view->message = $message;
        }

        /** set variable initial value */
        $filter     = null;
        $new_search = FALSE;

        /** get params for the filter */
        if ($this->getRequest()->isPost())
        {
            $filter     = $_POST['filterPage'];
            $new_search = TRUE;
            switch ($filter)
            {
                case 0 : $param = null;
                    break;
                case 1 : $param = $this->_getParam('filterTitle');
                    break;
            }
            $this->_paginator_sess->filter = $filter;
            $this->_paginator_sess->param  = $param;
        }

        $filter = $this->_paginator_sess->filter;
        $param  = $this->_paginator_sess->param;

        /** Return alert to view on filter selected */
        switch ($filter)
        {
            case 0 : $filter_alert = "Show all promotional materials";
                break;
            case 1 : $filter_alert = "Promotional materials which title with keyword '"
                        . $param . "'";
                break;
        }
        $this->view->alert = $filter_alert;

        $material_desc = new Model_DbTable_MaterialDescription();
        $select        = $material_desc->getQueryAll($filter, $param,2);

        /** get pagerow setting and send to the paginator control */
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

        if ($page_row != null)
        {
            $paginator = parent::setPaginator($select,$page_row);
        } else
        {
            $paginator = parent::setPaginator($select);
        }

        /**
         * if this is a new search
         * then return the page number back to the 1st page
         */
        if ($new_search)
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
        $form         = new Admin_Form_MaterialPromotionForm;
        $material     = new Model_DbTable_Material();
        $materialdesc = new Model_DbTable_MaterialDescription();
        $materiallink = new Model_DbTable_MaterialLink();
        $languageId   = '2';
        if ($this->getRequest()->isPost())
        {
            if ($form->isValid($_POST))
            {
                /** Counter jumlah material yang diinsert */
                $numbCtr     = $_POST['materialCtr'];
                $data        = array('name' => $_POST['materialTitle']);
                $material_id = $material->insertMaterial($data);

                $title = htmlspecialchars($_POST['materialTitle'], ENT_QUOTES);
                $desc  = htmlspecialchars($_POST['materialDescription'], ENT_QUOTES);

                if (!empty($material_id))
                {
                    $data2 = array(
                            'material_id' => $material_id,
                            'language_id' => $languageId,
                            'title'       => $title,
                            'description' => $desc,
                    );
                    $materialdesc->insertMaterial($data2);

                    for ($i = 1; $i <= $numbCtr; $i++)
                    {
                        if (!empty($_POST['materialUrl'.$i]) AND !empty($_POST['materialName'.$i]))
                        {
                            $data3 = array(
                                    'material_id' => $material_id,
                                    'file_number' => $i,
                                    'file'        => $_POST['materialName' . $i],
                                    'link'        => $_POST['materialUrl' . $i],
                            );
                            $materiallink->insertMaterial($data3);
                        }
                    }
                    $this->loggingaction('promotionalmaterials', 'create', $material_id, $languageId);
                    $this->_flash->addMessage('1\Promotional Material Insert Success!');
                } else
                {
                    $this->_flash->addMessage('2\Promotional Material Insert Failed!');
                }
                $this->_redirect($this->view->rootUrl('/admin/materialpromotionindo/'));
            }
        }
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form, datamaterial, numbCtr2
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        $material_id  = $this->_getParam('id');
        $language_id  = $this->_getParam('lang');
        $form         = new Admin_Form_MaterialPromotionForm;
        $material     = new Model_DbTable_Material();
        $materialdesc = new Model_DbTable_MaterialDescription();
        $materiallink = new Model_DbTable_MaterialLink();

        if ($this->getRequest()->isPost())
        {
            if ($form->isValid($_POST))
            {
                $title = htmlspecialchars($_POST['materialTitle'], ENT_QUOTES);
                $desc  = htmlspecialchars($_POST['materialDescription'], ENT_QUOTES);

                if($language_id==1)
                {
                    $indo = $materialdesc->checkForIndo($material_id,1);
                    if($indo)
                    {
                        $data2 = array(
                                'material_id' => $material_id,
                                'language_id' => $language_id,
                                'title'       => $title,
                                'description' => $desc,
                        );
                        $materialdesc->updateMaterial($data2, $material_id, $language_id);
                    }else
                    {
                        $data2 = array(
                                'material_id' => $material_id,
                                'language_id' => $language_id,
                                'title'       => $title,
                                'description' => $desc,
                        );
                        $materialdesc->insertMaterial($data2);
                    }
                }else
                {
                    $data = array('name' => $title);
                    $material->updateMaterial($data, $material_id);

                    $data2 = array(
                            'title'       => $title,
                            'description' => $desc,
                    );
                    $materialdesc->updateMaterial($data2, $material_id, $language_id);

                    /** Counter jumlah material yang diupdate */
                    $numbCtr = $_POST['materialCtr'];
                    $no = 1;
                    for ($i = 1; $i <= $numbCtr; $i++)
                    {
                        if (!empty($_POST['materialName'.$i]) AND !empty($_POST['materialUrl'.$i]))
                        {
                            $materialStack[$no]['file'] = $_POST['materialName' . $i];
                            $materialStack[$no]['link'] = $_POST['materialUrl' . $i];
                            $no++;
                        }
                    }

                    /** Get material list from database and convert to a NON ASSOC Array */
                    $listmaterial = $materiallink->getAllById($material_id);
                    if (!empty($listmaterial))
                    {
                        foreach ($listmaterial as $val)
                        {
                            $oldmaterial[$val['file_number']]['file'] = $val['file'];
                            $oldmaterial[$val['file_number']]['link'] = $val['link'];
                        }
                    }

                    /**
                     * Compare new materials with old materials,
                     * if exist in new materials but not in old one, then insert
                     * if exist in old materials but not in new one, then delete
                     * if exist in both materials but different, then update
                     */
                    for ($i = 1; $i <= max(count($materialStack), count($oldmaterial)); $i++)
                    {
                        if (!empty($materialStack[$i]) AND !empty($oldmaterial[$i]))
                        {
                            if (($materialStack[$i]['file'] != $oldmaterial[$i]['file']) OR ($materialStack[$i]['link'] != $oldmaterial[$i]['link']))
                            {
                                $data3 = array(
                                        'file' => $materialStack[$i]['file'],
                                        'link' => $materialStack[$i]['link']
                                );
                                $materiallink->updateMaterial($data3, $material_id, $i);
                            }
                        } else if (!empty($materialStack[$i]) AND empty($oldmaterial[$i]))
                        {
                            $data3 = array(
                                    'material_id' => $material_id,
                                    'file_number' => $i,
                                    'file'        => $materialStack[$i]['file'],
                                    'link'        => $materialStack[$i]['link']
                            );
                            $materiallink->insertMaterial($data3);
                        } else if (empty($materialStack[$i]) AND !empty($oldmaterial[$i]))
                        {
                            $materiallink->deleteMaterial($material_id, $i);
                        }
                    }
                }
                $this->loggingaction('promotionalmaterials', 'edit', $material_id);
                $this->_flash->addMessage('1\Promotional Material Update Success!');
                $this->_redirect($this->view->rootUrl('/admin/materialpromotionindo/'));
            }
        }

        $data = $materiallink->getAllNameLinkByMaterialId($material_id);

        if($language_id==1)
        {
            $indo = $materialdesc->checkForIndo($material_id,1);
            if($indo)
            {
                $material_data = $materialdesc->getAllByIdLang($material_id);
            }
        }else
        {
           $material_data = $materialdesc->getAllByIdLang($material_id,2);
        }

        
        $form->materialTitle->setValue($this->view->htmlDecode($material_data[0]['title']));
        $form->materialDescription->setValue($this->view->htmlDecode($material_data[0]['description']));

        /** send to view */
        $this->view->language_id = $language_id;
        $this->view->form = $form;
        $this->view->datamaterial = $data;
        $this->view->numbCtr = sizeof($data);
    }
}