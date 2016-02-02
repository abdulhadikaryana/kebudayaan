<?php
/**
 * Model_DbTable_TourismOperator
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel tourism operator
 *
 * @package DbTable Model
 */
class Model_DbTable_TourismOperatorDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'tourismoperatordescription';

    /**
     * Fungsi untuk memasukkan semua data ke dalam tabel tourismoperatordescription
     * @param data $input
     * @return array
     */
    public function insertTourismOperatorDescription($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function checkForIndo($catId,$langId=2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('tourismoperator_id = ?', $catId)
                ->where('language_id = ?',$langId);
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    /**
     * Fungsi untuk mengupdate data dari tabel tourismoperatordescription
     * berdasarkan tourismoperraor_id yang diberikan
     * @param data $input
     * @param integer $tourism_id
     */
    public function updateTourismOperatorDescription($input,$tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id).$this->getAdapter()->quoteInto('AND language_id = ?',$input['language_id']);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk menghapus data dari tabel tourismoperatordescription
     * berdasarkan tourismoperaotr_id yang diberikan
     * @param integer $tourism_id
     */
    public function deleteTourismOperatorDescription($tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id);
        $this->delete($where);
    }

    public function deleteTourismOperatorDescription2($tourism_id,$language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id).
                 $this->getAdapter()->quoteInto('AND language_id = ?',$language_id);
        $this->delete($where);
    }

    public function checkDescIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('tourismoperator_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('tourismoperator_id = ?',$catId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['description']==' ')
            {
                return false;
            }else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
    
    public function searchTourismFix($param, $limit = 10, $offset = 0, $lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('tourismoperator_id','name','description'))
                ->where("{$this->_name}.language_id = ?",$lang_id)
                ->order('tourismoperator_id DESC')
                ->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%'";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%'";
                }

            }

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');


        }
        else
        {
            
            
            $string = "{$this->_name}.name like '%$param%'";
            $string2 = "{$this->_name}.description like '%$param%'";
            

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }
        
        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            //return $query;
            return $result;
        }
        else
        {
            return null;
        }

    }


    public function searchTourismBaru($param, $limit = 10, $offset = 0, $lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('tourismoperator_id','name','description'))
                ->where("{$this->_name}.language_id = ?",$lang_id);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%'";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%'";
                }

            }

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');


        }
        else
        {
            
            
            $string = "{$this->_name}.name like '%$param%'";
            $string2 = "{$this->_name}.description like '%$param%'";
            

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END LIMIT $offset, $limit";
        $query .= $string_order;
        
        //echo $query;
            
        $q = $this->_db->query($query);
        $result = $q->fetchAll();
        
        if(count($result))
        {
            //return $query;
            return $result;
        }
        else
        {
            return null;
        }         


    }

    public function numRowsTourism($param,$lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('tourismoperator_id','name','description'))
                ->where("{$this->_name}.language_id = ?",$lang_id);
                //->limit($limit,$offset);

        $key = explode(' ', $param);
        if(is_array($key))
        {
            $string = '';
            $string2 = '';
            for($i=0;$i<sizeof($key);$i++)
            {
                if($i != sizeof($key) - 1)
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_name}.name like '%$key[$i]%'";
                    $string2 .= "{$this->_name}.description like '%$key[$i]%'";
                }

            }

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');


        }
        else
        {
            
            
            $string = "{$this->_name}.name like '%$param%'";
            $string2 = "{$this->_name}.description like '%$param%'";
            

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END";
        $query .= $string_order;

        $q = $this->_db->query($query);
        $result = $q->fetchAll();
        
        if(count($result))
        {
            //return $query;
            return count($result);
        }
        else
        {
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
   
}
?>
