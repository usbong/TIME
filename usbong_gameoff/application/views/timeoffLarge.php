<!--
' Copyright 2020~2025 USBONG
'
' Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
'
' http://www.apache.org/licenses/LICENSE-2.0
'
' Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.
'
' @company: USBONG
' @author: SYSON, MICHAEL B.
' @date created: 20200306
' @date updated: 20250704; from 20250703
' @website: http://www.usbong.ph
'
' Note: re-used computer instructions mainly from the following:
'	1) Usbong Knowledge Management System (KMS);
'	2) Usbong Game Off 2022;
'
' Reference:
' 1) http://gcctech.org/csc/javascript/javascript_keycodes.htm;
' last accessed: 20221101
'
' 2) https://www.w3schools.com/css/css3_2dtransforms.asp;
' last accessed: 20221104
'
' 3) https://www.w3schools.com/css/css_align.asp; 
' last accessed: 20221105 
'
' Notes:
' IF NOT @BOTTOM row
' BOTTOM-LEFT; CENTER+3
' BOTTOM-RIGHT; CENTER+5
'
' IF NOT @TOP row
' TOP-LEFT; CENTER-5
' TOP-RIGHT; CENTER-3

<?php
/*
NOTES; TO-DO LIST: 

ANDROID mobile, 
TO-DO: -set: canvas, background images to 50% of current size

--> update: the following
myCanvas
ImageBackgroundOfPuzzle
ImageController
ImageHowToPlayGuide

iPAD (portrait) no buttons;
--> (landscape) increase: button size

EDGE; desktop
--> @100% based on computer monitor excessively large;

FIREFOX; desktop
--> excess space at bottom

//added by Mike, 20230111
increase the size of each tile to 64x64 from 32x32;
width, height;
clipWidth, clipHeight

Image32x32Tile
Image32x32TileTarget
Image32x32TileTargetBorder
Image32x32TileSpaceBorder
Image32x32TileSpaceTarget
Image32x32TileSpace
Image32x32TileFrame1
Image32x32TileFrame2


//added by Mike, 20230112
TO-DO: -verify: correct display design layout for Android mobile;
--> steps count NOT clearly displayed with 64x64px image tiles

*/



defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">

    <!-- Reference: Apache Friends Dashboard index.html -->
    <!-- "Always force latest IE rendering engine or request Chrome Frame" -->
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=yes" />
    <style type="text/css">
	/**/
	                    html, body
                        {
                            font-family: Arial;
							font-size: 11pt;
								
							/* edited by Mike, 20220911
							width: 640px; 
							*/
							width: 100%; /*90%; 80%;*/
							height: 100%;
									
							/*//added by Mike, 20221210*/
							background-color: #ffffff; /* white */
																					
							padding: 0;
							margin: 0;
							
							/* //added by Mike, 20221002
							//reference: https://www.w3schools.com/howto/howto_css_disable_text_selection.asp;
							//last accessed: 20221002
							*/
							
						    -webkit-user-select: none; /* Safari */
						    -ms-user-select: none; /* IE 10 and IE 11 */
						    user-select: none; /* Standard syntax */
							
							/* added by Mike, 20221012 */
							transform: scale(1.0);
							
							/* added by Mike, 20221119 */							
							touch-action: none;
						}
						
						/* added by Mike, 20220911 */
	                    body.bodyPortraitMode
                        {
                            font-family: Arial;
							font-size: 11pt;
							width: 100%; /*80%;*/
							height: 100%;
							padding: 0;
							margin: auto;
						}						

	                    body.bodyLandscapeMode
                        {
                            font-family: Arial;
							font-size: 11pt;
							width: 100%; /*80%;*/
							height: 100%; /*80%;*/
							padding: 0;
							margin: auto;
						}						
						
						canvas.myCanvas {
							
							/*width: 100%;*/ /*80%;*/ /*160px; */
							/*height: 100%;*/ /*80%;*/ /*144px;*/ 
							
							/*reference: https://stackoverflow.com/questions/5127937/how-to-center-canvas-in-html5; last accessed: 20220911
							answer by: Marco Luglio, 20111016T0357
							*/
							
							/*//added by Mike, 20221210*/
							background-color: #ffffff; /* white */
							visible: hidden;
							
							padding: 0;
							margin: auto;							
							display: block;
							
/* 							default VALUES; 
								TO-DO: -reverify: with mobile;
								TO-DO: -put: in reusable container 
*/
/*
							width: 320px;
							height: 288px;	
*/

							width: 640px;
							height: 576px;							

/*
							transform: scale(1.0,0.9);	
*/							
							
							/* //added by Mike, 20221104 */
							z-index: -1;							
						}
						
						canvas.myEffectCanvas {		
							position: absolute;
											
							padding: 0;
							margin: auto;					
							display: block;
					
							visibility: hidden;

							z-index: 99;							
						}						
						
						canvas.myHitByAttackEffectCanvas {		
							position: absolute;
											
							padding: 0;
							margin: auto;							
							display: block;
					
							visibility: hidden;

							z-index: 99;							
						}
						
						/*added by Mike, 20221121 */
						div.DivTextStatus
						{
							position: absolute;
/*	//edited by Mike, 20221213							
							background-color: #000000aa;
*/							
							background-color: #00000099;
							color: #ffffff; /*#ffbd00;*/ /* gold */

							border: 3px solid #ffffff;
							border-radius: 4px;		
							


							/*opacity: 50%;*/

							font-size: 2em; 							
							
							font-weight: bold;

/* //edited by Mike, 20230130							
							margin: 10px;
*/
							padding: 10px;

							visibility: hidden;	
							
							/* added by Mike, 20230128;
								put above tile images */
							z-index: 90; /*4;*/													
						}
						
						div.DivStepCountStatus
						{
							position: absolute;
/*							
							background-color: #000000aa;
*/							
							/*color: rgb(92,70,50);*/ /*#6d4e22; brown */

							color: #ffffff; /* white */
							/*color: #000000;*/ /* black */
							/*color: #2683D0;*/ /* blue */

							/*opacity: 50%;*/

							font-size: 4em; /*2em;*/ 							
							font-weight: bold;

							
/* //edited by Mike, 20230130							
							padding: 10px;
*/
							/* //changed from margin */
							/* //edited by Mike, 20230130 
							margin: 10px;
							*/
							padding: 0px;

							visibility: hidden;							
							
							/* put above image tiles;
								below step count button
							*/							
							z-index: 8; /*90;*/
						}	
						
						div.DivStepCountStatusShadow
						{
							position: absolute;
/*							
							background-color: #000000aa;
*/							
							color: #000000; /* black */

							/*opacity: 50%;*/

							font-size: 4em; /*2em;*/ 							
							font-weight: bold;
							
/* //edited by Mike, 20230130							
							padding: 10px;
*/
							/* //changed from margin */
							/* //edited by Mike, 20230130 
							margin: 10px;
							*/
							padding: 0px;


							visibility: hidden;							
							
							/* put above image tiles;
								below step count button
							*/							
							z-index: 8; /*90;*/
						}												
						
						div.DivTextEnter
						{
							position: absolute;
							/*background-color: #000000aa;*/
							color: #ffffff;

							/*opacity: 50%;*/

							font-size: 2em; /*16px;*/ 	
							
							font-weight: bold;

							/* //noted by Mike, 20230130 */
							padding: 10px;

							visibility: visible;							
						}						
																
						audio.myAudio
						{
							width: 416px;
							height: 312px;

							/* added by Mike, 20230115 */
							visibility: hidden;							
						}
						
						/* //added by Mike, 20221215 */
						span.puzzleRecordedStepsSpan
						{
							visibility: hidden;
						}
						
						a.executeLink
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
/* //edited by Mike, 20230130							
							margin: 12px;
*/
							padding: 12px;

							background-color: #ffe400;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 4px;		

							visibility: visible;							
						}

						a.pauseLink
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 2px;
							margin: 2px;
/*	//gold
							background-color: #ffe400;
							color: #222222;
*/
							background-color: rgb(60,60,60);
							color: rgb(60,60,60);

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 4px;		

							visibility: hidden; /*visible;*/							
						}

						a.pauseLink:active
						{
							background-color: rgb(20,20,20);
							color: rgb(20,20,20);						
						}
						/* //added by Mike, 20221113 */
						button:focus
						{
							outline:0;
						}
						
						/* //added by Mike, 20220917
						//reference: GAMEBOY COLOR;
						//US PATENT NO.5.095.798
						//to still exist?
						//PHILIPPINE PATENT?
						//
						//remembers: NOKIA mobile telephone (J2ME);
						//where: ACTION button @CENTER of DIRECTIONAL KEY;
						*/
						button.controlKeyButtonLeft, .controlKeyButtonRight, .controlKeyButtonUp, .controlKeyButtonDown, .controlKeyButtonLeverCenterNeutral
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 10px; /*12px;*/

							/*background-color: rgb(60,60,60);*/							
							/*color: rgb(60,60,60);*/ /*rgb(30,30,30);*/

							background-color: #3c3c3cAA; /*rgb(107,169,39);*/
							color: #3c3c3c00; /*rgb(107,169,39);*/ 

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;
							
							z-index: 99;
						}

						button:active { /* focus out after click */
/*	//bright
							background-color: rgb(120,120,120);
							color: rgb(120,120,120); 
*/
/*	//edited by Mike, 20230207
							background-color: rgb(20,20,20);
							color: rgb(20,20,20); 
*/
							background-color: #141414AA; /*rgb(107,169,39);*/
							color: #14141400; /*rgb(107,169,39);*/ 


						}
						
						/*
							TO-DO: -reverify: this;
							//remembers: XBOX 360 controller;
							//keyphrase: LED (Light Emitting Diode)
						*/
						
						button.controlKeyButtonLetterJ
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 8px;
							/*
							  background-color: rgb(123,196,45);							
							  color: rgb(123,196,45);
							*/
							background-color: #6ba927AA; /*rgb(107,169,39);*/
							color: #6ba92700; /*rgb(107,169,39);*/ 

							/*opacity: 80%;*/
							
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 90px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;
							
							z-index: 99;							
						}
						
						button.controlKeyButtonLetterJ:active { /* focus out after click */
							background-color: rgb(75,119,28);
							color: rgb(75,119,28); 
						}						
						
						button.controlKeyButtonLetterL
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 8px;
							background-color: rgb(183,0,0);							
							color: rgb(183,0,0);

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 90px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;
							
							z-index: 99;							
						}
						
						button.controlKeyButtonLetterL:active { 
							background-color: rgb(132,0,0);
							color: rgb(132,0,0); 
						}	
						
						button.controlKeyButtonLetterI
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 8px;
							background-color: rgb(237,203,10);							
							color: rgb(237,203,10);

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 90px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;

							z-index: 99;							
						}
						
						button.controlKeyButtonLetterI:active { 
							background-color: rgb(204,174,9);
							color: rgb(204,174,9); 
						}	
						
						button.controlKeyButtonLetterK
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 8px;
							background-color: rgb(9,46,145);							
							color: rgb(9,46,145);

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 90px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;
							
							z-index: 99;							
						}
						
						button.controlKeyButtonLetterK:active { 
							background-color: rgb(7,38,118);
							color: rgb(7,38,118); 
						}	
						
						/* //keyphrase: KEYBOARD */
						button.controlKeyButtonRightLeverCenterNeutral
						{
							left: 0px;
							top: 0px;
							position: absolute;
							
							padding: 8px;
							background-color: rgb(255,255,255); /*rgb(60,60,60);*/ /*rgb(12,139,79);	*/						
							color: rgb(255,255,255); /*rgb(60,60,60);*/ /*rgb(12,139,79);*/

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 90px; /*4px*/
							
							margin: 0px;
							
							visibility: hidden;
							
							z-index: 99;							
						}
						
						button.controlKeyButtonRightLeverCenterNeutral:active { 
							background-color: rgb(255,255,255); /*rgb(20,20,20);*/ /*rgb(9,100,56);*/
							color: rgb(255,255,255); /*rgb(20,20,20);*/ /*rgb(9,100,56);*/ 
						}	

						div.checkBox
						{
								border: 1.5pt solid black; height: 9pt; width: 9pt;
								text-align: center;
								float: left
						}
						
						div.option
						{
								padding: 2pt;
								display: inline-block;
						}
						
						div.copyright
						{
								text-align: center;
						}
						
						div.patientName
						{
							text-align: left;
						}						

						div.medicalDoctorName
						{
							text-align: left;
						}						
						
						div.tableHeader
						{
							font-weight: bold;
							text-align: center;
							background-color: #00ff00; <!--#93d151; lime green-->
							border: 1pt solid #00ff00;
						}					

						div.tableHeaderAddNewPatient
						{
							font-weight: bold;
							text-align: center;
							background-color: #ff8000; <!--#93d151; lime green-->
							border: 1pt solid #ff8000;
						}						
						
						input.browse-input
						{
							width: 100%;
							max-width: 500px;
														
							resize: none;

							height: 100%;
						}	
									
						img {
							visibility: hidden;
						}

						img.Image-companyLogo {
							max-width: 60%;
							height: auto;
							float: left;
							text-align: center;
							padding-left: 20px;
							padding-top: 10px;
						}

						img.Image-moscLogo {
							max-width: 20%;
							height: auto;
							float: left;
							text-align: center;
						}						
						
						table.addPatientTable
						{
							border: 2px dotted #ab9c7d;		
							margin-top: 10px;
						}						
						
						
						table.search-result
						{
<!--							border: 1px solid #ab9c7d;		
-->
						}						

						table.imageTable
						{
							width: 100%;
<!--							border: 1px solid #ab9c7d;		
-->
						}						

						table
						{
							border-collapse: collapse;
							 
							padding: 0;		
							margin: 0;

							/*added by: Mike, 20220830 */
							overflow: hidden;
							
							/*added by: Mike, 20220902; 
							  note: effect */							
							/*border: 1px dotted #ab9c7d;*/							
							
							/*added by Mike, 20220902;
							  still INCORRECT OUTPUT;
							display: block;
							max-width:640px;							
							*/
						}
						

						tr
						{
							padding: 0;		
							margin: 0;
						}						

						td 
						{
							padding: 0;		
							margin: 0;
						}						

						td.column
						{
							border: 1px dotted #ab9c7d;		
							text-align: right							
						}						
						
						td.imageColumn
						{
							width: 40%;
							display: inline-block;
						}				

						td.pageNameColumn
						{
							width: 50%;
							display: inline-block;
							text-align: right;
						}
						
						.Button-emptyStonePosCornerTopLeftPillar {
							padding: 10px;

							/*added by: Mike, 20220830 */
							overflow: hidden;								
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

/*	//removed by Mike, 20220830

							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;

							/* note: negative VALUE for opposite side */

							box-shadow:inset 2px 2px 0 0px black;		
						}

						.Button-emptyStonePosCornerTopLeftPillar:hover {
							background-color: #b80000;
							border-radius: 45px;
							box-shadow:inset 0px 0px 0 0px black;														
						}

						.Button-emptyStonePosCornerTopLeftPillar:focus {
							background-color: #b80000;
							box-shadow:inset 0px 0px 0 0px black;														
						}
						
						.Button-emptyStonePosCornerTopLeft {
							padding: 10px;

/* //added by Mike, 20220830
   //reference: https://stackoverflow.com/questions/3795888/extra-padding-on-chrome-safari-webkit-any-ideas;
   //last accessed: 20220830
   //"This has to do with the way margins collapse together so that two margins between elements don't accumulate."
   //answer by: Andrew Vit, 20100926T0001
*/
							overflow: hidden;	
							
							background-color: #ff9300;

/*	//removed by Mike, 20220830
							color: #222222;
*/

							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

/*	//removed by Mike, 20220830
							float: left;
*/
							margin: 0px;
						}

						.Button-emptyStonePosCornerTopLeft:hover {
							background-color: #b80000;
							border-radius: 45px;
						}

						.Button-emptyStonePosCornerTopLeft:focus {
							background-color: #b80000;
						}

