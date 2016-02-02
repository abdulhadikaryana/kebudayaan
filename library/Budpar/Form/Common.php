<?php
/**
 * Budpar_Form_Common
 *
 * Merupakan parent class
 *
 * @package Budpar Library Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Budpar_Form_Common extends Zend_Form
{
    /**
     * Decorator table
     * Harus dideklarasi public untuk dapat digunakan
     * @var array
     */
    public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td')),
        array('Label', array('tag' => 'td', 'class' => 'first-td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );

    /**
     * Decorator table untuk button submit dengan menghilangkan label
     * Harus dideklarasi public untuk dapat digunakan
     * @var array
     */
    public $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')),
        array(array('label' => 'HtmlTag'),
            array('tag' => 'td', 'placement' => 'prepend')),
        array(array('row' => 'HtmlTag'),
            array('tag' => 'tr')));

    /**
     * Language id yang digunakan
     * @var integer
     */
    protected $_languageId;

    /**
     * Action Helper BaseUrl
     * @var Zend_Action_Helper
     */
    protected $_baseUrlHelper;

    /**
     * Variabel session zend
     * @var Zend_Session_Namespace
     */
    protected $_sess = null;

    protected $_translate;

    /**
     * Variabel session namespace untuk digunakan sebagai nama
     * session
     */
    const SESSION_NAMESPACE = 'budpar';  

    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        // Variabel
		$this->_languageId = (Zend_Registry::isRegistered('languageId')) ?
            Zend_Registry::get('languageId') : '';
        $this->_baseUrlHelper =
            Zend_Controller_Action_HelperBroker::getStaticHelper('BaseUrl');
		$this->_translate = (Zend_Registry::isRegistered('Zend_Translate')) ?
            Zend_Registry::get('Zend_Translate') : '';

        //$this->_translate = Zend_Registry::get('Zend_Translate');

        // Session
        $this->_sess = new Zend_Session_Namespace(self::SESSION_NAMESPACE);
    }
}