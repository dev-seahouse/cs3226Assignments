$(function() {
    setupDataTable();
    highlightTableCellsMarkedX();
    highlightRows();
    scaleRowHeights($('#ranktable').find('tbody > tr'));
    /* TBD
    Note: can reuse the removeDuplicates function for the other two functionalities
    For each 9 column: MC/TC/SPE/HW/Bs/KS/AC/DIL/Sum, use client-side JavaScript (as we have not learned how to access database in web-server), highlight the cell(s) that contains the highest score for that particular column using Orange color. This likely requires some custom JS coding work.
    */
});

function setupDataTable() {
    // add column sorting functionality to ranking table
    $("#ranktable").DataTable({
        // options api: https://datatables.net/reference/option/
        paging: false,
        searching: false,
        info: false
    });

    // using DataTables overrode my table width setting, so setting it here again
    $("#ranktable").width('100%');
}

function highlightTableCellsMarkedX() {
    // highlight rows that have top 3, and lowest value in SUM column
    // highlight cells with 'x' in student details page
    $('#statstable').find("td").each(function() {
        var value = $(this).html();
        if (value == "x") {
            $(this).addClass('highlightCellWithX');
        }
    });
}

function highlightRows() {
    // get values of last column (SUM)
    var vals = $("#ranktable tr:gt(0) td:last-child").map(function() {
        return parseFloat($(this).text()) ? parseFloat($(this).text()) : null;
    }).get();

    vals = removeDuplicates(vals);

    var max = Math.max.apply(null, vals); // get the max of the array
    // set color to gold
    vals.splice(vals.indexOf(max), 1); // remove max from the array

    var secondMax = Math.max.apply(null, vals); // get the new max
    // set color to silver
    vals.splice(vals.indexOf(secondMax), 1); // remove max from the array

    var thirdMax = Math.max.apply(null, vals); // get the new max
    // set color to bronze
    vals.splice(vals.indexOf(thirdMax), 1); // remove max from the array

    var last = Math.min.apply(null, vals);

    $("#ranktable tr:gt(0) td:last-child").each(function() {
        var curr = $(this).text();
        var parent = $(this).parent();

        if (curr == max) {
            parent.addClass("gold");
        } else if (curr == secondMax) {
            parent.addClass("silver");
        } else if (curr == thirdMax) {
            parent.addClass("bronze");
        } else if (curr == last) {
            parent.addClass("last");
        }
    });
}


function scaleRowHeights(rows) {
    const totalNumOfDataRows = rows.length,
           baseRowHeight = rows[0].offsetHeight;

    setRowHeights();
    restoreDefaultRowHeightsIfTheadClicked();

    function setRowHeights() {
        rows.each((rowIndex, currRow) => {
            setRowHeight(rowIndex, currRow);
        });
    }

    function setRowHeight(rowIndex, currRow) {
        if (rowIndex !== totalNumOfDataRows - 1) {
            $(currRow).next('tr').css('height', calculateRowHeightBasedOnRankScoreDiff(currRow) + 'px');
        }
    }

    function calculateRowHeightBasedOnRankScoreDiff(currRow) {
        const delta = 45;
        let $currTotlRankScoreCol = $(currRow).find('.js-rankTotl'),
            currTotlRankScore = $currTotlRankScoreCol.text(),
            $nextTotlRankScoreCol = $(currRow).next('tr').find('.js-rankTotl'),
            nextTotlRankScore = $nextTotlRankScoreCol.text();

        return (currTotlRankScore - nextTotlRankScore) * delta + baseRowHeight;
    }

    function restoreDefaultRowHeightsIfTheadClicked() {
        $('#ranktable thead').one('click', function() {
            rows.each((index, currRow) => {
                $(currRow).css('height', baseRowHeight);
            });
        });
    }
}


// remove duplicate numbers in array
function removeDuplicates(arr) {
    return arr.filter(function(elem, index, self) {
        return index == self.indexOf(elem);
    });
}
