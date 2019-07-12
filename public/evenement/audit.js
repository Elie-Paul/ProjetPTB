$(document).ready(function () {

    $('#commander').on('click', function () {
        let userid = $('#userid').val();
        $.ajax({
                url: '/audit/commandeptbbythera',
                type: 'post',
                data: {userid: userid},
                dataType: 'json',
                success: function (data) {
                    console.log("auditer");
                }
                },
                error: function (error) {
                    alert('Erreur ' + error);
                }
            });
        return false;
    });