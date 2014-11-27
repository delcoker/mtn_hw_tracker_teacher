// created because database structure changed the last minute
var global_drop_off = 0;

// $_SESSION['username'] = $username;
//      $_SESSION['role_id'] = $result['role_role_id'];
//      $_SESSION['amount_left'] = $result['amount_left'];
//      $_SESSION['id'] = $result['user_id'];

var user_id = 0;
var user_name = 0;
var user_role_id = 0;
var amount_left = 0;
//      alert(amount_left);


var seats_left = 0;
var res_seats = 0;
var pass_on_bus = 0;
var num_of_seats = 0;

$(document).ready(function () {
//   var amount_left = $('#amount_left').text();
//   alert(amount_left);
//   login();
});


function syncAjax(u) {
   var obj = $.ajax({url: u, async: false});
   return $.parseJSON(obj.responseText);
}

var school_id;
var class_id;
var subject_id;

var id = 0;

function publish_ass() {

   $(function () {
      $("input[name*=radio-choice-2]:checked").each(function () {
         school_id = $(this).val();
//         alert("school " + school_id);
      });
   });

   $(function () {
      $("input[name*=radio-choice-3]:checked").each(function () {
         class_id = $(this).val();
//         alert("class " + class_id);
      });
   });

   $(function () {
      $("input[name*=radio-choice-4]:checked").each(function () {
         subject_id = $(this).val();
//         alert("subject " + subject_id);
      });
   });


   var date1 = $("#due_date").val();
   var date2 = new Date(date1);
   var date = getFormattedDate(date2);

   var ass = $("#actual_ass").val();

//   alert(id);
//   alert(ass);

   if (date === null) {
      alert("please select a data");
      return;
   }

   var u = "action_1.php?cmd=3&school_id=" + school_id + "&class_id=" + class_id + "&subject_id=" + subject_id + "&date=" + date + "&teacher_id=" + id + "&ass=" + ass;

//   prompt("URL", u);

   r = syncAjax(u);

   if (r.result === 1) {
      alert("Added Assignment");
   }
   else {
      alert("Could not add");
      return;
   }

   // if it added 

   // send message

   var u = "action_1.php?cmd=4" + "&date=" + date + "&teacher_id=" + id;
   r = syncAjax(u);

   if (r.result === 1) {
      alert("Message send");
   }
   else {
      alert("Could not send");
   }
}

function getFormattedDate(date) {
   var year = date.getFullYear();
   var month = (1 + date.getMonth()).toString();
   month = month.length > 1 ? month : '0' + month;
   var day = date.getDate().toString();
   day = day.length > 1 ? day : '0' + day;
   return year + '-' + month + '-' + day;
}

function logout() {
   window.open("logout.php", "_self");
}

function login() {

   //complete the url
   var user = document.getElementById("username").value;
   var pass = document.getElementById("password").value;

   var u = "action_1.php?cmd=2&user=" + user + "&pass=" + pass;
//   prompt("URL", u);
   r = syncAjax(u);

//   prompt(r.user);

//                alert(r.result);
   if (r.result === 1) {
      username = r.user.username;
      t_firstname = r.user.firstname;
      t_lastname = r.user.lastname;
      id = r.user.id;
//      res_seats = r.user.res_seats;
//      num_of_seats = r.user.num_of_seats;
//      seats_left = r.user.seats_left;
//      pass_on_bus = r.user.pass_on_bus;
//      pass_on_bus = r.
      $(".user").text(t_firstname);



      var u = "action_1.php?cmd=5&getschools";
//      prompt("URL", u);
      schools = syncAjax(u);

//      <input type="radio" name="radio-choice-2" class="school" id="radio-choice-21" value="1" checked="checked" />
//                  <label for="radio-choice-21">Ghana I.S</label>
      var sch = ["Ghana", "Tema", "James town"];
//      console.log(schools.schools);

      var ins = '<legend>Choose your school:</legend>';
      $.each(schools.schools, function (key, elem) {
//         console.log(elem.id);
         ins += '<label for="radio-choice-2' + elem.id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-first-child ui-radio-on">' + elem.school_name + '</label><input type="radio" name="radio-choice-2" class="school" id="radio-choice-2' + elem.id + '" value="' + elem.id + '" checked="checked" data-cacheval="false">';

      });
      $('#schoolList fieldset').html(ins);


// classes

      var u1 = "action_1.php?cmd=6";
//      prompt("URL", u1);
      classes = syncAjax(u1);

//      console.log(classes.classes);

      var ins2 = '<legend>Select your class:</legend>';
      $.each(classes.classes, function (key, elem) {
//         console.log(elem.id);
         ins2 += '<label for="radio-choice-3' + elem.id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-on ui-first-child">' + elem.class_number + '</label><input type="radio" name="radio-choice-3" id="radio-choice-3' + elem.id + '" value="' + elem.id + '" checked="checked">';

      });
      $('#classList fieldset').html(ins2);

      // subjects
      var u2 = "action_1.php?cmd=7";
//      prompt("URL", u2);
      subject = syncAjax(u2);

//      console.log(subject.subjects);

      var ins3 = '<legend>Select your class:</legend>';
      $.each(subject.subjects, function (key, elem) {
//         console.log(elem.id);
         ins3 += '<label for="radio-choice-4' + elem.id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-on ui-first-child">' + elem.subject_name + '</label><input type="radio" name="radio-choice-4" id="radio-choice-4' + elem.id + '" value="' + elem.id + '" checked="checked">';

      });
      $('#subjectList fieldset').html(ins3);

      window.open("main_hwtracker_mobile.html#home", "_self");
   }
   else {
      alert("username or password wrong");
      return;
   }
}


