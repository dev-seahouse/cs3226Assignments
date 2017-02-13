$(function () {
  setupDataTable();
  highlightTableCellsMarkedX();
  scaleRowHeights($('#ranktable').find('tbody > tr'));
  drawRadarChart($('#studentRadarChart'));
  setActive();
  setAutoSum();
})

function setAutoSum() {
  $('.autosum').change(function() {
    var sum = 0.0;
    
    $('.autosum').each(function() {
      var values = $(this).val().split(',');
      values.forEach(function(item, index) {
        var val = parseFloat(item);
        if (!(val !== val)) {
          sum += parseFloat(item);
        }
      });
    });
    
    $('#sum').val(sum);
  });
}

function setActive() {
  // set active for other links
  var url = window.location;
  $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
  $('ul.nav a').filter(function() {
    return this.href == url;
  }).parent().addClass('active');
}

function setupDataTable () {
  // add column sorting functionality to ranking table
  $('#ranktable').DataTable({
    // options api: https://datatables.net/reference/option/
    paging: false,
    searching: false,
    info: false
  })

  // using DataTables overrode my table width setting, so setting it here again
  $('#ranktable').width('100%')
}

function highlightTableCellsMarkedX () {
  // highlight rows that have top 3, and lowest value in SUM column
  // highlight cells with 'x' in student details page
  $('#statstable').find('td').each(function () {
    var value = $(this).text()
    if (value == 'x' || value == 'x.y' || value == 'xy.z') {
      $(this).addClass('highlightCellWithX')
    }
  })
}

function scaleRowHeights (rows) {
  if (!rows.length) return
  const totalNumOfDataRows = rows.length
  const baseRowHeight = rows[0].offsetHeight

  setRowHeights()
  restoreDefaultRowHeightsIfTheadClicked()

  function setRowHeights () {
    rows.each((rowIndex, currRow) => {
      setRowHeight(rowIndex, currRow)
    })
  }

  function setRowHeight (rowIndex, currRow) {
    if (rowIndex !== totalNumOfDataRows - 1) {
      $(currRow).next('tr').css('height', calculateRowHeightBasedOnRankScoreDiff(currRow) + 'px')
    }
  }

  function calculateRowHeightBasedOnRankScoreDiff (currRow) {
    const delta = 40
    let $currTotlRankScoreCol = $(currRow).find('.js-rankTotl'),
        currTotlRankScore = $currTotlRankScoreCol.text(),
        $nextTotlRankScoreCol = $(currRow).next('tr').find('.js-rankTotl'),
        nextTotlRankScore = $nextTotlRankScoreCol.text()

    return (currTotlRankScore - nextTotlRankScore) * delta + baseRowHeight
  }

  function restoreDefaultRowHeightsIfTheadClicked () {
    $('#ranktable thead').one('click', function () {
      rows.each((index, currRow) => {
        $(currRow).css('height', baseRowHeight)
      })
    })
  }
}

// remove duplicate numbers in array
function removeDuplicates (arr) {
  return arr.filter(function (elem, index, self) {
    return index == self.indexOf(elem)
  })
}

function drawRadarChart ($selector) {
  if (!$selector.length) return
  getStudentData().then(function (data) {
    return formartChartData(data)
  }).done(function (formattedData) {
    makeRadarChart($selector, formattedData)
  }).fail(function (data) {
  })
    }

function formartChartData (data) {
  let keys = ['AC', 'BS', 'HW', 'MC', 'TC', 'MC']
  let formattedCurrStudentData = []
  let formattedTopStudentData = []
  let currentStudentData = data['currentStudent']
  let topStudentData = data['topStudent']
  keys.forEach(function (key) {
    formattedCurrStudentData.push(currentStudentData[key])
    formattedTopStudentData.push(topStudentData[key])
  })

  return {
    keys: keys,
    currentStudent: formattedCurrStudentData,
    topStudent: formattedTopStudentData
  }
}

function getStudentData () {
  let apitUrl = '/api' + window.location.pathname
  return makeAjaxCall(apitUrl, 'GET')
}

function makeAjaxCall (url, methodType, callback) {
  return $.ajax({
    url: url,
    method: methodType,
    dataType: 'json'
  })
}

function makeRadarChart ($selector, dataset) {
  data = {
    labels: dataset['keys'],
    datasets: [
      {
        label: 'You',
        backgroundColor: 'rgba(179,181,198,0.2)',
        borderColor: 'rgba(179,181,198,1)',
        pointBackgroundColor: 'rgba(179,181,198,1)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgba(179,181,198,1)',
        data: dataset['currentStudent']
      },
      {
        label: 'The champion',
        backgroundColor: 'rgba(255,99,132,0.2)',
        borderColor: 'rgba(255,99,132,1)',
        pointBackgroundColor: 'rgba(255,99,132,1)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgba(255,99,132,1)',
        data: dataset['topStudent']
      }
    ]
  }

  new Chart($selector, {
    type: 'radar',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scale: {
        ticks: {
          beginAtZero: true,
          stepSize: 5
        }
      }
    }
  })
}

