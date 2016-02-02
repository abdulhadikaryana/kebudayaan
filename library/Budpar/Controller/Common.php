<?php/** * Budpar_Controller_Common * * Merupakan parent class * * @package Budpar Library * @copyright Copyright (c) 2010 Sangkuriang Studio * @author Sangkuriang Studio <www.sangkuriangstudio.com> */class Budpar_Controller_Common extends Zend_Controller_Action {    protected $_meta = array(        "kebudayaan indonesia",        "kebudayaan",        "budaya indonesia",        "budaya",        "indonesia",    );    /**     * Variabel session zend     * @var Zend_Session_Namespace     */    protected $_sess = null;    /**     * Variabel flash messenger zend     * @var Zend_Helper_FlashMessenger     */    protected $_flash = null;    /**     * Variabel redirector     * @var Zend_Helper_Redirector     */    protected $_redirector = null;    /**     * Variabel language id yang sedang digunakan     * @var integer     */    protected $_languageId = null;    /**     * Variabel untuk menyimpan constructor Facebook Connect.     * Constructor disimpan di login controller     * @var facebook     */    protected $_fb = null;    /**     * Variabel session namespace untuk digunakan sebagai nama     * session     */    const SESSION_NAMESPACE = 'budpar';    /**     * Variabel nama module untuk menghilangkan error pada admin karena     * pada admin registri tidak di set      */    protected $_moduleName = '';    /**     * Fungsi inisialisasi     */    public function init() {        // Assign variabel        $this->_sess = new Zend_Session_Namespace(self::SESSION_NAMESPACE);        $this->_flash = $this->_helper->FlashMessenger;        $this->_redirector = $this->_helper->getHelper('Redirector');        $this->_languageId = Zend_Registry::get('languageId');        // Pemanggilan method inisialisasi        $this->_initLanguage();        $this->_initHighlight();        $this->_initFacebookConnect();        $this->_initPreviousUri();        $this->_moduleName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();        $this->view->moduleName = $this->_moduleName;//        echo $this->_moduleName;exit;        // Breadcrumb        $this->_generateBreadcrumb();        // Title dari website        // Nama controller        $this->view->controller = Zend_Controller_Front::getInstance()->getRequest()                ->getControllerName();        // Nama action        $this->view->action = Zend_Controller_Front::getInstance()->getRequest()                ->getActionName();        $this->view->sess = $this->_sess;        //generate header image        $highlightDb = new Model_DbTable_Highlight;        $highlight = $highlightDb->getMainType(3, $this->_languageId);        $this->view->imageData = $highlight;        // Untuk munculin list kategori di menu        $categoryDb = new Model_Category;        $categories = $categoryDb->getAllHierarchyByLanguage();        $this->view->categories = $categories;        $this->view->headTitle('Kebudayaan Indonesia');        $partnerDb = new Model_DbTable_Partner;//        Data        $partner = $partnerDb->getAllWithDesc($this->_languageId);        $partner = $partnerDb->fetchAll($partner);        $this->view->partner = $partner->toArray();//        echo '<pre>';//        print_r($categories);    }    /**     * Fungsi untuk generate breadcrumb. Fungsi ini akan di-override sama     * controller anak2nya. Disengaja untuk dikosongin     */    protected function _generateBreadcrumb() {            }    /**     *  Fungsi untuk mengirim email menggunakan Zend Mail dengan cara     *  melalui SMTP     *     *  @param $htmlMsg isi dari email dalam format HTML     *  @param $email alamat email     *  @return boolean bisa terkirim atau tidak     *     */    protected function _sendEmail($msg, $fromName, $fromEmail, $subject, $toEmail) {        // Inisialisasi Zend_Mail_Transport        $transport = new Zend_Mail_Transport_Smtp(SMTP_HOST, Array(            //'auth' => 'login',            //'username' => SMTP_USERNAME,            //'password' => SMTP_PASSWORD,            'port' => 25,        ));        $transport->EOL = "\r\n";        Zend_Mail::setDefaultTransport($transport);        // Buat Zend_Mail properti        $mail = new Zend_Mail();        $mail->setFrom($fromEmail, $fromName);        $mail->setSubject($subject);        // Cek email tujuan        if (is_array($toEmail)) {            for ($i = 0; $i < count($toEmail); $i++) {                $mail->addTo($toEmail[$i]);            }        } else {            $mail->addTo($toEmail);        }        $mail->setBodyHtml($msg, 'UTF-8', Zend_Mime::ENCODING_8BIT);        // Kirim email-nya        $isSend = false;        try {            if (!$mail->send()) {                throw new Exception("Error occurred sending message");            } else {                $isSend = true;            }        } catch (Exception $e) {            print $e->getMessage();            exit();        }        return $isSend;    }    /**     * Fungsi untuk membuat paginator     *     * @param Zend Select $select sql dari Zend     * @param int $countPerPage berapa total item per halamannya     * @param int $pageRange range dari halaman yang dimunculkan di paginasi     *     * @return Zend_Paginator paginator     */    protected function setPaginator($select, $countPerPage = 6, $pageRange = 5) {        $paginator = Zend_Paginator::factory($select);        $pagenumber = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;        $paginator->setCurrentPageNumber($pagenumber);        $paginator->setItemCountPerPage($countPerPage);        $paginator->setPageRange($pageRange);        return $paginator;    }    /**     * Fungsi untuk inisialisasi language untuk digunakan di pilihan     * bahasa serta inisialisasi beberapa variabel berkaitan dengan language     */    private function _initLanguage() {        // Param        $languageName = $this->_getParam('language');        // Model        $languageDb = new Model_DbTable_Language;        // Data        $language = $languageDb->getLangNameArrayWithCache();        // View        $this->view->language = $language;        $this->view->selectedLanguage = Zend_Registry::get('language');    }    /**     * Fungsi untuk generate highlight di sidebar     */    private function _initHighlight() {        // Model        $highlightDb = new Model_DbTable_Highlight;        // Data        $highlight = $highlightDb->getMain($this->_languageId);        $smallhighlight = $highlightDb->getSmallHighlight($this->_languageId);        // View        $this->view->highlightImage = $highlight;        $this->view->smallHighlight = $smallhighlight;    }    /**     * Fungsi untuk inisialisasi object Facebook     */    private function _initFacebookConnect() {        // FBconnect        //$fb = new Facebook(Zend_Registry::get('fb_api_key'),        //Zend_Registry::get('fb_app_secret'));        $fb = new Facebook(array(            'appId' => Zend_Registry::get('fb_app_id'),            'secret' => Zend_Registry::get('fb_app_secret'),            'cookie' => true,        ));        $this->_fb = $fb;        $this->view->fb = $fb;    }    /**     * Fungsi untuk inisialisasi previous dan current URI yang digunakan     * untuk redirect back ke halaman sebelum user login/register     */    private function _initPreviousUri() {        // Default previous uri        if (!isset($this->_sess->previousUri)) {            $this->_sess->previousUri = '/';        }        // Set previous uri        if (isset($this->_sess->currentUri)                AND ! preg_match("/\/login*/", $this->_sess->currentUri)                AND ! preg_match("/\/registration*/", $this->_sess->currentUri)                AND ! preg_match("/\/ajax*/", $this->_sess->currentUri)        ) {            $this->_sess->previousUri = $this->_sess->currentUri;        }        $this->_sess->currentUri = $this->view->currentUrl();        $this->view->currentUri = $this->view->currentUrl();    }    protected function norenderView() {        $this->_helper->viewRenderer->setNoRender();    }    protected function disableView() {        $this->_helper->viewRenderer->setNoRender();        $this->_helper->getHelper('layout')->disableLayout();    }    protected function disableLayout() {        $this->_helper->layout()->disableLayout();    }    protected function setLayout($layout = '') {        $this->_helper->layout->setLayout($layout);    }}