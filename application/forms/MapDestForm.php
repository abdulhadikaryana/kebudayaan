<?php
/**
 * Form_MapLocationForm
 *
 * Form untuk memilih lokasi di halaman map
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_MapDestForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId == 2){
            $textsearch = 'See Location';
        }
        else{
            $textsearch = 'Lihat Lokasi';
        }
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'mapDestForm',
            'action' => '',
            'accept-charset' => 'utf-8',
        ));

        // -> Name
        $province = $this->createElement('text', 'searchname');
        $province->setLabel('searchname')
                 ->setDecorators($this->buttonDecorators);
        $this->addElement($province);

        // -> Submit
        $submit = $this->createElement('submit', 'submittext');
        $submit->setLabel($textsearch)
               ->setDecorators($this->buttonDecorators);
        $submit->setAttrib('class', 'button button-grey');
        $this->addElement($submit);
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

