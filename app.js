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
        var id = $(this).data('id');
        document.getElementsByClassName("id")[0].dataset.value = id;
        getDetails(id);
        $('#edit').modal('show');
    });
    $('#editForm').submit(function(e) {
        var id = document.getElementsByClassName("id")[0].dataset.value;
        //var nazev = document.getElementById("nazev").value = document.getElementsByClassName("nazev")[0].innerText;
        // var mj = document.getElementById("mj").value = document.getElementsByClassName("mj")[0].innerText;
        e.preventDefault();
        var editform = $(this).serialize() + '&id=' + id;
        $.ajax({
            method: 'POST',
            url: 'edit.php',
            data: editform,
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
    //

    //----------------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete', function() {
        var id = $(this).data('id'); //get data id form clicked element
        document.getElementsByClassName("id")[1].dataset.deleteid = id; //assign the clicked elm id to new submit modal "yes" btn
        getDetails(id); //post query to delete
        $('#delete').modal('show'); //show modal delete

        document.getElementsByClassName("id")[1].dataset.deleteid; //get current "yes" button modal id value to delete
    });


    $('.id').click(function() {

        var id = document.getElementsByClassName("id")[1].dataset.deleteid;
        $.ajax({
            method: 'POST',
            url: 'delete.php',
            data: { id: id },
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

                $('#delete').modal('hide');
            }
        });
    });

    //---------------------------------------------------------------------------------------------------------

    //hide message
    $(document).on('click', '.close', function() {
        $('#alert').hide();
    });

});

function fetch() {
    $.ajax({
        method: 'POST',
        url: 'fetch.php',
        data: { uniq: $('.uniform').val() },
        success: function(response) {
            $('#tbody').html(response);
        }
    });
}

function getDetails(id) {
    $.ajax({
        method: 'POST',
        url: 'fetch_row.php',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                $('#edit').modal('hide');
                $('#delete').modal('hide');
                $('#alert').show();
                $('#alert_message').html(response.message);
            } else {
                console.log(response);
                $('.id').val(response.data.ID_POLOZKA);
                $('.nazev').val(response.data.NAZEV);
                $('.mj').val(response.data.MJ);
                $('.mnozstvi').val(response.data.MNOZSTVI);
                $('.cena').val(response.data.CENA);
                $('.celkem').val(response.data.CELKEM);
                $('.uniform').val(response.data.UNIQ);

            }
        }

    });
}