<?php
$level = @$_GET['level'];
$level = in_array($level, range(1, 5)) ? $level : 3;
require_once 'data_kanji' . $level . '.php';

// Page limit
$count = count($kanji);
$maxWordIndex = $count - 1;
$maxPage = ceil($count / 40);
$pageNumbers = range(1, $maxPage);
$pageFrom = @$_GET['page_from'];
$pageFrom = in_array($pageFrom, $pageNumbers) ? $pageFrom : 1;
$pageTo = @$_GET['page_to'];
$pageTo = in_array($pageTo, $pageNumbers) && $pageTo >= $pageFrom ? $pageTo : $maxPage;
$numberOfWords = @$_GET['number_of_words'];
$numberOfWords = intval($numberOfWords);
$numberOfWords = !$numberOfWords || $numberOfWords < 0 || $numberOfWords >= $count ? 75 : $numberOfWords;

// JVC Kanji Process
$wordIndexFrom = ($pageFrom - 1) * 40;
$wordIndexTo = $pageTo * 40 - 1;
$wordIndexTo = $wordIndexTo > $maxWordIndex ? $maxWordIndex : $wordIndexTo;
$words = [];
for ($i = $wordIndexFrom; $i <= $wordIndexTo; $i++) {
    $words[] = $kanji[$i];
}
shuffle($words);
$wordsCount = count($words);
if ($numberOfWords < $wordsCount) {
    array_splice($words, $numberOfWords);
}
$words = array_chunk($words, 5);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kanji Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
</head>
<body>
    <div id="main" class="container">
        <div id="filters" class="card">
            <div class="card-body">
                <h4 class="card-title">Kanji Generator</h4>
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select name="level" id="level" class="form-control">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php echo $i == $level ? ' selected="selected"' : '' ?>>JVC Level <?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="page_from">Page from</label>
                                <input type="text" name="page_from" class="form-control" id="page_from" placeholder="Enter page from" value="<?php echo $pageFrom; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="page_to">Page to</label>
                                <input type="text" name="page_to" class="form-control" id="page_to" placeholder="Enter page to" value="<?php echo $pageTo; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="number_of_words">Number of words</label>
                                <input type="text" name="number_of_words" class="form-control" id="number_of_words" placeholder="Enter number of words" value="<?php echo $numberOfWords; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="view-options" class="card">
            <div class="card-body">
                <form class="form-inline">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input id="show_kanji" name="show_kanji" class="form-check-input" type="checkbox" value="1" checked="checked">
                            Show Kanji
                        </label>
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-check">
                        <label class="form-check-label">
                            <input id="show_meaning" name="show_kanji" class="form-check-input" type="checkbox" value="1" checked="checked">
                            Show Meaning
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <table id="kanji-table" class="table table-bordered">
            <?php foreach ($words as $rowKey => $row): ?>
            <tr>
                <?php foreach ($row as $colKey => $ceil): ?>
                    <td><?php echo $ceil['kanji'] ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>