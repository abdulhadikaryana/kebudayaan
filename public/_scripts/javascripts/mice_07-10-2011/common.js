$(function(){
    $('#customselector').customSelect();
    $('.selectitems').click(function(){
        var lang = $(this).attr('id');
        changeLanguage(lang,document.URL);
    });

});



function changeLanguage(lang, links)
{
    var linkSplit = new Array();
    linkSplit = links.split("/")

    if(application_environtment == 'development')
    {
		linkSplit[6] = lang;
    }
    else
    {
		linkSplit[4] = lang;
    }

	var linkBaru = linkSplit.join("/");

	if ((lang == 'id')||(lang == 'en'))
    {
        switch(lang)
        {
            case 'en' : window.location = linkBaru;
                      break;
            case 'id' : window.location = linkBaru;
                      break;
        }
	}
}