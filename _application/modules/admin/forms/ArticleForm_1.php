<?php

class Admin_Form_ArticleForm extends Zend_Form {

  public $article_poi_id;
  public $article_status;
  public $article_main_image;
  public $article_title;
  public $article_content;
  public $area_select;
  public $Island_select;
  public $SaveStatus;
  public $articleSortOrder;
  public $languageID;
  public $draft;
  public $submit;

  public function init() {

    $this->draft = new Zend_Form_Element_Submit('action');
    $this->draft->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttrib('class', 'btn');

    $this->submit = new Zend_Form_Element_Submit('action');
    $this->submit->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttrib('class', 'btn btn-success');

    $tableArea           = new Model_DbTable_Area;
    $this->article_title = $this->createElement('text', 'ArticleTitle');
    $this->article_title->removeDecorator('HtmlTag');
    $this->article_title->removeDecorator('DtDdWrapper');
    $this->article_title->removeDecorator('Label');
    $this->article_title->setAttrib('class', 'mediumele');
    $this->article_title->setRequired(TRUE);

    $this->SaveStatus = $this->createElement('hidden', 'SaveStatus');
    $this->SaveStatus->removeDecorator('HtmlTag');
    $this->SaveStatus->removeDecorator('DtDdWrapper');
    $this->SaveStatus->removeDecorator('Label');
    $this->SaveStatus->setValue(1);

    $this->articleSortOrder = $this->createElement('text', 'articleSortOrder');
    $this->articleSortOrder->removeDecorator('HtmlTag');
    $this->articleSortOrder->removeDecorator('DtDdWrapper');
    $this->articleSortOrder->removeDecorator('Label');
    $this->articleSortOrder->setAttrib('class', 'smallele');
    $this->articleSortOrder->setValue(0);

    $this->article_content = $this->createElement('textarea', 'ArticleContent');
    $this->article_content->removeDecorator('HtmlTag');
    $this->article_content->removeDecorator('DtDdWrapper');
    $this->article_content->removeDecorator('Label');
    $this->article_content->setAttribs(array('cols' => 5, 'rows' => 5));
    $this->article_content->setRequired(TRUE);

    $this->article_status = $this->createElement('hidden', 'ArticlePoi');
    $this->article_status->removeDecorator('HtmlTag');
    $this->article_status->removeDecorator('DtDdWrapper');
    $this->article_status->removeDecorator('Label');
    $this->article_status->setAttrib('minlength', '2');
    $this->article_status->setRequired(TRUE);

    $this->article_poi_id = $this->createElement('hidden', 'PoiId');
    $this->article_poi_id->removeDecorator('HtmlTag');
    $this->article_poi_id->removeDecorator('DtDdWrapper');
    $this->article_poi_id->removeDecorator('Label');
    $this->article_poi_id->setRequired(TRUE);


    $data = $tableArea->setAreaForSelectElement($this->languageID);
//        $data = $tableArea->setAreaForSelectElement(1);
    $temp = array(0          => 'select Island');
    $area_data = $temp + $data;
    $data      = array("multiOptions"       => $area_data);
    $this->island_select = $this->createElement('select', 'IslandListOptions', $data);
    $this->island_select->removeDecorator('HtmlTag');
    $this->island_select->removeDecorator('DtDdWrapper');
    $this->island_select->removeDecorator('Label');
    $this->island_select->setAttrib('onchange', "getAreaList(this.value,0," . $this->languageID . ");");

    $this->article_main_image = $this->createElement('text', 'ArticleMainImage');
    $this->article_main_image->removeDecorator('HtmlTag');
    $this->article_main_image->removeDecorator('DtDdWrapper');
    $this->article_main_image->removeDecorator('Label');

  }

  public function setLanguageId($int) {
    $this->languageID = $int;
  }

}