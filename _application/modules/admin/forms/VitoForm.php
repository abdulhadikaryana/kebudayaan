<?php
class Admin_Form_VitoForm extends Zend_Form
{
    public $TourismOperatorPhone;
    public $TourismOperatorWebsite;
    public $TourismOperatorEmail;
    public $TourismOperatorArea;
    public $TourismOperatorFax;
    public $TourismOperatorAddress;
    public $TourismOperatorLangName;
    public $TourismOperatorRegion;
    
    public function init()
    {
        $table_classification = new Model_DbTable_Classification;
        $table_area = new Model_DbTable_Area;

        $this->TourismOperatorArea = $this->createElement('hidden','TourismArea');
        $this->TourismOperatorArea->removeDecorator('HtmlTag');
        $this->TourismOperatorArea->removeDecorator('DtDdWrapper');
        $this->TourismOperatorArea->removeDecorator('Label');
        $this->TourismOperatorArea->setValue(0);

        $this->TourismOperatorFax = $this->createElement('text','TourismOperatorFax');
        $this->TourismOperatorFax->removeDecorator('HtmlTag');
        $this->TourismOperatorFax->removeDecorator('DtDdWrapper');
        $this->TourismOperatorFax->setAttrib('class','mediumele');
        $this->TourismOperatorFax->removeDecorator('Label');

        $this->TourismOperatorEmail = $this->createElement('text','TourismOperatorEmail');
        $this->TourismOperatorEmail->removeDecorator('HtmlTag');
        $this->TourismOperatorEmail->removeDecorator('DtDdWrapper');
        $this->TourismOperatorEmail->removeDecorator('Label');
        $this->TourismOperatorEmail->setAttrib('class','mediumele');
        $this->TourismOperatorEmail->setAttrib('class','tableFormInputNormal');

        $this->TourismOperatorLangName = $this->createElement('text','TourismOperatorLangName');
        $this->TourismOperatorLangName->removeDecorator('HtmlTag');
        $this->TourismOperatorLangName->setAttrib('class','mediumele');
        $this->TourismOperatorLangName->removeDecorator('DtDdWrapper');
        $this->TourismOperatorLangName->removeDecorator('Label');

        $this->TourismOperatorPhone = $this->createElement('text','TourismOperatorPhone');
        $this->TourismOperatorPhone->removeDecorator('HtmlTag');
        $this->TourismOperatorPhone->removeDecorator('DtDdWrapper');
        $this->TourismOperatorPhone->setAttrib('class','mediumele');
        $this->TourismOperatorPhone->removeDecorator('Label');

        $this->TourismOperatorWebsite = $this->createElement('text','TourismOperatorWebsite');
        $this->TourismOperatorWebsite->removeDecorator('HtmlTag');
        $this->TourismOperatorWebsite->removeDecorator('DtDdWrapper');
        $this->TourismOperatorWebsite->removeDecorator('Label');
        $this->TourismOperatorWebsite->setAttrib('class','mediumele');
        
        $this->TourismOperatorAddress = $this->createElement('textarea','TourismOperatorAddress');           
        $this->TourismOperatorAddress->removeDecorator('HtmlTag');
        $this->TourismOperatorAddress->removeDecorator('DtDdWrapper');
        $this->TourismOperatorAddress->removeDecorator('Label');
        $this->TourismOperatorAddress->setAttribs(array('cols' => 20, 'rows' => 5));

        $this->TourismOperatorRegion = $this->createElement('text','TourismOperatorRegion');           
        $this->TourismOperatorRegion->removeDecorator('HtmlTag');
        $this->TourismOperatorRegion->removeDecorator('DtDdWrapper');
        $this->TourismOperatorRegion->removeDecorator('Label');
        $this->TourismOperatorRegion->setAttrib('class','mediumele');
    }
}