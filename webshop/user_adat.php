<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
    <h2>Üdvözöllek, <?php echo $_SESSION["user"];  ?></h2>
    <h4>Tekintsd meg a rendeléseidet:</h4>

    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-light table-striped text-center mt-5">
                <tr>
                    <th>Terméknév</th>
                    <th>Termékár</th>
                    <th>Darabszám</th>
                    <th>Érték</th>
                    <th>Dátum</th>
                    <th>Termékkép</th>
                </tr>

                <?php

                    $nev = $_SESSION["user"];
                    $con = mysqli_connect(host,user,pwd,dbname);
                    mysqli_query($con, "SET NAMES utf8");

                    $sql = "SELECT termekek.nev,termekek.ar,rend_term.db,rendelesek.datum,termekek.kep FROM vevok INNER JOIN rendelesek ON vevok.id=rendelesek.vevoid INNER JOIN rend_term ON rendelesek.id=rend_term.rendelesid INNER JOIN termekek ON rend_term.termekid=termekek.id WHERE vevok.felh LIKE '$nev'";

                    $result = mysqli_query($con, $sql);

                    while($row = mysqli_fetch_array($result)){

                        $termeknev = $row["nev"];
                        $termekar = $row["ar"];
                        $db = $row["db"];
                        $ertek = $termar*$db;
                        $datum = $row["datum"];
                        $termekkep = $row["kep"];

                        echo "
                            <tr>
                                <td>".$termeknev."</td>
                                <td>".number_format($termekar,0,".",".")." Ft</td>
                                <td>".$db."</td>
                                <td>".number_format($ertek,0,".",".")." Ft</td>
                                <td>".$datum."</td>
                                <td> <img src='$termekkep' alt='' title='' class='admin_kep' /> </td>
                            </tr>
                        
                        ";
                    }

                ?>
            </table>
        </div>
    </div>
</div>



</body>
</html>