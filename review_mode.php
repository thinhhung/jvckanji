<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="kanji-list" class="container">
    <div class="card-list">
        <div class="row">
            <?php foreach ($words as $rowKey => $row): ?>
                <?php foreach ($row as $colKey => $ceil): ?>
                    <div class="flashcard-wrapper col-6 col-sm-3 col-md-2">
                        <div class="flashcard">
                            <div class="front card">
                                <div class="card-body">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4><?php echo $ceil['kanji'] ?></h4>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5><?php echo $ceil['sino'] ?></h5>
                                    <p><?php echo $ceil['meaning'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<script>
    $('.flashcard').flip();
</script>