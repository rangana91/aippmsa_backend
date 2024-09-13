<title>AIPPMSA Dashboard</title>
<div class="row">
</div>
<div class="row text-center">
    <div class="col-12 col-xl-8">
        <div class="row">
            <!-- Existing Card -->
            <div class="col-12 col-xxl-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h2 class="fs-5 fw-bold mb-0">Welcome to AIPPMSA Portal</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Row for Three Cards Centered -->
        <div class="row justify-content-center mt-4">
            <!-- Card 1: Items -->
            <div class="col-12 col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3 text-primary">{{$items}}</div>
                        <h5 class="card-title fs-5 fw-bold mb-2">Items</h5>
                        <p class="card-text">Total number of items available in the inventory. Stay updated with the latest additions and stock levels.</p>
                    </div>
                </div>
            </div>
            <!-- Card 2: Orders -->
            <div class="col-12 col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3 text-success">{{$orders}}</div>
                        <h5 class="card-title fs-5 fw-bold mb-2">Orders</h5>
                        <p class="card-text">Total number of orders processed. Monitor your sales and keep track of order fulfillment efficiency.</p>
                    </div>
                </div>
            </div>
            <!-- Card 3: Customers -->
            <div class="col-12 col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3 text-danger">{{$customers}}</div>
                        <h5 class="card-title fs-5 fw-bold mb-2">Customers</h5>
                        <p class="card-text">Total number of unique customers served. Understand your customer base and enhance your engagement strategies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
