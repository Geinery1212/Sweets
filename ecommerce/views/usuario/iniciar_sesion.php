<div class="background"></div>
<div class="contenedor__todo">
    <div class="caja__trasera">
        <div class="caja__trasera-login">
            <h3>¿Ya tienes una cuenta?</h3>
            <p>Inicia sesión para entrar en la página</p>
            <button id="btn__iniciar-sesion">Iniciar Sesión</button>
        </div>
        <div class="caja__trasera-register">
            <h3>¿Aún no tienes una cuenta?</h3>
            <p>Regístrate para que puedas iniciar sesión</p>
            <button id="btn__registrarse">Regístrarse</button>
        </div>
    </div>

    <!--Formulario de Login y registro-->
    <div class="contenedor__login-register">
        <!--Login-->
        <form action="<?= base_url ?>Usuario/loguear" method="POST" class="formulario__login">
            <h2>Iniciar Sesión</h2>
            <input type="text" name="email" placeholder="Correo Electronico">
            <input type="password" name="password" placeholder="Contraseña">
            <button type="submit">Entrar</button>
        </form>

        <!--Register-->
        <form action="<?= base_url ?>Usuario/registrar" method="POST" class="formulario__register">
            <h2>Regístrarse</h2>
            <input type="text" name="nombre" placeholder="Nombre completo">
            <input type="text" name="email" placeholder="Correo Electronico">
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="password" placeholder="Contraseña">
            <button type="submit">Regístrarse</button>
        </form>
    </div>    
</div>