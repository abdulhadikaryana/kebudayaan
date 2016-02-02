<?php

class Budpar_Form_Validator_Url extends Zend_Validate_Abstract
{
    const INVALID_URL = 'invalidUrl';

    protected $_messageTemplates = array(
        self::INVALID_URL => "'%value%' is not a valid URL.",
    );

    public function isValid($value)
    {
        $valueString = (string) $value;
        $this->_setValue($valueString);

        $regex = "((http://|https://)?(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6})";
        if ( ! preg_match($regex, $value)) {
            $this->_error(self::INVALID_URL);
            return false;
        }
        
        return true;
    }
}