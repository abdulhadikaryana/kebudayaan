<?php

class Admin_Form_PoiForm
        extends Zend_Form
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
//  public $Poi_Phone;
//  public $Poi_Address;
//  public $Poi_Website;
//  public $Poi_TagLine;
  public $Poi_Information;
//  public $Poi_HowToGetThere;
//  public $Poi_HowToGetAround;
//  public $Poi_WhatToDo;
//  public $Poi_WhereToEat;
//  public $Poi_WhereToStay;
//  public $Poi_WhatToBuy;
  public $Poi_Tips;
  public $Poi_x;
  public $Poi_y;
  public $SaveStatus;
  public $HeaderImage;
//  public $SpecialDestination;
  public $submit;
  public $draft;
  public $name;
  public $featured;
  public $description;
  /**
   *
   * @var Zend_Form_Element_File
   */
  public $header_image;
  public $videos;

  public function init()
  {
    $tableArea     = new Model_DbTable_Area;
    $tableCategory = new Model_DbTable_Category;
    $dateValidator = new Zend_Validate_Date;

    $this->name = new Zend_Form_Element_Text('Name');
    $this->name
            ->setRequired(true)
            ->setAttrib('class', 'span7')
            ->setAttrib('placeholder', 'Masukan Nama Kebudayaan Disini...')
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label');
    ;

    $this->featured = new Zend_Form_Element_Checkbox('Featured');
    $this->featured
            ->setAttrib('class', 'checkbox')
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
    ;

    $this->description = new Zend_Form_Element_Textarea('Description');
    $this->description
            ->setAttrib('style', 'width:100%')
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
    ;

    $this->header_image = new Zend_Form_Element_File('Header_image');
    $this->header_image
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
    ;


    $this->submit = new Zend_Form_Element_Submit('Submit');
    $this->submit
            ->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttribs(array(
                'class' => 'btn btn-success',
                'id'    => 'submit-btn'
            ));

    $this->draft = new Zend_Form_Element_Submit('Draft');
    $this->draft->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttribs(array(
                'class' => 'btn',
                'id'    => 'draft-btn'
            ));


    $this->videos = new Zend_Form_SubForm();

    $category              = $tableCategory->getAllParentIdNameForSelectByLangId(1);
    $this->Category_Select = $this->createElement('select',
                                                  'CategorySelect',
                                                  $category);
    $this->Category_Select->removeDecorator('HtmlTag');
    $this->Category_Select->removeDecorator('DtDdWrapper');
    $this->Category_Select->removeDecorator('Label');
    $this->Category_Select->setAttrib('onchange',
                                      'getChildCategory(this.value);');

    $category_child       = $tableCategory->getAllChildIdNameByParentIdLangId();
    $this->Category_Child = $this->createElement('select',
                                                 'CategoryChild',
                                                 $category_child);
    $this->Category_Child->removeDecorator('HtmlTag');
    $this->Category_Child->removeDecorator('DtDdWrapper');
    $this->Category_Child->removeDecorator('Label');

    $data = $tableArea->setAreaForSelectElement(1);

    $temp = array(0          => 'Pilih Area');
    $area_data = $temp + $data;
    $data      = array("multiOptions" => $area_data);

    $this->Island_Select = $this->createElement('select',
                                                'IslandListOptions',
                                                $data);
    $this->Island_Select->removeDecorator('HtmlTag');
    $this->Island_Select->removeDecorator('DtDdWrapper');
    $this->Island_Select->removeDecorator('Label');
    $this->Island_Select->setAttrib('onchange',
                                    'getAreaList(this.value,0);');

    $this->Poi_x = $this->createElement('hidden', 'pointx');
    $this->Poi_x->removeDecorator('HtmlTag');
    $this->Poi_x->setAttrib('class', 'required');
    $this->Poi_x->removeDecorator('DtDdWrapper');
    $this->Poi_x->removeDecorator('Label');
    $this->Poi_x->setAttrib('onkeyup', 'updatePosition();');
    $this->Poi_x->setAttrib('class', 'smallele');
    $this->Poi_x->setRequired(TRUE);

    $this->Poi_y = $this->createElement('hidden', 'pointy');
    $this->Poi_y->removeDecorator('HtmlTag');
    $this->Poi_y->setAttrib('class', 'required');
    $this->Poi_y->removeDecorator('DtDdWrapper');
    $this->Poi_y->removeDecorator('Label');
    $this->Poi_y->setAttrib('onkeyup', 'updatePosition();');
    $this->Poi_y->setAttrib('class', 'smallele');
    $this->Poi_y->setRequired(TRUE);

    /* hidden element */

    $this->relPoi_counter = $this->createElement('hidden',
                                                 'relPoi_counter');
    $this->relPoi_counter->removeDecorator('HtmlTag');
    $this->relPoi_counter->removeDecorator('DtDdWrapper');
    $this->relPoi_counter->removeDecorator('Label');
    $this->relPoi_counter->setValue(0);

    $this->SaveStatus     = $this->createElement('hidden',
                                                 'SaveStatus');
    $this->SaveStatus->removeDecorator('HtmlTag');
    $this->SaveStatus->removeDecorator('DtDdWrapper');
    $this->SaveStatus->removeDecorator('Label');
    $this->SaveStatus->setValue(1);
    /**
     * This element will be used for maximum area counter storage, 
     * when you remove an area this counter number wont be decreased
     */
    $this->Count_area     = $this->createElement('hidden', 'MaxArea');
    $this->Count_area->removeDecorator('HtmlTag');
    $this->Count_area->removeDecorator('DtDdWrapper');
    $this->Count_area->removeDecorator('Label');
    $this->Count_area->setValue(0);
    /**
     * This element will be used for maximum category counter storage, 
     * when you remove a category this counter number wont be decreased
     */
    $this->Count_category = $this->createElement('hidden',
                                                 'MaxCategory');
    $this->Count_category->removeDecorator('HtmlTag');
    $this->Count_category->removeDecorator('DtDdWrapper');
    $this->Count_category->removeDecorator('Label');
    $this->Count_category->setValue(0);

    $this->Area_counter = $this->createElement('hidden', 'AreaCounter');
    $this->Area_counter->removeDecorator('HtmlTag');
    $this->Area_counter->removeDecorator('DtDdWrapper');
    $this->Area_counter->removeDecorator('Label');
    $this->Area_counter->setValue(0);

    $this->Category_counter = $this->createElement('hidden',
                                                   'CategoryCounter');
    $this->Category_counter->removeDecorator('HtmlTag');
    $this->Category_counter->removeDecorator('DtDdWrapper');
    $this->Category_counter->removeDecorator('Label');
    $this->Category_counter->setValue(0);

    $this->Main_category = $this->createElement('hidden',
                                                'MainCategory');
    $this->Main_category->removeDecorator('HtmlTag');
    $this->Main_category->removeDecorator('DtDdWrapper');
    $this->Main_category->removeDecorator('Label');
    $this->Main_category->setValue(0);
  }

}