/*
	TOP-RIGHT CORNER
*/
						.Button-emptyStonePosCornerTopRightPillar {
							padding: 10px;
							
							/*added by: Mike, 20220830 */
							overflow: hidden;	
														
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

							float: left;
							
							/* added by Mike, 20220830 */
							margin: 0px;
							
						
							/* note: negative VALUE for opposite side */
							box-shadow:inset -2px 2px 0 0px black;														
						}

						.Button-emptyStonePosCornerTopRightPillar:hover {
							background-color: #b80000;
							border-radius: 45px;
							box-shadow:inset 0px 0px 0 0px black;														
						}

						.Button-emptyStonePosCornerTopRightPillar:focus {
							background-color: #b80000;
							box-shadow:inset 0px 0px 0 0px black;														
						}
						
						.Button-emptyStonePosCornerTopRight {
							padding: 10px;

							/*added by: Mike, 20220830 */
							overflow: hidden;								
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

							/* removed by Mike, 20220830 */
/*							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;
						}

						.Button-emptyStonePosCornerTopRight:hover {
							background-color: #b80000;
							border-radius: 45px;
						}

						.Button-emptyStonePosCornerTopRight:focus {
							background-color: #b80000;
						}
						

/*
	BOTTOM-LEFT CORNER
*/
						.Button-emptyStonePosCornerBottomLeftPillar {
							padding: 10px;
							
							/*added by: Mike, 20220830 */
							overflow: hidden;							
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;


							/* removed by Mike, 20220830 */
/*							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;
							

							/* note: negative VALUE for opposite side */
							box-shadow:inset 2px -2px 0 0px black;														
						}

						.Button-emptyStonePosCornerBottomLeftPillar:hover {
							background-color: #b80000;
							border-radius: 45px;
							box-shadow:inset 0px 0px 0 0px black;														
						}

						.Button-emptyStonePosCornerBottomLeftPillar:focus {
							background-color: #b80000;
							box-shadow:inset 0px 0px 0 0px black;														
						}
						
						.Button-emptyStonePosCornerBottomLeft {
							padding: 10px;

							/*added by: Mike, 20220830 */
							overflow: hidden;								
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

							/* removed by Mike, 20220830 */
/*							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;
						}

						.Button-emptyStonePosCornerBottomLeft:hover {
							background-color: #b80000;
							border-radius: 45px;
						}

						.Button-emptyStonePosCornerBottomLeft:focus {
							background-color: #b80000;
						}
						
/*
	BOTTOM-RIGHT CORNER
*/
						.Button-emptyStonePosCornerBottomRightPillar {
							padding: 10px;

							/*added by: Mike, 20220830 */
							overflow: hidden;						
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

							/* removed by Mike, 20220830 */
/*							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;
						
							/* note: negative VALUE for opposite side */
							box-shadow:inset -2px -2px 0 0px black;														
						}

						.Button-emptyStonePosCornerBottomRightPillar:hover {
							background-color: #b80000;
							border-radius: 45px;
							box-shadow:inset 0px 0px 0 0px black;														
						}

						.Button-emptyStonePosCornerBottomRightPillar:focus {
							background-color: #b80000;
							box-shadow:inset 0px 0px 0 0px black;														
						}
						
						.Button-emptyStonePosCornerBottomRight {
							padding: 10px;
							
							/*added by: Mike, 20220830 */
							overflow: hidden;								
							
							background-color: #ff9300;
							color: #222222;
							font-size: 16px;
							font-weight: bold;

							border: 0px solid;		
							border-radius: 0px;

							/* removed by Mike, 20220830 */
/*							float: left;
*/
							/* added by Mike, 20220830 */
							margin: 0px;
						}

						.Button-emptyStonePosCornerBottomRight:hover {
							background-color: #b80000;
							border-radius: 45px;
						}

						.Button-emptyStonePosCornerBottomRight:focus {
							background-color: #b80000;
						}

						/* noted by Mike, 20221104 */
						.ImageBackgroundOfPuzzle {
							position: absolute;

							text-align: center;
							line-height: 32px;			
/*							
							box-shadow: 0 0 50px 15px grey;
*/							
							opacity: 60%;

																														visibility: hidden;
														
							/* //removed by Mike, 20221127
							transform: scale(0.5,0.8);	
							*/

							padding: 0;
							margin: auto;
							display: block;							
																					
							/* default VALUES; 
								TO-DO: -reverify: with mobile
							*/
/*
							width: 320px;
							height: 288px;	
*/

							width: 640px;
							height: 576px;	
							
							
							/* 
							object-fit: contain;
							*/
							
							/* //added by Mike, 20221104 */
							z-index: 0;	

							visibility: hidden;
							
						}

						.ImageBackgroundOfAction {
							position: absolute;

							text-align: center;
							line-height: 32px;							
																																visibility: hidden;
							
							/*transform: scale(0.5,0.8);	
							*/
														
							padding: 0;
							margin: auto;
							display: block;							
														
							width: 320px;
							height: 288px;
							
							/* 
							object-fit: contain;
							*/

							/* //added by Mike, 20221104 */
							z-index: 0;		
							
						}

						.ImageController, .ImageStepCount {
							position: absolute;
							
							text-align: center;
							line-height: 32px;
							
							visibility: hidden;
							
/*							//edited by Mike, 20221129
							width: 160px;
							height: 144px;					*/	
							
							/* default VALUES; 
								TO-DO: -reverify: with mobile
							*/
/*
							width: 320px;
							height: 288px;	
*/

							width: 640px;
							height: 576px;	
											
							/* //added by Mike, 20221104 */
							z-index: 15;									
						}
						
						.ImageHowToPlayGuide {
							position: absolute;

							text-align: center;
							line-height: 32px;
							
							visibility: hidden;
							
							/* default VALUES; 
								TO-DO: -reverify: with mobile
							*/
/*
							width: 320px;
							height: 288px;	
*/

							width: 640px;
							height: 576px;	
												
							z-index: 10;		
						}						


						 /* //added by Mike, 20221130 */
						.ImageTitle {
							position: absolute;

							text-align: center;
							line-height: 32px;
							
							visibility: hidden;

							/* //edited by Mike, 20230121
							//notes: @640px, excess shaking via MS EDGE Browser
							*/
							width: 480px; /*640px;*/
							
							object-fit: contain;

							z-index: 10;									
						}	

						.ImageMiniControllerLarge {
							position: absolute;

							width: 64px;
						    height: 64px;

							object-fit: contain;

							pointer-events: none;
							
							/* put above button */
							z-index: 20;		
							
							background: transparent;
							opacity: 80%;
							
							/* //changed from margin */
							padding: 10px;
							
							visibility: hidden;						
						}
						
						.ImageMiniStepCount {
							position: absolute;

/*	//edited by Mike, 20230128
							width: 32px;
						    height: 32px;
*/						    
							width: 64px;
						    height: 32px;

/*	//removed by Mike, 20230128
							object-fit: contain;
*/
							pointer-events: none;
							
							/* put above button */
							z-index: 20;		
							
							background: transparent;
							opacity: 80%;
							
							/* //changed from margin */
							/* //edited by Mike, 20230130 
							padding: 10px;
							*/
							margin: 0px;
							
							visibility: hidden;						
						}

						
						.ButtonControllerGuide {
							position: absolute;	
							width: 32px;
						    height: 32px;
							object-fit: contain;
  								  								
  							background: transparent; /*#ffffff;*/
  							border: none;
								
  							/*
							background:url("../assets/images/gameOff2022ControllerGuideButton.png") no-repeat;
							*/
																								margin: 10px;
							
							z-index: 20;	
							
							visibility: hidden;			
						}
						

						.ButtonStepCountGuide {
							position: absolute;	
/*	//edited by Mike, 20230128
							width: 32px;
						    height: 32px;
*/						    
							width: 64px;
						    height: 32px;
							object-fit: contain;
  								  								
  							background: transparent; /*#ffffff;*/
  							border: none;
								
  							/*
							background:url("../assets/images/gameOff2022ControllerGuideButton.png") no-repeat;
							*/
																								margin: 10px;
							
							/* //edited by Mike, 20230128
								put above the step count text;
								z-index: 20;	
							*/
							z-index: 99;	
							
							visibility: hidden;			
						}						
						
						.ButtonControllerGuide:active, .ButtonStepCountGuide:active {
							background: transparent; /*#ffffff;*/
  							border: none;							
						}


						/* noted by Mike, 20221105 */						
						.Image32x32Tile {
							position: absolute;
	
							/* //added by Mike, 20221113; edited by Mike, 20230111*/
/*
						    width: 128px;
						    height: 128px;
*/
/*
						    width: 256px;
						    height: 256px;							
*/
						    width: 512px;
						    height: 512px;							

							object-fit: contain;
	
							/* //added by Mike, 20221112; edited by Mike, 20230111 */
/*
  							clip: rect(0px,32px,32px,0px);
*/
/*
 							clip: rect(0px,64px,64px,0px);
*/
 							clip: rect(0px,128px,128px,0px);
	
							background-color: transparent;
							border: none;

							color: #222222;

							/* //removed by Mike, 20221111
							opacity: 0.5;*/
							
							font-weight: bold;
							font-size: 146%; /*20px;*/
							
							text-align: center;							
							line-height: 32px;

							/*padding-top: 0.1875%;*/ /*6px;*/

/* //removed by Mike, 20221112							
							border: 2px solid; 
							border-radius: 3px;
*/

							visibility: hidden;

							margin: 0px; /*1px;*/	
							padding: 0px;
							z-index: 3;		
							
						}

						/* noted by Mike, 20221105 */						
						.Image32x32TileTarget {
							position: absolute;
						    
/* //added by Mike, 20221113; edited by Mike, 20230111*/
/*
						    width: 128px;
						    height: 128px;
*/
/*
						    width: 256px;
						    height: 256px;							
*/
						    width: 512px;
						    height: 512px;								    
						    
							object-fit: contain;


							/* //added by Mike, 20221112; edited by Mike, 20230111 */
/*
  							clip: rect(0px,32px,32px,0px);
*/
/*
 							clip: rect(0px,64px,64px,0px);
*/
 							clip: rect(0px,128px,128px,0px);

	
/* //removed by Mike, 20221112
							width: 32px;
							height: 32px;
*/

/* //edited by Mike, 20221112 */
/*
							background-color: #ffffff;
*/
background-color: transparent;
border: none;
							color: #222222;

							/* //added by Mike, 20221111 
							   //TO-DO: -update: this
							*/
							opacity: 0.5;

							font-weight: bold;
							font-size: 146%; /*18px;*/

							text-align: center;							
							line-height: 32px;

							/*padding-top: 0.1875%;*/ /*6px;*/

/* //note: with clip rect border is put on entire sprite image */
/* //removed by Mike, 20221112
							border: 3px solid #ff0000;
							border-radius: 3px;
*/
							margin: 0px; /*1px;*/	
							padding: 0px;
							z-index: 4;		
						}
						
						.Image32x32TileTargetBorder {
							position: absolute;
/*
edited by Mike, 20230111
							width: 27px;
							height: 27px;
*/
/*
							width: 58px;
							height: 58px;
*/
							width: 116px;
							height: 116px;

							background-color: transparent;
							color: #222222;

							font-weight: bold;
							font-size: 146%; /*18px;*/

							text-align: center;		
/*							
							line-height: 32px;

							border: 3px solid #ff0000;
							border-radius: 3px;
*/
							line-height: 64px;

							border: 6px solid #ff0000;
							border-radius: 6px;

							visibility: hidden;

							margin: 0px;
							padding: 0px;
							z-index: 4;		
						}
						
						.Image32x32TileSpaceBorder {
							position: absolute;

/*
edited by Mike, 20230111
							width: 27px;
							height: 27px;
*/
/*
							width: 58px;
							height: 58px;
*/
							width: 116px;
							height: 116px;

							background-color: transparent;
							color: #222222;

							font-weight: bold;
							font-size: 146%; /*18px;*/

							text-align: center;			
/*							
							line-height: 32px;

							border: 3px solid #ffffff;
							border-radius: 3px;
*/
							line-height: 64px;

							border: 6px solid #ffffff;
							border-radius: 6px;

							visibility: hidden;

							margin: 0px;
							padding: 0px;
							z-index: 4;		
						}
						
						
						.Image32x32TileSpaceTarget {
							position: absolute;

/*
edited by Mike, 20230111
							width: 27px;
							height: 27px;
*/
/*
							width: 58px;
							height: 58px;
*/
							width: 116px;
							height: 116px;

							background-color: #000000; /*#ffffff;*/
							color: #222222;

							text-align: center;
/*							
							line-height: 32px;
						
							border: 3px solid #ffffff; /*#ff0000;*/
							border-radius: 3px;
*/
							line-height: 64px;
						
							border: 6px solid #ffffff; /*#ff0000;*/
							border-radius: 6px;

							margin: 0px;
							padding: 0px;
							z-index: 5;		
						}						
						
						/* added by Mike, 20221105 */
						.Image32x32TileSpace {
							position: absolute;
							
	/* //added by Mike, 20221113; edited by Mike, 20230111*/
/*
						    width: 128px;
						    height: 128px;
*/
/*
						    width: 256px;
						    height: 256px;							
*/
						    width: 512px;
						    height: 512px;		
							
							
							object-fit: contain;
														
							/* //added by Mike, 20221112; edited by Mike, 20230111 */
/*
  							clip: rect(0px,32px,32px,0px);
*/
/*
 							clip: rect(0px,64px,64px,0px);
*/
 							clip: rect(0px,128px,128px,0px);

	
/* //removed by Mike, 20221112
							width: 32px;
							height: 32px;
*/

/* //edited by Mike, 20221112 */
/*
							background-color: #222222;
*/
background-color: transparent;
border: none;
							color: #222222;

							text-align: center;
/*
							line-height: 32px;							
*/
							line-height: 64px;							

							margin: 0px; /*1px;*/	
							padding: 0px;	

							z-index: 3;		
						}
												
						
						/* added by Mike, 20221121 */
						.ImageMiniPuzzleImage {
							position: absolute;
							
							width: 64px;
						    height: 64px;
							object-fit: contain;

							z-index: 2;		
							
							visibility: hidden;						
						}				
						
						.ImageHealthTile {
							position: absolute;

							width: 20px;
							height: 5px;

							background-color: #00aa00;
							color: #222222;

							/*border: 2px solid #d6d6d6;*/
							/*
							border-top: 2px solid #000000;
							border-bottom: 2px solid #000000;
							*/

							visibility: hidden;

							margin: 5px;
							padding: 0px;
							z-index: 10;		
						}

						.ImageMonsterHealthTile {
							position: absolute;

							width: 20px;
							height: 5px;

							background-color: #ffda00;
							color: #222222;

							visibility: hidden;

							margin: 5px;
							padding: 0px;
							z-index: 10;		
						}
						
						.ImageHealthTileContainer {
							position: absolute;

							width: 20px;
							height: 5px;

							background-color: #000000;

							/*border: 2px solid #ffffff;*/
							visibility: hidden;

							margin: 5px;
							padding: 0px;
							z-index: 10;		
						}

						.ImageMonsterHealthTileContainer {
							position: absolute;

							width: 20px;
							height: 5px;

							background-color: #000000;

							/*border: 2px solid #ffffff;*/
							visibility: hidden;

							margin: 5px;	
							padding: 0px;
							z-index: 10;		
						}
															
						/* noted by Mike, 20220820
						using: absolute positions; 
						add: auto-identify IF mobile*/
						.Image64x64Tile {
							position: absolute;
/*
  							clip: rect(0px,64px,64px,0px);

*/ 							clip: rect(0px,128px,128px,0px);

							
							/* //added by Mike, 20221104 
								reverified: this
							*/
							z-index: 2;								
						}
						
						.Image64x64TileFrame1 {
							position: absolute;
/*							
  							clip: rect(0px,64px,64px,0px);
*/
  							clip: rect(0px,128px,128px,0px);


							/* //added by Mike, 20220904; removed by Mike, 20220904
								TO-DO: -verify: @set vertex, e.g. center */
							/*
								transform: rotate(-15deg);
							*/	

							visibility: hidden;
						}

						.Image64x64TileFrame2 {
							position: absolute;
  							/*clip: rect(0px,128px,64px,64px);*/

/*
  							clip: rect(0px,64px,64px,0px);
							object-position: -64px;
*/							
  							clip: rect(0px,128px,128px,0px);
							object-position: -128px;
							
						}
						
						.Image64x64TileBackground {
							position: absolute;
/*							
  							clip: rect(0px,64px,64px,0px);					
*/							
  							clip: rect(0px,128px,128px,0px);					
						}
						
						.Image32x32TileFrame1 {
							position: absolute;
							/* //added by Mike, 20221112; edited by Mike, 20230111 */
/*
  							clip: rect(0px,32px,32px,0px);
*/
/*
 							clip: rect(0px,64px,64px,0px);
*/
 							clip: rect(0px,128px,128px,0px);
						}

						.Image32x32TileFrame2 {
							position: absolute;
  							/*clip: rect(0px,128px,64px,64px);*/

							/* //added by Mike, 20221112; edited by Mike, 20230111 */
/*
  							clip: rect(0px,32px,32px,0px);
*/
/*
 							clip: rect(0px,64px,64px,0px);
*/
 							clip: rect(0px,128px,128px,0px);

/* //removed by Mike, 20221116							
							object-position: -32px;
*/							
						}						

						
						/* added by Mike, 20220825 
						reference: https://stackoverflow.com/questions/15533636/playing-sound-in-hidden-tag; last accessed: 20220825
						//answer by: couzzi, 20130320T2013						
						*/
						audio { 
							display:none;
						}
						

    /**/
    </style>
    <title>
      TIME OFF
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
    </style>

	<!--  
  <base href="http://store.usbong.ph/"> 
-->
  
  <!--target="_blank"-->
  
  </head>
	  <script>
	  
/*	  
//added by Mike, 20220910
//notes:	  Image32x32TileFrame2
--> verifying: Gameboy Control Scheme as executed on Mobile, e.g. ANDROID
--> "Keep the original GameBoy screen resolution of 160px x 144px."
--> https://itch.io/jam/gbjam-9; last accessed: 20220909	  

//added by Mike, 20221213
//TO-DO: -verify: adding ELAPSED TIME;
--> notes: SONIC#1 SEGA GAMEGEAR
*/	  
	  
//added by Mike, 20220912
//note: landscape screen size in SUPER FANTASY ZONE, DEFENDER ARCADE
//keyphrase: FLYING, PlayStation Portable, Nintendo Switch Lite
//current: gameboy color screen ratio; 160x144, w x h

/* //edited by Mike, 20221231
const iStageMaxWidth=160*2; //160;
const iStageMaxHeight=144*2; //144;
*/
/*
var iStageMaxWidth=160*4; //640
var iStageMaxHeight=144*4; //576

//added by Mike, 20230106
const iDefaultCanvasWidth=640;
const iDefaultCanvasHeight=576;
*/
var iDefaultCanvasWidth=640*2;//640;
var iDefaultCanvasHeight=576*2;//576;

var iStageMaxWidth=iDefaultCanvasWidth;//160*4; //640
var iStageMaxHeight=iDefaultCanvasHeight;//144*4; //576

var bHasSetMaxWidthHeight=false;
 
var iHorizontalOffset=0;
var iVerticalOffset=0;

//note: for INNER SCREEN
iHorizontalOffset=(screen.width)/2-iStageMaxWidth/2;

//added by Mike, 20221005
iVerticalOffsetInnerScreen=0;

//added by Mike, 20221119
var iHorizontalOffsetOfTargetBorder=0;

//added by Mike, 20221108
iCurrentAppleWebKitInnerWidth=0;

//added by Mike, 20221125
const iMyDefendedEffectCanvasContextRadius=50;
var iMyDefendedEffectCount=0;
const iMyDefendedEffectCountMax=10; //20; //6;
var bHasPressedActionCommand;

//added by Mike, 20221128
const iMyHitByAttackEffectCanvasContextRadius=30;
const iMyHitByAttackEffectCountMax=10; //20; //6;
var iMyHitByAttackEffectCount=iMyHitByAttackEffectCountMax;

//edited by Mike, 20221129
//1000/60=16.66; 60 frames per second
//1000/30=33.33; 30 frames 
const fFramesPerSecondDefault=16.66;
//const fFramesPerSecondDefault=33.33;
var fFramesPerSecond=fFramesPerSecondDefault;
var iCurrentIntervalId=-1;

//added by Mike, 20221118
var sBaseURL = '<?php echo base_url();?>';

//added by Mike, 20221115
var iCurrentMiniGame=0;
const MINI_GAME_PUZZLE=0;

//removed by Mike, 20221229
//const MINI_GAME_ACTION=1;

//added by Mike, 20221229
const MINI_GAME_LEADERBOARD=2;


//added by Mike, 20221118
var imgPuzzle;

//added by Mike, 20221213
var iStepCountStatus=0;


//added by Mike, 20221012; edited by Mike, 2022115
/*
let iHumanTileX = iStageMaxWidth/2;
let iHumanTileY = iStageMaxHeight/2;	
*/
/*
let iHumanTileX = 0;
let iHumanTileY = 0;

const iHumanTileWidth = 32;
const iHumanTileHeight = 32;

//edited by Mike, 20221126; from 20221120
const iImgMonsterTileWidth=64; //32;
const iImgMonsterTileHeight=64; //32;

//added by Mike, 20221126
var monsterTileYOffset=0;
const defaultMonsterTileYOffset=0;
*/

//added by Mike, 20220925
//note: for CONTROLLER BUTTONS
iVerticalOffset=(iStageMaxHeight+(screen.height/1.5-iStageMaxHeight));
	  	  
//added by Mike, 20220925
bIsMobile = false;	  

//added by Mike, 20221108
bIsUsingAppleWebKit=false;
//added by Mike, 20221108
iAppleWebKitInnerWidthOffset=0;
//added by Mike, 20221109
bIsUsingAppleMac=false;

//added by Mike, 20221110
bIsAudioPlaying=false;

//added by Mike, 20221121
iCurrentPuzzleStage=0;
bIsPuzzleDone=false;

//added by Mike, 20221124
fMyAudioVolume=1.0;
fMyAudioEffectVolume=1.0; //added by Mike, 20221126

//added by Mike, 20221124
const sAudioPuzzleStage0="assets/audio/UsbongGameOff2022Action20221119T1911.mp3";

const sAudioPuzzleStage1="assets/audio/UsbongGameOff2022PuzzleRhythm20221127from20211012.mp3";

//TO-DO: -update: this
const sAudioPuzzleStage2="assets/audio/UsbongGameOff2022Puzzle20221119T1427.mp3";

const sAudioAction="assets/audio/UsbongGameOff2022ActionPiano20221122T1542.mp3";

const sAudioEffectActionStart="assets/audio/UsbongGameOff2022ActionStartV20221126T0554.mp3";


//TO-DO: -add: END
//const sAudioPuzzleStage3="assets/audio/UsbongGameOff2022PuzzleEND.mp3";


//added by Mike, 20221124
//const sImagePuzzleStage0="assets/images/count1024x1024.png"
//const sImagePuzzleStage0="assets/images/allineedisonedreamNightwingAndHisDuckArmy.jpg"

const sImagePuzzleStage0="assets/images/count1024x1024.png";

const sImagePuzzleStage1="assets/images/allineedisonedreamNightwingAndHisDuckArmyZoomIn.jpg";

const sImagePuzzleStage2="assets/images/cambodia1024x1024-20141225T0958.jpg";

//added by Mike, 20221127
//"assets/images/mtPinatubo20150115T1415.jpg"
//edited by Mike, 20221210
//const sImagePuzzleBg="assets/images/mtPinatubo512x512-20150115T1415.jpg";
//const sImagePuzzleBg="assets/images/blankTime.png";
const sImagePuzzleBg="assets/images/buhangin512x512-20170422T0257.jpg";

//assets/images/assets/images/bgImageCave.png
const sImageActionBg="assets/images/bgImageCave512x512.png";


//added by Mike, 20221105
bIsTargetAtSpace = true;
		  
iTargetAtSpaceBlinkAnimationCount=0;
iTargetAtSpaceBlinkAnimationCountMax=6;
		  
//added by Mike, 20221106
iTargetTileBgCount=-1;		  

//added by Mike, 20221106
//note: 4x4
var iRowCount=0;
const iRowCountMax=4;
var iColumnCount=0;
const iColumnCountMax=4;
var arrayPuzzleTileCountId = []; 
var arrayPuzzleTilePos = [ [],[],[],[] ]; 

const iTileBgCountMax=iRowCountMax*iColumnCountMax;	

//added by Mike, 20221108
var iCountMovementStep=0;

//added by Mike, 20221213
const iCountInitMovementStepMax=15;
const iCountMovementStepMax=100-iCountInitMovementStepMax;

//added by Mike, 20221214
var arrayCountMovementStep= [];

var bIsInitAutoGeneratePuzzleFromEnd=false;
var iDelayAnimationCountMovementStep=0;
var iDelayAnimationCountMovementStepMax=6;

//added by Mike, 20221129
var iPrevDirection=0;

//added by Mike, 20221121
var iDelayAnimationCountEnter=0;
const iDelayAnimationCountEnterMax=10;

//added by Mike, 20250703
var iCongratsRestartDelayCount=0;
const iCongratsRestartDelayCountMax=300;//100;
var bHasPressedRestartPuzzleDone=false;

//added by Mike, 20250704
var bIsExecuteEndingAnimationDone=false; 
var iEndingAnimationDelayCount=0;
const iEndingAnimationDelayCountMax=15;

//added by Mike, 20221121
var iDelayCountToNextLevel=0;
const iDelayCountToNextLevelMax=100;

//added by Mike, 20221120
var iNoKeyPressCount=0;
const iNoKeyPressCountMax=100; //10;//0;// 512;

//added by Mike, 20221121
var iKeyPressCount=0;
const iKeyPressCountMaxBeforeMiniDisplay=100; 

var iMonsterAttackIndex=0;
var iMonsterAttackIndexFromTopToBottom=0;
var iMonsterAttackIndexFromBottomToTop=1;
var iMonsterAttackIndexFromLeftToRight=2;
var iMonsterAttackIndexFromRightToLeft=3;

const iCornerCountMax=4;	

var bIsMonsterExecutingAttack=false;
var bIsMonsterInHitState=false;

var iMonsterInHitStateCount=0;
const iMonsterInHitStateCountMax=20;
const iMonsterInDestroyedStateCountMax=40;
const iMonsterEndStateCountBeforeMax=180;
const iMonsterEndStateCountMax=200;

var iHumanInHitStateCount=0;
const iHumanInDestroyedStateCountMax=100;
const iHumanEndStateCountBeforeMax=180;


//added by Mike, 20221125
//reference: https://github.com/usbong/tugon/blob/main/mainLinux.cpp;
//last accessed: 20221125
var bIsExecutingDestroyHuman=false;
var iDestroyHumanShakeDelayCount=0;
var iDestroyHumanShakeDelayMax=5;

var iShakeOffsetWidthMax=2;
var iShakeOffsetHeightMax=2;

var iShakeOffsetWidth=iShakeOffsetWidthMax;
var iShakeOffsetHeight=iShakeOffsetHeightMax;

//added by Mike, 20221115
var bIsInitMiniGameAction=true;

//added by Mike, 20221108
var bIsToLeftCornerDone=false;
var bIsToTopCornerDone=false;
var bIsToRightCornerDone=false;
var bIsToBottomCornerDone=false;

//added by Mike, 20221114
var bHasPressedStart=false;

//added by Mike, 20221130
var bHasViewedTitle=false;

//added by Mike, 20221122
var bHasViewedControllerGuide=false;

//added by Mike, 20221129
var bHasViewedHowToPlayGuide=false;

var bIsHowToPlayGuideDisplayed=false;

//added by Mike, 20221123
var bIsActionKeyPressed=false;
var bHasHitMonster=false;
var bHasDefeatedMonster=false;
var bHasDefeatedHuman=false; //added by Mike, 20221127

var iPuzzleTileWidth=128;//64;
var iPuzzleTileHeight=128;//64;

//added by Mike, 20230123
const iPuzzleTileTotalWidthMax=iPuzzleTileWidth*iColumnCountMax;
const iPuzzleTileTotalHeightMax=iPuzzleTileHeight*iRowCountMax;

var iBorderOffset=0;
var iOffsetWidth=0;
var iOffsetHeight=0;
	  
/*	  
//added by Mike, 20220829
const iHumanTileAnimationCountMax=6; //12;//20; //6;
var iHumanTileAnimationCount=0;	  

//edited by Mike, 20221123; from 20221120
const iMonsterTileAnimationCountMax=6; //3;
var iMonsterTileAnimationCount=0;	  

//edited by Mike, 20221120; from 20220915
iMonsterStepY=10;
iMonsterStepX=10;

iMonsterTileY=0;
iMonsterTileX=0;

//added by Mike, 20221128
iHumanStepX=2; //5;
iHumanStepY=2; //5;

//added by Mike, 20221121
iMiniPuzzleWidth=128;//64;
iMiniPuzzleHeight=128;//64;
*/

//added by Mike, 20221029
iTouchStartX=0;
iTouchStartY=0;
iTouchEndX=0;
iTouchEndY=0;

iTouchStartCount=0;
iTouchEndCountMax=5;

//added by Mike, 20221115
var iFacingDirection=0;

const iFACING_DOWN=0;
const iFACING_UP=1;
const iFACING_LEFT=2;
const iFACING_RIGHT=3;

var bIsWalkingAction=false;

	  
//added by Mike, 20220822
//OK; this technique solves noticeable delay when holding the key press;
//can add simultaneous keypresses;
//edited by Mike, 20220823
//bKeyDownRight = false;
const iKEY_W = 0;
const iKEY_S = 1;
const iKEY_A = 2;
const iKEY_D = 3;

const iKEY_I = 4;
const iKEY_K = 5;
const iKEY_J = 6;
const iKEY_L = 7;


const iTotalKeyCount = 8; //4;

//added by Mike, 20221030
const iDirectionTotalKeyCount = 4;
//const iActionTotalKeyCount = 4;


//https://www.w3schools.com/js/js_arrays.asp; last accessed: 20220823
const arrayKeyPressed = [];
for (iCount=0; iCount<iTotalKeyCount; iCount++) {
	arrayKeyPressed[iCount]=false;
}

//added by Mike, 20221122
const iArrayHealthActionCountMax=8;
var iCurrentArrayHealthActionCount=8;
var arrayHealthAction = [];

//added by Mike, 20221122
const iArrayMonsterHealthActionCountMax=8;
var iCurrentArrayMonsterHealthActionCount=8;
var arrayMonsterHealthAction = [];


//added by Mike, 20221118
//reference: https://stackoverflow.com/questions/21246818/how-to-get-the-base-url-in-javascript;
//last accessed: 20221118
//answer by: Muhammad Raheel, 20140121T0707
function getBaseURL(){
    return sBaseURL;
}

//added by Mike, 20221122
function toggleControllerGuide() {
	//edited by Mike, 20221129
//	if (bHasPressedStart) {
	if ((bHasPressedStart) && (bHasViewedHowToPlayGuide)){	
		var controllerGuideImage = document.getElementById("controllerGuideImageId");
	
		//added by Mike, 20221122
		var controllerGuideButton = document.getElementById("controllerGuideButtonId");
		//remove focus on clicked button
		//to NOT execute when ENTER key is pressed;
		controllerGuideButton.blur();

		var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
		var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");

		var stepCountGuideImage = document.getElementById("stepCountGuideImageId");			
		var stepCountGuideButton = document.getElementById("stepCountGuideButtonId");

		stepCountGuideImage.style.visibility = "hidden";
		stepCountGuideButton.blur();
		stepCountGuideButton.style.visibility = "hidden";		

/*				
		if (controllerGuideImage.style.visibility=="hidden") {
			controllerGuideImage.style.visibility = "visible";
			
			stepCountStatusDiv.style.visibility = "hidden";
			stepCountStatusShadowDiv.style.visibility = "hidden";			
		}
		else {
			controllerGuideImage.style.visibility = "hidden";

			stepCountStatusDiv.style.visibility = "visible";
			stepCountStatusShadowDiv.style.visibility = "visible";
			
			//remove focus on clicked button
			//to NOT execute when ENTER key is pressed;
			stepCountGuideButton.blur();

			stepCountGuideImage.style.visibility = "hidden";					
		}			
*/		
		
/*		
//added by Mike, 20230115
//------		
		var controllerGuideImage = document.getElementById("controllerGuideImageId");			
		var controllerGuideButton = document.getElementById("controllerGuideButtonId");

		//remove focus on clicked button
		//to NOT execute when ENTER key is pressed;
		controllerGuideButton.blur();

		controllerGuideImage.style.visibility = "hidden";
//------			
*/
	}
}

//added by Mike, 20230113
//TODO: -fix: this with controller guide
function toggleStepCountGuide() {
	//edited by Mike, 20221129
//	if (bHasPressedStart) {
	if ((bHasPressedStart) && (bHasViewedHowToPlayGuide)){	
		var stepCountGuideImage = document.getElementById("stepCountGuideImageId");			
	
		var stepCountGuideButton = document.getElementById("stepCountGuideButtonId");

		var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
		var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");
		
		//remove focus on clicked button
		//to NOT execute when ENTER key is pressed;
		stepCountGuideButton.blur();
	
	//alert("dito");					
		if (stepCountGuideImage.style.visibility=="hidden") {
			stepCountGuideImage.style.visibility = "visible";
/*			
			stepCountStatusDiv.style.visibility = "hidden";
			stepCountStatusShadowDiv.style.visibility = "hidden";		
*/			
		}
		else {
			stepCountGuideImage.style.visibility = "hidden";
/*			
			stepCountStatusDiv.style.visibility = "visible";
			stepCountStatusShadowDiv.style.visibility = "visible";		
*/			
		}			
		
		//added by Mike, 20230115
//------		
		var controllerGuideImage = document.getElementById("controllerGuideImageId");			
		var controllerGuideButton = document.getElementById("controllerGuideButtonId");

		//remove focus on clicked button
		//to NOT execute when ENTER key is pressed;
		controllerGuideButton.blur();

		controllerGuideImage.style.visibility = "hidden";
//------		
	}
}


//added by Mike, 20221129
function toggleHowToPlayGuide() {
	if (bHasPressedStart) {
		var howToPlayGuideImage = document.getElementById("howToPlayGuideImageId");
		var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
		var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");
		
		//alert("dito");		
			
		if (howToPlayGuideImage.style.visibility=="hidden") {
			howToPlayGuideImage.style.visibility = "visible";
			
			stepCountStatusDiv.style.visibility = "hidden";
			stepCountStatusShadowDiv.style.visibility = "hidden";
		}
		else {
			howToPlayGuideImage.style.visibility = "hidden";

			stepCountStatusDiv.style.visibility = "visible";
			stepCountStatusShadowDiv.style.visibility = "visible";
		}			
	}
}

//added by Mike, 20221120
function changeMiniGame(iMiniGameId) {
//	alert("HALLO!");
	
	if (iCurrentMiniGame==MINI_GAME_PUZZLE){
		if (iMiniGameId!=MINI_GAME_PUZZLE) {
			removeFromPuzzleStageExcessTiles();

			//added by Mike, 20221126
			var myAudio = document.getElementById("myAudioId");
			//myAudio.pause();
			
			if (myAudio.src!=getBaseURL()+sAudioPuzzleStage0) {
				myAudio.setAttribute("src", getBaseURL()+sAudioPuzzleStage0);
			}
	
			fMyAudioVolume=0.1;						
			myAudio.volume=fMyAudioVolume;
			
			//removed by Mike, 20230819
            //myAudio.play();


/*
						var myAudio = document.getElementById("myAudioId");

						myAudio.setAttribute("src", getBaseURL()+sAudioAction);

						//edited by Mike, 20221125
						//myAudio.volume=0.2;						
						fMyAudioVolume=0.2;						
						myAudio.volume=fMyAudioVolume;

						myAudio.play();
*/

		}
	}

	iCurrentMiniGame=iMiniGameId;

	//added by Mike, 20221120
	bIsInitMiniGameAction=false;
}

function removeFromPuzzleStageExcessTiles() {
	//iTileBgCountMax = 16
	for (let iTileBgCount=0; iTileBgCount<iTileBgCountMax; iTileBgCount++) {		
		arrayPuzzleTileCountId[iTileBgCount] = document.getElementById("puzzleTileImageIdBg"+iTileBgCount);
		
		arrayPuzzleTileCountId[iTileBgCount].style.visibility="hidden";
	}	
	
	//added by Mike, 20221119
	var puzzleTileImageTargetBorder = document.getElementById("divPuzzleTileImageTargetBorderId");
	
	puzzleTileImageTargetBorder.style.visibility="hidden";
	
	//added by Mike, 20221121
	var puzzleTileImageSpaceBorder = document.getElementById("divPuzzleTileImageSpaceBorderId");
	
	puzzleTileImageSpaceBorder.style.visibility="hidden";	
}

//--
//note: learned: to be doable via Android (Samsung Galaxy S Duos)
//after observing successful execution of the following:
//1) https://invertedhat.itch.io/postie; last accessed: 20221031; from 20221031
//2) https://allalonegamez.itch.io/rewind-time; last accessed: 20220825
//
//reference: https://developer.mozilla.org/en-US/docs/Web/API/Fullscreen_API;
//last accessed: 20220825
function toggleFullScreen() {		

//alert("HALLO");

  //added by Mike, 20221129
  //put this before bHasPressedStart=true;
 
/* 
  if (bHasPressedStart) { 
 	if (!bHasViewedHowToPlayGuide) {
		bHasViewedHowToPlayGuide=true;
		
		var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
		var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");		
		
		stepCountStatusDiv.style.visibility = "visible";
		stepCountStatusShadowDiv.style.visibility = "visible";
		
		return;
	}
  }
*/
  var titleImage = document.getElementById("titleImageId");	
  var howToPlayGuideImage = document.getElementById("howToPlayGuideImageId");	

  //bIsPuzzleDone=true;
  if (bIsPuzzleDone) {
	  //added by Mike, 20250704
	  if (!bIsExecuteEndingAnimationDone) {
		  return;
	  }
	  
	  //edited by Mike, 20250703
	  //alert("DITO!!");
	  if (iCongratsRestartDelayCount==iCongratsRestartDelayCountMax) {
		  //if (bHasPressedRestartPuzzleDone) {
			  titleImage.style.visibility="hidden";
			  howToPlayGuideImage.style.visibility = "hidden";
			  window.location.href = "";
			  
			  return;
		  //}
	  }

	  if (!bHasPressedRestartPuzzleDone) {
		  bHasPressedRestartPuzzleDone=true;
		  iCongratsRestartDelayCount=iCongratsRestartDelayCountMax;
	  }
  }
	
  if (!bHasViewedTitle) {
    titleImage.style.visibility="hidden";
    bHasViewedTitle=true;	
  }
 
  
  if (bHasViewedTitle) { 
 	if (!bHasViewedHowToPlayGuide) {
	  bHasViewedHowToPlayGuide=true;	  
	  howToPlayGuideImage.style.visibility = "visible"; 
	  return;
    }
	else {
	//alert("DITO");	
      howToPlayGuideImage.style.visibility = "hidden"; 
  
	  if (bHasPressedStart) {
		  if (bIsInitAutoGeneratePuzzleFromEnd) {
			//alert(">>>>>>> DITO");	

			iDelayAnimationCountMovementStepMax=0;
			howToPlayGuideImage.style.visibility = "hidden"; 
			bIsHowToPlayGuideDisplayed=false;
			return;
		  }
	  }

	  //added by Mike, 20221114	
	  bHasPressedStart=true;	  
	}
  }

/*
//  if (!bHasViewedHowToPlayGuide) {
  if (!bIsHowToPlayGuideDisplayed) {
	  howToPlayGuideImage.style.visibility = "visible"; 
	  bIsHowToPlayGuideDisplayed=true;
  }
  else {
	  howToPlayGuideImage.style.visibility = "hidden"; 
	  bIsHowToPlayGuideDisplayed=false;
  }
*/  



/*
  
  //added by Mike, 20221129
  var textEnterDiv = document.getElementById("textEnterDivId");

		
  //added by Mike, 20221108
  //note: fullscreenElement command 
  //does NOT execute on AppleWebKit, e.g. iPad 15
  //added by Mike, 20221110
  if (!bIsUsingAppleWebKit) {
	  if (!document.fullscreenElement) {
		  
		//edited by Mike, 20221127
		//document.documentElement.requestFullscreen();
		
		if ((!bIsMobile) || (bIsUsingAppleMac)) {				
		}
		else {
			document.documentElement.requestFullscreen();
		}

//////removed by Mike, 20230819
////		document.getElementById("myAudioId").play();
////		bIsAudioPlaying=true;
////				//alert("hallo");

	  } else if (document.exitFullscreen) {
		//added by Mike, 20221020
		//pauseAudio();
		document.getElementById("myAudioId").pause();

		//added by Mike, 20221110
		bIsAudioPlaying=false;
		
		document.exitFullscreen();
	  }
  }
  else {
	  if (!bIsAudioPlaying) {
//// //removed by Mike, 20230819
//////			alert("play");
////		document.getElementById("myAudioId").play();		  
////		bIsAudioPlaying=true;
      }
	  else {
//			alert("pause");
		document.getElementById("myAudioId").pause();
		bIsAudioPlaying=false;
	  }
  }
*/  
}

document.addEventListener("keydown", (e) => {
	
  //alert("e.key: "+e.key);
	
  if (e.key === "Enter") {
	toggleFullScreen();
  }
  
  //added by Mike, 20221101; removed by Mike, 20221101
/*
  //note: shall need to override existing pre-written ACTIONS
  if (e.key === "Escape") {
//		  alert("dito");
	toggleFullScreen();
  }
*/
}, false);
//--

//added by Mike, 20221112
//note: execute this due to broken image icon appears using Google Chrome
function autoUpdatePuzzleTileImage() {
	iTileBgCount=0; //0+1;//0;

//removed by Mike, 20221113
	//iCount=0;

/* //edited by Mike, 2022113
	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
*/			
	while (iTileBgCount<16) {
			if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
			//	alert(iTileTextCount);
					
			//notes: noticeable DELAY to fix OUTPUT error;
			//where: IF SPACE tile (BLINKING) is immediately 
			//to the left of tile with text "15", 
			//the tiles that were exchanged
			//to be located below or right of it
			//are INCORRECTLY displayed as also the SPACE tile,
			//albeit NOT BLINKING 
			//elapsed time: 5hrs (approx);
			//technique to solve: CLARIFY; verify significance
			//example: VALUE : arrayPuzzleTileCountId, iTileBgCount;
			//to get iRowCount and iColumnCount position
			//--> example OUTPUT VALUE: "15"

			//note: Tile Space; target number become its own	
			//clip
/* //edited by Mike, 20230111			
			arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-96px -96px";
*/

//			arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-192px -192px";
			//arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-384px -384px";
			arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-"+iPuzzleTileWidth*3+"px -"+iPuzzleTileHeight*3+"px";
			
				
			}
			else {
			
			//added by Mike, 20221113
			iTileTextCount=parseInt(arrayPuzzleTileCountId[iTileBgCount].alt);
					
				iColumnCount = (iTileTextCount-1)%4;
				iRowCount = Math.floor((iTileTextCount-1)/4);

/* //edited by Mike, 20230111			
				//x, y
				arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-" + iColumnCount*32 + "px -" + iRowCount*32 + "px";
*/

//				arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-" + iColumnCount*64 + "px -" + iRowCount*64 + "px";
				//arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-" + iColumnCount*128 + "px -" + iRowCount*128 + "px";
				
				arrayPuzzleTileCountId[iTileBgCount].style.objectPosition = "-" + iColumnCount*iPuzzleTileWidth + "px -" + iRowCount*iPuzzleTileHeight + "px";
				
			}
				
			iTileBgCount++;
	}	
}


//added by Mike, 20221111
//function autoVerifyPuzzleIfAtEnd() {
function isAutoVerifiedPuzzleDone() {

	if (!bIsInitAutoGeneratePuzzleFromEnd) {
		iTileBgCount=0;

		for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {
			for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
				//alert(iTileBgCount);

				if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
				}				
				else if (arrayPuzzleTileCountId[iTileBgCount].alt!=(iTileBgCount+1)) {
					return false;
				}			
				
				iTileBgCount++;
			}
		}
		
		//removed by Mike, 20221121
		//alert("DONE!");
		return true;
	}	
}

