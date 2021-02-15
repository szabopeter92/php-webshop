<?php  require "../connection.php";    ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
<title>Admin - Termékek megjelenítése</title>
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <h2 class="text-center">Termékek</h2>

        <table class="table table-light table-striped mt-5 text-center">

            <tr>
                <th>Azonosító</th>
                <th>Termékkép</th>
                <th>Terméknév</th>
                <th>Termékár (bruttó)</th>
                <th>Cikkszám</th>
                <th>Készlet</th>
                <th>Műveletek</th>
            </tr>

            <?php

                $con = mysqli_connect(host,user,pwd,dbname);
                mysqli_query($con, "SET NAMES utf8");

                $sql = "SELECT id,kep,nev,ar,cikkszam,keszlet FROM termekek ORDER BY id ASC";

                $result = mysqli_query($con, $sql);

                while($row = mysqli_fetch_array($result)){

                    ?>

                        <tr>
                            <td><?php  echo $row["id"];   ?></td>
                            <td> <img src="../<?php  echo $row["kep"]; ?>" class="admin_kep" alt=""> </td>
                            <td><?php  echo $row["nev"];  ?></td>
                            <td><?php echo number_format($row["ar"],0,".",".");  ?> Ft</td>
                            <td><?php  echo $row["cikkszam"]; ?></td>
                            <td><?php  echo $row["keszlet"]; ?></td>
                            <td>
                                <a href="admin_modosit.php?id=<?php echo $row["id"];?>"> <i class="fas fa-pen"></i> </a>
                                <a href="admin_torol.php?id=<?php echo $row["id"];?>"> <i class="fas fa-trash"></i> </a>
                            </td>
                        </tr>  


                    <?php
                }


            ?>

        </table>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>