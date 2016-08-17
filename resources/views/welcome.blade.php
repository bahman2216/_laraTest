<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">


</head>
<body>
<div class="container">
    {!! Form::open(['id'=>'product-form','class'=>'col-md-6 col-md-push-4 form-horizontal'])!!}

    <div class='form-group'>
        {!! Form::label('product', 'Product name:',['class'=>'col-xs-12 col-md-3']) !!}
        <div class='col-xs-12 col-md-6'>
            {!! Form::text('product', null, ['class' => 'form-control', 'id' => 'product'])!!}
        </div>
    </div>

    <div class='form-group'>
        {!! Form::label('quantity', 'Quantity in stock',['class'=>'col-xs-12 col-md-3']) !!}
        <div class='col-xs-12 col-md-6'>
            {!! Form::text('quantity', null, ['class' => 'form-control', 'id' => 'quantity'])!!}
        </div>
    </div>

    <div class='form-group'>
        {!! Form::label('price', 'Price per item',['class'=>'col-xs-12 col-md-3']) !!}
        <div class='col-xs-12 col-md-6'>
            {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'price'])!!}
        </div>
    </div>

    <button type="button" onclick="submitForm()" class="btn btn-default">Submit</button>

    {!! Form::close() !!}

</div>

<div class="container">
        <div class="row">
            <div class="col-md-2">
                Product name
            </div>
            <div class="col-md-2">
                Quantity in stock
            </div>
            <div class="col-md-2">
                Price per item
            </div>
            <div class="col-md-2">
                Datetime submitted
            </div>
            <div class="col-md-2">
                Total value number
            </div>
        </div>

        <div class="row" id="newData">

        </div>

</div>
</body>

<script language="JavaScript">
    function submitForm() {
        var token = document.getElementsByName('_token')[0].value;

        var xmlhttp = window.XMLHttpRequest ?
                new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                alert(xmlhttp.responseText);
        }

        var product = document.getElementById('product').value;
        var quantity = document.getElementById('quantity').value;
        var price = document.getElementById('price').value;

        xmlhttp.open("POST", "/productPost", true);

        xmlhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("product=" + product + "&quantity=" + quantity + "&price=" + price);

        loadData(function (response) {
            res = JSON.parse(response);

            var index = res[Object.keys(res)[Object.keys(res).length - 1]];
            var createdDate = index.date;

            totalValue = price * quantity;
            var newData = '<div class="row"><div class="col-md-2">' + product + '</div>' + '<div class="col-md-2">' + quantity + '</div>' + '<div class="col-md-2">' + price + '</div>' + '<div class="col-md-2">' + createdDate + '</div>' + '<div class="col-md-2">' + totalValue + '</div></div>';

            var container = document.getElementById('newData').innerHTML;

            document.getElementById('newData').innerHTML = newData + container;

        });
    }

    function loadData(callback) {

        var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
        xobj.open('GET', '/product.json', true);
        xobj.onreadystatechange = function () {
            if (xobj.readyState == 4 && xobj.status == "200") {

                callback(xobj.responseText);

            }
        }
        xobj.send(null);

    }
</script>
</html>