function get_assignments2() {
//debugger;
   var url = "action_1.php?cmd=8&prof_id=" + 1;

//   prompt("url", url);
   assigns2 = syncAjax(url);

   if (assigns2.result === 1) {
//      console.log(assigns);
      ins5 = "";
//      $.each(assigns.assignments, function (key, elem) {
//
////         console.log(elem.actual_assignment);
//         var actual = elem.actual_assignment;
//
//         actual = actual.replace(/["']/g, "!apostrophe!");

         ins5 += '<div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-first-child ui-last-child ui-collapsible-collapsed"><h1 class="ui-collapsible-heading ui-collapsible-heading-collapsed"><a href="#" class="ui-collapsible-heading-toggle ui-btn ui-btn-icon-left ui-btn-inherit ui-icon-plus">Subject - Form - Date<span class="ui-collapsible-heading-status"> click to expand contents</span></a></h1><div class="ui-collapsible-content ui-body-inherit ui-collapsible-content-collapsed" aria-hidden="true"><p>Content</p></div></div>';
//      });
      $('#ass_list2').html(ins5);
   }
}



function get_assignments() {

   var url = "action_1.php?cmd=8&prof_id=" + id;

//   prompt("url", url);
   assigns = syncAjax(url);

   if (assigns.result === 1) {
//      console.log(assigns);
      ins4 = "";
      $.each(assigns.assignments, function (key, elem) {

//         console.log(elem.actual_assignment);
         var actual = elem.actual_assignment;

         actual = actual.replace(/["']/g, "!apostrophe!");

         ins4 += '<li class="ui-first-child ui-last-child"><a href="#" onclick="popUp(' + "'" + actual + "'" + ')" class="ui-btn ui-btn-icon-right ui-icon-carat-r ui-last-child">' + elem.subject + " - " + elem.class + " - " + elem.due.substring(0, 10) + '</a></li>';
      });
      $('#assignments').html(ins4);
   }
}

function popUp(text) {
   alert(text.replace("!apostrophe!", "'"));
}

function qrgenerate(rand) {
//   window.location.reload();
   if (rand === "" || rand == null) {
      alert("Times are hard huh? You haven't paid yet! Sorry");
      return;
   }
   $('#qrcode').text("");
   jQuery('#qrcode').qrcode({
      text: rand.toString()
   });
}

function payment() {

//   alert("here");
//   $("#status").text("NOT PAID");
   var fare = $("#fare").val();
   var amount_before = amount_left;
   if (amount_before - $("#fare").val() >= 0) {
      var new_amount = amount_before - $("#fare").val();

      var ticket = Math.floor((Math.random() * 1000) + 1);
//      alert(ticket);

      var url = "login_mobile_action_1.php?cmd=3&user_id=" + user_id + "&new_amount=" + new_amount + "&amount_before=" + amount_before + "&fare=" + $("#fare").val() + "&ticket_num=" + ticket + "&location=" + global_drop_off;
      prompt("url", url);
      r = syncAjax(url);
//      prompt("url", r.result);
      if (r.result === 1) { // signifies update
         alert("Your ticket is available in another tab. Go to payment to view");
//         $("#status").text("PAID");
//         qrgenerate(ticket);
         window.open("mobile_and_passenger.php#view_payment", "_self");
         window.location.reload();
//         window.open("mobile_and_passenger.php#view_payment", "_self");

//         window.reload("mobile_and_passenger.php#view_payment");
//         window.location.href="mobile_and_passenger.php#view_payment";
         global_drop_off = 0;
      }
      else if (r.result === 0 && r.trans.message === "Already Reserved") {
         alert("You have " + r.trans.message);
//         alert(r.trans.ticket_num);
//         $("#status").text("PAID");
//         qrgenerate(r.trans.ticket_num);
         window.open("mobile_and_passenger.php#view_payment", "_self");
//         global_drop_off = 0;
      }
      else {
         alert(r.trans.message);
         alert("unsuccessful");
         global_drop_off = 0;
         return;
      }
   }
   else {
      alert("unsuccessful, not enough funds, you broke");
      global_drop_off = 0;
   }
}

var x = document.getElementById("demo");

function getLocation() {
//   console.log("called");
   if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
   } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
   }
}

