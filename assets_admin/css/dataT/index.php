
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.4.0.min.js"></script>
    <script src="assets/js/mdb.min.js"></script>
    <script src="assets/js/jquery-latest.js"></script>
    <script type="text/javascript">
        var refreshid = setInterval(function(){
            $('#responsecontainer').load('data.php');
        },1000);
    </Script>
</head>
<body>
    <div class="container">
        <h3 class="testing">testing</h3>

    </div>

    <div class="container-fluid" id="responsecontainer" style="width:100%"> </div>
</body>
</html>