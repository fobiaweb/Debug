<?php
/**
 * html.php file
 *
 * @author     Dmitriy Tyurin <fobia3d@gmail.com>
 * @copyright  Copyright (c) 2014 Dmitriy Tyurin
 */



?>
<style>
<?php echo file_get_contents(__DIR__ . '/style.css'); ?>
</style>


<div id="ac-logger-switch">DBG</div>
<div id="ac-logger" class="">
    <div class="content">
        <table style="width: 100%;">
            <thead>
                <tr >
                    <th class="number"   style="width: 30px;">№</th>
                    <th class="time"     style="width: 70px;">time    </th>
                    <th class="level"    style="width: 70px;">level   </th>
                    <th class="category" style="width: 70px;">ctgory</th>
                    <th class="message">message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->list as $row): ?>
                    <tr>
                        <td class="number"><?= sprintf("%'02d", ++ $i); ?></td>
                        <td class="time"><?= sprintf("%-9s", $row['time']); ?></td>
                        <td class="level"><?= sprintf("%-9s", "[{$row['level']}]"); ?></td>
                        <td class="category"> </td>
                        <td class="message"><?= $row['message'] . " <i>" . $row['context'] . "</i>"; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
<?php
echo file_get_contents(__DIR__ . '/debug.js');
?>

</script>
