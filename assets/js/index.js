window.addEventListener('load', function() {
  var successDiv = document.getElementsByClassName('success')[0];
  if (successDiv.innerHTML) {
    successDiv.style.display = 'block';
    setTimeout(function() {
      successDiv.style.display = 'none';
    }, 100*successDiv.innerHTML.length);  // similar to showSuccess function in script.js
  }
});
