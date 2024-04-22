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

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Select data from the "students" table
        $sql = "SELECT * FROM $table";
        $result = mysqli_query($conn, $sql);
        
        // Handle record deletion
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_umid"])) {
            $umid_to_delete = $_POST["delete_umid"];
        
            // Perform delete query
            $delete_query = "DELETE FROM $table WHERE UMID = '$umid_to_delete'";
            if (mysqli_query($conn, $delete_query)) {
                $alert_message = "Record deleted successfully.";
                $alert_class = "alert-success";
            } else {
                $alert_message = "Error deleting record: " . mysqli_error($conn);
                $alert_class = "alert-danger";
            }
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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

    <section class='mt-4'>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        // Display alert message if set
                        if (isset($alert_message)) {
                            echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
                            echo '<strong>Message:</strong> ' . $alert_message;
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h1 class='mb-4'>Registered Students</h1>
                            <table class="table" id="student-table-body">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">UMID</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Project Title</th>
                                        <th scope="col">Email Address</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Time Slot</th>
                                        <!-- <th scope="col">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Check if there are any results
                                        if (mysqli_num_rows($result) > 0) {
                                            // Output data for each row
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<th scope="row">' . $row["UMID"] . '</th>';
                                                echo '<td>' . $row["FirstName"] . '</td>';
                                                echo '<td>' . $row["LastName"] . '</td>';
                                                echo '<td>' . $row["ProjectTitle"] . '</td>';
                                                echo '<td>' . $row["EmailAddress"] . '</td>';
                                                echo '<td>' . $row["PhoneNumber"] . '</td>';
                                                echo '<td>' . $row["TimeSlot"] . '</td>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="8">No data found</td></tr>';
                                        }

                                        // Close the connection
                                        mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src='./assets/js/bootstrap.bundle.min.js'></script>
    <script src='./assets/js/main.js'></script>
</body>

</html>