<div>
    <title>AIPPMSA - {{\Illuminate\Support\Str::upper($itemType)}}</title>
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
                <table id="itemsTable" class="display table table-striped table-bordered table-hover mb-0 rounded">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
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
@section('custom-css')
    <style>
        #itemsTable {
            width: 100%;
            border-collapse: collapse;
        }

        #itemsTable thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        #itemsTable tbody tr {
            transition: background-color 0.3s;
        }

        #itemsTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        #itemsTable td, #itemsTable th {
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

        #itemsTable td img {
            border-radius: 4px;
        }


        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-inner--icon {
            font-size: 16px;
        }

        .btn-inner--text {
            margin-left: 5px;
        }

        .text-white {
            color: #fff;
        }

        .border-r25 {
            border-radius: 0.25rem;
        }

        .btn-group-sm .btn {
            padding: 0.375rem 0.75rem;
        }
    </style>
@endsection
