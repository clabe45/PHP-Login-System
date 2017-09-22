window.addEventListener('load', function() {
  /*
   * Edit form
   */
  var editForm = document.getElementById('edit-form');
  editForm.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    var inputs = this.getElementsByTagName('input');
    var data = {
      name: inputs[0].value,
      username: inputs[1].value,
      email: inputs[2].value
    };

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

    // send AJAX
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
              url = url+(url.indexOf('?')===-1 ? '?' : '&' )+'success=edit';  // append 'success' value
              window.location.replace(url);
            }
          }
        } else {
          showError('Error sending data: error' + this.status);
        }
      }
    };
    request.open('POST', 'ajax/edit_profile.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    request.send(JSON.stringify(data)); // send post data as json (don't worry, my PHP code will handle it)
  });

  /*
   * Change password form
   */
  var changePWForm = document.getElementById('change-password-form');
  changePWForm.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    var inputs = this.getElementsByTagName('input');
    var data = {
      current_password: inputs[0].value,
      new_password: inputs[1].value,
      confirm_new_password: inputs[2].value
    };

    infoDivIndex = 1;

    // form validation
    if (data.new_password.length < 11) {
      showError("Please enter a passphrase that is at least <u>11</u> characters long.");
      return;
    }
    if (data.new_password !== data.confirm_new_password) {
      showError("Passwords do not match.");
      return;
    }

    delete data.confirm_new_password; // not needed in AJAX

    // send AJAX
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
              url = url+(url.indexOf('?')===-1 ? '?' : '&' )+'success=changepw';  // append 'success' value
              window.location.replace(url);
            }
          }
        } else {
          showError('Error sending data: error' + this.status);
        }
      }
    };
    request.open('POST', 'ajax/change_password.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    request.send(JSON.stringify(data)); // send post data as json (don't worry, my PHP code will handle it)
  });
});
