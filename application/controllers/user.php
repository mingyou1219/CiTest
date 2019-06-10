<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
	public function register()
	{
		$this->load->view('register',
			Array("pageTitle" => "發文系統 - 會員註冊")
		);
	}
	public function registering(){
		$account = $this->input->post("account");
		$password= $this->input->post("password");
		$passwordrt= $this->input->post("passwordrt");
		
		if( trim($password) =="" || trim($account) =="" ){
			$this->load->view('register',Array(
				"errorMessage" => "Account or Password shouldn't be empty,please check!" ,
				"account" => $account
			));
			return false;
		}
		if( $password != $passwordrt ){
			//如果不一致，我們讀取 register view，
			//但將 $account 跟錯誤訊息帶入作為處理
			$this->load->view('register',Array(
				"errorMessage" => "Password doesn't match re-type password,please check yout input!" ,
				"account" => $account
			));
			return false;
		}
		$this->load->model("UserModel");
		if($this->UserModel->checkUserExist($account)){
			$this->load->view('register',Array(
				"errorMessage" => "This account is already in used." ,
				"account" => $account
			));
			return false;
		}
		$this->UserModel->insert(trim($account),trim($password));  //完成新增動作
		$this->load->view('register_success',Array(
				"account" => $account,
				"pageTitle" => "發文系統 - 會員註冊成功"
		));		
	}
	public function login(){
		session_start();
		if(isset($_SESSION["user"]) && $_SESSION["user"] != null){ //已經登入的話直接回首頁
			redirect(site_url("/")); //轉回首頁
			return true;
		}
		$this->load->view(
			"login",
			Array( "pageTitle" => "發文系統 - 會員登入"	)
		);
	}
	public function logining(){
		session_start();
		if(isset($_SESSION["user"]) && $_SESSION["user"] != null){ //已經登入的話直接回首頁
			redirect(site_url("/")); //轉回首頁
			return true;
		}
		$account = trim($this->input->post("account"));
		$password = trim($this->input->post("password"));
		$this->load->model("UserModel");
		$user = $this->UserModel->getUser($account,$password);
		if($user == null){
			$this->load->view(
				"login",
				Array( "pageTitle" => "發文系統 - 會員登入"	,
					"account" => $account,
					"errorMessage" => "使用者或密碼錯誤"
				)
			);		
			return true;
		}
		$_SESSION["user"] = $user;
		redirect(site_url("/")); //轉回首頁
	}
	public function logout(){
		session_start();
		session_destroy();
		redirect(site_url("/user/login")); //轉回登入頁
	}
}