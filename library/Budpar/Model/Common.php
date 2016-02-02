<?php
/**
 * Budpar_Model_Common
 *
 * Merupakan parent class model
 *
 * @package Budpar Library Model
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Budpar_Model_Common
{
    /**
     * Language id yang digunakan
     * @var integer
     */
    protected $_languageId;

    /**
     * Fungsi inisialisasi
     */
    public function __construct()
    {
        // Variabel
        $this->_languageId = (Zend_Registry::isRegistered('languageId')) ?
            Zend_Registry::get('languageId') : '';
    }
}