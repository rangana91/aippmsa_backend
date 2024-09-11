<title>Antique Shop - Categories</title>
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Categories</h1>
        </div>
        <div>
            <a href="" class="btn btn-outline-gray-600 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#new-cat-modal">
                Add New Category
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="categoriesTable" class="display table table-centered table-nowrap mb-0 rounded">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Display Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('components/add_category_modal')
@include('components/edit-category')
@include('components/delete-category')
@section('custom-js')
    <script src="/assets/js/category.js"></script>
@endsection
