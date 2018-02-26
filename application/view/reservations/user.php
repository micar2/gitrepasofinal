<?php $this->layout('layouts/layout');
use \Mini\Libs\Sesion; ?>
<div class="container">
<?php if(isset($reservations)){
foreach ($reservations as $reservation){ ?>
    <div class="card d-inline-flex p-2" style="width: 16rem;margin: 22px;">
        <div class="card-body">
            <h5 class="card-title"><?= $customers[$reservation->id] ?></h5>
            <p class="card-text">el: <?= $reservation->day ?>/<?= $reservation->month ?>/2018</p>
            <p class="card-text">a las: <?= $reservation->hour ?>:00</p>
            <p class="card-text">sección: <?= isset($users[$reservation->id]) ? $users[$reservation->id] : Sesion::get('user_section') ?></p>
            <p class="card-text">le atiende:<?= isset($name[$reservation->id]) ? $name[$reservation->id] : Sesion::get('user_name') ?></p>
            <?php if ($reservation->user_id == Sesion::get('user_id')){ ?>
            <form action="<?= URL ?>reservations/destroy" method="POST">
                <input type="text" class="d-none" name="reservation_id" value="<?= $reservation->id ?>"/>
                <input type="submit" class="btn btn-danger" value="Borrar">
            </form>
            <?php } ?>
        </div>
    </div>
    <?php  } }else{ echo '<h2>No tiene citas asignadas</h2>'; } ?>
</div>
