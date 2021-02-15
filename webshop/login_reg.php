<?php

    require "connection.php";

    session_start();

    //Alapállapot ami jelzi, hogy nem vagyunk bejelentkezve
    $_SESSION["logged"] = false;
    

    $error = "";
    $success = "";

    //Regisztráció
    if(isset($_POST["reg"])){

        $user = $_POST["user"];
        $pwd = $_POST["pwd"];
        $email = $_POST["email"];

        if(empty($user) || empty($pwd) || empty($email)){

            $error = "Minden mező kitöltése kötelező!";
        }
        else{

            $con = mysqli_connect(host,user,pwd,dbname);
            mysqli_query($con, "SET NAMES utf8");

            $user_sql = "SELECT user FROM adatok WHERE user='$user'";

            $user_exist = mysqli_query($con, $user_sql);

            if(mysqli_num_rows($user_exist) >= 1){

                $error = "Létező felhasználónév!";
            }
            else if(strlen($pwd) < 6){

                $error = "A jelszó hossza min. 6 karakter legyen!";

            }
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

                $error = "Nem megfelelő email formátum!";
            }
            else if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/',$pwd)){

                $error = "A jelszó nem felel meg a követelményeknek!";

            }
            else{

            $sql = "INSERT INTO adatok(user,email,pwd) VALUES('$user', '$email', sha1('$pwd'))";

            mysqli_query($con, $sql);

            $success = "Sikeres regisztráció!";
        }

      }
    }


    //Bejelentkezés
    if(isset($_POST["login"])){
        
        $user = $_POST["user"];
        $pwd = $_POST["pwd"];

        if(empty($user) || empty($pwd)){

            $error = "Minden mező kitöltése kötelező!";
        }else{

            $con = mysqli_connect(host,user,pwd,dbname);
            mysqli_query($con, "SET NAMES utf8");

            $sql = "SELECT user,pwd FROM adatok WHERE user='$user' AND pwd=sha1('$pwd')";

            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0){

                //Alapállapot megváltoztatása true-ra -> sikeres a bejelentkezés
                $_SESSION["logged"] = true;
                //Átkonvertáljuk a $user változó értékét munkamenet(session) változóra
                $_SESSION["user"] = $user;
                header("Location: index.php");
                
            }
            else{

                 $error = "Hibás belépési adatok!";
            }
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
<title>Webshop Regisztárció - bejelentkezés</title>
</head>
<body>

    <div class="container">

        <div class="row justify-content-center">

            <form action="" method="post" class="form-group text-center p-5 rounded"> 
                
                <span class="text-danger d-block mb-3"><?php  if(!empty($error)){echo $error;}  ?></span>
                <span class="text-success d-block mb-3"><?php  if(!empty($success)){echo $success;}  ?></span>

                <label for="">Felhasználónév</label>
                <input type="text" name="user" class="form-control mb-3">

                <label for="">E-mail cím</label>
                <input type="text" name="email" class="form-control mb-3">

                <label for="">Jelszó</label>
                <input type="password" name="pwd" class="form-control mb-3">

                <button type="submit" name="login" class="btn btn-success">Bejelentkezés</button>
                <button type="submit" name="reg" class="btn btn-primary">Regisztráció</button>

                <div class="mt-5 text-left">
                    <ul>
                        A jelszónak tartalmaznia kell legalább egy:
                        <li>a-z (kisbetű)</li>
                        <li>A-Z (nagybetű)</li>
                        <li>0-9 (számot)</li>
                        <li>@#&-_$%+=?! (speciális karaktert)</li>
                    </ul>
                </div>

            </form>

        </div>

    </div>

</body>
</html>