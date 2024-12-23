# Lessons-learned: Development Notes

## 1) OUTPUT of reusing javascript instructions via JAVA parser engine 

### Additional Note:

COMMAND from PHP, to BSHELL (UBUNTU OS), to JAVA, to javascript;<br/>
<br/>
<b>echo shell_exec($sCommand);</b><br/>

### OBJECTIVE

AUTO-GENERATE puzzle for the day if does NOT yet exist when user enters the web service,<br/>
--> due to: SERVER was shutdown, et cetera;<br/>
--> keyphrase: a puzzle for the day always exists

### OUTPUT

--> receiving INCORRECT OUTPUT<br/> 
--> due to: permission requested by OS to make directory,<br/>
--> create new output file, et cetera;<br/>
<br/>
--> adds: however, removing PHP in the sequence of COMMANDS,<br/> 
--> shall cause CORRECT OUTPUT<br/>
--> shares: added PHP COMMAND to auto-generate input (puzzle for the day),<br/>
--> when user enters the web service;<br/>
--> adds: [Task Scheduling](https://github.com/usbong/TIME/blob/main/notes/TaskScheduling.md) to auto-generate puzzle at set TIME already exists,<br/>
--> albeit shall NOT execute IF SERVER is OFF<br/>
--> notes: [Task Scheduling](https://github.com/usbong/TIME/blob/main/notes/TaskScheduling.md) : BSHELL (UBUNTU OS), to JAVA, to javascript;<br/>
<br/>
--> adds: multiple people who enter the web service at nearly the same time,<br/>
--> may cause multiple puzzles to be auto-generated via this ACTION;<br/>
<br/>
--> admits: opted to verify this ACTION first,<br/>
--> instead of auto-verifying and generating the puzzle for the day<br/> 
--> when OS boots from shutdown;<br/>
--> due to: appeared faster to execute;

## 2) CONTROLLER INPUT technique 

observed: ACTION BUTTONS (at RIGHT PANEL) are NOT hit by human user fingers;<br/>
--> when the buttons are NOT observed by human user;<br/>
--> adds: instead the space, e.g. TOP-LEFT, is hit;<br/>
--> TO-DO: -verify: adding ACTION button for TOP-LEFT, et cetera;<br/>
--> adds: assistive AI to auto-identify if human user going for LEFT, instead of TOP;<br/>
<br/>
notes: TOUCH screen technique of TILE to move exists;<br/>
--> however, CONTROLLER INPUT can be reused, e.g. turn-based GAME;

