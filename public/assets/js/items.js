$(document).ready(function (){

    const currentURL = window.location.href;
    const urlParts = currentURL.split('/');
    const itemType = urlParts[urlParts.length - 1];
    const itemTable = $('#itemsTable').DataTable( {
        serverSide: true,
        ajax: {
            url: '/items/'+itemType,
            // dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'category.display_name' },
            { data: 'price' },
            { data: 'imageData' },
            { data: 'action' },
        ]
    } );

    //edit function
    $('#itemsTable tbody').on('click', '.table-action-edit', function() {
        let data = itemTable.row($(this).parents('tr')).data();

        // Set the form values with the item data
        $('#item_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_qty').val(data.qty);
        $('#edit_price').val(data.price);
        $('#edit_description').val(data.description);
        $("#edit_category").val(data.category.id);
        $("#edit_producer_code").val(data.producer_code);
        $("#edit_inventory_code").val(data.inventory_code);
        $("#editImagePreview").attr('src', data.image);

        // Clear existing variant rows
        $('#variant-rows').empty();

        // Populate the variant rows from the existing data
        data.variants.forEach(function(variant) {
            addVariantRow(variant.size, variant.color, variant.quantity);
        });

        // Show the modal
        $('#edit-item-modal').modal('toggle');
    });

    //variants for the edit
    let variantIndex = 0;

    // Add a new variant row
    function addVariantRow(size = '', color = '', quantity = '') {
        const row = `<tr data-variant-index="${variantIndex}">
                        <td><input type="text" name="variants[${variantIndex}][size]" class="form-control" value="${size}" /></td>
                        <td><input type="text" name="variants[${variantIndex}][color]" class="form-control" value="${color}" /></td>
                        <td><input type="number" name="variants[${variantIndex}][quantity]" class="form-control" value="${quantity}" /></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Remove</button>
                        </td>
                     </tr>`;
        $('#variant-rows').append(row);
        variantIndex++;
    }

    // Add variant button click
    $('#add-variant-btn').on('click', function () {
        addVariantRow(); // Adds a blank row
    });

    // Remove variant row
    $(document).on('click', '.remove-variant-btn', function () {
        $(this).closest('tr').remove();
    });

    //create item
    $('#add_item_form').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);
        // formData.append('imageFile', $('#imageFile')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "/add-item",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // location.reload();
                $('#new-item-modal').modal('toggle');
                itemTable.ajax.reload();
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

    $("#add_item_form input").on("keyup", function() {
        let fieldName = $(this).attr("name");
        $("#" + fieldName + "-error").text("");
    });

    //update item
    $('#edit_item_form').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "/update-item",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#edit-item-modal').modal('toggle');
                itemTable.ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    let errorMessage = messages.join("<br>");
                    $("#" + fieldName + "-edit-error").html(errorMessage);
                });
            }
        });
    });

    $('#editImageFile').change(function () {
        let fileInput = this;

        if (fileInput.files && fileInput.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#editImagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            $('#editImagePreview').attr('src', '');
        }
    });

    $("#edit_item_form input").on("keyup", function() {
        let fieldName = $(this).attr("name");
        $("#" + fieldName + "-error").text("");
    });

    //delete function
    $('#itemsTable tbody').on('click', '.table-action-delete', function() {
        let data = itemTable.row($(this).parents('tr')).data();
        $("button.btn-primary").attr("data-item-id", data.id);
        $('#delete-item').modal('toggle');
    });

    $('.delete-item-btn').on('click', function (){
        let itemId = $("button.btn-primary").attr("data-item-id");
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/delete-item",
            data: {
                'item_id': itemId,
                '_token': csrfToken,
            },
            success: function(response) {
                // location.reload();
                $('#delete-item').modal('toggle');
                itemTable.ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    alert(messages);
                });
            }
        });
    })

    $('.close-item-delete').on('click', function (){
        $('#delete-item').modal('toggle');
    })

    //check existing producer code
    $("#producer_code").on("blur", function() {
        let code = $(this).val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/check-producer-code",
            data: {
                'code': code,
                '_token': csrfToken,
            },
            success: function(response) {
                if (response) {
                    $('#existing-producer-code').modal('toggle');
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    alert(messages);
                });
            }
        });
    });

    //update existing producer code quantity
    $('#updateExistingQty').on('click', function (){
        let code = $('#producer_code').val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/update-existing-item",
            data: {
                'code': code,
                '_token': csrfToken,
            },
            success: function(response) {
                $('#existing-producer-code').modal('toggle');
                $('#new-item-modal').modal('toggle');
                itemTable.ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                $(".error-message").text("");
                $.each(errors, function(fieldName, messages) {
                    alert(messages);
                });
            }
        });
    })
})