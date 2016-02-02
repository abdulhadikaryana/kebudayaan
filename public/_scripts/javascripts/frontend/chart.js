
$(document).ready(function() {      

    lamanbudaya.cultureCharts.getCultureMainCategory();
   
    $('#filter-chart').click(function(){
        var categoryId = $('#main-category').val();
        if(categoryId == 'all')
            lamanbudaya.cultureCharts.getCultureMainCategory();
        else
            lamanbudaya.cultureCharts.getCultureSubCategory(categoryId);
    });
   
});

lamanbudaya.cultureCharts = {
    chart : null,
    /**
     * Menampilkan main category
     */
    getCultureMainCategory : function() {
        lamanbudaya.cultureCharts.showLoading();
        $.ajax({
            type: 'POST',
            url: lamanbudaya.url.baseUrl + "/chart/category",
            data: {},
            dataType: 'json',
            success: function (data) {         
                if(lamanbudaya.cultureCharts.chart == null)
                    lamanbudaya.cultureCharts.createCategoryChart(data);
                else {                                
                    lamanbudaya.cultureCharts.updateChartData(data);
                }
                lamanbudaya.cultureCharts.hideLoading();                    
            }
        });
    }, 
    /**
     * Menampilkan sub category dari suatu parent category
     */
    getCultureSubCategory : function(parentCategoryId) {
        lamanbudaya.cultureCharts.showLoading();
        $.ajax({
            type: 'POST',
            url: lamanbudaya.url.baseUrl + "/chart/sub-category",
            data: {
                'parent_category' : parentCategoryId
            },
            dataType: 'json',
            success: function (data) {                                
                lamanbudaya.cultureCharts.updateChartData(data);                
                lamanbudaya.cultureCharts.hideLoading();
            }
        });
    },
    /**
     * Membuat grafik
     */
    createCategoryChart : function(data) {          
        lamanbudaya.cultureCharts.chart = new Highcharts.Chart({
            chart: {
                renderTo: 'category-chart',
                type: 'column'
            },
            title: {
                text: data.title,
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                title: {
                    text: data.xLabel
                },
                categories: data.category
            },
            yAxis: {
                title: {
                    text: data.yLabel
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return this.x +': '+ this.y;
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function(e) {                                
                                window.open(lamanbudaya.url.baseUrl + this.config[2], '_blank');
                                e.preventDefault();
                            }
                        }
                    }
                }
            },            
            series: [{
                name: '',
                data: data.total
            }]
        });                
    }, 
    /**
     * Update data di chart
     */
    updateChartData : function(data) {
        lamanbudaya.cultureCharts.chart.setTitle({
            text : data.title
            });
        lamanbudaya.cultureCharts.chart.xAxis[0].setCategories(data.category);
        lamanbudaya.cultureCharts.chart.series[0].setData(data.total);
    },
    /**
     * Memunculkan loader menandakan proses ajax berlangsung
     */
    showLoading : function() {
        if(lamanbudaya.cultureCharts.chart != null)
            lamanbudaya.cultureCharts.chart.showLoading();
        
        $('#filter-loading').removeClass('hide');

    },
    /**
     * Menghilangkan loader ajax
     */
    hideLoading : function() {
        if(lamanbudaya.cultureCharts.chart != null)
            lamanbudaya.cultureCharts.chart.hideLoading();
        
        $('#filter-loading').addClass('hide');
    }
}