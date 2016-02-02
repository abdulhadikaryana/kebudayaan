<?php

class Budpar_View_Helper_MinStylesheets extends Zend_View_Helper_HeadLink
{
    public function minStylesheets()
    {
        $items = array();
        $stylesheets = array();
        foreach ($this as $item){
            if ($item->type == 'text/css' && $item->conditionalStylesheet === false){
                $stylesheets[$item->media][] = $item->href;
            } else {
                $items[] = $this->itemToString($item);
            }
        }

        foreach ($stylesheets as $media=>$styles) {
            $item = new stdClass();
            $item->rel = 'stylesheet';
            $item->type = 'text/css';
            $item->href = $this->getMinUrl() . '?f=' . implode(',', $styles);
            $item->media = $media;
            $item->conditionalStylesheet = false;
            $items[] = $this->itemToString($item);
        }

        return implode($this->_escape($this->getSeparator()), $items);
    }

    public function getMinUrl()
    {
        return $this->view->rootUrl() . '/min/';
    }
}


