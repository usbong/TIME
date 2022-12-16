/*
' Copyright 2022 SYSON, MICHAEL B.
'
' Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
'
' http://www.apache.org/licenses/LICENSE-2.0
'
' Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.
'
' @company: USBONG
' @author: SYSON, MICHAEL B.
' @date created: 20221216
' @date updated: 20221215
' @website: www.usbong.ph
'
' Notes:
' 1) execute javascript instructions inside Java instructions
' --> no need to translate existing javascript instruction into Java Computer Language;
' --> use output from javascript instructions as input to PHP instructions that connect to Database executed via Java instructions;
' --> HTTP components from Apache with Java instructions;
' --> execution already @SERVER;
'
' 2) Node.js also exists to execute javascript instructions;
' --> downloaded @https://nodejs.org/en/; last accessed: 20221216
' --> No USBONG sample instructions yet to connect to PHP instructions
'
' References:
'	1) https://stackoverflow.com/questions/22856279/call-external-javascript-functions-from-java-code; last accessed: 20221216
'	--> question by: MRK187, 20140404T0727; edited by: Andrii Abramov, 20200529T1505; 
'	--> answer by: user432, 20140404T0740
'
'	2) https://docs.oracle.com/javase/10/nashorn/introduction.htm#JSNUG136; last accessed: 20221216
'
'	3) The Apache Software Foundation. (2019). The Official Apache HttpComponents Homepage. https://hc.apache.org/index.html; last accessed: 20221216; from 20190810
'
'   4) https://github.com/usbong/SLHCC/tree/master/SLHCC/Cashier/generatePayslipAndORSlipForTheDay/add-on%20software; last accessed: 20221216
*/

import javax.script.*;

//added by Mike, 20221216
//used with reading external .js file
import java.lang.Object;
import java.nio.charset.StandardCharsets;
import java.nio.file.Paths;
import java.nio.file.Files;

/* //removed by Mike, 20221216
//OK
public class halimbawaJSFunctionExecutedViaJVM {

public static void main(String[] args) throws Exception {
    ScriptEngineManager manager = new ScriptEngineManager();
    ScriptEngine engine = manager.getEngineByName("JavaScript");

    // JavaScript code in a String
    
    String script1 = "function greet(name) {print ('Hallo, ' + name);}";
    
    //String script2 = "function getValue(a,b) { if (a===\"Number\") return 1; 
    //                 else return b;}";
    // evaluate script
    engine.eval(script1);
    //engine.eval(script2);

    Invocable inv = (Invocable) engine;

    inv.invokeFunction("greet", "USBONG!");  //This one works.      
 }
}
*/

//OK
public class halimbawaJSFunctionExecutedViaJVM {

public static void main(String[] args) throws Exception {
    ScriptEngineManager manager = new ScriptEngineManager();
    ScriptEngine engine = manager.getEngineByName("JavaScript");

    // JavaScript code from an external file
   
	// read script file
//	engine.eval(Files.newBufferedReader(Paths.get("C:/Scripts/Jsfunctions.js"), StandardCharsets.UTF_8));
	
	engine.eval(Files.newBufferedReader(Paths.get("/opt/lampp/htdocs/usbong_time/kasangkapan/add-on software/assets/halimbawaJSFunction.js"), StandardCharsets.UTF_8));
	
	Invocable inv = (Invocable) engine;
	// call function from script file
	inv.invokeFunction("greet", "USBONG!");

 }
}
