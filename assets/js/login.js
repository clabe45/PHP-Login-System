window.addEventListener('load', function() {
  var loginForm = document.getElementById('login-form');

  loginForm.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    var table = this.children[0]; // <table>
    var successDiv = this.children[1]; // <div class="success">
    var errorDiv = this.children[2];  // <div class="error">

    var data = {
      usernameOrEmail: table.getElementsByTagName('input')[0].value,
      password: table.getElementsByTagName('input')[1].value,
    };

    successDiv.style.display = 'none';
    errorDiv.style.display = 'none';

    // no form validation

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
             * redirect
             * (prepend root directory, because we're on localhost)
             */
            if (response.redirect) {
              window.location.replace(response.redirect);
            }
          }
        } else {
          showError('Error comminucating with server: error ' + this.status);
        }
      }
    };
    request.open('POST', 'ajax/login.php', true);
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
