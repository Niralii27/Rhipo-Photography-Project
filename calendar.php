<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/mobiscroll.javascript.min.css" rel="stylesheet" />
    <script src="js/mobiscroll.javascript.min.js"></script>

        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>

    <title>
        Rhipo Photography
    </title>

    <!-- Mobiscroll JS and CSS Includes -->
    <link rel="stylesheet" href="css/mobiscroll.javascript.min.css">
    <script src="js/mobiscroll.javascript.min.js"></script>
</head>
<style>
    .md-calendar-booking .mbsc-calendar-text {
    text-align: center;
}

.md-calendar-booking .booking-datetime .mbsc-datepicker-tab-calendar {
    flex: 1 1 0;
    min-width: 300px;
}

.md-calendar-booking .mbsc-timegrid-item {
    margin-top: 1.5em;
    margin-bottom: 1.5em;
}

.md-calendar-booking .mbsc-timegrid-container {
    top: 30px;
}
  
    </style>
    <body>
    <div class="md-calendar-booking">
    <div class="mbsc-form-group">
        <div class="mbsc-form-group-title">Single date & appointment booking</div>
        <div id="demo-booking-single"></div>
    </div>
    <div class="mbsc-form-group">
        <div class="mbsc-form-group-title">Select date & time</div>
        <div id="demo-booking-datetime" class="booking-datetime"></div>
    </div>
    <div class="mbsc-form-group">
        <div class="mbsc-form-group-title">Booking multiple appointments</div>
        <div id="demo-booking-multiple"></div>
    </div>
</div>
  
        <script>
            mobiscroll.setOptions({
  theme: 'ios',
  themeVariant: 'light'
});

var min = '2025-01-11T00:00';
var max = '2025-07-11T00:00';

mobiscroll.datepicker('#demo-booking-single', {
  display: 'inline',
  controls: ['calendar'],
  min: min,
  max: max,
  pages: 'auto',
  onPageLoading: function (event, inst) {
    getPrices(event.firstDay, function callback(bookings) {
      inst.setOptions({
        labels: bookings.labels,
        invalid: bookings.invalid,
      });
    });
  },
});

mobiscroll.datepicker('#demo-booking-datetime', {
  display: 'inline',
  controls: ['calendar', 'timegrid'],
  min: min,
  max: max,
  minTime: '08:00',
  maxTime: '19:59',
  stepMinute: 60,
  width: null,
  onPageLoading: function (event, inst) {
    getDatetimes(event.firstDay, function callback(bookings) {
      inst.setOptions({
        labels: bookings.labels,
        invalid: bookings.invalid,
      });
    });
  },
});

mobiscroll.datepicker('#demo-booking-multiple', {
  display: 'inline',
  controls: ['calendar'],
  min: min,
  max: max,
  pages: 'auto',
  selectMultiple: true,
  onInit: function (event, inst) {
    inst.setVal(['2025-01-11T00:00', '2025-01-16T00:00', '2025-01-17T00:00'], true);
  },
  onPageLoading: function (event, inst) {
    getBookings(event.firstDay, function callback(bookings) {
      inst.setOptions({
        labels: bookings.labels,
        invalid: bookings.invalid,
      });
    });
  },
});

function getPrices(d, callback) {
  var invalid = [];
  var labels = [];

  mobiscroll.getJson(
    'https://trial.mobiscroll.com/getprices/?year=' + d.getFullYear() + '&month=' + d.getMonth(),
    function (bookings) {
      for (var i = 0; i < bookings.length; ++i) {
        var booking = bookings[i];
        var d = new Date(booking.d);

        if (booking.price > 0) {
          labels.push({
            start: d,
            title: '$' + booking.price,
            textColor: '#e1528f',
          });
        } else {
          invalid.push(d);
        }
      }
      callback({ labels: labels, invalid: invalid });
    },
    'jsonp',
  );
}

function getDatetimes(day, callback) {
  var invalid = [];
  var labels = [];

  mobiscroll.getJson(
    'https://trial.mobiscroll.com/getbookingtime/?year=' + day.getFullYear() + '&month=' + day.getMonth(),
    function (bookings) {
      for (var i = 0; i < bookings.length; ++i) {
        var booking = bookings[i];
        var bDate = new Date(booking.d);

        if (booking.nr > 0) {
          labels.push({
            start: bDate,
            title: booking.nr + ' SPOTS',
            textColor: '#e1528f',
          });
          invalid = invalid.concat(booking.invalid);
        } else {
          invalid.push(bDate);
        }
      }
      callback({ labels: labels, invalid: invalid });
    },
    'jsonp',
  );
}

function getBookings(d, callback) {
  var invalid = [];
  var labels = [];

  mobiscroll.getJson(
    'https://trial.mobiscroll.com/getbookings/?year=' + d.getFullYear() + '&month=' + d.getMonth(),
    function (bookings) {
      for (var i = 0; i < bookings.length; ++i) {
        var booking = bookings[i];
        var d = new Date(booking.d);

        if (booking.nr > 0) {
          labels.push({
            start: d,
            title: booking.nr + ' SPOTS',
            textColor: '#e1528f',
          });
        } else {
          invalid.push(d);
        }
      }
      callback({ labels: labels, invalid: invalid });
    },
    'jsonp',
  );
}
  
            </script>
</body>
</html>