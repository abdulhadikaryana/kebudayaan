<?php
/**
 * Form_DestSearchHome
 *
 * Form untuk pencarian destinasi di halaman home
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_DestSearchHomeForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
     protected $name;
     protected $nameLabel;
     
    public function init()
    {
        parent::init();

        // Form Attribute
        $this->setMethod('get');
        $this->addAttribs(array(
            'id' => 'destSearchForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/destination/search',
        ));
        
        // Element Form
        // -> Name
        $this->name = $this->createElement('text', 'destName');
        $this->name->setAttrib('onkeypress', 'return onSearchKeyPress(event)')
             ->setDecorators($this->elementDecorators);
        $this->addElement($this->name);
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
    
    public function setNameLabel($label)
    {
        $this->name->setLabel($label);
    }
    
}

