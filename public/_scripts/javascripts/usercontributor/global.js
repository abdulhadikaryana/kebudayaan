/*
* global.js berisi fungsi-fungsi javascript yang digunakan 
* oleh seluruh page usercontributor
*
*/

function setCookie(name, value, nDays)
{
    var expires = new Date ();
    expires.setTime(expires.getTime() + 1000 * 60 * 60 * 24 * nDays);

	document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
}


function implode (glue, pieces) {
    // Joins array elements placing glue string between items and return one string  
    // 
    // version: 1103.1210
    // discuss at: http://phpjs.org/functions/implode
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Waldo Malqui Silva
    // +   improved by: Itsacon (http://www.itsacon.net/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: implode(' ', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'Kevin van Zonneveld'
    // *     example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'});
    // *     returns 2: 'Kevin van Zonneveld'
    var i = '',
        retVal = '',
        tGlue = '';
    if (arguments.length === 1) {
        pieces = glue;
        glue = '';
    }
    if (typeof(pieces) === 'object') {
        if (pieces instanceof Array) {
            return pieces.join(glue);
        } else {
            for (i in pieces) {
                retVal += tGlue + pieces[i];
                tGlue = glue;
            }
            return retVal;
        }
    } else {
        return pieces;
    }
}