<?php

/**
 * Model_DbTable_News
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel news
 *
 * @package DbTable Model
 */
class Model_DbTable_News extends Zend_Db_Table_Abstract {

    //deklarasi tabel yang digunakan dalam model news
    protected $_name = 'news';
    protected $_table = 'news_description';
    protected $_primary = 'id';
    protected $_account = 'admin_account';
    protected $_log = 'logadmin';

    const ARCHIVED = 0;
    const DRAFT = 1;
    const PENDING = 2;
    const PUBLISH = 3;

    public function insertNews($input) {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function updateNews($input, $news_id) {
        $where = $this->getAdapter()->quoteInto('news_id = ?', $news_id);
        $this->update($input, $where);
    }

    public function deleteNews($news_id) {
        $where = $this->getAdapter()->quoteInto('news_id = ?', $news_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel news dan newsdesc berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc($lang_id = 1, $limit = '') {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id")
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id", array("created_by" => "(IFNULL(name, username))"))
                ->where("{$this->_name}.status = 3")
                ->where("{$this->_table}.language_id = ?", $lang_id)
                ->where("{$this->_name}.publish_date <= NOW()")
                ->order(array('publish_date DESC'));

        return $this->fetchAll($query);
    }

    public function getAllWithDescRss($lang_id = 1, $limit = '') {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id")
                ->where("{$this->_name}.status = 3")
                ->where("{$this->_table}.language_id = ?", $lang_id)
                ->order('publish_date DESC');

        if (!empty($limit)) {
            $query->limit($limit, 0);
        }

        return $query;
    }

    public function getAllWithDescById($news_id, $lang_id) {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id")
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id", array("created_by" => "(IFNULL(name, username))"))
                ->where("{$this->_table}.language_id = ?", $lang_id)
                //->where("{$this->_name}.publish_date < NOW()")
                ->where("{$this->_name}.id = ?", $news_id);
        return $this->fetchRow($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel news berdasarkan news_id yang
     * diberikan
     * 
     * @param integer $news_id
     * @return array
     */
    public function getAllById($news_id) {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id = ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel news KECUALI yang mempunyai
     * news_id sesuai dengan yang diberikan
     *
     * @param integer $news_id
     * @return array
     */
    public function getAllExId($news_id) {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id != ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data news_id,picture,publish_date,title,dan content
     * yang paling terakhir
     * 
     * @return array
     */
    public function getLastNews($languageID = 1, $limit = 8) {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image', 'publish_date'))
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id", array('title', 'content'))
                ->where("{$this->_table}.language_id = ?", $languageID)
                ->where("{$this->_name}.status = 3 ")
                ->where("{$this->_name}.publish_date < NOW()")
                ->order('publish_date DESC')
                ->limit($limit, 0);

        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil tiga data news terakhir
     * @return array
     */
    public function getThreeListNews($languageID = 1) {
        $data = $this->select()
                ->from($this->_name, array(''))
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id", array('title'))
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.language_id = ?", $languageID)
                ->order('publish_date DESC')
                ->limit(3, 1);
        return $this->fetchAll($data);
    }

    public function getQueryAllByLanguage($type = 0, $param = null, $month = null, $language_id = 1, $userId = null) {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('n' => $this->_name), array('n.news_id,n.status,DATE(publish_date) AS date', 'status', 'n.status'))
                ->join(array('nd' => $this->_table), 'nd.news_id = n.news_id', array('title'))
                ->where('nd.language_id = ?', $language_id)
                ->where('n.status != ?', "0");
        if (null != $userId) {
            $select->where("n.created_by", $userId);
        }
        switch ($type) {
            case 1: $select->where("nd.title LIKE '%" . $param . "%'");
                break;
            case 2: $select->join(array('pn' => 'poitonews'), 'pn.news_id = n.news_id', array('poi_id'));
                $select->join(array('p' => 'poi'), 'p.poi_id = pn.poi_id');
                $select->join(array('pd' => 'poidescription'), 'pd.poi_id = p.poi_id');
                $select->where("pd.name LIKE '%" . $param . "%'");
                $select->where("pd.language_id = ?", $language_id);
                $select->group('n.news_id');
                break;
            case 3: $select->where('MONTH(n.publish_date) = ?', $month);
                $select->where('YEAR(n.publish_date) = ?', $param);
                break;
            case 4: $select->where("n.status = ?", $param);
                break;
        }
        $select->order('news_id DESC');
        return $select;
    }

    public function getPublishYear() {
        $select = $this->select()
                ->from($this->_name, array('YEAR(publish_date) AS year'))
                ->order('year ASC')
                ->group('year');
        return $this->fetchAll($select)->toArray();
    }

    public function getPictureById($news_id) {
        $select = $this->select()
                ->from($this->_name, array('image'))
                ->where('news_id = ?', $news_id);
        $image = $this->fetchrow($select);
        if (!empty($image)) {
            $image = $image->toArray();
        }
        return $image['image'];
    }

    public function getStatusById($news_id) {
        $select = $this->select()
                ->from($this->_name, array('status'))
                ->where('news_id = ?', $news_id);
        $status = $this->fetchRow($select);
        if (!empty($status)) {
            return $status['status'];
        }
    }

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -* */
    /* jul                                                                                                  */

    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -* */
    /*
      menampilakan hasil pencarian pada tabel news dan newsdesc berdasarkan
      parameter (kata kunci) yang di request

     */
    public function searchNews($param, $limit = 10, $offset = 0, $lang_id) {

        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_table)
                ->where("{$this->_table}.title like '%$param%'")
                ->limit($limit, $offset);
        return $this->fetchAll($data);
    }

    public function searchNewsFix($param, $limit = 10, $offset = 0, $lang_id) {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image'))
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id", array('title', 'content'))
                ->where("{$this->_table}.language_id = ?", $lang_id);

        $key = explode(' ', $param);
        if (is_array($key)) {
            $string = '';
            $string2 = '';
            $string_order = '';
            for ($i = 0; $i < sizeof($key); $i++) {
                if ($i != sizeof($key) - 1) {
                    $string .= "{$this->_table}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%' OR ";
                } else {
                    $string .= "{$this->_table}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%'";
                }
            }

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        } else {


            $string = "{$this->_table}.title like '%$param%'";
            $string2 = "{$this->_table}.content like '%$param%'";


            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        }

        //$string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END LIMIT 0, 12";
        //$query .= $string_order;
//            $new = "SELECT news.news_id, news.picture, newsdesc.title, newsdesc.content FROM news 
//INNER JOIN newsdesc ON newsdesc.news_id = news.news_id 
//WHERE (newsdesc.language_id = '1') AND ((newsdesc.title LIKE '%bali%') OR (newsdesc.content LIKE '%bali%')) 
//ORDER BY CASE WHEN newsdesc.title LIKE '%bali%' THEN 0 WHEN newsdesc.content LIKE '%bali%' THEN 1 ELSE 2 END LIMIT 0, 12";
//        
//        $q = $this->_db->query($new);
//        $result = $q->fetchAll();


        $result = $this->fetchAll($query);


        if (count($result)) {
            //return $query;
            return $result;
        } else {
            return null;
        }
    }

    public function searchNewsBaru($param, $limit = 10, $offset = 0, $lang_id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image'))
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id", array('title', 'content'))
                ->where("{$this->_table}.language_id = ?", $lang_id)
                ->where("{$this->_name}.status = 3");

        $key = explode(' ', $param);
        if (is_array($key)) {
            $string = '';
            $string2 = '';
            $string_order = '';
            for ($i = 0; $i < sizeof($key); $i++) {
                if ($i != sizeof($key) - 1) {
                    $string .= "{$this->_table}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%' OR ";
                } else {
                    $string .= "{$this->_table}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%'";
                }
            }

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        } else {

            $string = "{$this->_table}.title like '%$param%'";
            $string2 = "{$this->_table}.content like '%$param%'";

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END LIMIT $offset, $limit";
        $query .= $string_order;

        $q = $this->_db->query($query);
        $result = $q->fetchAll();

        if (count($result)) {
            //return $query;
            return $result;
        } else {
            return null;
        }
    }

    public function numbRowsNews($param, $lang_id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image'))
                ->join($this->_table, "{$this->_table}.news_id = {$this->_name}.id", array('title', 'content'))
                ->where("{$this->_table}.language_id = ?", $lang_id);
        //->limit($limit,$offset);

        $key = explode(' ', $param);
        if (is_array($key)) {
            $string = '';
            $string2 = '';
            for ($i = 0; $i < sizeof($key); $i++) {
                if ($i != sizeof($key) - 1) {
                    $string .= "{$this->_table}.title like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%' OR ";
                } else {
                    $string .= "{$this->_table}.title like '%$key[$i]%'";
                    $string2 .= "{$this->_table}.content like '%$key[$i]%'";
                }
            }

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        } else {


            $string = "{$this->_table}.title like '%$param%'";
            $string2 = "{$this->_table}.content like '%$param%'";


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
        //    //return $query;
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

    public function updateField($newsId, array $data) {

        $where = $this->getAdapter()->quoteInto('news_id = ?', $newsId);

        $this->update($data, $where);
    }

    public function getAuthor($id, $languageId) {
        $query = $this->select()
                ->setIntegrityCheck(false)
//                ->from($this->_log)
//                ->join($this->_name,"{$this->_log}.content_id = {$this->_name}.id")
//                ->join($this->_account,"{$this->_log}.user_id = {$this->_account}.admin_id")
//                ->where("{$this->_log}.action = 'create'")
//                ->where("{$this->_name}.id = ?",$id);
                ->from($this->_name)
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id")
                ->where("{$this->_name}.id = ?", $id);
        ;

        //echo $query->__toString();        
        $data = $this->fetchAll($query);
        return $data;
    }

    public function getLatestPost($limit) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_table)
                ->join($this->_name, "{$this->_table}.news_id = {$this->_name}.id")
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id", array('admin_name' => 'name'))
                ->where("{$this->_name}.status = ?", self::PUBLISH)
                ->order("{$this->_table}.news_id DESC")
                ->limit($limit)
        ;
        $data = $this->fetchAll($query);
        return $data;
    }

    public function getLatestDraft($limit) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_table)
                ->join($this->_name, "{$this->_table}.news_id = {$this->_name}.id")
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id", array('admin_name' => 'name'))
                ->where("{$this->_name}.status = ?", self::DRAFT)
                ->order("{$this->_table}.news_id DESC")
                ->limit($limit)
        ;

        $data = $this->fetchAll($query);
        return $data;
    }

}

?>
