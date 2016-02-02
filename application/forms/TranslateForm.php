<?php

class Form_TranslateForm extends Zend_Form {

  public $name;
  public $description;
  public $submit;
  public $draft;

  public function init() {

    $this->name         = new Zend_Form_Element_Text('Name');
    $this->description  = new Zend_Form_Element_Textarea('Description');
    $this->submit       = new Zend_Form_Element_Submit('Submit');

    $this->name->setRequired(true)
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label');
    $this->description->setRequired(true)
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label');

    $this->submit->setAttrib('class', 'btn btn-success');
  }

}

?>