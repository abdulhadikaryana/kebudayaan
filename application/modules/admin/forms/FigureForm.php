<?php

class Admin_Form_FigureForm
        extends Zend_Form
{
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $name;
  /**
   *
   * @var Zend_Form_Element_File
   */
  public $image;
  /**
   *
   * @var Zend_Form_Element_Textarea
   */
  public $description;
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
    $this->setName('figure');
    $this->setIsArray(true);

    $this->name        = new Zend_Form_Element_Text('name');
    $this->image       = new Zend_Form_Element_File('image');
    $this->description = new Zend_Form_Element_Textarea('description');
    $this->draft       = new Zend_Form_Element_Submit('draft');
    $this->submit      = new Zend_Form_Element_Submit('submit');

    $this->name->setRequired(true)
            ->setAttrib('class', 'span6');
    $this->description->setRequired(true);
    $this->draft->setAttrib('class', 'btn');
    $this->submit->setAttrib('class', 'btn btn-success');

    $this->image->addValidator(new Zend_Validate_File_Extension('jpg'))
//            ->addValidator(new Zend_Validate_File_ImageSize(array()))
    ;

    $this->addElements(array(
        $this->name,
        $this->image,
        $this->description,
        $this->draft,
        $this->submit
    ));

    $this->setElementDecorators(array(
        'ViewHelper',
        'Errors'), array('image'), false);

    $this->image->setDecorators(array(
        'File'));
  }

}