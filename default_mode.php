<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="kanji-list" class="container">
    <table class="table table-bordered">
        <?php foreach ($words as $rowKey => $row): ?>
        <tr>
            <?php foreach ($row as $colKey => $ceil): ?>
                <td>
                    <?php echo $ceil['kanji'] ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
