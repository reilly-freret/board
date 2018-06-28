function registerAjax(event) {

  var username = document.getElementById("rusername").value;
  var password = document.getElementById("rpassword").value;
  var name = document.getElementById("rname").value;
  var phone = document.getElementById("rphone").value;
  var taField = document.getElementById("rauth").value;
  var defTA = "nah";

  if (username == "") {
    alert("You must choose a username to register");
    return;
  }
  if (password == "" || password.length < 4 || password.length > 20) {
    alert("Please choose an alphanumeric password between 4 and 20 characters, inclusive");
    return;
  }
  if (name == "") {
    alert("Please enter your full name to continue; this is how you'll appear to other users");
    return;
  }
  if (document.getElementById("regStudentButton").checked == false && taField.length != 6) {
    alert("That doesn't look like a valid TA code. Check with your instructor to make sure you have the most up-to-date authorization");
    return;
  }
  if (phone.length < 10) {
    alert("Please enter a valid 10-digit phone number. You'll get SMS alerts when your TA is ready to assist you.");
    return;
  }

  // format phone number correctly
  phone = "+1" + phone.replace(/\(|\)|-|\.| |[A-z]/g, '');


  console.log(username);
  console.log(password);
  console.log(name);
  console.log(phone);
  console.log(taField);

  if (document.getElementById("regStudentButton").checked == false) {
    var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password) + "&name=" + encodeURIComponent(name) + "&phone=" + encodeURIComponent(phone) + "&auth=" + encodeURIComponent(taField);
  } else {
    var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password) + "&name=" + encodeURIComponent(name) + "&phone=" + encodeURIComponent(phone) + "&auth=" + encodeURIComponent(defTA);
  }

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "register.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlHttp.addEventListener("load", function(event) {
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      alert("You've been registered!");
      window.location.replace("landing.html");
    } else {
      alert("Registration failed. " + jsonData.message);
    }
  }, false);
  xmlHttp.send(dataString);
}

function loginAjax(s) {

  if (s == "ta") {
    var username = document.getElementById("tusername").value;
    var password = document.getElementById("tpassword").value;
  } else {
    var username = document.getElementById("susername").value;
    var password = document.getElementById("spassword").value;
  }

  var dataString = "username=" + username + "&password=" + password + "&type=" + s;

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "login.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlHttp.addEventListener("load", function(event) {
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      /*if (s == "ta") {
        window.location.replace("talanding.html");
      } else {
        window.location.replace("landing.html");
      }*/
      window.location.replace("landing.html");
    } else {
      alert("Login failed. " + jsonData.message);
    }
  }, false);
  xmlHttp.send(dataString);
}

document.addEventListener("DOMContentLoaded", function(event) {

  // Buttons
  studentOptionButton = document.getElementById("studentLoginLanding")
  taOptionButton = document.getElementById("taLoginLanding")
  registerOptionButton = document.getElementById("registerLanding")
  studentBack = document.getElementById("studentLoginBack")
  taBack = document.getElementById("taLoginBack")
  registerBack = document.getElementById("registerBack")
  regStudent = document.getElementById("asStudent")
  regTA = document.getElementById("asTA")
  regSubmit = document.getElementById("regSubmit")
  studentLoginButton = document.getElementById("studentLoginButton")
  taLoginButton = document.getElementById("taLoginButton")

  // Div displays
  optionButtons = document.getElementById("buttonList")
  studentLoginContainer = document.getElementById("studentLogin")
  taLoginContainer = document.getElementById("taLogin")
  registerContainer = document.getElementById("register")
  taAuthField = document.getElementById("taAuth")

  // enter keystrokes
  document.getElementById("tpassword").addEventListener("keyup", function(event) {
    event.preventDefault();
  if (event.keyCode === 13) {
    taLoginButton.click();
  }
  })

  document.getElementById("spassword").addEventListener("keyup", function(event) {
    event.preventDefault();
  if (event.keyCode === 13) {
    studentLoginButton.click();
  }
  })

  regSubmit.addEventListener("click", registerAjax)
  studentLoginButton.addEventListener("click", function() {
    loginAjax("student");
  })
  taLoginButton.addEventListener("click", function() {
    loginAjax("ta");
  })


  // Display scripts
  studentOptionButton.addEventListener("click", function() {
    optionButtons.hidden = true;
    studentLoginContainer.hidden = false;
  })

  taOptionButton.addEventListener("click", function() {
    optionButtons.hidden = true;
    taLoginContainer.hidden = false;
  })

  registerOptionButton.addEventListener("click", function() {
    optionButtons.hidden = true;
    registerContainer.hidden = false;
  })

  studentBack.addEventListener("click", function() {
    optionButtons.hidden = false;
    studentLoginContainer.hidden = true;
  })

  taBack.addEventListener("click", function() {
    optionButtons.hidden = false;
    taLoginContainer.hidden = true;
  })

  registerBack.addEventListener("click", function() {
    optionButtons.hidden = false;
    registerContainer.hidden = true;
  })

  regStudent.addEventListener("click", chooseDisplay)
  regTA.addEventListener("click", chooseDisplay)
})

function chooseDisplay() {
  if (document.getElementById("regStudentButton").checked == false) {
    taAuthField.hidden = true;
  } else {
    taAuthField.hidden = false;
  }
}
