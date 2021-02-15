<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
   <div id="sort">
        <a href="?sort=price_asc"> <i class="fas fa-sort-amount-up-alt"></i> </a>
        <a href="?sort=price_desc"> <i class="fas fa-sort-amount-down"></i> </a>
        <a href="?sort=newest"> <i class="far fa-calendar"></i> </a>
        <a href="?sort=best"> <i class="fas fa-star"></i> </a>
   </div>

    <?php

        $con = mysqli_connect(host,user,pwd,dbname);
        mysqli_query($con, "SET NAMES utf8");

        //Termékek megjelenítse kategória szerint --

        //Ha van beállítva az url-be katid (kategória id)
        if(isset($_GET["katid"])){

            $katid = $_GET["katid"];

            //Csak azokat a termékeket jelenítsük meg, melyeknek az kategóriája megegyik az urlben szereplő katid-val
            $sql = "SELECT * FROM termekek WHERE kategoria='$katid'";
        }
        //Ha az urlben szerepel a sor -- rendezzük a termékeket valahogyan
        else if(isset($_GET["sort"])){

            $sort = $_GET["sort"];

            switch($sort){

                case "price_asc":
                    $sql = "SELECT * FROM termekek ORDER BY ar ASC";
                break;

                case "price_desc":
                    $sql = "SELECT * FROM termekek ORDER BY ar DESC";
                break;

                case "newest":
                    $sql = "SELECT * FROM termekek ORDER BY id DESC";
                break;

                case "best":
                    $sql = "SELECT * FROM termekek INNER JOIN rend_term ON termekek.id=rend_term.termekid GROUP BY termekek.nev ORDER BY SUM(db) DESC";
                break;



                /*
                default:
                    $sql = "SELECT * FROM termekek ORDER BY id DESC";
                break;
                */
            }
        }
         //Ha nincs beállítva katid (nem kategória alapján jelenítek meg terméket) és nincs beállítva sort (nem rendeztem a termékeket)
        else{

            $sql = "SELECT * FROM termekek ORDER BY id DESC";
        }

        $result = mysqli_query($con, $sql);

        while($row = mysqli_fetch_array($result)){

            $id = $row["id"];
            $termeknev = $row["nev"];
            $termekar = $row["ar"];
            $termekkep = $row["kep"];
            $keszlet = $row["keszlet"];

            echo "

                <div class='termekdoboz'>

                    <div class='termekkep'>
                        <a href='termek.php?termekid=".$id."'>
                            <img src='$termekkep' alt='' title='' />
                        </a>
                    </div>

                    <div class='termeknev'>
                        ".$termeknev."
                    </div>

                    <div class='keszlet'>
                        Készlet: ".$keszlet." db
                    </div>

                    <div class='termekar'>
                        ".number_format($termekar,0,".",".")." Ft
                    </div>

                    <div class='termekkosar'>
                        <a href='kosarmuvelet.php?id=".$id."&action=add'> <i class='fas fa-shopping-cart'></i> Kosárba</a>
                    </div>


                
                </div>
            
            ";
        }

    ?>


</div>



</body>
</html>