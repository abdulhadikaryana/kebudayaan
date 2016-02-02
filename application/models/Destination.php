<?php
/**
 * Model_Destination
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * event dan tidak mengakses ke database
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Solution
 * @author Sangkuriang Solution <www.sangkuriangstudio.com>
 */
class Model_Destination
{
    /**
     * Fungsi untuk mendapatkan angka random untuk gambar header small di halaman
     * destinasi biasa
     *
     * @return string nama file header
     */
    public function getHeaderSmall()
    {
       //$random = rand(0, 2) + 1;
       //return $random.".jpg";
	   //override: dari desainer, cuma ada satu gambar
       return "header-small.jpg";
    }
    public function getHeaderSmallIndo()
    {
       //$random = rand(0, 2) + 1;
       //return $random.".jpg";
	   //override: dari desainer, cuma ada satu gambar
       return "indo_default_header.jpg";
    }
    
    public function getRelatedDestination($poi_id)
    {
        $table_area = new Model_DbTable_Area;
        $table_areatopoi = new Model_DbTable_AreaToPoi;
        
        $area_list = $table_areatopoi->getPoiAreaIdProvince($poi_id,1);
        $poi_list = array();        
        foreach($area_list as $area_id)
        {
            $temp = $table_areatopoi->getAllPoiByAreaIdExPoi($area_id,$poi_id);
            foreach($temp as $temp_poi)
            {
                if(!in_array($temp_poi,$poi_list))
                {
                    array_push($poi_list,$temp_poi);
                }
            }
        }
        
        if (sizeof($poi_list)<5)
        {
            $area_list = $table_areatopoi->getPoiAreaIdProvince($poi_id);
            foreach($area_list as $area_id)
            {
                $temp = $table_areatopoi->getAllPoiByAreaIdExPoi($area_id,$poi_id);
                foreach($temp as $temp_poi)
                {
                    if(!in_array($temp_poi,$poi_list))
                    {
                        array_push($poi_list,$temp_poi);
                    }
                }
            }
        }
        
        if(sizeof($poi_list)>5){$treshold = 5;}else{$treshold = sizeof($poi_list);}
        
        $random = $this->_mrand(0,$treshold-1,$treshold);
        $random_list = array();
        
        foreach($random as $index)
        {
            array_push($random_list,$poi_list[$index]);
        }
        
        return $random_list;
    }
    
    private function _mrand($l,$h,$t,$len=false)
    {
            if($l>$h){$a=$l;$b=$h;$h=$a;$l=$b;}
            if( (($h-$l)+1)<$t || $t<=0 )return false;
            $n = array();
            if($len>0)
            {
                if(strlen($h)<$len && strlen($l)<$len)return false;
                if(strlen($h-1)<$len && strlen($l-1)<$len && $t>1)return false;
            do
            {
                $x = rand($l,$h);
                if(!in_array($x,$n) && strlen($x) == $len)$n[] = $x;
            }
    
            while(count($n)<$t);
            }else{
            do
            {
                $x = rand($l,$h);
            if(!in_array($x,$n))$n[] = $x;
            }
                while(count($n)<$t);
            }
         return $n;
    }
}
?>