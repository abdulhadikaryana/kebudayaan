<?php
class Admin_Form_AirlinesForm extends Zend_Form
{
    
    public $linkName;
    public $linkWebsite;
    public $linkEmail;
    public $linkFax;
    public $linkCtr;
    public $linkDescription;
    public $linkTelephone;
    public $airlineImage;
   
    public function init()
    {
        $this->linkName= $this->createElement('text','linkName');
        $this->linkName->removeDecorator('HtmlTag');
        $this->linkName->removeDecorator('DtDdWrapper');
        $this->linkName->removeDecorator('Label');
        $this->linkName->setAttrib('class','mediumele');

        $this->linkWebsite= $this->createElement('text','linkWebsite');
        $this->linkWebsite->removeDecorator('HtmlTag');
        $this->linkWebsite->removeDecorator('DtDdWrapper');
        $this->linkWebsite->removeDecorator('Label');
        $this->linkWebsite->setAttrib('class','mediumele');

        $this->linkEmail= $this->createElement('text','linkEmail');
        $this->linkEmail->removeDecorator('HtmlTag');
        $this->linkEmail->removeDecorator('DtDdWrapper');
        $this->linkEmail->removeDecorator('Label');
        $this->linkEmail->setAttrib('class','mediumele');

        $this->linkFax= $this->createElement('text','linkFax');
        $this->linkFax->removeDecorator('HtmlTag');
        $this->linkFax->removeDecorator('DtDdWrapper');
        $this->linkFax->removeDecorator('Label');
        $this->linkFax->setAttrib('class','mediumele');

        $this->linkTelephone= $this->createElement('text','linkTelephone');
        $this->linkTelephone->removeDecorator('HtmlTag');
        $this->linkTelephone->removeDecorator('DtDdWrapper');
        $this->linkTelephone->removeDecorator('Label');
        $this->linkTelephone->setAttrib('class','mediumele');

        $this->linkDescription = $this->createElement('textarea','linkDescription');           
        $this->linkDescription->removeDecorator('HtmlTag');
        $this->linkDescription->removeDecorator('DtDdWrapper');
        $this->linkDescription->removeDecorator('Label');
        $this->linkDescription->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->airlineImage = $this->createElement('text','airlineImage');
        $this->airlineImage->removeDecorator('HtmlTag');
        $this->airlineImage->removeDecorator('DtDdWrapper');
        $this->airlineImage->removeDecorator('Label');
        $this->airlineImage->setAttrib('class','smallele');

        $this->linkCtr= $this->createElement('hidden','linkCtr');
        $this->linkCtr->removeDecorator('HtmlTag');
        $this->linkCtr->removeDecorator('DtDdWrapper');
        $this->linkCtr->removeDecorator('Label');
        $this->linkCtr->setAttrib('class','mediumele');

    }  
}