<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/model/response/MessageResponse.php');

	function signUp($email, $password, $image) {
		$mysql = DBConnection::getConnection();
		$response = null;
		if ($mysql != null) {
			if (validateEmail($email)) {
				if (!isEmailExist($mysql, $email)) {
					$stmt = $mysql->prepare("INSERT INTO User (email, password, avatar) VALUES (?, ?, ?);");
					$stmt->bind_param("sss", $email, $password, $image);
	 				$stmt->execute();
					if ($stmt->affected_rows == 1) {
						$response = Response::getMessageResponseWithMessage("Tạo tài khoản thành công.");
					} else {
						$response = Response::getNormalError();
					}
					$stmt->close();
				} else {
					$response = Response::get400Error("Email đã đăng ký trên hệ thống.");
				}
			} else {
				$response = Response::get400Error("Email không đúng định dạng.");
			}
		} else {
			$response =  Response::getSQLConnectionError();
		}
		return $response;
	}
?>