//added by Mike, 20250704
function executeEndingAnimation() {
	var textStatusDiv = document.getElementById("textStatusDivId");
	
	var starPuzzleTileImage = document.getElementById("starPuzzleTileImageIdBg");
	var puzzleTileImageTargetBorder = document.getElementById("divPuzzleTileImageTargetBorderId");
	
	puzzleTileImageTargetBorder.style.visibility = "hidden";

	if (!bIsExecuteEndingAnimationDone) {

		if (iEndingAnimationDelayCount<iEndingAnimationDelayCountMax) {
			iEndingAnimationDelayCount++;
			return;
			
		}
		else {
			iEndingAnimationDelayCount=0;
		}

		iTileBgCount=0;

		for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {
			for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
	/*
				alert("iTileBgCount: "+iTileBgCount);
				alert("iTargetTileBgCount: "+iTargetTileBgCount);
	*/
				if (arrayPuzzleTileCountId[iTileBgCount].style.visibility!="hidden") {
					arrayPuzzleTileCountId[iTileBgCount].style.visibility="hidden";					
					return false;
				}				

				iTileBgCount++;
			}			
		}
	}
	
	//alert("DITO!!");
	bIsExecuteEndingAnimationDone=true;
	
	starPuzzleTileImage.style.left=arrayPuzzleTileCountId[iTileBgCountMax-1].style.left;
	starPuzzleTileImage.style.top=arrayPuzzleTileCountId[iTileBgCountMax-1].style.top;	
	starPuzzleTileImage.style.visibility="visible";
	
	return true;
}

//added by Mike, 20221108
//note: Carnage Heart from Videogame Magazines, Artificial Intelligence 
function autoGeneratePuzzleFromEnd() {

		//sRecordedSteps="3121220312133003112111302212133333303312003030030303133122112122121303033033311212002";

	var puzzleRecordedStepsSpan = document.getElementById("puzzleRecordedStepsId");
	sRecordedSteps=puzzleRecordedStepsSpan.innerHTML;

/*
	arrayKeyPressed[iKEY_A]=true;	
	arrayKeyPressed[iKEY_K]=true;
*/
	
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
		
/*		
		//added by Mike, 20221111; removed by Mike, 20221111
		//note: add to quickly verify end OUTPUT
		bIsInitAutoGeneratePuzzleFromEnd=false;
		return;
*/	
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
	
	
	//reference: https://www.w3schools.com/jsref/jsref_random.asp;
	//last accessed: 20221108
	//number between 0 and 4; integer only	
//	for (iCount=0; iCount<iCountMovementStepMax; iCount++) {
	
	if (iCountMovementStep<iCountMovementStepMax) {
		
		//edited by Mike, 20221214; from 20221129
		//random
		//let iDirection = window.parseInt(Math.random() * 4);	
		
		//OK
		let iDirection=parseInt(sRecordedSteps.substr(iCountMovementStep,1));		

		
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
		
		//added by Mike, 20221214
		arrayCountMovementStep[iCountMovementStep]=iDirection;
			
		
		iCountMovementStep++;
	}	
	else {		
		bIsInitAutoGeneratePuzzleFromEnd=false;

/*		//TO-DO: -add: in Database, with datetime stamp
		//added by Mike, 20221214
		var sRecordedSteps="";
		
		for (let iCount=0; iCount<iCountMovementStep; iCount++) {		
			sRecordedSteps=sRecordedSteps.concat(arrayCountMovementStep[iCount]);
		}
		
		
		//OK
		//example output: 3121220312133003112111302212133333303312003030030303133122112122121303033033311212002
		alert(sRecordedSteps);
*/				
	}	
	
}

// NOTE:
//reference: https://stackoverflow.com/questions/8663246/javascript-timer-loop;
//last accessed: 20220424
//answer by: keyboardP, 20111229T0158
//edited by: Ken Browning, 20111229T0200
//edited by Mike, 20220820
function myUpdateFunction() {

//	iCurrentMiniGame=MINI_GAME_ACTION;
//	iCurrentMiniGame=MINI_GAME_LEADERBOARD;

	//added by Mike, 20221115
    switch(iCurrentMiniGame) {
    	case MINI_GAME_PUZZLE:
			miniGamePuzzleUpdate();
    	break;

/*	//removed by Mike, 20221210
    	case MINI_GAME_ACTION:
			miniGameActionUpdate();
    	break;
*/    	
		//added by Mike, 20221229
    	case MINI_GAME_LEADERBOARD:
			miniGameLeaderboardUpdate();
    	break;


    }
}

//added by Mike, 20221229
//TO-DO: -update: this

