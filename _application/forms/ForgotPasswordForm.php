<?php
/**
 * Form_ForgotPasswordForm
 *
 * Form untuk reset password karena pengguna lupa
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ForgotPasswordForm extends Budpar_Form_Common
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
            'id' => 'inputForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/registration/forgot',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form
        // -> Email
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email:')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_EmailAddress())
              ->addValidator(new Zend_Validate_Db_RecordExists('user', 'email'));
        $this->addElement($email);

        // -> Submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Send')
               ->removeDecorator('Label');
        $this->addElement($submit);
    }
}

