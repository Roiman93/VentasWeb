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

    <style>
    /*  mantiene fija la cabecera de la tabla  */
    thead.sticky {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 1;
    }
    </style>

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


<script>
function hide_o_show() {

    $('.ui.sidebar').sidebar('toggle');

}

function myFunction(x) {
    if (x.matches) { // Si la consulta de medios coincide
        // document.body.style.backgroundColor = "yellow";
        $('#menu_tablet').hide();
        $('#menu_mobil').show();
        $('#div_h').hide();

    } else {

        $('#menu_tablet').show();
        $('#div_h').show();
        $('#menu_mobil').hide();


        // document.body.style.backgroundColor = "pink";
    }
}
// ejecutar funcion cuando se cargue la pagina por completo
window.addEventListener("load", function() {

    var x = window.matchMedia("(max-width: 768px)")
    myFunction(x) // Llamar a la función de escucha en tiempo de ejecución
    x.addListener(myFunction) // Adjunte la función de escucha en los cambios de estado
    $('.ui.button').popup();



});
</script>

<script type="text/javascript" src="build/js/Sweetalert.min.js"></script>

</html>