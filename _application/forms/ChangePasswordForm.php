<?php
/**
 * Form_ChangePasswordForm
 *
 * Form untuk change password
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ChangePasswordForm extends Budpar_Form_Common
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
            'id' => 'changePasswordForm',
            'action' => $this->_baseUrlHelper->baseUrl() . '/registration/change-password',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Form Element
        // -> Password
        $oldPassword = $this->createElement('password', 'oldPassword');
        $oldPassword->setLabel('Old Password')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setDecorators($this->elementDecorators);
        $this->addElement($oldPassword);
        
        // -> Password
        $password = $this->createElement('password', 'newPassword');
        $password->setLabel('New Password')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->setDecorators($this->elementDecorators);
        $this->addElement($password);

        // -> Password Confirm
        // ---> Validator password
        $identValidator = new Zend_Validate_Identical($_POST['newPassword']);
        $identValidator->setMessages(
            array('notSame' => 'Value doesn\'t match!',
                  'missingToken' => 'Value doesn\'t match!'));

        $password2 = $this->createElement('password', 'newPassword2');
        $password2->setLabel('Confirm New password:')
                  ->setRequired(true)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator($identValidator)
                  ->setDecorators($this->elementDecorators);
        $this->addElement($password2);
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

