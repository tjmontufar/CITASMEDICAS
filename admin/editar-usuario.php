<link rel="stylesheet" href="../css/modal-usuario.css">
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="php/edit-user.php" method="POST">
            <div class="title">Actualizar datos del Usuario</div>
            <div class="form-group">
                <label for="idusuario">ID</label>
                <input id="idusuario" type="text" name="idusuario" autocomplete="off" value="" readonly="true">

                <label for="dni">DNI</label>
                <input id="dni" type="text" name="dni" autocomplete="off" value="">

                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" name="nombre" autocomplete="off" value="">

                <label for="apellido">Apellido</label>
                <input id="apellido" type="text" name="apellido" autocomplete="off" value="">

                <label for="correo">Correo</label>
                <input id="correo" type="email" name="correo" autocomplete="off" value="">

                <label for="usuario">Nombre de Usuario</label>
                <input id="usuario" type="text" name="usuario" autocomplete="off" value="">
            </div>
            <button type="submit" class="modificar">Modificar</button>
        </form>
    </div>
</div>