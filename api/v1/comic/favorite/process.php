<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function star($userId, $comicId) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$status = new Status();
			$stmt = $mysql->prepare("INSERT INTO Favorite (user_id, comic_id) VALUES (?, ?);");
			$stmt->bind_param("ii", $userId, $comicId);
	 		$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$status->success = true;
			} else {
				$stmt = $mysql->prepare("SELECT * FROM Favorite WHERE user_id = ? AND comic_id = ?");
				$stmt->bind_param("ii", $userId, $comicId);
	 			$stmt->execute();
	 			$stmt->store_result();
	 			if ($stmt->num_rows == 1) {
	 				$status->success = true;
	 			} else {
	 				$status->success = false;
	 			}
			}		
			$response = new Response(200, $status);
		}
		return $response;
	}

	function unstar($userId, $comicId) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$status = new Status();
			$stmt = $mysql->prepare("DELETE FROM Favorite WHERE user_id = ? AND comic_id = ?;");
			$stmt->bind_param("ii", $userId, $comicId);
	 		$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$status->success = true;
			} else {
				$stmt = $mysql->prepare("SELECT * FROM Favorite WHERE user_id = ? AND comic_id = ?");
				$stmt->bind_param("ii", $userId, $comicId);
	 			$stmt->execute();
	 			$stmt->store_result();
	 			if ($stmt->num_rows == 0) {
	 				$status->success = true;
	 			} else {
	 				$status->success = false;
	 			}
			}		
			$response = new Response(200, $status);
		}
		return $response;
	}

	class Status {
		function __construct() {

		}
	}
?>
