<?php 
class Admin_Form_ActivityForm extends Zend_Form
{
    public $categoryParent;
    public $categoryName;
    public $categoryPicture;
    public $categoryDescription;
    
    public function init()
    {
        $this->categoryName = $this->createElement('text','categoryName');           
        $this->categoryName->removeDecorator('HtmlTag');
        $this->categoryName->removeDecorator('DtDdWrapper');
        $this->categoryName->removeDecorator('Label');
        $this->categoryName->setAttrib('class','mediumele');
        
        $this->categoryPicture = $this->createElement('text','categoryPicture');           
        $this->categoryPicture->removeDecorator('HtmlTag');
        $this->categoryPicture->removeDecorator('DtDdWrapper');
        $this->categoryPicture->removeDecorator('Label');
        $this->categoryPicture->setAttrib('class','mediumele');
        
        $this->categoryDescription = $this->createElement('textarea','categoryDescription');           
        $this->categoryDescription->removeDecorator('HtmlTag');
        $this->categoryDescription->removeDecorator('DtDdWrapper');
        $this->categoryDescription->removeDecorator('Label');
        $this->categoryDescription->setAttribs(array('cols' => 5, 'rows' => 5));    

        $this->categoryDescription = $this->createElement('textarea','categoryDescription');           
        $this->categoryDescription->removeDecorator('HtmlTag');
        $this->categoryDescription->removeDecorator('DtDdWrapper');
        $this->categoryDescription->removeDecorator('Label');
        $this->categoryDescription->setAttribs(array('cols' => 5, 'rows' => 5));
    }
    
    public function setCategoryParent($language_id)
    {
        $tableCategory = new Model_DbTable_Category;
        $category = $tableCategory->getAllParentIdNameForSelectByLangId($language_id,TRUE,'-');
        $this->categoryParent = $this->createElement('select','categoryParent',$category);
        $this->categoryParent->removeDecorator('HtmlTag');
        $this->categoryParent->removeDecorator('DtDdWrapper');
        $this->categoryParent->removeDecorator('Label');
        $this->categoryParent->setAttrib('onchange','recommendSize();');      
    }
    
}