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
  const STATUS_ARCHIVED = 0;
  const STATUS_DRAFT = 1;
  const STATUS_PENDING = 2;
  const STATUS_PUBLISH = 3;
  const LANGUAGE_ID = 1;
  const LANGUAGE_EN = 2;

  /**
   *
   * @var Model_DbTable_Event
   */
  protected $event;
  /**
   *
   * @var Model_DbTable_EventDesc
   */
  protected $event_description;
  /**
   * 
   * @var Zend_Session_Namespace
   */
  protected $filter;

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init()
  {
    $this->event = new Model_DbTable_Event();
    $this->event_description = new Model_DbTable_EventDesc();
    $this->filter = new Zend_Session_Namespace('filter');
    parent::init();
    $this->view->image_dir_type = 3;
  }

  public function restoreAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id) {
      $event = $this->event->find($id)->current();
      if (null != $event
              && $event->status == self::STATUS_ARCHIVED) {
        $event->setFromArray(array(
            'status' => self::STATUS_DRAFT))->save();
        $this->loggingaction('Event', 'Restore', $id,
                self::LANGUAGE_ID);
        $this->_helper->flashMessenger->addMessage
                ('Muat ulang kegiatan berhasil');
      }
    }
    $this->_helper->redirector("index");
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
   *     all_category, dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index event
   */
  public function indexAction()
  {
    $pageNumber = $this->_getParam('page');
    // Menangani permintaan POST
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $action = $post['action'];
      switch ($action) {
        case 'delete':
          if (isset($post['events'])) {
            $events = $post['events'];
            foreach ($events as $id) {
              $event = $this->event->find($id)->current();
              if (null != $event) {
                if ($event->status != self::STATUS_ARCHIVED) {
                  $event->setFromArray(array(
                      'status' => self::STATUS_ARCHIVED))->save();
                  $this->loggingaction('Event', 'Archive', $id);
                } else {
                  $event->delete();
                  $this->loggingaction('Event', 'Delete', $id);
                }
              }
            }
            $this->_helper->flashMessenger->addMessage
                    ('Kegiatan berhasil dihapus.');
          }
          break;
        case 'restore':
          if (isset($post['events'])) {
            $events = $post['events'];
            foreach ($events as $id) {
              $event = $this->event->find($id)->current();
              if (null != $event
                      && $event->status == self::STATUS_ARCHIVED) {
                $event->setFromArray(array(
                    'status'             => self::STATUS_DRAFT))->save();
                $this->loggingaction('Event', 'Restore', $id,
                        self::LANGUAGE_ID);
              }
            }
            $this->_helper->flashMessenger('Muat ulang kegiatan berhasil');
          }
          break;
        case 'filter':
          $this->filter->event = $post['filter'];
          break;
        case 'sort':
          $this->filter->event = $post['filter'];
          if ($this->filter->event['order'] == 'ASC') {
            $this->filter->event['order'] = 'DESC';
          } else $this->filter->event['order'] = 'ASC';
          break;
        case 'reset':
          $this->filter->unsetAll();
          break;
        default:
          break;
      }
      $this->_helper->redirector('index');
    }


    $messages = $this->_helper->flashMessenger->getMessages();
    $data = $this->event->findAll($this->filter->event,
            self::LANGUAGE_ID);
    $statusesCount = $this->event->findStatusesCount();
    if (!$this->_userInfo->canApprove) {
      $data = $this->event->findAll($this->filter->event,
              self::LANGUAGE_ID, $this->_userInfo->id);
      $statusesCount = $this->event
              ->findStatusesCount($this->_userInfo->id);
    }

    $events = Zend_Paginator::factory($data);
    $events->setCurrentPageNumber($pageNumber);
    $events->setItemCountPerPage(5);
    if (isset($this->filter->event['row'])) {
      $events->setItemCountPerPage($this->filter->event['row']);
    }


    $this->view->userInfo = $this->_userInfo;
    $this->view->statusesCount = $statusesCount;
    $this->view->filter = $this->filter->event;
    $this->view->messages = $messages;
    $this->view->events = $events;
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

    $form->draft->setLabel('Draft');
    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Terbitkan');
    } else {
      $form->submit->setLabel('Simpan Sebagai Pratinjau');
    }

    if ($this->getRequest()->isPost()) {
      if ($_POST['dateStart'] == $_POST['dateEnd']) {
        $startdate = $_POST['dateStart'] . ' ' . $_POST['timeStart'] . ':00';
        $enddate = $_POST['dateStart'] . ' ' . $_POST['timeEnd'] . ':00';
      } else {
        $startdate = $_POST['dateStart'] . ' ' . $_POST['timeStart'] . ':00';
        $enddate = $_POST['dateEnd'] . ' ' . $_POST['timeEnd'] . ':00';
      }

      $status = Model_DbTable_Event::DRAFT;
      if ($this->getRequest()->getPost('action') == 'Terbitkan'
              || $this->getRequest()->getPost('action') == 'Simpan Sebagai Pratinjau') {
        if ($this->_userInfo->canApprove) {
          $status = Model_DbTable_Event::PUBLISH;
        } else {
          $status = Model_DbTable_Event::PENDING;
        }
      }
      //preparing data and insert for event table
      $data = array(
          'main_pics'    => $_POST['eventImage'],
          'time_created' => date('Y-m-d H:i:s'),
          'date_start'   => $startdate,
          'date_end'     => $enddate,
          'category'     => $_POST['mainCategory'],
          'mice_event'   => $_POST['mice_event'],
          'user_id'      => $this->_userInfo->id,
          'status'       => $status
      );
      $event_id = $table_event->insertEvent($data);

      if (isset($event_id)) {
        //preparing data and insert for event description
        $event_name = htmlspecialchars($_POST['eventName'], ENT_QUOTES);
        $event_description = htmlspecialchars($_POST['eventDescription'],
                ENT_QUOTES);
        $data = array(
            'event_id'    => $event_id,
            'language_id' => $language_id,
            'name'        => $event_name,
            'description' => $event_description,
        );
        $table_event_description->insertEvent($data);

        $poi_count = $_POST['poiMax'];
        $poiarr = array();
        for ($i = 0; $i <= $poi_count; $i++) {
          if ($_POST['poiValue' . $i] != '') {
            array_push($poiarr, $_POST['poiValue' . $i]);
          }
        }

        if (sizeof($poiarr) > 0) {
          foreach ($poiarr as $poiid) {
            $data = array(
                'event_id' => $event_id,
                'poi_id'   => $poiid,
            );
            if ($poiid != '') {
              $table_poitoevent->insertEvent($data);
            }
          }
        }
        $this->loggingaction('Event', 'Create', $event_id,
                $language_id);
        $this->_flash->addMessage("Menambah Kegiatan Berhasil!");
      } else {
        $this->_flash->addMessage("Menambah Kegiatan Gagal!");
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
    if ($this->getRequest()->isPost()) {
      $data = array('report'            => htmlspecialchars($_POST['eventReport'],
                  ENT_QUOTES), 'language_id'       => $language_id);
      $table_event_description->updateEvent($data, $event_id,
              $language_id);
      $this->_flash->addMessage("1\Event Report Saved!");
      $this->_redirect($this->view->rootUrl('/admin/event/'));
    }
    //get report from the database and show it
    $eventReport = $table_event_description->getEventReport($event_id,
            $language_id);
    $this->view->report = $eventReport['report'];
    $this->loggingaction('Event', 'Report', $event_id, $language_id);
    $this->_flash->addMessage("Event Report Success!");
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

    $form->draft->setLabel('Draft');
    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Sunting');
    } else $form->submit->setLabel('Sunting Untuk Pratinjau');


    //if this is a post request
    if ($this->getRequest()->isPost()) {


      //preparing data and update for event description
      $event_name = htmlspecialchars($_POST['eventName'], ENT_QUOTES);
      $event_description = htmlspecialchars($_POST['eventDescription'],
              ENT_QUOTES);

      if ($language_id != 1) {
        $indo = $table_event_description->checkForIndo($event_id);
        if ($indo) {
          $data = array(
              'event_id'    => $event_id,
              'language_id' => $language_id,
              'name'        => $event_name,
              'description' => $event_description,
          );
          $table_event_description->updateEvent($data, $event_id,
                  $language_id);
        } else {
          $data2 = array(
              'event_id'    => $event_id,
              'language_id' => $language_id,
              'name'        => $event_name,
              'description' => $event_description,
          );
          $table_event_description->insertEvent($data2);
        }
      } else {
        if ($_POST['dateStart'] == $_POST['dateEnd']) {
          $startdate = $_POST['dateStart'] . ' ' . $_POST['timeStart'] . ':00';
          $enddate = $_POST['dateStart'] . ' ' . $_POST['timeEnd'] . ':00';
        } else {
          $startdate = $_POST['dateStart'] . ' ' . $_POST['timeStart'] . ':00';
          $enddate = $_POST['dateEnd'] . ' ' . $_POST['timeEnd'] . ':00';
        }

        $status = Model_DbTable_Event::DRAFT;
        if ($this->getRequest()->getPost('action') == 'Sunting'
                || $this->getRequest()->getPost('action') == 'Sunting Untuk Pratinjau') {
          if ($this->_userInfo->canApprove) $status = Model_DbTable_Event::PUBLISH;
          else $status = Model_DbTable_Event::PENDING;
        }
        //preparing data and update for event table
        $data = array(
            'main_pics'  => $_POST['eventImage'],
            'date_start' => $startdate,
            'date_end'   => $enddate,
            'category'   => $_POST['mainCategory'],
            'mice_event' => ((empty($_POST['mice_event']) || $_POST['mice_event'] == 0) ? 0 : $_POST['mice_event']),
            'updated_by' => $this->_userInfo->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'status'     => $status
        );
        $table_event->updateEvent($data, $event_id);

        $data = array(
            'event_id'    => $event_id,
            'language_id' => $language_id,
            'name'        => $event_name,
            'description' => $event_description,
        );
        $table_event_description->updateEvent($data, $event_id,
                $language_id);

        $poi_count = $_POST['poiMax'];
        $poiarr = array();
        for ($i = 0; $i <= $poi_count; $i++) {
          if ($_POST['poiValue' . $i] != '') {
            array_push($poiarr, $_POST['poiValue' . $i]);
          }
        }

        //create poi related to event list
        $saved_poitoevent = array();
        $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,
                $language_id);
        //convert to a non ASSOC array
        foreach ($saved_list as $list) {
          array_push($saved_poitoevent, $list['poi_id']);
        }

        //compare the new list with the new one, if the new one doesnt exist then insert then new one
        foreach ($poiarr as $poi_new) {
          if (!in_array($poi_new, $saved_poitoevent)) {
            $data = array(
                'event_id' => $event_id,
                'poi_id'   => $poi_new,
            );
            $table_poitoevent->insertEvent($data);
          }
        }
        //do the complementary process, if the old one doesnot exist in the new list then delete the old ones
        foreach ($saved_poitoevent as $poi_old) {
          if (!in_array($poi_old, $poiarr)) {
            if ($poi_old != '') {
              $table_poitoevent->deleteEvent($event_id, $poi_old);
            }
          }
        }
      }
      //preparing data for updating the poi to event data

      $this->loggingaction('Event', 'Edit', $event_id, $language_id);
      $this->_flash->addMessage("Sunting Kegiatan Berhasil!");
      $this->_redirect($this->view->rootUrl('/admin/event/'));
    }

    if ($language_id != 1) {
      $indo = $table_event_description->checkForIndo($event_id);
      if ($indo) {
        $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,
                $language_id);
      }
    } else {
      $saved_list = $table_poitoevent->getAllPoiNameByEventId($event_id,
              $language_id);
    }



    if ($language_id != 2) {
      //data processing
      $event_data = $table_event->getAllWithDescById($event_id,
              $language_id);
      $event_name = $this->view->HtmlDecode($event_data[0]['name']);
      $event_description = $this->view->HtmlDecode($event_data[0]['description']);
      $poiCount = $table_poitoevent->countRelatedPoiByEventId($event_id);
      $datetime_start = explode(' ', $event_data[0]['date_start']);
      $datetime_end = explode(' ', $event_data[0]['date_end']);

      //set form element value
      $form->eventName->setValue($event_name);
      $form->eventDescription->setValue($event_description);
      $form->eventImage->setValue($event_data[0]['main_pics']);
      $form->dateEnd->setValue($datetime_end[0]);
      $form->dateStart->setValue($datetime_start[0]);
      $form->timeStart->setValue(substr($datetime_start[1], 0, 5));
      $form->timeEnd->setValue(substr($datetime_end[1], 0, 5));
      $form->mainCategory->setValue($event_data[0]['category']);
      $form->poiMax->setValue($poiCount);

      if ($datetime_start[0] == $datetime_end[0]) {
        $this->view->date_view = $datetime_start[0] . ' one day event';
        $this->view->show_clock = TRUE;
      } else {
        $this->view->date_view = $datetime_start[0] . ' until ' . $datetime_end[0];
        $this->view->show_clock = FALSE;
      }

      $this->view->event_time = array($datetime_start[1], $datetime_end[1]);
    }


    if ($language_id == 2) {
      $data = $table_event->getAllWithDescById($event_id, $language_id);
      if (isset($data[0])) {
        $form->eventName->setValue($data[0]['name']);
        $form->eventDescription->setValue($this->view->htmlDecode($data[0]['description']));
      }
    }

    $this->view->event_id = $event_id;
    $this->view->form = $form;
    $this->view->langId = $language_id;
