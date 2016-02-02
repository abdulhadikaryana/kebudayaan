/**
 * Registration.js
 *
 * Javascript yang berisi fungsi2 yang berkaitan dengan registrasi
 *
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

/**
 * JQuery OnReady function
 */
$(function() {

    $('#changePassword').live('click', function(e) {
        e.preventDefault();
        createChangePasswordDialog();
    });


    if ($("#activation-message").length > 0) {
        $("#activation-message").dialog({
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

function createChangePasswordDialog()
{
    $('#change-password-box').removeClass('hidden');
    $('.error-box').hide();
    $('#oldPassword').val('');
    $('#newPassword').val('');
    $('#newPassword2').val('');

    if ($('#change-password-box').length > 0) {
        $('#change-password-box').dialog({
            modal: true,
            position: 'center',
            resizable: 'false',
            title : 'Change Password - Indonesia Travel',
            width: 400,
            minHeight: 140,
            buttons: {
                'Change Password': function() {
                    submitChangePasswordForm();
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            }
        });
    }
}

function createChangePasswordMsgDialog()
{
    if ($("#change-password-message").length > 0) {
        $("#change-password-message").dialog({
            modal: true,
            position: 'center',
            resizable: 'false',
            width: 400,
            height: 130,
            buttons: {
                Ok: function() {
                    $(this).dialog('close');
                }
            }
        });
    }
}


function getChangePasswordForm()
{
    var oldPassword = $('#oldPassword').val();
    var newPassword = $('#newPassword').val();
    var newPassword2 = $('#newPassword2').val();

    var dataString = {oldPassword: oldPassword, newPassword: newPassword,
        newPassword2: newPassword2};

    return dataString;
}

function submitChangePasswordForm()
{
    var dataString = getChangePasswordForm();
    $('#boxLoading').show();
    
    $.ajax({
       type: 'POST',
       url: baseUrl + '/registration/change',
       data: dataString,
       success: function(data) {
            $('#boxLoading').hide();
            if (data == 'success') {
                $('#change-password-box').dialog('close');
                createChangePasswordMsgDialog();
                $('#change-password-message').show();
            } else {
                $('#change-password-box .error-box').html(data);
                $('#change-password-box .error-box').show();
            }
       }
    });
}
