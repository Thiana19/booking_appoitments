<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet">
</head>
<body>
    <!-- Log out button -->
    <a href="<?php echo e(route('appointments.create')); ?>" class="logout-btn">
        <img src="<?php echo e(asset('images/shutdown.png')); ?>" alt="Logout Icon" width="30" height="30">
    </a>

    <!-- tabs -->
    <div class="tabs">
        <button class="tab active" onclick="openTab('pending')">Pending</button>
        <button class="tab" onclick="openTab('approved')">Approved</button>
        <button class="tab" onclick="openTab('rejected')">Rejected</button>
    </div>

    <!-- Tab content -->
    <div id="pending" class="tabcontent">
        <h2>Pending Appointments</h2>
        <?php $__currentLoopData = $pendingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="appointment-card">
            <div class="appointment-details">
                <p><strong>Name:</strong> <?php echo e($appointment->name); ?></p>
                <p><strong>Passport No:</strong> <?php echo e($appointment->passport_no); ?></p>
                <p><strong>Email:</strong> <?php echo e($appointment->email); ?></p>
                <p><strong>Appointment Date:</strong> <?php echo e($appointment->appt_date); ?></p>
                <p><strong>Appointment Time:</strong> <?php echo e($appointment->appt_time); ?></p>
                <p><strong>Reason:</strong> <?php echo e($appointment->reason); ?></p>
            </div>
            <div class="actions">
            <form action="<?php echo e(route('appointments.updateStatus', $appointment->id)); ?>" method="POST" class="status-form">
                <?php echo csrf_field(); ?>
                <button type="submit" name="status" value="approved" class="approve-btn">Approve</button>
            </form>

            <form action="<?php echo e(route('appointments.updateStatus', $appointment->id)); ?>" method="POST" class="status-form">
                <?php echo csrf_field(); ?>
                <button type="submit" name="status" value="rejected" class="reject-btn">Reject</button>
            </form>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


    <div id="approved" class="tabcontent">
        <h2>Approved Appointments</h2>
        <?php $__currentLoopData = $approvedAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="appointment-card">
            <div class="appointment-details">
                <p><strong>Name:</strong> <?php echo e($appointment->name); ?></p>
                <p><strong>Passport No:</strong> <?php echo e($appointment->passport_no); ?></p>
                <p><strong>Email:</strong> <?php echo e($appointment->email); ?></p>
                <p><strong>Appointment Date:</strong> <?php echo e($appointment->appt_date); ?></p>
                <p><strong>Appointment Time:</strong> <?php echo e($appointment->appt_time); ?></p>
                <p><strong>Reason:</strong> <?php echo e($appointment->reason); ?></p>
            </div>
            <div class="actions">
                <img src="<?php echo e(asset('images/checked.png')); ?>" alt="" width="100" height="100">
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div id="rejected" class="tabcontent">
        <h2>Rejected Appointments</h2>
        <?php $__currentLoopData = $rejectedAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="appointment-card">
            <div class="appointment-details">
                <p><strong>Name:</strong> <?php echo e($appointment->name); ?></p>
                <p><strong>Passport No:</strong> <?php echo e($appointment->passport_no); ?></p>
                <p><strong>Email:</strong> <?php echo e($appointment->email); ?></p>
                <p><strong>Appointment Date:</strong> <?php echo e($appointment->appt_date); ?></p>
                <p><strong>Appointment Time:</strong> <?php echo e($appointment->appt_time); ?></p>
                <p><strong>Reason:</strong> <?php echo e($appointment->reason); ?></p>
            </div>
            <div class="actions">
                <img src="<?php echo e(asset('images/remove.png')); ?>" alt="" width="100" height="100">
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- JavaScript to switch tabs -->
    <script>
        function openTab(tabName) {
            var i;
            var tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";

            var tabs = document.getElementsByClassName("tab");
            for (i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }

            event.currentTarget.classList.add("active");
        }

        function updateStatus(appointmentId, status) {
        fetch(`/appointments/${appointmentId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Reload the page to update the appointments
            location.reload();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    </script>
</body>
</html>
<?php /**PATH C:\Users\cisse.t\Desktop\laravel\booking-appointment\resources\views/dashboard.blade.php ENDPATH**/ ?>