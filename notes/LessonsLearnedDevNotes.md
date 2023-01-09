# Lessons-learned: Development Notes

## 1) OUTPUT of reusing javascript instructions via JAVA parser engine 

### Additional Note:

COMMAND from PHP, to BSHELL (UBUNTU OS), to JAVA, to javascript;<br/>
<br/>
<b>echo shell_exec($sCommand);</b><br/>

### OUTPUT

--> receiving INCORRECT OUTPUT<br/> 
--> due to: permission requested by OS to make directory,<br/>
--> create new output file, et cetera;<br/>
<br/>
--> adds: however, removing PHP in the sequence of COMMANDS,<br/> 
--> shall cause CORRECT OUTPUT<br/>
--> shares: added PHP COMMAND to auto-generate input (puzzle for the day),<br/>
--> IF it has not yet been generated,<br/>
--> due to: SERVER was shutdown, et cetera;<br/>
--> keyphrase: a puzzle for the day always exists
