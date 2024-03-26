<?php
session_start();

if(!isset($_SESSION['token'])){
    echo "<script>window.location.href='index.php'</script>";
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title></title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>

<div class="container">


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Yeni Kayıt Ekle
    </button>

    <a href="logout.php" class="btn btn-danger" style="float:right">Çıkış Yap</a>


    <table class="table">
        <thead>
        <tr>
            <th scope="col">Plaka</th>
            <th scope="col">Ücret</th>
            <th scope="col">Tarih</th>
        </tr>
        </thead>
        <tbody id="listBody">

        </tbody>
    </table>


</div>

</body>
</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ekle</h5>

            </div>
            <div class="modal-body">
                <form action="add.php" method="post">
                    <div class="form-group">
                        <label for="name">Plaka</label>
                        <input type="text" class="form-control" name="plaka" id="plaka">
                    </div>
                    <div class="form-group">
                        <label for="dob">Giriş Tarihi :</label>
                        <input type="datetime-local" class="form-control" name="tarih" id="tarih">
                    </div>

                    <div class="error">

                    </div>

                    <!--tarih.. -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {

        function list(){
            $.ajax({
                url: 'request.php',
                type: 'POST',
                data: {
                    type: 'list'
                },
                success: function (response) {
                    console.log(response);
                    $('#listBody').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        list();


        $(document).on('click','#save',function(e){
            console.log($('#tarih').val());

            //$('#tarih').val() tarih mi ?
            if($('#tarih').val() == ''){
                $('.error').html('Tarih boş olamaz');
                return;
            }

           $.ajax({
               url: 'request.php',
               type: 'POST',
               data: {
                     type: 'add',
                   plaka: $('#plaka').val(),
                   tarih: $('#tarih').val()
               },
               success: function (response) {
                        console.log(response);
                   //$('#exampleModal').modal('hide');
                   $('.error').html('');

                   let data = JSON.parse(response);
                   console.log(data.status);

                     if(data.status == false){
                          $('.error').html(data.error);
                     }
                     list();
               }
           });
        });





    });
</script>






