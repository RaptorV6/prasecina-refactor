$(document).ready(function() {
    fetch();
    //add
    $('#addnew').click(function() {
        $('#add').modal('show');
    });
    $('#addForm').submit(function(e) {
        e.preventDefault();
        var addform = $(this).serialize();
        //console.log(addform);
        $.ajax({
            method: 'POST',
            url: 'add.php',
            data: addform,
            dataType: 'json',
            success: function(response) {
                $('#add').modal('hide');
                if (response.error) {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                } else {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                    fetch();
                }
            }
        });
    });
    //




    //hide message
    $(document).on('click', '.close', function() {
        $('#alert').hide();
    });

});

function fetch() {
    $.ajax({
        method: 'POST',
        url: 'check/fetch.php',
        data: { zadanka: $('.zadanka').val() },
        success: function(response) {
            $('#tbody').html(response);
        }
    });
}