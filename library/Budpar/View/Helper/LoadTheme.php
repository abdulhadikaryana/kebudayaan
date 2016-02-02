<?php
/**
 * Budpar_View_Helper_LoadTheme
 *
 * Helper untuk me-load theme yang digunakan
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_LoadTheme extends Zend_View_Helper_Abstract
{
    /**
     * Fungsi untuk load theme
     *
     * @param string $theme nama theme
     */
    public function loadTheme($theme)
    {
        $this->view->headLink()
                   ->appendStylesheet('/themes/' . $theme . '/' . $theme . '.css');
    }
}
