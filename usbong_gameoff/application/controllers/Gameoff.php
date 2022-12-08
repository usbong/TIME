<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//edited by Mike, 20220425
//class Canvas
//edited by Mike, 20221121
//class FlashStage extends CI_Controller { //MY_Controller {
class Gameoff extends CI_Controller { //MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
//	public function search()//$param)
	public function index()
	{
		//added by Mike, 20220416
/*
		if(!isset($_SESSION)) 
		{ 
			session_start();
		}
*/
		session_destroy();
		session_start();
		
/*	//removed by Mike, 20221121
		//TO-DO: -update: this for >= PLAYER COUNT
		$data['sInputAsButtonText0']="NONE";
		$data['sInputAsButtonText1']="NONE";
		$data['iHitPlayerId']="-1";
*/

/*
		//from application/core/MY_Controller
		$this::initStyle();
		$this::initHeaderWith($data);
		//--------------------------------------------
		$this->load->view('templates/right_side_bar');
		//--------------------------------------------
*/

		date_default_timezone_set('Asia/Hong_Kong');
		$dateTimeStamp = date('Y/m/d H:i:s');

		//example: website address: http://localhost/usbong_igo/index.php/stage/

		//edited by Mike, 20221121	
		$data="";		
		//$this->load->view('flashStage', $data);
		$this->load->view('gameoff', $data);

/*		
		//--------------------------------------------
		$this->load->view('templates/footer');	
*/		
	}
}
