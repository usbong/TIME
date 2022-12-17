<?php
/*
  Copyright 2020~2022 USBONG
  
  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
  http://www.apache.org/licenses/LICENSE-2.0
  Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.

  @company: USBONG
  @author: SYSON, MICHAEL B.
  @date created: 20200521
  @date updated: 20221217; from 20221110
  @website address: www.usbong.ph
  
  Input:
  1) sRecordedSteps : recorded steps to auto-generate puzzle;
  --> String format; 
  
  Output:
  1) Automatically connect to the DB and insert sRecordedSteps the puzzle table
  
  Reference:
  1) Usbong KMS; https://github.com/usbong/kms 
  --> https://github.com/usbong/KMS/blob/master/usbong_kms/server/storeTransactionsListForTheDay.php; last accessed: 20221217
*/

	// connect to the database
	include('usbong-time-connect.php');

	$mysqli->set_charset("utf8");

	date_default_timezone_set('Asia/Hong_Kong');

	//edited by Mike, 20220823
	//note: update: base directory location
	//identify if WINDOWS file directory system 		
	//TO-DO: -update: to correct location
	$fileBasePath = "G:\Usbong MOSC\Everyone\Information Desk\output\informationDesk\cashier\\";
						
//	echo $fileBasePath;
	
	if (strpos(dirname(__FILE__), ':\\') !== false) { //WINDOWS file directory system
	}
	else {
		//TO-DO: -update: to correct location
		$fileBasePath = "/home/unit_member/MOSC/output/informationDesk/cashier/";
	}
							


	$sDateToday = date("Y-m-d", strtotime(date("Y-m-d")));
	$sDateTodayTransactionFormat = date("m/d/Y", strtotime(date("Y-m-d")));

	//TO-DO: -add: this
	//$data = json_decode(file_get_contents('php://input'), true);
	//$data["payslip_type_id"]

	//update: 123456798 to correct input; sRecordedSteps 

	if ($insertResultArray = $mysqli->query("insert into puzzle (puzzle_date, puzzle_recorded_steps) values ('".$sDateTodayTransactionFormat."', '123456798')"))
	{
		echo "SUCCESS!";
	}		
	// show an error if there is an issue with the database query
	else
	{
		echo "Error: " . $mysqli->error;
	}																

	//close database connection
	$mysqli->close();
?>
