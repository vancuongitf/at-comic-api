<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');
	require_once($publicHtmlPath . 'public_html/api/v1/comic/favorite/process.php');

	$response = Response::getUnAuthorizionError();
	if (isset($_SERVER['HTTP_ACCESS_TOKEN'])) {
		$id = checkToken(DBConnection::getConnection(), $_SERVER['HTTP_ACCESS_TOKEN']);
		if ($id != -1) {
			if (isset($_POST['comic_id']) && filter_var($_POST['comic_id'], FILTER_VALIDATE_INT)) {
				$response = star($id, $_POST['comic_id']);
			} else {
				$response = Response::get400Error("Comic id thiếu hoặc sai định dạng.");
			}
		}
	}
	header($response->code);
	echo json_encode($response->value);
?>
