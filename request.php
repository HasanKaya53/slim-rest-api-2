<?php

//access close..

session_start();
if(!isset($_POST['type'])){
    echo "<script>window.location.href='index.php'</script>";
    exit;
}

if(!isset($_SESSION['token'])){
    echo "<script>window.location.href='index.php'</script>";
    exit;
}

if(!isset($_POST)){
    echo "<script>window.location.href='index.php'</script>";
    exit;
}
///asdas





if($_POST['type'] == 'list'){
    $ch = curl_init('http://localhost:8888/v1/services/transition/list');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['token']));

    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);


if(isset($response['error']) || sizeof($response) == 0 ){
        echo json_encode([]);
        exit;
}

    $table = "";


echo json_encode($response);



}


else if($_POST['type'] == 'add'){
    $ch = curl_init('http://localhost:8888/v1/services/transition/new');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ([
        'plaka' => $_POST['plaka'],
        'tarih' => date('Y-m-d H:i:s', strtotime($_POST['tarih']))
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['token']));

    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);

    echo json_encode($response);
}






?>