function miniGameLeaderboardUpdate() {
	var imgUsbongLogo = document.getElementById("usbongLogoId");
	//imgUsbongLogo.style.visibility="hidden";
		
	//added by Mike, 20221130
	var titleImage = document.getElementById("titleImageId");	
	//titleImage.style.visibility="hidden";
	
	var iTitleImageWidth = (titleImage.clientWidth);
	var iTitleImageHeight = (titleImage.clientHeight);	
		
	//added by Mike, 20221122
	var controllerGuideImage = document.getElementById("controllerGuideImageId");	
	//controllerGuideImage.style.visibility = "hidden"; //hidden

	var iControllerGuideImageWidth = (controllerGuideImage.clientWidth);
	var iControllerGuideImageHeight = (controllerGuideImage.clientHeight);	
	
	var controllerGuideMiniImage = document.getElementById("controllerGuideMiniImageId");		
	//removed by Mike, 20221129
//	controllerGuideMiniImage.style.visibility = "visible"; 
		
	var controllerGuideButton = document.getElementById("controllerGuideButtonId");	


//added by Mike, 20221129	
	var howToPlayGuideImage = document.getElementById("howToPlayGuideImageId");	
	//howToPlayGuide.style.visibility="hidden";
	
	var iHowToPlayGuideImageWidth = (howToPlayGuideImage.clientWidth);
	var iHowToPlayGuideImageHeight = (howToPlayGuideImage.clientHeight);	

/* //removed by Mike, 20221229
	if (bHasPressedStart) {
		if (!bHasViewedHowToPlayGuide) {	
			howToPlayGuideImage.style.visibility = "visible"; 
		}
		else {
			//removed by Mike, 20221129
			//bIsInitAutoGeneratePuzzleFromEnd=true;
			howToPlayGuideImage.style.visibility = "hidden"; 
		}
	}
*/

	//added by Mike, 20221104; edited by Mike, 20221118
//	var imgPuzzle;
	if (document.getElementById("puzzleImageId")==null) {
		//alert("dito");
		//reference: https://www.w3schools.com/jsref/met_node_removechild.asp;
		//last accessed: 2022118
		const imgPuzzleChild = document.adoptNode(imgPuzzle);
		document.body.appendChild(imgPuzzleChild);		
	}

	imgPuzzle = document.getElementById("puzzleImageId");

    //edited by Mike, 20221121; 
    //reverify: if solves noticeable DELAY in loading image file			
	//alert(imgPuzzle.src);	
	//edited by Mike, 20221210
//	if (!imgPuzzle.src.toLowerCase().includes("pinatubo")) {
	if (!imgPuzzle.src.toLowerCase().includes("buhangin")) {
		//added by Mike, 2022118
		imgPuzzle.setAttribute("src", getBaseURL()+sImagePuzzleBg);
		imgPuzzle.setAttribute("class", "ImageBackgroundOfPuzzle");	
	}

	//added by Mike, 20221105
	imgPuzzle.style.visibility="visible";		
	imgPuzzle.style.zIndex=0; //added by Mike, 20221118
	
	
/*	
	//added by Mike, 20220912	
	var pauseLink = document.getElementById("pauseLinkId");
	var iPauseLinkHeight = (pauseLink.clientHeight);//+1; + "px";
	var iPauseLinkWidth = (pauseLink.clientWidth);//+1; + "px"

	//		alert("screen.height: "+screen.height); //533
*/


	//reference: https://www.w3schools.com/tags/canvas_fillrect.asp; 
	//last accessed: 2020911
	var myCanvas = document.getElementById("myCanvasId");
	var myCanvasContext = myCanvas.getContext("2d");
	//TO-DO: -add: center align of bigger window 
	//TO-DO: -reverify: this

	//removed by Mike, 20221210
	//myCanvasContext.fillRect(0, 0, iStageMaxWidth, iStageMaxHeight);	


//alert (iHorizontalOffset);

//added by Mike, 20221002; edited by Mike, 20221005
//myCanvas.style.top = (0)+"px"; //iVerticalOffset+
myCanvas.style.top = (iVerticalOffsetInnerScreen+0)+"px"; //iVerticalOffset+

	//added by Mike, 20221012
	iHorizontalOffset=myCanvas.getBoundingClientRect().x;

	//added by Mike, 20221118
	imgPuzzle.style.top = (iVerticalOffsetInnerScreen+0)+"px";
	imgPuzzle.style.left = (iHorizontalOffset+0)+"px";

}

function miniGamePuzzleUpdate() {
	var imgUsbongLogo = document.getElementById("usbongLogoId");
	//imgUsbongLogo.style.visibility="hidden";
		
	//added by Mike, 20221130
	var titleImage = document.getElementById("titleImageId");	
	//titleImage.style.visibility="hidden";
	
	var iTitleImageWidth = (titleImage.clientWidth);
	var iTitleImageHeight = (titleImage.clientHeight);	
		
	//added by Mike, 20221122
	var controllerGuideImage = document.getElementById("controllerGuideImageId");	
	//controllerGuideImage.style.visibility = "hidden"; //hidden

/* //removed by Mike, 20230106
	var iControllerGuideImageWidth = (controllerGuideImage.clientWidth);
	var iControllerGuideImageHeight = (controllerGuideImage.clientHeight);	
*/
	
	var controllerGuideMiniImage = document.getElementById("controllerGuideMiniImageId");		
	//removed by Mike, 20221129
//	controllerGuideMiniImage.style.visibility = "visible"; 
		
	var controllerGuideButton = document.getElementById("controllerGuideButtonId");	

	//added by Mike, 20230115
	var stepCountGuideImage = document.getElementById("stepCountGuideImageId");	
	//stepCountGuideImage.style.visibility = "hidden"; //hidden

	
	//added by Mike, 20230113
	var stepCountGuideMiniImage = document.getElementById("stepCountGuideMiniImageId");		
	//removed by Mike, 20230113
//	controllerGuideMiniImage.style.visibility = "visible"; 
		
	var stepCountGuideButton = document.getElementById("stepCountGuideButtonId");	

	stepCountGuideMiniImage.visibility = "hidden";
	stepCountGuideImage.style.visibility = "hidden";
	stepCountGuideButton.style.visibility = "hidden";	
	stepCountGuideButton.blur();
		
	
	//added by Mike, 20230128
	//note: max to be 999
	//iStepCountStatus=999;

	if (iStepCountStatus>999) {
		iStepCountStatus=999;
	}

	//added by Mike, 20221213
	var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
	//note: correct sequence to cause correct OUTPUT
	stepCountStatusDiv.innerHTML = iStepCountStatus;
	//edited by Mike, 20230128
	//var iStepCountStatusDivWidth = (stepCountStatusDiv.clientWidth);	
	var iStepCountStatusDivWidthOffset=5;
	var iStepCountStatusDivWidth = (stepCountStatusDiv.clientWidth)+iStepCountStatusDivWidthOffset;	

	var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");
	stepCountStatusShadowDiv.innerHTML = iStepCountStatus;
	//edited by Mike, 20230128
	//var iStepCountStatusShadowDivWidth = (stepCountStatusShadowDiv.clientWidth);	
	var iStepCountStatusShadowDivWidth = (stepCountStatusShadowDiv.clientWidth)+iStepCountStatusDivWidthOffset;	
	
	//added by Mike, 20221130
	if (!bHasViewedTitle) {
		titleImage.style.visibility="visible";
	}

/*
	//edited by Mike, 20221129
	if (bHasPressedStart) {
		//added by Mike, 20221130
		//var titleImage = document.getElementById("titleImageId");	
		titleImage.style.visibility="hidden";
		bHasViewedTitle=true;
	
	 	if (bHasViewedHowToPlayGuide) {	
			controllerGuideButton.style.visibility = "visible"; 
			controllerGuideMiniImage.style.visibility = "visible"; 

			//added by Mike, 20230113
			stepCountGuideButton.style.visibility = "visible"; 
			//removed by Mike, 20230710
			//stepCountGuideMiniImage.style.visibility = "visible"; 

			//added by Mike, 20221213
			stepCountStatusDiv.style.visibility = "visible";
			stepCountStatusShadowDiv.style.visibility = "visible";
		}
		//added by Mike, 20221129
		else {
			controllerGuideMiniImage.style.visibility = "hidden"; 

			//added by Mike, 20221213
			stepCountStatusDiv.style.visibility = "hidden";
			stepCountStatusShadowDiv.style.visibility = "hidden";
		}
	}
	
	//added by Mike, 20221129	
	var howToPlayGuideImage = document.getElementById("howToPlayGuideImageId");	
	//howToPlayGuide.style.visibility="hidden";
	
	var iHowToPlayGuideImageWidth = (howToPlayGuideImage.clientWidth);
	var iHowToPlayGuideImageHeight = (howToPlayGuideImage.clientHeight);	


	if (bHasPressedStart) {
		if (!bHasViewedHowToPlayGuide) {	
			howToPlayGuideImage.style.visibility = "visible"; 

			stepCountStatusDiv.style.visibility = "hidden"; 
			stepCountStatusShadowDiv.style.visibility = "hidden"; 	
		}
		else {
			//removed by Mike, 20221129
			//bIsInitAutoGeneratePuzzleFromEnd=true;
			howToPlayGuideImage.style.visibility = "hidden"; 
		}
	}
*/


	
	//added by Mike, 20221129	
	var howToPlayGuideImage = document.getElementById("howToPlayGuideImageId");	
	//howToPlayGuide.style.visibility="hidden";
	
	var iHowToPlayGuideImageWidth = (howToPlayGuideImage.clientWidth);
	var iHowToPlayGuideImageHeight = (howToPlayGuideImage.clientHeight);	
		
	var stepCountStatusDiv = document.getElementById("stepCountStatusDivId");
	var stepCountStatusShadowDiv = document.getElementById("stepCountStatusShadowDivId");	
	
/*	
	if (bHasPressedStart) {
		
		//added by Mike, 20221130
		//var titleImage = document.getElementById("titleImageId");	
		titleImage.style.visibility="hidden";
		
		bHasViewedTitle=true;
	
	 	if (bHasViewedHowToPlayGuide) {	
			controllerGuideButton.style.visibility = "visible"; 
			controllerGuideMiniImage.style.visibility = "visible"; 

			//added by Mike, 20230113
			stepCountGuideButton.style.visibility = "visible"; 
			//removed by Mike, 20230710
			//stepCountGuideMiniImage.style.visibility = "visible"; 

////			//added by Mike, 20221213
////			stepCountStatusDiv.style.visibility = "visible";
////			stepCountStatusShadowDiv.style.visibility = "visible";
			
			howToPlayGuideImage.style.visibility = "hidden"; 
		}
		//added by Mike, 20221129
		else {
			controllerGuideMiniImage.style.visibility = "hidden"; 

////			//added by Mike, 20221213
////			stepCountStatusDiv.style.visibility = "hidden";
////			stepCountStatusShadowDiv.style.visibility = "hidden";
			
			howToPlayGuideImage.style.visibility = "visible"; 
		}
	}
*/


/*
	var iControllerGuideButtonWidth = (controllerGuideButton.clientWidth);
	var iControllerGuideButtonHeight = (controllerGuideButton.clientHeight);		
*/	
	
	//removed by Mike, 20230113
/*
	//var iControllerGuideButtonWidth = 32;
	//var iControllerGuideButtonHeight = 32;

	//added by Mike, 20230113
	var iStepCountGuideButtonWidth = stepCountGuideMiniImage.getBoundingClientRect().width; //32;
//	var iStepGuideGuideButtonHeight= 32;
*/
	//edited by Mike, 20230129
	//TO-DO: -reduce: size IF mobile; example: half of width and height;
	var iStepCountGuideButtonWidth = stepCountGuideMiniImage.clientWidth; 

	//added by Mike, 20221121
	var textStatusDiv = document.getElementById("textStatusDivId");
	var textEnterDiv = document.getElementById("textEnterDivId");



/*	//removed by Mike, 20221120
	//added by Mike, 20221118
	monsterTile.style.visibility="visible";	
*/	

	//added by Mike, 20221104; edited by Mike, 20221118
//	var imgPuzzle;
	if (document.getElementById("puzzleImageId")==null) {
		//alert("dito");
		//reference: https://www.w3schools.com/jsref/met_node_removechild.asp;
		//last accessed: 2022118
		const imgPuzzleChild = document.adoptNode(imgPuzzle);
		document.body.appendChild(imgPuzzleChild);		
	}

	imgPuzzle = document.getElementById("puzzleImageId");

    //edited by Mike, 20221121; 
    //reverify: if solves myCanvasnoticeable DELAY in loading image file			
	//alert(imgPuzzle.src);	
	//edited by Mike, 20221210
//	if (!imgPuzzle.src.toLowerCase().includes("pinatubo")) {
	if (!imgPuzzle.src.toLowerCase().includes("buhangin")) {
		//added by Mike, 2022118
		imgPuzzle.setAttribute("src", getBaseURL()+sImagePuzzleBg);
		imgPuzzle.setAttribute("class", "ImageBackgroundOfPuzzle");	
	}

	//added by Mike, 20221105
	imgPuzzle.style.visibility="visible";	
	
	
	
	imgPuzzle.style.zIndex=0; //added by Mike, 20221118
		
	//added by Mike, 20230207
	//TO-DO: -increase: touchable part (lower zIndex than displayed button) for inputs
		
	//added by Mike, 20220917; edited by Mike, 20220918
	//var linkAsButtonLeftKey = document.getElementById("leftKeyId");
	var buttonLeftKey = document.getElementById("leftKeyId");
	var buttonRightKey = document.getElementById("rightKeyId");
	var buttonUpKey = document.getElementById("upKeyId");
	var buttonDownKey = document.getElementById("downKeyId");

	//added by Mike, 20221019
	var buttonLeverCenterNeutralKey = document.getElementById("leverCenterNeutralKeyId");

	//added by Mike, 20221021
	var buttonLetterJKey = document.getElementById("letterJKeyId");
	var buttonLetterLKey = document.getElementById("letterLKeyId");
	var buttonLetterIKey = document.getElementById("letterIKeyId");
	var buttonLetterKKey = document.getElementById("letterKKeyId");

	//added by Mike, 20221019
	var buttonRightLeverCenterNeutralKey = document.getElementById("rightLeverCenterNeutralKeyId");
	
/*
	//added by Mike, 20220912	
	var pauseLink = document.getElementById("pauseLinkId");
	var iPauseLinkHeight = (pauseLink.clientHeight);//+1; + "px";
	var iPauseLinkWidth = (pauseLink.clientWidth);//+1; + "px"
*/

	//		alert("screen.height: "+screen.height); //533



	//reference: https://www.w3schools.com/tags/canvas_fillrect.asp; 
	//last accessed: 2020911
	var myCanvas = document.getElementById("myCanvasId");
	var myCanvasContext = myCanvas.getContext("2d");
	//TO-DO: -add: center align of bigger window 
	//TO-DO: -reverify: this

	//removed by Mike, 20221210
	//myCanvasContext.fillRect(0, 0, iStageMaxWidth, iStageMaxHeight);	

	//added by Mike, 20241217
	//bIsUsingAppleMac=true;

/*
	//added by Mike, 20230106
	if ((!bIsMobile) || (bIsUsingAppleMac)) {
//	if (!bIsMobile) {
	}
	else {
		if (!bHasSetMaxWidthHeight) {	
			iStageMaxWidth=iStageMaxWidth/2; 
			iStageMaxHeight=iStageMaxHeight/2;	
			
			iTitleImageWidth = iTitleImageWidth/2;
			iTitleImageHeight = iTitleImageHeight/2;				

	//	alert(myCanvas.style.width);
			myCanvas.style.width = iDefaultCanvasWidth/2 +"px"; //"300px"; 
			myCanvas.style.height = iDefaultCanvasHeight/2 +"px";
			
			imgPuzzle.style.width = iDefaultCanvasWidth/2 +"px"; 
			imgPuzzle.style.height = iDefaultCanvasHeight/2 +"px"; 
			
			controllerGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
			controllerGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 

			//added by Mike, 20230115
			stepCountGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
			stepCountGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 


			howToPlayGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
			howToPlayGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 
			
			titleImage.style.width=iStageMaxWidth;
			titleImage.style.height=iStageMaxHeight;
			
			bHasSetMaxWidthHeight=true;
		}		
	}
*/

	if (!bHasSetMaxWidthHeight) {	
/*	
		iDefaultCanvasWidth=iDefaultCanvasWidth*2;
		iDefaultCanvasHeight=iDefaultCanvasHeight*2;
		
		iStageMaxWidth=iStageMaxWidth*2; 
		iStageMaxHeight=iStageMaxHeight*2;	
*/

		iStageMaxWidth=iStageMaxWidth/2; 
		iStageMaxHeight=iStageMaxHeight/2;	
		
		iTitleImageWidth = iTitleImageWidth/2;
		iTitleImageHeight = iTitleImageHeight/2;			

//	alert(myCanvas.style.width);
		myCanvas.style.width = iDefaultCanvasWidth/2 +"px"; //"300px"; 
		myCanvas.style.height = iDefaultCanvasHeight/2 +"px";
		
		imgPuzzle.style.width = iDefaultCanvasWidth/2 +"px"; 
		imgPuzzle.style.height = iDefaultCanvasHeight/2 +"px"; 
		
		controllerGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
		controllerGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 

		//added by Mike, 20230115
		stepCountGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
		stepCountGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 

		howToPlayGuideImage.style.width = iDefaultCanvasWidth/2 +"px"; 
		howToPlayGuideImage.style.height = iDefaultCanvasHeight/2 +"px"; 
		
		titleImage.style.width=iStageMaxWidth;
		titleImage.style.height=iStageMaxHeight;
		
		bHasSetMaxWidthHeight=true;
	}
	
	var iControllerGuideImageWidth = (controllerGuideImage.clientWidth);
	var iControllerGuideImageHeight = (controllerGuideImage.clientHeight);	

	//added by Mike, 20230115
	var iStepCountGuideImageWidth = (stepCountGuideImage.clientWidth);
	var iStepCountGuideImageHeight = (stepCountGuideImage.clientHeight);	



//alert (iHorizontalOffset);

//added by Mike, 20221002; edited by Mike, 20221005
//myCanvas.style.top = (0)+"px"; //iVerticalOffset+
myCanvas.style.top = (iVerticalOffsetInnerScreen+0)+"px"; //iVerticalOffset+

	//added by Mike, 20221012
	iHorizontalOffset=myCanvas.getBoundingClientRect().x;

	//added by Mike, 20221118
	imgPuzzle.style.top = (iVerticalOffsetInnerScreen+0)+"px";
	imgPuzzle.style.left = (iHorizontalOffset+0)+"px";

	//added by Mike, 20221130
/*	//removed by Mike, 20221130
	var titleImage = document.getElementById("titleImageId");	
	titleImage.style.visibility="visible";
*/

	titleImage.style.top = (iVerticalOffsetInnerScreen+0+iStageMaxHeight/3 -iTitleImageHeight/2)+"px";
	titleImage.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iTitleImageWidth/2 +"px";
	

	//added by Mike, 20221122
	controllerGuideImage.style.top = (iVerticalOffsetInnerScreen+0+iStageMaxHeight/2 -iControllerGuideImageHeight/2)+"px";
	controllerGuideImage.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iControllerGuideImageWidth/2 +"px";
	
	//added by Mike, 20230115
	stepCountGuideImage.style.top = (iVerticalOffsetInnerScreen+0+iStageMaxHeight/2 -iStepCountGuideImageHeight/2)+"px";
	stepCountGuideImage.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iStepCountGuideImageWidth/2 +"px";
	
	//added by Mike, 20221129	
	howToPlayGuideImage.style.top = (iVerticalOffsetInnerScreen+0+iStageMaxHeight/2 -iHowToPlayGuideImageHeight/2)+"px";
	howToPlayGuideImage.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iHowToPlayGuideImageWidth/2 +"px";


	//@TOP-LEFT
	controllerGuideButton.style.left = iHorizontalOffset+"px";
	controllerGuideButton.style.top= (0)+"px";
	
	//added by Mike, 20221122
	controllerGuideMiniImage.style.left = iHorizontalOffset+"px";
	controllerGuideMiniImage.style.top= (0)+"px";
	
	//added by Mike, 20230113
	//@TOP-RIGHT

	stepCountGuideButton.style.left = iHorizontalOffset+iStageMaxWidth-iStepCountGuideButtonWidth+"px";
	stepCountGuideButton.style.top= (0)+"px";
	
	stepCountGuideMiniImage.style.left = iHorizontalOffset+iStageMaxWidth-iStepCountGuideButtonWidth+"px";
	stepCountGuideMiniImage.style.top= (0)+"px";
	
/*	
	stepCountGuideButton.style.right = iHorizontalOffset+iStageMaxWidth+"px";
	stepCountGuideButton.style.top= (0)+"px";
	
	stepCountGuideMiniImage.style.right = iHorizontalOffset+iStageMaxWidth+"px";
	stepCountGuideMiniImage.style.top= (0)+"px";
*/		
	
	//added by Mike, 20221213
	stepCountStatusDiv.style.left = iHorizontalOffset+iStageMaxWidth-iStepCountStatusDivWidth+"px";
	stepCountStatusDiv.style.top= (0)+"px";
	
	var iStepCountStatusShadowOffset=1; //2;
	stepCountStatusShadowDiv.style.left = iHorizontalOffset+iStageMaxWidth-iStepCountStatusShadowDivWidth+iStepCountStatusShadowOffset+"px";
	stepCountStatusShadowDiv.style.top= (0)+"px";	

/*
	//edited by Mike, 20221012
	pauseLink.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iPauseLinkWidth/2 +"px";
	pauseLink.style.top = 0+iStageMaxHeight +"px"; 
	pauseLink.style.visibility="visible";	  
*/

	//edited by Mike, 20221129; from 20221121
//	if (!bHasPressedStart) {
	if ((!bHasPressedStart)||(!bHasViewedHowToPlayGuide)) {
		var iTextEnterDivWidth = (textEnterDiv.clientWidth);
		var iTextEnterDivHeight = (textEnterDiv.clientHeight);
	
		textEnterDiv.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iTextEnterDivWidth/2 +"px";
		textEnterDiv.style.top = 0+iStageMaxHeight-iTextEnterDivHeight+"px"; 
			
		//reference: https://github.com/masarapmabuhay/tugon/blob/main/mainLinux.cpp; last accessed: 20221121
		//keyphrase: GAMEOFF 2021, TUGON
		if (iDelayAnimationCountEnter<iDelayAnimationCountEnterMax) {
			textEnterDiv.style.visibility="visible";
		}
		else {
			if (iDelayAnimationCountEnter>20) {
				iDelayAnimationCountEnter=0;
			}
			textEnterDiv.style.visibility="hidden";
		}			
	
		iDelayAnimationCountEnter++;
	}
	else {
		textEnterDiv.style.visibility="hidden";
	}
		
	//added by Mike, 20221121	
	var sText = "AUTO-GENERATING...";

//alert(sText.length);
	var iTextStatusDivWidth = (textStatusDiv.clientWidth);
	var iTextStatusDivHeight = (textStatusDiv.clientHeight);

	textStatusDiv.innerHTML = sText;

	textStatusDiv.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iTextStatusDivWidth/2 +"px";
	textStatusDiv.style.top = 0+iStageMaxHeight-iTextStatusDivHeight*1.5+"px"; 
				
	if (bHasPressedStart) {	
		//added by Mike, 20221129
		if (bHasViewedHowToPlayGuide) {	
			//edited by Mike, 20221124
			if (bIsInitAutoGeneratePuzzleFromEnd) {	
			//if ((bIsInitAutoGeneratePuzzleFromEnd) && (!bHasDefeatedMonster)) {	
			
				textStatusDiv.style.visibility="visible";
			}
			else {
				textStatusDiv.style.visibility="hidden";
			}
		}
	}
	else {
		textStatusDiv.style.visibility="hidden";
	}

	
	//identify offset due to smaller window centered @horizontal
/*	
	alert(screen.width);
	alert(screen.height);
*/



	//added by Mike, 20221030
	//TO-DO: -reverify: adding this in touchmove
	if (iTouchStartCount<iTouchEndCountMax) {
		
		//alert("iTouchStartCount: "+iTouchStartCount);
		
		if (iTouchStartCount>=iTouchEndCountMax) {
			iTouchEndX=iTouchStartX;
			iTouchEndY=iTouchStartY;
			handleGesture();
		}

		iTouchStartCount++;
	}

	


	//reference: https://stackoverflow.com/questions/7545641/how-to-create-multidimensional-array;
	//last accessed: 20221105
	//answer by: Dan, 20150107T2231 
	//edited by: Nadav, 20131113T1000
	//removed by Mike, 20221105
	//var arrayPuzzleTilePos = [ [],[],[],[] ]; 

	let iTileBgCount=0;

/* //edited by Mike, 20230111	
	let iPuzzleTileWidth=32;
	let iPuzzleTileHeight=32;
*/
/*	//removed by Mike, 20230123
	let iPuzzleTileWidth=64;
	let iPuzzleTileHeight=64;
*/

/*	//removed by Mike, 20230123	
	const iPuzzleTileTotalWidthMax=iPuzzleTileWidth*iColumnCountMax;
	const iPuzzleTileTotalHeightMax=iPuzzleTileHeight*iRowCountMax;
	
//	alert(iPuzzleTileWidth);
//	alert (iPuzzleTileTotalMaxWidth);
	
*/
	//edited by Mike, 20230123
	iBorderOffset=0; //2;
	iOffsetWidth=iStageMaxWidth/2-iPuzzleTileTotalWidthMax/2;
	iOffsetHeight=iStageMaxHeight/2-iPuzzleTileTotalHeightMax/2;
	
	//removed by Mike, 20221106
	//16=4*4
	//const iTileBgCountMax=iRowCountMax*iColumnCountMax;	
	
	//added by Mike, 20221113
	var bHasExecutedTileExchange=false;

	//added by Mike, 20221119
	var puzzleTileImageTargetBorder = document.getElementById("divPuzzleTileImageTargetBorderId");
	
	//added by Mike, 20221121
	var puzzleTileImageSpaceBorder = document.getElementById("divPuzzleTileImageSpaceBorderId");

/* //removed by Mike, 20230129
	//added by Mike, 202221121
	var miniPuzzleTileImage = document.getElementById("miniPuzzleTileImageId");	

	//added by Mike, 20221121
	//add mini puzzle tile image after auto-generating
	if (!bIsInitAutoGeneratePuzzleFromEnd) {
		miniPuzzleTileImage.style.visibility = "visible";
	}
		
	miniPuzzleTileImage.style.left = iHorizontalOffset+"px";
	miniPuzzleTileImage.style.top= (iStageMaxHeight-iMiniPuzzleHeight)+"px";
*/

	//added by Mike, 20221124
	var myAudio = document.getElementById("myAudioId");
	
	//edited by Mike, 20221127
	//iCurrentPuzzleStage=1;
	
//iCurrentPuzzleStage=1;
	//miniPuzzleTileImage
	
/* //removed by Mike, 20230710
	switch (iCurrentPuzzleStage) {
		case 0: //starting level			
			if (myAudio.src!=getBaseURL()+sAudioPuzzleStage0) {
				if (myAudio.volume>0) {
					//edited by Mike, 20221125; from 20221124
					fMyAudioVolume-=0.2;
					if (fMyAudioVolume<0) {
						fMyAudioVolume=0;
					}
					
					myAudio.volume=fMyAudioVolume; 
				}
				else {				
					//alert("dito");
					myAudio.pause();
					myAudio.setAttribute("src", getBaseURL()+sAudioPuzzleStage0);

					//edited by Mike, 20221125
					//myAudio.volume=1.0;					
					fMyAudioVolume=1.0;
					//myAudio.volume=1.0;
					myAudio.volume=fMyAudioVolume;

					//added by Mike, 20221129
					if (textEnterDiv.style.visibility=="hidden") {
						myAudio.play();	
					}
				}
			}	
			//added by Mike, 20221130
			else {
				fMyAudioVolume=1.0;
				myAudio.volume=fMyAudioVolume;
			}
			break;
		
			
		default: //END
			break;
	}	
*/	
	
	//added by Mike, 20221124; removed by Mike, 20221124
	//iTileBgCount=0;
	
//	for (let iTileBgCount=0; iTileBgCount<16; iTileBgCount++) {		
	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {		
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
		
		//edited by Mike, 20221118
		//arrayPuzzleTileCountId[iTileBgCount] = document.getElementById("puzzleTileImageIdBg"+iTileBgCount);
	
		arrayPuzzleTileCountId[iTileBgCount] = document.getElementById("puzzleTileImageIdBg"+iTileBgCount);
	
		//added by Mike, 20221118
		//reference: https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_img_create;
		//last accessed: 20221118	
		//edited by Mike, 20221121
//		arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+"assets/images/count1024x1024.png");

	
		//edited by Mike, 20221122; from 20221121		
		//iCurrentPuzzleStage=1;		
		switch (iCurrentPuzzleStage) {
			case 0: //starting level; numbers sequence
				//alert("dito");

				//edited by Mike, 20221124
			//arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+"assets/images/count1024x1024.png");
				
				if (arrayPuzzleTileCountId[iTileBgCount].src!=getBaseURL()+sImagePuzzleStage0) {
					
				    //edited by Mike, 20221127	//arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+"assets/images/count1024x1024.png");
					arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+sImagePuzzleStage0);
				}
				break;
			case 1: //next level; cambodia
				arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+sImagePuzzleStage1);
				break;		
			case 2: //next level; duck army
				arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+sImagePuzzleStage2);			
				break;					
			default:		
				iCurrentPuzzleStage=0;			

				//repeat from starting level	
				//edited by Mike, 20221124
			//arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+"assets/images/count1024x1024.png");	
				if (arrayPuzzleTileCountId[iTileBgCount].src!=getBaseURL()+sImagePuzzleStage0) {
					//edited by Mike, 20221127
				//arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+"assets/images/count1024x1024.png");
arrayPuzzleTileCountId[iTileBgCount].setAttribute("src", getBaseURL()+sImagePuzzleStage0);				
				
				}
				break;
		}

		//alert(iTileBgCount);
		
		arrayPuzzleTileCountId[iTileBgCount].style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCount+iBorderOffset*iColumnCount+"px";
		
