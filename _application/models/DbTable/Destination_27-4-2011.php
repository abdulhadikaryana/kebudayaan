<?php
/**
 * Model_DbTable_Destination
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel poi
 *
 * @package model
 */
class Model_DbTable_Destination extends Zend_Db_Table_Abstract
{

    //deklarasi tabel yang digunakan dalam model destination
    protected $_name = 'poi';
    protected $_poidesc = 'poidescription';
    protected $_gallery = 'gallery';
    protected $_primary = 'poi_id';

    /**
     * Fungsi untuk melakukan insert pada tabel poi
     * @return string
     */
    public function insertPoi($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk melakukan update pada tabel poi
     * @return null
     */
    public function updatePoi($input,$poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $this->update($input, $where);
    }

    public function updateRating($poiId, $input, $oldRate = '', $newRate = '')
    {
        $currentRating = $this->getRate($poiId);

        $data = array();
        if(empty($oldRate))
        {

            $data = array(
                    'totalrate' => $currentRating['totalrate'] + $input['rate'],
                    'totalrater' => $currentRating['totalrater'] + 1,
            );

        } else
        {
            $rate = $currentRating['totalrate'] - $oldRate;

            $newRate = $newRate + $rate;

            $data = array(
                    'totalrate' => $newRate,
                    'totalrater' => $currentRating['totalrater']
            );

        }

        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poiId);
        $this->update($data, $where);

        return array('rating' => number_format($data['totalrate']/$data['totalrater'], 2),
                'totalrater' => $data['totalrater']);
    }

    /**
     * Fungsi untuk melakukan delete pada tabel poi
     * @return null
     */
    public function deletePoi($poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $this->delete($where);
    }

    public function checkSpecialDestination($poiId)
    {
        $query = $this->select()
                ->from($this->_name,array('special'))
                ->where("{$this->_name}.poi_id = ?", $poiId);
        $report = $this->fetchRow($query);
        return $report['special'];
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi
     * @return array
     */
    public function getAllPoi()
    {
        $query = $this->select()
                ->from($this->_name,array('poi_id'));
        $data = $this->fetchAll($query);
        $return = $data->toArray();
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getAllById($poiId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('poi_id = ?', $poiId);

        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi dan tabel-tabel lain
     * digunakan untuk menggenerate destinasi untuk indexing lucene
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc()
    {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('p' => $this->_name))
                ->join(array('pd' => $this->_poidesc),'p.poi_id = pd.poi_id')
                ->join(array('l' => 'language'),'pd.language_id = l.language_id',array('language_name'));
        return $this->fetchAll($select);
    }

    public function getAllWithDescForRss($lang_id = 1, $limit = '')
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_poidesc,"{$this->_poidesc}.poi_id = {$this->_name}.poi_id")
                ->where("{$this->_poidesc}.language_id = ?", $lang_id)
                ->setIntegrityCheck(false)
                ->order("{$this->_poidesc}.poi_id DESC")
                ->where("{$this->_name}.special = 1");

        if( ! empty($limit))
        {
            $query->limit($limit, 0);
        }

        return $query;
    }

    /**
     * Fungsi untuk mendapatkan beberapa informasi untuk map berdasarkan sebuah poi id
     *
     * @param integer $languageId
     * @param integer $poiId
     * @return array
     */
    public function getWithDescForMapByPoiId($poiId, $languageId)
    {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('p' => $this->_name),
                array('pointX', 'pointY', 'special'))
                ->join(array('pd' => $this->_poidesc),'p.poi_id = pd.poi_id',
                array('poi_id', 'poi_name' => 'name', 'description'))
                ->where("pd.language_id = ?", $languageId)
                ->where("pd.poi_id = ?", $poiId);

