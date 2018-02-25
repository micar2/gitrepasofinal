<?php $this->layout('layouts/layout') ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h2>Registro</h2>
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
        <section>
            <label>Nombre:</label> <input class="form-control" type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : "" ?>">
            <br />
            <label>Email:</label> <input class="form-control" type="text" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : "" ?>">
            <br />
            <label>Contraseña:</label> <input class="form-control" type="password" name="password">
            <br />
            <label>Repita Contraseña:</label> <input class="form-control" type="password" name="passwordR">
            <br />
            <label for="tipoUsuario">Tipo de usuario:</label>
            <br/>
            Cliente<input type="radio" name="type" value="customers" checked="checked" >
            <br/>
            Administrador<input type="radio" name="type" value="users">
            <br/>
            <input type="submit" class="btn" value="Continuar">
        </section>
    </form>
</div>