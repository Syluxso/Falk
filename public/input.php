<!DOCTYPE html>
<html>
<head>
    <title>Opt In Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <style>
      .error {
          color:red;  z-index:0; position:relative; display:block; text-align: left; }
  </style>
  <script>
        $(document).ready(function() {
            $("#optin-form").validate({
              errorPlacement: function(error, element) {
                $(element).parents(".input-group-parent").append(error)
              },
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
                  var root = "https://falk.syworks.test";
                  var url = root + "/api/optinrequest.php";
                  $.ajax({
                      type: "POST",
                      url: url,
                      data: $(form).serialize(),
                      success: function(success) {
                        console.log(success);
                        alert("Form submitted successfully!");
                        form.reset();
                      },
                      error: function() {
                        console.log(url);
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
<br />
<br />
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-md-offset-4">
        <div class="well">
          <form id="optin-form">
            <h1>Opt In Form</h1>
            <div class="input-group-parent">
              <div class="input-group">
                <input type="text" id="phone" name="phone" placeholder="Enter phone number" class="form-control">
                <span class="input-group-addon" id="basic-addon1">Phone</span>
              </div>
            </div>
            <br />
            <div class="input-group-parent">
              <div class="input-group">
                <input type="text" id="site_id" name="site_id" placeholder="Enter site ID" class="form-control">
                <span class="input-group-addon" id="basic-addon1">Site ID</span>
              </div>
            </div>
            <br />
            <div class="input-group-parent">
              <div class="input-group">
                <input type="text" id="site_name" name="site_name" placeholder="Enter site name" class="form-control">
                <span class="input-group-addon" id="basic-addon1">Site Name</span>
              </div>
            </div>
            <br />

            <input type="submit" value="Submit" class="btn btn-block btn-success">
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    const isNumericInput = (event) => {
      const key = event.keyCode;
      return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
      );
    };

    const isModifierKey = (event) => {
      const key = event.keyCode;
      return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
          // Allow Ctrl/Command + A,C,V,X,Z
          (event.ctrlKey === true || event.metaKey === true) &&
          (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
    };

    const enforceFormat = (event) => {
      // Input must be of a valid number format or a modifier key, and not longer than ten digits
      if(!isNumericInput(event) && !isModifierKey(event)){
        event.preventDefault();
      }
    };

    const formatToPhone = (event) => {
      if(isModifierKey(event)) {return;}

      const input = event.target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
      const areaCode = input.substring(0,3);
      const middle = input.substring(3,6);
      const last = input.substring(6,10);

      if(input.length > 6){event.target.value = `(${areaCode}) ${middle} - ${last}`;}
      else if(input.length > 3){event.target.value = `(${areaCode}) ${middle}`;}
      else if(input.length > 0){event.target.value = `(${areaCode}`;}
    };

    const inputElement = document.getElementById('phone');
    inputElement.addEventListener('keydown',enforceFormat);
    inputElement.addEventListener('keyup',formatToPhone);
  </script>
</body>
</html>