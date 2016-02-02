<?php

/**
 * ContactUsController
 *
 * Controller untuk melakukan fungsi2 untuk halaman contact us
 *
 * @package Front Controller
 */
class ContactUsController extends Budpar_Controller_Common {

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init() {
        parent::init();
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form
     * Desc: Fungsi untuk menampilkan halaman utama contact us
     */
    public function indexAction() {
        // Set layout
        $this->_helper->layout->setLayout('kebudayaan');

        // Variabel
        $request = $this->getRequest();

        // Form
        $form = new Form_ContactUsForm;

        // Request dari Form
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $contactDb = new Model_DbTable_Contact;
                $contactDb->insertContact($request->getPost());
                $this->view->submit = true;
                $form->reset();
            }
        }

        $this->view->headTitle()->prepend($this->view->translate('id_menu_contact'));

        $this->view->langId = $this->_languageId;
        $this->view->titlehead = $this->view->translate('id_menu_contact');
        $this->view->titleform = $this->view->translate('id_title_contactus');
        $this->view->bigPageTitle = $this->view->translate('id_menu_contact');
        $this->view->bgClass = 'red';

        // View
        $this->view->form = $form;
        $this->view->setAsConversionPage = true;
    }

}

?>