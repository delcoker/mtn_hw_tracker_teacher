<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("adb.php");

class teacher_login_class extends adb {

   function teacher_login_class() {
      adb::adb();
   }

   function acutalassignment($ass) {
      $query = "insert into mw_hw_tracker_assignment(assignment_title, date_modified, date_created) values(\"$ass\", now(), now())";
//      print $query;
      return $this->query($query);
   }

   function addassignment($date_due, $teacher_id, $school_id, $class_id, $subject_id, $assignment_id) {



      $query = "Insert into mw_hw_tracker_given_hw(date_assigned, date_due, teacher_teacher_id, school_school_id, class_class_id, subject_subject_id, assignment_assignment_id, date_created, date_modified) values(now(), '$date_due', $teacher_id, $school_id, $class_id, $subject_id, $assignment_id, now(), now())";
//                      print($query);
      $ins = $this->query($query);
      $id = $this->get_insert_id();

//      print($id . "-----id");
      // get last given assignment
//     $query2 = "Select * from mw_hw_tracker_given_hw where given_hw_id = $id";
      // get students in this class in this school

      $query3 = "Select * from mw_hw_tracker_student where school_id = $school_id and class_id = $class_id";

//      print($query3 . "-----q3");
      $this->query($query3);
      $row_studs = $this->fetch();
      $res = false;
      while ($row_studs) {


         $query1 = "Insert into mw_hw_tracker_student_has_assignment(student_id, given_hw_id, date_created) values($row_studs[student_id], $id, now())";
         $row_studs = $this->fetch();
//         print($query1 . "---res");
         $res = $this->query($query1);
      }
      return $ins;
   }

   function loginAsTeach($username, $password) {
      $query = "Select count(*) as c from mw_hw_tracker_teacher where username= '$username' and password = '$password' ";
//                      print($query);
      $this->query($query);
      $result = $this->fetch();
      if ($result['c'] > 0) {
         return true;
      } else {
         return false;
      }
   }

   function loadProfile($username) {
      //load username and other informaiton into the session      
      $query = "select * from mw_hw_tracker_teacher where username = '$username';";

      $this->query($query);

      $result = $this->fetch();
//      session_start();
//      $_SESSION['username'] = $username;
//      print $result;
      return $result;
   }

   /**
    * query all religion in the table and store the dataset in $this->result	
    * @return if successful true else false
    */
   function get_all_details() {
      $query = "select * from mw_hw_tracker_student";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   /**
    * get the children (students) of this parent
    * @return if successful true else false
    */
   function get_children($parent_id) {
      $query = "select * from mw_hw_tracker_student where parent_id = $parent_id";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($query);
      return $res;
   }

   function add_info($seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, $locationAddress, $latitude) {
      //write the SQL query and call $this->query()
      $query = "insert into mw_info(seatsLeft, numOfPssngrsReserved, numOfSeats, numOfPssngrsBus, longitude, locationAddress, latitude, date_modified, date_created) values($seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, '$locationAddress', $latitude, now(), now())";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   /**
    * updates the record identified by id 
    */
   function update_info($info_id, $seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, $locationAddress, $latitude) {
      //write the SQL query and call $this->query()
      $query = "Update mw_info set seatsLeft = $seatsLeft
                                    ,   numOfPssngrsReserved = $numOfPssngrsReserved
                                    ,   numOfSeats = $numOfSeats
                                    ,   numOfPssngrsBus = $numOfPssngrsBus
                                    ,   longitude = $longitude, 
                                       locationAddress = $locationAddress, latitude = $latitude
                                    ,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_location($longitude, $latitude, $info_id) {
      //write the SQL query and call $this->query()
      $query = "Update mw_info set longitude = $longitude, 
                                       latitude = $latitude
                                    ,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_pass($seatsLeft, $numOfPssngrsReserved, $numOfPssngrsBus, $info_id) {
      $query = "Update mw_info set numOfPssngrsReserved = $numOfPssngrsReserved,   seatsleft = $seatsLeft
                                    ,   numOfPssngrsBus = $numOfPssngrsBus,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_pass_decrease() {
      
   }

}
