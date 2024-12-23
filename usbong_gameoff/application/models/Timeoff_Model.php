<?php 

/*
' Copyright 2020~2023 USBONG
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
' @date updated: 20230109; from 20221215
'
' Note: re-used computer instructions mainly from the following:
'	1) Usbong Knowledge Management System (KMS);
'	2) Usbong Game Off 2022;
*/


class Timeoff_Model extends CI_Model
{
	public function addAutoGeneratedPuzzle($param) 
	{			
		$data = array(
					'puzzle_date' => $param['puzzleDate'],
					'puzzle_recorded_steps' => $param['sRecordedSteps']
				);

		$this->db->insert('puzzle', $data);			
		return $this->db->insert_id();
	}	
	
	public function getAutoGeneratedPuzzle($param) 
	{			
		$this->db->select('puzzle_recorded_steps');

		$this->db->where('puzzle_date',$param['puzzleDate']);
		$this->db->order_by('added_datetime_stamp', 'DESC');
		$this->db->limit(1);		
		$query = $this->db->get('puzzle');

//		$row = $query->row();		
		$rowArray = $query->result_array();
		
		if ($rowArray == null) {			
			return false; //edited by Mike, 20190722
		}
		
//		echo report_id: .$rowArray[0]['report_id'];
		
/*		return $row->report_description;
*/
//		return $rowArray[0]['report_description'];

		return $rowArray;
	}	
	
}	
?>
