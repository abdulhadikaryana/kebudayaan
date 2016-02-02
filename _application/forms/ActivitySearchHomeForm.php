<?php
/**
 * Form_ActivitySearchHome
 *
 * Form untuk pencarian destinasi berdasarkan aktivitas di halaman home
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ActivitySearchHomeForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        
        // Form Attribute
        $this->setMethod('get');
        $this->addAttribs(array(
            'id' => 'activitySearchForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/destination/search',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // -> Activities
        $categoryDb = new Model_DbTable_Category;
        $category = $categoryDb->getAllButNotMainCategoryForForm($this->_languageId);
        
        $activity = $this->createElement('select', 'destActivity');
        $activity->setLabel('Activity')
                 ->setMultiOptions($category)
                 ->setDecorators($this->elementDecorators);
        $this->addElement($activity);
    }

    /**
     * Fungsi untuk load default decorator
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}

