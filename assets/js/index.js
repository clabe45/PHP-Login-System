window.addEventListener('load', function() {
  var successDiv = document.getElementsByClassName('success')[0];
  console.log(successDiv, successDiv.innerHTML, successDiv.innerHTML.length, !!successDiv.innerHTML);
  if (successDiv.innerHTML) {
    successDiv.style.display = 'block';
    setTimeout(function() {
      successDiv.style.display = 'none';
    }, 100*successDiv.innerHTML.length);  // similar to showSuccess function in script.js
  }
});
