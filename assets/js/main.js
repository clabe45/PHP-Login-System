window.addEventListener('load', function() {
  // refresh loop
  /*(function refresh() {
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
  })();*/

  // for content from header.php
  document.getElementById('search-box').addEventListener('input', function() {
    var searchResults = document.getElementById('search-results');
    var request;
    if (window.XMLHttpRequest) // newer browsers
      request = new XMLHttpRequest();
    else if (window.ActiveXObject)  // older versions of IE
      request = new ActiveXObject("Microsoft.XMLHTTP");
    request.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          // success
          // show and reset innerHTML
          searchResults.style.display = 'inline';
          while (searchResults.hasChildNodes()) {
            searchResults.removeChild(searchResults.lastChild);
          }
          if (data.search.length > 0) {  // don't search empty string

            var response;
            try {
              response = JSON.parse(this.responseText);  // parsed result (array, in this case)
            } catch (e) {
              document.write(this.responseText);  // error formatted as HTML (From PHP)
            }
            for (var i=0; i<response.length; i++) {
              var user = response[i];
              var child = document.createElement('a');  // search result div
              child.className = 'search-result';
              child.href = 'profile.php?user_id='+user.user_id;
              child.innerHTML = user.username;
              searchResults.appendChild(child);
            }
          }
        } else {
          // error
        }
      }
    };

    var data = new Object();
    data.search = this.value;
    if (document.getElementById('search-users').checked) {
      data.type = 'user';
    } else {
      alert('error in main.js');
    }

    request.open('POST', 'ajax/search.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    request.send(JSON.stringify(data)); // send post data as json (don't worry, my PHP code will handle it)
  });
});
