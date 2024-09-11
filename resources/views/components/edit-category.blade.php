<div class="modal fade" id="edit-cat-modal" tabindex="-1" role="dialog" aria-labelledby="edit-cat-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card p-3 p-lg-4">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h4">Edit Category </h1>
                    </div>
                    <form action="#" id="edit_cat_form" class="mt-4">
                        @csrf
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="category">Category</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="category name" id="edit_name" name="name" autofocus>
                            </div>
                            <span class="error-message font-base text-danger" id="name-error"></span>
                        </div>
                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="cat_display_name">Category Display Name</label>
                                <div class="input-group">
                                    <input type="text" placeholder="Category Display Name" class="form-control" name="display_name" id="edit_display_name">
                                </div>
                                <span class="error-message font-base text-danger" id="display_name-error"></span>
                            </div>
                        </div>
                        <div class="d-grid">
                            <input type="text" id="cat_id" name="id" hidden="">
                            <button type="submit" id="add_cat" class="btn btn-gray-800">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
