window.addEventListener('load', function() {
  var loginForm = document.getElementById('register-form');

  loginForm.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    var table = this.children[0]; // <table>
    var successDiv = this.children[1]; // <div class="success">
    var errorDiv = this.children[2];  // <div class="error">

    var data = {
      name: table.getElementsByTagName('input')[0].value,
      username: table.getElementsByTagName('input')[1].value,
      email: table.getElementsByTagName('input')[2].value,
      password: table.getElementsByTagName('input')[3].value,
      confirm_password: table.getElementsByTagName('input')[4].value
    };

    successDiv.style.display = 'none';
    errorDiv.style.display = 'none';

    // form validation
    if (data.name.split(' ').length != 2) {  // isn't two words
      showError("Please provide your first and last name.");
      return;
    }
    if (!/^[_a-zA-Z0-9]{3,50}$/.test(data.username)) {
      showError(`Please enter a valid username:
        <br> - between 3 and 25 characters long
        <br> - contains only alphanumerical characters and underscores (_)`);
      return;
    }
    if (data.email.length < 6) {
      showError("Please enter a valid email address!");
      return;
    }
    if (data.password.length < 11) {
      showError("Please enter a passphrase that is at least <u>11</u> characters long.");
      return;
    }
    if (data.password !== data.confirm_password) {
      showError("Passwords do not match.");
      return;
    }

    delete data.confirm_password; // not needed in AJAX

    // AJAX
    var request;
    if (window.XMLHttpRequest) // newer browsers
      request = new XMLHttpRequest();
    else if (window.ActiveXObject)  // older versions of IE
      request = new ActiveXObject("Microsoft.XMLHTTP");
    request.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          // success
          var response;
          try {
            response = JSON.parse(this.responseText);  // parsed result
          } catch (e) {
            document.write(this.responseText);
          }
          if (response.error) showError(response.error);
          else {
            /*
             * redirect if necessary
             * (prepend root directory, because we're on localhost)
             */
            if (response.redirect) {
              var url = response.redirect;
              url = url+(url.indexOf('?')===-1 ? '?' : '&' )+'success=register';  // append 'success' switch
              window.location.replace(url);
            }
          }
        } else {
          showError('Error comminucating with server: error ' + this.status);
        }
      }
    };
    request.open('POST', 'ajax/register.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    request.send(JSON.stringify(data)); // send post data as json (don't worry, my PHP code will handle it)

    function showError(message) {
      errorDiv.innerHTML = message;
      errorDiv.style.display = 'block';

      setTimeout(function() {
        errorDiv.style.display = 'none';
      }, 100*message.length);
    }
    function showSuccess(message) {
      successDiv.innerHTML =  message;
      successDiv.style.display = 'block';

      setTimeout(function() {
        successDiv.style.display = 'none';
      }, 100*message.length);
    }
  });
});
