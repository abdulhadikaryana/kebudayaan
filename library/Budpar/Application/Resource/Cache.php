<?php
/**
 * Budpar_Application_Resource_Cache
 * 
 * Kelas untuk inisialisasi cache yang digunakan di Budpar
 * dengan mengambil settingan yang telah ada di application.ini
 * 
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_Application_Resource_Cache
    extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Fungsi inisialisasi
     *
     * @return Zend_Cache
     */
    public function init ()
    {
        // Mendapatkan opsi dari application.ini
        $options = $this->getOptions();

        // Buat objek Zend_Cache
        $cache = Zend_Cache::factory(
            $options['frontEnd'], 
            $options['backEnd'], 
            $options['frontEndOptions'], 
            $options['backEndOptions']);

        // Set ke registry
        Zend_Registry::set('cache', $cache);
        
        return $cache;
    }
}
