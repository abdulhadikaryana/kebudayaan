<?php

/**
 * Budpar_Controller_Plugin_Language
 *
 * Kelas Front Controller Plugin untuk inisialisasi bahasa dan translation
 *
 * @package Budpar Library
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Budpar_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract {

    public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        $useModule = array('default', 'mice');

        if (in_array($request->getModuleName(), $useModule)
                AND
                $this->getRequest()->getParam('language') != 'scripts') {
            Zend_Db_Table_Abstract::setDefaultAdapter(Zend_Registry::get('read'));
        } else {
            Zend_Db_Table_Abstract::setDefaultAdapter(Zend_Registry::get('write'));
        }

        if (in_array($request->getModuleName(), $useModule)
                AND
                $this->getRequest()->getParam('language') != 'scripts') {
            $language = $this->getRequest()->getParam('language');
            if (empty($language)) {
                $language = 'id';
            }

            // Model
            $dictionaryDb = new Model_DbTable_Dictionary;
            $languageDb = new Model_DbTable_Language;

            // Data
            $dictionary = $dictionaryDb->getDictionaryArray($language);
            $languageId = $languageDb->getIdByName($language);

            try {
                // Translator Zend
                $translate = new Zend_Translate('array', $dictionary, $language);

                // Set registry
                Zend_Registry::set('Zend_Translate', $translate);
                Zend_Registry::set('language', $language);
                Zend_Registry::set('languageId', $languageId['language_id']);
                Zend_Registry::set('languageText', $languageId['language_text']);
            } catch (Zend_Translate_Exception $zte) {
                
            } catch (Zend_Exception $ze) {
                
            }
        }
    }

}
