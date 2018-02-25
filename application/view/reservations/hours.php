<?php $this->layout('layouts/layout'); ?>

<div class="container">
    <?php $this->insert('partials/feedback') ?>
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
            <select name="hour" class="custom-select">
                <option selected>Elige hora</option>
                <option value="8">08:00</option>
                <option value="9">09:00</option>
                <option value="10">10:00</option>
                <option value="11">11:00</option>
                <option value="12">12:00</option>
                <option value="13">13:00</option>
                <option value="14">14:00</option>
            </select>
            <input type="text" class="d-none" name="day" value="<?= $day ?>"/>
            <input type="text" class="d-none" name="month" value="<?= $month ?>"/>
            <input type="submit" class="btn btn-info" value="Solicitar">
        </form>
</div>
