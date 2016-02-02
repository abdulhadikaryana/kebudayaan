<?php

/**
 * EventController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * event
 *
 * @package Front Controller
 */
class EventController extends Budpar_Controller_Common {

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init() {
        parent::init();

        $this->view->bigPageTitle = $this->view->translate('Event');
        $this->view->bgClass = "yellow";
    }

    /**
     * IS: Parameter sortby, sortorder terdeklarasi
     * FS: Mengirimkan ke viewer: event
     * Desc: Fungsi untuk menampilkan daftar event
     */
    public function indexAction() {
        
        $this->_helper->layout->setLayout('kebudayaan');
        $eventDb = new Model_DbTable_Event;
        $event = $eventDb->getAllWithDesc($this->_languageId);

        $this->view->event = $event;
        $this->view->count = count($event);
    }

    /**
     * IS: Parameter year, month terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, weeksInMonth, yearMonth, days, 
     *     event, eventDescDb, languageId 
     * Desc: Fungsi untuk menampilkan calendar
     */
    /* public function calendarAction()
      {
      // Param
      // - Tahun
      if($this->_hasParam('year')) {
      $year = $this->_getParam('year');
      } else {
      $year = date('Y');
      }

      // - Bulan
      if($this->_hasParam('month')) {
      $month = $this->_getParam('month');
      } else {
      $month = date('m');
      }

      $year = '2010';
      $month = '01';

      // Membuat tanggal berdasarkan parameter diatas
      $tempDate = mktime(0, 0, 0, (int)$month, 1, $year);
      $daysInMonth = date("t", $tempDate); // Jumlah hari per bulan
      $firstDay = date("w", $tempDate); // Hari pertama

      // Model
      $eventModel = new Model_Event;

      // Data
      $weeksInMonth = $eventModel->getWeeksInMonth($daysInMonth, $firstDay);
      $days = $eventModel->getDaysInMonth($weeksInMonth, $daysInMonth, $firstDay);
      $event = $eventModel->getAllSearchEvent($year.'-'.$month.'-01',
      $year.'-'.$month.'-31');

      //echo "<pre>";
      //print_r($events);

      // View
      $this->view->pageTitle = 'Events Calendar';
      $this->view->weeksInMonth = $weeksInMonth;
      $this->view->yearMonth = $year . "-" . $month;
      $this->view->days = $days;
      $this->view->event = parent::setPaginator($event);
      $this->view->eventDescDb = new Model_DbTable_EventDesc;
      $this->view->languageId = $this->_languageId;

      if($this->_request->isXmlHttpRequest()){
      $this->_helper->layout()->disableLayout();
      $this->render('grid-calendar');
      }
      $this->render('grid-calendar');
      // Model
      $eventDb = new Model_DbTable_Event;

      // Data
      $event = $eventDb->getAllWithDesc($this->_languageId);

      // View
      $this->view->event = parent::setPaginator($event);
      }
     */

    /**
     * IS: -
     * FS: Merender template full-calendar.phtml 
     * Desc: Fungsi untuk menampilkan detail event dengan format calendar
     */
    public function calendarAction() {
        $this->_helper->layout->setLayout('one-column');

        $searchTitle = $this->view->translate('id_more_read_event');
        $this->view->test = $searchTitle;

        $this->render('full-calendar');
    }

    /**
     * IS: Language id, start date, end date terdeklarasi
     * FS: Mengirimkan data event ke view
     * Desc: Membuat halaman feed dalam format JSon untuk halaman calendar
     */
    public function eventlistAction() {
        //get Start date and End date Parameter
        $startDate = $this->unixToMySQL($this->_getParam('start'));
        $endDate = $this->unixToMySQL($this->_getParam('end'));
        //create eventDb Instance
        $eventDb = new Model_DbTable_Event;
        $data = $eventDb->getEventInRange($startDate, $endDate, $this->_languageId);
        if (sizeof($data) > 0) {
            $this->view->list = $this->formatFullCalendar($data->toArray());
        } else {
            //prevent calendar from error when theres no JSon Feed Data
            $fakeData = array(
                array(
                    'id' => 111,
                    'title' => "Independence Day",
                    'start' => "1945-08-17",
                    'end' => "1945-08-17"
                )
            );
            $this->view->fake = $fakeData;
        }
        $this->view->layout()->disableLayout();
        $this->render('generate-event');
    }

