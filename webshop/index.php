<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
    <h1>Főoldal</h1>
    <?php echo "Üdvözöllek az oldalon ".$_SESSION["user"];  ?>
</div>



</body>
</html>