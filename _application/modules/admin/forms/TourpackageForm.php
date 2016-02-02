<?php 
class Admin_Form_TourpackageForm extends Zend_Form
{
    public $packWebsite;
    public $packContact;
    public $packTitle;
    public $packDescription;

    public function init()
    {
        $this->packWebsite = $this->createElement('text','packWebsite');           
        $this->packWebsite->removeDecorator('HtmlTag');
        $this->packWebsite->removeDecorator('DtDdWrapper');
        $this->packWebsite->removeDecorator('Label');
        $this->packWebsite->setAttrib('class','mediumele');        

        $this->packContact = $this->createElement('text','packContact');           
        $this->packContact->removeDecorator('HtmlTag');
        $this->packContact->removeDecorator('DtDdWrapper');
        $this->packContact->removeDecorator('Label');
        $this->packContact->setAttrib('class','mediumele');
        
        $this->packTitle = $this->createElement('text','packTitle');           
        $this->packTitle->removeDecorator('HtmlTag');
        $this->packTitle->removeDecorator('DtDdWrapper');
        $this->packTitle->removeDecorator('Label');
        $this->packTitle->setAttrib('class','mediumele');

        $this->packDescription = $this->createElement('textarea','packDescription');           
        $this->packDescription->removeDecorator('HtmlTag');
        $this->packDescription->removeDecorator('DtDdWrapper');
        $this->packDescription->removeDecorator('Label');
        $this->packDescription->setAttribs(array('cols' => 5, 'rows' => 5));

    }
}