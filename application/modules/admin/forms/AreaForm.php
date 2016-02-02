<?php 
class Admin_Form_AreaForm extends Zend_Form
{
    public $areaDescription;
    public $areaEntry;
    public $areaHistory;
    public $areaPeople;
    public $areaCuisine;
    public $areaTourismOffice;
    public $areaNameLang;
    public $Poi_x;
    public $Poi_y;
    
    public function init()
    {
        $this->areaNameLang = $this->createElement('text','areaNameLan');           
        $this->areaNameLang->removeDecorator('HtmlTag');
        $this->areaNameLang->removeDecorator('DtDdWrapper');
        $this->areaNameLang->removeDecorator('Label');
        $this->areaNameLang->setAttrib('class','mediumele');

        $this->areaDescription = $this->createElement('textarea','areaDescription');           
        $this->areaDescription->removeDecorator('HtmlTag');
        $this->areaDescription->removeDecorator('DtDdWrapper');
        $this->areaDescription->removeDecorator('Label');
        $this->areaDescription->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->areaEntry = $this->createElement('textarea','areaEntry');           
        $this->areaEntry->removeDecorator('HtmlTag');
        $this->areaEntry->removeDecorator('DtDdWrapper');
        $this->areaEntry->removeDecorator('Label');
        $this->areaEntry->setAttribs(array('cols' => 5, 'rows' => 5));
        
        $this->areaHistory = $this->createElement('textarea','areaHistory');           
        $this->areaHistory->removeDecorator('HtmlTag');
        $this->areaHistory->removeDecorator('DtDdWrapper');
        $this->areaHistory->removeDecorator('Label');
        $this->areaHistory->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->areaPeople = $this->createElement('textarea','areaPeople');           
        $this->areaPeople->removeDecorator('HtmlTag');
        $this->areaPeople->removeDecorator('DtDdWrapper');
        $this->areaPeople->removeDecorator('Label');
        $this->areaPeople->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->areaCuisine = $this->createElement('textarea','areaCuisine');           
        $this->areaCuisine->removeDecorator('HtmlTag');
        $this->areaCuisine->removeDecorator('DtDdWrapper');
        $this->areaCuisine->removeDecorator('Label');
        $this->areaCuisine->setAttribs(array('cols' => 5, 'rows' => 5));

        $this->areaTourismOffice = $this->createElement('textarea','areaTourismOffice');           
        $this->areaTourismOffice->removeDecorator('HtmlTag');
        $this->areaTourismOffice->removeDecorator('DtDdWrapper');
        $this->areaTourismOffice->removeDecorator('Label');
        $this->areaTourismOffice->setAttribs(array('cols' => 5, 'rows' => 5));
        
        $this->Poi_x = $this->createElement('hidden','pointx');
        $this->Poi_x->removeDecorator('HtmlTag');
        $this->Poi_x->setAttrib('class','required');
        $this->Poi_x->removeDecorator('DtDdWrapper');
        $this->Poi_x->removeDecorator('Label');
        $this->Poi_x->setAttrib('onkeyup','UpdatePosition();');
        $this->Poi_x->setAttrib('class','smallele');
        $this->Poi_x->setRequired(TRUE);

        $this->Poi_y = $this->createElement('hidden','pointy');
        $this->Poi_y->removeDecorator('HtmlTag');
        $this->Poi_y->setAttrib('class','required');
        $this->Poi_y->removeDecorator('DtDdWrapper');
        $this->Poi_y->removeDecorator('Label');
        $this->Poi_y->setAttrib('onkeyup','UpdatePosition();');
        $this->Poi_y->setAttrib('class','smallele');
        $this->Poi_y->setRequired(TRUE);        
    }
}