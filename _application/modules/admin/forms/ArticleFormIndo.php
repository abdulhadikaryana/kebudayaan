<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_Form_ArticleFormIndo extends Admin_Form_ArticleForm
{

    public function init()
    {
        parent::setLanguageId(2);
        parent::init();
    }
}