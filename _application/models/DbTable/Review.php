<?php
/**
 * Model_DbTable_Review
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel review
 *
 * @package DbTable Model
 */
class Model_DbTable_Review extends Zend_Db_Table_Abstract
{
    /**
     * Nama tabel
     * @var String
     */
    protected $_name = 'review';

    protected $_user = 'user';

    public function insertReview($poiId, $userId, $fbname, $data)
    {
        $review = array(
            'poi_id'  => $poiId,
            'user_id' => $userId,
            'rate'    => $data['rate'],
            'review_title' => $data['review_title'],
            'review_content'  => $data['review_content'],
        );

        if( ! empty($fbname)) {
            $review['isfb'] = 1;
        }

        $reviewId = $this->insert($review);

        if($reviewId) {
            $destDb = new Model_DbTable_Destination;
            $destDb->updateRating($poiId, $data);
        }

        return $reviewId;
    }

    public function insertReviewRating($poiId, $userId, $fbname = '', $newRate)
    {
        $destDb = new Model_DbTable_Destination;

        $review = $this->getByPoiIdUserId($poiId, $userId);

        $avgRating = 0;

        if(count($review)) {
            $oldRate = $review['rate'];

            $avgRating = $destDb->updateRating($poiId, $data, $oldRate, $newRate);
            
        } else {
            $data = array(
                'poi_id'  => $poiId,
                'user_id' => $userId,
                'rate'    => $newRate
            );
            if( ! empty($fbname)) {
                $data['isfb'] = 1;
            }
            $reviewId = $this->insert($data);
            $avgRating = $destDb->updateRating($poiId, $data);

        }

        $this->editRating($poiId, $userId, $newRate);

        return $avgRating;

    }

    public function editReview($poiId, $userId, $data)
    {
        $review = array (
            'rate'   => $data['rate'],
            'review_title' => $data['review_title'],
            'review_content' => $data['review_content']
        );

        $where[] = $this->getAdapter()->quoteInto('poi_id = ?', $poiId);
        $where[] = $this->getAdapter()->quoteInto('user_id = ?', $userId);

        return $this->update($review, $where);
    }

    public function editRating($poiId, $userId, $rate)
    {
        $review = array (
            'rate'   => $rate,
        );

        $where[] = $this->getAdapter()->quoteInto('poi_id = ?', $poiId);
        $where[] = $this->getAdapter()->quoteInto('user_id = ?', $userId);

        return $this->update($review, $where);
    }

    

    public function editReviewThumb($reviewId, $thumbType)
    {
        $review = $this->get($reviewId);

        $data = array();
        if($thumbType == 1) {
            $review['thumb_up'] = $review['thumb_up'] + 1;
            $data['thumb_up'] = $review['thumb_up'];
        } elseif($thumbType == 2) {
            $review['thumb_down'] = $review['thumb_down'] + 1;
            $data['thumb_down'] = $review['thumb_down'];
        }

        $where[] = $this->getAdapter()->quoteInto('review_id = ?', $reviewId);
        $this->update($data, $where);

        return $review;
    }

    public function get($reviewId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_user,
                    "{$this->_user}.user_id = {$this->_name}.user_id",
                    array('username', 'email'))
                ->where('review_id = ?', $reviewId)
                ->setIntegrityCheck(false);
    
        $data = $this->fetchRow($query);
    
        $data['review_content'] = stripslashes($data['review_content']);

        return $data;
    }

    public function getUserId($destId)
    {
        $query = $this->select()
                ->from($this->_name, array('user_id'))
                ->where('poi_id = ?', $destId);

        $data = $this->fetchRow($query);

        return $data['user_id'];
    }

    public function getByPoiIdUserId($poiId, $userId)
    {
        $query = $this->select()
                ->from($this->_name, array('review_id', 'rate'))
                ->where('poi_id = ?', $poiId)
                ->where('user_id = ?', $userId);
        //echo $query->__toString();
        $data = $this->fetchRow($query);

        return $data;
    }

    /**
     * Fungsi  untuk mengambil semua data
     *
     * @param Integer $poiId destinasi id
     * @return Array data review
     */
    public function getAllByPoiId($poiId, $reviewId = '')
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_user, 
                    "{$this->_user}.user_id = {$this->_name}.user_id",
                    array('username', 'email'))
                ->where("{$this->_name}.poi_id = ?", $poiId)
                ->where("{$this->_name}.review_content IS NOT NULL")
                ->setIntegrityCheck(false);

        if( ! empty($reviewId)) {
            $query->where("{$this->_name}.review_id <> ?", $reviewId);
        }
                
        return $query;
    }

    /**
     * Fungsi untuk mendapatkan data review berdasarkan destinasi dan
     * user.
     *
     * @param integer $poiId
     * @param integer $userId
     * @return array
     */
    public function getByPoiAndUser($poiId, $userId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_user,
                    "{$this->_user}.user_id = {$this->_name}.user_id",
                    array('username', 'email'))
                ->where("{$this->_name}.review_content IS NOT NULL")
                ->where("{$this->_name}.poi_id = ?", $poiId)
                ->where("{$this->_name}.user_id = ?", $userId)
                ->setIntegrityCheck(false);
                
        $data = $this->fetchRow($query);

        return $data;

    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data review sesuai masukan 
     * review_id
     * 
     * @param array $input
     * @param int $review_id
     */
    public function updateReview($input, $review_id)
    {
        $where = $this->getAdapter()->quoteInto('review_id = ?', $review_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data review sesuai masukan 
     * review_id
     * 
     * @param int $review_id
     */
    public function deleteReview($review_id)
    {
        $where = $this->getAdapter()->quoteInto('review_id = ?', $review_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil status review dimana review_id nya sesuai 
     * dengan parameter masukan
     * 
     * @param int $review_id
     * @return int status
     */
    public function getStatusById($review_id)
    {
        $select = $this->select()
                  ->from(array('r' => $this->_name), array('r.status'))
                  ->where('r.review_id = ?', $review_id);
        $status = $this->fetchRow($select);
        return $status['status'];
    }
    
    /**
     * Fungsi untuk mengambil query seluruh record review sesuai dengan filter
     * parameter masukan
     * 
     * @param int $filter
     * @param int $param
     * @return query
     */
    public function getQueryAll($filter = 0, $param = null)
    {
        $select = $this->select()
                  ->from(array('r' => $this->_name), array('r.review_id','r.review_content','r.status','r.review_title'));
        switch($filter)
        {
            case 1: $select->where("r.review_title LIKE '%".$param."%'");
                    break;
            case 2: $select->where("r.status = ?", $param);
                    break;
        }
        $select->order('review_id DESC');
        return $select;
    }
    
    /**
     * Fungsi untuk mengambil satu record review dimana review_id nya sesuai 
     * dengan parameter masukan
     * 
     * @param int $review_id
     * @return array
     */
    public function getReviewById($review_id)
    {
        $select = $this->select()
                  ->from(array('r' => $this->_name), array('r.review_content','r.review_title'))
                  ->where("r.review_id = ?", $review_id);
                  
        return $this->fetchRow($select);
    }
}
