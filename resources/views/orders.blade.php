<title>Antique Shop - Orders</title>
<h1>Test</h1>
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
            <table id="ordersTable" class="display table table-centered table-nowrap mb-0 rounded">
                <thead>
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
