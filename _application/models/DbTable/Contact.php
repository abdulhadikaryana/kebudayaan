<?php
/**
 * Model_DbTable_Contact
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel contact
 *
 * @package DbTable Model
 */
class Model_DbTable_Contact extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'contact';

    public function insertContact($input)
    {
        $data = array(
            'name' => $input['name'],
            'email' => $input['email'],
//            'country' => $input['country'],
            'url' => $input['website'],
            'subject' => $input['subject'],
            'comment' => $input['comment'],
            'date'=> date('Y-m-d H:i:s')
        );
        
        $this->insert($data);
    }

    public function getAllQuery($filter=null, $param = null)
    {
        $select = $this->select()
                ->from($this->_name)
                ->order('date DESC');
//       switch($filter)
//        {
//            case 1 : $select->where("name LIKE '%".$param."%'");
//                     break;
//            case 2 : $select->where('status = ?', $param);
//                     break;
//            case 3 : $select->where('subject = ?',$param);
//                     break;
//            case 4 : $select->where('flag = ?',$param);
//                     break;
//            case 5:  $select->where('country = ?', $param);
//       }
        if(null != $filter){
            if(null != $filter['name'])
            {
                $select->where("name LIKE ?", "%{$filter['name']}%");
            }
            if(null != $filter['subject'])
            {
                $select->where("subject = ? ",$filter['subject']);
            }
        }
        
        return $select;
        
    }

    public function getAllById($contactId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('contact_id = ?', $contactId);
        return $this->fetchAll($query)->toArray();
    }

    public function updateContact($input,$contact_id)
    {
        $where = $this->getAdapter()->quoteInto('contact_id = ?',$contact_id);
        $this->update($input,$where);
    }

    public function deleteContact($contactId)
    {
        $where = $this->getAdapter()->quoteInto('contact_id = ?',$contactId);
        $this->delete($where);
    }

    public function getReplyMessage($name, $reply)
    {
        $htmlMsg = "
                Dear ".$name." <br /><br />
                ".$reply." <br /><br />
             Indonesia Travel Team
            ";

        return $htmlMsg;
    }

    public function getCountId()
    {
        $data = $this->select()
                ->from($this->_name,array('COUNT(contact_id) as count'));
        $return = $this->fetchRow($data);
        $query = $return->toArray();
        return $query['count'];
    }

}
?>
