<?php
$level = @$_GET['level'];
$level = in_array($level, range(1, 5)) ? $level : 3;
$jvcKanjiFileName = 'kanji' . $level . '.txt';

// Get data
$jvcKanji = explode("\n\n", file_get_contents($jvcKanjiFileName));
$jvcKanjiArray = [];

// Page limit
$count = count($jvcKanji);
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
	$values =  explode("\t", $jvcKanji[$i]);
	$words[] = $values[0];
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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="UTF-8">
	<style type="text/css">
		#main {
			padding: 100px 0;
		}
		table {
			text-align: center;
			font-size: 36px;
			width: 500px;
			margin: 0 auto;
		}
	</style>
</head>
<body>
	<div id="main" class="container">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Kanji Generator</h4>
				<form method="GET">
					<div class="form-group">
						<label for="level">Level</label>
						<input type="text" name="level" class="form-control" id="level" placeholder="Enter level" value="<?php echo $level; ?>">
					</div>
					<div class="form-group">
						<label for="page_from">Page from</label>
						<input type="text" name="page_from" class="form-control" id="page_from" placeholder="Enter page from" value="<?php echo $pageFrom; ?>">
					</div>
					<div class="form-group">
						<label for="page_to">Page to</label>
						<input type="text" name="page_to" class="form-control" id="page_to" placeholder="Enter page to" value="<?php echo $pageTo; ?>">
					</div>
					<div class="form-group">
						<label for="number_of_words">Number of words</label>
						<input type="text" name="number_of_words" class="form-control" id="number_of_words" placeholder="Enter number of words" value="<?php echo $numberOfWords; ?>">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
		<table class="table">
			<?php foreach ($words as $rowKey => $row): ?>
			<tr>
				<?php foreach ($row as $colKey => $ceil): ?>
					<td><?php echo $ceil ?></td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</body>
</html>