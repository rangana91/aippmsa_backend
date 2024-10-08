<title>AIPPMSA - Orders</title>
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Orders</h1>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="ordersTable" class="display table table-striped table-bordered table-hover mb-0 rounded">
                <thead class="table-light">
                <tr>
                    <th>Customer Name</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@section('custom-js')
    <script src="/assets/js/orders.js"></script>
@endsection
@section('custom-css')
    <style>
        #ordersTable {
            width: 100%;
            border-collapse: collapse;
        }

        #ordersTable thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        #ordersTable tbody tr {
            transition: background-color 0.3s;
        }

        #ordersTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        #ordersTable td, #ordersTable th {
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

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
@endsection
