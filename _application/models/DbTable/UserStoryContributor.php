<?php
/**
 * Model_DbTable_UserStoryContributor
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story content
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryContributor extends Zend_Db_Table_Abstract
{

    //put your code here
    protected $_name = 'userstorycontributor';
    //protected $_primary = array('id');



    public function insertContributor($data){
        $this->insert($data);
    }

    public function searchUser($param)
    {
        $data = $this->select()
                ->from($this->_name,array('id','nama','foto','website','email'))
                ->where("{$this->_name}.nama like '%$param%'");
                
        $result = $this->fetchAll($data);
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }
    
    //untuk detail aithor
    public function getById($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.id = ?",$id);

        $result = $this->fetchRow($data);
 
        if(count($result) > 0)
        {
            //return 1;
            return $result;
        }
        else
        {
            return NULL;
        }        
    }


    public function getByContributorId($id)
    {

        $data = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.id = ?",$id);
        
        $result = $this->fetchRow($data);
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }
    

    public function displayUserContributor($limit)
    {
        $data = $this->select()
                ->from($this->_name,array('id','nama','foto','website','email'))
                ->order('RAND()')
                ->limit($limit);

        $result = $this->fetchAll($data);
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }    


    public function selectAll()
    {
        $data = $this->select()
                ->from($this->_name);

        $result = $this->fetchAll($data);
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    } 


    /*
    *rating
    * param1 = author_id
    * param2 = score_rating
    */
    public function rating($author_id,$score_rating)
    {
        $data = array('rating' => $score_rating);
        $where = $this->getAdapter()->quoteInto('id = ?', $author_id);
        $this->update($data, $where);
    }



    /*
        get all data (fungsi ini dipakai oleh data table di viewer add usergenerated content)
    */
    public function getAllDataFix($limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = ''){

        $data = $this->select()
                ->from($this->_name)
                ->limit($limit,$offset);

        //filter searching
        if($search != '')
        {
            $data->where("{$this->_name}.nama like '%$search%'");
        }

        if(($order == 'asc') || ($order == 'undefined'))
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id ASC'; break;
                case 1 : $string = 'id ASC'; break;
            }
            //$string = 'id ASC';
        }
        else if($order = 'desc')
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id DESC'; break;
                case 1 : $string = 'id DESC'; break;
            }
            //$string = 'id DESC';
        }
        
        $data->order($string);

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result->toArray();;
        }
        else
        {
            return NULL;
        }
    }


    /*
        count data
    */
    public function countAllData($limit = 0, $offset = 0, $sortColumn = 0, $order = 'asc', $search = '')
    {
        $data = $this->select()
                ->from($this->_name);

        //filter searching
        if($search != '')
        {
            $data->where("{$this->_name}.nama like '%$search%'");
        }

        if(($order == 'asc') || ($order == 'undefined'))
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id ASC'; break;
                case 1 : $string = 'id ASC'; break;
            }
            //$string = 'id ASC';
        }
        else if($order = 'desc')
        {
           switch($sortColumn)
            {
                case 0 : $string = 'id DESC'; break;
                case 1 : $string = 'id DESC'; break;
            }
            //$string = 'id DESC';
        }
        
        $data->order($string);

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return count($result);
            //return $result->toArray();;
        }
        else
        {
            return NULL;
        }
    }

    /*
     * fungsi untuk update data
    */
    public function updateField($contributor_id,$data)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $contributor_id);
        $this->update($data, $where);

    }

    /*
        remove user contrbutor
    */
    public function deleteContributor($contributor_id)
    {
       $where = $this->getAdapter()->quoteInto('id = ?', $contributor_id);
       $this->delete($where);
    }
}
?>
