<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImgGallery
 *
 * @author egiw
 */
class Admin_Model_DbTable_ImgGallery extends Zend_Db_Table_Abstract {

    protected $_name = 'img_gallery';
    protected $_account = 'admin_account';
    protected $_primary = 'id';

    public function fetchAllWithFilter($filter = array()) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_account, "{$this->_account}.admin_id = {$this->_name}.created_by", array("username", "name"))
                ->order("{$this->_name}.created_at DESC");

        if (null != $filter) {
            if (null != $filter['caption']) {
                $query->where("{$this->_name}.caption LIKE ?", "%{$filter['caption']}%");
            }

            if (null != $filter['caption_en']) {
                $query->where("{$this->_name}.caption_en LIKE ?", "%{$filter['caption_en']}%");
            }
        }

        return $this->fetchAll($query);
    }

    public function fetchAllWithLimit($search = null, $limit, $offset) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->order("{$this->_name}.created_at DESC");

        if (null != $search) {
            $query->where('caption LIKE ?', "%{$search}%")
                    ->orWhere('caption_en LIKE ?', "%{$search}%");
        }
        if (null !== $limit && null !== $offset)
            $query->limit($limit, $offset);

        return $this->fetchAll($query);
    }

    public function searchImages($param, $limit = 10, $offset = 0) {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image', 'caption', 'caption_en', 'source'));

        $key = explode(' ', $param);
        if (is_array($key)) {
            $string = '';
            $string2 = '';
            $string_order = '';
            for ($i = 0; $i < sizeof($key); $i++) {
                if ($i != sizeof($key) - 1) {
                    $string .= "{$this->_name}.caption like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_name}.caption_en like '%$key[$i]%' OR ";
                } else {
                    $string .= "{$this->_name}.caption like '%$key[$i]%'";
                    $string2 .= "{$this->_name}.caption_en like '%$key[$i]%'";
                }
            }

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        } else {
            $string = "{$this->_name}.caption like '%$param%'";
            $string2 = "{$this->_name}.caption_en like '%$param%'";

            $query->where('(' . $string . '');
            $query->orWhere('' . $string2 . ')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END LIMIT $offset, $limit";
        $query .= $string_order;

        $q = $this->_db->query($query);
        $result = $q->fetchAll();
        return $result;
    }

}
