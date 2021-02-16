<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
    <h2>Megrendelés összesítése</h2>

    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-light table-striped text-center">
                <tr>
                    <th>Azonosító</th>
                    <th>Terméknév</th>
                    <th>Bruttó ár</th>
                    <th>Darabszám</th>
                    <th>Cikkszám</th>
                    <th>Érték</th>
                </tr>

                <?php

                    $vegosszeg = 0;

                    if(isset($_SESSION["cart"])){

                        foreach($_SESSION["cart"] as $product_id => $db){

                            $con = mysqli_connect(host,user,pwd,dbname);
                            mysqli_query($con, "SET NAMES utf8");

                            $sql = "SELECT * FROM termekek WHERE id='$product_id'";

                            $result = mysqli_query($con, $sql);

                            while($row = mysqli_fetch_array($result)){

                                $termeknev = $row["nev"];
                                $bruttoar = $row["ar"];
                                $cikkszam = $row["cikkszam"];
                                $ertek = $bruttoar*$db;

                                echo "
                                
                                    <tr>
                                        <td>".$product_id."</td>
                                        <td>".$termeknev."</td>
                                        <td>".number_format($bruttoar,0,".",".")." Ft</td>
                                        <td>".$db."</td>
                                        <td>".$cikkszam."</td>
                                        <td>".number_format($ertek,0,".",".")." Ft</td>
                                    </tr>
                                ";

                                $vegosszeg += $ertek;
                            }
                        }
                    }

                ?>
                <tr>
                    <td colspan="6" align="right">
                        <strong>Végösszeg: </strong><?php  echo number_format($vegosszeg,0,".",".");  ?> Ft
                    </td>
                </tr>
            </table>


            
            <?php

                //Rendelés adatainak eltárolsáa adatbázisban

                $error = "";
                $error2 = "";
                $success= "";

                if(isset($_POST["megrendel"]) && (isset($_POST["check"]) == 1)){

                    $nev = $_POST["nev"];
                    $email = $_POST["email"];
                    $telefon = $_POST["telefon"];
                    $szcim = $_POST["szcim"];
                    $szmod = $_POST["szmod"];
                    $fizmod = $_POST["fizmod"];
                    $user = $_SESSION["user"];

                    if(empty($nev) || empty($email) || empty($telefon) || empty($szcim)){

                        $error = "Rendelés leadásához minden mező kitöltése kötelező!";
                    }
                    else{

                        $con = mysqli_connect(host,user,pwd,dbname);
                        mysqli_query($con, "SET NAMES utf8");

                        $sql = "INSERT INTO vevok(nev,email,cim,telefon,pw,szcim,felh) VALUES('$nev', '$email', '$szcim', '$telefon', '', '$szcim', '$user')";

                        mysqli_query($con, $sql);

                        //Megkeresem a vevők táblába utoljára bekerült vevőm azonosítóját = rendelések tábla vevőidval
                        $utolsovevoid = "SELECT id FROM vevok ORDER BY id DESC LIMIT 1";

                        //Eltárolom az utolsó vevőid lekérdezés kimenetét egy változóba
                        $result = mysqli_query($con, $utolsovevoid);

                        //Tömbösítem a lekérdezésem kimenetét -> a vevőid-t el tudjam tárolni egy php változóba
                        $get_vevoid = mysqli_fetch_array($result);

                        //Eltárolom a végleges vevőid-t egy változóba, ami a tömbösített lekérdezésem 0. indexe
                        $kapottvevoid = $get_vevoid[0];

                        //A megfelelő adatokat feltöltöm a rendelések táblába
                        $sql2 = "INSERT INTO rendelesek(vevoid,szallitas,fizmod,datum,statusz,bosszeg) VALUES('$kapottvevoid','$szmod','$fizmod', NOW(), 'függőben', '$vegosszeg')";

                        mysqli_query($con, $sql2);

                        //Megkeresem az utolsó rendelésem azonosítóját
                        $utolsorendelesid = "SELECT id FROM rendelesek ORDER BY id DESC LIMIT 1";

                        //Eltárolom az utolsó rendelésid lekérdezés kimenetét egy változóba
                        $result2 = mysqli_query($con, $utolsorendelesid);

                         //Tömbösítem a lekérdezésem kimenetét -> a rendelésid-t el tudjam tárolni egy php változóba
                         $get_rendelesid = mysqli_fetch_array($result2);

                         //Eltárolom a végleges rendelésid-t egy változóba, ami a tömbösített lekérdezésem 0. indexe
                         $kapottrendelesid = $get_rendelesid[0];

                         foreach($_SESSION["cart"] as $product_id => $db){

                            //A megfelelő adatok feltöltöm a rend_term táblába
                            $sql3 = "INSERT INTO rend_term(rendelesid,termekid,db) VALUES('$kapottvevoid', '$product_id', '$db')";

                            mysqli_query($con, $sql3);

                            //Frissítsük a termék készletének darabszámáz a termékek táblában
                            $sql4 = "UPDATE termekek SET keszlet=keszlet-'$db' WHERE id='$product_id'";

                            mysqli_query($con, $sql4);
                         }

                         $success = "Rendelését sikeresen rögzítettük!";
                         //Rendelés leadása után ürítjük a kosár tartalmát
                         unset($_SESSION["cart"]);
                    }
                }
                else if(isset($_POST["megrendel"]) && (isset($_POST["check"]) == 0)){

                    $nev = $_POST["nev"];
                    $email = $_POST["email"];
                    $telefon = $_POST["telefon"];
                    $szcim = $_POST["szcim"];

                    $error2 = "Vásárlási feltételek elfogadása kötelező!";

                    if(empty($nev) || empty($email) || empty($telefon) || empty($szcim)){

                        $error = "Rendelés leadásához minden mező kitöltése kötelező!";
                    }

                }


            ?>


            <div class="container" >
                    <div class="row justify-content-center">
                        <form  action="" method="post" class="form-group text-center p-5 rounded" id="megrendeles_form">
                            
                            <h4 class="text-success mb-3"><?php  if(!empty($success)){echo $success;}    ?></h4>
                            <h4 class="text-danger mb-3"><?php  if(!empty($error)){echo $error;}    ?></h4>

                            <input type="text" name="nev" class="form-control mb-3" placeholder="Név...">
                            <input type="email" name="email" class="form-control mb-3" placeholder="E-mail cím...">
                            <input type="text" name="telefon" class="form-control mb-3" placeholder="Telefonszám...">
                            <input type="text" name="szcim" class="form-control mb-3" placeholder="Szállítási cím (irsz,város,utca,házszám)...">

                            <select name="szmod" class="form-control mb-3">
                                <option value="gls">GLS futár</option>
                                <option value="posta-utanvet">Postai utánvét</option>
                                <option value="szemelyes">Személyes átvétel</option>
                            </select>

                            <select name="fizmod" class="form-control mb-3">
                                <option value="obk">Online bankkártya</option>
                                <option value="utanvet">Utánvét</option>
                                <option value="atutalas">Átutalás</option>
                            </select>

                            <h4 class="text-danger mb-3"><?php  if(!empty($error2)){echo $error2;}    ?></h4>

                            <p> <a href="tajekoztato.php">Elfogadom a vásárlási feltételeket</a> </p>
                            <input type="checkbox" name="check" class="d-block m-auto">

                            <button type="submit" name="megrendel" class="mt-3">Rendelés leadása</button>

                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
