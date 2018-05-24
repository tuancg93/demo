<?php 
$rules = array( 
    'auth'   => "/auth/([\w\-]+)",    
    'user'     => "/user/(?'id'\d+)",              
);
$allow_methods = ['login'];
$mapRequest = array(
	'PUT' => 'update',
	'GET' => 'detail'
);
$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
$uri = urldecode( $uri );
foreach ( $rules as $action => $rule ) {
    if ( preg_match( '~^'.$rule.'$~i', $uri, $params ) ) {

        include( $modules ."/".$action."/".ucwords($action) .$suffixes. '.php' );
        $className = ucwords($action).$suffixes;

        $method = $params[1];
        if(is_numeric($method)){        
        	$method = isset($mapRequest[$_SERVER['REQUEST_METHOD']])? $mapRequest[$_SERVER['REQUEST_METHOD']] : "index";

        }
        try{        	
        	$classes = new $className();
        	if(!in_array($method, $allow_methods)){        		
        		$classes->checkAuthen();        
        	}
        	echo $classes->$method();
        }catch(Exception $e){
        	echo ApiController::sendResponse(404,json_encode(['success'=>false,'message'=>$e->getMessage()]));
        }
       
        exit();
    }
    	
   
}
echo "Đường dẫn {$uri} không tồn tại";
exit();
?>