<?php

//Actions for promotions
include_once './gen.php';
//include_once ;
//session_destroy();
//if (!isset($_SESSION['last_insert_id'])) {
//   session_start();
//}
//include "health_promotion.php";
//$last_inserted_id = $_SESSION['last_insert_id'];

$cmd = get_datan("cmd");
//$last_inserted_id = 2;
//$id = get_data("id");
//$date = get_data("date");
//$venue = get_data("venue");
//$page = get_datan("start");


switch ($cmd) {

   case 1:
      //get promotion based on idhealth promotion
      get_info();
      break;

   case 2:
      //get all promotions 
      login();
      break;

   case 3:
      addassignment();
      break;

   case 4:
      //update promotion
      send_message();
      break;

   case 5:
      //g
      get_bus_loca();
      break;

   case 6;
      increase();
      break;

   case 7;
      // get idcho from health promotion
      decrease();
      break;


   case 8;
      // search by method, date and topic
      break;

   default:
      echo "{";
      echo jsonn("result", 0);
      echo ",";
      echo jsons("message", "not a recognised command");
      echo "}";
}
$teacher_id = 0;
function addassignment() {
   include_once './classes/teacher_login_class.php';
   $p = new teacher_login_class();
   $date_due = get_data("date");
   $teacher_id = get_datan("teacher_id");
   $school_id = get_datan("school_id");
   $class_id = get_datan("class_id");
   $subject_id = get_datan("subject_id");
   $ass = get_data("ass");

   if (!$p->acutalassignment($ass)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not add assigment1");
      echo "}";
      return;
   }
   
   $assignment_id = $p->get_insert_id();
//   print_r($assignment_id);
//    check this toooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooddday
   if (!$p->addassignment($date_due, $teacher_id, $school_id, $class_id, $subject_id, $assignment_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not add assigment2");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Assignment added");
   echo "}";
}

function send_message() {
   $url = "https://api.smsgh.com/v3/messages/send?"
           . "From=%2B233244813169"
           . "&To=%2B233502128010"
           . "&Content=Teacher+with+id:+$teacher_id+just+posted+an+assignment+due+$date_due"
           . "&ClientId=odfbifrp"
           . "&ClientSecret=rktegnml"
           . "&RegisteredDelivery=true";
// Fire the request and wait for the response
   $response = file_get_contents($url);
   var_dump($response);
}

function transact1() {
   session_start();
//   $_SESSION['paid']=0;


   $last_inserted_id = $_SESSION['last_insert_id'];

   $id = get_datan('user_id');
   $new_amount = get_datan('new_amount');
   $amount_before = get_datan('amount_before');
   $fare = get_datan('fare');
   $ticket = get_datan('ticket_num');
   $pick_up_location = get_datan("location");

   if ($id == 0) {
      return;
   }

   include_once './transaction_class.php';
   include_once './user_class.php';
   include_once './details_class.php';

   $p = new user_class();
   $q = new transaction_class();
   $d = new deatils_class();

   $row3 = 0;

//   print($d->get_isert_id($d));


   if ($d->get_details($last_inserted_id)) {
      $row3 = $d->fetch();
   }

   if ($row3 == 0 || $row3['seatsLeft'] == 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "No seats left");
      echo "}";
      return;
   }

//   $already_reserved = 0;
   if ($q->search_transactions($id)) {
      $already_reserved = $q->fetch();
   }
//   print_r( $already_reserved);
   if ($already_reserved['c'] != 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo '"trans":{';
      echo jsons("message", "Already Reserved") . ",";
      echo jsons("ticket_num", $already_reserved['c']);
      echo "}";
      echo "}";
//      $_SESSION['paid'] = 1;
      return;
   }

   $row = $p->deduction($id, $new_amount);
   $row2 = $q->transaction($id, $fare, $ticket, $new_amount, $pick_up_location);

   $row4 = $d->update_info($row3['info_id'], $row3['seatsLeft'] - 1, $row3['numOfPssngrsReserved'] + 1, $row3['numOfSeats'], $row3['numOfPssngrsBus'], $row3['longitude'], "\"" . $row3['locationAddress'] . "\"", $row3['latitude']);

   if (!$row || !$row2 || !$row4) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not saved");
      echo "}";
      return;
   }

   echo "{";
   echo jsonn("result", 1) . ",";
   echo '"user":{';
   echo jsons("tran", "transaction successful");
   echo "}";
   echo "}";

//    $_SESSION['paid'] = 1;
//    print $_SESSION['paid'];
}

function transact() {
   session_start();
//   $_SESSION['paid']=0;


   $last_inserted_id = $_SESSION['last_insert_id'];

   $id = get_datan('user_id');
   $new_amount = get_datan('new_amount');
   $amount_before = get_datan('amount_before');
   $fare = get_datan('fare');
   $ticket = get_datan('ticket_num');
   $pick_up_location = get_datan("location");

   if ($id == 0) {
      return;
   }

   include_once './transaction_class.php';
   include_once './user_class.php';
   include_once './details_class.php';

   $p = new user_class();
   $q = new transaction_class();
   $d = new deatils_class();

   $row3 = 0;

//   print($d->get_isert_id($d));


   if ($d->get_details($last_inserted_id)) {
      $row3 = $d->fetch();
   }

   if ($row3 == 0 || $row3['seatsLeft'] == 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "No seats left");
      echo "}";
      return;
   }

//   $already_reserved = 0;
   if ($q->search_transactions($id)) {
      $already_reserved = $q->fetch();
   }
