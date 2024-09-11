<title>Antique Shop - {{\Illuminate\Support\Str::upper($itemType)}}</title>
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Item List</h1>
        </div>
        <div>
            <a href="" class="btn btn-outline-gray-600 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#new-item-modal">
                Add New {{\Illuminate\Support\Str::title($itemType)}}
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="itemsTable" class="display table table-centered table-nowrap mb-0 rounded">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('components/add-item')
@include('components/edit-item')
@include('components/delete-item')
@include('components/existing-producer-code')
@section('custom-js')
    <script src="/assets/js/items.js"></script>
@endsection
