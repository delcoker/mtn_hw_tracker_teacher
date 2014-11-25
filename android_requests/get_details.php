<?php

include_once '../classes/student_class.php';
include_once '../classes/given_hw_class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// get children (students) that belong to parent
if (isset($_REQUEST["pid"])) {
   $pid = ($_REQUEST["pid"]);

   $children_obj = new student_class();
   if ($children_obj->get_children($pid)) {
      $dataset_children = $children_obj->fetch();
//      print_r($dataset_children);
      while ($dataset_children) {
         print $dataset_children["student_id"];
         print "#";
         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "#";
//         print $dataset_children["school_school_id"];
         print "#";
         print $dataset_children["class_id"];
         print "#,";
//         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "here";
         $dataset_children = $children_obj->fetch();
      }
   } else {
      print false;
   }
} else // get assignment due tomorrow
if (isset($_REQUEST["pid2"]) && isset($_REQUEST["cid"]) && isset($_REQUEST["date"])) {
   $pid = ($_REQUEST["pid2"]);
   $cid = ($_REQUEST["cid"]);
   $date = ($_REQUEST["date"]);

   $hw_obj = new given_hw_class();
   if ($hw_obj->get_details_w_parent_due_tomorrow($pid, $cid, $date)) {
      $dataset_hw = $hw_obj->fetch();
//      print_r($dataset_children);
      while ($dataset_hw) {
         print $dataset_hw["subject_name"];
         print "#";
         print $dataset_hw["assignment_title"];
         print "#";
         print $dataset_hw["date_due"];
         print "#,";
//         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "here";
         $dataset_hw = $hw_obj->fetch();
      }
   } else {
      print false;
   }
} // get assingments due the week
else if (isset($_REQUEST["pid3"]) && isset($_REQUEST["cid"]) && isset($_REQUEST["date"])) {
   $pid = ($_REQUEST["pid3"]);
   $cid = ($_REQUEST["cid"]);
   $date = ($_REQUEST["date"]);

   $hw_obj = new given_hw_class();
   if ($hw_obj->get_details_w_parent_due_week($pid, $cid, $date)) {
      $dataset_hw = $hw_obj->fetch();
//      print_r($dataset_children);
      while ($dataset_hw) {
         print $dataset_hw["subject_name"];
         print "#";
         print $dataset_hw["assignment_title"];
         print "#";
         print $dataset_hw["date_due"];
         print "#,";
//         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "here";
         $dataset_hw = $hw_obj->fetch();
      }
   } else {
      print false;
   }
} else if (isset($_REQUEST["item"]) && isset($_REQUEST["amount"]) && isset($_REQUEST["date"])) {
   $item = $_REQUEST["item"];
   $amount = $_REQUEST["amount"];
   $date = $_REQUEST["date"];
   $amount_left = $_REQUEST["amount_left"];
   $amount_start = $_REQUEST["amount_start"];


   $query = "insert into mw_susu_exp (item, date_spent, amount_spent, amount_left, amount_start) values ('$item', '$date', '$amount', '$amount_left', '$amount_start')";
   if (mysql_query($query, $link)) {
      print "true";

      $url = "https://api.smsgh.com/v3/messages/send?"
              . "From=%2B233244813169"
              . "&To=%2B233502128010"
              . "&Content=You+spent+$amount+on+$item+on+$date"
              . "&ClientId=odfbifrp"
              . "&ClientSecret=rktegnml"
              . "&RegisteredDelivery=true";
      // Fire the request and wait for the response
      $response = file_get_contents($url);
      var_dump($response);
   } else {
      print "false";
   }
}
// retrieving expenditures
else if (isset($_REQUEST["getall"])) {
   $query = mysql_query("select * from mw_susu_exp ORDER BY item", $link);
   $queryData = mysql_fetch_assoc($query);
   $queryResult = "";
   $queryArray = Array();

   while ($queryData) {
      $queryId = $queryData["susu_exp_id"];
      $queryItem = $queryData["item"];
      // $queryDate = $queryData["date_spent"];
      $querySpent = $queryData["amount_spent"];
      // $queryLeft = $queryData["amount_left"];

      print ("$queryId" . "#");
      print ("$queryItem" . "#");
      print ("$querySpent" . "#,");

      $queryData = mysql_fetch_assoc($query);
   }

   // print json_encode($queryArray);
}
