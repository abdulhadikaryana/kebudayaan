<?php

/**
 * Model_DbTable_Event
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel event
 *
 * @package DbTable Model
 */
class Model_DbTable_Event extends Zend_Db_Table_Abstract
{
  //deklarasi table yang digunakan dalam model event
  protected $_name = 'event';
  protected $_table = 'eventdesc';
  protected $_primary = 'event_id';
  protected $_log = 'logadmin';
  protected $_account = 'admin_account';
  protected $_category = 'category';

  const ARCHIVED = 0;
  const DRAFT = 1;
  const PENDING = 2;
  const PUBLISH = 3;
  const LANGUAGE_ID = 1;
  const LANGUAGE_EN = 2;

  public function findAll($filter = null, $language_id = self::LANGUAGE_ID, $user_id = null)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_table,
                    "{$this->_name}.event_id = {$this->_table}.event_id",
                    array('name'))
            ->columns(array('isTranslated' => "(
              SELECT COUNT(*) 
              FROM {$this->_table} 
              WHERE event_id = {$this->_name}.event_id
              AND language_id = 2)"))
            ->joinLeft($this->_category,
                    "{$this->_name}.category = {$this->_category}.category_id",
                    array('category' => 'name'))
            ->joinLeft(array('created_by' => $this->_account),
                    "{$this->_name}.user_id = created_by.admin_id",
                    array('created_by' => 'username'))
            ->joinLeft(array('updated_by' => $this->_account),
                    "{$this->_name}.updated_by = updated_by.admin_id",
                    array('updated_by' => 'username'))
            ->joinLeft(array('approved_by' => $this->_account),
                    "{$this->_name}.approved_by = approved_by.admin_id",
                    array('approved_by' => 'username'))
            ->where("{$this->_table}.language_id = ?", $language_id)
    ;

    if (null != $user_id) $select->where("user_id = ?", $user_id);

    if (null == $filter['status']
            || self::ARCHIVED != $filter['status']) $select->where("status != ?",
              self::ARCHIVED);

    if (null != $filter) {
      if (null != $filter['name']) {
        $select->where("{$this->_table}.name LIKE ?",
                "%{$filter['name']}%");
      }
      if (null != $filter['status']) {
        $select->where("{$this->_name}.status = ?", $filter['status']);
      }
      if (null != $filter['sort']) {
        $select->order("{$filter['sort']} {$filter['order']}");
      }
    }
    $result = $this->fetchAll($select);
    return $result;
  }

  public function findStatusesCount($user_id = null)
  {
    $select = $this->select()
            ->from($this->_name,
            array(
        'archived' => "SUM(status = 0)",
        'draft'    => "SUM(status = 1)",
        'pending'  => "SUM(status = 2)",
        'publish'  => "SUM(status = 3)"));

    if (null != $user_id) $select->where("user_id = ?", $user_id);

    $result = $this->fetchRow($select);

    return $result;
  }

  /**
   * Fungsi untuk melakukan insert pada tabel event
   * @return array
   */
  public function insertEvent($data)
  {
    $this->insert($data);
    return $this->_db->lastInsertId();
  }

  /**
   * Fungsi untuk melakukan update pada tabel event
   * @return array
   */
  public function updateEvent($data, $event_id)
  {
    $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id);
    $this->update($data, $where);
  }

  /**
   * Fungsi untuk melakukan delete pada tabel event
   * @return array
   */
  public function deleteEvent($event_id)
  {
    $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id);
    $this->delete($where);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel event
   * @return array
   */
  public function getAll()
  {
    $data = $this->select()
            ->from($this->_name);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk menggenerate query dari tabel event berdasarkan parameter yang diberikan
   * @return string
   */
  public function getQueryAllByLang($filter, $param1 = null, $param2 = null, $language_id = 1, $user_id = null)
  {
    $select = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('e' => $this->_name),
                    array('event_id', 'dstart' => 'DATE(date_start)', 'dend'   => 'DATE(date_end)', 'category', 'date_start', 'date_end', 'main_pics', 'status'))
            ->join(array('ed' => $this->_table),
                    'ed.event_id = e.event_id',
                    array('name', 'description'))
            ->join(array('cd' => 'categorydescription'),
                    'cd.category_id = e.category',
                    array('category_name' => 'cd.name'))
            ->where('cd.language_id = ?', $language_id)
            ->where('ed.language_id = ?', $language_id)
            ->where('e.status = ?', self::PUBLISH);

    if (null != $user_id) {
      $select->where("user_id", $user_id);
    }

    switch ($filter) {
      case 1 : $select->where("ed.name LIKE '%" . $param1 . "%'");
        break;
      case 2 : $select->join(array('pte' => 'poitoevent'),
                'pte.event_id = e.event_id', array('poi_id'));
        $select->join(array('pd' => 'poidescription'),
                'pd.poi_id = pte.poi_id', array());
        $select->where('pd.language_id = ?', $language_id);
        $select->where("pd.name LIKE '%" . $param1 . "%'");
        $select->order('pd.poi_id');
        break;
      case 3 : $select->where('e.category = ?', $param1);
        break;
      case 4 : $process_date = TRUE;
        break;
    }

//        if($process_date)
    if ($process_date = FALSE) {
      if (($param1 != null) && ($param2 != null)) {
        $select->where("(date(e.date_start) BETWEEN '" . $param1 . "' AND '" . $param2 . "'");
        $select->orWhere("date(e.date_end) BETWEEN '" . $param1 . "' AND '" . $param2 . "'");
        $select->orWhere("date(e.date_start) < '" . $param1 . "' AND date(e.date_end)> '" . $param2 . "')");
      } elseif (($param1 != null) && ($param2 == null)) {
        $select->where("date(e.date_start) >= '" . $param1 . "'");
      } elseif (($param2 != null) && ($param1 == null)) {
        $select->where("date(e.date_end) <= '" . $param2 . "'");
      }
      $select->where('ed.language_id = ?', $language_id);
    }

    $select->order('e.date_start DESC');
    $select->group('e.event_id');
    return $select;
  }

  /**
   * Fungsi untuk mengambil data event dari dua rentang waktu yang diberikan
   * @param date $start, date $end, integer $language_id
   * @return string
   */
  public function getEventInRange($start, $end, $language_id = 1)
  {
    $query = $this->getQueryAllByLang(4, $start, $end, $language_id);
    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel event dan tabel eventdesc
   * berdasarkan language_id yang diberikan
   * 
   * @param integer $lang_id
   * @return array
   */
  public function getAllWithDesc($lang_id = 1)
  {
    $data = $this->select()
            ->from($this->_name)
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id")
            ->setIntegrityCheck(false)
            ->where("{$this->_name}.status = 3")
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->order('time_created desc');
    return $this->fetchAll($data);
  }

  public function getAllWithDescForRss($lang_id = 1, $limit = '')
  {
    $query = $this->select()
            ->from($this->_name)
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id")
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->setIntegrityCheck(false)
            ->order('date_start DESC');

    if (!empty($limit)) {
      $query->limit($limit, 0);
    }

    return $query;
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel event dan tabel eventdesc
   * berdasarkan language_id dan event_id yang diberikan
   * 
   * @param integer $event_id
   * @param integer $lang_id
   * @return array
   */
  public function getAllWithDescById($event_id, $lang_id = 1)
  {
    $data = $this->select()
            ->from($this->_name)
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id")
            ->setIntegrityCheck(false)
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->where("{$this->_name}.event_id = ?", $event_id);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk mengambil 4 date event terakhir
   * @return array
   * @deprecated functionality replaced by get fourClosestEvent
   */
  public function getThreeLatestEvent($languageID = 1)
  {
    $data = $this->select()
            ->from($this->_name,
                    array('event_id', 'date_start', 'date_end', 'main_pics'))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->setIntegrityCheck(false)
            ->where("{$this->_table}.language_id = ?", $languageID)
            ->order('date_start DESC')
            ->limit(4, 0);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk mengambil 4 event terdekat dengan tanggal sekarang
   * @return array
   * @version 1.0
   */
  public function getFourClosestEvent($languageID = 1)
  {
    $currentDate = date('Y-m-d', time());
    $noSignDiff = "IF((SIGN(DATEDIFF(date_start,'" . $currentDate . "')) = -1)," .
            "(((DATEDIFF(date_start,'" . $currentDate . "'))*(DATEDIFF(date_start,'" . $currentDate . "')))" .
            " / (-1*(DATEDIFF(date_start,'" . $currentDate . "')))),(DATEDIFF(date_start,'" . $currentDate . "')))" .
            " AS NoSignDiff";

    $query = $this->select()
            ->distinct()
            ->setIntegrityCheck(false)
            ->from($this->_name,
                    array('event_id', 'date_start', 'date_end', 'main_pics', $noSignDiff))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->where("{$this->_table}.language_id = ?", $languageID)
            ->order('NOSignDiff ASC')
            ->where("DATEDIFF(date_start, '" . $currentDate . "') >= 0")
            ->where("status = ?", self::PUBLISH)
            ->limit(4, 0);

    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengambil main pics dari event yang paling terakhir
   * @return array
   */
  public function getMainPicsLatestEvent()
  {
    $data = $this->select()
            ->from($this->_name, array('main_pics'))
            ->order('date_start DESC')
            ->limit(1, 0);
    $return = $this->fetchRow($data);
    return $return;
  }

  /**
   * Fungsi untuk mengambil start date dan end_date dari tabel event berdasarkan
   * event_id yang diberikan
   *
   * @param integer $event_id
   * @return array
   */
  public function getDateStartEndById($event_id)
  {
    $data = $this->select()
            ->from($this->_name, array('date_start', 'date_end'))
            ->where('event_id = ?', $event_id);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk mengambil main pics dari tabel event berdasarkan event_id
   * yang diberikan
   *
   * @param integer $event_id
   * @return array
   */
  public function getMainPicsById($event_id)
  {
    $data = $this->select()
            ->from($this->_name, array('main_pics'))
            ->where('event_id = ?', $event_id);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel event berdasarkan event_id
   * yang diberikan
   * @param integer $event_id
   * @return array
   */
  public function getAllById($event_id)
  {
    $data = $this->select()
            ->from($this->_name)
            ->where('event_id = ?', $event_id);
    return $this->fetchAll($data);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel event kecuali yang mempunyai
   * event_id sesuai yang diberikan
   *
   * @param integer $event_id
   * @return array
   */
  public function getAllExId($event_id)
  {
    $data = $this->select()
            ->from($this->_name)
            ->where('event_id != ?', $event_id);
    return $this->fetchAll($data);
  }

  public function getEventLatestByIdLang($langId, $sortingOptions = null, $limit = false, $status = Model_DbTable_Event::PUBLISH)
  {
    $daythis = date('Y-m-d H:i:s');

    //ambil data
    $query = $this->select()
            ->from($this->_name)
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->setIntegrityCheck(false)
            ->where("{$this->_name}.date_end >= ?", $daythis)
            ->where("{$this->_name}.status = ?", $status)
            ->where("{$this->_table}.language_id = ?", $langId)
            ->order("{$this->_name}.date_start DESC");

    if ($limit) {
      $query->limit($limit, 0);
    }

    $sortBy = $this->_getSortBy($sortingOptions['sort_by'],
            $sortingOptions['sort_order']);

    $query->order($sortBy);

    $data = $this->fetchAll($query);
    $return = $data->toArray();

    return $return;
  }

  /**
   * Fungsi untuk mendukung sorting
   *
   * @param string $sort field sorting
   * @param string $sortOrder urutan sorting
   *
   * @return string gabungan antara $sort dan $sortOrder
   */
  private function _getSortBy($sort = 'name', $sortOrder = 'DESC')
  {
//        if ($sortOrder == '') {
//            $sortOrder = 'DESC';
//        }
//
//        $sortBy = '';
//
//        if($sort == 'name')
//            $sortBy = "{$this->_td}.name";
//        else
//            $sortBy = "{$this->_td}.name";
//
//        return $sortBy . ' ' . $sortOrder;
    return "";
  }

  /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -* */
  /* jul                                                                                                  */
  /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -* */
  /*
    menampilakan hasil pencarian pada tabel event dan eventdesc berdasarkan
    parameter (kata kunci) yang di request

   */
  public function suggestEvent($param, $lang_id)
  {

    $data = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('event_id'))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->where("{$this->_table}.name like '%$param%'");
    //->limit(10);
    return $this->fetchAll($data);
  }

  public function searchEventFix($param, $limit = 10, $offset = 0, $lang_id)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('event_id'))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->limit($limit, $offset);

    $key = explode(' ', $param);
    if (is_array($key)) {
      $string = '';
      $string2 = '';
      for ($i = 0; $i < sizeof($key); $i++) {
        if ($i != sizeof($key) - 1) {
          $string .= "{$this->_table}.name like '%$key[$i]%' OR ";
          $string2 .= "{$this->_table}.description like '%$key[$i]%' OR ";
        } else {
          $string .= "{$this->_table}.name like '%$key[$i]%'";
          $string2 .= "{$this->_table}.description like '%$key[$i]%'";
        }
      }
      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');

      //$query->where($string);
      //$query->orWhere($string2);
    } else {

      $string = "{$this->_table}.name like '%$param%'";
      $string2 = "{$this->_table}.description like '%$param%'";

      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');

      //$query->where("{$this->_table}.name like '%$param%'");
      //$query->orWhere("{$this->_table}.description like '%$param%'");
    }

    $result = $this->fetchAll($query);

    if (count($result)) {
      return $result;
      //return $result->toArray();    
    } else {
      return null;
    }
  }

  public function searchEventBaru($param, $limit = 10, $offset = 0, $lang_id)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('event_id'))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->where("{$this->_table}.language_id = ?", $lang_id)
            ->where("{$this->_name}.status = 3");
    //->limit($limit,$offset);

    $key = explode(' ', $param);
    if (is_array($key)) {
      $string = '';
      $string2 = '';
      for ($i = 0; $i < sizeof($key); $i++) {
        if ($i != sizeof($key) - 1) {
          $string .= "{$this->_table}.name like '%$key[$i]%' OR ";
          $string2 .= "{$this->_table}.description like '%$key[$i]%' OR ";
        } else {
          $string .= "{$this->_table}.name like '%$key[$i]%'";
          $string2 .= "{$this->_table}.description like '%$key[$i]%'";
        }
      }
      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');
    } else {

      $string = "{$this->_table}.name like '%$param%'";
      $string2 = "{$this->_table}.description like '%$param%'";

      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');
    }

    $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END LIMIT $offset, $limit";
    $query .= $string_order;

    //echo $query;

    $q = $this->_db->query($query);
    $result = $q->fetchAll();

    if (count($result)) {
      //return $query;
      return $result;
    } else {
      return null;
    }
  }

  public function numbRowsEvent($param, $lang_id)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('event_id'))
            ->join($this->_table,
                    "{$this->_table}.event_id = {$this->_name}.event_id",
                    array('name', 'description'))
            ->where("{$this->_table}.language_id = ?", $lang_id);
    //->limit($limit,$offset);

    $key = explode(' ', $param);
    if (is_array($key)) {
      $string = '';
      $string2 = '';
      for ($i = 0; $i < sizeof($key); $i++) {
        if ($i != sizeof($key) - 1) {
          $string .= "{$this->_table}.name like '%$key[$i]%' OR ";
          $string2 .= "{$this->_table}.description like '%$key[$i]%' OR ";
        } else {
          $string .= "{$this->_table}.name like '%$key[$i]%'";
          $string2 .= "{$this->_table}.description like '%$key[$i]%'";
        }
      }
      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');
    } else {

      $string = "{$this->_table}.name like '%$param%'";
      $string2 = "{$this->_table}.description like '%$param%'";

      $query->where('(' . $string . '');
      $query->orWhere('' . $string2 . ')');
    }

    $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END";
    $query .= $string_order;

    $q = $this->_db->query($query);
    $result = $q->fetchAll();

    if (count($result)) {
      //return $query;
      return count($result);
    } else {
      return null;
    }

    //$result = $this->fetchAll($query);
    //
        //if(count($result))
    //{
    //    return count($result);
    //}
    //else
    //{
    //    return null;
    //}
  }

  /*
    update data
   */
  public function updateField($eventId, array $data)
  {

    $where = $this->getAdapter()->quoteInto('event_id = ?', $eventId);

    $this->update($data, $where);
  }

  //Query API buat mobile ---------------------------------------------------------------------------
  public function api_getAllWithDesc($param)
  {
    $data = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('e' => $this->_name))
            ->join(array('ed' => $this->_table),
                    'ed.event_id = e.event_id')
            ->where("ed.language_id = ?", $param['languageId'])
            ->limit($param['limit'], $param['offset']);

    if ($param['sortby'] != '') {
      switch ($param['sortby']) {
        case 'name' : $data->order('ed.name ' . $param['sortorder']);
          break;
      }
    }

    return $this->fetchAll($data)->toArray();
  }

  public function api_getAllWithoutDesc($param)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('e' => $this->_name),
                    array('event_id', 'time_created', 'date_start', 'date_end', 'viewer'))
            ->join(array('ed' => $this->_table),
                    'ed.event_id = e.event_id',
                    array('language_id', 'name', 'description'))
            //->join(array('ed' => $this->_table),'ed.event_id = e.event_id',array('language_id','name','fnStripTags(description) as description'))
            ->where("ed.language_id = ?", $param['languageId']);
    //->where("e.time_created != '0000-00-00 00:00:00'")
    //if enabled paging
    if ($param['paging']) {
      $query->limit($param['limit'], $param['offset']);
    }

    /*
     * $param['intervalType'] = type of interval, string (day/week/month/year)
     * $param['intervalValue'] = value of interval type, int
     * */
    if (isset($param['intervalType']) AND !empty($param['intervalValue'])) {
      switch (strtolower(trim($param['intervalType']))) {
        case 'day' :
          if ($param['rule'] == 1) { // before & after from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] DAY) AND (NOW() + INTERVAL $param[intervalValue] DAY)");
          } elseif ($param['rule'] == 2) {  // just before from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] DAY) AND NOW()");
          } elseif ($param['rule'] == 3) { // just after from now
            $query->where("e.date_start BETWEEN NOW() AND (NOW() + INTERVAL $param[intervalValue] DAY)");
            $query->where("e.date_end <= (NOW() + INTERVAL $param[intervalValue] DAY)");
          }
          break;

        case 'week' :
          if ($param['rule'] == 1) { // before & after from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] WEEK) AND (NOW() + INTERVAL $param[intervalValue] WEEK)");
          } elseif ($param['rule'] == 2) {  // just before from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] WEEK) AND NOW()");
          } elseif ($param['rule'] == 3) { // just after from now
            $query->where("e.date_start BETWEEN NOW() AND (NOW() + INTERVAL $param[intervalValue] WEEK)");
            $query->where("e.date_end <= (NOW() + INTERVAL $param[intervalValue] WEEK)");
          }
          break;

        case 'month' :
          if ($param['rule'] == 1) { // before & after from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] MONTH) AND (NOW() + INTERVAL $param[intervalValue] MONTH)");
          } elseif ($param['rule'] == 2) {  // just before from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] MONTH) AND NOW()");
          } elseif ($param['rule'] == 3) { // just after from now
            $query->where("e.date_start BETWEEN NOW() AND (NOW() + INTERVAL $param[intervalValue] MONTH)");
            $query->where("e.date_end <= (NOW() + INTERVAL $param[intervalValue] MONTH)");
          }
          break;
        case 'year' :
          if ($param['rule'] == 1) { // before & after from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] YEAR) AND (NOW() + INTERVAL $param[intervalValue] YEAR)");
          } elseif ($param['rule'] == 2) {  // just before from now
            $query->where("e.date_start BETWEEN (NOW() - INTERVAL $param[intervalValue] YEAR) AND NOW()");
          } elseif ($param['rule'] == 3) { // just after from now
            $query->where("e.date_start BETWEEN NOW() AND (NOW() + INTERVAL $param[intervalValue] YEAR)");
            $query->where("e.date_end <= (NOW() + INTERVAL $param[intervalValue] YEAR)");
          }
          break;
      }
    } else {
      //default, query data between interval min 6 month from now and plus 6 month from now
      $query->where("e.date_start BETWEEN (NOW() - INTERVAL 6 MONTH) AND (NOW() + INTERVAL 6 MONTH)");
    }

    if ($param['sortby'] != '') {
      switch ($param['sortby']) {
        case 'name' : $query->order('ed.name ' . $param['sortorder']);
          break;
        case 'start' : $query->order('e.date_start ' . $param['sortorder']);
          break;
      }
    }
