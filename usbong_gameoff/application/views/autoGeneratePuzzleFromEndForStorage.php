<!--
/*
'
' Copyright 2022 USBONG
'
' Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
'
' http://www.apache.org/licenses/LICENSE-2.0
'
' Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.
'
' @company: USBONG
' @author: SYSON, MICHAEL B.
' @date created: 20221214
' @date updated: 20221214
' @website: www.usbong.ph
'
' References:
' 1) https://phantomjs.org/; last accessed: 20200724
' downloaded phantomjs zipped file's examples: netsniff.js; last accessed: 20200725
'
' 2) https://nodejs.org/en/download/; last accessed: 20221214
' execute: .js file via: node halimbawa.js
' https://askubuntu.com/questions/1297994/what-is-the-simplest-way-to-run-javascript-code-on-ubuntu; last accessed: 20221214
'
'*/
-->

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  </head>

  <title>
    TIME OFF
  </title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

  <style type="text/css">
  </style>

  <script>  
	//added by Mike, 20221214
	var iCountMovementStep=0;
	const iCountInitMovementStepMax=15;
	const iCountMovementStepMax=100-iCountInitMovementStepMax;
	
	var iPrevDirection=0;
	var bIsInitAutoGeneratePuzzleFromEnd=true;
	
	const iKEY_W = 0;
	const iKEY_S = 1;
	const iKEY_A = 2;
	const iKEY_D = 3;
	
	const iKEY_I = 4;
	const iKEY_K = 5;
	const iKEY_J = 6;
	const iKEY_L = 7;
		
	const iTotalKeyCount = 8; //4;	
	const iDirectionTotalKeyCount = 4;	
	
	var arrayCountMovementStep= [];


	//added by Mike, 20221108
	//note: Carnage Heart from Videogame Magazines, Artificial Intelligence 
//	function autoGeneratePuzzleFromEnd() {
	function autoGeneratePuzzleFromEndForStorage() {
	
	//sRecordedSteps="3121220312133003112111302212133333303312003030030303133122112122121303033033311212002";
	
	
	/*	
		//added by Mike, 20221213
		//-----------------------------------------
		//notes: 15 steps
		
		//added by Mike, 20221108
		//move all outer tiles
		//to: left corner
		if (!bIsToLeftCornerDone) {
			if (iCountMovementStep<iColumnCountMax) {
				arrayKeyPressed[iKEY_A]=true;	
				arrayKeyPressed[iKEY_K]=true;
				iCountMovementStep++;		
	
				return;
			}
			iCountMovementStep=0;
			bIsToLeftCornerDone=true;
		}
					
		if (!bIsToTopCornerDone) {
			//to: top corner	
			if (iCountMovementStep<iRowCountMax) {
				arrayKeyPressed[iKEY_W]=true;	
				arrayKeyPressed[iKEY_K]=true;
				iCountMovementStep++;
				return;
			}
			iCountMovementStep=0;
			bIsToTopCornerDone=true;
		}
	
		if (!bIsToRightCornerDone) {	
			//to: right corner
			if (iCountMovementStep<iColumnCountMax) {
				arrayKeyPressed[iKEY_D]=true;	
				arrayKeyPressed[iKEY_K]=true;
				iCountMovementStep++;		
				return;
			}
			iCountMovementStep=0;
			bIsToRightCornerDone=true;
		}
	
		if (!bIsToBottomCornerDone) {	
			//to: bottom corner -1	
			if (iCountMovementStep<iRowCountMax-1) {
				arrayKeyPressed[iKEY_S]=true;	
				arrayKeyPressed[iKEY_K]=true;
				iCountMovementStep++;
				return;
			}
			iCountMovementStep=0;
			bIsToBottomCornerDone=true;
		}
		//-----------------------------------------
	*/	
		
		//reference: https://www.w3schools.com/jsref/jsref_random.asp;
		//last accessed: 20221108
		//number between 0 and 4; integer only	
	//	for (iCount=0; iCount<iCountMovementStepMax; iCount++) {
				
		if (iCountMovementStep<iCountMovementStepMax) {

			//alert("iCountMovementStep: "+iCountMovementStep);
			
			//edited by Mike, 20221214; from 20221129
			//random
			let iDirection = window.parseInt(Math.random() * 4);	
			
			//OK
			//let iDirection=parseInt(sRecordedSteps.substr(iCountMovementStep,1));		
				
			//added by Mike, 20221129
			//objective: reduce immediate left-right 
			//and up-down movements
			//keyphrase: Artificial Intelligence
			//-----
			switch (iPrevDirection) {
				case iKEY_W: //0
					if (iDirection==iKEY_S) {
						if (iDirection%2==0) {
							iDirection=iKEY_A;
						}
						else {
							iDirection=iKEY_D;
						}
					}
					break;	
				case iKEY_S: //1
					if (iDirection==iKEY_W) {
						if (iDirection%2==0) {
							iDirection=iKEY_A;
						}
						else {
							iDirection=iKEY_D;
						}
					}
					break;	
				case iKEY_A: //2
					if (iDirection==iKEY_D) {
						if (iDirection%2==0) {
							iDirection=iKEY_W;
						}
						else {
							iDirection=iKEY_S;
						}
					}
					break;	
				case iKEY_D: //3
					if (iDirection==iKEY_A) {
						if (iDirection%2==0) {
							iDirection=iKEY_W;
						}
						else {
							iDirection=iKEY_S;
						}
					}
					break;	
			}		
			
			iPrevDirection=iDirection;
						
			//-----
			
	/* //removed by Mike, 20221214			
			switch (iDirection) {
				case iKEY_W: //0
					arrayKeyPressed[iKEY_W]=true;	
					arrayKeyPressed[iKEY_K]=true;						
					break;	
				case iKEY_S: //1
					arrayKeyPressed[iKEY_S]=true;	
					arrayKeyPressed[iKEY_K]=true;
					break;	
				case iKEY_A: //2
					arrayKeyPressed[iKEY_A]=true;	
					arrayKeyPressed[iKEY_K]=true;
					break;	
				case iKEY_D: //3
					arrayKeyPressed[iKEY_D]=true;	
					arrayKeyPressed[iKEY_K]=true;			
					break;	
			}
	*/		
			//added by Mike, 20221214
			arrayCountMovementStep[iCountMovementStep]=iDirection;
				
			
			iCountMovementStep++;
		}	
		else {		
			bIsInitAutoGeneratePuzzleFromEnd=false;
	
			//TO-DO: -add: in Database, with datetime stamp
			//added by Mike, 20221214
			var sRecordedSteps="";
			
			for (let iCount=0; iCount<iCountMovementStep; iCount++) {		
				sRecordedSteps=sRecordedSteps.concat(arrayCountMovementStep[iCount]);
			}
			
			
			//OK
			//example output: 3121220312133003112111302212133333303312003030030303133122112122121303033033311212002
			//alert(sRecordedSteps);				
			//alert((sRecordedSteps.length));

			//iRecordedSteps = window.parseInt(sRecordedSteps);
						
			window.location.href = "<?php echo site_url('timeoff/addAutoGeneratedPuzzleToStorage/"+sRecordedSteps+"');?>"; 
			
			
		}				
	}
	
	function onLoad() {
		while (bIsInitAutoGeneratePuzzleFromEnd) {
			autoGeneratePuzzleFromEndForStorage();
		}
	}
	
  </script>  
  <body id="myBodyId" onload="onLoad();">
  </body>
</html>
