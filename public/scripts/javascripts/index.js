/**
 * index.js
 *
 * Javascript yang berisi fungsi2 yang digunakan di halaman index/home
 *
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

/**
 * Fungsi On Ready JQuery
 */
$(function() {

    initTabOnClick();
    initEventDatePicker();

    showdestTab();

});

/**
 * Fungsi untuk inisialisasi on click event untuk tab search destinasi dan
 * aktivitas
 */
function initTabOnClick()
{
    $('#dest-link').click(function(){
        showdestTab();
    });

    $('#dir-link').click(function(){
       showDirectoryTab()
    });
}

/**
 * Fungsi untuk inisialisasi date picker untuk search event
 */
function initEventDatePicker()
{
    // Date picker
    $('#start-date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#end-date').datepicker({dateFormat: 'yy-mm-dd'});
}

/**
 * Fungsi yang dipanggil jika tab destinasi di-klik
 */
function showdestTab()
{
    $('#dest-search-tab').attr('class', 'show');
    $('#dir-search-tab').attr('class', 'hidden');

    $('#dest-link img').attr('id', 'dest-img-hover');
    $('#dir-link img').attr('id', 'dir-img');
}

/**
 * Fungsi yang dipanggil jika tab aktivitas di-klik
 */
function showDirectoryTab()
{
    $('#dir-search-tab').attr('class', 'show');
    $('#dest-search-tab').attr('class', 'hidden');

    $('#dir-link img').attr('id', 'dir-img-hover');
    $('#dest-link img').attr('id', 'dest-img');
}

/**
 * Fungsi yang menentukan form destinasi atau aktivitas yang di-submit
 */
function submitSearchForm()
{
    if($('#dest-search-tab').hasClass('show')) {
        setDestinationFormForSubmit();
    } else if($('#dir-search-tab').hasClass('show')) {
        setDirectoryFormForSubmit();
    }
}

/**
 * Fungsi untuk reset form destinasi
 */
function resetSearchForm()
{
    if($('#dest-search-tab').hasClass('show')) {
        resetDestinationForm();
        $('#dest-search-tab .error-box').hide();
    } else if($('#dir-search-tab').hasClass('show')) {
        resetDirectoryForm();
        $('#dest-search-tab .error-box').hide();
    }
}

/**
 * Fungsi untuk menyiapkan data destinasi untuk submit
 */
function setDestinationFormForSubmit()
{
    var destName = $('#destName').val();
    //var destLocation = $('#destLocation').val();
    
    var url = baseUrl + "/destination/search";
    if (destName != ""){
        url += "/name/" + destName;
        $('#dest-search-tab .error-box').hide();
        window.open(url);
        

    }
    else{
        //$('#dest-search-tab .error-box').html('Please fill the empty field');
        $('#dest-search-tab .error-box').show();
    }
}

/**
 * Fungsi yang dipanggil untuk menyiapkan data aktivitas untuk submit
 */
function setDirectoryFormForSubmit()
{
    var destActivity = $('#destActivity').val();

    var url = baseUrl + "/activity";
    if (destActivity != 0)
        url += "/detail/" + destActivity;

    window.open(url);
}

/**
 * Fungsi untuk mereset value di form destinasi
 */
function resetDestinationForm()
{
    $('#destName').val('');
    $('#error-msg-dest').html('');
}

/**
 * Fungsi untuk mereset value di form directory/activity
 */
function resetDirectoryForm()
{
    $('#destActivity').val('');
}

/**
 * Fungsi untuk melakukan reset field-field search events
 */
function resetEvents()
{
    $('#start-date').val('Start Date');
    $('#end-date').val('End Date');
    $('#event-search-form .error-box').hide();
}

/**
 * Fungsi yang digunakan untuk melihat event dari tanggal2
 * yang dipilih oleh user.
 */
function seeEvents()
{
    var dateStart = $('#start-date').val();
    var dateEnd = $('#end-date').val();

    var url = '';
    if(dateStart != 'Start Date'){
         if(dateStart != 'Start Date') {
                url += '/date-start/' + dateStart;
                $('#error_event_home').html('');
         }
         if(dateEnd != 'End Date') {
                url += '/date-end/' + dateEnd;
    
         }
        $('#event-search-form .error-box').hide();
        window.open(
            baseUrl + '/event/search' + url
         );
    }else if((dateStart == 'Start Date')&&(dateEnd != 'End Date')){
        $('#event-search-form .error-box').show();
    }else{
        $('#event-search-form .error-box').show();
    }

    
}

/**
 * Fungsi yang dipanggil jika field name di search destinasi form.
 * Digunakan jika user menekan enter di field maka bisa langsung melakukan
 * proses searching
 */
function onSearchKeyPress(event)
{
    var key;

    if(window.event) {
        key = event.keyCode;
    } else if(event.which) {
        key = event.which;
    }

    if (isNaN(key)) return true;

    // enter
    if (key == 13) {
        submitSearchForm();
        return false;
    } else {
        return true;
    }
}

