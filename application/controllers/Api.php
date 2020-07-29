<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Api extends CI_Controller {

function __construct(){
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}
	//                 >>    API ADMIN     <<
	public function login(){
			$username = $this->input->post('username');
			$pass= $this->input->post('password');
			$time = date('Y-m-d H:i:s');

			$this->db->where('username',$username);
			$this->db->where('password',md5($pass));

			$status = $this->db->get('user');

			if($status -> num_rows() > 0){

				$simpan['loginTime'] = $time ;
				$simpan['status'] =0 ;
				$id = $status->row()->userId ;

				$this->db->where('userId',$id);

				$check = $this->db->update('user',$simpan);
				
				if($check){
					$data['status'] = true ;
					$data['pesan'] = 'ok, success';
					$data['data'] = $status->result();
				}
				else{
					$data['status'] = false ;
					$data['pesan'] = 'error, try again';
				}
			}
				else{
					$data['status'] = false ;
					$data['pesan'] = $username;
				}

			echo json_encode($data);

		}
		
		public function pintu(){
			$userId = $this->input->post('userId');
			$timeBuka = date('Y-m-d H:i:s');

			// $this->db->where('status',0);
			$this->db->where('userId',$userId);
			$getUser = $this->db->get('user');

			if($getUser -> num_rows() > 0){
				$statusPintu = $getUser->row()->status;
				$username = $getUser->row()->username;
				if($statusPintu == 0){
					$simpan['userId']=$userId;
					$simpan['username']=$username;
					$simpan['idPintu']=1;
					$simpan['status']=1;
					$simpan['waktuBuka']=$timeBuka;
					$statusInsert = $this->db->insert('aktivitasPintu',$simpan);
					if($statusInsert){
						$this->db->where('idPintu', 1);
						$getPintu = $this->db->get('pintu');
						if ($getPintu -> num_rows() > 0) {
							$data['status'] = true ;
							$data['pesan'] = 'ok, success';
							$data['data'] = $getPintu->result();
						}
						else{
							$data['status'] = false ;
							$data['pesan'] = 'error, try again';
						
						}
						$updateStatus['status'] = 1 ;
						$userId = $getUser->row()->userId ;
						$this->db->where('userId',$userId);
						$check = $this->db->update('user',$updateStatus);
						if($check){
							$data['status'] = true ;
							$data['pesan'] = 'ok, success';
						}else{
							$data['status'] = false ;
							$data['pesan'] = 'try again';
						}
						
					}else{
						$data['status'] = false ;
						$data['pesan'] = 'try again';
					}
				}else{
					$this->db->where('idPintu', 1);
						$getPintu = $this->db->get('pintu');
						if ($getPintu -> num_rows() > 0) {
							$data['status'] = true ;
							$data['pesan'] = 'ok, success';
							$data['data'] = $getPintu->result();
						}
						else{
							$data['status'] = false ;
							$data['pesan'] = 'error, try again';
						
						}
					$data['status'] = false ;
					$data['pesan'] = 'Anda Sudah Melakukan Insert';
				}
			}else{
				$data['status'] = false ;
				$data['pesan'] = 'try again';
			}
			echo json_encode($data);

		}

		public function update_pintu(){
			$idPintu = $this->input->post('idPintu');
			$updatePintu = $this->input->post('updatePintu');

			$updateStatus['status'] = $updatePintu ;
			$this->db->where('idPintu',$idPintu);
			$check = $this->db->update('pintu',$updateStatus);
			if($check){
				$data['status'] = true ;
				$data['pesan'] = 'ok, success';
			}else{
				$data['status'] = false ;
				$data['pesan'] = 'try again';
			}
			echo json_encode($data);

		}

		public function get_history(){
			$this->db->order_by('waktuBuka', 'DESC');
			$getHistory = $this->db->get('aktivitasPintu');
			if($getHistory -> num_rows()> 0 ){
				$data['data']= $getHistory ->result();
				$data['status'] = true ;
				$data['pesan'] = 'finded';
			}
			else{
					$data['status'] = false ;
					$data['pesan'] = 'error, data not find';
			}

			echo json_encode($data);
		}

		public function kunciPintu(){
			$statusPintu = $this->input->post('statusPintu');
			$ststusKunci = $this->input->post('statusKunci');

			$simpan['statusPintu'] = $statusPintu;
			$simpan['statusKunci'] = $ststusKunci;
			$insert = $this->db->insert('kunciPintu', $simpan);

			if($insert){
				$data['status'] = true ;
				$data['pesan'] = 'ok, success';
			}else{
				$data['status'] = false ;
				$data['pesan'] = 'try again';
			}
			echo json_encode($data);
		}

		public function getAktivitas(){

			$this->db->order_by('date', 'DESC');
			$getHistory = $this->db->get('kunciPintu');
			if($getHistory -> num_rows()> 0 ){
				$data['data']= $getHistory ->result();
				$data['status'] = true ;
				$data['pesan'] = 'finded';
			}
			else{
					$data['status'] = false ;
					$data['pesan'] = 'error, data not find';
			}

			echo json_encode($data);
		}
		

	}
