<?php

class Model_DbTable_Figure extends Zend_Db_Table_Abstract {

    protected $_name = 'figure';
    protected $_description = 'figure_description';
    protected $_account = 'admin_account';

    public function findAll($language_id = null, $limit = null) {

        $select = $this->select()->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_account, "{$this->_name}.created_by = {$this->_account}.admin_id", array(
                    'created_by' => "IFNULL({$this->_account}.name, {$this->_account}.username)"
                ))
                ->join($this->_description, "{$this->_name}.id = {$this->_description}.figure_id", array('description'));



        if (null != $limit)
            $select->limit($limit);



        if (null != $language_id)
            $select->where("{$this->_description}.language_id = ?", $language_id);

        $select->where("{$this->_name}.status = ?", 3);

        $select->order("{$this->_name}.created_at DESC");



        $result = $this->fetchAll($select);

        return $result;
    }

    public function findWithDescription($figure_id, $language_id) {

        $select = $this->select()->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_description, "{$this->_name}.id = {$this->_description}.figure_id", array('description'))
                ->where("{$this->_name}.id = ?", $figure_id)
                ->where("{$this->_description}.language_id = ?", $language_id);



        $result = $this->fetchRow($select);

        return $result;
    }

    public function searchFig($param, $limit = 10, $offset = 0, $language_id) {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id', 'image', 'name', 'status'))
                ->join($this->_description, "{$this->_description}.figure_id = {$this->_name}.id")
                ->where("{$this->_description}.language_id = ?", $language_id)
                ->where("{$this->_name}.status = 3");





        $key = explode(' ', $param);

        if (is_array($key)) {

            $string = '';

            $string2 = '';

            $string_order = '';

            for ($i = 0; $i < sizeof($key); $i++) {

                if ($i != sizeof($key) - 1) {

                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";

                    $string2 .= "{$this->_description}.description like '%$key[$i]%' OR ";
                } else {

                    $string .= "{$this->_name}.name like '%$key[$i]%'";

                    $string2 .= "{$this->_description}.description like '%$key[$i]%'";
                }
            }



            $query->where('(' . $string . '');

            $query->orWhere('' . $string2 . ')');
        } else {



            $string = "{$this->_name}.name like '%$param%'";

            $string2 = "{$this->_description}.description like '%$param%'";



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

    public function numbRowsFigure($param, $lang_id) {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('id'))
                ->join($this->_description, "{$this->_description}.figure_id = {$this->_name}.id")
                ->where("{$this->_description}.language_id = ?", $lang_id)
                ->where("{$this->_name}.status = 3");





        $key = explode(' ', $param);

        if (is_array($key)) {

            $string = '';

            $string2 = '';

            for ($i = 0; $i < sizeof($key); $i++) {

                if ($i != sizeof($key) - 1) {

                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";

                    $string2 .= "{$this->_description}.description like '%$key[$i]%' OR ";
                } else {

                    $string .= "{$this->_name}.name like '%$key[$i]%'";

                    $string2 .= "{$this->_description}.description like '%$key[$i]%'";
                }
            }

            $query->where('(' . $string . '');

            $query->orWhere('' . $string2 . ')');
        } else {



            $string = "{$this->_name}.name like '%$param%'";

            $string2 = "{$this->_description}.description like '%$param%'";



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
    }

}
