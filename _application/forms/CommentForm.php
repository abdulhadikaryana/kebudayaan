<?php
/**
 * Form_CommentForm
 *
 * Form untuk comment
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_CommentForm extends Budpar_Form_Common
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
            'id' => 'commentForm',
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        $langId = Zend_Registry::get('languageId');
        if($langId==1){
            $textNameComment = 'Name:';
            $textWebsiteComment = 'Website (Optional):';
            $textComment = 'Comment:';
            $textSubmit = 'Submit';
        }else {
            $textNameComment = 'Nama:';
            $textWebsiteComment = 'Website (Tidak Wajib):';
            $textComment = 'Komentar:';
            $textSubmit = 'Kirim';
        }

        if ( ! $this->_sess->username AND ! $this->_sess->fbname) {
            // Element Form
            // -> Author
            $name = $this->createElement('text', 'author');
            $name->setLabel($textNameComment)
                 ->setRequired(true);
            $this->addElement($name);

            // -> Email
            $email = $this->createElement('text', 'email');
            $email->setLabel('Email:')
                  ->setRequired(true)
                  ->addValidator(new Zend_Validate_EmailAddress());
            $this->addElement($email);

            // -> Website
            //$urlValidator = new Zend_Validate_Regex('((http://|https://)?(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6})');
           // $urlValidator->setMessages(
               // array('regexNotMatch' => 'Value is not valid URL'));
            $website = $this->createElement('text', 'website');
            $website->setLabel($textWebsiteComment)
                    ->addValidator(new Budpar_Form_Validator_Url);
                    //->addValidator($urlValidator);
            $this->addElement($website);
        }
        
        // -> Message
        $comment = $this->createElement('textarea', 'comment');
        $comment->setLabel($textComment)
                ->setRequired(true);
        $this->addElement($comment);

        if ( ! $this->_sess->username AND ! $this->_sess->fbname) {
            // -> Captcha
            $publicKey = Zend_Registry::get('recaptcha_public_key');
            $privateKey = Zend_Registry::get('recaptcha_private_key');
            $recaptcha = new Zend_Service_ReCaptcha($publicKey, $privateKey);

            $captcha = new Zend_Form_Element_Captcha('captcha', array(
                'captcha'        => 'ReCaptcha',
                'captchaOptions' => array(
                    'captcha' => 'ReCaptcha', 'service' => $recaptcha)
            ));
            $this->addElement($captcha);
        }

        // -> Submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($textSubmit)
               ->removeDecorator('Label');
        $this->addElement($submit);
    }
}

