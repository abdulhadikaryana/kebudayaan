<?php

class Admin_Form_GalleryForm extends Zend_Form {

    /**
     *
     * @var Zend_Form_Element_Hidden
     */
    public $id;

    /**
     *
     * @var Zend_Form_Element_Text
     */
    public $source;

    /**
     *
     * @var Zend_Form_Element_Text
     */
    public $caption;

    /**
     *
     * @var Zend_Form_Element_Text
     */
    public $caption_en;

    /**
     *
     * @var Zend_Form_Element_File
     */
    public $image;

    /**
     * 
     * @var Zend_Form_Element_Submit
     */
    public $submit;

    public function init() {
        $this->setName('gallery');
        $this->setIsArray(true);

        $this->id = new Zend_Form_Element_Hidden('id');
        $this->source = new Zend_Form_Element_Text('source');
        $this->caption = new Zend_Form_Element_Textarea('caption');
        $this->caption_en = new Zend_Form_Element_Textarea('caption_en');
        $this->image = new Zend_Form_Element_File('image');
        $this->submit = new Zend_Form_Element_Submit('submit');


        $this->source->setAttribs(array(
            'class' => 'span6'
        ));

        $this->caption->setRequired(true)
                ->setAttribs(array(
                    'class' => 'span6',
                    'rows' => 3,
                    'style' => 'height:auto;font-size: 16px;font-weight:normal;font-family:Helvetica;padding:5px 10px'
        ));

        $this->caption_en->setRequired(true)
                ->setAttribs(array(
                    'class' => 'span6',
                    'rows' => '3',
                    'style' => 'height:auto;font-size: 16px;font-weight:normal;font-family:Helvetica;padding:5px 10px'
        ));

        $this->image
                ->setDestination(UPLOAD_FOLDER . 'gallery')
                ->addValidator(new Zend_Validate_File_Extension('jpg, png'));

        $this->submit->setLabel('Simpan');
        $this->submit->setAttrib('class', 'btn btn-success');

        $this->addElements(array(
            $this->id,
            $this->source,
            $this->caption,
            $this->caption_en,
            $this->image,
            $this->submit
        ));

        $this->setElementDecorators(array('ViewHelper', 'Errors'), array('image'), false);
        $this->image->setDecorators(array('file'));
    }

}
