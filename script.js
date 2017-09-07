window.addEventListener('load', function() {
  var contentArea = document.getElementById('content-area');
  (function refresh() {
    var request;
    if (window.XMLHttpRequest) // newer browsers
      request = new XMLHttpRequest();
    else if (window.ActiveXObject)  // older versions of IE
      request = new ActiveXObject("Microsoft.XMLHTTP");

    request.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          contentArea.innerHTML = this.responseText;
        } else {
          throw new Error('Error fetching data: error ' + this.status);
        }
      }
    }
    request.open('GET', 'inc/functions', true);
    // request.send();

    setTimeout(refresh, 4000);
  })();
});
