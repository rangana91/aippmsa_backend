$(document).ready(function(){

    const categoryTable = $('#ordersTable').DataTable( {
        serverSide: true,
        ajax: {
            url: '/order-data',
        },
        columns: [
            { data: 'customer_name' },
            { data: 'item' },
            { data: 'qty' },
            { data: 'created_at' },
        ]
    } );
})