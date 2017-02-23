
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
  setupNavBarDropDown()
  setupDataTable()
  highlightTableCellsMarkedX()
  scaleRowHeights()
  drawRadarChart($('#studentRadarChart'))
  drawProgressChart($('#progressChart'))
  setActive()
  setAutoSum()
  highlightRows()
  highlightHighestValue()
})

function setupNavBarDropDown() {
  var previous = null;
  $('.dropdown-submenu a.test').on("click", function(e){
    if (previous != null) previous.toggle()
    previous = $(this).next('ul')
    $(this).next('ul').toggle()
    e.stopPropagation()
    e.preventDefault()
  })
}

function setAutoSum () {
  $('.autosum').change(function () {
    var sum = 0.0
    console.log('in setAutoSum')
    $('.autosum').each(function () {
        var val = parseFloat($(this).val())
        console.log(val);
        if (!(val !== val)) {
          sum += parseFloat($(this).val())
        }
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

function scaleRowHeights() {
  var rows = $('#ranktable').find('tbody > tr')
  if (!rows.length) return
  const baseRowHeight = rows[0].offsetHeight
  const totalNumOfDataRows = rows.length
  const delta = 15
  
  setRowHeights($('#ranktable th').length - 1)
  
  $('#ranktable th').on('click', function () {
    var colIndex = $(this)[0].cellIndex
    if (colIndex <= 2) {
      resetRowHeights()
    } else {
      setRowHeights(colIndex)
    }
  })
  
  function setRowHeights(colIndex) {
    var rows = $('#ranktable').find('tbody > tr')
    rows.eq(0).css('height', baseRowHeight)
    
    rows.each((rowIndex, currRow) => {
      if (rowIndex !== totalNumOfDataRows - 1) {
        var currColScore = $(currRow).find('td').eq(colIndex).text()
        var nextColScore = $(currRow).next('tr').find('td').eq(colIndex).text()
        var spacing = Math.abs(currColScore - nextColScore) * delta + baseRowHeight
        $(currRow).next('tr').css('height', spacing + 'px')
      }
    })
  }
  
  function resetRowHeights() {
    var rows = $('#ranktable').find('tbody > tr')
    rows.each((index, curr) => {
      $(curr).css('height', baseRowHeight)
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
  let keys = ['ac', 'bs', 'hw', 'mc', 'ks', 'tc']
  let formattedCurrStudentData = []
  let formattedTopStudentData = []
  let formattedKeys = []
  let currentStudentData = data['currentStudent']
  let topStudentData = data['topStudent']
  let currentStudentDataName = currentStudentData['name']
  let topStudentDataName = topStudentData['name']
  keys.forEach(function (key) {
    formattedKeys.push(key.toUpperCase());
    formattedCurrStudentData.push(currentStudentData[key])
    formattedTopStudentData.push(topStudentData[key])
  })
  
  return {
    keys: formattedKeys,
    currentStudent: formattedCurrStudentData,
    topStudent: formattedTopStudentData,
	  currentStudentDataName: currentStudentDataName,
    topStudentDataName: topStudentDataName
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
        label: dataset['currentStudentDataName'],
        backgroundColor: 'rgba(179,181,198,0.2)',
        borderColor: 'rgba(179,181,198,1)',
        pointBackgroundColor: 'rgba(179,181,198,1)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgba(179,181,198,1)',
        data: dataset['currentStudent']
      },
      {
        label: dataset['topStudentDataName'],
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

//progress chart
function drawProgressChart ($selector) {
  if (!$selector.length) return
  getProgressData().then(function (data) {
    return formartProgressChartData(data)
  }).done(function (formattedData) {
    makeProgressChart($selector, formattedData)
  }).fail(function (data) {
  })
}

function formartProgressChartData (data) {
  let nicks = data['nicks']
  let progressData = data['progressData']
  let dataStore = {}
  var maxWeeks = 0;
  
  progressData.forEach(function (scoreRow) {
    dataStore[scoreRow['nick']] = [0]
  })
  
  progressData.forEach(function (scoreRow) {
    maxWeeks = Math.max(maxWeeks, scoreRow['week'])
    let currentWeek = scoreRow['week'] - 1;
    let previousWeek = currentWeek - 1;
    
    if (previousWeek >= 0) {
      dataStore[scoreRow['nick']][currentWeek] = dataStore[scoreRow['nick']][previousWeek] + scoreRow['progress']
    } else {
      dataStore[scoreRow['nick']][currentWeek] = scoreRow['progress']
    }
  })
  
  let chartData = []
  nicks.forEach(function(nick) {
    let color = getRandomColor()
    chartData.push({
      label: nick,
      backgroundColor: color,
      borderColor: color,
      data: dataStore[nick],
      fill: false
    })
  })
  
  let weeks = []
  for (let i = 0; i < maxWeeks; i++) {
    weeks.push(i + 1);
  }
  
  return {
    weeks: weeks,
    chartData: chartData
  }
}

function getProgressData () {
  let apitUrl = '/api' + window.location.pathname
  return makeAjaxCall(apitUrl, 'GET')
}

function getRandomColor() {
  var letters = '0123456789ABCDEF'.split('');
  var color = '#';
  for (var i = 0; i < 6; i++ ) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function makeProgressChart ($selector, dataset) {
  data = {
    labels: dataset['weeks'],
    datasets: dataset['chartData']
  }

  new Chart($selector, {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      title:{
        display: false,
        text: 'Progress Chart'
      },
      tooltips: {
        mode: 'index',
        intersect: false
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Week'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Score'
          }
        }]
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
