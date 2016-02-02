<?php
/**
 * Author: Hermanet Lay,
 * Project: Visit Indonesia 2010 
 * Helper JavaScript, makes your life easier for javascript coding on view, also makes your PHTML scripts tidy
 * Optional Parameter :
 * mode, data
 * ----------
 * HOW TO USE
 * ---------
 * Settings:
 * ---------
 * change $_scriptDir value with '/your/script/directory' (NOTICE that theres no slash at the end of it!)
 * -------
 * Param :
 * -------
 * (1) : Return Value of your JavaScript Directory;
 * (2) : Include Javascript files to your phtml/view, required : $data
 *       $data is an array with js name without .js extension, ex. : $data = array(1st js name only, 2nd js name only, 3rd js name only)
 * start : print '<script type="'.'text/javascript">' tag
 * end : print '</script>' tag
 * newArray : create an array and sets its value, if you add the 4th parameter when you are calling the jsView you can specify the element name of the array
 */
class Budpar_View_Helper_JsView extends Zend_View_Helper_Abstract {
	
    private $_javascriptUrl;
    private $_styleUrl;
    private $_scriptDir = '/javascripts';
        
    public function __construct() 
    {
        $tempInstance = new Budpar_View_Helper_ScriptUrl();
        $this->_javascriptUrl .= $tempInstance->scriptUrl().$this->_scriptDir;
    }
    
    public function jsView($mode = 1,$data = null,$optParam1 = null,$optParam2 = null) 
    {
        switch ($mode)
        {
          case 1 :  return $this->_javascriptUrl;
                    break;
          case 2 :  return $this->batchJsLink($data);
                    break;
          
          //word command list
          case 'newArray'   :   return $this->setJsArray($optParam1,$optParam2,$data);
          case 'start'      :   return $this->startScript();
          case 'end'        :   return $this->endScript();
        }
    }
    
    public function setJsArray($optParam1,$optParam2 = null, $data)
    {
        if ($optParam2 != null){return $this->createArrayVariableExtended($optParam1,$optParam2,$data);}
        else
        {return $this->createArrayVariable($optParam1,$data);}
    }
    
    public function createArrayVariableExtended($varname,$indexName,$data)
    {
        $html .= 'var '.$varname.' = Array(';
        $element_size = sizeof($data);
        $element_count = 0;
        
        foreach($data as $element)
        {
            $html .= "'".$element[$indexName]."'";
            if($element_count < $element_size-1){$html .= ',';}
            $element_count++;
        }
        
        $html .= ');'."\n";
        return $html;
    }
    
    public function createArrayVariable($varname,$data)
    {
        $html .= 'var '.$varname.' = Array(';
        $element_size = sizeof($data);
        for($element_count=0;$element_count<$element_size;$element_count++)
        {
            $html .="'".$data[$element_count]."'";
            if($element_count < $element_size-1){$html .= ',';}
        }
        $html .= ');'."\n";
        return $html;
    }
    
    public function startScript()
    {
        $html = '<script type="'.'text/javascript">'."\n";
        return $html;
    }

    public function endScript()
    {
        $html = '</script>'."\n";
        return $html;
    }
    
    public function batchJsLink($data)
    {
        $html = '';
        foreach($data as $jsfile){$html .= $this->generateJsLink($jsfile)."\n";}
        return $html;
    }
    
    public function generateJsLink($link)
    {
        $html = "<script type='text/javascript'";
        $html .= "src=".$this->_javascriptUrl.'/'.$link.'.js';
        $html .= "></script>";
        return $html;
    }
}