<?php
class Admin_Form_TourismOperatorForm extends Zend_Form
{
    public $TourismOperatorPhone;
    public $TourismOperatorWebsite;
    public $TourismOperatorEmail;
    public $TourismOperatorClassification;
    public $TourismOperatorPOI;
    public $TourismOperatorArea;
    public $TourismOperatorStar;
    public $TourismOperatorFax;
    public $Pointx;
    public $Pointy;
    public $TourismOperatorAddress;
    public $TourismOperatorLangName;
    public $TourismOperatorDescription;
    public $ClassificationSelect;
    public $AreaSelect;
    public $RelatedPoiSelect;
    public $Count_class;
    public $Class_counter;
    public $Island_Select;
    
    public function init()
    {
        $table_classification = new Model_DbTable_Classification;
        $table_area = new Model_DbTable_Area;
    
        $this->Count_class = $this->createElement('hidden','MaxClass');
        $this->Count_class->removeDecorator('HtmlTag');
        $this->Count_class->removeDecorator('DtDdWrapper');
        $this->Count_class->removeDecorator('Label');
        $this->Count_class->setValue(0);

        $this->TourismOperatorArea = $this->createElement('hidden','TourismArea');
        $this->TourismOperatorArea->removeDecorator('HtmlTag');
        $this->TourismOperatorArea->removeDecorator('DtDdWrapper');
        $this->TourismOperatorArea->removeDecorator('Label');
        $this->TourismOperatorArea->setValue(0);

        $this->Class_counter = $this->createElement('hidden','ClassCounter');
        $this->Class_counter->removeDecorator('HtmlTag');
        $this->Class_counter->removeDecorator('DtDdWrapper');
        $this->Class_counter->removeDecorator('Label');
        $this->Class_counter->setValue(0);
        
        $this->TourismOperatorFax = $this->createElement('text','TourismOperatorFax');
        $this->TourismOperatorFax->removeDecorator('HtmlTag');
        $this->TourismOperatorFax->removeDecorator('DtDdWrapper');
        $this->TourismOperatorFax->setAttrib('class','mediumele');
        $this->TourismOperatorFax->removeDecorator('Label');
        
        $this->TourismOperatorStar = $this->createElement('text','TourismOperatorStar');
        $this->TourismOperatorStar->removeDecorator('HtmlTag');
        $this->TourismOperatorStar->removeDecorator('DtDdWrapper');
        $this->TourismOperatorStar->setAttrib('class','smallele');
        $this->TourismOperatorStar->removeDecorator('Label');
        $this->TourismOperatorStar->setValue(0);

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

        $this->Pointx = $this->createElement('text','Pointx');
        $this->Pointx->removeDecorator('HtmlTag');
        $this->Pointx->removeDecorator('DtDdWrapper');
        $this->Pointx->removeDecorator('Label');
        $this->Pointx->setAttrib('class','smallele');
        $this->Pointx->setAttrib('onkeyup','UpdatePosition();');

        $this->Pointy = $this->createElement('text','Pointy');
        $this->Pointy->removeDecorator('HtmlTag');
        $this->Pointy->removeDecorator('DtDdWrapper');
        $this->Pointy->removeDecorator('Label');
        $this->Pointy->setAttrib('onkeyup','UpdatePosition();');
        $this->Pointy->setAttrib('class','smallele');
        
        $classification_list = $table_classification->setClassificationForSelectElement();
        $option_value = array("multiOptions" => $classification_list);
        $this->ClassificationSelect= $this->createElement('select','ClassSelect',$option_value);
        $this->ClassificationSelect->removeDecorator('HtmlTag');
        $this->ClassificationSelect->removeDecorator('DtDdWrapper');
        $this->ClassificationSelect->removeDecorator('Label');
 
        $data = $table_area->setAreaForSelectElement(1);
        
        $temp = array(0 => 'select Island');
        $area_data = $temp + $data;
        $data = array("multiOptions" => $area_data);
                
        $this->Island_Select = $this->createElement('select','IslandCoverOptions',$data);
        $this->Island_Select->removeDecorator('HtmlTag');
        $this->Island_Select->removeDecorator('DtDdWrapper');
        $this->Island_Select->removeDecorator('Label');
        $this->Island_Select->setAttrib('onchange','getAreaCover(this.value,0);');

        $data = $table_area->setAreaForSelectElement(1);
        $temp = array(0 => 'select Island');
        $area_data = $temp + $data;
        $data = array("multiOptions" => $area_data);

        $this->AreaSelect = $this->createElement('select','IslandListOptions',$data);
        $this->AreaSelect->removeDecorator('HtmlTag');
        $this->AreaSelect->removeDecorator('DtDdWrapper');
        $this->AreaSelect->removeDecorator('Label');
        $this->AreaSelect->setAttrib('onchange','getAreaList(this.value,0);');

        $this->Poiselect = $this->createElement('select','PopularSelect',$popular);
        $this->Poiselect->removeDecorator('HtmlTag');
        $this->Poiselect->removeDecorator('DtDdWrapper');
        $this->Poiselect->removeDecorator('Label');
        
        $this->TourismOperatorAddress = $this->createElement('textarea','TourismOperatorAddress');           
        $this->TourismOperatorAddress->removeDecorator('HtmlTag');
        $this->TourismOperatorAddress->removeDecorator('DtDdWrapper');
        $this->TourismOperatorAddress->removeDecorator('Label');
        $this->TourismOperatorAddress->setAttribs(array('cols' => 20, 'rows' => 5));

        $this->TourismOperatorDescription = $this->createElement('textarea','TourismOperatorDescription');           
        $this->TourismOperatorDescription->removeDecorator('HtmlTag');
        $this->TourismOperatorDescription->removeDecorator('DtDdWrapper');
        $this->TourismOperatorDescription->removeDecorator('Label');
        $this->TourismOperatorDescription->setAttribs(array('cols' => 5, 'rows' => 5));
    }
}