    protected function formatFullCalendar(array $data) {
        $newData = array();
        foreach ($data as $value) {
            //separate date and time
            $startArr = explode(' ', $value['date_start']);
            $endArr = explode(' ', $value['date_end']);
            $dateStart = explode('-', $startArr[0]);
            $dateEnd = explode('-', $endArr[0]);
            $dataArr = array();
            //check if it is an one day event or long event
            //if it is then disable the allday events
            if ($startArr[0] == $endArr[0]) {
                $dataArr['start'] = $value['date_start'];
                $dataArr['end'] = $value['date_end'];
                //Handling data error (one day event with wrong start/end time)
                //Construct the start/end time
                if ($startArr[1] != $endArr[1]) {
                    $dataArr['allDay'] = false;
                }
            } else {
                $dataArr['start'] = $value['dstart'];
                $dataArr['end'] = $value['dend'];
            }
            //save another data into the array
            $dataArr['id'] = $value['event_id'];
            $dataArr['title'] = htmlspecialchars_decode($value['name'], ENT_QUOTES);
            //construct the url
            $dataArr['url'] = $this->view->baseUrl('/event/detail/' .
                    $value['event_id'] . '/' . $this->view->makeUrlFormat($dataArr['title']));
            $dataArr['picture'] = $value['main_pics'];
            $dataArr['description'] = $this->view->truncate(
                    strip_tags($this->view->HtmlDecode($value['description'])), 250);
            array_push($newData, $dataArr);
        }
        return $newData;
    }

