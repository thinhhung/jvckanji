var maxPages = {
    1: 14,
    2: 15,
    3: 10,
    4: 10,
    5: 6
};
var afterChangeLevel = function () {
    var level = $('#level').val();
    $('select#page_from option, select#page_to option').removeAttr('disabled').show();
    if (typeof maxPages[level] !== 'undefined') {
        var showToIndex = maxPages[level] - 1;
        if ($('select#page_from').val() > maxPages[level]) {
            $('select#page_from').val(maxPages[level]);
        }
        if ($('select#page_to').val() > maxPages[level]) {
            $('select#page_to').val(maxPages[level]);
        }
        $('select#page_from option:gt(' + showToIndex + '), select#page_to option:gt(' + showToIndex + ')').attr('disabled','disabled').hide();
    }
}
$(function () {
    afterChangeLevel();
    $('#level').change(afterChangeLevel);
});