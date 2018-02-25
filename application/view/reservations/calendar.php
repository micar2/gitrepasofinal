<?php $this->layout('layouts/layout'); ?>
<div class="container">
    <table id="calendar" class="d-inline-flex p-2">
        <caption><?php echo $meses[$month]." ".$year?></caption>
        <tr>
            <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
            <th>Vie</th><th>Sab</th><th>Dom</th>
        </tr>
        <tr bgcolor="silver">
            <?php $last_cell=$diaSemana+$ultimoDiaMes;
            for($i=1;$i<=42;$i++)
            {
                if($i==$diaSemana) {
                    $day=1;
                }
                if($i<$diaSemana || $i>=$last_cell)
                {
                    echo "<td>&nbsp;</td>";
                }else{
                    if($day>=$diaActual) { ?>
                        <td class='hoy'>
                            <form action="<?= URL ?>reservations/cite" method="POST">
                                <input type="text" class="d-none" name="day" value="<?= $day ?>"/>
                                <input type="text" class="d-none" name="month" value="<?= $month ?>"/>
                                <input type="submit" value="<?= $day ?>">
                            </form>
                        </td>
                        <?php $day++;}else{ ?>
                        <td><?= $day ?></td>
                        <?php $day++;}
                }

                if($i%7==0) {
                    echo "</tr><tr>\n";
                }
            } ?>
        </tr>
    </table>
    <table id="calendar" class="d-inline-flex p-2">
        <caption><?php echo $meses[$month+1]." ".$year?></caption>
        <tr>
            <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
            <th>Vie</th><th>Sab</th><th>Dom</th>
        </tr>
        <tr bgcolor="silver">
            <?php $last_cell=$diaSemana+$ultimoDiaMes2;
            for($i=1;$i<=42;$i++)
            {
                if($i==$diaSemana) {
                    $day=1;
                }
                if($i<$diaSemana || $i>=$last_cell)
                {
                    echo "<td>&nbsp;</td>";
                }else{?>
                    <td class='hoy'>
                        <form action="<?= URL ?>reservations/cite" method="POST">
                            <input type="text" class="d-none" name="day" value="<?= $day ?>"/>
                            <input type="text" class="d-none" name="month" value="<?= ($month+1) ?>"/>
                            <input type="submit" value="<?= $day ?>">
                        </form>
                    </td>
                    <?php $day++;
                }
                if($i%7==0) {
                    echo "</tr><tr>\n";
                }
            } ?>
        </tr>
    </table>
</div>