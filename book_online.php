<?php
include('config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// SQL query with prepared statement for security
$sql = "SELECT * FROM booking WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$title = $price = $other_services = "N/A";
$required_hours = 1;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = htmlspecialchars($row['title']);
    $price = htmlspecialchars($row['fees']);
    $other_services = ($row['description']);
    $required_hours = isset($row['hours']) ? intval($row['hours']) : 1;
}

function getAllTimeSlots() {
    return [
        '08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM',
        '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM',
        '06:00 PM', '07:00 PM', '08:00 PM'
    ];
}

// Get holidays from database
$holidays = [];
$holidaysSql = "SELECT * FROM holidays";
$holidaysResult = $conn->query($holidaysSql);
if ($holidaysResult) {
    while($row = $holidaysResult->fetch_assoc()) {
        $holidays[] = $row['holiday_date'];
    }
}

// Get bookings with prepared statement
$bookings = [];
$sql = "SELECT date, time, hours FROM client_booking";
$result = $conn->query($sql);
if ($result) {
    while($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $time = $row['time'];
        $hours = intval($row['hours']);
        
        if (!isset($bookings[$date])) {
            $bookings[$date] = [];
        }
        
        $timeIndex = array_search($time, getAllTimeSlots());
        if ($timeIndex !== false) {
            for ($i = 0; $i < $hours && ($timeIndex + $i) < count(getAllTimeSlots()); $i++) {
                $blockedTime = getAllTimeSlots()[$timeIndex + $i];
                $bookings[$date][] = $blockedTime;
            }
        }
    }
}

