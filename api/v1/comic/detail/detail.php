<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');
	require_once($publicHtmlPath . 'public_html/api/v1/comic/detail/process.php');

	$response = Response::getUnAuthorizionError();
	if (isset($_SERVER['HTTP_ACCESS_TOKEN']) && checkToken(DBConnection::getConnection(), $_SERVER['HTTP_ACCESS_TOKEN']) != -1) {
		$id = -1;
		if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
			$id = $_GET['id'];
			$response = getComicDetail($id);
		} else {
			$response = Response::get400Error("Id không đúng định dạng.");
		}
	}
	header($response->code);
	echo json_encode($response->value);
?>
