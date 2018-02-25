<?php $this->layout('layouts/layout') ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h2>Entrada</h2>
    <form action="<?= URL ?>users/login" method="POST">
        <section>
            <label>Email:</label> <input class="form-control" type="text" name="email" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
            <br />
            <label>Contraseña:</label> <input class="form-control" type="password" name="password">
            <br />
            <input type="submit" class="btn" value="Continuar">
        </section>
    </form>
</div>