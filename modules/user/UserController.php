<?php 

	class UserController extends ApiController
	{
		
		public function detail(){
		if (isset($_GET['id'])){
			$id = stripslashes($_REQUEST['id']);
			$id = mysqli_real_escape_string($this->conn,$id);			
        	$query = "SELECT * FROM `users` WHERE id='$id'";
				$result = mysqli_query($this->conn,$query) ;
				$rows = mysqli_fetch_assoc($result);
			        if($rows){
				    	return static::success("Tìm kiếm thành công",$rows);
			        }else{
			        	throw new ApiException("Không tìm thấy người dùng");
			        }
			
			}else{
			    	throw new ApiException("Không tìm thấy người dùng");
			    	
			}		
		}
		public function update(){
			if (isset($_GET['id'])){
				$id = stripslashes($_REQUEST['id']);
				$id = mysqli_real_escape_string($this->conn,$id);			
	        	$query = "SELECT * FROM `users` WHERE id='$id'";
					$result = mysqli_query($this->conn,$query) ;
					$rows = mysqli_fetch_assoc($result);
				        if($rows){
				        	$array_params = ['name','address','tel','password'];
							parse_str(file_get_contents("php://input"),$data);
							
							foreach ($array_params as $key => $value) {

									if(empty($data[$value])){
										throw new ApiException("Field $value không được để trống");
										exit;
									}
							}
				        	$name = stripslashes($data['name']);
							$name = mysqli_real_escape_string($this->conn,$name);	

							$address = stripslashes($data['address']);
							$address = mysqli_real_escape_string($this->conn,$address);	

							$tel = stripslashes($data['tel']);
							$tel = mysqli_real_escape_string($this->conn,$tel);	

							$password = stripslashes($data['password']);
							$password = mysqli_real_escape_string($this->conn,$password);	


							$sql = "UPDATE users SET name = '" . $name . "' ,
													address = '" . $address . "' ,
													tel = '" . $tel . "' ,
													password = '" . md5($password) . "' 
													WHERE id = ".$_GET["id"];
							if ($this->conn->query($sql) === TRUE) {
							    return static::success("Tìm kiếm thành công",$data);
							} else {
							    throw new ApiException("Không thực hiện được chức năng");
							}

				        }else{
				        	throw new ApiException("Không tìm thấy người dùng");
				        }
				
				}else{
				    	throw new ApiException("Không tìm thấy người dùng");
				    	
				}		
		}
	}