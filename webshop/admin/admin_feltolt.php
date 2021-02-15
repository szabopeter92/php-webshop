<?php

    require "../connection.php";

    $error="";
    $success="";

    if(isset($_POST["upload"])){

        $target = "../img/".basename($_FILES["file"]["name"]);

        $termekkep = $_FILES["file"]["name"];
        $termeknev = $_POST["termeknev"];
        $termekar = $_POST["termekar"];
        $kategoria = $_POST["kategoria"];
        $cikkszam = $_POST["cikkszam"];
        $keszlet = $_POST["keszlet"];
        $trovid = $_POST["trovid"];
        $thosszu = $_POST["thosszu"];


        if(empty($termekkep) || empty($termeknev) || empty($termekar) || empty($kategoria) || empty($cikkszam) || empty($keszlet) || empty($trovid) || empty($thosszu)){

            $error = "Minden mező kitöltése kötelező!";
        }
        else{

            $con = mysqli_connect(host,user,pwd,dbname);
            mysqli_query($con, "SET NAMES utf8");

            $sql = "INSERT INTO termekek(kategoria,nev,cikkszam,ar,rleiras,hleiras,kep,keszlet,aktiv) VALUES('$kategoria', '$termeknev', '$cikkszam', '$termekar', '$trovid', '$thosszu', 'img/$termekkep', '$keszlet', '1')";

            mysqli_query($con,$sql);

            move_uploaded_file($_FILES["file"]["tmp_name"], $target);

            $success = "Sikeres feltöltés!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<title>Admin - Termék feltöltés</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="admin_feltolt.php">Termék feltöltése</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_rendeles.php">Rendelések</a>
      </li>
    </ul>
  </div>
</nav>

    <div class="container">
        <div class="row justify-content-center">
            <form enctype="multipart/form-data" action="" class="form-group text-center p-5 rounded" method="post">

                <span class="text-danger mb-3 d-block">
                    <?php  if(!empty($error)){echo $error;}   ?>
                </span>

                <span class="text-success mb-3 d-block">
                    <?php  if(!empty($success)){echo $success;}   ?>
                </span>


                <h2>Termék feltöltése</h2>

                <label for="">Termékkép</label>
                <input type="file" name="file" class="form-control mb-3">

                <label for="">Terméknév</label>
                <input type="text" name="termeknev" class="form-control mb-3">

                <label for="">Termékár</label>
                <input type="text" name="termekar" class="form-control mb-3">

                <label for="">Kategória</label>
                <select name="kategoria" class="form-control mb-3">
                    <option value="2">Hp Notebook</option>
                    <option value="3">Dell Notebook</option>
                    <option value="4">Asus Notebook</option>
                    <option value="5">Lenovo Notebook</option>
                    <option value="6">Apple Notebook</option>
                    <option value="7">Toshiba Notebook</option>
                </select>

                <label for="">Cikkszám</label>
                <input type="text" name="cikkszam" class="form-control mb-3">

                <label for="">Készlet</label>
                <input type="text" name="keszlet" class="form-control mb-3">

                <label for="">Termék rövid leírása</label>
                <input type="text" name="trovid" class="form-control mb-3">

                <label for="">Termék részletes leírása</label>
                <textarea name="thosszu"  cols="50" rows="10" class="form-control mb-3"></textarea>

                <button class="btn btn-primary" name="upload" type="submit">Termék feltöltése</button>


            
            </form>
        </div> 
    </div>

</body>
</html>