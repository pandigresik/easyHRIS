var User = {
    login: function () {
        var username = $('#divlogin input[name=username]').val();
        var password = $('#divlogin input[name=password]').val();
        var defaultPage = '#';
        $.ajax({
            url: 'user/checkLogin',
            data: {
                username: username,
                password: password
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {},
            success: function (data) {
                if (data.status) {
                    $('#divlogin #divinfo').html('<div class="alert alert-success">' + data.message + ' success' + '</div>');
                    var redirectPage = (window.location.hash != '') ? window.location.hash.substr(1) : defaultPage;
                    window.location.href = redirectPage;
                } else {
                    $('#divlogin #divinfo').html('<div class="alert alert-danger">' + data.message + ' gagal' + '</div>');
                }
            },
            error: function () {}
        });
        return false;
    },

    changePassword: function () {
        var oldPassword = $('#divChangePassword input[name=oldPassword]').val();
        var newPassword = $('#divChangePassword input[name=newPassword]').val();
        var confirmPassword = $('#divChangePassword input[name=confirmPassword]').val();
        var sama = 1;
        if (newPassword != confirmPassword) {
            sama = 0;
        }
        if (sama) {
            $.ajax({
                url: 'user/changePassword',
                data: {
                    oldPassword: oldPassword,
                    newPassword: newPassword
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {},
                success: function (data) {
                    if (data.status) {
                        $('#divinfo').html('<div class="alert alert-success">' + data.message + '</div>');
                        $('#divChangePassword button[type=submit]').addClass('disabled');
                    } else {
                        $('#divinfo').html('<div class="alert alert-danger">' + data.message + '</div>');
                    }
                },
                error: function () {}
            });
        } else {
            alert('Password belum sama');
        }
        return false;
    }
};

$(function () {
    $('#divlogin input[name=username]').focus();
})