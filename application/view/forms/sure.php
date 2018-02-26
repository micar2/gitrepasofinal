<?php $this->layout('layouts/layout');
use Mini\Libs\Sesion; ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
    <h2>Estas seguro de querer eliminar tu cuenta</h2>
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
        <input type="text" class="d-none" name="typeId" value="<?= Sesion::get('user_id') ? 'user' : '' ?> <?= Sesion::get('customer_id') ? 'customer' : '' ?>"/>
        <h3 class="alert alert-danger w-25 p-3">Si&#160&#160&#160&#160&#160<input type="radio" name="down" value="si" ></h3>
        <br/>
        <h3 class="alert alert-success w-25 p-3">No&#160&#160&#160&#160<input type="radio" name="down" value="no" checked="checked" ></h3>
        <br/>
        <input type="submit" class="btn" value="Continuar">
    </form>
</div>