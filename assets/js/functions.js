// stolen from https://stackoverflow.com/a/901144/3783155
function getParameterByName(name) {
  var url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return null;
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// shorthand for writing AJAX request out
function ajax(filename, data) {
  return new Promise(function(resolve, reject) {
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
            console.log("error parsing response json");
            reject && reject(this.responseText);
          }
          if (response.error) showError(response.error);
          else {
            resolve && resolve(response);
            if (response.reload) location.reload();
            /*
             * redirect if necessary
             * (prepend root directory, because we're on localhost)
             */
            if (response.redirect) {
              window.location.replace(response.redirect);
            }
          }
        } else {
          showError('Error sending data: error' + this.status);
          reject && reject();
        }
      }
    };
    request.open('POST', 'ajax/' + filename, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    request.send(JSON.stringify(data)); // send post data as json (don't worry, my PHP code will handle it)
  });
}

function getUser() {
  return ajax('get_user.php');      // returns a promise
}

/** Messages UI */

var infoDivIndex = 0; // which divs to use for the following methods

function showError(message) {
  var errorDiv = document.getElementsByClassName('error')[infoDivIndex];
  if (errorDiv.tagName !== 'DIV') {
    throw new Error('Bad .error element');
    return;
  }
  errorDiv.innerHTML = message;
  errorDiv.style.display = 'block';

  setTimeout(function() {
    errorDiv.style.display = 'none';
  }, 100*message.length);
}
function showSuccess(message) {
  var successDiv = document.getElementsByClassName('success')[infoDivIndex];
  if (successDiv.tagName !== 'DIV') {
    throw new Error('Bad .success element');
    return;
  }
  successDiv.innerHTML =  message;
  successDiv.style.display = 'block';

  setTimeout(function() {
    successDiv.style.display = 'none';
  }, 100*message.length);
}
