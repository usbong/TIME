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
' @date updated: 20221217; from 20221216
' @website: www.usbong.ph
'
' Notes:
' 1) execute javascript instructions inside Java instructions
' --> no need to translate existing javascript instruction into Java Computer Language;
' --> use output from javascript instructions as input to PHP instructions that connect to Database executed via Java instructions;
' --> HTTP components from Apache with Java instructions;
' --> execution already @SERVER;
'
' 2) The following cause ERROR in OUTPUT when used with Java's ScriptEngineManager:
'	2.1) window
'	2.2) let
'	2.3) const
'
' 3) Node.js also exists to execute javascript instructions;
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
'
'   5) https://stackoverflow.com/questions/39644510/java-code-cannot-invoke-method-from-scriptengine-with-new-context;
'	//last accessed: 20221217
'	//answer by: Andreas, 20160922T1704, edited 20160922T1714
'
'   6) generateMonthlySummaryReportWithDiagnosedCasesOfAllInputFiles.java;
'	//last accessed: 20221217
*/

import javax.script.*;

//added by Mike, 20221216
//used with reading external .js file
import java.lang.Object;
import java.nio.charset.StandardCharsets;
import java.nio.file.Paths;
import java.nio.file.Files;

//added by Mike, 20221217; removed by Mike, 20221217
//return value from javascript
//import jdk.nashorn.api.scripting.JSObject;

//added by Mike, 20221217
import java.util.ArrayList;
import java.util.List;

//added by Mike, 20221217
import java.io.PrintWriter;
import java.io.File;

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

	//added by Mike, 20221217
	//Reference: https://stackoverflow.com/questions/39644510/java-code-cannot-invoke-method-from-scriptengine-with-new-context;
	//last accessed: 20221217
	//answer by: Andreas, 20160922T1704, edited 20160922T1714

	//note: technique puts Java object into Javascript function
	//adds: Java object with received value can be used,
	//as with adding container's value 
	//via return command from Javascript function
	//notes: NOT yet verified which object types usable;
	
	List<String> list = new ArrayList<>();
	Bindings scope = engine.getBindings(ScriptContext.ENGINE_SCOPE);
	scope.put("list", list);

    // JavaScript code from an external file
   
	// read script file
//	engine.eval(Files.newBufferedReader(Paths.get("C:/Scripts/Jsfunctions.js"), StandardCharsets.UTF_8));
		
//	engine.eval(Files.newBufferedReader(Paths.get("/opt/lampp/htdocs/usbong_time/kasangkapan/add-on software/assets/halimbawaJSFunction.js"), StandardCharsets.UTF_8));
	
	//@current directory path
	//edited by Mike, 20221217
//	engine.eval(Files.newBufferedReader(Paths.get("./assets/halimbawaJSFunction.js"), StandardCharsets.UTF_8));
	
	engine.eval(Files.newBufferedReader(Paths.get("./assets/autoGeneratePuzzleFromEndForStorage.js"), StandardCharsets.UTF_8));
	
	Invocable inv = (Invocable) engine;
	// call function from script file
	//edited by Mike, 20221217
	//inv.invokeFunction("greet", "USBONG!");
	inv.invokeFunction("onLoad");

/*	//removed by Mike, 20221217
	Object oOutput = inv.invokeFunction("onLoad");
	System.out.println("oOutput: "+oOutput);

	String sOutput = (String)oOutput;	
	System.out.println("sOutput: "+sOutput);
*/	

	//edited by Mike, 20221217	
//	System.out.println(list);	
	System.out.println(list.get(0));	
	
	//added by Mike, 20221217
	makeFilePath("./output");
	printOutputToFile(list);
 }
 
 //added by Mike, 20221217
 private static void makeFilePath(String filePath) {
	File directory = new File(filePath);		
	if (!directory.exists() && !directory.mkdirs()) 
    {
    	System.out.println("File Path to file could not be made.");
    }    			
 } 

 //added by Mike, 20221217 
 private static void printOutputToFile(List<String> listInput) {
 	try {
 		PrintWriter outputWriter = new PrintWriter("output/sRecordedSteps.txt", "UTF-8");	
		
		outputWriter.print(listInput.get(0));		
	
		outputWriter.close();
	}
	catch (Exception e) {
	}
 }
 
}
