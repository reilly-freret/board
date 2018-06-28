var currUser;
var currRoom;
var currType = "student";

var dataString = "yo?";
var xmlHttp = new XMLHttpRequest();
xmlHttp.open("POST", "isLogged.php", true);
xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlHttp.addEventListener("load", function(event) {
  var jsonData = JSON.parse(event.target.responseText);
  if (jsonData.success) {
    if (jsonData.userType == "ta") {
      document.getElementById("taStuff").hidden = false;
      document.getElementById("studentJoin").hidden = true;
    }
    currUser = jsonData.username;
    if (jsonData.room) currRoom = jsonData.room;
  } else {
    window.location.replace("login.html")
  }
}, false);
xmlHttp.send(dataString);

function getRoom() {
  var dataString = "yo?";
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "isLogged.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlHttp.addEventListener("load", function(event) {
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.room) {
      currRoom = jsonData.room;
      document.getElementById("currentRoom").innerHTML = currRoom;
      lists.hidden = false;
    }
  }, false);
  xmlHttp.send(dataString);
}

function logout() {
  window.location.replace("logout.php");
}

document.addEventListener("DOMContentLoaded", function() {
  var join = document.getElementById("studentJoinSession");
  var lists = document.getElementById("lists");
  var taJoinRoom = document.getElementById("taJoinRoom");

  taJoinRoom.addEventListener("click", function() {
    joinRoomTa();
    getRoom();
    location.reload();
  })

  join.addEventListener("click", function() {
    joinRoom();
    getRoom();
    location.reload();
  })
})

window.onload = function() {
  getRoom();
}