//   print_r( $already_reserved);
   if ($already_reserved['c'] != 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo '"trans":{';
      echo jsons("message", "Already Reserved") . ",";
      echo jsons("ticket_num", $already_reserved['c']);
      echo "}";
      echo "}";
//      $_SESSION['paid'] = 1;
      return;
   }

   $row = $p->deduction($id, $new_amount);
   $row2 = $q->transaction($id, $fare, $ticket, $new_amount, $pick_up_location);

   $row4 = $d->update_info($row3['info_id'], $row3['seatsLeft'] - 1, $row3['numOfPssngrsReserved'] + 1, $row3['numOfSeats'], $row3['numOfPssngrsBus'], $row3['longitude'], "\"" . $row3['locationAddress'] . "\"", $row3['latitude']);

   if (!$row || !$row2 || !$row4) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not saved");
      echo "}";
      return;
   }

   echo "{";
   echo jsonn("result", 1) . ",";
   echo '"user":{';
   echo jsons("tran", "transaction successful");
   echo "}";
   echo "}";

//    $_SESSION['paid'] = 1;
//    print $_SESSION['paid'];
}

function dropoffs() {
   include_once './dropoff_class.php';
   $obj_drop2 = new dropoff_class();
   $obj_drop2->get_all_dropoffs();
   $row_drops2 = $obj_drop2->fetch();
   $i = 0;
   while ($row_drops2) {
//      print "fadsf";
      print jsons("$i", $row_drops2['dropoff_name']) . ",";
      $row_drops2 = $obj_drop2->fetch();
      $i++;
   }
}

function login() {
   include_once './classes/teacher_login_class.php';
//   include_once './details_class.php';
//   $details_obj = new deatils_class();
//   if (!$details_obj->get_all_details()) {
//      
//   } else {
//      $details_row = $details_obj->fetch();
//   }
//   session_start();
   $user = get_data('user');
   $pass = get_data('pass');
   $p = new teacher_login_class();
   $val = $p->loginAsTeach($user, $pass);
//   $row = 0;
   if ($val) {
      $row = $p->loadProfile($user);
      if ($row) {
         echo "{";
         echo jsonn("result", 1);
         echo ',"user":';
         echo "{";
         echo jsons("id", $row["teacher_id"]) . ",";
         echo jsons("username", $row["username"]) . ",";
         echo jsons("firstname", $row["firstname"]) . ",";
         echo jsons("lastname", $row["lastname"]);
         echo "}";
         print "}";
         return;
      }
   } else {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, no record retrieved");
      echo "}";
   }
//   if it's a new day - reset all values
//   include_once './details_class.php';
//   $det_obj = new deatils_class();
//   if (!$det_obj->get_all_details()) {
//      echo "{";
//      echo jsonn("result", 0) . ",";
//      echo jsons("message", "error, no record retrieved2");
//      echo "}";
//      return;
//   }
//   $last_inserted_id = 0;
//   $row2 = $det_obj->fetch();
////   print_r($row2);
//   $row3 = $row2;
//   while ($row2) {
////      $row3 = $row2;
//
//      $last_inserted_id = $row2['info_id'];
//      $_SESSION['last_insert_id'] = $last_inserted_id;
//
//      $row2 = $det_obj->fetch();
//   }
//   print_r($_SESSION);
//
//   $det_obj2 = new deatils_class();
//
////   print_r ($row3);
////   print $row3['date_created'];
//
//   $dt = new DateTime($row3['date_created']);
//
//   $dt1 = $dt->format('d-m-Y');
////   print "---------------" . ($row3['date_created']);
//   $dt2 = date('d-m-Y');
////           
////   print "dt1 " . ($dt1);
////   print "dt2 " . ($dt2);
////   print ($dt1 === $dt2);
////   
////exit();
//
//   if ($dt1 == $dt2) {
////      print "here";
//      return;
//   } else {
////      exit();
//      // create a new info row
//      if (!$det_obj->add_info($row3['numOfSeats'], 0, $row3['numOfSeats'], 0, $row3['longitude'], $row3['locationAddress'], $row3['latitude'])) {
////       this should be concatenated witht the top
//         echo "{";
//         echo jsonn("result", 0) . ",";
//         echo jsons("message", "error, could not create new tuple");
//         echo "}";
////         exit();
//      }
//      $_SESSION['last_insert_id'] = $det_obj->get_insert_id($det_obj);
////      print "created";
//   }
//   echo jsons("last_insert_id", $_SESSION['last_insert_id']);
//   echo "}";
//   print "}";
//   return;
}

function diver_update_bus_location() {
   $info_id = 1;
   $longitude = get_data('long');
   $latitude = get_data('lat');

   include_once './details_class.php';
   $update = new deatils_class();

   if (!$update->update_location($longitude, $latitude, $info_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Succesful");
   echo "}";
}

function get_bus_loca() {
   include_once './details_class.php';
   $det = new deatils_class();
   if (!$det->get_all_details()) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   $row = $det->fetch();
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("x", $row['longitude']) . ",";
   echo jsons("y", $row['latitude']);
   echo "}";
   return;
}

function increase() {

   session_start();
   $last_inserted_id = $_SESSION['last_insert_id'];
   $seats_left = get_data("seats_left");
   $pass_res = get_data('pass_res');
   $pass_on = get_data('pass_on');

   include_once './details_class.php';
   $d = new deatils_class();
//exit();
   $row4 = $d->update_pass($seats_left, $pass_res, $pass_on, $last_inserted_id);

   if (!$row4) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Successful");
   echo "}";
}

function decrease() {
   session_start();
//   $_SESSION['paid']=0;


   $last_inserted_id = $_SESSION['last_insert_id'];
}
