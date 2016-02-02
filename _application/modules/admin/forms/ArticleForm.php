<?php

class Admin_Form_ArticleForm
        extends Zend_Form
{
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $name;
  /**
   * 
   * @var Zend_Form_Element_Textarea
   */
  public $description;
  /**
   * 
   * @var Zend_Form_Element_Select
   */
  /**
   * 
   * @var Zend_Form_Element_File
   */
  public $image;
  /**
   * 
   * @var Zend_Form_Element_Submit
   */
  public $draft;
  /**
   * 
   * @var Zend_Form_Element_Submit
   */
  public $submit;

  public function init()
  {
    $this->setName('article');
    $this->setIsArray(true);

    $this->name        = new Zend_Form_Element_Text('name');
    $this->description = new Zend_Form_Element_Textarea('description');
    $this->image       = new Zend_Form_Element_File('image');
    $this->draft       = new Zend_Form_Element_Submit('draft');
    $this->submit      = new Zend_Form_Element_Submit('submit');

    $this->name->setRequired(true)
            ->setAttrib('class', 'span6')
            ->setAttrib('style', 'padding:10px;');

    $this->description->setRequired(true);

    $this->image->setRequired(true)
            ->setDestination(UPLOAD_FOLDER . 'article/')
            ->addValidator(new Zend_Validate_File_Extension('jpg,png'))
    ;

    $this->submit->setAttrib('class', 'btn btn-success');

    $this->draft->setAttrib('class', 'btn');


    $this->addElements(array(
        $this->name,
        $this->description,
        $this->image,
        $this->draft,
        $this->submit
    ));

    $this->setElementDecorators(array(
        'ViewHelper', 'Errors'
            ), array('image'), false);

    $this->image->setDecorators(array(
        'File'
    ));
  }

}