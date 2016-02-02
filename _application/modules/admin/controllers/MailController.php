<?php
/**
 * MailController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - mail/inbox
 */
require_once 'Zend/Controller/Action.php';

class Admin_MailController extends Library_Controller_Backend
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
     * Desc: Mengatur aksi yang dilakukan untuk halaman index mail
     */
	public function indexAction() 
	{
        /** User admin on current session */
        $session_user = '*' . $this->_userInfo->name . '*';
        
        /** Send this page url to the view */
        $this->view->cleanurl = $this->_cleanUrl;

        /** Get messages from CRUD process */
        $message = $this->_flash->getMessages();
        if (!empty($message)) {
            $this->view->message = $message;
        }
        
        /** Create table instance */
        $table_mail = new Model_DbTable_Mail;
        $select = $table_mail->getAllMailByRecipient($session_user);
        
        /** Get page row setting and send to the paginator control */
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;
        
		if ($page_row != null) {
    		$paginator = parent::setPaginator($select, $page_row);
        } else {
    		$paginator = parent::setPaginator($select);
        }
        
        /** Send data to the view */
		$this->view->paginator = $paginator;
	}
    
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        /** User admin on current session */
        $session_user = '*' . $this->_userInfo->name . '*';
        
        $form = new Admin_Form_MailForm;
        $table_mail = new Model_DbTable_Mail;
                        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                /** Preparing the date insert */
                date_default_timezone_set('Asia/Jakarta');
                $current = date("Y-m-d H:i:s", time());
                $content = htmlspecialchars($_POST['mailContent'], ENT_QUOTES);

                $recipient_array = explode(',', $_POST['mailRecipient']);
                foreach ($recipient_array as $key => $value) {
                    $edited_recipient .= "*" . trim($value) . "*,";
                };
                
                $data = array(
                    'date' => $current,
                    'from' => $session_user,
                    'to' => $edited_recipient,
                    'content' => $content,
                    'subject' => $_POST['mailSubject'],
                    'status' => 0,
                );
              
                $mail_id = $table_mail->insertMail($data);
                
                if (!empty($mail_id)) {
                    $this->_flash->addMessage("1\Mail Sent!");
                } else {
                    $this->_flash->addMessage("2\Mail Sending Failed!");
                }
                $this->_redirect($this->view->rootUrl('/admin/mail/'));
            }
        } 
        $this->view->form = $form;
    }
    
    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman read/reply
     */
    public function readreplyAction()
    {
        /** User admin on current session */
        $session_user = '*' . $this->_userInfo->name . '*';
        
        $mail_id = $this->_getParam('id');
        $form = new Admin_Form_MailForm;
        $table_mail = new Model_DbTable_Mail;
        $table_mail->updateMail(array('status' => 1), $mail_id);
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                /** Preparing the date insert */
                date_default_timezone_set('Asia/Jakarta');
                $current = date("Y-m-d H:i:s", time());
                $content = htmlspecialchars($_POST['mailContent'], ENT_QUOTES);
                
                $recipient_array = explode(',', $_POST['mailRecipient']);
                foreach ($recipient_array as $key => $value) {
                    $edited_recipient .= "*" . trim($value) . "*,";
                };

                $data = array(
                    'date' => $current,
                    'from' => $session_user,
                    'to' => $edited_recipient,
                    'content' => $content,
                    'subject' => $_POST['mailSubject'],
                    'status' => 0,
                );
                
                $check = $table_mail->insertMail($data);
                
                if (!empty($check)) {
                    $this->_flash->addMessage("1\Mail Reply Sent!");
                } else {
                    $this->_flash->addMessage("2\Mail Sending Failed!");
                }
                $this->_redirect($this->view->rootUrl('/admin/mail/'));
            }
        }
        
        $data = $table_mail->getMailById($mail_id);
        $content_array = 
            explode("----------------------", $data['content']);
        $content_last = array_pop($content_array);
        foreach ($content_array as $key => $value) {
            $new_content .= $value . "----------------------"; 
        };
        $edited_content = $new_content 
            . "<br/>[" . $data['date'] ."] " . trim($session_user, '*') . " wrote: " 
            . $content_last
            . "----------------------";
            
        $form->mailRecipient->setValue(trim($data['from'], '*'));
        $form->mailSubject->setValue("Re: " . $data['subject']);
        $form->mailContent->setValue($this->view->HtmlDecode($edited_content));
        $this->view->form = $form;
    }
}
?>