<title>AIPPMSA - Categories</title>
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
            <table id="categoriesTable" class="display table table-striped table-bordered table-hover mb-0 rounded">
                <thead class="table-light">
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

@section('custom-css')
    <style>
        #categoriesTable {
            width: 100%;
            border-collapse: collapse;
        }

        #categoriesTable thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        #categoriesTable tbody tr {
            transition: background-color 0.3s;
        }

        #categoriesTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        #categoriesTable td, #categoriesTable th {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-light th {
            background-color: #e9ecef;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .btn {
            margin-right: 5px;
        }
    </style>
@endsection
