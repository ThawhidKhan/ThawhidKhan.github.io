<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/myStyle.css">
</head>

<body>

    <?php
        $servername = "localhost";
        $username = "id21647095_uddinaqdb";
        $password = "Uddinaq@123";
        $dbname = "id21647095_uddinaqdb";
        $table = "students";
        $availableSeatsTable = "available_seats";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $errors = [];

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize form data
            $umid = validateUMID($_POST["umid"]);
            $firstName = validateAlphaInput($_POST["firstName"]);
            $lastName = validateAlphaInput($_POST["lastName"]);
            $projectTitle = validateInput($_POST["projectTitle"]);
            $emailAddress = validateEmail($_POST["emailAddress"]);
            $phoneNumber = validatePhoneNumber($_POST["phoneNumber"]);
            $timeSlot = validateInput($_POST["timeSlot"]);
            // Check if UMID is unique
            if (!isUMIDUnique($umid)) {
                $errors[] = "UMID '$umid' already exists. Please use a different UMID.";
            }

        // Check for errors
        if (count($errors) === 0) {
            // Get the selected time slot and update available seats
            $selectedTimeSlot = $timeSlot;

            // Fetch current available seats for the selected time slot
            $query = "SELECT available_seats FROM $availableSeatsTable WHERE time_slot = '$selectedTimeSlot'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $availableSeats = $row['available_seats'];

                // Check if there are available seats
                if ($availableSeats > 0) {
                    // Decrement available seats by 1
                    $availableSeats--;

                    // Update the database with the new available seats count
                    $updateQuery = "UPDATE $availableSeatsTable SET available_seats = $availableSeats WHERE time_slot = '$selectedTimeSlot'";
                    if (mysqli_query($conn, $updateQuery)) {
                        // Insert data into the "students" table
                        $insertSql = "INSERT INTO $table (UMID, FirstName, LastName, ProjectTitle, EmailAddress, PhoneNumber, TimeSlot) VALUES ('$umid', '$firstName', '$lastName', '$projectTitle', '$emailAddress', '$phoneNumber', '$timeSlot')";

                       if (mysqli_query($conn, $insertSql)) {
                        $successMessage = "New record added successfully";
                        // Display success message in Bootstrap alert
                        echo '<div class="alert alert-success text-center" role="alert">';
                        echo $successMessage;
                        echo '</div>';
                        // Add a button to navigate to index.php
                        echo '<div class="text-center mt-3">';
                        echo '<a href="index.php" class="btn btn-primary">Go to Home Page</a>';
                        echo '</div>';
                        exit();
                        } else {
                        handleQueryError($insertSql);
                        }
                    } else {
                        handleQueryError($updateQuery);
                    }
                } else {
                    $errors[] = "No available seats for the selected time slot.";
                }
            } else {
                handleQueryError($query);
            }
        }
    }

    // Function to validate and sanitize input
    function validateInput($input) {
        return htmlspecialchars(trim($input));
    }

    // Function to validate alpha input
    function validateAlphaInput($input) {
        $input = validateInput($input);
        if (!preg_match("/^[a-zA-Z]+$/", $input)) {
            global $errors;
            $errors[] = "Invalid input: $input. Please use only alphabetic characters.";
        }
        return $input;
    }

    // Function to validate email
    function validateEmail($email) {
        $email = validateInput($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            global $errors;
            $errors[] = "Invalid email address: $email.";
        }
        return $email;
    }

    // Function to validate phone number
    function validatePhoneNumber($phoneNumber) {
        $phoneNumber = validateInput($phoneNumber);
        if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phoneNumber)) {
            global $errors;
            $errors[] = "Invalid phone number: $phoneNumber. Please use the format 999-999-9999.";
        }
        return $phoneNumber;
    }

    // Function to handle query errors
    function handleQueryError($query)
    {
        global $conn;
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        exit();
    }

    // Function to check if UMID already exists in the database
        function isUMIDUnique($umid) {
            global $conn, $table;
            $query = "SELECT UMID FROM $table WHERE UMID = '$umid'";
            $result = mysqli_query($conn, $query);

            return mysqli_num_rows($result) === 0; // Returns true if UMID is unique
        }

        // Function to validate and sanitize UMID input
        function validateUMID($umid) {
            // Check if UMID is 8 digits and only contains digits
            if (!preg_match("/^\d{8}$/", $umid)) {
                global $errors;
                $errors[] = "Invalid UMID: $umid. UMID must be 8 digits and only contain digits.";
                return ''; // Return an empty string to indicate an error
            }

            // Return the sanitized UMID
            return htmlspecialchars(trim($umid));
        }

    ?>


    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="./assets/images/logo.png" class='w-25' alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./registerStudent.php">Project Demo Registration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./registerStudent.php">Student Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Display errors in an alert -->


    <section class='mt-4'>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <?php
                        if (count($errors) > 0) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                            echo '<strong>Error!</strong> There are issues with the submitted data. Please check the following:';
                            echo '<ul>';
                            foreach ($errors as $error) {
                                echo '<li>' . $error . '</li>';
                            }
                            echo '</ul>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-8 offset-md-2">

                    <div class="card">
                        <h1 class='mb-4 ms-3'>Register Student</h1>
                        <div class="card-body">
                            <!-- Form to insert data -->
                            <!-- Form to insert data -->
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="umid" class="form-label">UMID</label>
                                    <input type="text" class="form-control" id="umid" name="umid"
                                        value="<?php echo isset($umid) ? $umid : ''; ?>" maxlength="8"
                                        oninput="validateUMID(this)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                        value="<?php echo isset($firstName) ? $firstName : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                        value="<?php echo isset($lastName) ? $lastName : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="projectTitle" class="form-label">Project Title</label>
                                    <input type="text" class="form-control" id="projectTitle" name="projectTitle"
                                        value="<?php echo isset($projectTitle) ? $projectTitle : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emailAddress" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="emailAddress" name="emailAddress"
                                        value="<?php echo isset($emailAddress) ? $emailAddress : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                                        value="<?php echo isset($phoneNumber) ? $phoneNumber : ''; ?>" required
                                        oninput="formatPhoneNumber(this)">
                                </div>
                                <div class="mb-3">
                                    <label for="timeSlot" class="form-label">Time Slot Available</label>
                                    <?php
                                    // Fetch available time slots and seats from the database
                                    $query = "SELECT time_slot, available_seats FROM $availableSeatsTable";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        echo '<select class="form-select" id="timeSlot" name="timeSlot" required>';
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $option = $row['time_slot'];
                                            $seats = $row['available_seats'];
                                            $selected = isset($timeSlot) && $timeSlot == $option ? 'selected' : '';
                                            echo "<option value=\"$option\" data-seats=\"$seats\" $selected>$option, $seats seats remaining</option>";
                                        }
                                        echo '</select>';
                                    } else {
                                        echo "Error fetching time slots: " . mysqli_error($conn);
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src='./assets/js/bootstrap.bundle.min.js'></script>
    <script src='./assets/js/main.js'></script>
</body>

</html>