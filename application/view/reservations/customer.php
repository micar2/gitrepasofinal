<?php $this->layout('layouts/layout');
use \Mini\Libs\Sesion; ?>

<div class="container">
    <?php foreach ($reservations as $reservation){ ?>
        <div class="card d-inline-flex p-2" style="width: 16rem;margin: 22px;">
            <div class="card-body">
                <h5 class="card-title"><?= Sesion::get('customer_name') ?></h5>
                <p class="card-text">el: <?= $reservation->day ?>/<?= $reservation->month ?>/2018</p>
                <p class="card-text">a las: <?= $reservation->hour ?>:00</p>
                <p class="card-text">sección: <?= $reservation->section ?></p>
                <p class="card-text">le atiende:<?= $reservation->name ?></p>
            </div>
        </div>
    <?php   }?>
</div>