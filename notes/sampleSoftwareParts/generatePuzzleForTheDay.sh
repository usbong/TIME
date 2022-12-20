#!/bin/bash

# Copyright 2020~2022 USBONG
#
# Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
#
# http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.
#
# @company: USBONG
# @author: SYSON, MICHAEL B.
# @date created: 20201001
# @last modified: 20221220; from 20221216

#set mainDirectory=%~dp0
#cd /d %mainDirectory%

#Windows Machine
#java -cp .\software;.\software\org.json.jar;.\software\org.apache.httpclient.jar;.\software\org.apache.httpcore.jar;.\software\org.apache.commons-logging.jar UsbongHTTPConnect http://localhost/ input/*.txt

#TO-DO: -reverify: this

#Linux Machine
#java -cp ./software:./software/org.json.jar:./software/org.apache.httpclient.jar:./software/org.apache.httpcore.jar:./software/org.apache.commons-logging.jar UsbongHTTPConnect http://localhost/ input/*.txt

#java -cp ./software:./software/org.json.jar:./software/org.apache.httpclient.jar:./software/org.apache.httpcore.jar:./software/org.apache.commons-logging.jar UsbongHTTPConnect http://localhost/ output/*.txt

#added by Mike, 20221220
#note: add this due to directory where CRON command is executed 
#may NOT be in this same directory
#reminder: update to the CORRECT file location 
cd /opt/lampp/htdocs/usbong_time/kasangkapan/"add-on software"/

java halimbawaJSFunctionExecutedViaJVM

java -cp ./httpConnectSoftwarePart:./httpConnectSoftwarePart/org.json.jar:./httpConnectSoftwarePart/org.apache.httpclient.jar:./httpConnectSoftwarePart/org.apache.httpcore.jar:./httpConnectSoftwarePart/org.apache.commons-logging.jar UsbongHTTPConnect http://localhost/ output/*.txt


#cd ..
#%2

#PAUSE
#exit
