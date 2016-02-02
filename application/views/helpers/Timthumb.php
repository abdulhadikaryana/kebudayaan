<?php

class View_Helper_Timthumb extends Zend_View_Helper_Abstract
{

    protected $format = '<img src="%s" alt="%s" />';
    public $_view;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function timthumb($name, $w = 100, $q = 100, $h = 100)
    {
        $filename = "upload/culture/" . $name;
        if (!is_file(IMAGE_FOLDER . $filename))
            $filename = "default.jpg";
        $timthumb = "timthumb.php?src=%s&w=%d&h=%d&q=%d";
        $url = sprintf($timthumb, $filename, $w, $q, $h);
        $src = $this->_view->imageUrl($url);

        return $src;
    }

}
