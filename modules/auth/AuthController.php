<?php 

	class AuthController extends ApiController
	{
		
		public function login(){
		if (isset($_POST['email'])){
			$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($this->conn,$email);			
			$password = stripslashes($_REQUEST['password']);
			$password = mysqli_real_escape_string($this->conn,$password);
			if(empty($email)){
				throw new ApiException("Email không được để trống");				
			}
			if(empty($password)){
				throw new ApiException("Mật khẩu không được để trống");				
			}

        	$query = "SELECT * FROM `users` WHERE email='$email' and password='".md5($password)."'";
				$result = mysqli_query($this->conn,$query) ;
				$rows = mysqli_num_rows($result);
			        if($rows==1){
			        	$_SESSION['token'] = $token = base64_encode($email);

				    	return static::success("Đăng nhập thành công",['token' => $token]);
			        }else{
			        	throw new ApiException("Sai tài khoản hoặc mật khẩu");
			        }
			
			    }else{
			    	throw new ApiException("Error Processing Request");
			    	
			    }		
		}
		public function logout(){
			$_SESSION['token'] = null;
			session_destroy();
			return static::success("Đăng xuất thành công"); 
		}
	}