//        $this->view->mice_event = $event_data[0]['mice_event'];
  }

  public function approveAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
    if ($this->_userInfo->canApprove) {
      $id = $this->_getParam('id');
      $tbl_event = new Model_DbTable_Event;
      $tbl_event->fetchRow("event_id = {$id}")
              ->setFromArray(array("status" => Model_DbTable_Event::PUBLISH))->save();
      $this->loggingaction('Event', 'Approve', $id, self::LANGUAGE_ID);
      $this->_flashMessenger->addMessage('Kegiatan Berhasil Disetujui');
    }
    $this->_helper->redirector('index');
  }

  public function deleteAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id) {
      $event = $this->event->find($id)->current();
      if (null != $event) {
        if ($event->status != self::STATUS_ARCHIVED) {
          $event->setFromArray(array(
              'status' => self::STATUS_ARCHIVED))->save();
          $this->loggingaction('Event', 'Archive', $id,
                  self::LANGUAGE_ID);
          $this->_helper->flashMessenger->addMessage
                  ('Kegiatan dipindahkan ke arsip.');
        } else {
          $event->delete();
          $this->loggingaction('Event', 'Delete', $id,
                  self::LANGUAGE_ID);
          $this->_helper->flashMessenger->addMessage
                  ('Kegiatan berhasil dihapus.');
        }
      }
    }
    $this->_helper->redirector('index');
  }

  public function deletetranslationAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id) {
      $translation = $this->event_description->fetchRow(array(
          'event_id = ?'    => $id,
          'language_id = ?' => self::LANGUAGE_EN));

      if (null != $translation) {
        $translation->delete();
        $this->_helper->flashMessenger->addMessage
                ('Translasi berhasil dihapus');
        $this->loggingaction('Event', 'Delete', $id, self::LANGUAGE_EN);
      }
    }
    $this->_helper->redirector('index');
  }

}