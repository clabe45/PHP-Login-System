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

    ajax('user_exists.php', {type: 'username', arg: data.username})
    .then(function(response){
      if (response.error) showError(response.error);
      else {
        ajax('user_exists.php', {type: 'email', arg: data.email})
        .then(function(response){
          if (response.error) showError(response.error);
          else {
            ajax('register.php', data);
          }
        })
      }
    });
  });
});
