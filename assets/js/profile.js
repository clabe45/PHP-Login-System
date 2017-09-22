function modifyFriendship(action_url) {
  ajax(action_url, {
    friend_id: getParameterByName('user_id')
  })
}
