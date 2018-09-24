<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function login($email, $password) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			if (validateEmail($email)) {
				$token = hashPassword($email . microtime(true));
				$stmt = $mysql->prepare("UPDATE User SET token = ? WHERE email = ? AND password = ? ;");
				$stmt->bind_param("sss", $token, $email, $password);
	 			$stmt->execute();
				if ($stmt->affected_rows == 1) {
					$response = new Response(200, new Token($token));
				} else {
					$response = Response::getMessageResponseWithMessage("Mật khẩu hoặc tài khoản không chính xác.");
				}
				$stmt->close();
			} else {
				$response = Response::getNormalErrorWithMessage("Email không đúng định dạng.");
			}	
		}
		return $response;
	}

	class Token {
		function __construct($token) {
			$this->access_token = $token;
		}
	}
?>
