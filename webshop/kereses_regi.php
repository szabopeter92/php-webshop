<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
    <form action="" method="post" id="kereses_form">
        <h2>Írja be a termék nevét!</h2>
        <input type="text" name="termeknev" id="">
        <button type="submit" name="kereses">Keresés</button>
    </form>

    <?php

        if(isset($_POST["kereses"])){

            $termeknev = $_POST["termeknev"];

            $con = mysqli_connect(host,user,pwd,dbname);
            mysqli_query($con, "SET NAMES utf8");

            $sql = "SELECT * FROM termekek WHERE nev LIKE '%$termeknev%'";

            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0){

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
                                <a href='kosarmuvelet.php?id=".$id."&action=add'>Kosárba</a>
                            </div>
        
        
                        
                        </div>
                    
                    ";

                }
            }
            else{

                echo "<h3>Nincs ilyen termék az adatbázisban!</h3>";
            }
        }

    ?>
</div>




</body>
</html>