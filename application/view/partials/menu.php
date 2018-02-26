<?php use \Mini\Libs\Sesion;?>
<div class="navigation ">

    <a href="<?= URL; ?>">Pagina Principal</a>
    <?php if (Sesion::get('customer_id') || Sesion::get('user_id')){ ?>
        <a href="<?= URL; ?>home/priv">Privado</a>
        <a href="<?= URL; ?>home/ex">Salir</a>
    <?php if (Sesion::get('user_id')){ ?>
        <a href="<?= URL; ?>reservations/seeUserReservation">Ver Mis Citas</a>
        <a href="<?= URL; ?>reservations/seeReservation">Ver Citas</a>
        <a href="<?= URL; ?>users/down">Darse de baja</a>
    <?php }
    if(Sesion::get('customer_id')){ ?>
        <a href="<?= URL; ?>reservations/reservation">Pedir Cita</a>
        <a href="<?= URL; ?>reservations/see">Ver Mis Citas</a>
        <a href="<?= URL; ?>users/down">Darse de baja</a>
    <?php }}else{ ?>
        <a href="<?= URL; ?>users/login">Entrar</a>
        <a href="<?= URL; ?>users/register">Registrarse</a>
    <?php } ?>

</div>