//		arrayPuzzleTileCountId[iTileBgCount].style.top = iVerticalOffset+iPuzzleTileHeight*iColumnCount+"px";
		arrayPuzzleTileCountId[iTileBgCount].style.top = 0+iOffsetHeight+iPuzzleTileHeight*iRowCount+iBorderOffset*iRowCount+"px";

//		alert (iPuzzleTileWidth*iRowCount);


		//edited by Mike, 20221127	//arrayPuzzleTileCountId[iTileBgCount].style.visibility="visible";	
		if (bHasPressedStart) {
			//edited by Mike, 20250704; from 20221121
			if (!bIsPuzzleDone) {
				arrayPuzzleTileCountId[iTileBgCount].style.visibility="visible";
			}
			else {
				for (iCount=0; iCount<iTotalKeyCount; iCount++) {
					//set to FALSE all pressed keys
					arrayKeyPressed[iCount]=false;
				}
			}
		}
		
	
		if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
			//reminder: @last tile #16, space
			//pressed up, tile above the space
			if (arrayKeyPressed[iKEY_W]) {
			//alert(iRowCount);
				if ((iRowCount-1)>=0) {
					iTargetTileBgCount=arrayPuzzleTilePos[iRowCount-1][iColumnCount];
					
					arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileTarget";
					

					//added by Mike, 20221119
					puzzleTileImageTargetBorder.style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCount+"px";
					
					puzzleTileImageTargetBorder.style.top = 0+iOffsetHeight+iPuzzleTileHeight*(iRowCount-1)+"px";
					
					puzzleTileImageTargetBorder.style.visibility = "visible";

					iHorizontalOffsetOfTargetBorder	= iHorizontalOffset;
				//arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
					
					bIsTargetAtSpace=false;
				}	
			}
			else if (arrayKeyPressed[iKEY_S]) {
				//edited by Mike, 20221106
//				if ((iRowCount+1)<=iRowCountMax-1) {
				if ((iRowCount+1)<iRowCountMax) {
					iTargetTileBgCount=arrayPuzzleTilePos[iRowCount+1][iColumnCount];
					
					//alert(iTargetTileBgCount);

					arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileTarget";
				
				//arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
				
				
					//added by Mike, 20221119
					puzzleTileImageTargetBorder.style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCount+"px";
					//puzzleTileImageTargetBorder.style.left = iOffsetWidth+iPuzzleTileWidth*iColumnCount+"px";
					
					puzzleTileImageTargetBorder.style.top = 0+iOffsetHeight+iPuzzleTileHeight*(iRowCount+1)+"px";
					
					puzzleTileImageTargetBorder.style.visibility = "visible";
				
					iHorizontalOffsetOfTargetBorder	= iHorizontalOffset;
				
					bIsTargetAtSpace=false;
				}	
			}
			else if (arrayKeyPressed[iKEY_A]) {						
				if ((iColumnCount-1)>=0) {
					iTargetTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount-1];

					arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileTarget";
				
				//arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
				
					//added by Mike, 20221119
					puzzleTileImageTargetBorder.style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*(iColumnCount-1)+"px";

					//puzzleTileImageTargetBorder.style.left = iOffsetWidth+iPuzzleTileWidth*(iColumnCount-1)+"px";
					
					puzzleTileImageTargetBorder.style.top = 0+iOffsetHeight+iPuzzleTileHeight*(iRowCount)+"px";
					
					puzzleTileImageTargetBorder.style.visibility = "visible";

					iHorizontalOffsetOfTargetBorder	= iHorizontalOffset;
								
					bIsTargetAtSpace=false;
				}	
			}			
			else if (arrayKeyPressed[iKEY_D]) {
				//edited by Mike, 20221106				
//				if ((iColumnCount+1)<=iColumnCountMax-1) {
				if ((iColumnCount+1)<iColumnCountMax) {
					iTargetTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount+1];

					arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileTarget";
				
				//arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
								
					//added by Mike, 20221119
					puzzleTileImageTargetBorder.style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*(iColumnCount+1)+"px";
					
					puzzleTileImageTargetBorder.style.top = 0+iOffsetHeight+iPuzzleTileHeight*(iRowCount)+"px";
					
					puzzleTileImageTargetBorder.style.visibility = "visible";
								
					iHorizontalOffsetOfTargetBorder	= iHorizontalOffset;
								
					bIsTargetAtSpace=false;
				}	
			}			
			else {	
				//arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpaceTarget";		
				bIsTargetAtSpace=true;				
			}
	
	
			//added by Mike, 20221119			
			if (iHorizontalOffsetOfTargetBorder	!= iHorizontalOffset) {
			
				puzzleTileImageTargetBorder.style.left = (puzzleTileImageTargetBorder.style.left.replace("px","")-iHorizontalOffsetOfTargetBorder+iHorizontalOffset)+"px";			
				
				iHorizontalOffsetOfTargetBorder=iHorizontalOffset;
			}

			
			//edited by Mike, 20221127
			//if (bIsTargetAtSpace) {	
			if ((bIsTargetAtSpace) && (bHasPressedStart)) {

				//added by Mike, 20221113; removed by Mike, 20221113
				//if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
					
				//edited by Mike, 20221121
				//STAGE 1: NUMBERS SEQUENCE
				if (iCurrentPuzzleStage==0) { 					
					if (iTargetAtSpaceBlinkAnimationCount==iTargetAtSpaceBlinkAnimationCountMax) {
						if (arrayPuzzleTileCountId[iTileBgCount].className=='Image32x32TileSpace') {
						arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpaceTarget";
						}
						else {
						arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
						}
						iTargetAtSpaceBlinkAnimationCount=0;
					}
					else {
						iTargetAtSpaceBlinkAnimationCount++;
					}				
	//alert(iTargetAtSpaceBlinkAnimationCount);	
				}
				else {
				
		if (iTargetAtSpaceBlinkAnimationCount==iTargetAtSpaceBlinkAnimationCountMax) {
															
					
							if (puzzleTileImageSpaceBorder.style.visibility==   "hidden") {

arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";
					
					puzzleTileImageSpaceBorder.style.left = arrayPuzzleTileCountId[iTileBgCount].style.left;
					
					puzzleTileImageSpaceBorder.style.top = arrayPuzzleTileCountId[iTileBgCount].style.top;
					
					puzzleTileImageSpaceBorder.style.visibility =   "visible";				

					}
						
						iTargetAtSpaceBlinkAnimationCount=0;
					}
					else {
									
					puzzleTileImageSpaceBorder.style.visibility =   "hidden";
			
						iTargetAtSpaceBlinkAnimationCount++;
					}						
						
					
				}
			}				
			else {				
				//edited by Mike, 20221113
				for (iCount=0; iCount<iTotalKeyCount; iCount++) {
//				for (iCount=0; iCount<iDirectionTotalKeyCount; iCount++) {
					
					//if a key has been pressed
					if (arrayKeyPressed[iCount]==true) {
												//alert("dito");
						//set adjacent tiles to be not the TARGET as default 
						if (!arrayKeyPressed[iKEY_W]) {						
							if ((iRowCount-1)>=0) {
								arrayPuzzleTileCountId[arrayPuzzleTilePos[iRowCount-1][iColumnCount]].className="Image32x32Tile";
								
							}	
						}

						if (!arrayKeyPressed[iKEY_S]) {
							
							//edited by Mike, 20221106
	//						if ((iRowCount+1)<iRowCountMax-1) {
							if ((iRowCount+1)<iRowCountMax) {
			arrayPuzzleTileCountId[arrayPuzzleTilePos[iRowCount+1][iColumnCount]].className="Image32x32Tile";
							}
						}
						
						if (!arrayKeyPressed[iKEY_A]) {
							if ((iColumnCount-1)>=0) {
								arrayPuzzleTileCountId[arrayPuzzleTilePos[iRowCount][iColumnCount-1]].className="Image32x32Tile";
							}		
						}						
						
						if (!arrayKeyPressed[iKEY_D]) {						
							//edited by Mike, 20221106
							//if ((iColumnCount+1)<iColumnCountMax-1) {
							if ((iColumnCount+1)<iColumnCountMax) {
								arrayPuzzleTileCountId[arrayPuzzleTilePos[iRowCount][iColumnCount+1]].className="Image32x32Tile";					
							}	
						}
						
						break;						
					}
				}
			}
			

			//added by Mike, 20221106;
			//edited by Mike, 20221106
//			if (arrayKeyPressed[iKEY_J]) {
			if ((arrayKeyPressed[iKEY_J]) ||
				(arrayKeyPressed[iKEY_L]) ||
				(arrayKeyPressed[iKEY_I]) ||
				(arrayKeyPressed[iKEY_K])) {
				//reminder: iTileBgCount = iTileBgCountMax-1
			
			
			//added by Mike, 20221108
	
			if (iTargetTileBgCount==-1) {
				break;
			}
			
				arrayPuzzleTileCountId[iTileBgCount].className="Image32x32Tile";
				
				arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileSpace";

				arrayPuzzleTileCountId[iTileBgCount].alt=arrayPuzzleTileCountId[iTargetTileBgCount].alt;


				arrayPuzzleTileCountId[iTargetTileBgCount].alt="";


				bIsTargetAtSpace=true;
				
				//edited by Mike, 20221213; from 20221113
				//bHasExecutedTileExchange=true;
				
/*	//removed by Mike, 20221213				
				//added by Mike, 20221113				
				iStepCountStatus--;
*/				
				if (!bIsInitAutoGeneratePuzzleFromEnd) {
					//note: iCountMovementStep
					//iStepCountStatus++;
					
					if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
						bHasExecutedTileExchange=false;
					}
					else {
						bHasExecutedTileExchange=true;
						iStepCountStatus++;
					}
				}	
			}
			
			//added by Mike, 20221106
			//iDirectionTotalKeyCount
			for (iCount=0; iCount<iTotalKeyCount; iCount++) {
				arrayKeyPressed[iCount]=false;	
			}
		}				
		
		iTileBgCount++;
		//alert("iTileBgCount: "+iTileBgCount);		
		}
	}


	//added by Mike, 20221108; edited by Mike, 20221114
	if (bHasPressedStart) {
		//added by Mike, 20221129
		if (bHasViewedHowToPlayGuide) {	
			if (bIsInitAutoGeneratePuzzleFromEnd) {
/*
				iDelayAnimationCountMovementStep=0;
				iDelayAnimationCountMovementStepMax=0;
*/
				//if (iDelayAnimationCountMovementStep==iDelayAnimationCountMovementStepMax) 	
				if (iDelayAnimationCountMovementStep>=iDelayAnimationCountMovementStepMax) 	
				{
					autoGeneratePuzzleFromEnd();
					iDelayAnimationCountMovementStep=0;
				}
				else {
					iDelayAnimationCountMovementStep++;
				}

				//autoGeneratePuzzleFromEnd();
			}
			
		
			//added by Mike, 20230128; from 20230121
			var iTopRightPuzzleTilePosX=iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCountMax+iBorderOffset*iColumnCountMax;
				
		//	alert(iTopRightPuzzleTilePosX);
		//	alert(iPuzzleTileWidth);
		
		/*  //removed by Mike, 20230121
			//stepCountStatusDiv
			stepCountGuideMiniImage.style.visibility="hidden";
			stepCountGuideButton.style.visibility="hidden";
		*/
		
		//	alert(stepCountStatusDiv.getBoundingClientRect().x);
			//is stepCount intersecting with top-right puzzle tile
			//via mobile? if so, set to hidden displayed step count status
			//note: did not anymore add the y-axis 
			if (stepCountStatusDiv.getBoundingClientRect().x<=iTopRightPuzzleTilePosX+iPuzzleTileWidth) {
			
				//removed by Mike, 20241217
				//stepCountGuideMiniImage.style.visibility="visible";
				
				stepCountGuideButton.style.visibility="visible";
				
				//stepCountStatusDiv.style.visibility="hidden";
				
				//alert("dito");
				//TO-DO: -reduce: size for mobile; width and height, half?
/* //edited by Mike, 20230129				
				stepCountStatusDiv.style.visibility = "hidden";
				stepCountStatusShadowDiv.style.visibility = "hidden";		
*/
				stepCountStatusDiv.style.visibility = "visible";
				stepCountStatusShadowDiv.style.visibility = "visible";		

			}
		}
	}

		
	//added by Mike, 20220917	
	//alert (buttonLeftKey.getBoundingClientRect().width);	//Example Output: 47.28334045410156
	//var iButtonWidth = buttonUpKey.getBoundingClientRect().width;
	//edited by Mike, 20230209
	var iButtonWidth = buttonRightKey.getBoundingClientRect().width;
	//notes: iButtonCenterNeutralKeyWidth longer than iButtonWidth
	//var iButtonCenterNeutralKeyWidth = buttonLeverCenterNeutralKey.getBoundingClientRect().width;	
	var iButtonHeight = buttonUpKey.getBoundingClientRect().height;

/*
	//if (!document.fullscreenElement) {	
	if ((!bIsMobile) || (bIsUsingAppleMac)) {
*/		
		buttonUpKey.style.visibility = "hidden";		
		buttonLeftKey.style.visibility = "hidden";
		buttonRightKey.style.visibility = "hidden";
		buttonDownKey.style.visibility = "hidden";
		
		//added by Mike, 20221019
		buttonLeverCenterNeutralKey.style.visibility = "hidden";
		
		//added by Mike, 20221021
		buttonLetterIKey.style.visibility = "hidden";		
		buttonLetterJKey.style.visibility = "hidden";
		buttonLetterLKey.style.visibility = "hidden";
		buttonLetterKKey.style.visibility = "hidden";
		
		buttonRightLeverCenterNeutralKey.style.visibility = "hidden";
/*		
	}
	else {
*/		
/*
		//edited by Mike, 20221108; edited by Mike, 20230111;
		//TO-DO: -reverify: when iPAD starts @PORTRAIT;
		//--> size not smaller for portrait; button positions incorrect;
		//TO-DO: -reverify: when iPAD starts @LANDSCAPE,
		//--> has: excess offset at top
		if (bIsUsingAppleWebKit) {		
			//edited by Mike, 20230111	//iVerticalOffset=(iStageMaxHeight+buttonUpKey.clientHeight*3);			
			//iVerticalOffset=window.innerWidth/2;
			iVerticalOffset=iStageMaxHeight/2;
			//iVerticalOffset=iCurrentAppleWebKitInnerWidth/2;

			//alert(screen.orientation); //OUTPUT: [object ScreenOrientation]

	
			//alert(window.innerWidth);
			
			//note: CHANGE in orientation
			if (iCurrentAppleWebKitInnerWidth!=window.innerWidth) {
				iCurrentAppleWebKitInnerWidth=window.innerWidth;
				
////				screen.width=iCurrentAppleWebKitInnerWidth;
////				alert(screen.width);
				
				iAppleWebKitInnerWidthOffset=iCurrentAppleWebKitInnerWidth-screen.width;
				
				if (iAppleWebKitInnerWidthOffset<0) {
					iAppleWebKitInnerWidthOffset*=(-1);
					
					//added by Mike, 20230111
					iVerticalOffset=iCurrentAppleWebKitInnerWidth/2;
				}
			}
		}
		else {			
			//added by Mike, 20230207
			//TO-DO: -verify: with iPAD;
		
			//added by Mike, 20221002
			iVerticalOffset=(iStageMaxHeight+(screen.height/1.5-iStageMaxHeight));
			
			//alert(screen.orientation); //OUTPUT: [object ScreenOrientation]

			if (window.matchMedia("(orientation: landscape)").matches) {
				//note: for CONTROLLER BUTTONS
				//edited by Mike, 20230207
				//iVerticalOffset=(screen.height-buttonUpKey.clientHeight*3); //set to 3 button height from the bottom
				//put @vertical center 
				//iVerticalOffset=(screen.height/2); 
				iVerticalOffset=(screen.height/2-buttonUpKey.clientHeight); 
			}				
		}
*/		
	
