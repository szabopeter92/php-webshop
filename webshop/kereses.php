<?php  require "header.php";  ?>

<div id="top">
    <?php  require "menu.php";  ?>
</div>

<div id="left">
    <?php  require "kategoria.php";    ?>
</div>


<div id="right">
   <form action="" method="post" id="kereses_form">
        <h2>Keresés</h2>

        <input type="text" name="search" id="search" placeholder="Írja be a termék nevét...">
   </form>

   <div class="result"></div>
</div>


<script>

    $(function(){

        $("#search").keyup(function(){

            var text = $("#search").val();

            if(text != ""){

                $.ajax({

                    method: "post",
                    url: "fetch.php",
                    dataType: "text",
                    data: {text:text},
                    success: function(data){

                        $(".result").html(data);
                    }
                })
            }
            else{

                $(".result").html("");
            }
        })
    })

</script>

</body>
</html>