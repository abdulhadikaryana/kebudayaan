<?php

class Admin_Form_NewsForm extends Zend_Form {

  public $newsTitle;
  public $newsContent;
  public $PoiCounter;
  public $newsPoi;
  public $newsImage;
  public $newsPublishDate;
  public $newsStatus;
  public $submit;
  public $draft;

  /**
   *
   * @var Zend_Form_Element_File
   */
  public $image;

  /**
   * IS: 
   * FS: 
   * Desc: Mengatur tampilan form di halaman news
   */
  public function init() {

    $this->submit = new Zend_Form_Element_Submit('action');
    $this->draft  = new Zend_Form_Element_Submit('action');
    $this->image  = new Zend_Form_Element_File('image');

    $this->submit->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttrib('class', 'btn btn-success');

    $this->draft->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setLabel('Draft')
            ->setAttrib('class', 'btn');

    $this->image->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setLabel('Draft');

    $this->newsTitle = $this->createElement('text', 'newsTitle');
    $this->newsTitle->removeDecorator('HtmlTag');
    $this->newsTitle->removeDecorator('DtDdWrapper');
    $this->newsTitle->removeDecorator('Label');
    $this->newsTitle->setAttrib('class', 'span8');

    $this->newsContent = $this->createElement('textarea', 'newsContent');
    $this->newsContent->removeDecorator('HtmlTag');
    $this->newsContent->removeDecorator('DtDdWrapper');
    $this->newsContent->removeDecorator('Label');
    $this->newsContent->setAttribs(array('cols' => 5, 'rows' => 5));

    $this->PoiCounter = $this->createElement('hidden', 'PoiCounter');
    $this->PoiCounter->removeDecorator('HtmlTag');
    $this->PoiCounter->removeDecorator('DtDdWrapper');
    $this->PoiCounter->removeDecorator('Label');
    $this->PoiCounter->setValue(0);

//        Related destination
    $this->newsPoi = $this->createElement('text', 'newsPoi');
    $this->newsPoi->removeDecorator('HtmlTag');
    $this->newsPoi->removeDecorator('DtDdWrapper');
    $this->newsPoi->removeDecorator('Label');
    $this->newsPoi->setAttrib('class', 'span4');


    $this->newsImage = $this->createElement('text', 'newsImage');
    $this->newsImage->removeDecorator('HtmlTag');
    $this->newsImage->removeDecorator('DtDdWrapper');
    $this->newsImage->removeDecorator('Label');
    $this->newsImage->setAttrib('class', 'smallele');

    $this->newsPublishDate = $this->createElement('text', 'newsPublishDate');
    $this->newsPublishDate->removeDecorator('HtmlTag');
    $this->newsPublishDate->removeDecorator('DtDdWrapper');
    $this->newsPublishDate->removeDecorator('Label');
    $this->newsPublishDate->setAttrib('class', 'smallele');

    $this->newsStatus = $this->createElement('hidden', 'newsStatus');
    $this->newsStatus->removeDecorator('HtmlTag');
    $this->newsStatus->removeDecorator('DtDdWrapper');
    $this->newsStatus->removeDecorator('Label');
    $this->newsStatus->setValue(1);
  }

}