$bookingsJson = json_encode($bookings);
$holidaysJson = json_encode($holidays);
$requiredHoursJson = json_encode($required_hours);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rhipo Photography</title>
  <link rel="icon" href="images/logo2.png" type="image/png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" />
  <style>
    @font-face {
    font-family: 'The New Elegance';
    src: url('assets/fonts/TheNewElegance-CondensedRegular.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .card {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      text-align: center;
      font-family:'The New Elegance';
      font-size: 28px;
      font-weight: bold;
      color: #9D8161;
      margin-bottom: 20px;
    }

    .calendar-time-section {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }

    .time-slots {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .time-slot {
      flex: 1 1 30%;
      padding: 8px 10px;
      background-color: #f0f0f0;
      border-radius: 4px;
      text-align: center;
      font-size: 14px;
      font-weight: bold;
      color: #333;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      min-width: 80px;
      max-height:50px;
    }

    .time-slot:hover {
      background-color: #9D8161;
      color: white;
    }

    .time-slot.selected {
      background-color: #9D8161;
      color: white;
    }

    .form-section input,
    .form-section select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-section input:focus,
    .form-section select:focus {
      border-color: #9D8161;
      outline: none;
    }

    .book-now-btn {
      width: 100%;
      background-color:rgba(157, 129, 97, 0.93);
      color: white;
      font-size: 16px;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .book-now-btn:hover {
      background-color:#9D8161;
    }

    .services-section {
      margin-top: 15px;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .services-item span {
      font-weight: bold;
      color: #9D8161;
    }

    .address-preview {
      margin-top: 10px;
      font-style: italic;
      color: #7F6B4F;
    }

    @media (max-width: 768px) {
      .calendar-time-section {
        grid-template-columns: 1fr;
      }
    }

 
  </style>
</head>
<body>
  <div class="card">
    <!-- Card Title -->
    <div class="card-title">Book Your Event</div>
    <!-- <p>Check out our availability and book the date and time that works for you</p> -->
<br></br>
    <!-- Calendar and Time Slots -->
    <div class="calendar-time-section">
      <!-- Calendar -->
      <div>
        <input type="text" id="calendar" placeholder="Select a date" />
        <div id="date-error" class="error-message">Please select a date</div>

      </div>

      <!-- Time Slots -->
      <div class="time-slots" id="timeSlots">
        <div class="time-slot" data-time="1:30 PM">8:00 AM</div>
        <div class="time-slot" data-time="2:00 PM">9:00 AM</div>
        <div class="time-slot" data-time="2:30 PM">10:00 AM</div>
        <div class="time-slot" data-time="3:00 PM">11:00 AM</div>
        <div class="time-slot" data-time="3:30 PM">12:00 PM</div>
        <div class="time-slot" data-time="4:00 PM">1:00 PM</div>
        <div class="time-slot" data-time="4:30 PM">2:30 PM</div>
        <div class="time-slot" data-time="5:00 PM">3:00 PM</div>
        <div class="time-slot" data-time="5:30 PM">4:30 PM</div>
        <div class="time-slot" data-time="6:00 PM">5:00 PM</div>
        <div class="time-slot" data-time="6:00 PM">6:00 PM</div>
        <div class="time-slot" data-time="6:00 PM">7:00 PM</div>
        <div class="time-slot" data-time="6:00 PM">8:00 PM</div>
        </div>
        <div id="time-error" class="error-message">Please select a time slot</div>

    </div>
<br></br>
    <!-- Form Section -->
    <div class="form-section">
    <div class="form-group">
                <input type="text" id="name" placeholder="Enter your name" required />
                <div id="name-error" class="error-message">Please enter your name</div>
            </div>
            <div class="form-group">
                <input type="email" id="email" placeholder="Enter your email" required />
                <div id="email-error" class="error-message">Please enter a valid email</div>
            </div>

            <div class="form-group">
                <input type="text" id="address" placeholder="Enter your address" required />
                <div id="address-error" class="error-message">Please enter your address</div>
            </div>

            <div class="form-group">
                <select id="timezone" required>
                    <option value="" disabled selected>Select Timezone</option>
                    <option value="ISP">India Standard Time(GMT+5:30)</option>
                    <option value="PST">Pacific Standard Time(PST)</option>
                </select>
                <div id="timezone-error" class="error-message">Please select a timezone</div>
            </div>
    </div>

    <!-- Services Section -->
    <div class="services-section">
      <p><span>Event:</span> <?= htmlspecialchars($title) ?></p>
      <p><span>Price:</span> <?= htmlspecialchars($price) ?></p>
      <p><span>Services:</span> <?= ($other_services) ?></p>
      <p><span>Address:</span> <span id="address-in-services">N/A</span></p>
      <p><span>Time Slot:</span> <span id="selected-time">Not selected</span></p>
    </div>


    <!-- Book Now Button -->
    <button class="book-now-btn" id="book-now-btn">Book Now</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get bookings data and required hours from PHP
    const bookings = <?php echo $bookingsJson; ?>;
    const holidays = <?php echo $holidaysJson; ?>;
    const requiredHours = <?php echo $requiredHoursJson; ?>;
    
    // All possible time slots
    const allTimeSlots = <?php echo json_encode(getAllTimeSlots()); ?>;
    
    let selectedTime = null;
    let selectedDate = null;
    const timeSlotsContainer = document.getElementById('timeSlots');

    // Add error message styles
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        .error-field {
            border-color: #dc3545 !important;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .time-error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }
        //      .has-slots::after {
        //     content: '';
        //     display: block;
        //     width: 6px;
        //     height: 6px;
        //     background:rgb(76, 177, 79);
        //     border-radius: 50%;
        //     position: absolute;
        //     bottom: 2px;
        //     left: 50%;
        //     transform: translateX(-50%);
        // }
        .same-day-message {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    `;
    document.head.appendChild(styleElement);

    function isValidBookingDate(date) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(0, 0, 0, 0);
        
        const checkDate = new Date(date);
        checkDate.setHours(0, 0, 0, 0);

        if (holidays.includes(date)) {
            return false;
        }
        
        return checkDate >= tomorrow;
    }


   // Function to check if a date has any available time slots
   function hasAvailableTimeSlots(date) {
    if (!isValidBookingDate(date)) return false;

    if (holidays.includes(date)) return false;

    
    // Check if there are any available slots for this date
    let hasSlots = false;
    allTimeSlots.forEach(time => {
        if (hasEnoughContinuousHours(date, time, requiredHours)) {
            hasSlots = true;
        }
    });
    return hasSlots;
}

    // Function to check if a time slot has enough continuous available hours
    function hasEnoughContinuousHours(date, startTimeSlot, requiredHours) {
        const bookedSlots = bookings[date] || [];
        const startIndex = allTimeSlots.indexOf(startTimeSlot);
        
        if (startIndex === -1) return false;
        
        // Check if we have enough slots remaining in the day
        if (startIndex + requiredHours > allTimeSlots.length) return false;
        
        // Check if all required consecutive slots are available
        for (let i = 0; i < requiredHours; i++) {
            const checkTime = allTimeSlots[startIndex + i];
            if (bookedSlots.includes(checkTime)) {
                return false;
            }
        }
        
        return true;
    }

    // Update available time slots based on selected date
    function updateAvailableTimeSlots(date) {
        if (!timeSlotsContainer) {
            console.error('Time slots container not found');
            return;
        }

        timeSlotsContainer.innerHTML = '';
        selectedTime = null; // Reset selected time when date changes
        document.getElementById('selected-time').textContent = 'Not selected';

        
        
        // Check each time slot
        const today = new Date();
        const selectedDateObj = new Date(date);
        today.setHours(0, 0, 0, 0);
        selectedDateObj.setHours(0, 0, 0, 0);

        if (selectedDateObj.getTime() === today.getTime()) {
            timeSlotsContainer.innerHTML = '<div class="same-day-message">Please select a date at least one day in advance for booking.</div>';
            return;
        }
        
        // Check each time slot
        if (isValidBookingDate(date)) {
            allTimeSlots.forEach(time => {
                if (hasEnoughContinuousHours(date, time, requiredHours)) {
                    const slot = document.createElement('div');
                    slot.className = 'time-slot';
                    slot.setAttribute('data-time', time);
                    slot.textContent = time;
                    
                    slot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot').forEach(s => 
                            s.classList.remove('selected')
                        );
                        this.classList.add('selected');
                        selectedTime = time;
                        const selectedTimeElement = document.getElementById('selected-time');
                        if (selectedTimeElement) {
                            selectedTimeElement.textContent = time;
                        }
                        const timeError = document.getElementById('time-error');
                        if (timeError) {
                            timeError.style.display = 'none';
                        }
                        validateField('time');
                    });

                    timeSlotsContainer.appendChild(slot);
                }
            });
        }

        // Show message if no slots available
        if (timeSlotsContainer.children.length === 0) {
            timeSlotsContainer.innerHTML = '<div class="no-slots-message">No available time slots for this date</div>';
        }
    }

    // Initialize calendar
    const calendar = flatpickr("#calendar", {
        inline: true,
        defaultDate: "today",
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: holidays, // Disable holiday dates

        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0];
            if (hasAvailableTimeSlots(dateStr)) {
                dayElem.classList.add('has-slots');
            }

            if (holidays.includes(dateStr)) {
                dayElem.classList.add('holiday');
            }
        },
        onChange: function(selectedDates, dateStr) {
            selectedDate = dateStr;
            updateAvailableTimeSlots(dateStr);
            validateField('date');
        }
    });

    // Add input event listeners for real-time validation
    document.getElementById('name').addEventListener('input', () => validateField('name'));
    document.getElementById('email').addEventListener('input', () => validateField('email'));
    document.getElementById('address').addEventListener('input', () => validateField('address'));
    document.getElementById('timezone').addEventListener('change', () => validateField('timezone'));

    // Function to validate fields
    function validateField(fieldName) {
        const fields = {
            name: document.getElementById('name'),
            email: document.getElementById('email'),
            address: document.getElementById('address'),
            timezone: document.getElementById('timezone'),
            date: document.getElementById('calendar'),
            time: document.getElementById('selected-time')
        };
        
        const errorElements = {
            name: document.getElementById('name-error'),
            email: document.getElementById('email-error'),
            address: document.getElementById('address-error'),
            timezone: document.getElementById('timezone-error'),
            date: document.getElementById('date-error'),
            time: document.getElementById('time-error')
        };

        let isValid = true;
        
        if (fieldName === 'all' || fieldName === 'name') {
            if (!fields.name?.value?.trim()) {
                showError(fields.name, errorElements.name);
                isValid = false;
            } else {
                hideError(fields.name, errorElements.name);
            }
        }

        if (fieldName === 'all' || fieldName === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!fields.email?.value?.trim() || !emailRegex.test(fields.email.value.trim())) {
                showError(fields.email, errorElements.email);
                isValid = false;
            } else {
                hideError(fields.email, errorElements.email);
            }
        }

        if (fieldName === 'all' || fieldName === 'address') {
            if (!fields.address?.value?.trim()) {
                showError(fields.address, errorElements.address);
                isValid = false;
            } else {
                hideError(fields.address, errorElements.address);
            }
        }

        if (fieldName === 'all' || fieldName === 'timezone') {
            if (!fields.timezone?.value) {
                showError(fields.timezone, errorElements.timezone);
                isValid = false;
            } else {
                hideError(fields.timezone, errorElements.timezone);
            }
        }

        if (fieldName === 'all' || fieldName === 'date') {
            if (!selectedDate) {
                errorElements.date.style.display = 'block';
                isValid = false;
            } else {
                errorElements.date.style.display = 'none';
            }
        }

        if (fieldName === 'all' || fieldName === 'time') {
            if (!selectedTime || fields.time?.textContent === 'Not selected') {
                errorElements.time.style.display = 'block';
                isValid = false;
            } else {
                errorElements.time.style.display = 'none';
            }
        }

        return isValid;
    }

    function showError(field, errorElement) {
        if (field && errorElement) {
            field.classList.add('error-field');
            errorElement.style.display = 'block';
        }
    }

    function hideError(field, errorElement) {
        if (field && errorElement) {
            field.classList.remove('error-field');
            errorElement.style.display = 'none';
        }
    }

    // Initialize time slots for today's date
    const today = new Date().toISOString().split('T')[0];
    selectedDate = today;
    updateAvailableTimeSlots(today);

    // Update address preview when address is entered
    const addressInput = document.getElementById('address');
    const addressPreview = document.getElementById('address-in-services');
    
    if (addressInput && addressPreview) {
        addressInput.addEventListener('input', function() {
            addressPreview.textContent = this.value || 'N/A';
        });
    }

    // Handle form submission
    document.getElementById('book-now-btn').addEventListener('click', function() {
        if (validateField('all')) {
            const eventName = document.querySelector('.services-section p:first-child').textContent.split(':')[1].trim();
            
            const bookingData = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                event_name: eventName,
                date: selectedDate,
                time: selectedTime,
                timezone: document.getElementById('timezone').value,
                address: document.getElementById('address').value.trim(),
                hours: requiredHours
            };
            
            fetch('booking_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(bookingData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Your booking request has been Sent successfully. A confirmation email has been sent to your email address. Please check your inbox for further details.');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to process booking'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing your booking.');
            });
        }
    });
});
</script>
</body>
</html>
