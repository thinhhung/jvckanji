<?php
define('BASEPATH', getcwd());
function get_value($key, $default = null) {
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    if (isset($_GET[$key])) {
        return $_GET[$key];
    }
    if (isset($_COOKIE[$key])) {
        return $_COOKIE[$key];
    }
    return $default;
}

function set_cookie_value($key, $value) {
    // Expires after a month
    setcookie($key, $value, time() + 2592000, '/');
}


$level = get_value('level');
$level = in_array($level, range(1, 5)) ? $level : 3;
require_once 'data_kanji' . $level . '.php';


// Page limit
$count = count($kanji);
$maxWordIndex = $count - 1;
$maxPage = ceil($count / 40);
$pageNumbers = range(1, $maxPage);
$pageFrom = get_value('page_from');
$pageFrom = in_array($pageFrom, $pageNumbers) ? $pageFrom : 1;
$pageTo = get_value('page_to');
$pageTo = in_array($pageTo, $pageNumbers) ? $pageTo : $maxPage;
if ($pageFrom > $pageTo) {
    $temp = $pageTo;
    $pageTo = $pageFrom;
    $pageFrom = $temp;
}
$numberOfWords = get_value('number_of_words');
$numberOfWords = intval($numberOfWords);
$numberOfWords = !$numberOfWords || $numberOfWords < 0 ? 40 : $numberOfWords;

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
} else {
    $numberOfWords = $wordsCount;
}
$words = array_chunk($words, 5);
$reviewMode = get_value('review_mode', false);
set_cookie_value('level', $level);
set_cookie_value('page_from', $pageFrom);
set_cookie_value('page_to', $pageTo);
set_cookie_value('number_of_words', $numberOfWords);
set_cookie_value('review_mode', $reviewMode);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kanji Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
</head>
<body>
    <div id="filters" class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kanji Generator</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-2">
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
                                <label for="page_from">From</label>
                                <select name="page_from" id="page_from" class="form-control">
                                    <?php for ($i = 1; $i <= 15; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php echo $i == $pageFrom ? ' selected="selected"' : '' ?>>Page <?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="page_to">To</label>
                                <select name="page_to" id="page_to" class="form-control">
                                    <?php for ($i = 1; $i <= 15; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php echo $i == $pageTo ? ' selected="selected"' : '' ?>>Page <?php echo $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="number_of_words">Number of words</label>
                                <input type="text" name="number_of_words" class="form-control" id="number_of_words" placeholder="Enter number of words" value="<?php echo $numberOfWords; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="review_mode">Review Mode</label>
                                <select name="review_mode" id="review_mode" class="form-control">
                                    <option value="0"<?php echo !$reviewMode ? ' selected="selected"' : '' ?>>Disabled</option>
                                    <option value="1"<?php echo $reviewMode ? ' selected="selected"' : '' ?>>Enabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="script.js"></script>
    <?php require_once $reviewMode ? 'review_mode.php' : 'default_mode.php'; ?>
</body>
</html>