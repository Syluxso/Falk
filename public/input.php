<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Phone Number Form</title>-->
<!--</head>-->
<!--<body>-->
<!--<h1>Phone Number Form</h1>-->
<!--<form id="phoneForm" onsubmit="return validateForm()" method="POST">-->
<!--    <label for="phone">Phone:</label>-->
<!--    <input type="tel" id="phone" name="phone" placeholder="Enter a US phone number" required>-->
<!--    <p id="phoneError" style="color:red; display:none;">Please enter a valid US phone number</p>-->
<!---->
<!--    <label for="siteID">Site ID:</label>-->
<!--    <input type="text" id="siteID" name="siteID" maxlength="255" placeholder="Enter site ID" required>-->
<!---->
<!--    <label for="siteName">Site Name:</label>-->
<!--    <input type="text" id="siteName" name="siteName" placeholder="Enter site name" required>-->
<!---->
<!--    <input type="submit" id="submit" value="Submit" disabled>-->
<!--</form>-->
<!---->
<!--<script>-->
<!--    function validateForm() {-->
<!--        // validate phone number-->
<!--        var phoneInput = document.getElementById("phone").value;-->
<!--        if (!/^(\+1)?([2-9]\d{2}[2-9]\d{6})$/.test(phoneInput)) {-->
<!--            document.getElementById("phoneError").style.display = "block";-->
<!--            return false;-->
<!--        } else {-->
<!--            document.getElementById("phoneError").style.display = "none";-->
<!--        }-->
<!---->
<!--        // enable submit button if either field is valid-->
<!--        var siteIDInput = document.getElementById("siteID").value;-->
<!--        var siteNameInput = document.getElementById("siteName").value;-->
<!--        if (siteIDInput || siteNameInput) {-->
<!--            document.getElementById("submit").disabled = false;-->
<!--        } else {-->
<!--            document.getElementById("submit").disabled = true;-->
<!--            return false;-->
<!--        }-->
<!---->
<!--        // if all fields are valid, submit the form-->
<!--        return true;-->
<!--    }-->
<!---->
<!--    document.getElementById("phoneForm").addEventListener("submit", function(event) {-->
<!--        event.preventDefault(); // prevent default form submission behavior-->
<!---->
<!--        // send SMS message-->
<!--        var phoneInput = document.getElementById("phone").value;-->
<!--        var siteIDInput = document.getElementById("siteID").value;-->
<!--        var siteNameInput = document.getElementById("siteName").value;-->
<!--        var message = "You have opted in to receive SMS messages for " + siteNameInput + ". Site ID: " + siteIDInput;-->
<!--        alert("SMS message sent to " + phoneInput + ":\n\n" + message);-->
<!---->
<!--        // reset form-->
<!--        document.getElementById("phoneForm").reset();-->
<!--        document.getElementById("submit").disabled = true;-->
<!--    });-->
<!--</script>-->
<!--</body>-->
<!--</html>-->

<!DOCTYPE html>
<html>
<head>
    <title>Opt In Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#optin-form").validate({
                rules: {
                    phone: {
                        required: true,
                        phoneUS: true
                    },
                    site_id: {
                        required: true,
                        maxlength: 255
                    },
                    site_name: {
                        required: true
                    }
                },
                messages: {
                    phone: {
                        required: "Please enter a valid US phone number"
                    },
                    site_id: {
                        required: "Please enter a site ID",
                        maxlength: "Site ID must be less than 255 characters"
                    },
                    site_name: {
                        required: "Please enter a site name"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: "/api/optinrequest.php",
                        data: $(form).serialize(),
                        success: function() {
                            alert("Form submitted successfully!");
                            form.reset();
                        },
                        error: function() {
                            alert("An error occurred while submitting the form.");
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</head>
<body>
<h1>Opt In Form</h1>
<form id="optin-form">
    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" placeholder="Enter phone number">
    <br>
    <label for="site_id">Site ID:</label>
    <input type="text" id="site_id" name="site_id" placeholder="Enter site ID">
    <br>
    <label for="site_name">Site Name:</label>
    <input type="text" id="site_name" name="site_name" placeholder="Enter site name">
    <br>
    <input type="submit" value="Submit">
</form>
</body>
</html>