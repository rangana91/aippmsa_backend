<div class="modal fade" id="new-item-modal" tabindex="-1" role="dialog" aria-labelledby="new-item-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card p-3 p-lg-4">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h4">Add New {{\Illuminate\Support\Str::title($itemType)}}</h1>
                    </div>
                    <form action="#" id="add_item_form" class="mt-4">
                        @csrf
                        <!-- General Information -->
                        <div class="form-group mb-4">
                            <label for="name">Item Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Item name" id="name" name="name">
                            </div>
                            <span class="error-message font-base text-danger" id="name-error"></span>
                        </div>

                        <!-- Category -->
                        <div class="form-group mb-4">
                            <label class="my-1 me-2" for="category">Category</label>
                            <select name="category_id" class="form-select" id="category" aria-label="Category">
                                <option selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->display_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dynamic Variant Section -->
                        <div id="variants-container">
                            <div class="variant-row mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="size">Size</label>
                                        <select name="size[]" class="form-select" aria-label="Size">
                                            @if($itemType == 'short' || $itemType == 'skirt')
                                                <option value="12">12</option>
                                                <option value="14">14</option>
                                                <option value="16">16</option>
                                                <!-- Add more sizes as needed -->
                                            @else
                                                <option value="s">S</option>
                                                <option value="m">M</option>
                                                <option value="l">L</option>
                                                <option value="xl">XL</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="color">Color</label>
                                        <select name="color[]" class="form-select" aria-label="Color">
                                            <option value="white">White</option>
                                            <option value="green">Green</option>
                                            <option value="black">Black</option>
                                            <option value="purple">Purple</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantity[]" class="form-control"
                                               placeholder="Quantity">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger mt-2 remove-variant">Remove</button>
                            </div>
                        </div>

                        <!-- Add More Variant Button -->
                        <div class="form-group">
                            <button type="button" id="add-variant" class="btn btn-secondary">Add Variant</button>
                        </div>

                        <!-- Price -->
                        <div class="form-group mb-4">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" placeholder="Price" name="price">
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group mb-4">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="imageFile" name="imageFile">
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" placeholder="Description" id="description" name="description"
                                      rows="4"></textarea>
                        </div>

                        <div class="d-grid">
                            <input type="hidden" name="type" value="{{$itemType}}">
                            <button type="submit" id="add_item" class="btn btn-gray-800">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add more variants dynamically
    document.getElementById('add-variant').addEventListener('click', function () {
        let variantHtml = `
            <div class="variant-row mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="size">Size</label>
                        <select name="size[]" class="form-select">
                            @if($itemType == 'short' || $itemType == 'skirt')
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                            @else
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                            @endif
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="color">Color</label>
                                    <select name="color[]" class="form-select">
                                        <option value="white">White</option>
                                        <option value="green">Green</option>
                                        <option value="black">Black</option>
                                        <option value="purple">Purple</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity[]" class="form-control" placeholder="Quantity">
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger mt-2 remove-variant">Remove</button>
                            </div>
                            `;
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', variantHtml);

        // Attach event to remove variant row
        document.querySelectorAll('.remove-variant').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.variant-row').remove();
            });
        });
    });
</script>
