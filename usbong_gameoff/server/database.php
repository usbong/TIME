<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
  Copyright 2019~2022 SYSON, MICHAEL B.
  
  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You ' may obtain a copy of the License at
  http://www.apache.org/licenses/LICENSE-2.0
  Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, ' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing ' permissions and limitations under the License.

  @company: USBONG
  @author: SYSON, MICHAEL B.
  @date created: 20200521
  @date updated: 20221217; from 20221110
  @website address: www.usbong.ph

  Given:
  1) Database (DB) details

  Output:
  1) Containers with the DB details as value.
  
  Note:
  1) The containers enable a person to access the DB details using only one (1) container name for each DB detail regardless of whether its value changes.
  
  Reference:
  1) Usbong KMS; https://github.com/usbong/kms
*/

$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = '';
$db['database'] = 'usbong_time';

?>
