<?php
/**
 * ArticleController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * article
 *
 * @package Front Controller
 */
class ArticleController
        extends Budpar_Controller_Common
{
  /**
   * IS: -
   * FS: -
   * Desc: Fungsi inisialisasi
   */
  public function init()
  {
    parent::init();

    switch ($this->_languageId) {
      case 1: $langLocale             = 'en';
        break;
      case 2: $langLocale             = 'id';
        break;
    }
    $this->view->languageID = $langLocale;

    if ($this->_hasParam('destId')) {

      $imageDb = new Model_DbTable_Image;

      $imageGallery = $imageDb->getAllImageGalleryByPoiId($this->_destId);

      $this->view->imageGallery = $imageGallery;
    }

    $category                 = $this->getRequest()->getParam('category');
    $title                    = $this->getTitle($category);
    $this->view->bigPageTitle = $title;
    $this->view->bgClass      = "orange";
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: article
   * Desc: Fungsi untuk menampilkan daftar attraction
   */
  public function indexAction()
  {

    $category = $this->getRequest()->getParam('category');
    $title    = $this->getTitle($category);

    // Model
    $articleDb = new Model_DbTable_Article;

    // Data
    $article             = $articleDb->findAll($this->_languageId,
            $category);
    // View
    $this->view->title   = $title;
    $this->view->article = parent::setPaginator($article);
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: article
   * Desc: Fungsi untuk menampilkan detail attraction
   */
  public function detailAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $category = $this->getRequest()->getParam('category');
    $title    = $this->getTitle($category);

    // Param
    $id = $this->_getParam('id');

    // Model
    $articleDb = new Model_DbTable_Article;
    // Data
    $article = $articleDb->findWithDescription($id, $this->_languageId);
    $this->view->title   = $title;
    $this->view->article = $article;
  }

  protected function countView($destId)
  {
    $db = new Model_DbTable_Destination();

    $data = $db->pageViewer($destId);
    return $data;
  }

  /**
   * IS: Parameter articleId terdeklarasi
   * FS: Mengirimkan ke viewer: article, pageTitle
   * Desc: Fungsi untuk menampilkan attraction
   */
  public function detailInDestAction()
  {
    $this->_helper->layout->setLayout('one-column');

    //$this->_helper->layout()->disableLayout();
    //$this->_helper->viewRenderer->setNoRender(true);

    $exurl  = explode('/', $this->view->currentUrl());
    $newUrl = array_splice($exurl, 0, 9);
    $url    = implode("/", $newUrl);

    //echo $url;
    //print_r($newUrl);
    //echo $url;
    // Param
    $articleId = $this->_getParam('articleId');
    $destId    = $this->_getParam('destId');

    $this->view->pageViewer = $this->countView($destId);

    // Model
    $articleDb = new Model_DbTable_Article;

    // Data
    $article = $articleDb->getAllWithDescByLanguageId($articleId,
            $this->_languageId, true);

    //if content is empty, will be redirecting to list of article
    if ($article['description']) {
      $article['description'] = str_replace("../../../../",
              "../../../../../../", $article['content']);

      // Breadrumb
      $pageTitle = $this->view->HtmlDecode($article['name']);
      $this->_generateDescBreadcrumb($pageTitle);

      // Passing ke view
      $this->view->pageTitle   = $pageTitle;
      $this->view->article     = $article;
      $this->view->main_images = $article['image'];

      //realated link
      $linkModel                = new Model_DbTable_RelatedArticleAttraction();
      $this->view->related_link = $linkModel->getByArticleId($articleId,
              $this->_languageId);
    } else {
      $this->_redirector->gotoUrl($url);
    }
  }

  private function getTitle($articleCategory)
  {
    $title = '';
    switch ($articleCategory) {
      case 1:
        $title = $this->view->translate('Figures');
        break;
      case 2:
        $title = $this->view->translate('Community');
        break;
    }
    return $title;
  }

  private function getUrl($articleCategory)
  {
    $url = '';
    switch ($articleCategory) {
      case 1:
        $url = $this->view->baseUrl('tokoh-kebudayaan');
        break;
      case 2:
        $url = $this->view->baseUrl('community');
        break;
    }
    return $url;
  }

  protected function _generateBreadcrumb()
  {

    $category  = $this->_getParam('category');
    $listTitle = $this->getTitle($category);
    $listUrl   = $this->getUrl($category);

    if ($this->_hasParam('id')) {
      $articleId     = $this->_getParam('id');
      $articleDescDb = new Model_DbTable_Article;
      $articleTitle  = $articleDescDb->getTitleById($articleId,
              $this->_languageId);
    }
    $texthomelink  = $this->view->translate('id_menu_home');
    $links         = null;
    switch ($this->_request->getActionName()) {
      case 'detail':
        $links = array(
            $texthomelink          => $this->view->baseUrl('/'),
            $listTitle             => $listUrl,
            $articleTitle          => '',
        );
        $this->view->pageTitle = $articleTitle;
        break;
      case 'index':
      default:
        $links                 = array(
            $texthomelink          => $this->view->baseUrl('/'),
            $listTitle             => '',
        );
        $this->view->pageTitle = $listTitle;
    }
    Zend_Registry::set('breadcrumb', $links);
  }

}