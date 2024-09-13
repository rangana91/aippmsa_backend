$(document).ready(function(){
    const categoryTable = $('#customersTable').DataTable( {
        serverSide: true,
        ajax: {
            url: '/customers-data',
            // dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'address' },
        ]
    } );
})