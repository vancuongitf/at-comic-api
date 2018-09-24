<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function getComicChapters($id, $page) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$ignore = ($page - 1) * 50;
			$stmt = $mysql->prepare('SELECT COUNT(id) as count FROM Chapter WHERE comic_id = ?;');
    		$stmt->execute();
			$stmt->bind_result($count);
			$nextPageFlag = false;
			while ($stmt->fetch()) {
				if ($count > $page * 50) {
					$nextPageFlag = true;
				}	
    		}
			$stmt = $mysql->prepare('SELECT id, comic_id, name, position, viewcount, image FROM Chapter WHERE comic_id = ? ORDER BY position ASC LIMIT ?, 50;');
			$stmt->bind_param('ii', $id, $ignore);
			$stmt->execute();
			$stmt->bind_result($id, $comic_id, $name, $position, $view_count, $image);
			$stmt->store_result();
			$chapters = array();
			if ($stmt->num_rows > 0) {
				while ($stmt->fetch()) {
					$chapter = new Chapter();
					$chapter->id = $id;
					$chapter->comic_id = $comic_id;
					$chapter->name = $name;
					$chapter->position = $position;
					$chapter->viewcount = $view_count;
					$chapter->image = $image;
					array_push($chapters, $chapter);
    			}
   			}
   			$data = new Chapter();
   			$data->next_page_flag = $nextPageFlag;
   			$data->result = $chapters;
    		$response = new Response(200, $data);
		}
		return $response;
	}

	class Chapter {
		function __construct(){

		}
	}
?>
