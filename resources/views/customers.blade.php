<title>AIPPMSA - Customers</title>
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Customers</h1>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="customersTable" class="display table table-striped table-bordered table-hover mb-0 rounded">
                <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@section('custom-js')
    <script src="/assets/js/customers.js"></script>
@endsection

@section('custom-css')
    <style>
        #customersTable {
            width: 100%;
            border-collapse: collapse;
        }

        #customersTable thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
        }

        #customersTable tbody tr {
            transition: background-color 0.3s;
        }

        #customersTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        #customersTable td, #customersTable th {
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
    </style>
@endsection
