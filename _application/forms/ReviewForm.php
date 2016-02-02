<?php
/**
 * Form_ReviewForm
 *
 * Form untuk review
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_ReviewForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId!=2){
            $yourrate = 'Your rating for this destination:';
            $yourrev = 'Your review:';
            $tit = 'Title';
        }else{
            $yourrate = 'Rating Anda untuk destinasi ini:';
            $yourrev = 'Tinjauan Anda:';
            $tit = 'Judul';
        }
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'reviewForm'
        ));
        $this->setAttrib('accept-charset', 'utf-8');

        // Element Form  
        // -> Rating
        $ratingValue = array(0, 1, 2, 3, 4, 5);
        $rating = $this->createElement('radio', 'rate');
        $rating->setLabel($yourrate)
               ->setRequired(true)
               ->setMultiOptions($ratingValue)
               ->addValidator('NotEmpty')
               ->setDecorators(array(
                    'ViewHelper',
                    'Description',
                    'Errors',
                    array('HtmlTag', array('tag' => 'dd',
                        'id' => 'rating-element', 'class' => 'rating-enable')),
                    array('Label', array('tag' => 'dt')),
                ));
        $this->addElement($rating);

// -> Title
        $title = $this->createElement('text', 'review_title');
        $title->setLabel($tit)
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->setDecorators(array(
                    'ViewHelper',
                    'Description',
                    'Errors',
                    array('HtmlTag', array('tag' => 'dd',
                        'id' => 'review-element')),
                    array('Label', array('tag' => 'dt')),
                ));
        $this->addElement($title);

        // -> Review
        $review = $this->createElement('textarea', 'review_content');
        $review->setLabel($yourrev)
              ->setRequired(true)
              ->setAttrib('rows','20')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setDecorators(array(
                    'ViewHelper',
                    'Description',
                    'Errors',
                    array('HtmlTag', array('tag' => 'dd',
                        'id' => 'review-element')),
                    array('Label', array('tag' => 'dt')),
                ));
        $this->addElement($review);

        // -> Submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Submit')
               ->removeDecorator('Label');
        $this->addElement($submit);
    }
}

