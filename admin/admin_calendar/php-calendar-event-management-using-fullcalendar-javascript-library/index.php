<?php
if (isset($_GET['action']) && $_GET['action'] == 'fetch_titles') {
    include('config.php'); // Ensure your config.php is correct

    // Fetch event titles from the booking table
    $sql = "SELECT title FROM booking";
    $result = $conn->query($sql);

    $titles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $titles[] = $row['title'];
        }
    }

    // Return titles as JSON
    echo json_encode($titles);

    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="fullcalendar/fullcalendar.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.1/jquery.timepicker.min.css" />
    
    <script src="fullcalendar/lib/jquery.min.js"></script>
    <script src="fullcalendar/lib/moment.min.js"></script>
    <script src="fullcalendar/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.1/jquery.timepicker.min.js"></script>

    <script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: "fetch-event.php",
            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $('#eventModal').modal('show');
                $('#startDate').val($.fullCalendar.formatDate(start, "Y-MM-DD"));
                $('#startTime').val($.fullCalendar.formatDate(start, "HH:mm"));
                let timeOptions = '';
                for (let hour = 8; hour <= 19; hour++) {
                    let hourFormatted = hour < 10 ? '0' + hour : hour;
                    let timeLabel = hourFormatted + ':00 AM';
                    if (hour > 12) {
                        timeLabel = (hour - 12) + ':00 PM';
                    }
                    timeOptions += `<option value="${hourFormatted}:00">${timeLabel}</option>`;
                }
                $('#startTime').html(timeOptions);
            },
            eventClick: function (event) {
    console.log("Deleting Event ID: " + event.id);  // Debugging line
    var deleteMsg = confirm("Do you really want to delete?");
    if (deleteMsg) {
        $.ajax({
            type: "POST",
            url: "delete-event.php",
            data: {id: event.id},  // Ensure the correct ID is passed
            success: function (response) {
                console.log("Server response:", response);  // Log the response

                // Ensure the response is a valid JSON object
                try {
                    response = JSON.parse(response); // Parse response if it's a string
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    displayMessage("Error: Invalid server response.");
                    return;
                }

                // Check if the server response has the success flag
                if (response.success) {
                    $('#calendar').fullCalendar('removeEvents', event.id);
                    displayMessage("Deleted Successfully");
                } else {
                    displayMessage("Failed to delete the event: " + response.message);
                }
            },
            error: function () {
                displayMessage("Error deleting the event.");
            }
        });
    }
}

        });

        // Fetch event titles when modal is shown
        $('#eventModal').on('shown.bs.modal', function () {
            $.ajax({
                url: '', // Empty URL will call the same page
                type: 'GET',
                data: { action: 'fetch_titles' },
                success: function (data) {
                    console.log(data);  // Debugging: log the raw response data
                    var titles = JSON.parse(data); // Parse the JSON response
                    var titleOptions = '';

                    // Check if titles is an array and has data
                    if (Array.isArray(titles) && titles.length > 0) {
                        titles.forEach(function (title) {
                            titleOptions += `<option value="${title}">${title}</option>`;
                        });
                        $('#eventTitle').html(titleOptions);
                    } else {
                        alert("No titles found or invalid data.");
                    }
                },
                error: function () {
                    alert('Error fetching event titles.');
                }
            });
        });

        // Handle form submission when user clicks "Save"
        $('#saveEvent').click(function () {
            var title = $('#eventTitle').val();
            var name = $('#eventName').val();
            var email = $('#eventEmail').val();
            var timezone = $('#eventTimezone').val();
            var address = $('#eventAddress').val();
            var startDate = $('#startDate').val();
            var startTime = $('#startTime').val();

            if (title && name && email && timezone && address && startDate && startTime) {
                var start = startDate + ' ' + startTime;

                // Log the data being sent to the server for debugging purposes
                console.log('Sending data:', {
                    title: title,
                    start: start,
                    name: name,
                    email: email,
                    timezone: timezone,
                    address: address
                });

                $.ajax({
                    url: 'add-event.php',
                    data: {
                        action: 'insert_event',
                        title: title,
                        start_date: startDate,
                        start_time: startTime,
                        name: name,
                        email: email,
                        timezone: timezone,
                        address: address
                    },
                    type: "POST",
                    success: function (data) {
                        console.log('Response:', data);  // Log the server's response for debugging

                        $('#eventModal').modal('hide');
                        displayMessage("Added Successfully");
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: start,
                            allDay: false,
                            name: name,
                            email: email,
                            timezone: timezone,
                            address: address
                        }, true);
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error);  // Log any AJAX errors
                        displayMessage("An error occurred while adding the event.");
                    }
                });
            } else {
                displayMessage("Please fill all fields.");
            }
        });
    });

    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function () { $(".success").fadeOut(); }, 1000);
    }

    
    </script>

    <style>
    body {
        margin-top: 50px;
        text-align: center;
        font-size: 12px;
        font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
    }

    #calendar {
        width: 700px;
        margin: 0 auto;
    }

    .response {
        height: 60px;
    }

    .success {
        background: #cdf3cd;
        padding: 10px 60px;
        border: #c3e6c3 1px solid;
        display: inline-block;
    }
    </style>
</head>

<body>
    <h2>Manage Calendar</h2>
    <div class="response"></div>
    <div id='calendar'></div>

    <!-- Modal for adding event -->
    <div id="eventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="eventModalLabel">Add Event</h4>
                </div>
                <div class="modal-body">
                    <form id="eventForm" action="index.php">
                        <div class="form-group">
                            <label for="eventTitle">Event Title</label>
                            <select class="form-control" id="eventTitle" required>
                                <!-- Event titles will be populated here -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventName">Name</label>
                            <input type="text" class="form-control" id="eventName" required>
                        </div>
                        <div class="form-group">
                            <label for="eventEmail">Email</label>
                            <input type="email" class="form-control" id="eventEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="eventTimezone">Timezone</label>
                            <select class="form-control" id="eventTimezone" required>
                                <option value="IST">IST</option>
                                <option value="PST">PST</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventAddress">Address</label>
                            <textarea class="form-control" id="eventAddress" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="startTime">Start Time</label>
                            <select class="form-control" id="startTime" required></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="saveEvent" class="btn btn-primary">Save Event</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
