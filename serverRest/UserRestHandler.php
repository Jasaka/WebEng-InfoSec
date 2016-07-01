<?php

require_once("SimpleRest.php");
require_once("User.php");
		
class UserRestHandler extends SimpleRest {
	
	


	//delete user by user_id ==> dynamisch
	public function deleteUserDb($user_id)
	{
		$user = new User();
		$rawData = $user->deleteUserDb($user_id);

		$this->response($rawData);
	}

	//get user by user_id ==> dynamisch
	public function getUserDb($identity)
	{
		$user = new User();
		$rawData = $user->getUserDb($identity);

		$this->response($rawData);
	}


	//get user pubkey by user identity ==> dynamisch
	public function getUserDbIdent($user_identityrec)
	{
		$user = new User();
		$rawData = $user->getUserDbIdent($user_identityrec);

		$this->response($rawData);
	}







	//encode data to text/Html
	public function encodeHtml($responseData) {

		$htmlResponse = "<table border='1'>";
		foreach($responseData as $key=>$value) {
    			$htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
		}
		$htmlResponse .= "</table>";
		return $htmlResponse;
	}



	//encode data to application/json
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}



	//encode data to application/xml
	public function encodeXml($responseData) {
		// creating object of SimpleXMLElement
		$xml = new SimpleXMLElement('<?xml version="1.0"?><user></user>');
		foreach($responseData as $key=>$value) {
			$xml->addChild($key, $value);
		}

		return $xml->asXML();
	}

	//response the request
	public function response($rawData)
	{
		if (empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No user found!');
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this->setHttpHeaders($requestContentType, $statusCode);

		if (strpos($requestContentType, 'application/json') !== false) {
			$response = $this->encodeJson($rawData);
			echo $response;
		} else if (strpos($requestContentType, 'text/html') !== false) {
			$response = $this->encodeHtml($rawData);
			echo $response;
		} else if (strpos($requestContentType, 'application/xml') !== false) {
			$response = $this->encodeXml($rawData);
			echo $response;
		}

	}





}
?>