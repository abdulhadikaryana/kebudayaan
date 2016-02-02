<?php
/**
 * Form_DirSearchHome
 *
 * Form untuk pencarian direktori di halaman home
 *
 * TODO: - ga dipake lagi...dihapus aja deh
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_DirSearchHome extends Budpar_Form_Common
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
            'id' => 'dirSearchForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/directory/search',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form
        // -> Type
        $classDirectoryDb = new Model_DbTable_ClassificationDirectory;
        $classDirectory = $classDirectoryDb->getAllForMenu();
        $this->addElement('select', 'dirType', array(
            'decorators' => $this->elementDecorators,
            'label'       => 'Type',
            'multiOptions' => $classDirectory,
        ));

        // -> Name
        $this->addElement('text', 'dirName', array(
            'decorators' => $this->elementDecorators,
            'label'       => 'Name',
        ));

        // -> Location
        $this->addElement('text', 'dirLocation', array(
            'decorators' => $this->elementDecorators,
            'label'       => 'Location',
        ));
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

