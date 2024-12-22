
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="copyright" content="MACode ID, https://macodeid.com/">

  <title>Admin Calendar</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">
  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css">

  <style>
    #calendar-container {
      max-width: 900px;
      margin: 0 auto;
    }
    .fc-toolbar-title {
      font-size: 1.5em;
      font-weight: bold;
    }
    .fc-daygrid-day {
      height: 100px;
    }
    .fc-daygrid-day-number {
      font-size: 1.2em;
      margin-bottom: 10px;
    }
    .fc-event {
      background-color: #e0f7fa;
      border: none;
      color: #00796b;
      padding: 5px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><span class="text-primary">Admin</span>-Dashboard</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="appointments.php">Appointments</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reports.php">Reports</a>
            </li>
          </ul>
        </div> 
      </div>
    </nav>
  </header>

  <!-- Calendar -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Organizer Calendar</h1>
    <div id="calendar-container">
      <div id="calendar"></div>
    </div>
  </div>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2024-12-01', // Set the initial date to December 2024
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(fetchInfo, successCallback, failureCallback) {
          $.ajax({
            url: 'get_appointments.php',
            method: 'GET',
            success: function(data) {
              successCallback(data);
            },
            error: function() {
              failureCallback();
            }
          });
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>