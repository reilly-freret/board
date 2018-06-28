var currUser;
var currRoom;
var currType = "ta";

var dataString = "yo?";
var xmlHttp = new XMLHttpRequest();
xmlHttp.open("POST", "isLogged.php", true);
xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlHttp.addEventListener("load", function(event) {
  var jsonData = JSON.parse(event.target.responseText);
  if (jsonData.success) {
    if (jsonData.userType == "student") window.location.replace("landing.html");
    currUser = jsonData.username;
    if (jsonData.room) currRoom = jsonData.room;
  } else {
    window.location.replace("login.html")
  }
}, false);
xmlHttp.send(dataString);

function getRoomTa() {
  var dataString = "yo?";
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "isLogged.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlHttp.addEventListener("load", function(event) {
    console.log("here");
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.room) {
      currRoom = jsonData.room;
      document.getElementById("currentRoomTa").innerHTML = currRoom;
      lists.hidden = false;
    }
  }, false);
  xmlHttp.send(dataString);
}

function logout() {
  window.location.replace("logout.php");
}

document.addEventListener("DOMContentLoaded", function() {
  var join = document.getElementById("taJoinRoom");
  var create = document.getElementById("taCreateRoom");
  var lists = document.getElementById("listsTa");

  join.addEventListener("click", function() {
    joinRoomTa();
    getRoomTa();
    //location.reload();
  })
})
