<?php
/*
  Copyright 2019~2022 USBONG

  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.

  @company: USBONG
  @author: SYSON, MICHAEL B.
  @date created: 20190804
  @date updated: 20221217; from 20210323
  @website address: www.usbong.ph
    
  Given:
  1) Database (DB) details

  Output:
  1) Automatically connect to the database (DB) with $mysqli as the resulting reference to the DB
  
  Note:
  1) SQL (Structured Query Language) instructions can be used to search the database (DB) repository using $mysqli.
*/

//define('BASEPATH', "https://store.usbong.ph");
//define('BASEPATH', "http://localhost/usbong_kms/");
define('BASEPATH', "http://localhost/usbong_time/");

//typically, webroot would be in /var/www/html/
//include('/put_this_somewhere_outside_of_web_root/app+server/database.php');

//edited by Mike, 20210323
//TO-DO: -update: to eliminate excess steps
//include('C:/xampp/htdocs/usbong_kms/server/database.php');
include('/opt/lampp/htdocs/usbong_time/server/database.php');

//added by Mike, 20210323
//reminder: update computer server database values for username, password, etc in database.php
// server info
$server = $db['hostname']; //'mysql10.000webhost.com';
$user = $db['username'];
$pass = $db['password'];
$db = $db['database'];

// connect to the database
$mysqli = new mysqli($server, $user, $pass, $db);

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);
?>
