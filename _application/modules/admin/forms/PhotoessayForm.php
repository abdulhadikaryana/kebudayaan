<?php 
class Admin_Form_PhotoessayForm extends Zend_Form
{
    public $photoessay_title;
    public $photoessay_description;
    
    public function init()
    {
        $this->photoessay_title = $this->createElement('text','photoessayTitle');
        $this->photoessay_title->removeDecorator('HtmlTag');
        $this->photoessay_title->removeDecorator('DtDdWrapper');
        $this->photoessay_title->removeDecorator('Label');
        $this->photoessay_title->setAttrib('class','wideele');

        $this->photoessay_description = $this->createElement('textarea','photoessayDescription');
        $this->photoessay_description->removeDecorator('HtmlTag');
        $this->photoessay_description->removeDecorator('DtDdWrapper');
        $this->photoessay_description->removeDecorator('Label');
        $this->photoessay_description->setAttrib('cols','50');
        $this->photoessay_description->setAttrib('rows','5');
    }
}