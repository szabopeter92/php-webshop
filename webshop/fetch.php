<?php

    require "connection.php";

    $con = mysqli_connect(host,user,pwd,dbname);
    mysqli_query($con, "SET NAMES utf8");

    $text = mysqli_real_escape_string($con, $_POST["text"]);

    $sql = "SELECT * FROM termekek WHERE nev LIKE '%$text%'";

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
                        <a href='kosarmuvelet.php?id=".$id."&action=add'><i class='fas fa-shopping-cart'></i> Kosárba</a>
                    </div>


                
                </div>
            
            ";
        }
    }
    else{

        echo "<h3>Nincs ilyen termék az adatbázisban!</h3>";
    }