<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página sistema facturacion">

    <!--framework semantic-->
    <link rel="preload" href="css/semantic.min.css" as="style">
    <link rel="stylesheet" href="css/semantic.min.css">
    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
    <script src="css/semantic.min.js"></script>
    <!--fin-->



    <!--Fuentes-->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto"  crossorigin="crossorigin" as="font">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!--fin-->  
    <title>Control de Acceso</title>

    <style type="text/css">

        body {
          background-color: #eaeaf4;
        }
        body > .grid {
        height: 100%;
        }
        .image {
          margin-top: -100px;
        }
        .column {
          max-width: 450px;
        }

    </style>
    
</head>


<body>


   <div class="ui middle aligned center aligned grid">
      <div class="column">
        <h2 class="ui  image header">
          <img src="img/inicio.png" class="image">
          <div class="content">
          Facturacion 
          </div>
        </h2>
        <form class="ui large form" name="form" method="post" action="?opcion=logAcceso">
          <div class="ui stacked segment">
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" name="usuario" placeholder="E-mail address">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="pass" placeholder="Password">
              </div>
            </div>
            <input class="ui  fluid  large red submit button" type="submit" name="" value="Acceder">
            
          </div>

          <!-- mensaje de error  -->
          <?php if(isset($_SESSION['msn'])){ ?>

            <div class="ui info message">

              <i class="close icon"></i>
              <div class="header">OPSs! </div>
              <p><?php print $_SESSION['msn'];  unset($_SESSION['msn']); ?></p>

            </div>

            <?php } ?>
            <!-- fin -->

        </form>

        <div class="ui message">
        Develop by ING.Royman Rodriguez<a href="#"></a>
        </div>
      </div>
   </div>
   

</body>
<script>

  $('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  });
</script>
 
</html>