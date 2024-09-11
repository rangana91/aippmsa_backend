<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order View</title>
</head>
<body>

<h2>Order Details</h2>

<table border="1">
    <tr>
        <th>Customer Name</th>
        <th>Item</th>
        <th>Price</th>
        <th>Qty</th>
    </tr>
    <tr>
        <td>{{$customerName}}</td>
        <td>{{$itemName}}</td>
        <td>{{$itemPrice}}</td>
        <td>{{$qty}}</td>
    </tr>
</table>

</body>
</html>