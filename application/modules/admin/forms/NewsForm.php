<?php

class Admin_Form_NewsForm
        extends Zend_Form
{
  /**
   *
   * @var Zend_Form_Element_File
   */
  public $image;
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $publish_date;
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
  /**
   *
   * @var Zend_Form_Element_Text
   */
  public $title;
  /**
   *
   * @var Zend_Form_Element_Textarea
   */
  public $content;

  public function init()
  {

    $this->setName('news');
    $this->setIsArray(true);

    $this->title        = new Zend_Form_Element_Text('title');
    $this->content      = new Zend_Form_Element_Textarea('content');
    $this->image        = new Zend_Form_Element_File('image');
    $this->publish_date = new Zend_Form_Element_Text('publish_date');
    $this->draft        = new Zend_Form_Element_Submit('draft');
    $this->submit       = new Zend_Form_Element_Submit('submit');

    $this->title->setRequired(true)
            ->setAttrib('class', 'span6');
    $this->content->setRequired(true);
    $this->publish_date->setRequired(true)
            ->addValidator(new Zend_Validate_Date(array(
                        'format' => 'dd-mm-yy')));
    $this->draft->setAttrib('class', 'btn');
    $this->submit->setAttrib('class', 'btn btn-success');

    $this->addElements(array(
        $this->image, $this->publish_date, $this->draft,
        $this->submit, $this->title, $this->content));

    $this->setElementDecorators(array(
        'ViewHelper',
        'Errors',
            ), array('image'), false);

    $this->image->setDecorators(array(
        'File'));
  }

}