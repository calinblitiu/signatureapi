<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('company_model');
    	$this->load->model('signature_model');    
    }

	public function login(){
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
        $usertype   = $this->input->post('usertype');

        $com_id = -1;
        if ($usertype == 'driver') {
            $companycode = $this->input->post('companycode');

            if ($companycode == "") {
                $return_val['code'] = 'error';
                $return_val['msg'] = 'Request Error!';
                echo json_encode($return_val);
                exit();
            }

            $com_id = $companycode - 8000;
            $company = $this->company_model->getCompanyWhere(array(
                'com_id' => $com_id
            ));

            if (count($company) == 0) {
                $return_val['code'] = 'error';
                $return_val['msg'] = 'Please Input correct company code';
                echo json_encode($return_val);
                exit();
            }
        }
		
		if ($fullname == "" || $email == "" || $password == "" || $usertype == "") {
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
            exit();               
        } else {

            if ($usertype == 'admin') {
                $save_data['third_login_email'] = '';
                $save_data['third_login_password'] = '';
                $save_data['third_account_id'] = '';
                $save_data['nlauth_role'] = '';
                $com_id = $this->company_model->addCompany($save_data);    
            }
            

        	$user_id = $this->user_model->addUser(array(
        		'full_name'		     => $fullname,
        		'login_email'	     => $email,
                'type'               => $usertype,
                'company_profile_id' => $com_id,
        		'password' 		     => password_hash($password, PASSWORD_DEFAULT)
        	));


        	$this->login();
        }	
	}

	public function savethirdpartyconf() {
		$userid = $this->input->post('userId');
		$third_email = $this->input->post('email');
		$third_password = $this->input->post('password');
		$third_account_id = $this->input->post('accountId');
		$nlauth_role = $this->input->post('role');
		if ($userid == "" || $third_email == "" || $third_password == "" || $third_account_id == "" || $nlauth_role == "") {
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
        	$save_data['third_account_id'] = $third_account_id;
        	$save_data['nlauth_role'] = $nlauth_role;
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
        	$save_data['third_account_id'] = $third_account_id;
        	$save_data['nlauth_role'] = $nlauth_role;
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

	public function savesig() {
		$com_id = $this->input->post('comId');
		$order_id = $this->input->post('orderId');
		$url = $this->input->post('url');
		
		if ($com_id == "" || $order_id == "" || $url == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

        $users = $this->user_model->getUserWhere(array(
            'type' => 'admin', 
            'company_profile_id' => $com_id
        ));

        if (count($users) == 0)
        {
            $return_val['code'] = 'error';
            $return_val['msg'] = 'There is not admin user.';
            echo json_encode($return_val);
            exit();   
        }

		$data["com_id"] = $com_id;
		$data["order_id"] = $order_id;
		$data["image_url"] = $url;
        $data['admin_id'] = $users[0]->id;
		$sig_id = $this->signature_model->addSignature($data);
		if ($sig_id > 0) {
			$return_val['code'] = 'success';
			$data['sig_id'] = $sig_id;
            $return_val["msg"] = $data;
            echo json_encode($return_val);
            exit();
		}
	}

	public function do_upload(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $config['max_width']            = 10240;
        $config['max_height']           = 7680;
        $config['encrypt_name'] 		= TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('sig_image'))
        {
            $error = array('error' => $this->upload->display_errors());
            $return_val['code'] = 'error';
			$return_val['msg'] = strip_tags($error["error"]);
        	echo json_encode($return_val);
        	exit();
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $return_val['code'] = 'success';
            $return_val["msg"] = $data["upload_data"];
            echo json_encode($return_val);
            exit();
        }
    }

    public function loadsigs(){
    	$com_id = $this->input->post('comId');
    	if ($com_id == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

		$sigs = $this->signature_model->getSignaturesWhere(array(
			'com_id' => $com_id
		));

		if (count($sigs) == 0) {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Please configure your account with NetSuite Bundle';
        	echo json_encode($return_val);
        	exit();
		}

		$return_val['code'] = 'success';
    	$return_val['msg'] = $sigs;
    	echo json_encode($return_val);
    	exit();
    }
}
