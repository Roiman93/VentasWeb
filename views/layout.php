<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página sistema facturacion">

    <!--framework semantic-->
    <link rel="preload" href="build/css/Semantic/semantic.min.css" as="style">
    <link rel="stylesheet" href="build/css/Semantic/semantic.min.css">

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="build/css/Semantic/semantic.min.js"></script>
    <!--fin-->

    <!--  Hojas de estylo-->
    <!-- <link rel="preload" href="css/styl.css" as="style">
        <link rel="stylesheet" href="css/styl.css"> -->
    <!--fin-->

    <!--Fuentes-->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap"
        crossorigin="crossorigin" as="font">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap"
        rel="stylesheet">
    <!--fin-->

    <title>Sistema Ventas</title>

</head>

<body>


    <?php if (isset($_SESSION["admin"])) {
        include_once __DIR__ . "/templates/menu/menu_admin.php";
    } ?>

    <!-- Site content !-->
    <div class="pusher">
        <?php echo $contenido; ?>

    </div>

    <script>
    function hide_o_show() {

        $('.ui.sidebar').sidebar('toggle');

    }
    </script>
    <script type="text/javascript" src="build/js/Sweetalert.min.js"></script>

    <?php echo $script ?? ""; ?>

</body>

</html>