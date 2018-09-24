<?php
	function checkToken($mysql, $token) {
		$stmt = $mysql->prepare('SELECT id FROM User WHERE token = ?;');
		$stmt->bind_param('s', $token); // 's' specifies the variable type => 'string'
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id);
		if ($stmt->num_rows == 1) {
			$stmt->fetch();
			return $id;
		}
		return -1;
	}

	function validateEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	function isEmailExist($mysql ,$email) {
		$stmt = $mysql->prepare('SELECT id FROM User WHERE email = ?;');
		$stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			return true;
		}
		return false;
	}

	function hashPassword($password) {
		return hash("sha256", $password);
	}
?>
