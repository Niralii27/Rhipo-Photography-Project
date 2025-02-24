<?php
include('sidebar.php');
include('config.php');

// SQL query to fetch event titles from the bookings table
$sql = "SELECT title FROM booking"; // Replace 'booking' with your actual table name
$result = $conn->query($sql);

// Prepare an array to store the event titles
$eventTitles = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventTitles[] = $row['title'];
    }
} else {
    $eventTitles = [];
}

// SQL query to fetch holidays
$holidaySql = "SELECT holiday_date FROM holidays"; // Replace 'holidays' with your actual table name
$holidayResult = $conn->query($holidaySql);

// Prepare an array to store holiday dates
$holidayDates = [];

if ($holidayResult->num_rows > 0) {
    while($row = $holidayResult->fetch_assoc()) {
        $holidayDates[] = $row['holiday_date'];
    }
} else {
    $holidayDates = [];
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Calendar</title>
    
    <!-- External CSS links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css" />

    <!-- External JavaScript links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>
</head>
<body>
    <div class="ui container">
        <br/>
        <div class="ui grid">
            <div class="ui sixteen column">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Modal for Event Form -->
    <div class="ui modal" id="event-modal">
        <div class="header">Event Details</div>
        <div class="content">
            <form class="ui form" id="event-form">
                <div class="field">
                    <label>Event Title</label>
                    <select id="event-title" class="ui dropdown">
                        <!-- Event Titles will be populated here -->
                        <?php
                            foreach ($eventTitles as $title) {
                                echo "<option value=\"$title\">$title</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Name</label>
                    <input type="text" id="event-name" placeholder="Your Name">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" id="event-email" placeholder="Your Email">
                </div>
                <div class="field">
                    <label>Timezone</label>
                    <select id="event-timezone" class="ui dropdown">
                        <option value="PST">PST</option>
                        <option value="IST">IST</option>
                    </select>
                </div>
                <div class="field">
                    <label>Address</label>
                    <input type="text" id="event-address" placeholder="Event Address">
                </div>
                <div class="field">
                    <label>Event Date</label>
                    <input type="text" id="event-date" readonly>
                </div>
                <div class="field">
                    <label>Event Time</label>
                    <select id="event-time" class="ui dropdown">
                        <option value="08:00 AM">08:00 AM</option>
                        <option value="09:00 AM">09:00 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="12:00 PM">12:00 PM</option>
                        <option value="01:00 PM">01:00 PM</option>
                        <option value="02:00 PM">02:00 PM</option>
                        <option value="03:00 PM">03:00 PM</option>
                        <option value="04:00 PM">04:00 PM</option>
                        <option value="05:00 PM">05:00 PM</option>
                        <option value="06:00 PM">06:00 PM</option>
                        <option value="07:00 PM">07:00 PM</option>
                    </select>
                </div>
                <div class="actions">
                    <button type="button" class="ui button" id="save-event">Save</button>
                    <button type="button" class="ui button" id="cancel-event">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Holiday Button -->
    <div class="ui container">
        <br />
        <div class="ui grid">
            <div class="ui left aligned column">
                <button class="ui primary button" id="add-holiday-btn">Add Holiday</button>
            </div>
        </div>
    </div>

    <!-- Modal for Add Holiday Form -->
    <div class="ui modal" id="add-holiday-modal">
        <div class="header">Add New Holiday</div>
        <div class="content">
            <form class="ui form" id="add-holiday-form">
                <div class="field">
                    <label>Select Holiday Date</label>
                    <input type="date" id="holiday-date" required>
                </div>
                <div class="actions">
                    <button type="button" class="ui button" id="save-holiday">Save Holiday</button>
                    <button type="button" class="ui button" id="cancel-holiday">Cancel</button>
                </div>
            </form>
        </div>
    </div>

<script>
$(document).ready(function() {
    // Button for adding holidays
    $('#add-holiday-btn').click(function() {
        $('#add-holiday-modal').modal('show');
    });

    // Function to update time dropdown based on booked slots
    function updateTimeDropdown(selectedDate) {
    $.ajax({
        url: 'fetch-booked-times.php',
        type: 'POST',
        data: { selected_date: selectedDate },
        success: function(response) {
            const bookedTimes = JSON.parse(response); // Parse the JSON response
            const timeDropdown = $('#event-time');
            const timeSlots = [
                "08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "12:00 PM",
                "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM", "05:00 PM",
                "06:00 PM", "07:00 PM"
            ];

            // Reset the dropdown
            timeDropdown.empty();

            // Flag to check if there are any available slots
            let anyAvailable = false;

            // Loop through each time slot
            timeSlots.forEach(time => {
                let slotAvailable = true;

                // Loop through booked times to check if the current slot is taken
                bookedTimes.forEach(booked => {
                    const startTime = moment(booked.start_time, "hh:mm A");
                    const endTime = startTime.clone().add(booked.duration, 'hours');
                    const slotTime = moment(time, "hh:mm A");

                    // Check if this slot is between the start and end time of the booked event
                    if (slotTime.isBetween(startTime, endTime, null, '[)')) {
                        slotAvailable = false; // If it overlaps, it's unavailable
                    }
                });

                // Add the time slot to the dropdown
                if (slotAvailable) {
                    timeDropdown.append(`<option value="${time}">${time}</option>`);
                    anyAvailable = true;  // Mark that there is at least one available slot
                } else {
                    timeDropdown.append(`<option value="${time}" disabled>${time} (Unavailable)</option>`);
                }
            });

            // If no slots are available, show the "No availability" message
            if (!anyAvailable) {
                timeDropdown.append('<option value="" disabled>No available time slots for this date.</option>');

                // Disable the date in the calendar
                $('#calendar').fullCalendar('renderEvent', {
                    title: 'Fully Booked',
                    start: selectedDate,
                    allDay: true,
                    color: '#d9534f', // Red for fully booked
                });

                $('#event-modal').modal('hide'); // Close the modal if it was open
            }
        },
        error: function() {
            alert('Error fetching booked times.');
        }
    });
}



    // Save Holiday Logic
    $('#save-holiday').click(function () {
        var holidayDate = $('#holiday-date').val(); // Get selected holiday date

        if (holidayDate) {
            $.ajax({
                url: 'add-holiday.php', // Backend script to save holiday
                type: 'POST',
                data: { holiday_date: holidayDate },
                success: function(response) {
                    alert(response);
                    $('#add-holiday-modal').modal('hide'); // Close the modal after saving
                    $('#calendar').fullCalendar('refetchEvents'); // Refresh the calendar
                },
                error: function() {
                    alert('An error occurred while adding the holiday.');
                }
            });
        } else {
            alert('Please select a date for the holiday.');
        }
    });

    // Cancel Holiday Logic
    $('#cancel-holiday').click(function() {
        $('#add-holiday-modal').modal('hide');
    });

    // Initialize the calendar
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultView: 'month',
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: 'fetch-event.php', // Fetch events dynamically via AJAX
        validRange: {
            start: moment().format('YYYY-MM-DD') // Prevent past date selection
        },
        dayClick: function(date, jsEvent, view) {
            // Open modal when a date is clicked
            $('#event-date').val(date.format('YYYY-MM-DD'));
            updateTimeDropdown(date.format('YYYY-MM-DD')); // Update time dropdown
            $('#event-modal').modal('show');
        },
        eventClick: function(event, jsEvent, view) {
            // This will now only run for events that aren't holidays
            if (!holidayDates.includes(event.start.format('YYYY-MM-DD'))) {
                var confirmDelete = confirm("Do you really want to delete this event?");
                if (confirmDelete) {
                    deleteEvent(event.id); // Delete the event
                }
            }
        },
        // Disable holiday dates
        eventRender: function(event, element) {
            var holidayDates = <?php echo json_encode($holidayDates); ?>;
            var eventDate = event.start.format('YYYY-MM-DD');

            // Check if this event is a holiday
            if (holidayDates.includes(eventDate)) {
                element.css('background-color', '#FF0000'); // Red color for holidays
                element.find('.fc-title').text('Booked'); // Change title to 'Holiday'
                element.css('pointer-events', 'auto'); // Enable click interaction for holidays

                // Add click handler for holidays
                element.off('click').on('click', function() {
                    var confirmDelete = confirm("Do you really want to delete this holiday?");
                    if (confirmDelete) {
                        deleteHoliday(eventDate); // Delete the holiday
                    }
                });
            } else {
                // Reset event's default styles for non-holidays
                element.css('background-color', ''); // Reset the background for regular events
                element.find('.fc-title').text(event.title); // Restore the event title

                // Add click handler for regular events
                element.off('click').on('click', function() {
                    var confirmDelete = confirm("Do you really want to delete this event?");
                    if (confirmDelete) {
                        deleteEvent(event.id); // Delete the event
                    }
                });
            }
        }
    });

    // Function to delete the event
    function deleteEvent(eventId) {
        $.ajax({
            url: 'delete-event.php',
            type: 'POST',
            data: { id: eventId },
            success: function(response) {
                if (response === 'success') {
                    alert('Event deleted successfully!');
                    $('#calendar').fullCalendar('refetchEvents'); // Reload events after deletion
                } else {
                    alert('Failed to delete the event: ' + response);
                }
            },
            error: function() {
                alert('An error occurred while deleting the event.');
            }
        });
    }

    // Function to delete holiday
    function deleteHoliday(holidayDate) {
        $.ajax({
            url: 'delete-holiday.php',
            type: 'POST',
            data: { holiday_date: holidayDate },
            success: function(response) {
                if (response === 'success') {
                    alert('Holiday deleted successfully!');
                    $('#calendar').fullCalendar('refetchEvents'); // Refresh the calendar
                } else {
                    alert('Failed to delete the holiday: ' + response);
                }
            },
            error: function() {
                alert('An error occurred while deleting the holiday.');
            }
        });
    }

    // Save event logic
    $('#save-event').click(function () {
        var eventName = $('#event-title').val();
        var userName = $('#event-name').val();
        var email = $('#event-email').val();
        var timezone = $('#event-timezone').val();
        var address = $('#event-address').val();
        var date = $('#event-date').val();
        var time = $('#event-time').val();

        if (eventName && userName && email && timezone && address && date && time) {
            $.ajax({
                url: 'add-event.php',
                type: 'POST',
                data: {
                    event_name: eventName,
                    user_name: userName,
                    email: email,
                    time_zone: timezone,
                    address: address,
                    date: date,
                    time: time
                },
                success: function (response) {
                    if (response === 'success') {
                        // Close the modal and refresh the page
                        $('#event-modal').modal('hide');
                        alert('Event saved successfully!'); // Optional confirmation
                        location.reload(); // Refresh the page
                    } else {
                        alert('Failed to save the event: ' + response);
                    }
                },
                error: function () {
                    alert('An error occurred while saving the event.');
                }
            });
        } else {
            alert('Please fill all fields.');
        }
    });

    // Cancel logic for event
    $('#cancel-event').click(function() {
        $('#event-modal').modal('hide');
        $('#event-form')[0].reset(); // Clear form fields
    });
});
</script>

</body>
</html>
