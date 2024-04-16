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

    //edit
    $(document).on('click', '.edit', function() {
        //var id = $(this).data('id');
        //document.getElementById("test").dataset.id = id;
        //getDetails(id);
        $('#edit').modal('show');
    });
    $('#editForm').submit(function(e) {

        // var id = document.getElementsById("test").dataset.id;
        e.preventDefault();
        $.ajax({
            method: 'POST',
            // url: 'modal/edit.php',
            success: function(response) {
                if (response.error) {
                    $('#alert').show();

                } else {

                    $('#alert_message').html(response.message);

                }

                $('#edit').modal('hide');
            }
        });
    });
    //




    $(document).on('click', '.no', function(e) {
        var id = $(this).data('id');
        var loginos = $('input[name=loginos]').val();
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'no.php',
            data: "id=" + id + "&loginos=" + loginos,
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                } else {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                    fetch();
                }

                $('#edit').modal('hide');
            }
        });

    });



    $(document).on('click', '.yes', function(e) {
        var id = $(this).data('id');
        var loginos = $('input[name=loginos]').val();
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'yes.php',
            data: "id=" + id + "&loginos=" + loginos,
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                } else {
                    $('#alert').show();
                    $('#alert_message').html(response.message);
                    fetch();
                }

                $('#edit').modal('hide');
            }
        });

    });





    //hide message
    $(document).on('click', '.close', function() {
        $('#alert').hide();
    });

});


$(document).on('click', '.edit', function fetch(id) {
    var id = $(this).data('id');
    getDetails(id);

    $.ajax({
        method: 'POST',
        url: 'fetch_modal.php',
        data: { id: id },
        success: function(response) {
            $('#tbody').html(response);
            $("#target").text($("#wowo").text());
			  $("#target2").text($("#modalos").text());
        }
    });
});

function getDetails(id) {

    $.ajax({
        method: 'POST',
        url: 'fetch_all.php',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                $('#edit').modal('hide');
                $('#delete').modal('hide');
                $('#alert').show();
                $('#alert_message').html(response.message);
            } else {
                $('.id').val(response.data.ID_POLOZKA);
            }
        }

    });
}

function fetch() {
    $.ajax({
        method: 'POST',
        url: 'fast_fetch.php',
        success: function(response) {
            $('#tbodys').html(response);
        }
    });
}