<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema facturacion">
    <!-- jQqueri -->
    <script src="build/js/jquery_3_1_1.js"></script>
    <!--framework semantic-->    
    <link rel="stylesheet" href="build/css/Semantic/semantic.min.css">
    <script src="  build/css/Semantic/semantic.min.js"></script>
    <!--fin-->
    <title>Sistema Ventas</title>

    <!--  Hojas de estylo-->
    <link rel="stylesheet" href="build/css/app.css">
    <!--fin-->

</head>

<body>

    <?php if (isset($_SESSION["admin"])) {
    	include_once __DIR__ . "/templates/menu/menu_admin.php";
    } ?>


    <div class="pusher">
        <div class="article">
            <?php echo $contenido; ?>
        </div>
    </div>

    <?php echo $script ?? ""; ?>

</body>

<script type="text/javascript" src="build/js/config.js"></script>
<script type="text/javascript" src="build/js/Sweetalert.min.js"></script>

</html>