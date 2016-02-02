<?php
/**
  Helper boldStyle digunakan untuk merubah style kata yang sesuai dengan pattern
  pencarian
  
  @author tajhul
 */
class Budpar_View_Helper_BoldStyle extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }

    public function boldStyle($string, $search){
        
        $pattern = '/' . str_replace(' ', '|', $search) . '/';
        
        /*
            format array (this,'nama fungsinya')
            array($this,'to_bold')
        */
        $hasil = preg_replace_callback($pattern, array($this,'to_bold'), $string);
        
        return $hasil;

    }
    
    protected function to_bold($matches){
        return "<b>{$matches[0]}</b>";
    }

}