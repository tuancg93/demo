<?php 

	
	class ApiController
	{
		public $conn = null;
		public $name = "";
		public function __call($name, $arguments) {

	        if (!method_exists($this, $name)) {
	            throw new ApiException("Method ".$name . ' không tồn tại');
	        }
	        

			
	    }
	    static function getStatusCodeMeeage($status){
			$codes = array(			
				200 => "OK",
				404 => "Not Found"			
			);
			return (isset($codes[$status])) ? $codes[$status] : "";
		}
	    public function __construct()
	    {
	    	include("./config.php");
	    	$this->conn = new mysqli($servername, $username, $password,$database);
			if ($this->conn->connect_error) {
			    die("Connection failed: " . $this->conn->connect_error);
			} 
			mysqli_set_charset($this->conn,"utf8");

			
			

	    }
	    public function checkAuthen(){
	    	$headers = apache_request_headers();
			if(!isset($headers['Authorization']) ){
				throw new ApiException("Cần đăng nhập để thực hiện chức năng này");
			}else{
				if( $_SESSION['token'] != $headers['Authorization']){
					throw new ApiException("Đăng nhập không hợp lệ");
				}
			}


	    }
	    static function sendResponse($status = 200, $body = '', $content_type = "text/html")
		{
			$status_header = "HTTP/1.1 " . $status ." " . self::getStatusCodeMeeage($status);
			header($status_header);
			header('Content-type: ' . $content_type);
			return $body;
		}
		function success($message,$data = null,$status = 200)
		{
			$array_data = array(
				'success' => true,
				'message' => $message,
				'data' => $data
			);
			return $this->sendResponse($status,json_encode($array_data));
		}
		function index(){
			$array_data = array(
				'success' => true,
				'message' => "Đây là trang chủ",
				'data' => null
			);
			return $this->sendResponse(200,json_encode($array_data));
		}
	}