/*		
		buttonUpKey.style.left = (0)+iButtonWidth*1+"px";
		buttonUpKey.style.top =  iVerticalOffset+"px"; //iStageMaxHeight+"px";
		buttonUpKey.style.visibility = "visible";
		
		buttonLeftKey.style.left = (0)+"px";
		buttonLeftKey.style.top =  iVerticalOffset+iButtonHeight*1+"px"; //iStageMaxHeight+iButtonHeight*1+"px";
		buttonLeftKey.style.visibility = "visible";

		//edited by Mike, 20230207; from 20221019
		//TO-DO: -fix: excess pixel on right of neutral key
		buttonLeverCenterNeutralKey.style.left = (0)+iButtonWidth*1+"px";
		buttonLeverCenterNeutralKey.style.top =  iVerticalOffset+iButtonHeight*1+"px"; 
		buttonLeverCenterNeutralKey.style.visibility = "visible";
		//buttonLeverCenterNeutralKey.style.visibility = "hidden";

		//edited by Mike, 20230209
		buttonRightKey.style.left = (0)+iButtonWidth*2+"px";
		//buttonRightKey.style.left = (0)+iButtonCenterNeutralKeyWidth*2+"px";
		buttonRightKey.style.top =  iVerticalOffset+iButtonHeight*1+"px";//iStageMaxHeight+iButtonHeight*1+"px";
		buttonRightKey.style.visibility = "visible";
//		buttonRightKey.style.visibility = "hidden";

		buttonDownKey.style.left = (0)+iButtonWidth*1+"px";
		buttonDownKey.style.top =  iVerticalOffset+iButtonHeight*2+"px"; //iStageMaxHeight+iButtonHeight*2+"px";
		buttonDownKey.style.visibility = "visible";

		
		//added by Mike, 20221021
		buttonLetterIKey.style.left = iAppleWebKitInnerWidthOffset+(screen.width)-iButtonWidth*2+"px";
		buttonLetterIKey.style.top =  iVerticalOffset+"px"; //iStageMaxHeight+"px";
		buttonLetterIKey.style.visibility = "visible";
		
		buttonLetterJKey.style.left = iAppleWebKitInnerWidthOffset+(screen.width)-iButtonWidth*3+"px";
		buttonLetterJKey.style.top =  iVerticalOffset+iButtonHeight*1+"px"; //iStageMaxHeight+iButtonHeight*1+"px";
		buttonLetterJKey.style.visibility = "visible";

		//added by Mike, 20221019
		buttonRightLeverCenterNeutralKey.style.left = iAppleWebKitInnerWidthOffset+(screen.width)-iButtonWidth*2+"px";
		buttonRightLeverCenterNeutralKey.style.top =  iVerticalOffset+iButtonHeight*1+"px"; 
		buttonRightLeverCenterNeutralKey.style.visibility = "visible";

		buttonLetterLKey.style.left = iAppleWebKitInnerWidthOffset+(screen.width)-iButtonWidth+"px";
		buttonLetterLKey.style.top =  iVerticalOffset+iButtonHeight*1+"px";//iStageMaxHeight+iButtonHeight*1+"px";
		buttonLetterLKey.style.visibility = "visible";

		buttonLetterKKey.style.left = iAppleWebKitInnerWidthOffset+(screen.width)-iButtonWidth*2+"px";
		buttonLetterKKey.style.top =  iVerticalOffset+iButtonHeight*2+"px"; //iStageMaxHeight+iButtonHeight*2+"px";
		buttonLetterKKey.style.visibility = "visible";		
	}
*/		

						
	//added by Mike, 20221111
	if (!bIsInitAutoGeneratePuzzleFromEnd) {
		//edited by Mike, 20221121	
		//autoVerifyPuzzleIfAtEnd();		
		
		bIsPuzzleDone = isAutoVerifiedPuzzleDone();
				
		//added by Mike, 20250703				
		//bIsPuzzleDone=true;				
				
		if (bIsPuzzleDone) {
			//alert("Done!");
						
			var sText = "CONGRATULATIONS!!"; //edited 20250704

			//alert(sText.length);
			var iTextStatusDivWidth = (textStatusDiv.clientWidth);
			var iTextStatusDivHeight = (textStatusDiv.clientHeight);
		
			textStatusDiv.innerHTML = sText;

			textStatusDiv.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iTextStatusDivWidth/2 +"px";
			//edited by Mike, 20250704
			//textStatusDiv.style.top = 0+iStageMaxHeight-iTextStatusDivHeight*1.5+"px"; 
			textStatusDiv.style.top = 0+iStageMaxHeight/2-iTextStatusDivHeight*2+"px"; 
			
			textStatusDiv.style.visibility="visible";
			
			//added by Mike, 20221125
			if (myAudio.volume>0) {
				fMyAudioVolume-=0.2;

				if (fMyAudioVolume<0) {
					fMyAudioVolume=0;
				}
					
				myAudio.volume=fMyAudioVolume; 
			}
			else {				
				myAudio.pause();
			}
			
			//added by Mike, 20250704			
			executeEndingAnimation()
			
/*
			//added by Mike, 20250703
			if (iCongratsRestartDelayCount<iCongratsRestartDelayCountMax) {
				iCongratsRestartDelayCount++;
			}
			else {
				iCongratsRestartDelayCount=iCongratsRestartDelayCountMax;
			}	
*/

		
/* //removed by Mike, 20221230; TO-DO: -add: LEADERBOARD MINI GAME SCREEN
			if (iDelayCountToNextLevel>=iDelayCountToNextLevelMax) {
				iDelayCountToNextLevel=0;
				
				iCurrentPuzzleStage++;

				//edited by Mike, 20221122
				if (iCurrentPuzzleStage==0) {
				}
				else if (iCurrentPuzzleStage==1) {
					//added by Mike, 20221122
					toggleFullScreen();
					initPuzzleTileTextValueContainer();
				}
				else {
					//THANK YOU FOR PLAYING!
					//added by Mike, 20221122
					toggleFullScreen();
					initPuzzleEnd();
				}				
			}
			iDelayCountToNextLevel++;
*/			
		}	
	}
	//added by Mike, 20221120
	//if (!bIsInitAutoGeneratePuzzleFromEnd) {
	else {			
		buttonLeftKey.style.visibility="hidden";
		buttonRightKey.style.visibility="hidden";
		buttonUpKey.style.visibility="hidden";
		buttonDownKey.style.visibility="hidden";

		buttonLeverCenterNeutralKey.style.visibility="hidden";

		buttonLetterJKey.style.visibility="hidden";
		buttonLetterLKey.style.visibility="hidden";
		buttonLetterIKey.style.visibility="hidden";
		buttonLetterKKey.style.visibility="hidden";

		buttonRightLeverCenterNeutralKey.style.visibility="hidden";
	}
	
	//edited by Mike, 20221113; 20221112
	autoUpdatePuzzleTileImage();
}

//added by Mike, 20220904
//version 2; with offset, et cetera
//@return bool
function isIntersectingRect(mdo1, mdo2) {
	
	//added by Mike, 20221126
	if (bIsMonsterInHitState) {
		return false;
	}
	
	//added by Mike, 20221120 
	//note#1: mdo1=humanTile;
	//note#2: mdo2=monsterTile;
	
	let mdo1XPos = mdo1.getBoundingClientRect().x;
	let mdo1YPos = mdo1.getBoundingClientRect().y;			

/* //edited by Mike, 20221120
	let mdo1Width = 64;
	let mdo1Height = 64; 
*/
	let mdo1Width = 32;
	let mdo1Height = 32; 
	
	let mdo2XPos = mdo2.getBoundingClientRect().x;
	let mdo2YPos = mdo2.getBoundingClientRect().y;			
	let mdo2Width = 64; //mdo2.getBoundingClientRect().width;
	let mdo2Height = 64; //mdo2.getBoundingClientRect().height;		
	
	//edited by Mike, 20221120
	//note: before HUMAN reaches MONSTER
	let iOffsetXPosAsPixel=-20; //0; //10;
	let iOffsetYPosAsPixel=-20; //0; //10;	
	
	//added by Mike, 20221121
	if (bIsMonsterExecutingAttack) {
		iOffsetXPosAsPixel=0; //0; //10;
		iOffsetYPosAsPixel=0; //0; //10;	
	}


/*	//edited by Mike, 20221120
	let iHumanStepX=10;
	let iHumanStepY=10;	
*/
	let iHumanStepX=2;
	let iHumanStepY=2;	


/*	
	alert("mdo1XPos: "+mdo1XPos+"; "+"mdo1Width: "+mdo1Width);	
	alert("mdo2XPos: "+mdo2XPos+"; "+"mdo2Width: "+mdo2Width);
*/
	
	if ((mdo2YPos+mdo2Height < mdo1YPos+iOffsetYPosAsPixel-iHumanStepY) || //is the bottom of mdo2 above the top of mdo1?
		(mdo2YPos > mdo1YPos+mdo1Height-iOffsetYPosAsPixel+iHumanStepY) || //is the top of mdo2 below the bottom of mdo1?
		(mdo2XPos+mdo2Width < mdo1XPos+iOffsetXPosAsPixel-iHumanStepX) || //is the right of mdo2 to the left of mdo1?
		(mdo2XPos > mdo1XPos+mdo1Width-iOffsetXPosAsPixel+iHumanStepX)) //is the left of mdo2 to the right of mdo1?
	{		
		//no collision
		return false;
	}
	
	return true;
}

//added by Mike, 20221126
//version 2; with offset, et cetera
//@return bool
function isIntersectingRectDefault(mdo1, mdo2) {
	
	//added by Mike, 20221120 
	//note#1: mdo1=humanTile;
	//note#2: mdo2=monsterTile;
	
	let mdo1XPos = mdo1.getBoundingClientRect().x;
	let mdo1YPos = mdo1.getBoundingClientRect().y;			

/* //edited by Mike, 20221120
	let mdo1Width = 64;
	let mdo1Height = 64; 
*/
	let mdo1Width = 32;
	let mdo1Height = 32; 
	
	let mdo2XPos = mdo2.getBoundingClientRect().x;
	let mdo2YPos = mdo2.getBoundingClientRect().y;			
	let mdo2Width = 64; //mdo2.getBoundingClientRect().width;
	let mdo2Height = 64; //mdo2.getBoundingClientRect().height;		
	
	//edited by Mike, 20221120
	//note: before HUMAN reaches MONSTER
	let iOffsetXPosAsPixel=0; //-20; //0; //10;
	let iOffsetYPosAsPixel=0; //-20; //0; //10;	

	let iHumanStepX=2;
	let iHumanStepY=2;	


/*	
	alert("mdo1XPos: "+mdo1XPos+"; "+"mdo1Width: "+mdo1Width);	
	alert("mdo2XPos: "+mdo2XPos+"; "+"mdo2Width: "+mdo2Width);
*/
	
	if ((mdo2YPos+mdo2Height < mdo1YPos+iOffsetYPosAsPixel-iHumanStepY) || //is the bottom of mdo2 above the top of mdo1?
		(mdo2YPos > mdo1YPos+mdo1Height-iOffsetYPosAsPixel+iHumanStepY) || //is the top of mdo2 below the bottom of mdo1?
		(mdo2XPos+mdo2Width < mdo1XPos+iOffsetXPosAsPixel-iHumanStepX) || //is the right of mdo2 to the left of mdo1?
		(mdo2XPos > mdo1XPos+mdo1Width-iOffsetXPosAsPixel+iHumanStepX)) //is the left of mdo2 to the right of mdo1?
	{		
		//no collision
		return false;
	}
	
	return true;
}



//added by Mike, 20221120
//@return bool
function isPointIntersectingRect(iXPos, iYPos, mdo2) {
	
	//added by Mike, 20221120 
	//note#1: mdo1=humanTile;
	//note#2: mdo2=monsterTile;
/* //removed by Mike, 20221120	
	let mdo1XPos = mdo1.getBoundingClientRect().x;
	let mdo1YPos = mdo1.getBoundingClientRect().y;			

	let mdo1Width = 32;
	let mdo1Height = 32; 
*/

	let mdo1XPos = iXPos;
	let mdo1YPos = iYPos;				
	
/* //edited by Mike, 20221127	
	let mdo1Width = 32;
	let mdo1Height = 32; 
*/
	let mdo1Width = 0;
	let mdo1Height = 0; 
	
	//alert("mdo1XPos: "+mdo1XPos);

	//edited by Mike, 202221121
	let mdo2XPos = mdo2.getBoundingClientRect().x;
	let mdo2YPos = mdo2.getBoundingClientRect().y;			
	let mdo2Width = 64; //mdo2.getBoundingClientRect().width;
	let mdo2Height = 64; //mdo2.getBoundingClientRect().height;		

//	alert("mdo2XPos: "+mdo2XPos);

	//edited by Mike, 20221120
	//note: before HUMAN reaches MONSTER
	let iOffsetXPosAsPixel=0; //-20; //0; //10;
	let iOffsetYPosAsPixel=0; //-20; //0; //10;	

/*	//edited by Mike, 20221120
	let iHumanStepX=10;
	let iHumanStepY=10;	
*/
	let iHumanStepX=2;
	let iHumanStepY=2;	

/*	
	alert("mdo1XPos: "+mdo1XPos+"; "+"mdo1Width: "+mdo1Width);	
	alert("mdo2XPos: "+mdo2XPos+"; "+"mdo2Width: "+mdo2Width);
*/

/*	
	alert("mdo1YPos: "+mdo1YPos+"; "+"mdo1Height: "+mdo1Height);	
	alert("mdo2YPos: "+mdo2YPos+"; "+"mdo2Height: "+mdo2Height);
*/
/*
	alert("mdo1XPos: "+mdo1XPos+"; "+"mdo1Width: "+mdo1Width);	
	alert("mdo2XPos: "+mdo2XPos+"; "+"mdo2Width: "+mdo2Width);
*/	
	if ((mdo2YPos+mdo2Height < mdo1YPos+iOffsetYPosAsPixel-iHumanStepY) || //is the bottom of mdo2 above the top of mdo1?
		(mdo2YPos > mdo1YPos+mdo1Height-iOffsetYPosAsPixel+iHumanStepY) || //is the top of mdo2 below the bottom of mdo1?
		(mdo2XPos+mdo2Width < mdo1XPos+iOffsetXPosAsPixel-iHumanStepX) || //is the right of mdo2 to the left of mdo1?
		(mdo2XPos > mdo1XPos+mdo1Width-iOffsetXPosAsPixel+iHumanStepX)) //is the left of mdo2 to the right of mdo1?
	{		
		//no collision
		return false;
	}
	
	return true;
}


//added by Mike, 20221123
//@return bool
function isPointsOfRectIntersectingPointsOfRect(iXPos1, iYPos1, iXPos2, iYPos2) {
		//alert("iPuzzleTileWidth: "+iPuzzleTileWidth);

	let mdo1XPos = iXPos1;
	let mdo1YPos = iYPos1;				
	
	//edited by Mike, 20230524
	//set as a point; not a tile
	let mdo1Width = 1;//iPuzzleTileWidth;
	let mdo1Height = 1;//iPuzzleTileHeight; 

	let mdo2XPos = iXPos2;
	let mdo2YPos = iYPos2;				
	
	let mdo2Width = iPuzzleTileWidth;
	let mdo2Height = iPuzzleTileHeight; 

	let iOffsetXPosAsPixel = 0;
	let iOffsetYPosAsPixel = 0;
	
	//alert("mdo1XPos: "+mdo1XPos);

/*	
	alert("mdo1XPos: "+mdo1XPos+"; "+"mdo1Width: "+mdo1Width);	
	alert("mdo2XPos: "+mdo2XPos+"; "+"mdo2Width: "+mdo2Width);
*/

	if ((mdo2YPos+mdo2Height < mdo1YPos+iOffsetYPosAsPixel) || //is the bottom of mdo2 above the top of mdo1?
		(mdo2YPos > mdo1YPos+mdo1Height-iOffsetYPosAsPixel) || //is the top of mdo2 below the bottom of mdo1?
		(mdo2XPos+mdo2Width < mdo1XPos+iOffsetXPosAsPixel) || //is the right of mdo2 to the left of mdo1?
		(mdo2XPos > mdo1XPos+mdo1Width-iOffsetXPosAsPixel)) //is the left of mdo2 to the right of mdo1?
	{		
		//no collision
		return false;
	}
	
		
	return true;
}



//reference: https://stackoverflow.com/questions/15466802/how-can-i-auto-hide-alert-box-after-it-showing-it; last accessed: 20220911
//answer by: Travis J, 20130317T2213
function tempAlert(msg,duration)
{
 var el = document.createElement("div");
  
  //edited by Mike, 20220911 //el.setAttribute("style","position:absolute;top:40%;left:20%;background-color:white;");

  el.setAttribute("style","position:absolute;top:0%;left:0%;background-color:white;");
  el.innerHTML = msg;
   
  setTimeout(function(){
    el.parentNode.removeChild(el);
 	  
	//added by Mike, 20220914; edited by Mike, 20220925
	//--------------------------------------------

	//added by Mike, 20220926
	//TO-DO: -update: to identify offset container for INNER SCREEN, CONTROLLER
	var iHorizontalOffsetPrev = iHorizontalOffset;
	
	//TO-DO: -reverify: this; added by Mike, 20221119
	iHorizontalOffset=(screen.width)/2-iStageMaxWidth/2;

	//added by Mike, 20221119
	//error caused by pinch zoom via SAFARI on iPAD
	//added: in CSS's html and body, touch-action: none;
	if (bIsUsingAppleWebKit) {
		if (screen.width!=screen.innerWidth) {
			iHorizontalOffset=(screen.innerWidth)/2-iStageMaxWidth/2;
		}		
	}

	//added by Mike, 20220925	
	//iVerticalOffset=iStageMaxHeight+((screen.height-iStageMaxHeight)/2);
	iVerticalOffset=(iStageMaxHeight+(screen.height/1.5-iStageMaxHeight));	
	
	//alert("screen.width: "+screen.width); //landscape:533; potrait: 320
	//alert("iStageMaxWidth: "+iStageMaxWidth); //landscape:320; potrait: 320

	//alert("screen.height: "+screen.height); //landscape:533; potrait: 320

/* //removed by Mike, 20230115
	//added by Mike, 20220926
	//TO-DO: -add: auto-update for all moving objects, et cetera	
	var humanTile = document.getElementById("humanTileImageId");

	let iHumanTileX = humanTile.getBoundingClientRect().x;
	
	humanTile.style.left =  iHorizontalOffset + (iHumanTileX-iHorizontalOffsetPrev)+"px";
	//humanTile.style.left =  iHorizontalOffset + iHumanTileX+"px";

	//alert(humanTile.style.left);
*/

/*	
	//added by Mike, 20221006
	var pauseLink = document.getElementById("pauseLinkId");
	var iPauseLinkHeight = (pauseLink.clientHeight);//+1; + "px";
	var iPauseLinkWidth = (pauseLink.clientWidth);//+1; + "px"

	//edited by Mike, 20221012
	//note: screen set to custom-ZOOM causes INCORRECT POSITION OUTPUT
	//TO-DO: -verify: auto-set ZOOM to be 100%
	pauseLink.style.left = 0+iHorizontalOffset+iStageMaxWidth/2 -iPauseLinkWidth/2 +"px";
//	pauseLink.style.left = 0+screen.width/2-iPauseLinkWidth/2 +"px";

	//edited by Mike, 20221007
	//pauseLink.style.top = 0+iStageMaxHeight/2 +"px"; 
	pauseLink.style.top = 0+iStageMaxHeight +"px"; 
*/
	
	//notes: noticeable delay in CHANGE in position via repaint setting, et cetera	
	myUpdateFunction();
	//--------------------------------------------
	
  },duration);
  
  document.body.appendChild(el);
}

//edited by Mike, 20221030
//function keyPressDown(iKey) {
function keyPressDown(iKey, event) {	

	//added by Mike, 20230710
	//TODO: reverify: this; 
	//appears to NOT yet solve low-severity error
	//during auto-generation, 
	//where: target tile is highlighted
	if (bIsInitAutoGeneratePuzzleFromEnd) {
		return;
	}

	arrayKeyPressed[iKey]=true;	
	
	//added by Mike, 20221121
	for (iActionKeyCount=iDirectionTotalKeyCount; iActionKeyCount<iTotalKeyCount; iActionKeyCount++) {
		if (arrayKeyPressed[iActionKeyCount]) {
			bIsActionKeyPressed=true;
		}
	}		

	//edited by Mike, 20221030
	//arrayKeyPressed[iKey]=true;
	
	iEventChangedTouchCount = event.changedTouches.length;
					
	for (iCount=0; iCount<iEventChangedTouchCount; iCount++) {		
		if (event.changedTouches[iCount].screenX<screen.width/2) {
		}
		else {
			return;
		}
		
		//edited by Mike, 20221121; from 20221106
		for (iKeyCount=0; iKeyCount<iDirectionTotalKeyCount; iKeyCount++) {
		//for (iCount=0; iCount<iTotalKeyCount; iCount++) {
			arrayKeyPressed[iKeyCount]=false;
		}		
	
		arrayKeyPressed[iKey]=true;		
	}	
	
	iNoKeyPressCount=0;	
}

//edited by Mike, 20220918
//reverified: to be OK, onMouseUp with onMouseDown
//edited by Mike, 20221030
//function keyPressUp(iKey) {
function keyPressUp(iKey, event) {

//alert("RELEASE");

	//edited by Mike, 20221030
	arrayKeyPressed[iKey]=false;
	
	//added by Mike, 20221117
	bIsWalkingAction=false;
	
	//added by Mike, 20221121
	bIsActionKeyPressed=false;
}

