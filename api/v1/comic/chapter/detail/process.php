<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function getChapterPictures($id) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$stmt = $mysql->prepare('SELECT id, position, image FROM Picture WHERE chapter_id = ? ORDER BY position ASC;');
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->bind_result($id, $position, $image);
			$stmt->store_result();
			$pictures = array();
			if ($stmt->num_rows > 0) {
				while ($stmt->fetch()) {
					$picture = new Picture();
					$picture->id = $id;
					$picture->position = $position;
					$picture->image = $image;
					array_push($pictures, $picture);
    			}
   			}
   			$data = new Picture();
   			$data->result = $pictures;
    		$response = new Response(200, $data);
		}
		return $response;
	}

	class Picture {
		function __construct(){

		}
	}
?>
