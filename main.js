function validateForm() {
    // Validate first name (alpha characters only)
    var firstName = document.forms["registrationForm"]["firstName"].value;
    if (!/^[a-zA-Z]+$/.test(firstName)) {
        alert("First name should consist of alpha letters only");
        return false;
    }

    // Validate last name (alpha characters only)
    var lastName = document.forms["registrationForm"]["lastName"].value;
    if (!/^[a-zA-Z]+$/.test(lastName)) {
        alert("Last name should consist of alpha letters only");
        return false;
    }

    // Validate ID (8 digits)
    var umid = document.forms["registrationForm"]["umid"].value;
    if (!/^\d{8}$/.test(umid)) {
        alert("ID must be 8 digits");
        return false;
    }

    // Validate email
    var email = document.forms["registrationForm"]["emailAddress"].value;
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
        alert("Invalid email address");
        return false;
    }

    // Validate phone number (999-999-9999)
    var phoneNumber = document.forms["registrationForm"]["phoneNumber"].value;
    if (!/^\d{3}-\d{3}-\d{4}$/.test(phoneNumber)) {
        alert("Phone number should be in the format 999-999-9999");
        return false;
    }

    // Continue with other validations as needed...

    return true;
}

// Delete Record
function deleteRecord(umid) {
    // Perform AJAX request to delete the record
    $.ajax({
        type: "POST",
        url: "delete_record.php", // Change this to the actual server-side script handling the deletion
        data: {
            delete_umid: umid
        },
        success: function (response) {
            // Update the table content
            $("#student-table-body").html(response);
            // Show a success message (you can customize this part)
            showAlert("Record deleted successfully.", "alert-success");
        },
        error: function (xhr, status, error) {
            // Show an error message (you can customize this part)
            showAlert("Error deleting record: " + xhr.responseText, "alert-danger");
        }
    });
}

function showAlert(message, alertClass) {
    // Display alert message
    $(".alert").remove(); // Remove existing alerts
    var alertHTML = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">';
    alertHTML += '<strong>Message:</strong> ' + message;
    alertHTML += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    alertHTML += '</div>';
    $(".card-body").prepend(alertHTML);
}


function validateUMID(input) {
    // Allow only numeric input (0-9)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limit the input to 8 digits
    if (input.value.length > 8) {
        input.value = input.value.slice(0, 8);
    }
}


function formatPhoneNumber(input) {
    // Remove non-numeric characters
    let phoneNumber = input.value.replace(/\D/g, '');

    // Apply formatting (999-999-9999)
    if (phoneNumber.length >= 3 && phoneNumber.length <= 10) {
        phoneNumber = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    }

    // Update the input value
    input.value = phoneNumber;

    // Restrict the input to a maximum length of 12 characters (including hyphens)
    if (input.value.length > 12) {
        input.value = input.value.slice(0, 12);
    }
}