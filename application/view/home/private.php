<?php
use \Mini\Libs\Sesion;
$this->layout('layouts/layout'); ?>

<div class="container">
    <h1><?= $titulo ?></h1>
    <h2><?= Sesion::get('user_name') ?></h2>
</div>