    protected function unixToMySQL($timestamp) {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * IS: Parameter id, title terdeklarasi
     * FS: Mengirimkan ke viewer: event, poiRelated, comments, commentForm
     * Desc: Fungsi untuk menampilkan detail event
     */
    public function detailAction() {
        // Variable
        $contentType = 2;

        // Param
        $id = $this->_getParam('id');
        $title = $this->_getParam('title');


        // Model
        $eventDb = new Model_DbTable_Event;
        $poiToEventDb = new Model_DbTable_PoiToEvent;


        // Data
        $event = $eventDb->getAllWithDescById($id, $this->_languageId);
        $author = $eventDb->getAuthor($id, $this->_languageId);
        //if description is empty, will be redirecting to calender event
//	if($event[0]['description'])
//	{
        //update data viewer, hanya di incremen 1 saja setiap kali content detail di load
        $eventDb->updateField($id, array('viewer' => $event[0]['viewer'] + 1));

        $poiRelated = $poiToEventDb->getAllPoiNameByEventId($id, $this->_languageId);

        // View
        $this->view->event = $event[0];
        $this->view->poiRelated = $poiRelated;
//            $this->view->author = $author['name'];
//	}
//	else
//	{
//	    $this->_redirector->gotoUrl($this->view->baseUrl('/event/calendar/'));	    
//	}
    }

    /**
     * IS: Parameter date-start, date-end, sortby, sortorder terdeklarasi
     * FS: Mengirimkan ke viewer: event, formattedDateStart, formattedDateEnd
     * Desc: Fungsi untuk menampilkan halaman hasil pencarian
     */
    public function searchAction() {
        if ($this->_hasParam('date-start')) {
            // Param
            $dateStart = $this->_getParam('date-start');
            $dateEnd = $this->_getParam('date-end');
            $sortBy = $this->_getParam('sortby');
            $sortOrder = $this->_getParam('sortorder', 'desc');

            // Model
            $eventModel = new Model_Event;

            // Data
            $event = $eventModel->getAllSearchEvent($dateStart, $dateEnd, array('sort_by' => $sortBy,
                'sort_order' => $sortOrder), $this->_languageId);

            // format tanggal ke bentuk yang lebih manusiawi
            $format = "j M Y";
            $formattedDateStart = date($format, strtotime($dateStart));
            $formattedDateEnd = date($format, strtotime($dateEnd));

            // menentukan title
            if ($dateStart == $dateEnd)
                $titlePage = 'Event Search Result For ' . $formattedDateStart; // satu tanggal
            else // jika range tanggal
                $titlePage = 'Event Search Result From ' . $formattedDateStart . ' To ' . $formattedDateEnd;

            $this->_generateSorter($sortBy, $sortOrder);

            // View
            $this->view->event = parent::setPaginator($event);
            $this->view->formattedDateStart = $dateStart;
            $this->view->formattedDateEnd = $dateEnd;

            // Render
            $this->render('index');
        }
    }

    /**
     * IS: Parameter id, dateStart, dateEnd terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb() {
        $listTitle = $this->view->translate('id_menu_calendarevents');
        $searchTitle = $this->view->translate('event_search');
        $texthomelink = $this->view->translate('id_menu_home');

        if ($this->_hasParam('id')) {
            // Param
            $eventId = $this->_getParam('id');

            // Model
            $eventDescDb = new Model_DbTable_EventDesc;

            // Data
            $eventTitle = $eventDescDb->getNameById($eventId, $this->_languageId);
        }

        $links = null;

        switch ($this->_request->getActionName()) {
            case 'detail':
                if ($this->_hasParam('dateStart')) {
                    $title = $searchTitle;
                    $url = $this->view->baseUrl('event/search/date-start/' .
                            $this->_getParam('dateStart') . '/date-end/' .
                            $this->_getParam('dateEnd'));
                } else {
                    $title = $listTitle;
                    $url = $this->view->baseUrl('event');
                }

                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $url,
                    $eventTitle => '',
                );
                $this->view->pageTitle = $eventTitle;
                break;
            case 'search':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $searchTitle => '',
                );
                $this->view->pageTitle = $searchTitle;
                break;
            case 'index':
            default:
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => '',
                );
                $this->view->pageTitle = $listTitle;
        }
        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: nameSort, sortBy, sortOrder
     * Desc: Fungsi untuk generate sorter
     */
    private function _generateSorter($sortBy, $sortOrder) {
        // Model
        $sorter = new Model_Sorter;

        // Data
        $nameSort = $sorter->getSorter('name', $sortBy, $sortOrder);

        // View
        $this->view->nameSort = $nameSort;
        $this->view->sortBy = $sortBy;
        $this->view->sortOrder = strtolower($sortOrder);
    }

    public function rssAction() {
        // Tidak pake layout
        $this->_helper->layout->disableLayout();

        // Model
        $eventDb = new Model_DbTable_Event;

        $lang_id = $this->_languageId;

        // Data
        $eventQuery = $eventDb->getAllWithDescForRss($lang_id, 10);
        $event = $eventDb->fetchAll($eventQuery);
        for ($i = 0; $i < count($event); $i++) {
            $string = $event[$i]['name'];
            $string = str_replace('“', ' ', $string);
            $string = str_replace('”', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $news[$i]['name'] = $this->xmlEntities(htmlentities($string, ENT_QUOTES));

            $string = $event[$i]['description'];
            $string = str_replace('“', ' ', $string);
            $string = str_replace('”', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $news[$i]['description'] = $this->xmlEntities(htmlentities($news[$i]['content'], ENT_QUOTES));
        }

        $this->view->data = $event;
    }

    protected function xmlEntities($str) {
        $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
        $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
        $str = str_replace($html, $xml, $str);
        $str = str_ireplace($html, $xml, $str);
        return $str;
    }

}