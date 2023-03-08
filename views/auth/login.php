<div class="ui hidden  divider"></div>
<div class="ui hidden  divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">
    <h2 class="ui header">Inicio de Sesion</h2>

    <div class="ui hidden  divider"></div>

    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <div class="ui inverted  placeholder segment">
        <div class="ui two column very relaxed stackable  grid">
            <div class="column">
                <form class="ui inverted form" class="ui iverted form" method="POST" action="/">
                    <div class="field">
                        <label>Usuario</label>
                        <div class="ui left icon input">
                            <input type="email" id="email" placeholder="Tu Email" name="email">
                            <i class="user icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <label>Contraseña</label>
                        <div class="ui left icon input">
                            <input type="password" id="password" placeholder="Tu Password" name="password">
                            <i class="lock icon"></i>
                        </div>
                    </div>


                    <input type="submit" class="ui blue submit button" value="Iniciar Sesión">

                </form>
            </div>
            <!-- <div class="ui hidden divider"></div> -->

            <div class="  middle  aligned column">

                <h3 class="ui center inverted aligned header">¿Aún no tienes una cuenta?</h3>
                <a class="ui big blue  button" href="/crear-cuenta"><i class="signup icon"></i>Crear una</a>
                <div class="ui hidden  divider"></div>
                <a class="ui center inverted red button" href="/olvide">¿Olvidaste tu password?</a>


            </div>
        </div>

        <div id="div_h" class="ui inverted  vertical divider" style='display:none;'>Ó</div>


    </div>
</div>