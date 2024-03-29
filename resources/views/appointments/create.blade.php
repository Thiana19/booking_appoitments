<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Adjusted the asset URL for CSS -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
    <div class="tabs">
        <button class="tab" onclick="openTab('user')">User</button>
        <button class="tab" onclick="openTab('admin')">Admin</button>
    </div>


    <div class="user-card card" id="user-card">
        <div class="card-body">
            <h1 class="title">Book Your Appointment Now!</h1>
            <hr class="divider">
            <!-- Date and time card -->
            <div class="card-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row-3">
                                <h2 class="sub-title">Select Your Date & Time</h2>
                                <!-- Added an ID to the date input -->
                                <input type="date" class="date" id="appt_date">
                            </div>
                            <hr class="divider-2">
                            <div class="time-buttons">
                                <button class="btn time-btn" data-time="9am">9am</button>
                                <button class="btn time-btn" data-time="10:30am">10:30am</button>
                                <button class="btn time-btn" data-time="12pm">12pm</button>
                                <button class="btn time-btn" data-time="2pm">2pm</button>
                                <button class="btn time-btn" data-time="3:30pm">3:30pm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-2">
            <div class="col-md-6">
                <h2 class="sub-title">Appointment Form</h2>
                <!-- <hr class="divider-2"> -->
                <form id="appointmentForm" method="POST" action="{{ route('appointments.store') }}">
                    @csrf 
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required="" id="name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="passportNo" name="passport_no" placeholder="Enter Passport No" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="phoneNo" name="phone_no" placeholder="Enter Phone No" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                        <select class="dropdown" id="reason" name="reason" required>
                            <option value="" disabled selected>--Select Reason for Visit--</option>
                            <option value="Passport Renewal">Passport Renewal</option>
                            <option value="Document Request">Document Request</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <!-- Hidden input fields for appointment date and time -->
                    <input type="hidden" name="appt_date" id="appointment_date">
                    <input type="hidden" name="appt_time" id="appointment_time">
                    <!-- Submit button -->
                    <button type="button" id="submitBtn" class="submit-btn" onclick="submitForm()">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2 class="sub-title-2">Confirm Your Booking</h2>
                <div id="bookingDetails"></div>
            </div>
        </div>
    </div>

    <!-- Admin card -->
    <div class="admin-card card" id="admin-card">
        <h1>Login</h1>
        <div class="form-group-login">
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <input type="text" name="username" placeholder="Username">
                @error('username')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group-login">
                <input type="password" name="password" placeholder="Password">
                @error('error')
                    <span class="text-danger" style="color: red;">{{ $message }}</span>
                @enderror
        </div>
        <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>

<script>
    const timeButtons = document.querySelectorAll('.time-btn');
    const appointmentDateInput = document.querySelector('.date');

    // Add event listener to each button
    timeButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Deselect all buttons
            timeButtons.forEach(btn => {
                btn.classList.remove('selected');
            });
            // Select the clicked button
            button.classList.add('selected');
            // Update booking details
            displayBookingDetails();
        });
    });

    // Add event listener to form input change
    const formInputs = document.querySelectorAll('#appointmentForm input, #appointmentForm select');
    formInputs.forEach(input => {
        input.addEventListener('input', () => {
            displayBookingDetails();
        });
    });

    // Add event listener for date input change
    appointmentDateInput.addEventListener('input', () => {
        displayBookingDetails();
    });

    function displayBookingDetails() {
        // Get form data
        const formData = new FormData(document.getElementById('appointmentForm'));

        // Get selected time
        const selectedTime = document.querySelector('.time-btn.selected') ? document.querySelector('.time-btn.selected').dataset.time : '';

        // Get appointment date
        const appointmentDate = appointmentDateInput.value;

        // Populate hidden fields with appointment date and time
        document.getElementById('appointment_date').value = appointmentDate;
        document.getElementById('appointment_time').value = selectedTime;

        // Construct booking details HTML
        let bookingDetailsHTML = `
            <div style="margin-bottom: 10px;"><strong>Name: </strong><span style="color: black;">${formData.get('name')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Passport No: </strong><span style="color: black;">${formData.get('passport_no')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Phone No: </strong><span style="color: black;">${formData.get('phone_no')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Email Address: </strong><span style="color: black;">${formData.get('email')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Appointment Date: </strong><span style="color: black;">${appointmentDate}</span></div>
            <div style="margin-bottom: 10px;"><strong>Appointment Time: </strong><span style="color: black;">${selectedTime}</span></div>
            <div style="margin-bottom: 10px;"><strong>Reason for Visit: </strong><span style="color: black;">${formData.get('reason')}</span></div>
        `;

        // Display booking details
        document.getElementById('bookingDetails').innerHTML = bookingDetailsHTML;
    }

    // Function to submit the form
    function submitForm() {
        document.getElementById('appointmentForm').submit();
        alert("Your request has been successfully sent. You will receive an email for confirmation later.")
    }

    // JavaScript function to switch between tabs
    function openTab(tabName) {
        var i;
        var userCard = document.getElementById("user-card");
        var adminCard = document.getElementById("admin-card");
        var tabs = document.getElementsByClassName("tab");

        if (tabName === 'user') {
            userCard.style.display = "block";
            adminCard.style.display = "none";
            // Activate user tab
            tabs[0].classList.add("active");
            tabs[1].classList.remove("active");
        } else if (tabName === 'admin') {
            userCard.style.display = "none";
            adminCard.style.display = "block";
            // Activate admin tab
            tabs[0].classList.remove("active");
            tabs[1].classList.add("active");
        }
    }

    // Call openTab function with default tab
    openTab('user'); 

    // Check if there's an error message displayed, if so, stay in the admin tab
    window.addEventListener('DOMContentLoaded', (event) => {
        const errorMessage = document.querySelector('.text-danger');
        if (errorMessage) {
            openTab('admin');
            // Hide the error message after 5 seconds
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }
    });
</script>

</html>
