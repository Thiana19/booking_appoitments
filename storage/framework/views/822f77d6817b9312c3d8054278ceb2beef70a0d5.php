<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Adjusted the asset URL for CSS -->
    <link href="<?php echo e(asset('css/home.css')); ?>" rel="stylesheet">
</head>
<body>
    <div class="card">
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
                <form id="appointmentForm" method="POST">
                    <!-- Adjusted the name attribute for consistency -->
                    <div class="form-group">
                        <input type="text" name="full_name" class="form-control" placeholder="Enter Name" required="" id="name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="passportNo" name="passportNo" placeholder="Enter Passport No" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="phoneNo" name="phoneNo" placeholder="Enter Phone No" required>
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
                </form>
            </div>
            <div class="col-md-6">
                <h2 class="sub-title-2">Confirm Your Booking</h2>
                <div id="bookingDetails"></div>
                <!-- Adjusted the onclick attribute to trigger the form submission -->
                <button id="submitBtn" class="submit-btn" onclick="submitForm()" style="display: none;">Submit</button>
            </div>
        </div>
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

        // Construct booking details HTML
        let bookingDetailsHTML = `
            <div style="margin-bottom: 10px;"><strong>Name: </strong><span style="color: black;">${formData.get('full_name')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Passport No: </strong><span style="color: black;">${formData.get('passportNo')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Phone No: </strong><span style="color: black;">${formData.get('phoneNo')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Email Address: </strong><span style="color: black;">${formData.get('email')}</span></div>
            <div style="margin-bottom: 10px;"><strong>Appointment Date: </strong><span style="color: black;">${appointmentDate}</span></div>
            <div style="margin-bottom: 10px;"><strong>Appointment Time: </strong><span style="color: black;">${selectedTime}</span></div>
            <div style="margin-bottom: 10px;"><strong>Reason for Visit: </strong><span style="color: black;">${formData.get('reason')}</span></div>
        `;

        // Display booking details
        document.getElementById('bookingDetails').innerHTML = bookingDetailsHTML;

        // Show or hide the submit button based on whether booking details are present
        const submitBtn = document.getElementById('submitBtn');
        if (bookingDetailsHTML.trim() !== '') {
            submitBtn.style.display = 'block';
        } else {
            submitBtn.style.display = 'none';
        }
    }

    function submitForm() {
    const formData = new FormData(document.getElementById('appointmentForm'));

    // Get selected time
    const selectedTime = document.querySelector('.time-btn.selected') ? document.querySelector('.time-btn.selected').dataset.time : '';
    
    // Get appointment date
    const appointmentDate = appointmentDateInput.value;

    // Append time and date to formData
    formData.append('appt_time', selectedTime);
    formData.append('appt_date', appointmentDate);

    // Get CSRF token from meta tag
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    // Send appointment data to the server using AJAX
    fetch('<?php echo e(route("appointments.store")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            // Appointment booked successfully
            alert('Appointment booked successfully!');
            // Redirect or perform any other actions as needed
        } else {
            // Error handling if the request fails
            alert('Failed to book appointment. Please try again later.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
}


</script>
</html>

<?php /**PATH C:\Users\cisse.t\Desktop\laravel\booking-appointment\resources\views/welcome.blade.php ENDPATH**/ ?>