<?php
/**
 * RegistrationController
 *
 * Controller untuk melakukan fungsi2 untuk registrasi
 *
 * @package Front Controller
 */
class RegistrationController extends Budpar_Controller_Common
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
     * Desc: Fungsi untuk menampilkan halaman utama registrasi
     */
    public function indexAction()
    {
        // Variabel
        $request = $this->getRequest();

        // Form
        $form = new Form_RegistrationForm;

        // Request dari Form
        if($request->isPost()) {
            if($form->isValid($request->getPost())) {
                $this->_register($request);
                $form->reset();
            } 
        }

        // View
        $this->view->form = $form;
        $this->view->languageID = $this->_languageId;
    }

    /**
     * IS: Parameter email, key terdeklarasi
     * FS: Mengirimkan ke viewer: activateSuccess
     * Desc: Fungsi untuk melakukan aktivasi account
     */
    public function activateAction()
    {
        // Param
        $email = $this->_getParam('email');
        $key = $this->_getParam('key');

        // Model
        $userDb = new Model_DbTable_User;

        // Data
        $userId = $userDb->activateAccount($email, $key);

        $this->view->activateSuccess = true;
        
        $this->render('activate');
        //$this->_redirector->goToSimple('index', 'index');
    }

    /**
     * IS: Parameter oldPassword, newPassword, newPassword2 terdeklarasi
     * FS: -
     * Desc: Fungsi yang mengatur aksi untuk proses change password
     */
    public function changeAction()
    {
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            // Param
            $oldPassword = $this->_getParam('oldPassword');
            $newPassword = $this->_getParam('newPassword');
            $newPassword2 = $this->_getParam('newPassword2');

            // Form
            $form = new Form_ChangePasswordForm;

            // Model
            $userDb = new Model_DbTable_User;

            // Data
            $userId = $userDb->getUserById($this->_sess->userId);

            header('Cache-Control: no-cache');

            if($userId['password'] != md5($oldPassword)) {
                echo 'Your old password is incorrect';
            } elseif($newPassword != $newPassword2) {
                echo 'Your confirm password is not match';
            } else {
                $userDb->resetPass(md5($newPassword), $this->_sess->userId);
                echo 'success';
            }
        }
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: form, pageTitle
     * Desc: Fungsi yang mengatur aksi untuk proses forgot password
     */
    public function forgotAction()
    {
        // Variabel
        $request = $this->getRequest();

        // Form
        $form = new Form_ForgotPasswordForm;

        // Request dari Form
        if($request->isPost()) {
            if($form->isValid($request->getPost())) {
                $this->_forgotPassword();
                $form->reset();
            }
        }

        // View
        $this->view->pageTitle = 'Forgot Password';
        $this->view->form = $form;
        
    }

    /**
     * IS: Parameter key, email terdeklarasi
     * FS: Mengirimkan ke viewer: changeSuccess, form, pageTitle
     * Desc: Fungsi yang mengatur aksi untuk proses reset
     */
    public function resetAction()
    {
        $email = $this->_getParam('email');
        $activationKey = $this->_getParam('key');

        $userDb = new Model_DbTable_User;
        $user = $userDb->getUserByEmailActivationKey($email, $activationKey);

        if(count($user)) {
            $form = new Form_ResetPasswordForm;

            if($this->getRequest()->isPost()) {
                if($form->isValid($this->getRequest()->getPost())) {
                    $this->_resetPassword($user['user_id']);
                    $form->reset();

                    $this->view->changeSuccess = true;
                }
            } else {
                $form->email->setValue($email);
                $form->key->setValue($activationKey);
            }
        }

        $this->view->form = $form;
        $this->view->pageTitle = 'Change Password';

    }

    /**
     * IS: Parameter realname, email terdeklarasi
     * FS: Mengirimkan ke viewer: registerSuccess
     * Desc: Fungsi untuk melakukan proses registrasi seperti memasukkan data user
     * baru dan pengiriman email aktivasi
     * 
     * @param Zend_Request $request
     */
    private function _register($request)
    {
        // Model
        $userModel = new Model_User;

        // Data
        $activationKey = mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
        $activationMsg = $userModel->getActivationMessage(
                $this->view->baseUrl(),
                $this->_getParam('realname'),
                $this->_getParam('email'),
                $activationKey
            );

        // Send Email
        $fromName = 'Visit Indonesia';
        $fromEmail = 'noreply@indonesia.travel';
        $subject = 'Activation Required';
        $sendEmail = parent::_sendEmail($activationMsg,
            $fromName, $fromEmail, $subject, $this->_getParam('email'));

        if ($sendEmail) {
            // Model
            $userDb = new Model_DbTable_User;

            // Data insert
            $userDb->insertUser($request->getPost(), $activationKey);

            // View
            $this->view->registerSuccess = true;
        }
    }

    /**
     * IS: Parameter email terdeklarasi
     * FS: Mengirimkan ke viewer: forgotSuccess
     * Desc: Fungsi yang mengatur masalah lupa password
     */
    private function _forgotPassword()
    {
        $email = $this->_getParam('email');

        // Model
        $userModel = new Model_User;
        $userDb = new Model_DbTable_User;

        // Data
        $user = $userDb->getUser($email, null);
        $activationMsg = $userModel->getForgotMessage(
                $this->view->baseUrl(),
                $user[0]['name'] . ' (' . $user[0]['username'] . ')',
                $email,
                $user[0]['activationkey']
         );

        // Send Email
        $fromName = 'Visit Indonesia';
        $fromEmail = 'noreply@indonesia.travel';
        $subject = 'Reset your Visit Indonesia password';
        $sendEmail = parent::_sendEmail($activationMsg,
            $fromName, $fromEmail, $subject, $email);

        if ($sendEmail) {
            // View
            $this->view->forgotSuccess = true;
        }
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk mereset password
     */
    private function _resetPassword($userId)
    {
        $userDb = new Model_DbTable_User;

        $updateData = array(
            'password' => md5($this->_getParam('password'))
        );
        $userDb->updateUser($updateData, $userId);
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
                $title = $this->view->translate('id_menu_register');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
        }
        Zend_Registry::set('breadcrumb', $links);
    }
}
?>