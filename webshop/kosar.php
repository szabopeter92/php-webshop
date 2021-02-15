<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
    <h2>Kosár tartalma</h2>

    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-striped table-light text-center">
                <tr>
                    <th>Azonosító</th>
                    <th>Terméknév</th>
                    <th>Bruttó ár</th>
                    <th>Darabszám</th>
                    <th>Cikkszám</th>
                    <th>Érték</th>
                    <th><a href="kosarmuvelet.php?action=empty"> <i class="fas fa-trash-alt"></i> </a></th>
                </tr>

                <?php

                    $vegosszeg = 0;

                    //Kosár session létrehozása, ha egy termék belekerül a kosárba
                    if(isset($_SESSION["cart"])){
                        
                        //Bejárom egy foreach ciklussal a kosár sessionömet (tömb) azért, hogy a kosárban lévő termék azonosítóját és darabsázmát ki tudjam nyerni és változóként meg tudjam őket jeleníteni
                        foreach($_SESSION["cart"] as $product_id => $db){
                            
                            $con = mysqli_connect(host,user,pwd,dbname);
                            mysqli_query($con, "SET NAMES utf8");

                            $sql = "SELECT * FROM termekek WHERE id='$product_id'";

                            $result = mysqli_query($con, $sql);

                            while($row = mysqli_fetch_array($result)){

                                $termeknev = $row["nev"];
                                $cikkszam = $row["cikkszam"];
                                $bruttoar = $row["ar"];
                                $ertek = $bruttoar * $db;

                                echo "

                                <tr>
                                    <td>".$product_id."</td>
                                    <td>".$termeknev."</td>
                                    <td>".number_format($bruttoar,0,".",".")." Ft</td>
                                    <td>".$db."</td>
                                    <td>".$cikkszam."</td>
                                    <td>".number_format($ertek,0,".",".")." Ft</td>
                                    <td>
                                        <a href='kosarmuvelet.php?id=".$product_id."&action=add'>
                                            <i class='fas fa-plus'></i>
                                        </a>
                                        <a href='kosarmuvelet.php?id=".$product_id."&action=remove'>
                                            <i class='fas fa-minus'></i>
                                        </a>
                                    </td>
                                </tr>
                                
                                ";

                                $vegosszeg += $ertek;
                            }

                        }
                    }
                    else{

                        echo "<h2 class='text-center'>A kosár üres!</h2>";
                    }
                ?>

                <tr>
                    <td align="right" colspan="7">
                        <strong>Végösszeg: </strong><?php echo number_format($vegosszeg,0,".",".");  ?> Ft
                    </td>
                </tr>

            </table>

            <?php

                if($_SESSION["logged"]){

            ?>
            <a href="megrendeles.php" id="megrendel">Megrendelem</a>

            <?php
                }
                else{
            ?>

            <a href="login_reg.php">Rendelés leadásához kérjük jelentkezzen be!</a>

            <?php
                }
            ?>


            <?php
           /*
                if(empty($_SESSION["cart"])){

                    echo '<a href="#" id="megrendel">Megrendelem</a>';
                }
                else{

                    echo '<a href="megrendeles.php" id="megrendel">Megrendelem</a>';
                }
            */
            ?>
        </div>
    </div>
</div>



</body>
</html>