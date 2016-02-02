<?php

/**
 * Budpar_View_Helper_HtmlDecode
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_HtmlDecode extends Zend_View_Helper_Abstract
{   
    public function HtmlDecode($string, $mode = 1)
    {
        $custom = new Budpar_Custom_Common;

        return $custom->htmlDecode($string, $mode);
    }

}