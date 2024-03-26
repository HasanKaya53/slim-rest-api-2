<?php

session_start();

if(isset($_SESSION['token'])){
    echo "<script>window.location.href='list.php'</script>";
}

if ( isset($_POST['name']) && isset($_POST['pass'])) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];


    //clear
    $name = htmlspecialchars(strip_tags($name));
    $pass = htmlspecialchars(strip_tags($pass));


    $_POST = [];


    //POST..
    $data = [
        'username' => $name,
        'password' => $pass
    ];

    //request to api
    $ch = curl_init('http://localhost:8888/v1/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if(isset($response['status']) && $response['status'] == true){

        $_SESSION['token'] = $response['token'];
        echo "<script>window.location.href='list.php'</script>";
        

    }else{
        echo "
        <div class='alert alert-danger' role='alert'>
            Kullanıcı adı veya şifre hatalı
            
        </div>
        
        ";
    }




}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- style.css  -->
    <link rel="stylesheet" href="style.css">
    <title></title>
</head>
<body>

<div class="container">

    <form action="index.php" method="post">


        <!--<div class="form-group">
            <label for="name">Plaka</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="dob">Giriş Tarihi :</label>
            <input type="datetime-local" class="form-control" name="dob">
        </div>-->


        <div class="form-group">
            <label for="name">Kullanıcı Adı</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="dob">Şifre</label>
            <input type="text" class="form-control" name="pass" id="pass">
        </div>


        <button type="submit" class="btn" style="float:right">Kaydet</button>
    </form>
</div>






</body>
</html>