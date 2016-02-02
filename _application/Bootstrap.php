<?php

class Bootstrap
        extends Zend_Application_Bootstrap_Bootstrap
{
  /**
   * Fungsi untuk inisialisasi Document Type untuk view
   */
  protected function _initDoctype()
  {
    $this->bootstrap('view');
    $view = $this->getResource('view');
    $view->setEncoding('UTF-8');
    $view->doctype('XHTML1_TRANSITIONAL');
    $view->headMeta()->appendHttpEquiv('Content-Type',
                                       'text/html;charset=utf-8');
  }

  /**
   * Fungsi untuk inisialisasi autoload
   */
  protected function _initAutoload()
  {
    // Create an autoloader that will enable us to automatically load resources
    $moduleLoader = new Zend_Application_Module_Autoloader(array(
                'namespace' => '',
                'basePath'  => APPLICATION_PATH));
    Zend_Controller_Action_HelperBroker::addPrefix('Budpar_Action_Helper');
    $moduleLoader->addResourceType('library', '../library/Budpar/',
                                   'Budpar');
    $moduleLoader->addResourceType('adminLibrary',
                                   'modules/admin/library', 'Library_');
    $moduleLoader->addResourceType('adminForms',
                                   'modules/admin/forms',
                                   'Admin_Form_');
    $moduleLoader->addResourceType('adminModels',
                                   'modules/admin/models',
                                   'Admin_Model_');
    return $moduleLoader;
  }

  /**
   * Fungsi untuk mendeklarasikan modules
   */
  protected function _initModules()
  {
    $this->bootstrap('frontcontroller');
    $front = $this->getResource('frontcontroller');
    $front->addModuleDirectory(dirname(__FILE__) . '/modules');
  }

  /**
   * Fungsi untuk inisialisasi action helper budpar
   */
  protected function _initActionHelpers()
  {
    Zend_Controller_Action_HelperBroker::addPrefix('Budpar_Controller_Action_Helper');
  }

  /**
   * Fungsi untuk inisialisasi view
   */
  protected function _initView()
  {
    // Initialize view
    $view = new Zend_View();
    $view->headTitle('Budpar 2010');

    /* ZendX_JQuery::enableView($view);

      $view->addHelperPath('ZendX/JQuery/View/Helper',
      'ZendX_JQuery_View_Helper'); */
    $view->addHelperPath(APPLICATION_PATH . '/../library/Budpar/View/Helper/',
                         'Budpar_View_Helper');

    // Add it to the ViewRenderer
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                    'ViewRenderer'
    );
    $viewRenderer->setView($view);

    // Return it, so that it can be stored by the bootstrap
    return $view;
  }

  /**
   * Fungsi untuk inisialisasi key third party yang digunakan 
   */
  protected function _initKeyThirdParty()
  {
    $fbApiKey      = '';
    $fbAppSecret   = '';
    $gmapKey       = '';
    $gsearchApiKey = '';

    if (APPLICATION_ENV == 'development') {
      $fbAppId       = '116092178427152';
      $fbApiKey      = '0ae4535808eae9176c0331c1f3046ee4';
      $fbAppSecret   = '057d06fa6be5bee36584b9a2d4c0b572';
      $gmapKey2      = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
      $gmapKey       = 'AIzaSyCsFyU7d8CXc1nUIr7QVq-fBXSJjaM4rV4';
      $gsearchApiKey = 'ABQIAAAApfS5wSxrb7kgWGwU-M1a8BRkcn0mjacIfqIgDowzNA_jEcFtLBTe_2UI9tkQp9TbXC8o3w2Zxq4eng';
    } else {
      $fbAppId       = '128278523861210';
      $fbApiKey      = '45639e07b4d5830f72eeeba4514b65df';
      $fbAppSecret   = 'e88206b8f61d8716813da8025d3ce65c';
      //$gmapKey = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
      $gmapKey2      = 'ABQIAAAA4l_aTvb-Ccy0LPmnmpLkQxRB93edaK5BFbO7xsagv6wBifXTbxSwGovo4GTJ46u0W13gusb05hq-RA';
      $gmapKey       = 'AIzaSyCsFyU7d8CXc1nUIr7QVq-fBXSJjaM4rV4';
      $gsearchApiKey = 'ABQIAAAApfS5wSxrb7kgWGwU-M1a8BSupX9BTWPrXFeLbEPEDfDzeW63jhRNrH2L8n515oNlSSs5gxLJ3uI9xA';
    }

    Zend_Registry::set('gsearchApiKey', $gsearchApiKey); //Google Search API key
    Zend_Registry::set('fb_app_id', $fbAppId); //Facebook API key
    Zend_Registry::set('fb_api_key', $fbApiKey); //Facebook API key
    Zend_Registry::set('fb_app_secret', $fbAppSecret); //Facebook Application Secret
    Zend_Registry::set('gmap_key', $gmapKey); // new Google Map API
    Zend_Registry::set('gmap_key2', $gmapKey2); // old Google Map API
    Zend_Registry::set('recaptcha_public_key',
                       '6LfhlgUAAAAAAH80xL2h8wbxvSV0zb4_SsxGtQ1h');
    Zend_Registry::set('recaptcha_private_key',
                       '6LfhlgUAAAAAAB_ilPWjL_vAfePjRWrMnyOM7IZa');
    Zend_Registry::set('google_search_key',
                       '013865057979380924967:jyd9i2bhmve');
  }

  public function _initDatabases()
  {
    $this->bootstrap('multidb');
    $resource = $this->getPluginResource('multidb');
    Zend_Registry::set('read', $resource->getDb('read'));
    Zend_Registry::set('write', $resource->getDb('write'));
  }

  /**
   * Fungsi inisialisasi custom router
   */
  public function _initRoutes()
  {
    // For later use
    $front  = Zend_Controller_Front::getInstance();
    $router = $front->getRouter();
    //$router->removeDefaultRoutes();

    $route = new Zend_Controller_Router_Route(':language/:controller/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'index',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('front', $route);

    // Untuk meng-cover router url dengan detail
    $route = new Zend_Controller_Router_Route(':language/:controller/detail/:id/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'index',
                        'action'     => 'detail',
                        'id'         => '1',
                    )
    );
    $router->addRoute('front-detail', $route);

    // Untuk meng-cover router url dengan menggunakan view
    $route = new Zend_Controller_Router_Route(':language/:controller/view/:id/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'index',
                        'action'     => 'detail',
                        'id'         => '1',
                    )
    );
    $router->addRoute('front-view', $route);

    // Router untuk event detail yg berasal dari hasil pencarian event
    $route = new Zend_Controller_Router_Route(':language/event/detail/:id/:title/date-start/:dateStart/date-end/:dateEnd',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'event',
                        'action'     => 'detail',
                        'id'         => '\d+',
                        'title'      => 'title',
                        'dateStart'  => 'date',
                        'dateEnd'    => 'date',
                    )
    );
    $router->addRoute('detail-event-with-search', $route);

    // Router untuk destinasi
    $route = new Zend_Controller_Router_Route(':language/culture/:destId/:destTitle/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'destination',
                        'action'     => 'index',
                        'destTitle'  => '.+' // Biar bisa diakses tanpa title
                    ),
                    array(
                        'destId' => '\d+',
                    )
    );
    $router->addRoute('dest-action', $route);
    
    $route = new Zend_Controller_Router_Route(':language/culture/posts/*',
                array(
                    'language'      => 'id',
                    'module'        => 'default',
                    'controller'    => 'destination',
                    'action'        =>' posts'
                )
            );
    $router->addRoute('posts',$route);

    // Router untuk tourism operator di halaman destinasi
    $route = new Zend_Controller_Router_Route(':language/destination/:destId/:destTitle/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'tourism-operator',
                    ),
                    array(
                        'action'    => 'findtravel|findhotel|findrestaurant|findsouvenir',
                        'destId'    => '\d+',
                        'destTitle' => '.+',
                        'language'  => 'en|id'
                    )
    );
    $router->addRoute('dest-tourism', $route);

    // Router untuk tourism operator detail
    $route = new Zend_Controller_Router_Route(':language/destination/:destId/:destTitle/:type/detail/:tourismId/:tourismTitle',
                    array(
                        'language'     => 'id',
                        'module'       => 'default',
                        'controller'   => 'tourism-operator',
                        'action'       => 'detail',
                        'tourismId'    => '\d+',
                        'tourismTitle' => '',
                    ),
                    array(
                        'type'      => 'findtravel|findhotel|findrestaurant|findsouvenir',
                        'destId'    => '\d+',
                        'destTitle' => '.+',
                        'language'  => 'en|id'
                    )
    );
    $router->addRoute('dest-tourism-detail', $route);

    // Router untuk review di halaman destinasi
    $route = new Zend_Controller_Router_Route(':language/destination/:destId/:destTitle/review/:action/:reviewId',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'review',
                        'action'     => 'index',
                        'reviewId'   => '1',
                    ),
                    array(
                        'destId'    => '\d+',
                        'destTitle' => '.+',
                    )
    );
    $router->addRoute('dest-review', $route);

    $route = new Zend_Controller_Router_Route(':language/destination/:destId/:destTitle/article/:articleId/:articleTitle',
                    array(
                        'language'     => 'id',
                        'module'       => 'default',
                        'controller'   => 'article',
                        'action'       => 'detail-in-dest',
                        'destId'       => '\d+',
                        'destTitle'    => '\s+',
                        'articleId'    => '\d+',
                        'articleTitle' => '\s+'
                    )
    );
    $router->addRoute('dest-article', $route);

    $route = new Zend_Controller_Router_Route(':language/destination/search/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'destination',
                        'action'     => 'search',
                    )
    );
    $router->addRoute('dest-search', $route);

    $route = new Zend_Controller_Router_Route(':language/map/destination/:id',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'map',
                        'action'     => 'index',
                        'id'         => '\d+'
                    )
    );
    $router->addRoute('map-detail', $route);
    /* $routeRegex = new Zend_Controller_Router_Route_Regex(':language/:controller/:action/(\d+)/(.+)/*',
      array(
      'language'   => 'en',
      'module'     => 'default',
      'controller' => 'index',
      'action'     => 'detail'
      ),
      array(
      1 => 'id',
      2 => 'title'
      ),
      ':language/:controller/:action/%d/%s'

      );
      $router->addRoute('detail', $routeRegex); */

    $route = new Zend_Controller_Router_Route(':language/discover-indonesia/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'glance',
                    )
    );
    $router->addRoute('discover-indonesia', $route);

    $route = new Zend_Controller_Router_Route(':language/discover-indonesia/region-detail/:id/:title',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'region-detail',
                        'id'         => '\d+',
                        'title'      => '\s+'
                    )
    );
    $router->addRoute('discover-indonesia-region-detail', $route);

    $route = new Zend_Controller_Router_Route(':language/travel-information/:action',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'immigration',
                    )
    );
    $router->addRoute('travel-information', $route);

    $route = new Zend_Controller_Router_Route(':language/travel-information/general-information',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'general',
                    )
    );
    $router->addRoute('general-information', $route);

    $route = new Zend_Controller_Router_Route(':language/travel-information/foreign-representatives/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'foreign',
                    )
    );
    $router->addRoute('foreign-representatives', $route);

    $route = new Zend_Controller_Router_Route(':language/travel-information/indonesian-phrases',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'saying',
                    )
    );
    $router->addRoute('indonesia-phrases', $route);

    $route = new Zend_Controller_Router_Route(':language/travel-information/do-dont',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'do',
                    )
    );
    $router->addRoute('do-dont', $route);

    $route = new Zend_Controller_Router_Route(':language/frequently-asked-questions/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'faq',
                    )
    );
    $router->addRoute('faq', $route);

    $route = new Zend_Controller_Router_Route(':language/terms-and-conditions/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'terms',
                    )
    );
    $router->addRoute('terms', $route);

    $route = new Zend_Controller_Router_Route(':language/privacy-policy/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'policy',
                    )
    );
    $router->addRoute('policy', $route);

    $route = new Zend_Controller_Router_Route(':language/site-map/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'static',
                        'action'     => 'sitemap',
                    )
    );
    $router->addRoute('site-map', $route);

    $route = new Zend_Controller_Router_Route('admin/:controller/:action/*',
                    array(
                        'module'     => 'admin',
                        'controller' => 'index',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('admin', $route);

    $route = new Zend_Controller_Router_Route('admin/culture/:action/*', array(
                'module'     => 'admin',
                'controller' => 'destination',
                'action'     => 'index'
            ));
    $router->addRoute('culture', $route);

    $route = new Zend_Controller_Router_Route(':language/category/:action/:id', array(
                'language'   => 'id',
                'module'     => 'default',
                'controller' => 'category',
                'action'     => 'index',
                'id'         => '',
            ));
    $router->addRoute('category', $route);

    $route = new Zend_Controller_Router_Route(':language/category/:parentid/detail/:id/*/', array(
                'language'   => 'id',
                'module'     => 'default',
                'controller' => 'category',
                'action'     => 'detail',
                'id'         => '',                
            ));
    $router->addRoute('subcategory', $route);

    $route = new Zend_Controller_Router_Route(':language/related-link/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'RelatedLinks',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('RelatedLinks', $route);

    $route = new Zend_Controller_Router_Route(':language/redirect/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'index',
                        'action'     => 'redirect',
                    )
    );
    $router->addRoute('Redirect', $route);

    $route = new Zend_Controller_Router_Route(':language/photoessay/filter/:datefilter/:categoryfilter/*',
                    array(
                        'language'       => 'id',
                        'module'         => 'default',
                        'controller'     => 'photoessay',
                        'action'         => 'index',
                        'datefilter'     => 'February-2011',
                        'categoryfilter' => '0'
                    )
    );
    $router->addRoute('photoessay', $route);

    // Router untuk tourism operator detail (hasil searching)
    $route = new Zend_Controller_Router_Route(':language/tourismoperator/detailsingle/:tourismId',
                    array(
                        'language'     => 'id',
                        'module'       => 'default',
                        'controller'   => 'tourism-operator',
                        'action'       => 'detailsingle',
                        'tourismId'    => '\d+',
                        'tourismTitle' => '',
                    ),
                    array(
                        'language' => 'en|id'
                    )
    );
    $router->addRoute('search-tourism-detail', $route);


    // route untuk gallery di destinasi
    $route = new Zend_Controller_Router_Route(':language/destination/:destId/:destTitle/gallery/page/:page',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'destination',
                        'action'     => 'gallery',
                        'destId'     => '\d+',
                        'destTitle'  => '\s+',
                        'page'       => '\d+',
                    )
    );
    $router->addRoute('dest-gallery', $route);

    // Route untuk manage (user contributor backend)
    $route = new Zend_Controller_Router_Route('manage/:controller/:action/*',
                    array(
                        'module'     => 'manage',
                        'controller' => 'index',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('manage', $route);

//        // Router untuk usercontributor
//	$route = new Zend_Controller_Router_Route(':language/usercontributor/:contentId/:title',
//	array(
//	    'language'   => 'en',
//			    'contentId'  => 0,
//			    'controller' => 'usercontributor',
//			    'action'     => 'detail'),
//	array(
//	      'contentId' => '\d+',
//	      'title' => '\d+')
//	    );
//	$router->addRoute('usercontributor', $route);
    // Router untuk usercontributor di aliaskan menjadi travelers-stories
    $route = new Zend_Controller_Router_Route(':language/travelers-stories/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'usercontributor',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('travelers-stories', $route);

    // Router untuk usercontributor detail di aliaskan menjadi travelers-stories-detail
    $route = new Zend_Controller_Router_Route(':language/travelers-stories-detail/:type/:id/:title/',
                    array(
                        'language'   => 'id',
                        'module'     => 'default',
                        'controller' => 'usercontributor',
                        'action'     => 'detail',
                        'type'       => '\s+',
                        'id'         => '\d+',
                        'title'      => '\s+',
                    )
    );
    $router->addRoute('travelers-stories-detail', $route);


    // route untuk M.I.C.E
    $route = new Zend_Controller_Router_Route('mice/:language/:controller/:action/*',
                    array(
                        'language'   => 'id',
                        'module'     => 'mice',
                        'controller' => 'index',
                        'action'     => 'index',
                    )
    );
    $router->addRoute('mice', $route);

    $route = new Zend_Controller_Router_Route('mice/:language/search/page/:page',
                    array(
                        'language'   => 'id',
                        'module'     => 'mice',
                        'controller' => 'search',
                        'action'     => 'index',
                        'page'       => '\d+'
                    )
    );
    $router->addRoute('mice_search', $route);

    // route untuk M.I.C.E Destination / complex
    $route = new Zend_Controller_Router_Route('mice/:language/destination/:id/:title/',
                    array(
                        'language'   => 'id',
                        'module'     => 'mice',
                        'controller' => 'home',
                        'action'     => 'index',
                    ),
                    array(
                        'id'    => '\d+',
                        'title' => '.+',
                    )
    );
    $router->addRoute('mice-destination', $route);

    // route nearby destination - M.I.C.E
    $route = new Zend_Controller_Router_Route('mice/:language/nearby-destination/:id/:title/page/:page',
                    array(
                        'language'   => 'id',
                        'module'     => 'mice',
                        'controller' => 'home',
                        'action'     => 'destination',
                    ),
                    array(
                        'page'  => '\d+',
                        'id'    => '\d+',
                        'title' => '.+',
                    )
    );
    $router->addRoute('mice-nearbydestination', $route);

    // route nearby facilities and services
    $route = new Zend_Controller_Router_Route('mice/:language/services-facilities/:id/:title/:taxonomy/page/:page',
                    array(
                        'language'   => 'id',
                        'module'     => 'mice',
                        'controller' => 'home',
                        'action'     => 'hotel-and-travel',
                    ),
                    array(
                        'taxonomy' => '.+',
                        'page'     => '\d+',
                        'id'       => '\d+',
                        'title'    => '.+',
                    )
    );
    $router->addRoute('mice-nearbyservices', $route);


    $route = new Zend_Controller_Router_Route(':language/tokoh-kebudayaan', array(
                'module'     => 'default',
                'controller' => 'article',
                'action'     => 'index',
                'category'   => 1
            ));

    $router->addRoute('tokoh', $route);

    $route = new Zend_Controller_Router_Route(':language/tokoh-kebudayaan/:id/:title', array(
                'module'     => 'default',
                'controller' => 'article',
                'action'     => 'detail',
                'category'   => 1,
                'title'      => '.+'
            ));

    $router->addRoute('tokoh-detail', $route);

    $route = new Zend_Controller_Router_Route(':language/komunitas-kebudayaan', array(
                'module'     => 'default',
                'controller' => 'article',
                'action'     => 'index',
                'category'   => 2
            ));

    $router->addRoute('komunitas', $route);

    $route = new Zend_Controller_Router_Route(':language/komunitas-kebudayaan/:id/:title', array(
                'module'     => 'default',
                'controller' => 'article',
                'action'     => 'detail',
                'category'   => 2,
                'title'      => '.+'
            ));

    $router->addRoute('komunitas-detail', $route);
    
    $route = new Zend_Controller_Router_Route(':language/search/:action/keyword/:key',array(
                'module' => 'default',
                'controller' =>'search',
                'action' => 'index',
                'key' =>'.+'
    ));
    $router->addRoute('search',$route);

  }

  public function _initAuthPlugin()
  {
    Zend_Controller_Front::getInstance()->registerPlugin(new Budpar_Controller_Plugin_AccessPlugin(Zend_Auth::getInstance()));
  }

}
