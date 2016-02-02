<?php
/**
 * Form_LoginForm
 *
 * Form untuk login
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_LoginForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();

        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'loginForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/login/index',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        $username = $this->createElement('text', 'username');
        $username->setLabel('Username')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->setDecorators($this->elementDecorators);
        $this->addElement($username);

        // -> Password
        $password = $this->createElement('password', 'password');
        $password->setLabel('Password')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->setDecorators($this->elementDecorators);
        $this->addElement($password);

        // -> Remember me
        /*$remember = $this->createElement('checkbox', 'remember');
        $password->setLabel('')
                 ->setDecorators($this->elementDecorators);
        $this->addElement($password);*/
    }

    /**
     * Fungsi untuk load default decorator
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}