        return $this->fetchAll($select);
    }


    /**
     * Fungsi untuk mengambil semua data dari tabel poi berdasarkan language_id
     * (tabel poidescription) yang diberikan
     *
     * @param integer $lang_id
     * @return array
     */
    public function getAllByLang($langId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id", array(''))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $langId);
        return $this->fetchAll($data);
    }

    /**
     *
     * @param integer $poi_id
     * @param integer $language_id
     * @return array
     */
    public function getAllByIdLang($poi_id,$language_id )
    {
        $custom = new Budpar_Custom_Common;

        $query = $this->select()
                ->from($this->_name, array('poi_id','pointX','pointY','address','phone','website',
                'main_category','featured','popular', 'header_image',
                '(totalrate/totalrater) AS rating', 'totalrater'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('*'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $language_id)
                ->where("{$this->_name}.poi_id = ?", $poi_id);
        $check = $this->fetchRow($query);
        if($check!=null)
        {
            $data = $this->fetchRow($query)->toArray();
            if($data['name']!=null)
            {
                if($language_id!=2)
                {
                    if ($data['tagline'])
                    {
                        $data['fullname'] = $custom->htmlDecode($data['name']) . ": " . $custom->htmlDecode($data['tagline']);
                    } else
                    {
                        $data['fullname'] = $custom->htmlDecode($data['name']);
                    }
                }
                if($data['description']==null)
                {
                    $data['text']= "Sorry, these destinations do not have a description in English";

                }
                return $data;

            }else
            {
//                $query2 = $this->select()
//                        ->from($this->_name, array('name'))
//                        ->where("{$this->_name}.poi_id = ?", $poi_id);
//                $data2 = $this->fetchRow($query2)->toArray();
                $data['fullname'] = "Maaf, destinasi ini belum memiliki terjemahan bahasa Indonesia";
                if($data['description']==null)
                {
                    $data['text'] = "Maaf, destinasi ini belum memiliki terjemahan dalam bahasa Indonesia";
                }
//                echo '$data[]';
//                echo $query->__toString();
                return $data;

            }

        }else
        {
            $query2 = $this->select()
                    ->from($this->_name, array('poi_id','pointX','pointY','address','phone','website',
                    'main_category','featured','popular', 'header_image',
                    '(totalrate/totalrater) AS rating', 'totalrater'))
                    ->where("{$this->_name}.poi_id = ?", $poi_id);
            $data = $this->fetchRow($query2)->toArray();

            $data['fullname'] = "Sorry, these destinations do not have a description in English";
            $data['text'] = "Sorry, these destinations do not have a description in English";

            return $data;

        }
    }

    public function checkDestSpecialById($poi_id){
        $query = $this->select()
                ->from($this->_name,array('special'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($query);
        return $return['special'];
    }

    public function getheaderimagebyid2($id){
        $query = $this->select()
                ->from($this->_name,array(' '))
                ->setIntegrityCheck(false)
                ->join($this->_poidesc,"{$this->_name}.poi_id = {$this->_poidesc}.poi_id",array('header_image'))
                ->where("{$this->_name}.poi_id = ?", $id);
        echo $query->__toString();
       // return $this->fetchRow($query);
    }

    public function getAllByIdLangForIndo($poi_id,$language_id )
    {
        $custom = new Budpar_Custom_Common;

        $query = $this->select()
                ->from($this->_name, array('poi_id','pointX','pointY','address','phone','website',
                'main_category','featured','popular', 'header_image',
                '(totalrate/totalrater) AS rating', 'totalrater'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('*','header_image as banner'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $language_id)
                ->where("{$this->_name}.poi_id = ?", $poi_id);
        $check = $this->fetchRow($query);
        if($check!=null)
        {
            $data = $this->fetchRow($query)->toArray();
            if($data['name']!=null)
            {
                if($language_id!=1)
                {
                    if ($data['tagline'])
                    {
                        $data['fullname'] = $custom->htmlDecode($data['name']) . ": " . $custom->htmlDecode($data['tagline']);
                    } else
                    {
                        $data['fullname'] = $custom->htmlDecode($data['name']);
                    }
                }
                if($data['description']==null)
                {
                    $data['text']= "Maaf, destinasi ini belum memiliki terjemahan dalam bahasa Indonesia";

                }
                return $data;
            }else
            {
                $data['fullname'] = "Sorry, this destination does not have English translation";
                if($data['description']==null)
                {
                    $data['text'] = "Sorry, this destination does not have English translation";
                }
                return $data;
            }


        }else
        {
            $query2 = $this->select()
                    ->from($this->_name, array('poi_id','pointX','pointY','address','phone','website',
                    'main_category','featured','popular', 'header_image',
                    '(totalrate/totalrater) AS rating', 'totalrater'))
                    ->where("{$this->_name}.poi_id = ?", $poi_id);
            $data = $this->fetchRow($query2)->toArray();
            $data['fullname'] = "Maaf, destinasi ini belum memiliki terjemahan dalam bahasa Indonesia";
            $data['text'] = "Maaf, destinasi ini belum memiliki terjemahan dalam bahasa Indonesia";
            return $data;

        }
    }

    public function getAllByIdLangtes($poi_id,$language_id )
    {
        $custom = new Budpar_Custom_Common;

        $query = $this->select()
                ->from($this->_name, array('poi_id','pointX','pointY','address','phone','website',
                'main_category','featured','popular', 'header_image',
                '(totalrate/totalrater) AS rating', 'totalrater'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('*'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $language_id)
                ->where("{$this->_name}.poi_id = ?", $poi_id);

        $data = $this->fetchRow($query);
        if($data==null)
        {
            return "kosong";
        }else
        {
            return "ada";
        }
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi berdasarkan name yang
     * diberikan
     *
     * @param string $name
     * @return array
     */
    public function getAllByName($name,$language_id = 1)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => $this->_name),array('poi_id'))
                ->join(array('pd' => 'poidescription'),'p.poi_id = pd.poi_id',array('name'))
                ->where("pd.name LIKE '%" . $name . "%'")
                ->where('pd.language_id = ?',$language_id);
        return $this->fetchAll($data)->toArray();
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi berdasarkan status yang
     * diberikan
     *
     * @param string $status
     * @return array
     */
    public function getAllByStatus($status)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('status = ?', $status);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel poi kecuali yang mempunyai
     * poi_id seperti yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getAllExId($poiId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('poi_id != ?', $poiId);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua name dari tabel poi
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name, array('name'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data name dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poiId
     * @return array
     */
    public function getNameById($poiId)
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->where('poi_id = ?', $poiId);
        $report = $this->fetchRow($data);
        //$return = $report->toArray();
        return $report['name'];
    }

    /**
     * Fungsi untuk mengambil semua data name dari tabel poi kecuali yang
     * mempunyai poi_id seperti yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getAllNameExId($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->where('poi_id != ?', $poi_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil field untuk rating
     *
     * @param integer $poiid
     * @return array (fetchrow)
     */
    public function getRate($poiId)
    {
        $query = $this->select()
                ->from($this->_name, array('totalrate', 'totalrater'))
                ->where('poi_id = ?', $poiId);

        return $this->fetchRow($query);
    }

    /**
     * Fungsi untuk mengambil data Longitude dan Latitude dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getPoiCoordinate($poi_id)
    {
        $select = $this->select()
                ->from($this->_name, array('x' => 'pointX','y' => 'pointY'))
                ->where('poi_id = ?',$poi_id);
        return $this->fetchRow($select)->toArray();

    }


    /**
     * Fungsi untuk mengambil data pointX dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getPointXById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('pointX'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data pointY dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getPointYById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('pointY'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data address, phone , dan website dari tabel poi
     * berdasarkan poi_id yang diberikan
     *
     * @param string $name
     * @return array
     */
    public function getAddressPhoneByName($name)
    {
        $data = $this->select()
                ->from($this->_name, array('address', 'phone', 'website'))
                ->where("name LIKE '%" . $name . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data address dari tabel poi berdasarkan poi_id
     * yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getAddressById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('address'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data phone dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getPhoneById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('phone'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data website dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getWebsiteById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('website'))
                ->where('poi_id = ?', $poi_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data main category dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getMainCategoryById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('main_category'))
                ->where('poi_id = ?', $poi_id);
        $report = $this->fetchRow($data);
        $return = $report->toArray();
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data poi_id dan name dari tabel poi
     * @return array
     */
    public function getNameId()
    {
        $data = $this->select()
                ->from($this->_name, array('poi_id', 'name'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data poi_id, name, dan main_category dari tabel
     * poi berdasarkan poi_id yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getNameIdMainCatById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('poi_id', 'name', 'main_category'))
                ->where('poi_id = ?', $poi_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mendapatkan nilai poi_id yang paling terakhir di tabel poi
     * @return array
     */
    public function getLastId()
    {
        $data = $this->select()
                ->from($this->_name, array('poi_id'))
                ->order('poi_id DESC')
                ->limit(1, 0);
        $report = $this->fetchRow($data);
        $return = $report->toArray();
        return $return;
    }

    /**
     * Fungsi untuk mengambil data totalrate dan totalrater dari tabel poi
     * berdasarkan poi_id yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getRateById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('totalrate', 'totalrater'))
                ->where('poi_id = ?', $poi_id);
        $report = $this->fetchRow($data);
        $return = $report->toArray();
        $totalrate = $report['totalrate'];
        $totalrater = $report['totalrater'];
        $rating = $totalrate/$totalrater;
        return $rating;
    }

    /**
     * Fungsi untuk mengambil data status dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getStatusById($poi_id)
    {
        $data = $this->select()
                ->from($this->_name, array('status'))
                ->where('poi_id = ?', $poi_id);
        $report = $this->fetchRow($data);
        $return = $report->toArray();
        return $return['status'];
    }

    /**
     * Fungsi untuk mendapatkan 5 destinasi yang terfavorit
     * @return array
     */
    public function getFiveTopDestination()
    {
        $data = $this->select()
                ->from($this->_name, array('poi_id'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",
                array('name', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = 1")
                ->order("{$this->_name}.totalrate DESC")
                ->limit(5, 0);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil sejumalah destinasi yang diambil secara acak untuk
     * ditampilkan di home
     *
     * @param integer $numb
     * @param integer $lang_id
     * @return array
     */
    public function getRandomDestination($numberRandom, $langId)
    {
        $data = $this->select()
                ->from($this->_poidesc, array('poi_id', 'name', 'description'))
                ->join($this->_gallery,
                "{$this->_gallery}.poi_id = {$this->_poidesc}.poi_id",
                array('source'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $langId)
                ->order('RAND()')
                ->limit($numberRandom, 0);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil sejumlah destinasi special yang diambil secara acak untuk
     * ditampilkan di home
     *
     * @param integer $numb
     * @param integer $lang_id
     * @return array
     */
    public function getRandomSpecialDestination($numberRandom, $langId = 1)
    {
        $data = $this->select()
                ->from($this->_name, array('poi_id'))
                ->join($this->_poidesc,
                "{$this->_name}.poi_id = {$this->_poidesc}.poi_id",
                array('name', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.special = 1")
                ->where("{$this->_poidesc}.language_id = ?", $langId)
                ->order('RAND()')
                ->limit($numberRandom, 0);
        $result = $this->fetchAll($data);
        $return = $result->toArray();
        $imageDb = new Model_DbTable_Image;
        for ($i=0; $i<count($return); $i++)
        {
            $image = $imageDb->getMainImageSource($return[$i]['poi_id']);
            $return[$i]['source'] = $image['source'];
        }
        return $return;
    }

    /**
     * Fungsi untuk mengambil data Image,Name,dan description berdasarkan poi_id
     * yang diberikan
     *
     * @param integer $poi_id
     * @return array
     */
    public function getImageNameDescriptionById($poiId, $langId)
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",
                array('description'))
                ->join($this->_gallery, "{$this->_gallery}.poi_id =
                {$this->_poidesc}.poi_id", array('source'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = ?", $langId)
                ->where("{$this->_poidesc}.poi_id = ?", $poi_id)
                ->limit(1, 0);

        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data image,name dan description
     * @return array
     */
    public function getAllImageNameDescription()
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->join($this->_poidesc, "{$this->_poidesc}.poi_id = {$this->_name}.poi_id",
                array('description'))
                ->join($this->_gallery, "{$this->_gallery}.poi_id = {$this->_name}.poi_id",
                array('source'))
                ->setIntegrityCheck(false)
                ->where("{$this->_poidesc}.language_id = 1");
        return $this->fetchAll($data);
    }

/*
    public function getPoiIdByName($poi_name,$language_id = 1)
    {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('p' => $this->_name),array('id' => 'p.poi_id'))
                ->join(array('pd' => $this->_poidesc),'p.poi_id = pd.poi_id',array())
                ->where('UPPER(pd.name) = ?',strtoupper($poi_name))
                ->where('pd.language_id = ?',$language_id);
        $id = $this->fetchRow($select);
        return $id['id'];
    }
*/

    public function getPoiIdByName($poi_name,$language_id = 1)
    {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('p' => $this->_name),array('id' => 'p.poi_id'))
                ->join(array('pd' => $this->_poidesc),'p.poi_id = pd.poi_id',array())
                ->where('UPPER(pd.name) = ?',strtoupper($poi_name))
                ->where('pd.language_id = 1 OR pd.language_id = 2')
                ->limit(1);
        $id = $this->fetchRow($select);
        return $id['id'];
    }

    /**
     * Fungsi untuk mengambil data berdasarkan parameter, digunakan untuk CMS destination pada admin
     * 0 - all, 1 - name , 2 - area, 3 - category, 4 - status
     * @return string
     */
    public function getQueryAllByLang($filter = '0', $param = null,$language_id = 1)
    {
        $poi_column = array('poi.poi_id', 'poi.main_category', 'poi.popular', 'poi.status');
        $poi_desc_column = array('poides.name');
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('poi' => $this->_name), $poi_column)
                ->join(array('poides' => 'poidescription'), 'poides.poi_id = poi.poi_id', array('name'));

        switch ($filter)
        {
            case 1 : $select->where("poides.name LIKE '%" . $param . "%'");
                break;
            case 2 : $select->join('areatopoi', 'areatopoi.poi_id = poi.poi_id');
                $select->where('areatopoi.area_id = ?', $param);
                break;
            case 3 : $select->join(array('ctp' => 'categorytopoi'), 'ctp.poi_id = poi.poi_id',array());
                $select->where('ctp.category_id = ?', $param);
                break;
            case 4 : $select->where('poi.status = ?', $param);
                break;
            case 5 : $select->where('poi.special = ?', $param);
        }

        $select->where('language_id = ?', $language_id);
        $select->order('poi.poi_id DESC');
        return $select;
    }

    public function checkIfPoiExist($poi_id)
    {
        $select = $this->select()
                ->from($this->_name,array('exist' => 'COUNT(poi_id)'))
                ->where('poi_id = ?',$poi_id);
        $result = $this->fetchRow($select)->toArray();
        return $result['exist'];
    }

    public function checkIfPoiNameExist($poi_name,$language_id = 1)
    {
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('p' => $this->_name),array('exist' => 'COUNT(p.poi_id)'))
                ->join(array('pd' => $this->_poidesc),'p.poi_id = pd.poi_id',array())
                ->where('pd.language_id = 1 OR pd.language_id = 2')
                ->where('UPPER(pd.name) = ?',strtoupper($poi_name));
        $exist = $this->fetchRow($select)->toArray();
        return $exist['exist'];
    }


    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/
    /* jul                                                                                                  */
    /** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -**/


    /*
        menampilakan hasil pencarian pada tabel poi dan poidescription berdasarkan
        parameter (kata kunci) yang di request
    
    */
    public function suggestDest($param, $lang_id)
    {
        
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('poi_id','name'))
                ->join($this->_poidesc,"{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('description'))
                ->where("{$this->_poidesc}.language_id = ?",$lang_id)
                ->where("{$this->_poidesc}.name like '%$param%'");
                //->limit(10);
        return $this->fetchAll($data);
    }
    
    public function searchDestFix($param, $limit = 10, $offset = 0, $lang_id)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('poi_id'))
                ->join($this->_poidesc,"{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('description', 'name'))
                ->where("{$this->_poidesc}.language_id = ?",$lang_id)
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
                    $string .= "{$this->_poidesc}.name like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_poidesc}.description like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_poidesc}.name like '%$key[$i]%'";
                    $string2 .= "{$this->_poidesc}.description like '%$key[$i]%'";
                }
            }
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');

            //$query->where($string);
            //$query->orWhere($string2);
        }
        else
        {
            $string = "{$this->_poidesc}.name like '%$param%'";
            $string2 = "{$this->_poidesc}.description like '%$param%'";
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');

            //$query->where("{$this->_name}.name like '%$param%'");
            //$query->orWhere("{$this->_poidesc}.name like '%$param%'");
        }
        
        //$result = $string;
        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return null;
        }
    }
    
    public function numbRowsDest($param, $lang_id){
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('poi_id','name'))
                ->join($this->_poidesc,"{$this->_poidesc}.poi_id = {$this->_name}.poi_id",array('description'))
                ->where("{$this->_poidesc}.language_id = ?",$lang_id);
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
                    $string .= "{$this->_poidesc}.name like '%$key[$i]%' OR ";
                    $string2 .= "{$this->_poidesc}.description like '%$key[$i]%' OR ";
                }
                else
                {
                    $string .= "{$this->_poidesc}.name like '%$key[$i]%'";
                    $string2 .= "{$this->_poidesc}.description like '%$key[$i]%'";
                }
            }
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }
        else
        {
            $string = "{$this->_poidesc}.name like '%$param%'";
            $string2 = "{$this->_poidesc}.description like '%$param%'";
            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }
        
        $result = $this->fetchAll($query);
        
        if(count($result))
        {
            return count($result);
        }
        else
        {
            return null;
        }
    }
}

?>
