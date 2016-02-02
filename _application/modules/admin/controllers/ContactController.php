<?php 
/**
 * ContactController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - contact
 */
require_once 'Zend/Controller/Action.php';

class Admin_ContactController extends Library_Controller_Backend
{
    
    protected  $contact;
    protected  $_contactSubject;
    protected $filter;
    protected $form;

    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
    {
        $this->contact = new Model_DbTable_Contact();
        $this->_contactSubject = new Model_DbTable_ContactSubject();
        $this->form = new Admin_Form_ContactForm();
        $this->filter = new Zend_Session_Namespace('filter');
        parent::init();
    }

    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, filter_alert, 
     *     paginator, countId
     * Desc: Mengatur aksi yang dilakukan untuk halaman index
     */
    public function indexAction()
    {
        /** Get messages from CRUD process */
        $pageNumber = $this->_getParam('page');
        $message = $this->_flash->getMessages();
        if (!empty($message)) {
            $this->view->message = $message;
        }
        if($this->getRequest()->isPost()){
            $post = $this->getRequest()->getPost();
            switch ($post['action']){
                case 'delete':
                    if (isset($post['contact'])) {
                      $contact = $post['contact'];
                      foreach ($contact as $id) {
                        $this->contact->find($id)->current()->delete();
                      }
                      $this->_helper->flashMessenger->addMessage
                              ('Kontak berhasil dihapus.');
                    }
                    break;
                case 'filter':
                    $this->filter->contact = $post['filter'];
                    break;
                case 'sort' :
                    $this->filter->contact = $post['filter'];
                    if($this->filter->contact['order'] == 'ASC')
                        $this->filter->contact['order'] = 'DESC';
                    else $this->filter->contact['order'] = 'ASC';
                    break;
                case 'reset':
                    $this->filter->unsetAll();
                    break;
                default:
                    break;
            }
        }
        
        //set variable initial value
//        $filter = null;
        
//        $this->view->cleanurl = $this->_cleanUrl;
        //get params for the filter
//        if($this->getRequest()->isPost())
//        {
//            $filter = $_POST['filterPage'];
//            $new_search = TRUE;
//            $this->_paginator_sess->filter = $filter;
//            switch($filter)
//            {
//                case 0 : $param = null;
//                    break;
//                case 1 : $param = $_POST['filterName'];
//                    break;
//                case 2 : $param = $_POST['filterStatus'];
//                    break;
//                case 3 : $param = $_POST['filterSubject'];
//                    break;
//                case 4 : $param = $_POST['filterFlag'];
//                    break;
//                case 5 : $param = $_POST['filterCountry'];
//                    break;
//
//            }
//            $this->_paginator_sess->param = $param;
//        }

//        $contact = new Model_DbTable_Contact();
        
        /** Return alert to view on filter selected */
//        switch ($filter) {
//            case 0 : $filter_alert = "Show all contact";
//                     break;
//            case 1 : $filter_alert = "Contact which name with keyword '" 
//                        . $param . "'";
//					 break;
//			case 2 : 
//                switch ($param) {
//                    case 0 : $state = 'Not yet replied';                 break;
//                    case 1 : $state = 'A reply draft awaiting approval'; break;
//                    case 2 : $state = 'Replied';                         break;
//                }
//                $filter_alert = "Contact with '" . $state . "' status";
//				break;
//			case 3 : 
//                switch ($param) {
//                    case 0 : $state = 'Others';
//                             break;
//                    case 1 : $state = 'Destination Information Inquiry';
//                             break;
//                    case 2 : $state = 'Site Promotional/Marketing Cooperation Offers';
//                             break;
//                    case 3 : $state = 'Affiliation Information Inquiry';
//                             break;
//                    case 4 : $state = 'Feedback/Comment on this Site';
//                             break;
//                    case 5 : $state = 'Sender Country';
//                             break;
//                }
//                $filter_alert = "Contact with '" . $state . "' subject";
//				break;
//            case 4 : ($param == '1') ? $state = 'with' : $state = 'without';
//                     $filter_alert = "Contact " . $state . " flag";
//					 break;
//            case 5 : $filter_alert = 'All message send from '. $param;
//                     break;
//        }
//        $this->view->alert = $filter_alert;
        
        
        
//        $countId = $contact->getCountId();

        //get pagerow setting and send to the paginator control
        $new_search = FALSE;
        $param = null;
        $select =  $this->contact->getAllQuery($this->filter->contact, $param);
        $data = $this->contact->fetchAll($select);
        $param = $this->_paginator_sess->param;
        $filter = $this->_paginator_sess->filter;
        
        $contact = Zend_Paginator::factory($data);
        $contact->setCurrentPageNumber($pageNumber);
        $contact->setItemCountPerPage(5);
        if(null != $this->filter->contact['row']) $contact->setItemCountPerPage($this->filter->contact['row']);
        
        $this->view->filter = $this->filter->contact;
        $this->view->contact = $contact;
        
        
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

        if($page_row != null)
        {
            $paginator = parent::setPaginator($select, $page_row);
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
//        $this->view->countId = $countId;
        //country select
        Zend_Registry::set('languageId', 1);
        $this->view->totalItem = $paginator->getTotalItemCount();
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: detail, form
     * Desc: Mengatur aksi yang dilakukan untuk halaman detail
     */
    public function detailAction()
    {
        $form  =  new Admin_Form_ContactForm;
        $contact = new Model_DbTable_Contact();
        $contactId = $this->_getParam('id');
        $select =  $contact->getAllById($contactId);
        $this->view->detail = $select;
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: detail, form
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editdraftAction()
    {

        $form  =  new Admin_Form_ContactForm;
        $contact = new Model_DbTable_Contact();
        $contactId = $this->_getParam('id');
        $page = $this->_getParam('page');
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {

                $data = array(
                        'reply' => $_POST['replyText'],
                        'status' => '1',
                );
                $contact->updateContact($data, $contactId);
                $this->_flash->addMessage('1\Draft Reply Success!');
                $this->loggingaction('contact', 'edit', $contactId);
                $this->_redirect($page);
            }
        }

        $contact = new Model_DbTable_Contact();
        $contactId = $this->_getParam('id');
        $select =  $contact->getAllById($contactId);
        $this->view->detail = $select;
        $form->replyText->setValue($select[0]['reply']);
        $this->view->form = $form;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: -
     * Desc: Mengatur aksi yang dilakukan untuk halaman send
     */
    public function sendAction()
    {
        $contact = new Model_DbTable_Contact();
        $page = $this->_getParam('page');
        $contactId = $this->_getParam('id');
		$select =  $contact->getAllById($contactId);
        $message = $contact->getReplyMessage($select[0]['name'], $select[0]['reply']);

        $fromName = 'Visit Indonesia';
        $fromEmail = 'noreply@indonesia.travel';
        $subject = $select[0]['subject '] .'replied message';

        $sendEmail = $this->_sendEmail($message,
                $fromName, $fromEmail, $subject, $select[0]['email']);
        
		$this->_flash->addMessage("<p class='msg-ok'>A reply to ".$select[0]['name']." has been send</p>");
        
		if($sendEmail)
        {
            $this->_flash->addMessage("<p class='msg-ok'>A reply to ".$select[0]['name']." has been send</p>");
            $arrin = array(
                    'status' => '2'
            );
            $contact->updateContact($arrin,$contactId);
            $this->loggingaction('contact', 'edit', $contactId);
        }else
        {
            $this->_flash->addMessage("<p class='msg-error>'A reply to ".$select[0]['name']." failed to send</p>");
        }
        
		$this->_redirect($page);
    }

    /**vob
     * IS: -
     * FS: -
     * Desc: Fungsi untuk mengirim email
     */
    protected function _sendEmail($msg, $fromName, $fromEmail, $subject, $toEmail)
    {
        // Inisialisasi Zend_Mail_Transport
        $transport = new Zend_Mail_Transport_Smtp(SMTP_HOST, Array(
                        //'auth' => 'login',
                        //'username' => SMTP_USERNAME,
                        //'password' => SMTP_PASSWORD,
                        'port' =>  25,
        ));


        $transport->EOL = "\r\n";
        Zend_Mail::setDefaultTransport($transport);

        // Buat Zend_Mail properti
        $mail = new Zend_Mail();
        $mail->setFrom($fromEmail, $fromName);
        $mail->setSubject($subject);

        // Cek email tujuan
        if (is_array($toEmail))
        {
            for($i = 0; $i < count($toEmail); $i++)
            {
                $mail->addTo($toEmail[$i]);
            }
        } else
        {
            $mail->addTo($toEmail);
        }

        $mail->setBodyHtml($msg,'UTF-8', Zend_Mime::ENCODING_8BIT);

        // Kirim email-nya
        $isSend = false;
        try
        {
            if (!$mail->send())
            {
                throw new Exception("Error occurred sending message");
            }else
            {
                $isSend = true;
            }
        } catch (Exception $e)
        {
            print $e->getMessage();
            exit();
        }

        return $isSend;
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi yang mengatur aksi untuk seleksi beberapa item
     */
    public function actionAction()
    {
        //form submit ke sini
        //di sini ditentukan aksi2 apa aja yg dilakukan
        //tergantung SUATU variabel: $_POST["actionnya"]
        $con = new Model_DbTable_Contact();
        if ($_POST['actionnya'] && $_POST['contact_item'])
        {
            switch ($_POST['actionnya'])
            {
                case 'delete_selected':
                    $id = $_POST['contact_item'];
                    //print_r ($id);
                    for($i=0;$i < count($id);$i++)
                    {
                        $con->deleteContact($id[$i]);
                        $this->loggingaction('contact', 'delete', $id[$i]);
                    }
                    $this->_redirect($this->view->rootUrl('/admin/contact/'));
                    break;
                case 'toggle_flag_selected':

                    $contact_db = new Model_DbTable_Contact();

                    foreach ($_POST['contact_item'] as $id)
                    {
                        $contacts = $contact_db->getAllById($id);
                        if (count($contacts) > 0)
                        {
                            $new_flag = (bool)$contacts[0]['flag'] ? '0' : '1';
                            $new_data = array('flag' => $new_flag);
                            $contact_db->updateContact($new_data, $id);
                            $this->loggingaction('contact', 'edit', $id);
                        }
                    }
                    $this->_redirect($this->view->rootUrl('/admin/contact/'));
                    break;
                case 'flag_selected':
                    $contact_db = new Model_DbTable_Contact();
                    foreach ($_POST['contact_item'] as $id)
                    {
                        $contacts = $contact_db->getAllById($id);
                        if (count($contacts) > 0)
                        {
                            $contact_db->updateContact(array('flag' => '1'), $id);
                            $this->loggingaction('contact', 'edit', $id);
                        }
                    }
                    $this->_redirect($this->view->rootUrl('/admin/contact/'));
                    break;
                case 'unflag_selected':
                    $contact_db = new Model_DbTable_Contact();
                    foreach ($_POST['contact_item'] as $id)
                    {
                        $contacts = $contact_db->getAllById($id);
                        if (count($contacts) > 0)
                        {
                            $contact_db->updateContact(array('flag' => '0'), $id);
                            $this->loggingaction('contact', 'edit', $id);
                        }
                    }
                    $this->_redirect($this->view->rootUrl('/admin/contact/'));
                    break;
                case '':
                    $this->_redirect($this->view->rootUrl('/admin/contact/'));
            }
        }
    }

}