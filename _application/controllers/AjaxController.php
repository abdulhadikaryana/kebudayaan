<?php

/**
 * AjaxController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * ajax yg digunakan di beberapa controller sekaligus
 * 
 * @package Front Controller
 */
class AjaxController
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

    $this->_helper->layout()->disableLayout();

    /*        if( ! $this->_request->isXmlHttpRequest()) {
      $this->_redirector->gotoUrl('/');
      } */
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk menampilkan slide header
   */
  public function slideheaderAction()
  {
    //model
    $highlightDb = new Model_DbTable_Highlight;

    //data
    $highlightType = 3;

    // Language ga bisa dipake dari $_languageId dari parent-nya sehingga
    // menggunakan zend registry
    $highlight = $highlightDb->getMainType($highlightType,
                                           Zend_Registry::get('languageId'));

    //view
    $this->_helper->layout()->disableLayout();
    $this->view->imageData = $highlight;
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk mendapatkan provinsi berdasarkan area island yang diberikan
   */
  public function islandAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $areaId = $this->_getParam('areaId');

    // Model
    $areaDb = new Model_DbTable_Area;

    // Data
    $data = $areaDb->getAllAreaChildByParent($areaId,
                                             'Select Province');

    // Output
    echo $this->view->formSelect('province', "", array(), $data);
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk mendapatkan destinasi berdasarkan kategori
   *       Digunakan untuk map
   */
  public function destinationByCategoryAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $categoryId = $this->_getParam('categoryId');

    // Model
    //$destModel = new Model_Destination;
    $destDescDb = new Model_DbTable_DestinationDescription;

    // Data
    $destination = $destDescDb->getAllByCategoryList($categoryId,
                                                     $this->_languageId);

    $destinationData = $this->_createArrayDestination($destination);

    echo json_encode($destinationData);
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk mendapatkan destinasi berdasarkan area
   *       Digunakan untuk map
   */
  public function destinationByAreaAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $areaId = $this->_getParam('areaId');

    // Model
    $destDescDb = new Model_DbTable_DestinationDescription;

    // Data
    $destination = $destDescDb->getAllByAreaList($areaId,
                                                 $this->_languageId);

    $destinationData = $this->_createArrayDestination($destination);

    echo json_encode($destinationData);
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk mendapatkan destinasi berdasarkan nama
   *       Digunakan di map
   */
  public function destinationByNameAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $name = $this->_getParam('name');

    // Model
    $destDescDb = new Model_DbTable_DestinationDescription;

    // Data
    $destination = $destDescDb->getSearchByName($name,
                                                $this->_languageId);

    $destinationData = $this->_createArrayDestination($destination);

    echo json_encode($destinationData);
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk mendapatkan destinasi berdasarkan id yang diberikan
   */
  public function destinationByIdAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $poiId = $this->_getParam('poiId');

    // Model
    $destinationDb = new Model_DbTable_Destination;

    // Data
    $destination = $destinationDb->getWithDescForMapByPoiId($poiId,
                                                            $this->_languageId);

    $destinationData = $this->_createArrayDestination($destination);

    echo json_encode($destinationData);
  }

  /**
   * IS: 
   * FS: 
   * Desc: Fungsi AJAX untuk mendapatkan koordinate dari area
   * 
   * @return bentuk JSON dari koordinate
   */
  public function areaCoordinateAction()
  {
    // Tidak pake view
    $this->_helper->viewRenderer->setNoRender(true);

    // Param
    $areaId = $this->_getParam('areaId');

    // query ke db
    $areaDb = new Model_DbTable_Area;
    $result = $areaDb->getCoordinateById($areaId);

    echo json_encode($result);
  }
  
  /**
   * IS: 
   * FS: 
   * Desc: Fungsi untuk membentuk array destinasi dengan mengikutsertakan
   *       gambar dan tipe kategori dari destinasi tersebut
   * 
   * @param <type> $destination
   * @return <type> Fungsi
   */
  private function _createArrayDestination($destination)
  {
    // Model
    $customCommon = new Budpar_Custom_Common;
    $imageDb      = new Model_DbTable_Image;
    $catToPoiDb   = new Model_DbTable_CategoryToPoi;

    // Looping
    $newData = array();
    foreach ($destination as $counter => $row) {

      // Dapatkan gambar
      $image = $imageDb->getImageSourceById($row['poi_id']);

      // Dapatkan kategori
      $category = $catToPoiDb->getCategoryByPoiId($row['poi_id'],
                                                  $this->_languageId);

      $newData[$counter] = array(
          'id'          => $row['poi_id'],
          'name'        => $row['poi_name'],
          'description' => $customCommon->truncate($row['description'],
                                                   120),
          'pointX'      => $row['pointX'],
          'pointY'      => $row['pointY'],
          'special'     => $row['special'],
          'category'    => $category->toArray(),
          'image'       => basename($image)
      );
    }

    return $newData;
  }

  /**
   * IS: Language id, start date, end date terdeklarasi
   * FS: Mengirimkan data event ke view
   * Desc: Membuat halaman feed dalam format JSon untuk halaman calendar
   */
  public function eventlistAction()
  {
    //get Start date and End date Parameter
    $startDate = $this->unixToMySQL($this->_getParam('start'));
    $endDate   = $this->unixToMySQL($this->_getParam('end'));
    //create eventDb Instance
    $eventDb   = new Model_DbTable_Event;
    $data      = $eventDb->getEventInRange($startDate, $endDate,
                                           $this->_languageId);
    if (sizeof($data) > 0) {
      $this->view->list = $this->formatFullCalendar($data->toArray());
    } else {
      $this->view->fake = array();
    }
    $this->view->layout()->disableLayout();
    $this->render('generate-event');
  }

  /**
   * Feed for full calendar in JSON format 
   */
  protected function formatFullCalendar(array $data)
  {
    $newData = array();
    foreach ($data as $value) {
      //separate date and time
      $startArr  = explode(' ', $value['date_start']);
      $endArr    = explode(' ', $value['date_end']);
      $dateStart = explode('-', $startArr[0]);
      $dateEnd   = explode('-', $endArr[0]);
      $dataArr   = array();
      //check if it is an one day event or long event
      //if it is then disable the allday events
      if ($startArr[0] == $endArr[0]) {
        $dataArr['start'] = $value['date_start'];
        $dataArr['end']   = $value['date_end'];
        //Handling data error (one day event with wrong start/end time)
        //Construct the start/end time
        if ($startArr[1] != $endArr[1]) {
          $dataArr['allDay'] = false;
        }
      } else {
        $dataArr['start'] = $value['dstart'];
        $dataArr['end']   = $value['dend'];
      }

      //save another data into the array
      $dataArr['id']          = $value['event_id'];
      $dataArr['title']       = htmlspecialchars_decode($value['name'],
                                                        ENT_QUOTES);
      //construct the url
      $dataArr['url']         = $this->view->baseUrl('/event/detail/' .
              $value['event_id'] . '/' . $this->view->makeUrlFormat($dataArr['title']));
      $dataArr['picture']     = $value['main_pics'];
      $dataArr['description'] = $this->view->truncate(
              strip_tags($this->view->HtmlDecode($value['description'])),
                                                 250);
      array_push($newData, $dataArr);
    }
    return $newData;
  }

  protected function unixToMySQL($timestamp)
  {
    return date('Y-m-d H:i:s', $timestamp);
  }

  public function pollingAction()
  {
    $tbl_answer  = new Model_DbTable_Answer();
    $tbl_polling = new Model_DbTable_Polling();
    $polling     = $tbl_polling->getActivePolling();
    $cookie      = false;
    if ($this->getRequest()->isPost()
            && $this->getRequest()->isXMLHttpRequest()) {

      $answer = $tbl_answer->find($this->getRequest()
                              ->getPost('answer'))->current();
      $answer->setFromArray(array('total' => $answer->total + 1))
              ->save();
      $cookie = setcookie($polling->polling_id, true,
                          time() + 60 * 60 * 24 * 30);
    }

    $answers             = $tbl_answer->getAllWithResult($polling->polling_id);
    $this->view->polling = $polling;
    $this->view->answers = $answers;

    if ($this->getRequest()->getCookie($polling->polling_id) || $cookie) {
      $this->renderScript('ajax/result.phtml');
    }
  }

}