<?php

class Admin_Form_PartnerForm
        extends Zend_Form
{
  /**
   *
   * @var Zend_Form_Element_Hidden
   */
  public $id;
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $name;
  /**
   *
   * @var Zend_Form_Element_File
   */
  public $logo;
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $website;
  /**
   *
   * @var Zend_Form_Element_Textarea
   */
  public $description;
  /**
   * 
   * @var Zend_Form_Element_Hidden
   */
  public $language_id;
  /**
   * 
   * @var Zend_Form_Element_Submit
   */
  public $submit;

  public function init()
  {
    $this->setName('partner');
    $this->setIsArray(true);

    $this->id          = new Zend_Form_Element_Hidden('id');
    $this->language_id = new Zend_Form_Element_HIdden('language_id');
    $this->name        = new Zend_Form_Element_Text('name');
    $this->logo        = new Zend_Form_Element_File('logo');
    $this->website     = new Zend_Form_Element_Text('website');
    $this->description = new Zend_Form_Element_Textarea('description');
    $this->submit      = new Zend_Form_Element_Submit('submit');

    $this->name->setRequired(true)
            ->setAttribs(array(
                'class'       => 'span6',
                'placeholder' => 'Tulis nama partner disini...',
                'style'       => 'font-size: 16px;font-weight:normal;font-family:Helvetica;padding:5px 10px'
            ));

    $this->website->addValidator(new Budpar_Form_Validator_Url())
            ->setAttribs(array(
                'class'       => 'span11',
                'placeholder' => 'http://www.example.com'
            ));

    $this->logo
            ->setDestination(UPLOAD_FOLDER . 'partners-logo')
            ->addValidator(new Zend_Validate_File_Extension('jpg, png'));

    $this->description->setRequired(true)
            ->setAttribs(array(
                'cols' => 100,
                'rows' => 20
            ));
    
    $this->submit->setLabel('Simpan');
    $this->submit->setAttrib('class', 'btn btn-success');
    

    $this->addElements(array(
        $this->id,
        $this->language_id,
        $this->name,
        $this->logo,
        $this->website,
        $this->description,
        $this->submit
    ));

    $this->setElementDecorators(array('ViewHelper', 'Errors'),
                                array('logo'), false);
    $this->logo->setDecorators(array('file'));
  }

}