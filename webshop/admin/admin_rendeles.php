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

<div class="container-fluid">
    <h2 class="text-center mt-5 mb-5">Rendelések megjelenítése</h2>

    <div class="row justify-content-center">
        <table class="table text-center table-light table-striped">
            <tr>
                <th>Azonosító</th>
                <th>Vevő neve</th>
                <th>Vevő e-mail címe</th>
                <th>Vevő címe</th>
                <th>Szállítási mód</th>
                <th>Fizetési mód</th>
                <th>Dátum</th>
                <th>Státusz</th>
                <th>Végösszeg(bruttó)</th>
            </tr>

            <?php 

                $con = mysqli_connect(host,user,pwd,dbname);
                mysqli_query($con, "SET NAMES utf8");

                $sql = "SELECT vevok.id,vevok.nev,vevok.email,vevok.cim,rendelesek.szallitas,rendelesek.fizmod,rendelesek.datum,rendelesek.statusz,rendelesek.bosszeg FROM vevok INNER JOIN rendelesek ON vevok.id=rendelesek.vevoid ORDER BY id ASC";

                $result = mysqli_query($con, $sql);

                while($row = mysqli_fetch_array($result)){

                    ?>

                        <tr>
                            <td><?php  echo $row["id"];  ?></td>
                            <td><?php echo $row["nev"]; ?></td>
                            <td><?php echo $row["email"];  ?></td>
                            <td><?php echo $row["cim"];   ?></td>
                            <td><?php echo $row["szallitas"];   ?></td>
                            <td><?php echo $row["fizmod"];   ?></td>
                            <td><?php echo $row["datum"];   ?></td>
                            <td><?php echo $row["statusz"];   ?></td>
                            <td><?php echo number_format($row["bosszeg"],0,".",".");?> Ft</td>
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