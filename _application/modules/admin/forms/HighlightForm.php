<?php

class Admin_Form_HighlightForm extends Zend_Form {

  public $highlightImage;
  public $highlightType;
  public $highlightLink;
  public $highlightName;
  public $highlightDescription;
  public $highlightStatus;

  public function init() {
    $type = array("multiOptions" => array(
            3 => "Header",
            1 => "Medium-Sidebar",
            4 => "Small-Sidebar",
            ));

    $status = array("multiOptions" => array(
            1 => "Tampilkan",
            0 => "Tidak Ditampilkan",
            ));

    $this->highlightStatus = $this->createElement('select', 'highlightStatus', $status);
    $this->highlightStatus->removeDecorator('HtmlTag');
    $this->highlightStatus->removeDecorator('DtDdWrapper');
    $this->highlightStatus->removeDecorator('Label');

    $this->highlightType = $this->createElement('select', 'highlightType', $type);
    $this->highlightType->removeDecorator('HtmlTag');
    $this->highlightType->removeDecorator('DtDdWrapper');
    $this->highlightType->removeDecorator('Label');
    $this->highlightType->setAttrib('onchange', 'setRecommendSize();');

    $this->highlightImage = $this->createElement('text', 'highlightImage');
    $this->highlightImage->removeDecorator('HtmlTag');
    $this->highlightImage->removeDecorator('DtDdWrapper');
    $this->highlightImage->removeDecorator('Label');
    $this->highlightImage->setAttrib('class', 'mediumele');

    $this->highlightName = $this->createElement('text', 'highlightName');
    $this->highlightName->removeDecorator('HtmlTag');
    $this->highlightName->removeDecorator('DtDdWrapper');
    $this->highlightName->removeDecorator('Label');
    $this->highlightName->setAttrib('class', 'mediumele');

    $this->highlightSortOrder = $this->createElement('text', 'highlightSortOrder');
    $this->highlightSortOrder->removeDecorator('HtmlTag');
    $this->highlightSortOrder->removeDecorator('DtDdWrapper');
    $this->highlightSortOrder->removeDecorator('Label');
    $this->highlightSortOrder->setAttrib('class', 'smallele');

    $this->highlightLink = $this->createElement('text', 'highlightLink');
    $this->highlightLink->removeDecorator('HtmlTag');
    $this->highlightLink->removeDecorator('DtDdWrapper');
    $this->highlightLink->removeDecorator('Label');
    $this->highlightLink->setAttrib('class', 'mediumele');

    $this->highlightDescription = $this->createElement('textarea', 'highlightDescription');
    $this->highlightDescription->removeDecorator('HtmlTag');
    $this->highlightDescription->removeDecorator('DtDdWrapper');
    $this->highlightDescription->removeDecorator('Label');
    $this->highlightDescription->setAttribs(array('cols' => 5, 'rows' => 5));
  }

}