$(document).ready(function(){

    const categoryTable = $('#categoriesTable').DataTable( {
        serverSide: true,
        ajax: {
            url: '/category-data',
            // dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'display_name' },
            { data: 'action' },
        ]
    } );

    //edit function
    $('#categoriesTable tbody').on('click', '.table-action-edit', function() {
        let data = categoryTable.row($(this).parents('tr')).data();
        $('#cat_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_display_name').val(data.display_name);
        $('#edit-cat-modal').modal('toggle');
    });

    $('#edit_cat_form').on('submit', function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/update-category",
            data: formData,
            success: function(response) {
                // location.reload();
                $('#edit-cat-modal').modal('toggle');
                categoryTable.ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    let errorMessage = messages.join("<br>");
                    $("#" + fieldName + "-error").html(errorMessage);
                });
            }
        });
    });

    //delete function
    $('#categoriesTable tbody').on('click', '.table-action-delete', function() {
        let data = categoryTable.row($(this).parents('tr')).data();
        $("button.btn-primary").attr("data-cat-id", data.id);
        $('#delete-category').modal('toggle');
    });

    $('.delete-cat-btn').on('click', function (){
        let categoryId = $("button.btn-primary").attr("data-cat-id");
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/delete-category",
            data: {
                'cat_id': categoryId,
                '_token': csrfToken,
            },
            success: function(response) {
                // location.reload();
                $('#delete-category').modal('toggle');
                categoryTable.ajax.reload();
            },
            error: function(error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".error-message").text("");
                    $.each(errors, function(fieldName, messages) {
                        alert(messages);
                    });
                    $('#delete-category').modal('toggle');
                } else {
                    alert(error.responseJSON);
                    $('#delete-category').modal('toggle');
                }

            }
        });
    })

    //create category
    $("#add_cat_form").submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/create-category",
            data: formData,
            success: function(response) {
                $('#new-cat-modal').modal('toggle');
                categoryTable.ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    let errorMessage = messages.join("<br>");
                    $("#" + fieldName + "-error").html(errorMessage);
                });
            }
        });
    });

    $('.close-cat-delete').on('click', function (){
        $('#delete-category').modal('toggle');
    })

    $("#edit_cat_form input").on("keyup", function() {
        let fieldName = $(this).attr("name");
        $("#" + fieldName + "-error").text("");
    });

    $("#new-cat-modal input").on("keyup", function() {
        let fieldName = $(this).attr("name");
        $("#" + fieldName + "-error").text("");
    });
})