//added by Mike, 20221029
//reference: https://stackoverflow.com/questions/62823062/adding-a-simple-left-right-swipe-gesture/62825217#62825217;
//answer by: smmehrab, 20200709T2330; edited 20200711T0355
function handleGesture() {
	//added by Mike, 20221030; edited by Mike, 20221108
/*	
	if ((document.fullscreenElement) && (!bIsUsingAppleMac)){
*/		
		if (iTouchEndX < iTouchStartX) {
			//console.log('Swiped Left');
			//alert("Swiped Left");
			arrayKeyPressed[iKEY_D]=false;		
			arrayKeyPressed[iKEY_A]=true;		
		}

		if (iTouchEndX > iTouchStartX) {
			//console.log('Swiped Right');
			//alert("Swiped Right");
			arrayKeyPressed[iKEY_D]=true;		
			arrayKeyPressed[iKEY_A]=false;		
		}

		if (iTouchEndY < iTouchStartY) {
			//console.log('Swiped Up');
//			alert("Swiped Up");
			arrayKeyPressed[iKEY_W]=true;		
			arrayKeyPressed[iKEY_S]=false;		
		}

		if (iTouchEndY > iTouchStartY) {
			//console.log('Swiped Down');
//			alert("Swiped Down");
			arrayKeyPressed[iKEY_W]=false;		
			arrayKeyPressed[iKEY_S]=true;		
		}

		if (iTouchEndY === iTouchStartY) {
	//        console.log('Tap');
//			alert("Tap");
			arrayKeyPressed[iKEY_D]=false;		
			arrayKeyPressed[iKEY_A]=false;	

			arrayKeyPressed[iKEY_W]=false;		
			arrayKeyPressed[iKEY_S]=false;
		}
/*		
	}
*/	
}

//added by Mike, 20221121
function reset() {
	bIsToLeftCornerDone=false;
	bIsToTopCornerDone=false;
	bIsToRightCornerDone=false;
	bIsToBottomCornerDone=false;
	bHasPressedStart=false;
	bIsActionKeyPressed=false;	

	bIsInitAutoGeneratePuzzleFromEnd=true;	
	bIsPuzzleDone=false;
	
	iCountMovementStep=0;
	
	//added by Mike, 20221123
	iHumanTileAnimationCount=0;
	iMonsterTileAnimationCount=0;
	
	//added by Mike, 20221124
	iDelayAnimationCountEnter=0;
	
	//added by Mike, 20250703
	iCongratsRestartDelayCount=0;
	bHasPressedRestartPuzzleDone=false;
	bIsExecuteEndingAnimationDone=false; //20250704

/*	//removed by Mike, 20250703	
	//added by Mike, 20221127	
	if (!bHasDefeatedMonster) {
		bHasDefeatedMonster=false;
		bHasDefeatedHuman=false;
		bHasHitMonster=false;
		iMonsterInHitStateCount=0;
		iHumanInHitStateCount=0;
		bIsMonsterExecutingAttack=false;
		bIsMonsterInHitState=false;	
		iCurrentArrayHealthActionCount=8;
		iCurrentArrayMonsterHealthActionCount=8;	
		//iMonsterTileAnimationCount=0;
		iNoKeyPressCount=0;
		bIsExecutingDestroyHuman=false;
	}	
*/	
	
	for (iCount=0; iCount<iTotalKeyCount; iCount++) {
		arrayKeyPressed[iCount]=false;
	}	
}

//added by Mike, 20221113
function initPuzzleTileTextValueContainer() {

	//added by Mike, 20221121
	reset();		

	iTileBgCount=0;
	
	//edited by Mike, 20221123
/*	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
*/			
	while (iTileBgCount<16) {					
			//alert(arrayPuzzleTileCountId[iTileBgCount].alt);
//			arrayPuzzleTileCountId[iTileBgCount].alt=(iTileBgCount+1)+"";		

			if (iTileBgCount==iTileBgCountMax-1) {
//alert(iTileBgCount);
				arrayPuzzleTileCountId[iTileBgCount].alt=""; //space
				
				//added by Mike, 20221106
				arrayPuzzleTileCountId[iTileBgCount].className="Image32x32TileSpace";		

				bIsTargetAtSpace=true;
			}
			else {
				arrayPuzzleTileCountId[iTileBgCount].className="Image32x32Tile";
			}
			
			iTileBgCount++;
//		}
	}
}

//added by Mike, 20221113
function initPuzzleEnd() {

	//added by Mike, 20221121
	reset();		
}

function processInput(iXPos, iYPos) {
		if (bIsUsingAppleWebKit) {
		  bIsUsingAppleMac=true;
		}
		
		toggleFullScreen();
		
		//added by Mike, 20230710
		if (!bHasViewedTitle) {
			return;
		}
		//added by Mike, 20230710				
		if (bIsInitAutoGeneratePuzzleFromEnd) {
			return;
		}
		//added by Mike, 20230710				
		if (bIsPuzzleDone) {
			return;
		}
/*				
		//added by Mike, 20230802
		var stepCountGuideImage = document.getElementById("stepCountGuideImageId");			
		//alert("dito");					
		if (stepCountGuideImage.style.visibility=="visible") {
			return;
		}
*/				
				
				
				//added by Mike, 20230121
				//TO-DO: put in reusable function
/*
				//note: ZOOM function causes position ERROR via screenX
				var iXPos = event.clientX;//screenX;

				//note: screenY includes BROWSER address bar, et cetera;
				var iYPos = event.pageY; //screenY;
*/				
/*
				alert("iXPos: "+iXPos);
				alert("iYPos: "+iYPos);		
*/				
				//TO-DO: -add: the following to verify if tile was clicked;
	//iTileBgCount=0;

	//added by Mike, 20230125
	//identify blank/empty tile
	var iTileBgCountOfEmptyTile=-1;
	
	//added by Mike, 20230522
	bIsActionKeyPressed=true;

	//added by Mike, 20230523
	bHasExecutedTileExchange=false;
		
	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {		
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) 		{

			//edited by Mike, 20230524
			iTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount];
//			iTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount]+1;
			
			if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
				iTileBgCountOfEmptyTile=iTileBgCount;
			}	
		}
	}


	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {		
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {
			//edited by Mike, 20230524		
			iTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount];
//			iTileBgCount=arrayPuzzleTilePos[iRowCount][iColumnCount]-1;

		//alert(iTileBgCount);
/* //edited by Mike, 20230123		
		var iTilePosX= arrayPuzzleTileCountId[iTileBgCount].style.left;
		var iTilePosY= arrayPuzzleTileCountId[iTileBgCount].style.Top;
*/

	//edited by Mike, 20230524	
		var iTilePosX= iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCount+iBorderOffset*iColumnCount;
		var iTilePosY=0+iOffsetHeight+iPuzzleTileHeight*iRowCount+iBorderOffset*iRowCount;

/*
		var iTilePosX= iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*(iColumnCount+1)+iBorderOffset*(iColumnCount+1);
		var iTilePosY=0+iOffsetHeight+iPuzzleTileHeight*(iRowCount+1)+iBorderOffset*(iRowCount+1);
*/
		//added by Mike, 20230524
/*		
		iXPos=iXPos+iPuzzleTileWidth/2;
		iYPos=iYPos+iPuzzleTileHeight/2;
*/		
		//alert("iXPos: "+iXPos+"; iTilePosX: "+iTilePosX);
		
				//iPuzzleTileWidth
//alert("iTilePosX: "+iTilePosX);
		
		//edited by Mike, 20230524	
		if (isPointsOfRectIntersectingPointsOfRect(iXPos,iYPos,iTilePosX,iTilePosY)) {
			//alert("HIT!");
			//OK; row1; columns; 1 to 4; 
			//row2; columns 5 to 8;...
/*
			alert("HIT! TILE COUNT: " + iTileBgCount);
			alert("arrayPuzzleTileCountId[iTileBgCount].alt: " + arrayPuzzleTileCountId[iTileBgCount].alt);
*/			
			//edited by Mike, 20230524
			if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
				return;
			}						
			//OK; number value of Tile
			//alert (arrayPuzzleTileCountId[iTileBgCount].alt);
			//if NOT blank/empty tile
			//edited by Mike, 20230524
			//if (arrayPuzzleTileCountId[iTileBgCount].alt!="") {
			else if (arrayPuzzleTileCountId[iTileBgCount].alt!="") {
/*			
				alert("HIT! EXCHANGE! " + iTileBgCount);
				//exchange				
				alert("EXCHANGE! EMPTY location: "+iTileBgCountOfEmptyTile);
*/				
/*				//edited by Mike, 20230524
				//added by Mike, 20230524
				//IF @TOP row
				if (iTileBgCountOfEmptyTile<4) {				
				}
				//IF NOT @TOP row
				else {
					//TOP-LEFT; CENTER-5
					if (iTileBgCount==iTileBgCountOfEmptyTile-5) {
						alert("TOP-LEFT; CENTER-5");
						return;
					}
					//TOP-RIGHT; CENTER-3
					else if (iTileBgCount==iTileBgCountOfEmptyTile-3) {
						alert("TOP-RIGHT; CENTER-3");
						return;
					}					
				}
*/		
/*		
				//move only to TOP, BOTTOM, LEFT, RIGHT
				//from CENTER
				//IF @TOP row
				if (iTileBgCountOfEmptyTile<4) {
				alert(iTileBgCountOfEmptyTile);
					//TOP; CENTER-4
					if (iTileBgCount==iTileBgCountOfEmptyTile-4) {				
						return; 
					}
					
				}
*/								
				//move only to TOP, BOTTOM, LEFT, RIGHT
				//from CENTER
				//IF intends to move to LEFT						
				if (iTileBgCount==iTileBgCountOfEmptyTile-1) {
					if (iColumnCount>-1) {					
						//added by Mike, 20250701
						//alert ("iColumnCount: "+iColumnCount);					
						if (iColumnCount==3) { //if moving to the right-most column
							return;
						}
					}
					else {
						return;
					}
				}
				//IF intends to move to RIGHT
				else if (iTileBgCount==iTileBgCountOfEmptyTile+1) {
					if (iColumnCount<iColumnCountMax) {		
						//added by Mike, 20250701
						//alert ("iColumnCount: "+iColumnCount);
						if (iColumnCount==0) { //if moving to the left-most column
							return;
						}
					}
					else {
						return;
					}
				}	
				//IF intends to move to TOP
				else if (iTileBgCount==iTileBgCountOfEmptyTile-4) {
					if (iRowCount>-1) {					
					}
					else {
						return;
					}
				}
				//IF intends to move to BOTTOM
				else if (iTileBgCount==iTileBgCountOfEmptyTile+4) {
					if (iRowCount<iRowCountMax) {					
					}
					else {
						return;
					}
				}					
				else {
					return;
				}			
				

				
				//alert("arrayPuzzleTileCountId[iTileBgCount].alt: " + arrayPuzzleTileCountId[iTileBgCount].alt);			

/*				arrayPuzzleTileCountId[iTileBgCountOfEmptyTile].alt=arrayPuzzleTileCountId[iTileBgCount].alt;

				arrayPuzzleTileCountId[iTileBgCount].alt="";
*/				
				//added by Mike, 20230522
				//-----
				bIsActionKeyPressed=true;
/*
arrayPuzzleTileCountId[iTileBgCount].className="Image32x32Tile";
				arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileSpace";
				
arrayPuzzleTileCountId[iTileBgCountOfEmptyTile].alt=arrayPuzzleTileCountId[iTileBgCount].alt;
*/
/*
arrayPuzzleTileCountId[iTileBgCount].className="Image32x32Tile";
arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileSpace";
*/
//edited by Mike, 20230523
arrayPuzzleTileCountId[iTileBgCountOfEmptyTile].className="Image32x32Tile";

var puzzleTileImageTargetBorder = document.getElementById("divPuzzleTileImageTargetBorderId");

//puzzleTileImageTargetBorder.style.visibility = "hidden";
puzzleTileImageTargetBorder.style.visibility = "visible";

//reminder: arrayPuzzleTileCountId[iTileBgCount].alt="";
					puzzleTileImageTargetBorder.style.left = arrayPuzzleTileCountId[iTileBgCount].style.left;
					
					puzzleTileImageTargetBorder.style.top = arrayPuzzleTileCountId[iTileBgCount].style.top;
					
					
arrayPuzzleTileCountId[iTargetTileBgCount].className="Image32x32TileSpace";


//arrayPuzzleTileCountId[iTileBgCountOfEmptyTile].alt=arrayPuzzleTileCountId[iTileBgCount].alt;

arrayPuzzleTileCountId[iTileBgCountOfEmptyTile].alt=arrayPuzzleTileCountId[iTileBgCount].alt;

//added by Mike, 20230523
//TO-DO: -add: NO DIAGONAL exchange;
iTargetTileBgCount=iTileBgCountOfEmptyTile;
				
				arrayPuzzleTileCountId[iTileBgCount].alt="";
				

//				alert("dito");
/*
				arrayPuzzleTileCountId[iTileBgCount].alt="";
				arrayPuzzleTileCountId[iTargetTileBgCount].alt="";
*/	
	//TO-DO: -verify: "iTargetTileBgCount" to cause incorrect output
				
				//arrayPuzzleTileCountId[iTileBgCountOfEmptyTile	].alt="";
								
				if (!bIsInitAutoGeneratePuzzleFromEnd) {
					//note: iCountMovementStep
					//iStepCountStatus++;
/*					
					if (arrayPuzzleTileCountId[iTileBgCount].alt=="") {
						bHasExecutedTileExchange=false;
						//alert( "FALSE!" );
					}
					else {
*/					
						bHasExecutedTileExchange=true;
						iStepCountStatus++;
/*
					}
*/					
				}					
				
				for (iKeyCount=0; iKeyCount<iDirectionTotalKeyCount; iKeyCount++) {
					arrayKeyPressed[iKeyCount]=false;
				}
				//-----
								
				//edited by Mike, 20230522
//				break;	//causes multiple entering in the function	
				return;		
			}			
		}

	}
  }
		
/*
		arrayPuzzleTileCountId[iTileBgCount].style.left = iHorizontalOffset+iOffsetWidth+iPuzzleTileWidth*iColumnCount+iBorderOffset*iColumnCount+"px";
		
//		arrayPuzzleTileCountId[iTileBgCount].style.top = iVerticalOffset+iPuzzleTileHeight*iColumnCount+"px";
		arrayPuzzleTileCountId[iTileBgCount].style.top = 0+iOffsetHeight+iPuzzleTileHeight*iRowCount+iBorderOffset*iRowCount+"px";			
*/		
}

