<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/api/v1/user/login/process.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	$response = Response::getMissingDataError();
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$response = login($_POST['email'], hashPassword($_POST['password']));
	}
	header($response->code);
	echo json_encode($response->value);
?>
