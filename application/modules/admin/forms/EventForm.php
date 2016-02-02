<?php

class Admin_Form_EventForm
        extends Zend_Form
{
  public $eventName;
  public $eventDescription;
  public $eventImage;
  public $dateStart;
  public $dateEnd;
  public $timeStart;
  public $timeEnd;
  public $relatedPoi;
  public $mainCategory;
  public $poiMax;
  public $draft;
  public $submit;
  public $recurring;

  public function init()
  {

    $this->draft  = new Zend_Form_Element_Submit('action');
    $this->submit = new Zend_Form_Element_Submit('action');
    $this->draft->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttrib('class', 'btn');

    $this->submit->removeDecorator('HtmlTag')
            ->removeDecorator('DtDdWrapper')
            ->removeDecorator('Label')
            ->setAttrib('class', 'btn btn-success');


    $this->eventName = $this->createElement('text', 'eventName');
    $this->eventName->removeDecorator('HtmlTag');
    $this->eventName->removeDecorator('DtDdWrapper');
    $this->eventName->setAttrib('class', 'span6');
    $this->eventName->removeDecorator('Label');

    $this->poiMax = $this->createElement('hidden', 'poiMax');
    $this->poiMax->removeDecorator('HtmlTag');
    $this->poiMax->removeDecorator('DtDdWrapper');
    $this->poiMax->setAttrib('class', 'smallele');
    $this->poiMax->removeDecorator('Label');

    $this->dateStart = $this->createElement('hidden', 'dateStart');
    $this->dateStart->removeDecorator('HtmlTag');
    $this->dateStart->removeDecorator('DtDdWrapper');
    $this->dateStart->removeDecorator('Label');

    $this->dateEnd = $this->createElement('hidden', 'dateEnd');
    $this->dateEnd->removeDecorator('HtmlTag');
    $this->dateEnd->removeDecorator('DtDdWrapper');
    $this->dateEnd->removeDecorator('Label');

    $this->timeStart = $this->createElement('text', 'timeStart');
    $this->timeStart->removeDecorator('HtmlTag');
    $this->timeStart->removeDecorator('DtDdWrapper');
    $this->timeStart->setAttrib('class', 'smallele');
    $this->timeStart->removeDecorator('Label');
    $this->timeStart->setValue('00:00');
    $this->timeStart->setAttrib('id', 'timeStart');

    $this->timeEnd = $this->createElement('text', 'timeEnd');
    $this->timeEnd->removeDecorator('HtmlTag');
    $this->timeEnd->removeDecorator('DtDdWrapper');
    $this->timeEnd->setAttrib('class', 'smallele');
    $this->timeEnd->removeDecorator('Label');
    $this->timeEnd->setValue('00:00');

    $this->eventDescription = $this->createElement('textarea',
                                                   'eventDescription');
    $this->eventDescription->removeDecorator('HtmlTag');
    $this->eventDescription->removeDecorator('DtDdWrapper');
    $this->eventDescription->setAttribs(array(
        'style' => 'width: 100%',
        'cols'  => 200,
        'rows'  => 20,
    ));
    $this->eventDescription->removeDecorator('Label');

    $this->eventImage = $this->createElement('text', 'eventImage');
    $this->eventImage->removeDecorator('HtmlTag');
    $this->eventImage->removeDecorator('DtDdWrapper');
    $this->eventImage->setAttrib('class', 'smallele');
    $this->eventImage->removeDecorator('Label');

    $this->relatedPoi = $this->createElement('text', 'relatedPoi');
    $this->relatedPoi->removeDecorator('HtmlTag');
    $this->relatedPoi->removeDecorator('DtDdWrapper');
    $this->relatedPoi->setAttrib('class', 'mediumele');
    $this->relatedPoi->removeDecorator('Label');
  }

  public function setCategorySelectData($language_id = 1)
  {
    $table_category     = new Model_DbTable_Category;
    $category_data      = $table_category->getAllParentIdNameForSelectByLangId($language_id);
    $this->mainCategory = $this->createElement('select',
                                               'mainCategory',
                                               $category_data);
    $this->mainCategory->removeDecorator('HtmlTag');
    $this->mainCategory->removeDecorator('DtDdWrapper');
    $this->mainCategory->removeDecorator('Label');
  }

}