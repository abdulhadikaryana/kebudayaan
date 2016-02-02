<?php
/**
 * Model_DbTable_Comment
 *
 * Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel comment
 *
 * @package model
 */
class Model_DbTable_Comment extends Zend_Db_Table_Abstract
{
    /**
     * Nama tabel
     * @var String
     */
    protected $_name = 'comment';
    protected $_userid = 'user';

    /**
     * Primary key tabel
     * @var String
     */
    protected $_primary = 'comment_id';

    /**
     * Fungsi untuk memasukkan data comment
     * @return array
     */
    public function insertComment($contentId, $contentType, $input,
        $userId, $fbname = '')
    {
        if((!preg_match('@^http://|https://@', $input['website'])) AND (empty($fbname)))
            $input['website'] = 'http://' . $input['website'];

        date_default_timezone_set('Asia/Jakarta');
        $defaultData = array(
            'content_id'           => $contentId,
            'content_type'         => $contentType,
            'comment_author_url'   => $input['website'],
            'comment_content'      => $input['comment'],
            'comment_date'         => date('Y-m-d H:i:s')
        );
        
        if(isset($userId)) {
            $userDb = new Model_DbTable_User;
            $user = $userDb->getUserById($userId);
            $data = array(
                'comment_author'       => $user['name'],
                'comment_author_email' => $user['email'],
                'user_id'              => $userId
            );

            if( ! empty($fbname)) {
                $data['isfb'] = 1;
                $data['comment_author'] = $user['username'];
            }

            $defaultData = array_merge($defaultData, $data);
	     return $this->insert($defaultData);
        } else {
            $data = array(
                'comment_author'       => $input['author'],
                'comment_author_email' => $input['email'],
            );

            $defaultData = array_merge($defaultData, $data);
  	     
	     if(isset($input['author']) AND isset($input['email']))
            {
                return $this->insert($defaultData);
            }

        }
    }

    /**
     * 
     */
    public function getAllByContentType($contentId, $contentType)
    {
        $query = $this->select()
                 ->setIntegrityCheck(false)
                 ->from($this->_name)
                 ->where("{$this->_name}.content_id = ?", $contentId)
                 ->where("{$this->_name}.content_type = ?", $contentType);
        return $this->fetchAll($query);
    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data comment sesuai masukan 
     * comment_id
     * 
     * @param array $input
     * @param int $comment_id
     */
    public function updateComment($input, $comment_id)
    {
        $where = $this->getAdapter()->quoteInto('comment_id = ?', $comment_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data comment sesuai masukan 
     * comment_id
     * 
     * @param int $comment_id
     */
    public function deleteComment($comment_id)
    {
        $where = $this->getAdapter()->quoteInto('comment_id = ?', $comment_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil query seluruh record comment sesuai dengan filter
     * parameter masukan
     * 
     * @param int $filter
     * @return query
     */
    public function getByAuthor($language_id=1)
    {
        $data = $this->select()
                ->setIntegrityCheck()
                ->from($this->_name)
                ->where('comment_author = ?',$language_id)
                ;
        
        
    }
    
    
    public function getQueryAll($filter = 1)
    {
        $select = $this->select()
                  ->from(array('c' => $this->_name), array('c.comment_id', 'c.content_id', 'c.content_type', 'c.comment_author', 'c.comment_author_email', 'c.comment_content'))
                  ->where("c.content_type = ?", $filter)
                  ->order('comment_id DESC');
        if ($filter == 3) {
            $select->setIntegrityCheck(FALSE);
            $select->join(array('r' => 'review'), 'r.review_id = c.content_id', array('poi_id'));
        }
        return $select;
    }
    
    /**
     * Fungsi untuk mengambil satu record comment dimana comment_id nya sesuai 
     * dengan parameter masukan
     * 
     * @param int $comment_id
     * @return array
     */
    public function getCommentById($comment_id)
    {
        $select = $this->select()
                  ->from(array('c' => $this->_name), array('c.comment_content'))
                  ->where("c.comment_id = ?", $comment_id);
                  
        return $this->fetchRow($select);
    }


    /**
     * Fungsi untuk memasukkan data comment user contributor
     * @return array
     */
     /**
     * Fungsi untuk memasukkan data comment
     * @return array
     */
    public function insertCommentUsercon($contentId, $contentType, $input,
        $userId, $fbname = '')
    {
        if((!preg_match('@^http://|https://@', $input['website'])) AND (empty($fbname)))
            $input['website'] = 'http://' . $input['website'];

        date_default_timezone_set('Asia/Jakarta');
        $defaultData = array(
            'content_id'           => $contentId,
            'content_type'         => $contentType,
            'comment_author_url'   => $input['website'],
            'comment_content'      => $input['comment'],
            'parent_id'            => $input['parent_id'],
            'level'            	    => $input['level'],
            'comment_date'         => date('Y-m-d H:i:s')
        );
        
        if(isset($userId)) {
            $userDb = new Model_DbTable_User;
            $user = $userDb->getUserById($userId);
            $data = array(
                'comment_author'       => $user['name'],
                'comment_author_email' => $user['email'],
                'user_id'              => $userId
            );

            if( ! empty($fbname)) {
                $data['isfb'] = 1;
                $data['comment_author'] = $user['username'];
            }

            $defaultData = array_merge($defaultData, $data);
	     return $this->insert($defaultData);
        } else {
            $data = array(
                'comment_author'       => $input['author'],
                'comment_author_email' => $input['email'],
            );

            $defaultData = array_merge($defaultData, $data);
  	     
	     if(isset($input['author']) AND isset($input['email']))
            {
                return $this->insert($defaultData);
            }

        }
    }


    public function countComment($content_type,$content_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('comment_id'))
                  ->where("{$this->_name}.content_type = ?",$content_type)
                  ->where("{$this->_name}.content_id = ?",$content_id);
                  
        return count($this->fetchAll($select));
    }    

    /**
     * 
     */
    public function getAllByContentTypeFix($contentId, $contentType, $parent_id=0, $level_id=0)
    {
        $query = $this->select()
                 ->setIntegrityCheck(false)
                 ->from($this->_name)
                 ->where("{$this->_name}.content_id = ?", $contentId)
                 ->where("{$this->_name}.content_type = ?", $contentType)
                 ->where("{$this->_name}.parent_id = ?", $parent_id)
                 ->where("{$this->_name}.level = ?", $level_id);
        return $this->fetchAll($query);
        //return $this->fetchRow($query);
    }   


}
?>
