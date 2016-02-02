/**
 * Login.js
 *
 * Javascript yang berkaitan dengan fungsi2 login
 */

$(function() {
    onSignInClick();
    validateLoginForm();
});

function onSignInClick()
{
    $('#signIn').click(function(e) {
        e.preventDefault();
        createDialog();
    });

    $('#signInActivate').click(function(e) {
        e.preventDefault();
        createDialog();
    });
}

function createDialog()
{
    $('#login-box').removeClass('hidden');
    $('.error-box').hide();

    $('#username').val('');
    $('#password').val('');

    if ($('#login-box').length > 0) {
        $('#login-box').dialog({
            modal: true,
            position: 'center',
            resizable: 'false',
            title : 'Login - Indonesia Travel',
            width: 300,
            minHeight: 140,
            buttons: {
                'Sign In': function() {
                    $('#loginForm').submit();
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            }
        });
    }
}

function getDataForm()
{
    var username = $('#username').val();
    var password = $('#password').val();

    var dataString = 'username=' + username + '&password=' + password;

    return dataString;
}

function submitForm()
{
    var dataString = getDataForm();
    $('#boxLoading').show();
    $.ajax({
       type: 'POST',
       url: baseUrl + '/login/index',
       data: dataString,
       success: function(data) {
           $('#boxLoading').hide();
            if (data == 'success') {
                window.location = baseUrl;
            } else if (data == 'fail')
                $('.error-box').show();
       }
    });
}

function validateLoginForm()
{
    $("#loginForm input").blur(function(){
        $("#loginForm").validate().element($(this));
    });

    $("#loginForm").validate({
        rules : {
            username:{
                required:true
            },
            password:{
                required:true
            }
        },
        messages : {
            username : "Please enter your username",
            password : "Please enter your email"
        }

    });
}

