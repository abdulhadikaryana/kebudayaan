(function() {
    tinymce.create('tinymce.plugins.review', {
        init : function(ed, url) {
            ed.addButton('review', {
                title : 'Insert review',
                image : url+'/images/rev_icon.png',
                onclick : function() {

                     ed.selection.setContent('[review]');  

              }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('review', tinymce.plugins.review);
     
})();
