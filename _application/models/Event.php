<?php
/**
 * Model_Event
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * event dan tidak mengakses ke database
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Solution
 * @author Sangkuriang Solution <www.sangkuriangstudio.com>
 *
 */
class Model_Event
{
    /**
     * Bahasa yang digunakan
     * 
     * @var integer
     */
    private $_languageId;

    /**
     * Constructor
     */
    function __Construct()
    {
        $this->_languageId = Zend_Registry::get('languageId');
    }
    
    /**
     * Fungsi untuk mencari event-event berdasarkan tanggal.
     * Contoh mencari event tanggal 7 oktober maka
     * dibawah ini event yang muncul yaitu:
     *  - event dari tgl 5 okt - 8 okt
     *  - event tgl 7 okt dan berakhir tgl 7 okt (one day event)
     * 
     * @param string $dateStart tanggal mulai event
     * @param string $dateEnd tanggal berakhir event
     * @return array daftar event
     */
    public function getAllSearchEvent($dateStart, $dateEnd, $sortingOptions = null,$langId)
    {
        // mendapatkan tanggal-tanggal yang ada di rentang waktu tersebut
        $dates = $this->_getDateRangeArray($dateStart, $dateEnd);
        //print_r($dates);

        // Data
        $eventDescDb = new Model_DbTable_EventDesc;
        $allevents = $eventDescDb->getEventByStartDate($dateStart, $langId,
            $sortingOptions = null);
        //echo "<pre>";
        //print_r($allevents);

        // untuk menyimpan dengan array key, menjamin tidak ada event yg dimasukkin lebih dari satu
        $arrTmpEvent = array();
        // untuk menyimpan array final
        $arrEvent = array();

        // cek per hari apakah di hari tersebut ada event yg terjadi
        for($i=0; $i < count($dates); $i++)
        {
            $current = strtotime($dates[$i]);

            foreach($allevents as $allevent)
            {

                // dari format date time mysql, kita ambil date-nya saja
                $onlyStartDate = explode(" ", $allevent['date_start']);
                $onlyEndDate = explode(" ", $allevent['date_end']);

                // ubah ke strtotime untuk bisa dibandingkan
                $start = strtotime($onlyStartDate[0]);
                $end = strtotime($onlyEndDate[0]);

                $event_id = $allevent['event_id'];

                // cek apakah tanggal sekarang ada event-nya
                if($current >= $start && $current <= $end)
                {
                    // arrTmpEvent untuk cek apakah event tersebut sudah exist apa blum
                    if(!in_array($event_id,$arrTmpEvent))
                    { // cek array key dgn menggunakan event id
                        $arrTmpEvent[] = $event_id;
                        $arrEvent[] = $allevent;

                    }
                }
            }
        }

        unset($arrTmpEvent); // destroy tmp event

        return $arrEvent;
    }

    /**
     * Fungsi untuk mendapatkan jumlah minggu dalam suatu bulan
     *
     * @param Array $daysInMonth Jumlah hari dalam bulan
     * @param Integer $firstDay Hari pertama dalam bulan
     * @return Integer jumlah minggu
     */
    public function getWeeksInMonth($daysInMonth, $firstDay)
    {
        if ($firstDay < 0)
            $firstDay += 7;
        
        $tempDays = $firstDay + $daysInMonth;
        $weeksInMonth = ceil($tempDays / 7);

        return $weeksInMonth;
    }

    /**
     * Fungsi untuk membentuk daftar tanggal dalam suatu bulan dengan
     * mempertimbangkan hari pertama dalam bulan tersebut jatuh pada hari apa
     *
     * @param Integer $weeksInMonth jumlah minggu per bulan
     * @param Integer $daysInMonth jumlah hari per bulan
     * @param Integer $firstDay hari pertama dalam bulan tersebut
     *
     * @return <type> 
     */
    public function getDaysInMonth($weeksInMonth, $daysInMonth, $firstDay)
    {
        $counter = 0;
        $week[$weeksInMonth] = Array();
        if ($firstDay < 0) {
            $firstDay += 7;
        }
        for ($j = 0;$j < ($weeksInMonth + 1);$j++) {
            for ($i = 0;$i < 7;$i++) {
                $counter++;
                $week[$j][$i] = $counter;
                // geser hari dgn pertimbangan hari bulan sebelumnya
                $week[$j][$i] -= $firstDay;
                if (($week[$j][$i] < 1) || ($week[$j][$i] > $daysInMonth)) {
                    $week[$j][$i] = "";
                }
            }
        }

        return $week;
    }

    /**
     * Fungsi untuk mendapatkan tanggal-tanggal yang berada
     * pada rentang tanggal contoh 29 nov - 2 januari, maka
     * akan mengembalikan tgl 29, 30, 1 januari, dan 2 januari
     *
     * @param string $dateStart
     * @param string $dateEnd
     * @return array tanggal
     */
    private function _getDateRangeArray($dateStart, $dateEnd)
    {
        $range = array();

        // ubah dari string ke bentuk tanggal
        if (is_string($dateStart) === true)
            $dateStart = strtotime($dateStart);
        if (is_string($dateEnd) === true )
            $dateEnd = strtotime($dateEnd);

        do
        {
            // masukkan tanggal ke array
            $range[] = date('Y-m-d', $dateStart);
            // tambah satu hari
            $dateStart = strtotime("+ 1 day", $dateStart);
        } while($dateStart <= $dateEnd);

        return $range;
    }
}
?>
