<?php 
class Admin_Form_EssayimageForm extends Zend_Form
{
    public $image_weight;
    public $image_description;
    public $image_file;
    
    public function init()
    {
        $this->image_description = $this->createElement('textarea','imageDescription');
        $this->image_description->removeDecorator('HtmlTag');
        $this->image_description->removeDecorator('DtDdWrapper');
        $this->image_description->removeDecorator('Label');
        $this->image_description->setAttrib('cols','50');
        $this->image_description->setAttrib('rows','5');

        $this->image_weight = $this->createElement('text','imageWeight');
        $this->image_weight->removeDecorator('HtmlTag');
        $this->image_weight->removeDecorator('DtDdWrapper');
        $this->image_weight->removeDecorator('Label');
        $this->image_weight->setAttrib('class','smallele');

        $this->image_file = $this->createElement('text','imageFile');
        $this->image_file->removeDecorator('HtmlTag');
        $this->image_file->removeDecorator('DtDdWrapper');
        $this->image_file->removeDecorator('Label');
        $this->image_file->setAttrib('class','smallele');    
	}
}