<?php

/**
 * ContactUsController
 *
 * Controller untuk melakukan fungsi2 untuk halaman contact us
 *
 * @package Front Controller
 */
class ContactUsController extends Budpar_Controller_Common
{
  /**
   * IS: -
   * FS: -
   * Desc: Fungsi inisialisasi
   */
  public function init()
  {
    parent::init();
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Fungsi untuk menampilkan halaman utama contact us
   */
  public function indexAction()
  {
    // Set layout
    $this->_helper->layout->setLayout('kebudayaan');

    // Variabel
    $request = $this->getRequest();

    // Form
    $form = new Form_ContactUsForm;

    // Request dari Form
    if ($request->isPost()) {
      if ($form->isValid($request->getPost())) {
        $this->_sendMessage($request);
        $form->reset();
      }
    }
    $this->view->langId = $this->_languageId;
    $this->view->titlehead = $this->view->translate('id_menu_contact');
    $this->view->titleform = $this->view->translate('id_title_contactus');
    $this->view->bigPageTitle = $this->view->translate('id_menu_contact');
    $this->view->bgClass = 'red';
    
    // View
    $this->view->form = $form;
    $this->view->setAsConversionPage = true;
  }

  /**
   * IS: Parameter name, email, subject terdeklarasi
   * FS: Mengirimkan ke viewer: success
   * Desc: Fungsi untuk melakukan mengirimkan email kepada administrator dan
   *       melakukan penyimpanan data di tabel Contact
   * 
   * @param Zend_Request $request
   */
  private function _sendMessage($request)
  {
    // Model
    $contactSubject = new Model_DbTable_ContactSubject;
    $contactDb = new Model_DbTable_Contact;

    // Data
    $fromName = $this->_getParam('name');
    $fromEmail = $this->_getParam('email');
    $subject = '[Budaya Indonesia] New comment with topic: ' .
            $contactSubject->getNameById($this->_getParam('subject'));
    if (APPLICATION_ENV == 'development') {
      $to = array('deerawan@gmail.com');
    }
    // Jika email tidak diblacklist
    //$sendEmail = parent::_sendEmail($msg, $fromName, $fromEmail, $subject, $to);
    $contactDb->insertContact($request->getPost());
    $this->view->success = true;

//    if ($sendEmail) {
      // Masukkan data ke tabel
//    }
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: pageTitle
   * Desc: Fungsi untuk generate breadcrumb
   */
  protected function _generateBreadcrumb()
  {
    $texthomelink = $this->view->translate('id_menu_home');

    $links = null;
    switch ($this->_request->getActionName()) {
      case 'index':
      default:
        $title = $this->view->translate('id_menu_contact');
        $links = array(
            $texthomelink          => $this->view->baseUrl('/'),
            $title                 => '',
        );
        $this->view->pageTitle = $title;
    }
    Zend_Registry::set('breadcrumb', $links);
  }

}
?>