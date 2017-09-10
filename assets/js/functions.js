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
