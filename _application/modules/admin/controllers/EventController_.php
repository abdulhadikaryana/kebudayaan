<?php
/**
 * EventController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - event
 */
require_once 'Zend/Controller/Action.php';

class Admin_EventController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
    {
        parent::init();
        $this->view->image_dir_type = 3;
    }

    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row
     * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
     *     all_category, dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index event
     */
    public function indexAction()
    {
        //variable initiation and instance creation
        $this->view->cleanurl = $this->_cleanUrl;

        //get messages from CRUD process
        $message = $this->_flash->getMessages();
        if(!empty($message))
        {
            $this->view->message = $message;
        }

        //create table instances
        $table_event = new Model_DbTable_Event;
        $table_category = new Model_DbTable_Category;

        //set variable initial value
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
                case 1 : $param = $_POST['filterName'];
                    break;
                case 2 : $param = $_POST['filterDestination'];
                    break;
                case 3 : $param = $_POST['filterCategory'];
                    break;
                case 4 : $param = $_POST['filterDate1'];
                    $param2 = $_POST['filterDate2'];
                    break;
            }
            $this->_paginator_sess->param = $param;
        }

        //set paginator for list of destination data
        $filter = $this->_paginator_sess->filter;
        $param = $this->_paginator_sess->param;

        if(isset($param2))
        {
            $select = $table_event->getQueryAllByLang($filter,$param,$param2);
        }
        else
        {
            $select = $table_event->getQueryAllByLang($filter,$param);
        }

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

        //send data to the view
        $this->view->paginator = $paginator;
        $filter_data = $table_category->getAllParentCategoryIdNameByLangId(1);
        $this->view->all_category = $filter_data;

        /** Return alert to view on filter selected */
        switch ($filter)
        {
            case 0 : $filter_alert = "Show all events";
                break;
            case 1 : $filter_alert = "Events which name with keyword '" . $param
                        . "'";
                break;
            case 2 : $filter_alert = "Events that related to '" . $param . "'";
                break;
            case 3 : foreach ($filter_data as $category)
                {
                    $parent[$category['category_id']] = $category['name'];
                }
                $filter_alert = "Events with '" . $parent[$param]
                        . "' category";
                break;
            case 4 :
                if (!empty($param) && !empty($param2))
                {
                    $filter_alert = "Events between " . $param . " and " . $param2;
                } else if (!empty($param) && empty($param2))
                {
                    $filter_alert = "Events after " . $param;
                } else if (empty($param) && !empty($param2))
                {
                    $filter_alert = "Events before " . $param2;
                } else
                {
                    $filter_alert = "Show all events";
                }
                break;
        }
        $this->view->alert = $filter_alert;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        $form = new Admin_Form_EventForm;
        $form->setCategorySelectData();
        $table_event = new Model_DbTable_Event;
        $table_event_description = new Model_DbTable_EventDesc;
        $table_poitoevent = new Model_DbTable_PoiToEvent;
        $language_id = 1;

        if($this->getRequest()->isPost())
        {
            if($_POST['dateStart']==$_POST['dateEnd'])
            {
                $startdate = $_POST['dateStart'].' '.$_POST['timeStart'].':00';
                $enddate = $_POST['dateStart'].' '.$_POST['timeEnd'].':00';
            }
            else
            {
                $startdate = $_POST['dateStart'].' '.$_POST['timeStart'].':00';
                $enddate = $_POST['dateEnd'].' '.$_POST['timeEnd'].':00';
            }
            //preparing data and insert for event table
            $data = array(
                    'main_pics' => $_POST['eventImage'],
                    'date_start' => $startdate,
                    'date_end' => $enddate,
                    'category' => $_POST['mainCategory'],
            );
            $event_id = $table_event->insertEvent($data);

            if(isset($event_id))
            {
                //preparing data and insert for event description
                $event_name = htmlspecialchars($_POST['eventName'],ENT_QUOTES);
                $event_description = htmlspecialchars($_POST['eventDescription'],ENT_QUOTES);
                $data = array(
                        'event_id' => $event_id,
                        'language_id' => $language_id,
                        'name' => $event_name,
                        'description' => $event_description,
                );
                $table_event_description->insertEvent($data);

                $poi_count = $_POST['poiMax'];
                $poiarr = array();
                for($i=0;$i<=$poi_count;$i++)
                {
                    if($_POST['poiValue'.$i]!='')
                    {
                        array_push($poiarr,$_POST['poiValue'.$i]);
                    }
                }

                if(sizeof($poiarr)>0)
                {
                    foreach ($poiarr as $poiid)
                    {
                        $data = array(
                                'event_id' => $event_id,
                                'poi_id' => $poiid,
                        );
                        if($poiid != '')
                        {
                            $table_poitoevent->insertEvent($data);
                        }
                    }
                }
                $this->loggingaction('event', 'create', $event_id, $language_id);
                $this->_flash->addMessage("1\Event Insert Success!");
            } else
            {
                $this->_flash->addMessage("2\Event Insert Failed!");
            }
            $this->_redirect($this->view->rootUrl('/admin/event/'));
        }

        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: report
     * Desc: Mengatur aksi yang dilakukan untuk halaman report
     */
    public function reportAction()
    {
        //set variable initial value and create instances
        $language_id = 1;
        $event_id = $this->_getParam('id');
        $table_event_description = new Model_DbTable_EventDesc;
        //if this is a post request
        if($this->getRequest()->isPost())
        {
            $data = array('report' => htmlspecialchars($_POST['eventReport'],ENT_QUOTES),'language_id' => $language_id);
            $table_event_description->updateEvent($data,$event_id,$language_id);
            $this->_flash->addMessage("1\Event Report Saved!");
            $this->_redirect($this->view->rootUrl('/admin/event/'));
        }
        //get report from the database and show it
        $eventReport = $table_event_description->getEventReport($event_id,$language_id);
        $this->view->report = $eventReport['report'];
        $this->loggingaction('event', 'report', $event_id, $language_id);
        $this->_flash->addMessage("1\Event Report Success!");
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form, date_view, show_clock, event_time,
     *     event_id
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        //set parameter
        $language_id = $this->_getParam('lang');
        $event_id = $this->_getParam('id');

        //creating instance
        $form = new Admin_Form_EventForm;
        $form->setCategorySelectData();
        $table_event = new Model_DbTable_Event;
        $table_event_description = new Model_DbTable_EventDesc;
        $table_poitoevent = new Model_DbTable_PoiToEvent;

        //if this is a post request
        if($this->getRequest()->isPost())
        {


            //preparing data and update for event description
            $event_name = htmlspecialchars($_POST['eventName'],ENT_QUOTES);
            $event_description = htmlspecialchars($_POST['eventDescription'],ENT_QUOTES);

            if($language_id!=1)
            {
                $indo = $table_event_description->checkForIndo($event_id);
                if($indo)
                {
                    $data = array(
                            'event_id' => $event_id,
                            'language_id' => $language_id,
                            'name' => $event_name,
                            'description' => $event_description,
                    );
                    $table_event_description->updateEvent($data,$event_id,$language_id);
                }else
                {
                    $data2 = array(
                            'event_id' => $event_id,
                            'language_id' => $language_id,
                            'name' => $event_name,
                            'description' => $event_description,
                    );
                    $table_event_description->insertEvent($data2);
                }
            }else
            {
                if($_POST['dateStart']==$_POST['dateEnd'])
                {
                    $startdate = $_POST['dateStart'].' '.$_POST['timeStart'].':00';
                    $enddate = $_POST['dateStart'].' '.$_POST['timeEnd'].':00';
                }
                else
                {
                    $startdate = $_POST['dateStart'].' '.$_POST['timeStart'].':00';
                    $enddate = $_POST['dateEnd'].' '.$_POST['timeEnd'].':00';
                }

                //preparing data and update for event table
                $data = array(
                        'main_pics' => $_POST['eventImage'],
                        'date_start' => $startdate,
                        'date_end' => $enddate,
                        'category' => $_POST['mainCategory'],
                );
                $table_event->updateEvent($data,$event_id);

                $data = array(
                        'event_id' => $event_id,
                        'language_id' => $language_id,
                        'name' => $event_name,
                        'description' => $event_description,
                );
                $table_event_description->updateEvent($data,$event_id,$language_id);

                $poi_count = $_POST['poiMax'];
                $poiarr = array();
                for($i=0;$i<=$poi_count;$i++)
                {
                    if($_POST['poiValue'.$i]!='')
                    {
                        array_push($poiarr,$_POST['poiValue'.$i]);
                    }
                }

                //create poi related to event list
                $saved_poitoevent = array();
                $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,$language_id);
                //convert to a non ASSOC array
                foreach($saved_list as $list)
                {
                    array_push($saved_poitoevent,$list['poi_id']);
                }

                //compare the new list with the new one, if the new one doesnt exist then insert then new one
                foreach($poiarr as $poi_new)
                {
                    if(!in_array($poi_new,$saved_poitoevent))
                    {
                        $data = array(
                                'event_id' => $event_id,
                                'poi_id' => $poi_new,
                        );
                        $table_poitoevent->insertEvent($data);
                    }
                }
                //do the complementary process, if the old one doesnot exist in the new list then delete the old ones
                foreach($saved_poitoevent as $poi_old)
                {
                    if(!in_array($poi_old,$poiarr))
                    {
                        if($poi_old != '')
                        {
                            $table_poitoevent->deleteEvent($event_id,$poi_old);
                        }
                    }
                }

            }
            //preparing data for updating the poi to event data

            $this->loggingaction('event', 'edit', $event_id, $language_id);
            $this->_flash->addMessage("1\Event Update Success!");
            $this->_redirect($this->view->rootUrl('/admin/event/'));
        }

        if($language_id!=1)
        {
            $indo = $table_event_description->checkForIndo($event_id);
            if($indo)
            {
                $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,$language_id);
            }
        }else
        {
            $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,$language_id);
        }



        //data processing
        $event_data = $table_event->getAllWithDescById($event_id,$language_id);
        $event_name = $this->view->HtmlDecode($event_data[0]['name']);
        $event_description = $this->view->HtmlDecode($event_data[0]['description']);
        $poiCount = $table_poitoevent->countRelatedPoiByEventId($event_id);
        $datetime_start = explode(' ',$event_data[0]['date_start']);
        $datetime_end = explode(' ',$event_data[0]['date_end']);

        //set form element value
        $form->eventName->setValue($event_name);
        $form->eventDescription->setValue($event_description);
        $form->eventImage->setValue($event_data[0]['main_pics']);
        $form->dateEnd->setValue($datetime_end[0]);
        $form->dateStart->setValue($datetime_start[0]);
        $form->timeStart->setValue(substr($datetime_start[1],0,5));
        $form->timeEnd->setValue(substr($datetime_end[1],0,5));
        $form->mainCategory->setValue($event_data[0]['category']);
        $form->poiMax->setValue($poiCount);

        if($datetime_start[0] == $datetime_end[0])
        {
            $this->view->date_view = $datetime_start[0].' one day event';
            $this->view->show_clock = TRUE;
        }
        else
        {
            $this->view->date_view = $datetime_start[0].' until '.$datetime_end[0];
            $this->view->show_clock = FALSE;
        }

        $this->view->event_time = array($datetime_start[1],$datetime_end[1]);
        $this->view->event_id = $event_id;
        $this->view->form = $form;
        $this->view->langId = $language_id;
    }

}