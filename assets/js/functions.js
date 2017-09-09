function showError(message) {
  var errorDiv = document.getElementsByClassName('error')[0];
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
  var successDiv = document.getElementsByClassName('success')[0];
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
