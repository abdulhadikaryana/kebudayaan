<?php 
class Admin_Form_PoiFormIndo extends Zend_Form
{
    /*
    * untuk sementara seluruh element dibuat public karena sulit untuk membuat decorator 
    * dengan struktur yang sesuai dengan design
    */
    
    public $Island_Select;
    public $Main_category;

    public $Count_area;
    public $Count_category;
    public $Area_counter;
    public $Category_counter;
    public $relPoi_counter;
    
    public $Category_Select;
    public $Category_Child;
    public $Category_add_btn;

    public $Popular_Select;
    public $Poi_Name;
    public $Poi_Phone;
    public $Poi_Address;
    public $Poi_Website;
    public $Poi_TagLine;
    public $Poi_Information;
    public $Poi_HowToGetThere;
    public $Poi_HowToGetAround;
    public $Poi_WhatToDo;
    public $Poi_WhereToEat;
    public $Poi_WhereToStay;
    public $Poi_WhatToBuy;
    public $Poi_Tips;
    public $Poi_x;
    public $Poi_y;	
    public $SaveStatus;	
    public $HeaderImage;
    public $SpecialDestination;

    public function init()
    {
        $tableArea = new Model_DbTable_Area;
        $tableCategory = new Model_DbTable_Category;

        $this->Poi_Name = $this->createElement('text','PoiName');
        $this->Poi_Name->removeDecorator('HtmlTag');
        $this->Poi_Name->removeDecorator('DtDdWrapper');
        $this->Poi_Name->removeDecorator('Label');
        $this->Poi_Name->setRequired(TRUE);
        $this->Poi_Name->setAttrib('class','mediumele');

        $popular = array("multiOptions" => array(
            0 => "No",
            1 => "Yes",
        ));

        $this->Popular_Select = $this->createElement('select','PopularSelect',$popular);
        $this->Popular_Select->removeDecorator('HtmlTag');
        $this->Popular_Select->removeDecorator('DtDdWrapper');
        $this->Popular_Select->removeDecorator('Label');

        $this->Poi_TagLine = $this->createElement('text','PoiTagline');
        $this->Poi_TagLine->removeDecorator('HtmlTag');
        $this->Poi_TagLine->removeDecorator('DtDdWrapper');
        $this->Poi_TagLine->removeDecorator('Label');
        $this->Poi_TagLine->setAttrib('class','mediumele');
        
        $this->Poi_Address = $this->createElement('text','PoiAddress');
        $this->Poi_Address->setAttrib('class','tableFormInputLong');
        $this->Poi_Address->removeDecorator('HtmlTag');
        $this->Poi_Address->removeDecorator('DtDdWrapper');
        $this->Poi_Address->removeDecorator('Label');
        $this->Poi_Address->setAttrib('class','mediumele');

        $this->Poi_Phone = $this->createElement('text','PoiPhone');
        $this->Poi_Phone->removeDecorator('HtmlTag');
        $this->Poi_Phone->removeDecorator('DtDdWrapper');
        $this->Poi_Phone->removeDecorator('Label');
        $this->Poi_Phone->setAttrib('class','mediumele');

        $this->Poi_Website = $this->createElement('text','PoiWebsite');
        $this->Poi_Website->removeDecorator('HtmlTag');
        $this->Poi_Website->removeDecorator('DtDdWrapper');
        $this->Poi_Website->removeDecorator('Label');
        $this->Poi_Website->setAttrib('class','mediumele');

        $this->SpecialDestination = $this->createElement('checkbox','SpecialDestination');
        $this->SpecialDestination->removeDecorator('HtmlTag');
        $this->SpecialDestination->removeDecorator('DtDdWrapper');
        $this->SpecialDestination->removeDecorator('Label');
        $this->SpecialDestination->setCheckedValue(1);
        $this->SpecialDestination->setUncheckedValue(0);
        $this->SpecialDestination->setAttrib('onclick','showHeaderImage($(this));');

        $this->HeaderImage = $this->createElement('text','HeaderImage');
        $this->HeaderImage->removeDecorator('HtmlTag');
        $this->HeaderImage->removeDecorator('DtDdWrapper');
        $this->HeaderImage->removeDecorator('Label');
        $this->HeaderImage->setAttrib('class','disabled');
        
        $category = $tableCategory->getAllParentIdNameForSelectByLangId(2);
        $this->Category_Select = $this->createElement('select','CategorySelect',$category);
        $this->Category_Select->removeDecorator('HtmlTag');
        $this->Category_Select->removeDecorator('DtDdWrapper');
        $this->Category_Select->removeDecorator('Label');
        $this->Category_Select->setAttrib('onchange','getChildCategoryIndo(this.value);');

        $category_child = $tableCategory->getAllChildIdNameByParentIdLangId(null,2);
        $this->Category_Child = $this->createElement('select','CategoryChild',$category_child);
        $this->Category_Child->removeDecorator('HtmlTag');
        $this->Category_Child->removeDecorator('DtDdWrapper');
        $this->Category_Child->removeDecorator('Label');
        

        $data = $tableArea->setAreaForSelectElement(1);
        
        $temp = array(0 => 'select Island');
        $area_data = $temp + $data;
        $data = array("multiOptions" => $area_data);
                
        $this->Island_Select = $this->createElement('select','IslandListOptions',$data);
        $this->Island_Select->removeDecorator('HtmlTag');
        $this->Island_Select->removeDecorator('DtDdWrapper');
        $this->Island_Select->removeDecorator('Label');
        $this->Island_Select->setAttrib('onchange','getAreaList(this.value,0);');
    
        $this->Poi_x = $this->createElement('text','pointx');
        $this->Poi_x->removeDecorator('HtmlTag');
        $this->Poi_x->setAttrib('class','required');
        $this->Poi_x->removeDecorator('DtDdWrapper');
        $this->Poi_x->removeDecorator('Label');
        $this->Poi_x->setAttrib('onkeyup','UpdatePosition();');
        $this->Poi_x->setAttrib('class','smallele');
        $this->Poi_x->setRequired(TRUE);

        $this->Poi_y = $this->createElement('text','pointy');
        $this->Poi_y->removeDecorator('HtmlTag');
        $this->Poi_y->setAttrib('class','required');
        $this->Poi_y->removeDecorator('DtDdWrapper');
        $this->Poi_y->removeDecorator('Label');
        $this->Poi_y->setAttrib('onkeyup','UpdatePosition();');
        $this->Poi_y->setAttrib('class','smallele');
        $this->Poi_y->setRequired(TRUE);

        $this->Poi_Information = $this->createElement('textarea','PoiInformation');           
        $this->Poi_Information->removeDecorator('HtmlTag');
        $this->Poi_Information->removeDecorator('DtDdWrapper');
        $this->Poi_Information->removeDecorator('Label');
        $this->Poi_Information->setAttribs(array('cols' => 5, 'rows' => 5));
        
        $this->Poi_HowToGetThere = $this->createElement('textarea','PoiHowToGetThere');           
        $this->Poi_HowToGetThere->removeDecorator('HtmlTag');
        $this->Poi_HowToGetThere->removeDecorator('DtDdWrapper');
        $this->Poi_HowToGetThere->removeDecorator('Label');

        $this->Poi_HowToGetAround = $this->createElement('textarea','PoiHowToGetAround');           
        $this->Poi_HowToGetAround->removeDecorator('HtmlTag');
        $this->Poi_HowToGetAround->removeDecorator('DtDdWrapper');
        $this->Poi_HowToGetAround->removeDecorator('Label');

        $this->Poi_WhatToDo = $this->createElement('textarea','PoiWhatToDo');           
        $this->Poi_WhatToDo->removeDecorator('HtmlTag');
        $this->Poi_WhatToDo->removeDecorator('DtDdWrapper');
        $this->Poi_WhatToDo->removeDecorator('Label');
        
        $this->Poi_WhereToEat = $this->createElement('textarea','PoiWhereToEat');           
        $this->Poi_WhereToEat->removeDecorator('HtmlTag');
        $this->Poi_WhereToEat->removeDecorator('DtDdWrapper');
        $this->Poi_WhereToEat->removeDecorator('Label');
                
        $this->Poi_WhereToStay = $this->createElement('textarea','PoiWhereToStay');           
        $this->Poi_WhereToStay->removeDecorator('HtmlTag');
        $this->Poi_WhereToStay->removeDecorator('DtDdWrapper');
        $this->Poi_WhereToStay->removeDecorator('Label');

        $this->Poi_WhatToBuy = $this->createElement('textarea','PoiWhatToBuy');           
        $this->Poi_WhatToBuy->removeDecorator('HtmlTag');
        $this->Poi_WhatToBuy->removeDecorator('DtDdWrapper');
        $this->Poi_WhatToBuy->removeDecorator('Label');
        
        $this->Poi_Tips = $this->createElement('textarea','PoiTips');           
        $this->Poi_Tips->removeDecorator('HtmlTag');
        $this->Poi_Tips->removeDecorator('DtDdWrapper');
        $this->Poi_Tips->removeDecorator('Label');
        
        /*hidden element*/        

        $this->relPoi_counter = $this->createElement('hidden','relPoi_counter');
        $this->relPoi_counter->removeDecorator('HtmlTag');
        $this->relPoi_counter->removeDecorator('DtDdWrapper');
        $this->relPoi_counter->removeDecorator('Label');
        $this->relPoi_counter->setValue(0);
        
        $this->SaveStatus = $this->createElement('hidden','SaveStatus');
        $this->SaveStatus->removeDecorator('HtmlTag');
        $this->SaveStatus->removeDecorator('DtDdWrapper');
        $this->SaveStatus->removeDecorator('Label');
        $this->SaveStatus->setValue(1);
        /**
         * This element will be used for maximum area counter storage, 
         * when you remove an area this counter number wont be decreased
        */
        $this->Count_area = $this->createElement('hidden','MaxArea');
        $this->Count_area->removeDecorator('HtmlTag');
        $this->Count_area->removeDecorator('DtDdWrapper');
        $this->Count_area->removeDecorator('Label');
        $this->Count_area->setValue(0);
        /**
         * This element will be used for maximum category counter storage, 
         * when you remove a category this counter number wont be decreased
        */
        $this->Count_category = $this->createElement('hidden','MaxCategory');
        $this->Count_category->removeDecorator('HtmlTag');
        $this->Count_category->removeDecorator('DtDdWrapper');
        $this->Count_category->removeDecorator('Label');
        $this->Count_category->setValue(0);

        $this->Area_counter = $this->createElement('hidden','AreaCounter');
        $this->Area_counter->removeDecorator('HtmlTag');
        $this->Area_counter->removeDecorator('DtDdWrapper');
        $this->Area_counter->removeDecorator('Label');
        $this->Area_counter->setValue(0);

        $this->Category_counter = $this->createElement('hidden','CategoryCounter');
        $this->Category_counter->removeDecorator('HtmlTag');
        $this->Category_counter->removeDecorator('DtDdWrapper');
        $this->Category_counter->removeDecorator('Label');
        $this->Category_counter->setValue(0);

        $this->Main_category = $this->createElement('hidden','MainCategory');
        $this->Main_category->removeDecorator('HtmlTag');
        $this->Main_category->removeDecorator('DtDdWrapper');
        $this->Main_category->removeDecorator('Label');
        $this->Main_category->setValue(0);
        

    }
    
}
