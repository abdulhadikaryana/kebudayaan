<?php
/**
 * ShareSave Helper
 * 
 * Digunakan sebagai helper untuk
 * membuat tombol share/save/bookmark
 * @author Sangkuriang Studio 
 * @package user helper
 */
class Zend_View_Helper_ShareSave {
    /**
     * view untuk Zend
     * @var object
     */
    public $view;
    
    /**
     * Fungsi untuk menge-set view dari Zend
     * @param Zend_View_Interface $view
     * @return 
     */
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
    
    /**
     * Fungsi untuk membuat tombol ShareSave
     * @param string $url
     * @return string $html
     */
    public function shareSave() {
        $url = $this->view->baseUrl().'/'.$this->view->currentUrl();
        $html = "
		  <div id=\"sharesave\">
			<a class=\"a2a_dd\" href='http://www.addtoany.com/share_save?linkname=&amp;linkurl=www.indonesia.travel'>
		    <img src='http://static.addtoany.com/buttons/share_save_171_16.png' width=\"171\" height=\"16\" style=\"border:none;\" alt=\"Share/Save/Bookmark Visit Indonesia\"/></a>
		  </div>";

        return $html;
    }
}

