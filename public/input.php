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