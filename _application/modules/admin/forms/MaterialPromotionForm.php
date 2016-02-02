<?php
class Admin_Form_MaterialPromotionForm extends Zend_Form
{
    
    public $materialTitle;
    public $materialDescription;
    public $materialUrl;
    public $materialName;
    public $materialCtr;
    
    public function init()
    {
        $this->materialTitle = $this->createElement('text','materialTitle');
        $this->materialTitle->removeDecorator('HtmlTag');
        $this->materialTitle->removeDecorator('DtDdWrapper');
        $this->materialTitle->removeDecorator('Label');
        $this->materialTitle->setAttrib('class','mediumele');

        $this->materialName = $this->createElement('text','materialName');
        $this->materialName->removeDecorator('HtmlTag');
        $this->materialName->removeDecorator('DtDdWrapper');
        $this->materialName->removeDecorator('Label');
        $this->materialName->setAttrib('class','mediumele');
     
        $this->materialDescription = $this->createElement('textarea','materialDescription');           
        $this->materialDescription->removeDecorator('HtmlTag');
        $this->materialDescription->removeDecorator('DtDdWrapper');
        $this->materialDescription->removeDecorator('Label');
        $this->materialDescription->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->materialUrl= $this->createElement('text','materialUrl');
        $this->materialUrl->removeDecorator('HtmlTag');
        $this->materialUrl->removeDecorator('DtDdWrapper');
        $this->materialUrl->removeDecorator('Label');
        $this->materialUrl->setAttrib('class','mediumele');

        $this->materialCtr= $this->createElement('hidden','materialCtr');
        $this->materialCtr->removeDecorator('HtmlTag');
        $this->materialCtr->removeDecorator('DtDdWrapper');
        $this->materialCtr->removeDecorator('Label');
        $this->materialCtr->setAttrib('class','mediumele');
    }  
}