function getLocationBus() {
//   console.log("called");
//   if (navigator.geolocation) {
   navigator.geolocation.getCurrentPosition(showPositionBus, showError);
//   } else {
//      x.innerHTML = "Geolocation is not supported by this browser.";
//   }
}

function showPositionBus(position) {

   var url = "login_mobile_action_1.php?cmd=5";
//      prompt("url", url);
   r = syncAjax(url);

   if (r.result === 0) {
      alert(r.message);
      return;
   }

   var a = r.x;
   var b = r.y;

//   alert (a);

   x.innerHTML = "Latitude: " + b +
           "<br>Longitude: " + a;

   showBus(a, b);

}
var gloA = 0;
var gloB = 0;
function showBus(a, b) {
//   debugger;
   gloA = a;
   gloB = b;
   window.open("map.php", "_self");
   /*
    * Google Maps documentation: http://code.google.com/apis/maps/documentation/javascript/basics.html
    * Geolocation documentation: http://dev.w3.org/geo/api/spec-source.html
    */

}

function showPosition(position) {

   x.innerHTML = "Latitude: " + position.coords.latitude +
           "<br>Longitude: " + position.coords.longitude;

//           update database
   var url = "login_mobile_action_1.php?cmd=4&long=" + position.coords.longitude + "&lat=" + position.coords.latitude;
//      prompt("url", url);
   r = syncAjax(url);

   if (r.result === 0) {
      alert(r.message);
   }



   var latlon = position.coords.latitude + "," + position.coords.longitude;

   var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
           + latlon + "&zoom=14&size=400x300&sensor=false";
   document.getElementById("mapholder").innerHTML = "<img src='" + img_url + "'>";
}

function showError(error) {
   switch (error.code) {
      case error.PERMISSION_DENIED:
         x.innerHTML = "User denied the request for Geolocation.";
         break;
      case error.POSITION_UNAVAILABLE:
         x.innerHTML = "Location information is unavailable.";
         break;
      case error.TIMEOUT:
         x.innerHTML = "The request to get user location timed out.";
         break;
      case error.UNKNOWN_ERROR:
         x.innerHTML = "An unknown error occurred.";
         break;
   }
}

function callEveryHour() {
//   setTimeout(getLocation, 5000);
//   setInterval(getLocation(), 5000);
   getLocation();
//   console.log("called");
//   alert("called");
}



$(document).on("pagecreate", "#map-page", function () {
   var defaultLatLng = new google.maps.LatLng(gloA, gloB);  // Default to Hollywood, CA when no geolocation support
//   debugger;
   if (navigator.geolocation) {

      function success(pos) {
         // Location found, show map with these coordinates
         drawMap(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
//            alert(b);
      }
      function fail(error) {
         drawMap(defaultLatLng);  // Failed to find location, show default map
      }
      // Find the users current position.  Cache the location for 5 minutes, timeout after 6 seconds
      navigator.geolocation.getCurrentPosition(success, fail, {maximumAge: 500000, enableHighAccuracy: true, timeout: 6000});
   } else {
      drawMap(defaultLatLng);  // No geolocation support, show default map
   }
   function drawMap(latlng) {

      var myOptions = {
         zoom: 16,
         center: latlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
      // Add an overlay to the map of current lat/lng
      var marker = new google.maps.Marker({
         position: latlng,
         map: map,
         title: "Bus is here!"
      });
   }
});