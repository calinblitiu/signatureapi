<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('company_model');      
    }

	public function login()
	{
		$email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($email == "" || $password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

	 	$result = $this->user_model->login($email, $password);
	 	if (count($result) == 0) {
	 		$return_val['code'] = 'error';
        	$return_val['msg'] = 'Invailed User Email or Password.';
        	echo json_encode($return_val);
        	exit();	
	 	}
	 	
	 	$return_val['code'] = 'success';
        $return_val['msg'] = $result[0]; 
	 	echo json_encode($return_val);
	}

	public function signup() {

		$fullname 	= $this->input->post('fullname');
		$email    	= $this->input->post('email');
        $password 	= $this->input->post('password');
		
		if ($fullname == "" || $email == "" || $password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

        $users = $this->user_model->getUserWhere(array(
        	'login_email' => $email
        ));

        if (count($users) > 0) {
        	$return_val['code'] = 'error';
        	$return_val['msg'] = 'User is already exited! Please try again with another email.';
        	echo json_encode($return_val);
        } else {
        	$user_id = $this->user_model->addUser(array(
        		'full_name'		=> $fullname,
        		'login_email'	=> $email,
        		'password' 		=> password_hash($password, PASSWORD_DEFAULT)
        	));

        	$this->login();
        }	
	}

	public function savethirdpartyconf() {
		$userid = $this->input->post('userId');
		$third_email = $this->input->post('email');
		$third_password = $this->input->post('password');
		if ($userid == "" || $third_email == "" || $third_password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

		$users = $this->user_model->getUserWhere(array(
        	'id' => $userid
        ));

        if (count($users) == 0){
        	$return_val['code'] = 'error';
        	$return_val['msg'] = 'User is not exist.';
        	echo json_encode($return_val);
        	exit();
        }

        $user = $users[0];
        if ($user->company_profile_id == '-1') {
        	$save_data['third_login_email'] = $third_email;
        	$save_data['third_login_password'] = $third_password;
        	$comp_id = $this->company_model->addCompany($save_data);
        	$this->user_model->updateUser($userid, array(
        		"company_profile_id"  => $comp_id
        	));
        	
        	$comps = $this->company_model->getCompanyWhere(array(
        		"com_id"  => $comp_id
        	));

			$return_val['code'] = 'success';
        	$return_val['msg'] = $comps[0];
        	echo json_encode($return_val);
        	exit();
        } else {
        	$save_data['third_login_email'] = $third_email;
        	$save_data['third_login_password'] = $third_password;
        	$this->company_model->updateCompany($user->company_profile_id, $save_data);

        	$comps = $this->company_model->getCompanyWhere(array(
        		"com_id"  => $user->company_profile_id
        	));

			$return_val['code'] = 'success';
        	$return_val['msg'] = $comps[0];
        	echo json_encode($return_val);
        	exit();
        }
	}

	public function loadthirdpartyconf() {
		$userid = $this->input->post('userId');
		if ($userid == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

		$users = $this->user_model->getUserWhere(array(
        	'id' => $userid
        ));

        if (count($users) == 0){
        	$return_val['code'] = 'error';
        	$return_val['msg'] = 'User is not exist.';
        	echo json_encode($return_val);
        	exit();
        }

        $user = $users[0];
     	if ($user->company_profile_id == '-1') {
     		$return_val['code'] = 'error';
        	$return_val['msg'] = 'Company Informantion is not exist.';
        	echo json_encode($return_val);
        	exit();
     	}

        $comps = $this->company_model->getCompanyWhere(array(
    		"com_id"  => $user->company_profile_id
    	));

		$return_val['code'] = 'success';
    	$return_val['msg'] = $comps[0];
    	echo json_encode($return_val);
    	exit();
	}
}