//
    return $this->fetchAll($query)->toArray();
  }

  public function getAuthor($id, $languageId)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_account,
                    "{$this->_name}.user_id = {$this->_account}.admin_id")
            ->where("{$this->_name}.event_id = ?", $id);
    $data = $this->fetchAll($query);
    return $data;
  }

  public function getLatestPost($limit)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_table)
            ->join($this->_name,
                    "{$this->_table}.event_id = {$this->_name}.event_id")
            ->join($this->_account,
                    "{$this->_name}.user_id = {$this->_account}.admin_id",
                    array('admin_name' => 'name'))
            ->where("{$this->_name}.status = '3'")
            ->order("{$this->_table}.event_id DESC")
            ->limit($limit)
    ;
    $data = $this->fetchAll($query);
    return $data;
  }

  public function getLatestDraft($limit)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_table)
            ->join($this->_name,
                    "{$this->_table}.event_id = {$this->_name}.event_id")
            ->join($this->_account,
                    "{$this->_name}.user_id = {$this->_account}.admin_id",
                    array('admin_name' => 'name'))
            ->where("{$this->_name}.status = '1'")
            ->order("{$this->_table}.event_id DESC")
            ->limit($limit)
    ;
    $data = $this->fetchAll($query);
    return $data;
  }

}
?>