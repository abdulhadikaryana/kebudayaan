/**
 * Js untuk generate event calendar
 */

$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        firstDay: 1, // Senin
        titleFormat: {
            week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",  
            day: 'dddd, d MMM yyyy'
        },
        monthNames: lamanbudaya.calendar.getMonthNames(lamanbudaya.setting.lang),
        monthNamesShort: lamanbudaya.calendar.getMonthNamesShort(lamanbudaya.setting.lang),
        dayNames: lamanbudaya.calendar.getDayNames(lamanbudaya.setting.lang),
        dayNamesShort: lamanbudaya.calendar.getDayNamesShort(lamanbudaya.setting.lang),
        buttonText: lamanbudaya.calendar.getButtonText(lamanbudaya.setting.lang),
        editable: false,
        events: lamanbudaya.url.baseUrl + '/ajax/eventlist',
        loading: function (bool) { 
            if (bool) 
                $.blockUI({ message: $('#ajax-message') });
        }
    });
});

lamanbudaya.calendar = {
    getMonthNames : function(lang) {        
        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'];
        
        if(lang == 'id') {
            monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        }
        
        return monthNames;
    },
    getMonthNamesShort : function(lang) {        
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        if(lang == 'id') {
            monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        }
        
        return monthNames;
    },    
    getDayNames : function(lang) {
        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        if(lang == 'id') {
            dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
        }
        return dayNames;
    },
    getDayNamesShort : function(lang) {
        var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        if(lang == 'id') {
            dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        }
        return dayNames;
    },
    getButtonText : function(lang) {
        var buttonText = {
            today:    'today',
            month:    'month',
            week:     'week',
            day:      'day'
        };
        
        if(lang == 'id') {
            buttonText = {
                today:    'Hari ini',
                month:    'Bulan',
                week:     'Mingguan',
                day:      'Harian'
            };
        }
        return buttonText;
    }
};





