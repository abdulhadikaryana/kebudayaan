/**
 * contactus.js
 */

$(function() {

    if ($("#success-message").length > 0) {
        $("#success-message").dialog({
            modal: true,
            position: 'center',
            resizable: 'false',
            width: 450,
            height: 190,
            buttons: {
                Ok: function() {
                    window.location = baseUrl;
                }
            }
        });
    }
});

