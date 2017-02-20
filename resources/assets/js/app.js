
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
$(function () {
  setupDataTable()
  highlightTableCellsMarkedX()
  scaleRowHeights($('#ranktable').find('tbody > tr'))
  drawRadarChart($('#studentRadarChart'))
  setActive()
  setAutoSum()
  highlightRows()
  highlightHighestValue()
})

function setAutoSum () {
  $('.autosum').change(function () {
    var sum = 0.0

    $('.autosum').each(function () {
      var values = $(this).val().split(',')
      values.forEach(function (item, index) {
        var val = parseFloat(item)
        if (!(val !== val)) {
          sum += parseFloat(item)
        }
      })
    })

    $('#sum').val(sum)
  })
}

function setActive () {
  // set active for other links
  var url = window.location
  $('ul.nav a[href="' + url + '"]').parent().addClass('active')
  $('ul.nav a').filter(function () {
    return this.href == url
  }).parent().addClass('active')
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
  // highlight cells with 'x' in student details page
  $('#statstable').find('td').each(function () {
    var value = $(this).text()
    if (value == 'x' || value == 'x.y' || value == 'xy.z') {
      $(this).addClass('highlightXYZ')
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

function highlightRows () {
  // get values of last column (SUM)
  var vals = $('#ranktable tr:gt(0) td:last-child').map(function () {
    return parseFloat($(this).text()) ? parseFloat($(this).text()) : null
  }).get()

  vals = removeDuplicates(vals)

  var max = Math.max.apply(null, vals) // get the max of the array
  // set color to gold
  vals.splice(vals.indexOf(max), 1) // remove max from the array

  var secondMax = Math.max.apply(null, vals) // get the new max
  // set color to silver
  vals.splice(vals.indexOf(secondMax), 1) // remove max from the array

  var thirdMax = Math.max.apply(null, vals) // get the new max
  // set color to bronze
  vals.splice(vals.indexOf(thirdMax), 1) // remove max from the array

  var last = Math.min.apply(null, vals)

  $('#ranktable tr:gt(0) td:last-child').each(function () {
    var curr = $(this).text()
    var parent = $(this).parent()

    if (curr == max) {
      parent.addClass('gold')
    } else if (curr == secondMax) {
      parent.addClass('silver')
    } else if (curr == thirdMax) {
      parent.addClass('bronze')
    } else if (curr == last) {
      parent.addClass('last')
    }
  })
}

// remove duplicate numbers in array
function removeDuplicates (arr) {
  return arr.filter(function (elem, index, self) {
    return index == self.indexOf(elem)
  })
}

// highlight highest value in each column
function highlightHighestValue () {
  for (var i = 5; i <= 13; i++) {
    var max = 0
    // console.log('initial max:' + max);
    var column = $('#ranktable td:nth-child(' + i + ')')
    column.each(function () {
      var value = $(this).text()
      max = Math.max(value, max)
      // console.log('value:' + value + ' max:' + max);
    })
    // console.log('col:' + i + ' max:' + max);
    column.each(function () {
      var value = $(this).text()
      if (value == max) {
        $(this).addClass('highlighted')
      }
    })
  }
}

$('.delete-btn').click(function (e) {
  e.preventDefault()
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(function () {
    $('.delete-btn').closest('form').submit()
  }).then(function () {
    swal(
    'Deleted!',
    'success'
  )
  })
})
