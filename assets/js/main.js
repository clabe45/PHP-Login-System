window.addEventListener('load', function() {
  // refresh loop
  (function refresh() {
    if (document.getElementById('search-box')) // user is logged in
      updateNumbNotifications();

    setTimeout(refresh, 4000);
  })();

  /*
   *  FOR header.php
   */
  var searchBox = document.getElementById('search-box');
  searchBox && searchBox.addEventListener('input', function() {
    var data = new Object();
    data.search = this.value;
    if (document.getElementById('search-users').checked) {
      data.type = 'user';
    } else {
      alert('error in main.js');
    }
    ajax('search.php', data)

    .then(function(response) {
      // show and reset innerHTML
      var searchResults = document.getElementById('search-results');
      searchResults.style.display = 'inline';
      while (searchResults.hasChildNodes()) {
        searchResults.removeChild(searchResults.lastChild);
      }
      if (data.search.length > 0) {  // don't search empty string
        for (var i=0; i<response.length; i++) {
          var user = response[i];
          var child = document.createElement('a');  // search result div
          child.className = 'search-result';
          child.href = 'profile.php?user_id='+user.user_id;
          child.innerHTML = user.username;
          searchResults.appendChild(child);
        }
      }
    });
  });

  var notifLink = document.getElementById('notifications-count');
  if (notifLink && !(notifLink.innerHTML*1)) notifLink.className += notifLink.className?' ':'' + 'dull';
  var notifBox = document.getElementById('notifications-box');
  notifLink && notifLink.addEventListener('click', function() {
    notifBox.style.display = 'block';
    notifBox.focus();
    getUser().then(function(user) {
      ajax('view_all_notifications.php', {}); // make all notifications "viewed" by updating user's last_time_viewed_notifications
    });
    updateNumbNotifications();
  });
  document.body.addEventListener('click', function(e) {
    if (notifBox && !notifBox.contains(e.target) && !notifLink.contains(e.target)) {
      // click is outside
      notifBox.style.display = 'none';
    }
  });
  /*notifBox.addEventListener('focusout', function() {
    this.style.display = 'none';
  }, /* useCapturing** true);*/
  if (notifBox) notifBox.style.display = 'none';

  // add event listeners (hard to this in html because it needs to pass event)
  var links = notifBox ? notifBox.getElementsByTagName('a') : [];
  for (var i=0; i<links.length; i++) {
    links[i].addEventListener('click', viewNotification);
  }

  function updateNumbNotifications() {
    ajax('unviewed_notifications.php', {}).then(function(response) {
      notifLink.innerHTML = response.count;
      if (response.count == 0 && notifLink.className.indexOf('dull')===-1) notifLink.className += notifLink.className?' ':'' + 'dull';
      else if (response.count > 0) notifLink.className = notifLink.className.replace(/ ?dull/, '');
    });
  }

  function viewNotification(event) {
    ajax('click_notification.php', /*notification id*/{notification_id: event.target.dataset.id})     // first register notification view
    .then(function() {
      window.location.replace(event.target.dataset.href);     // and *then* redirect the user (programmatically)
    });
  }
});
