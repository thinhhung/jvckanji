<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="kanji-list" class="container">
    <div class="card-list">
        <?php foreach ($words as $rowKey => $row): ?>
        <div class="row">
            <?php foreach ($row as $colKey => $ceil): ?>
                <div class="col">
                    <div class="flashcard">
                        <div class="front card">
                            <div class="card-body">
                                <h4><?php echo $ceil['kanji'] ?></h4>
                            </div>
                        </div>
                        <div class="back card">
                            <div class="card-body">
                                <h5><?php echo $ceil['sino'] ?></h5>
                                <p><?php echo $ceil['meaning'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<script>
    $('.flashcard').flip();
</script>