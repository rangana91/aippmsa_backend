<div class="modal fade" id="edit-item-modal" tabindex="-1" role="dialog" aria-labelledby="edit-item-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card p-3 p-lg-4">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h4">Edit Item</h1>
                    </div>
                    <form action="#" id="edit_item_form" class="mt-4">
                        @csrf
                        <input type="hidden" id="item_id" name="id">

                        <!-- Basic Details (Name, Category, Price, etc.) -->
                        <div class="form-group mb-4">
                            <label for="edit_name">Item Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Item name" id="edit_name" name="name" autofocus>
                            </div>
                            <span class="error-message font-base text-danger" id="name-edit-error"></span>
                        </div>

                        <div class="form-group mb-4">
                            <label for="edit_category" class="my-1 me-2">Category</label>
                            <select name="category_id" class="form-select" id="edit_category" aria-label="Category">
                                <option selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->display_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Variants Section -->
                        <div class="form-group mb-4">
                            <h5>Variants</h5>
                            <table class="table" id="variantsTable">
                                <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="variant-rows">
                                <!-- Variant rows will be dynamically inserted here -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-outline-secondary" id="add-variant-btn">Add Variant</button>
                        </div>

                        <!-- Price and Description -->
                        <div class="form-group mb-4">
                            <label for="edit_price">Price</label>
                            <div class="input-group">
                                <input type="number" placeholder="Price" class="form-control" name="price" id="edit_price">
                            </div>
                            <span class="error-message font-base text-danger" id="price-edit-error"></span>
                        </div>

                        <div class="form-group mb-4">
                            <label for="editImageFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="editImageFile" name="imageFile">
                            <div class="mt-3 text-center">
                                <img src="" alt="Preview" id="editImagePreview" style="max-width: 75px; max-height: 75px;" class="rounded-circle">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="edit_description">Description</label>
                            <div class="input-group">
                                <textarea class="form-control" placeholder="Description" id="edit_description" name="description" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="update_item" class="btn btn-gray-800">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
