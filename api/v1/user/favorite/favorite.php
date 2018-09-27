<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');
	require_once($publicHtmlPath . 'public_html/api/v1/comic/home/process.php');

	$response = Response::getUnAuthorizionError();
	if (isset($_SERVER['HTTP_ACCESS_TOKEN'])) {
		$userId = checkToken(DBConnection::getConnection(), $_SERVER['HTTP_ACCESS_TOKEN']);
		if ($userId != -1) {
			$page = 1;
			if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
				$page = $_GET['page'];
			}
			if ($page < 1) {
				$page = 1;
			}
			$response = getComicList($userId, $page, true);	
		}
	}
	header($response->code);
	echo json_encode($response->value);
?>