//added by Mike, 20220822
function onLoad() {
	//added by Mike, 2022113
	//keyphrase: identify machine and computer browser

	//added by Mike, 20221108
	//alert(navigator.userAgent);

	//added by Mike, 20220910
	//reference: https://stackoverflow.com/questions/6666907/how-to-detect-a-mobile-device-with-javascript; last accessed: 20220910
	//answer by: Baraa, 20141026T2059
	//edited by Mike, 20221108
//	if (/Mobile|Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
	if (/Mobile|Android|webOS|iPhone|iPad|iPod|AppleWebKit|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {

//		alert("detected: Mobile Browser!");
		
		//added by Mike, 20220925
		bIsMobile=true;
		
		//added by Mike, 20221108
		if (navigator.userAgent.includes("AppleWebKit")) {
			bIsUsingAppleWebKit=true;
			//added by Mike, 20221109
			bIsUsingAppleMac=false; //default
		}
		
		//added by Mike, 20221113
		//notes: "AppleWebKit" to exist even with "Android"
		if (navigator.userAgent.includes("Android")) {
			bIsUsingAppleWebKit=false;
		}		

		//added by Mike, 20221113
		//example: Linux x86_64 (desktop)
		if (navigator.userAgent.includes("Linux x")) {		
			bIsMobile=false;
		}		

		//note: iPAD and MacBookPro OS : Mac OS X
		//adds: to be re-classified as iPAD via TOUCH command
		if ((navigator.userAgent.includes("Macintosh")) || navigator.userAgent.includes("Mac")) {
			bIsUsingAppleMac=true;
		}		
		
		//added by Mike, 20230111
		//note: TO-DO: -add: touch/mouse click ACTION COMMANDS
		//if using EDGE browser;
		//observed: shaking on EDGE browser via desktop,
		//caused by bIsMobile=true;
		if (navigator.userAgent.includes("Edge")) { //Edg
			bIsMobile=false;			
		}	
		
		
	}
	
	//added by Mike, 20221106
	iTileBgCount=0;

	for (iRowCount=0; iRowCount<iRowCountMax; iRowCount++) {		
		for (iColumnCount=0; iColumnCount<iColumnCountMax; iColumnCount++) {

		//alert(iTileBgCount);
			arrayPuzzleTilePos[iRowCount][iColumnCount]=iTileBgCount;

			arrayPuzzleTileCountId[iTileBgCount] = document.getElementById("puzzleTileImageIdBg"+iTileBgCount);

			arrayPuzzleTileCountId[iTileBgCount].style.visibility="hidden";
			
				//added by Mike, 20221106
				//reference: https://www.w3schools.com/tags/tag_img.asp;
				//last accessed: 20221105
				//count			
				//edited by Mike, 20221106				//arrayPuzzleTileCountId[iTileBgCount].alt=(iTileBgCount+1)+"";

				arrayPuzzleTileCountId[iTileBgCount].alt=(iTileBgCount+1)+"";
				
				//added by Mike, 20221106
				arrayPuzzleTileCountId[iTileBgCount].className="Image32x32Tile";	
		
			iTileBgCount++;
		}
	}

	//added by Mike, 20221122
	var controllerGuideImage = document.getElementById("controllerGuideImageId");			
	controllerGuideImage.style.visibility = "hidden"; //hidden

	//added by Mike, 20230115
	var stepCountGuideImage = document.getElementById("stepCountGuideImageId");			
	stepCountGuideImage.style.visibility = "hidden"; //hidden


	//reference: https://stackoverflow.com/questions/4917664/detect-viewport-orientation-if-orientation-is-portrait-display-alert-message-ad; last accessed: 20220910
	//answer by: Jatin, 20120731T0711;
	//edited by Tisho, 20120731T0730
	//add: listener to detect orientation change
	window.addEventListener("orientationchange", function() {
	  //orientation number (in degrees) : 90 and -90 for landscape; 0 for portrait
	  //edited by Mike, 20220911
	  //alert(window.orientation);
			
		//added by Mike, 20220910; edited by Mike, 20220911	
		var myBody = document.getElementById("myBodyId");

		//reference: https://stackoverflow.com/questions/4917664/detect-viewport-orientation-if-orientation-is-portrait-display-alert-message-ad; last accessed: 20220910
		//answer by: crmpicco, 20130515T1414;
		//edited by: posit labs, 20150929T1708
		//if ((window.orientation==0) ||
/*		
		if ((screen.orientation==0) ||
			(window.matchMedia("(orientation: portrait)").matches)) {
*/				
		if (screen.orientation==0) {
		  //alert("detected: PORTRAIT mode");
		   myBody.className='bodyPortraitMode';
		}
		else {//if (window.matchMedia("(orientation: landscape)").matches) {
		   //alert("detected: LANDSCAPE mode");	   	   
		   myBody.className='bodyLandscapeMode';
		}			  

		//tempAlert("close",1000);　//1sec
		//edited by Mike, 20220914
		//tempAlert("",1000);　//1sec
		tempAlert("",200);　//1/5sec		
				
		//TO-DO: -add: auto-update: object positions after CHANGE in orientation 
	}, false);

	//added by Mike, 20221118
	imgPuzzle = document.getElementById("puzzleImageId");

/* //removed by Mike, 20230115
	//added by Mike, 20220904	
	//TO-DO: -add: init; where: set initial positions, et cetera
	var monsterTile = document.getElementById("monsterTileImageId");
	monsterTile.style.left = screen.width/2 +"px"; //"100px";
	monsterTile.style.top = "0px"; //"100px";

	//edited by Mike, 20221120; from 20221118
	monsterTile.style.visibility="hidden"; //visible
*/

	document.body.onkeydown = function(e){
	//alert("e.keyCode: "+e.keyCode);
		
		//added by Mike, 20221108; edited by Mike, 20221115
		switch (iCurrentMiniGame) {
			case MINI_GAME_PUZZLE:
				if (bIsInitAutoGeneratePuzzleFromEnd) {
					return;
				}		
				break;
			case MINI_GAME_ACTION:
				break;						
		}
			
		//added by Mike, 20221121
		bIsActionKeyPressed=false;					
				
		//OK; //note: unicode keycode, where: key d : 100?
		//note: auto-accepts keyhold; however, with noticeable delay 
		//solved: via bKeyDownRight = false; et cetera
		if (e.keyCode==68) { //key d
	//			alert("dito");
			//humanTile.style.left =  iHumanTileX+iHumanStepX+"px";				
			//edited by Mike, 20220823
			//bKeyDownRight=true;
			arrayKeyPressed[iKEY_D]=true;			
		}
		else if (e.keyCode==65) { //key a			
			//edited by Mike, 20220823
			//humanTile.style.left =  iHumanTileX-iHumanStepX+"px";				
			arrayKeyPressed[iKEY_A]=true;			
		}
		
		//added by Mike, 20220822
		if (e.keyCode==87) { //key w		
			//edited by Mike, 20220823
			//humanTile.style.top =  iHumanTileY-iHumanStepY+"px";				
			arrayKeyPressed[iKEY_W]=true;			
		}
		else if (e.keyCode==83) { //key s
			//edited by Mike, 20220823
			//humanTile.style.top =  iHumanTileY+iHumanStepY+"px";				
			arrayKeyPressed[iKEY_S]=true;			
		}

		//added by Mike, 20221101		
		//notes: RIGHT-SIDE BUTTONS to already accept 
		//both capital and small letters

		//RIGHT-SIDE BUTTONS
		if (e.keyCode==73) { //key i
			arrayKeyPressed[iKEY_I]=true;		
			
			//added by Mike, 20221121
			bIsActionKeyPressed=true;	
		}
		else if (e.keyCode==75) { //key k			
			arrayKeyPressed[iKEY_K]=true;			

			//added by Mike, 20221121
			bIsActionKeyPressed=true;	
		}
		
		if (e.keyCode==74) { //key j		
			arrayKeyPressed[iKEY_J]=true;			

			//added by Mike, 20221121
			bIsActionKeyPressed=true;	
		}
		else if (e.keyCode==76) { //key l
			arrayKeyPressed[iKEY_L]=true;			

			//added by Mike, 20221121
			bIsActionKeyPressed=true;
		}				
	}

	//added by Mike, 20220822
	document.body.onkeyup = function(e){
		//alert("KEYUP; e.keyCode: "+e.keyCode);
		if (e.keyCode==68) { //key d
			//edited by Mike, 20220823
			//bKeyDownRight=false;
			arrayKeyPressed[iKEY_D]=false;						
		}
		else if (e.keyCode==65) { //key a			
			arrayKeyPressed[iKEY_A]=false;			
		}

		//added by Mike, 20220823
		if (e.keyCode==87) { //key w			
			arrayKeyPressed[iKEY_W]=false;			
		}
		else if (e.keyCode==83) { //key s			
			arrayKeyPressed[iKEY_S]=false;			
		}
		
		//added by Mike, 20221101
		//RIGHT-SIDE BUTTONS
		if (e.keyCode==73) { //key i
			arrayKeyPressed[iKEY_I]=false;		
			
			//added by Mike, 20221121
			bIsActionKeyPressed=false;	
		}
		else if (e.keyCode==75) { //key k			
			arrayKeyPressed[iKEY_K]=false;			

			//added by Mike, 20221121
			bIsActionKeyPressed=false;	
		}
		
		if (e.keyCode==74) { //key j		
			arrayKeyPressed[iKEY_J]=false;			

			//added by Mike, 20221121
			bIsActionKeyPressed=false;
		}
		else if (e.keyCode==76) { //key l
			arrayKeyPressed[iKEY_L]=false;			

			//added by Mike, 20221121
			bIsActionKeyPressed=false;	
		}		
	}	
	
	//added by Mike, 20221110
	//reference: https://stackoverflow.com/questions/70827887/detect-click-vs-touch-in-javascript;
	//last accessed: 20221110
	//answer by:  Jacob, 20220124T0110
	document.body.addEventListener('pointerdown', (event) => {
		//reference: https://developer.mozilla.org/en-US/docs/Web/API/PointerEvent/pointerType;
		//last accessed: 20221122
		switch(event.pointerType) {
/*
			case 'touch':
				//TODO: -verify: this
				if (bIsUsingAppleWebKit) {
				  //note: NOT yet set
				  if (bIsUsingAppleMac) {
					toggleFullScreen();
				  }

				  bIsUsingAppleMac=false;
				  bIsMobile=true;
				  
				  bHasSetMaxWidthHeight=true;
				}
*/
				//apply also 'mouse' instructions
			case 'mouse':	
			
				//note: ZOOM function causes position ERROR via screenX
				var iXPos = event.clientX;//screenX;

				//note: screenY includes BROWSER address bar, et cetera;
				var iYPos = event.pageY; //screenY;
			
				processInput(iXPos,iYPos);										
				break;
/*				
			case 'touch':
			    //alert("TOUCH");		  
			    if (bIsUsingAppleWebKit) {
				  //added by Mike, 20221111; removed by Mike, 20221118
				  //note: NOT yet set
				  if (bIsUsingAppleMac) {
					toggleFullScreen();
				  }

				  bIsUsingAppleMac=false;
				  bIsMobile=true; //added by Mike, 20221110			
				  
				  //added by Mike, 20230111
				  bHasSetMaxWidthHeight=true;
				}
				break;				
*/				
		}

	});

	//added by Mike, 20221029
	//reference: https://stackoverflow.com/questions/62823062/adding-a-simple-left-right-swipe-gesture/62825217#62825217;
	//answer by: smmehrab, 20200709T2330; edited 20200711T0355
	document.body.addEventListener('touchstart', function (event) {
		iEventChangedTouchCount = event.changedTouches.length;
		
		for (iCount=0; iCount<iEventChangedTouchCount; iCount++) {
			//note: ZOOM function causes position ERROR via screenX
			var iXPos = event.changedTouches[iCount].clientX;//screenX;

			//note: screenY includes BROWSER address bar, et cetera;
			var iYPos = event.changedTouches[iCount].pageY; //screenY;
		}
				
		processInput(iXPos,iYPos);
	});
/*	
		
		iEventChangedTouchCount = event.changedTouches.length;
		
		for (iCount=0; iCount<iEventChangedTouchCount; iCount++) {
			
		//added by Mike, 20221121
		if (iCurrentMiniGame==MINI_GAME_PUZZLE) {
			if (bHasPressedStart) {
				//edited by Mike, 20221121
				//note: ZOOM function causes position ERROR via screenX
				var iXPos = event.changedTouches[iCount].clientX;//screenX;

				//note: screenY includes BROWSER address bar, et cetera;
				var iYPos = event.changedTouches[iCount].pageY; //screenY;

				//alert(iYPos);


			}
		}
		
			
			if (event.changedTouches[iCount].screenX<screen.width/2) {
			}
			else {
				return;
			}
		
		//alert("hallo");
		
			iTouchStartX = event.changedTouches[iCount].screenX;
			iTouchStartY = event.changedTouches[iCount].screenY;		

			//alert("iTouchStartX: "+iTouchStartX);
			
			//added by Mike, 20221030
			iTouchStartCount=0;
		}

	}, false);

	document.body.addEventListener('touchend', function (event) {
		iEventChangedTouchCount = event.changedTouches.length;
		
		for (iCount=0; iCount<iEventChangedTouchCount; iCount++) {		
			if (event.changedTouches[iCount].screenX<screen.width/2) {
			}
			else {
				return;
			}
			iTouchEndX = event.changedTouches[iCount].screenX;
			iTouchEndY = event.changedTouches[iCount].screenY;

			//alert("iTouchEndX: "+iTouchEndX);

			handleGesture();
		}
	}, false);
	
			
	//added by Mike, 20221030
	//note: keyPress, keyRelease
	//adds: keyphrase: RELAX (with TOUCH inputs), 
	//--> not excessively fast ACTION; 
	//swipe command received as input @most one (1) time only;
	//afterwards, shall need keyReleased, i.e. keyUP;
	document.body.addEventListener('touchmove', function (event) {
		//alert(event.changedTouches.length);
		
		iEventChangedTouchCount = event.changedTouches.length;
		
		for (iCount=0; iCount<iEventChangedTouchCount; iCount++) {		
			if (event.changedTouches[iCount].screenX<screen.width/2) {
			}
			else {
				return;
			}
		
//			if (event.changedTouches[0]) {
//			if (iCount==0) {
			//if (true) {
		
			//added by Mike, 20221030
			iPrevTouchStartX=iTouchStartX;
			iPrevTouchStartY=iTouchStartY;

			iTouchStartX = event.changedTouches[iCount].screenX;
			iTouchStartY = event.changedTouches[iCount].screenY;		

			//alert("iTouchStartX: "+iTouchStartX);

			//alert("iTouchStartY: "+iTouchStartY);

			
			//added by Mike, 20221030; removed by Mike, 20221030
			//iTouchStartCount=0;
			
			//added by Mike, 20221031
			var buttonRightKey = document.getElementById("rightKeyId");
			var buttonUpKey = document.getElementById("upKeyId");
			
			//edited by Mike, 20230207
			//var iButtonWidth = buttonRightKey.getBoundingClientRect().width;
			var iButtonWidth = buttonUpKey.getBoundingClientRect().width;
			var iButtonHeight = buttonUpKey.getBoundingClientRect().height;
			
	
			//swiped left
			if (iTouchStartX<iPrevTouchStartX) {				
	//				alert("dito");

				//if initial movement to RIGHT
				//and swiped to LEFT (opposite direction)
				if (arrayKeyPressed[iKEY_D]) {
					
					iTouchEndX=iTouchStartX;
//					iTouchEndY=iTouchStartY;

					iTouchStartX=iPrevTouchStartX;
//					iTouchStartY=iPrevTouchStartY;
					
					//added by Mike, 20221031
					//swiped to LEFT					
					//distance get in x-axis
					//alert(iTouchStartX-iTouchEndX);
					
					iDistanceXAxis=iTouchStartX-iTouchEndX;					
//					iDistanceXAxis=iTouchEndX-iTouchStartX;					

					//iButtonWidth = buttonUpKey.getBoundingClientRect().width;

					//TO-DO: reverify: CAUSE iButtonWidth/5
//					if (iDistanceXAxis<=iButtonWidth/5) {
					if (iDistanceXAxis<=iButtonWidth/6) {
						arrayKeyPressed[iKEY_A]=false;
						arrayKeyPressed[iKEY_D]=false;	
			
					}
					else {						
						arrayKeyPressed[iKEY_A]=true;
						arrayKeyPressed[iKEY_D]=false;

						iTouchStartCount=0;			
					}
				}
			}
			//swiped right
			else if (iTouchStartX>iPrevTouchStartX) {				
				//if initial movement to LEFT
				//and swiped to RIGHT (opposite direction)
				if (arrayKeyPressed[iKEY_A]) {
					iTouchEndX=iTouchStartX;
//					iTouchEndY=iTouchStartY;

					iTouchStartX=iPrevTouchStartX;
//					iTouchStartY=iPrevTouchStartY;
					
					//handleGesture();

					//added by Mike, 20221031
					//swiped to RIGHT
					//distance get in x-axis
					//alert(iTouchStartX-iTouchEndX);
					
					iDistanceXAxis=iTouchEndX-iTouchStartX;					
					//iButtonWidth = buttonUpKey.getBoundingClientRect().width;

//					if (iDistanceXAxis<=iButtonWidth/5) {
					if (iDistanceXAxis<=iButtonWidth/6) {
						arrayKeyPressed[iKEY_A]=false;
						arrayKeyPressed[iKEY_D]=false;
					}
					else {
						arrayKeyPressed[iKEY_A]=false;
						arrayKeyPressed[iKEY_D]=true;

						iTouchStartCount=0;			
					}
				}
			}
			
			//added by Mike, 20221030
			//swiped up
			if (iTouchStartY < iPrevTouchStartY) {
								
				//if initial movement to DOWN
				//and swiped to UP (opposite direction)
				if (arrayKeyPressed[iKEY_S]) {
				
//					alert("dito");

				
//					iTouchEndX=iTouchStartX;
					iTouchEndY=iTouchStartY;

//					iTouchStartX=iPrevTouchStartX;
					iTouchStartY=iPrevTouchStartY;
					
					//added by Mike, 20221031
					//swiped to UP
					//distance get in y-axis
					//alert(iTouchStartY-iTouchEndY);					
					iDistanceYAxis=iTouchStartY-iTouchEndY;					

					//iButtonWidth = buttonUpKey.getBoundingClientRect().width;

					//TO-DO: reverify: CAUSE iButtonHeight/5
//					if (iDistanceYAxis<=iButtonHeight/5) {
					if (iDistanceYAxis<=iButtonHeight/6) {
						arrayKeyPressed[iKEY_W]=false;		
						arrayKeyPressed[iKEY_S]=false;		
			
					}
					else {						
						arrayKeyPressed[iKEY_W]=true;		
						arrayKeyPressed[iKEY_S]=false;		

						iTouchStartCount=0;			
					}
				}
			}
			//swiped down
			else if (iTouchStartY > iPrevTouchStartY) {
				//if initial movement to UP
				//and swiped to DOWN (opposite direction)
				if (arrayKeyPressed[iKEY_W]) {
//					iTouchEndX=iTouchStartX;
					iTouchEndY=iTouchStartY;

//					iTouchStartX=iPrevTouchStartX;
					iTouchStartY=iPrevTouchStartY;


					//added by Mike, 20221031
					//swiped to DOWN
					//distance get in y-axis
					//alert(iTouchStartY-iTouchEndY);					
					iDistanceYAxis=iTouchEndY-iTouchStartY;					

//alert(iButtonHeight);

					//TO-DO: reverify: CAUSE iButtonHeight/5
//					if (iDistanceYAxis<=iButtonHeight/5) {
					if (iDistanceYAxis<=iButtonHeight/6) {
						arrayKeyPressed[iKEY_W]=false;		
						arrayKeyPressed[iKEY_S]=false;		
					}
					else {						
						arrayKeyPressed[iKEY_W]=false;		
						arrayKeyPressed[iKEY_S]=true;		

						iTouchStartCount=0;			
					}
				}
			}			
			
		}
//		}

	}, false);
*/	

	//added by Mike, 20221113
	initPuzzleTileTextValueContainer();
		
			
	//edited by Mike, 20221126; from 20220904
	//fFramesPerSecond=16.66;
	//setInterval(myUpdateFunction, 16.66); //1000/60=16.66; 60 frames per second	
	iCurrentIntervalId=setInterval(myUpdateFunction, fFramesPerSecond); //1000/60=16.66; 60 	
}		

	
	  </script>
  <!-- edited by Mike, 20220822 -->
  <body id="myBodyId" onload="onLoad();">

	<canvas id="myCanvasId" class="myCanvas">
	</canvas>
	
	<!-- added by Mike, 20221125 -->
	<canvas id="myEffectCanvasId" class="myEffectCanvas">
	</canvas>

<!--
//reference: https://stackoverflow.com/questions/9454125/javascript-request-fullscreen-is-unreliable;
//last accessed: 20220825
//answer by: Sally Hammel, 20120409T1402
//edited by: BenMorel, 20131209T1511
-->
<!-- href="/flashStage"; href="#" //Full Screen Mode -->

<a id="pauseLinkId" class="pauseLink" onClick="toggleFullScreen()"><u>START</u></a>

<!-- edited by Mike, 20221119; from 20221105; mtPinatubo20150115T1415.jpg -->
	<img id="puzzleImageId" class="ImageBackgroundOfPuzzle" src="<?php echo base_url('../assets/images/blank.png');?>">	

<!-- added by Mike, 20221121; removed by Mike, 20230129	
	<img id="miniPuzzleTileImageId" class="ImageMiniPuzzleImage" onerror="" src="<?php echo base_url('assets/images/cambodia1024x1024-20141225T0958.jpg');?>" alt="" title="">	
-->
 
<!-- added by Mike, 20221122 -->
	<img id="controllerGuideImageId" class="ImageController" src="<?php echo base_url('assets/images/gameOff2022ControllerGuide.png');?>">	

<button id="controllerGuideButtonId" class="ButtonControllerGuide" onClick="toggleControllerGuide()">
</button>		

	<img id="controllerGuideMiniImageId" class="ImageMiniController" src="<?php echo base_url('assets/images/gameOff2022MiniControllerGuide.png');?>">	


<!-- added by Mike, 20230115; add: display leaderboard -->
	<img id="stepCountGuideImageId" class="ImageStepCount" src="<?php echo base_url('assets/images/blank.png?lastmod=20241213T1501');?>">	

<!-- added by Mike, 20241213; from 20230113; toggleStepCountGuide() -->
<button id="stepCountGuideButtonId" class="ButtonStepCountGuide" onClick="">
</button>		

	<img id="stepCountGuideMiniImageId" class="ImageMiniStepCount" src="<?php echo base_url('assets/images/miniStepCountGuide.png');?>">	


<!-- added by Mike, 20221129 -->
	<img id="howToPlayGuideImageId" class="ImageHowToPlayGuide" src="<?php echo base_url('assets/images/gameOff2022HowToPlay.png?lastmod=20241209T1031');?>">	

<!-- 
 added by Mike, 20221130 
 echo "../assets/images/gameOff2022Title.png"; /*
-->
	<img id="titleImageId" class="ImageTitle" src="<?php echo base_url('assets/images/gameOff2022Title.png?lastmod=20241220T1219');?>">	

	
	<div id="textStatusDivId" class="DivTextStatus">CONGRATULATIONS!</div>
	<div id="textEnterDivId" class="DivTextEnter">PRESS ENTER</div>

	<img id="starPuzzleTileImageIdBg" class="ImageMiniControllerLarge" onerror="" src="<?php echo base_url('assets/images/faviconLarge.png?lastmod=20250704');?>" alt="" title="">
			
<?php 
	$iRowCountMax=4; 
	$iColumnCountMax=4; 	

	//16=4*4
	$iTileBgCountMax=$iRowCountMax*$iColumnCountMax;

for ($iCount=0; $iCount<$iTileBgCountMax; $iCount++) {
	//edited by Mike, 20221113; from 20221111
	//count.png
	//cambodia128x128-20141225T0958.jpg
	//cambodia512x512-20141225T0958.jpg
	//cambodia1024x1024-20141225T0958.jpg
	//count1024x1024.png
?>		
	<img id="puzzleTileImageIdBg<?php echo $iCount;?>" class="Image32x32Tile" onerror="" src="<?php echo base_url('assets/images/count.png');?>" alt="" title="">

<?php
}
?>
	<!-- added by Mike, 20221119 -->
	<div id="divPuzzleTileImageTargetBorderId" class="Image32x32TileTargetBorder"></div>

	<!-- added by Mike, 20221121 -->
	<div id="divPuzzleTileImageSpaceBorderId" class="Image32x32TileSpaceBorder"></div>
	
	<!-- added by Mike, 20221122 -->
<?php

$iActionHealthMax=8;

for ($iCount=0; $iCount<$iActionHealthMax; $iCount++) {	
?>
	<div id="divActionHealthId<?php echo $iCount;?>" class="ImageHealthTile"></div>

	<div id="divActionMonsterHealthId<?php echo $iCount;?>" class="ImageMonsterHealthTile"></div>

<?php
}
?>

<!-- removed by Mike, 20220911
	<br />
	<div class="copyright">
		<span>© <b>www.usbong.ph</b> 2011~<?php echo date("Y");?>. All rights reserved.</span>
	</div>		 
-->	

	<!-- added by Mike, 20230112; from 20221213; note: correct sequence -->
	<div id="stepCountStatusShadowDivId" class="DivStepCountStatusShadow">0</div>
	<div id="stepCountStatusDivId" class="DivStepCountStatus">0</div>


<!-- edited by Mike, 20220918; 
	replaced: onClick COMMAND, with onMouseDown to be onMouseUp-->
<!--　//note: OUTPUT OK with computer browser with mouse
<a id="leftKeyId" class="controlKeyButtonAsLink" onMouseDown="leftKeyPressDown()" onMouseUp="leftKeyPressUp()"><|</a>
-->
<!--　//note: OUTPUT OK with Android touchscreen -->
<?php
	const iKEY_W = 0;
	const iKEY_S = 1;
	const iKEY_A = 2;
	const iKEY_D = 3;

	//added by Mike, 20221021
	const iKEY_I = 4;
	const iKEY_K = 5;
	const iKEY_J = 6;
	const iKEY_L = 7;

?>


<button id="upKeyId" class="controlKeyButtonUp" ontouchstart="keyPressDown(<?php echo iKEY_W;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_W;?>, event)">AAA</button>
<button id="leftKeyId" class="controlKeyButtonLeft" ontouchstart="keyPressDown(<?php echo iKEY_A;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_A;?>, event)">AAA</button>
<button id="rightKeyId" class="controlKeyButtonRight" ontouchstart="keyPressDown(<?php echo iKEY_D;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_D;?>, event)">AAA</button>
<button id="downKeyId" class="controlKeyButtonDown" ontouchstart="keyPressDown(<?php echo iKEY_S;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_S;?>, event)">AAA</button>

<!-- //edited by Mike, 20230209; from 20221019 -->
<button id="leverCenterNeutralKeyId" class="controlKeyButtonLeverCenterNeutral">AAA</button>

<!-- //added by Mike, 20221021 -->
<button id="letterIKeyId" class="controlKeyButtonLetterI" ontouchstart="keyPressDown(<?php echo iKEY_I;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_I;?>, event)">AAA</button>
<button id="letterJKeyId" class="controlKeyButtonLetterJ" ontouchstart="keyPressDown(<?php echo iKEY_J;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_J;?>, event)">AAA</button>
<button id="letterLKeyId" class="controlKeyButtonLetterL" ontouchstart="keyPressDown(<?php echo iKEY_L;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_L;?>, event)">AAA</button>
<button id="letterKKeyId" class="controlKeyButtonLetterK" ontouchstart="keyPressDown(<?php echo iKEY_K;?>, event)" ontouchend="keyPressUp(<?php echo iKEY_K;?>, event)">AAA</button>

<!-- //edited by Mike, 20230209; from 20221019 -->
<button id="rightLeverCenterNeutralKeyId" class="controlKeyButtonRightLeverCenterNeutral">AAA</button>

<!-- //edited by Mike, 20221110
	//reference: https://stackoverflow.com/questions/12804028/safari-with-audio-tag-not-working; 
	//last accessed: 20221110
	//answer by: George Dimitriadis, 20171016T1500
	//edited by: 404 - Brain Not Found, 20221124T2110
	
	//edited by Mike, 20221119
	//audio/x-m4a
	//UsbongGameOff2022Puzzle20221119T1427.mp3
	//UsbongGameOff2022Action20221119T1911.mp3
	//UsbongGameOff2022ActionPiano20221122T1542.mp3
	
	//note: put audio file in SERVER on CLOUD
-->
	<audio id="myAudioId" class="myAudio" src="assets/audio/UsbongGameOff2022Action20221119T1911.mp3" type="audio/x-m4a" controls loop>
	  Your browser does not support the audio tag.
	</audio><br/>	

	<audio id="myAudioEffectId" class="myAudio" src="assets/audio/UsbongGameOff2022ActionStartV20221126T0554.mp3" type="audio/x-m4a">
	  Your browser does not support the audio tag.
	</audio><br/>	

	<!-- added by Mike, 20221215 -->
	<span id="puzzleRecordedStepsId" class="puzzleRecordedStepsSpan">
<?php		
		//added by Mike, 20221231
		//debug; example value
		$sRecordedSteps="3121220312133003112111302212133333303312003030030303133122112122121303033033311212002";

		echo $sRecordedSteps;
	

?>		
	</span>

  </body>
</html>
