<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Fungsi untuk inisialisasi Document Type untuk view
     */
    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_TRANSITIONAL');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
    }

    /**
     * Fungsi untuk inisialisasi autoload
     */
    protected function _initAutoload() {
        // Create an autoloader that will enable us to automatically load resources
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH));
        Zend_Controller_Action_HelperBroker::addPrefix('Budpar_Action_Helper');
        $moduleLoader->addResourceType('library', '../library/Budpar/', 'Budpar');
        $moduleLoader->addResourceType('adminLibrary', 'modules/admin/library', 'Library_');
        $moduleLoader->addResourceType('adminForms', 'modules/admin/forms', 'Admin_Form_');
        $moduleLoader->addResourceType('adminModels', 'modules/admin/models', 'Admin_Model_');
        return $moduleLoader;
    }

    /**
     * Fungsi untuk mendeklarasikan modules
     */
    protected function _initModules() {
        $this->bootstrap('frontcontroller');
        $front = $this->getResource('frontcontroller');
        $front->addModuleDirectory(dirname(__FILE__) . '/modules');
    }

    /**
     * Fungsi untuk inisialisasi action helper budpar
     */
    protected function _initActionHelpers() {
        Zend_Controller_Action_HelperBroker::addPrefix('Budpar_Controller_Action_Helper');
    }

    /**
     * Fungsi untuk inisialisasi view
     */
    protected function _initView() {

        // Initialize view
        $view = new Zend_View();

        /* ZendX_JQuery::enableView($view);

          $view->addHelperPath('ZendX/JQuery/View/Helper',
          'ZendX_JQuery_View_Helper'); */
        $view->addHelperPath(APPLICATION_PATH . '/../library/Budpar/View/Helper/', 'Budpar_View_Helper');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'View_Helper');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker:: getStaticHelper(
                        'ViewRenderer'
        );
        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    /**
     * Fungsi untuk inisialisasi key third party yang digunakan 
     */
    protected function _initKeyThirdParty() {
        $fbApiKey = '';
        $fbAppSecret = '';
        $gmapKey = '';
        $gsearchApiKey = '';

        if (APPLICATION_ENV == 'development') {
            $fbAppId = '116092178427152';
            $fbApiKey = '0ae4535808eae9176c0331c1f3046ee4';
            $fbAppSecret = '057d06fa6be5bee36584b9a2d4c0b572';
            $gmapKey2 = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
            $gmapKey = 'AIzaSyCsFyU7d8CXc1nUIr7QVq-fBXSJjaM4rV4';
            $gsearchApiKey = 'ABQIAAAApfS5wSxrb7kgWGwU-M1a8BRkcn0mjacIfqIgDowzNA_jEcFtLBTe_2UI9tkQp9TbXC8o3w2Zxq4eng';
        } else {
            $fbAppId = '128278523861210';
            $fbApiKey = '45639e07b4d5830f72eeeba4514b65df';
            $fbAppSecret = 'e88206b8f61d8716813da8025d3ce65c';
            //$gmapKey = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
            $gmapKey2 = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
            $gmapKey = 'AIzaSyCsFyU7d8CXc1nUIr7QVq-fBXSJjaM4rV4';
            $gsearchApiKey = 'ABQIAAAApfS5wSxrb7kgWGwU-M1a8BSupX9BTWPrXFeLbEPEDfDzeW63jhRNrH2L8n515oNlSSs5gxLJ3uI9xA';
        }

        Zend_Registry::set('gsearchApiKey', $gsearchApiKey); //Google Search API key
        Zend_Registry::set('fb_app_id', $fbAppId); //Facebook API key
        Zend_Registry::set('fb_api_key', $fbApiKey); //Facebook API key
        Zend_Registry::set('fb_app_secret', $fbAppSecret); //Facebook Application Secret
        Zend_Registry::set('gmap_key', $gmapKey); // new Google Map API
        Zend_Registry::set('gmap_key2', $gmapKey2); // old Google Map API
        Zend_Registry::set('recaptcha_public_key', '6LfhlgUAAAAAAH80xL2h8wbxvSV0zb4_SsxGtQ1h');
        Zend_Registry::set('recaptcha_private_key', '6LfhlgUAAAAAAB_ilPWjL_vAfePjRWrMnyOM7IZa');
        Zend_Registry::set('google_search_key', '013865057979380924967:jyd9i2bhmve');
    }

    public function _initDatabases() {
        $this->bootstrap('multidb');
        $resource = $this->getPluginResource('multidb');
        Zend_Registry::set('read', $resource->getDb('read'));
        Zend_Registry::set('write', $resource->getDb('write'));
    }

    /**
     * Fungsi inisialisasi custom router
     */
    public function _initRoutes() {
        // For later use
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        //$router->removeDefaultRoutes();

        // Home
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'index',
            'action' => 'index'
        );

        $route = new Zend_Controller_Router_Route('/', $settings);
        $router->addRoute('beranda', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/home', $settings);
        $router->addRoute('home', $route);

        // index kebudayaan
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'culture',
            'action' => 'posts',
            'page' => '.+'
        );

        $route = new Zend_Controller_Router_Route('/kebudayaan/:page', $settings);
        $router->addRoute('kebudayaan', $route);
        // english route
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/culture/:page', $settings);
        $router->addRoute('culture', $route);

        // detail kebudayaan
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'culture',
            'action' => 'index'
        );
        $route = new Zend_Controller_Router_Route('/kebudayaan/:destId/:slug', $settings);
        $router->addRoute('detail-kebudayaan', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/culture/:destId/:slug', $settings);
        $router->addRoute('culture-detail', $route);

        // redirect kebudayaan
        $route = new Zend_Controller_Router_Route(':language/:culture/:destId/:slug', array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'culture',
            'action' => 'redirect',
            'slug' => '.+' // Biar bisa diakses tanpa title
                ), array('culture' => '(kebudayaan|culture)')
        );
        $router->addRoute('culture-redirect', $route);

        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'news',
            'action' => 'index',
            'page' => '.+'
        );
        $route = new Zend_Controller_Router_Route('/berita/:page', $settings);
        $router->addRoute('berita', $route);
        $settings['language'] = 'en';

        $route = new Zend_Controller_Router_Route('/news/:page', $settings);
        $router->addRoute('news', $route);

        // detail berita
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'news',
            'action' => 'detail'
        );
        $route = new Zend_Controller_Router_Route('/berita/:id/:slug', $settings);
        $router->addRoute('detail-berita', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/news/:id/:slug', $settings);
        $router->addRoute('news-detail', $route);

        // kontak
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'contact-us',
            'action' => 'index'
        );
        $route = new Zend_Controller_Router_Route('/kontak', $settings);
        $router->addRoute('kontak', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/contact', $settings);
        $router->addRoute('contact', $route);

        // kategori
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'category',
            'action' => 'see-category'
        );

        $route = new Zend_Controller_Router_Route('/kategori/:id/:slug', $settings);
        $router->addRoute('kategori', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/category/:id/:slug', $settings);
        $router->addRoute('category', $route);


        // subcategory
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'category',
            'action' => 'detail',
            'page' => '.+'
        );

        $route = new Zend_Controller_Router_Route('/subkategori/:id/:slug/:page', $settings);
        $router->addRoute('subkategori', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/subcategory/:id/:slug/:page', $settings);
        $router->addRoute('subcategory', $route);

        // map router
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'map',
            'action' => 'index'
        );
        $route = new Zend_Controller_Router_Route('/peta', $settings);
        $router->addRoute('peta', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/map', $settings);
        $router->addRoute('map', $route);

        // gallery router
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'gallery',
            'action' => 'index'
        );
        $route = new Zend_Controller_Router_Route('/galeri', $settings);
        $router->addRoute('galeri', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/gallery', $settings);
        $router->addRoute('gallery', $route);

        // chart router
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'chart',
            'action' => 'index'
        );
        $route = new Zend_Controller_Router_Route('/grafik', $settings);
        $router->addRoute('grafik', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/chart', $settings);
        $router->addRoute('chart', $route);

        // pencarian
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'search',
            'action' => 'index'
        );

        $route = new Zend_Controller_Router_Route('/pencarian', $settings);
        $router->addRoute('pencarian', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/search', $settings);
        $router->addRoute('search', $route);

        // figure
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'figure',
            'action' => 'index',
            'page' => '.+'
        );
        $route = new Zend_Controller_Router_Route('/sosok/:page', $settings);
        $router->addRoute('sosok', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/figure/:page', $settings);
        $router->addRoute('figure', $route);

        // detail sosok
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'figure',
            'action' => 'detail'
        );

        $route = new Zend_Controller_Router_Route('/sosok/:id/:slug', $settings);
        $router->addRoute('detail-sosok', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/figure/:id/:slug', $settings);
        $router->addRoute('figure-detail', $route);

        // kegiatan
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'event',
            'action' => 'index',
            'page' => '.+'
        );

        $route = new Zend_Controller_Router_Route('/kegiatan/:page', $settings);
        $router->addRoute('kegiatan', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/event/:page', $settings);
        $router->addRoute('event', $route);

        // detail event
        $settings = array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'event',
            'action' => 'detail'
        );
        $route = new Zend_Controller_Router_Route('/kegiatan/:id/:slug', $settings);
        $router->addRoute('detail-kegiatan', $route);
        $settings['language'] = 'en';
        $route = new Zend_Controller_Router_Route('/event/:id/:slug', $settings);
        $router->addRoute('event-detail', $route);

        // redirect kebudayaan
        $route = new Zend_Controller_Router_Route(':language/:event/:id/:slug', array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'event',
            'action' => 'redirect',
            'slug' => '.+' // Biar bisa diakses tanpa title
                ), array('event' => '(kegiatan|event)')
        );
        $router->addRoute('event-redirect', $route);

        $route = new Zend_Controller_Router_Route('/:language/api/eventdata', array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'api',
            'action' => 'eventdata'
        ));
        $router->addRoute('eventdata', $route);

        $route = new Zend_Controller_Router_Route('/:language/ajax/:action', array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'ajax',
            'action' => 'index'
        ));
        $router->addRoute('ajax', $route);


        $route = new Zend_Controller_Router_Route('/:language/chart/:action', array(
            'language' => 'id',
            'module' => 'default',
            'controller' => 'chart',
            'action' => 'category'
        ));
        $router->addRoute('chart-action', $route);

        $route = new Zend_Controller_Router_Route('admin/:controller/:action/*', array(
            'module' => 'admin',
            'controller' => 'index',
            'action' => 'index',
                )
        );
        $router->addRoute('admin', $route);

        $route = new Zend_Controller_Router_Route('admin/culture/:action/*', array(
            'module' => 'admin',
            'controller' => 'destination',
            'action' => 'index'
        ));
        $router->addRoute('destination', $route);
    }

    public function _initAuthPlugin() {
        Zend_Controller_Front::getInstance()->registerPlugin(new Budpar_Controller_Plugin_AccessPlugin(Zend_Auth::getInstance()));
    }

}
