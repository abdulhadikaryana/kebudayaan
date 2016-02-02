<?php
/**
 * LoginController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan login
 *
 * @package Front Controller
 */
class LoginController extends Budpar_Controller_Common
{
    /**
     * IS: Parameter username, password, remember terdeklarasi
     * FS: Mengirimkan ke viewer: fail,
     *     Session berisi data userId dan username
     * Desc: Fungsi untuk login biasa
     */
    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        // Jika request ajax
        //if ($this->_request->isXmlHttpRequest()) {
            
            // Tidak menggunakan layout dan view
            $this->_helper->layout()->disableLayout();

            $loginForm = new Form_LoginForm;

            if($this->getRequest()->isPost()
                AND $loginForm->isValid($this->getRequest()->getPost())) {

                // Param
                $username = $this->_getParam('username');
                $password = $this->_getParam('password');
                $remember = $this->_getParam('remember');
                
                // Menggunakan auth adapter bawaan Zend
                $db = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($db, "user",
                                        'username', 'password');

                // Set username dan password
                $authAdapter->setIdentity($username);
                $authAdapter->setCredential(md5($password));

                // Authentikasi
                $result = $authAdapter->authenticate();

                // Jika ada
                if ($result->isValid()) {
                    // Menggunakan auth adapter bawaan Zend
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $authAdapter = new Zend_Auth_Adapter_DbTable($db, "user",
                                            'username', 'password', 'activationkey');

                    // Set username dan password
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential(md5($password));

                    // Authentikasi
                    $result = $authAdapter->authenticate();
                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                        array('user_id' , 'username', 'activationkey')));

                    $identity = $auth->getIdentity();

                    if($this->_hasParam('remember')) {
                        $expire = time() + 1728000; // 20 hari expired
                        $cookiePass = sha1( md5($password) . $identity->activationkey );

                        setcookie('budpar_userId', $identity->user_id, $expire, '/');
                        setcookie('budpar_user', $identity->username, $expire, '/');
                        setcookie('budpar_pass', $cookiePass, $expire, '/');
                    }

                    // Set Blacklist jika ada
                    $this->_setBlacklist($identity->user_id);

                    // Set nilai session
                    $this->_sess->userId = $identity->user_id;
                    $this->_sess->username = $identity->username;



                    //echo 'success';
                } else {
                    echo 'fail';
                    $this->view->fail = true;
                    $this->_sess->error = true;                
                    
                    }
            } else{
                echo 'fail';
                $this->view->fail = true;
            }

             $this->_redirector->gotoUrl($this->_sess->previousUri);
    }


    /**
     * IS: Session terdeklarasi
     * FS: Session kosong
     * Desc: Fungsi untuk logout
     */
    public function logoutAction()
    {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();

        Zend_Session::destroy(true);

        $this->_redirector->gotoUrl('/');
    }

    public function logoutcontributorAction()
    {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();

        Zend_Session::destroy(true);
        
        //$url = $this->_getParam('currentUrl');

        $this->_redirector->gotoUrl($this->view->baseUrl('/usercontributor/'));
    }

    /**
     * IS: Parameter userId terdeklarasi
     * FS: -
     * Desc: Fungsi untuk melakukan settingan blacklist
     */
}
?>