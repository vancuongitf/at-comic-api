<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function getComicList($page) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$ignore = ($page - 1) * 30;
			$stmt = $mysql->prepare('SELECT id, name, description, author, view_count, getLikeCount(id) as like_count,image FROM Comic LIMIT ?, 30;');
			$stmt->bind_param('i', $ignore);
			$stmt->execute();
			$stmt->bind_result($id, $name, $description, $author, $view_count, $like_count, $image);
			$comics = array();
			while ($stmt->fetch()) {
				$comic = new Comic();
				$comic->id = $id;
				$comic->name = $name;
				$comic->description = $description;
				$comic->author = $author;
				$comic->view_count = $view_count;
				$comic->like_count = $like_count;
				$comic->image = $image;
				array_push($comics, $comic);
    		}
    		$stmt = $mysql->prepare('SELECT COUNT(id) as count FROM Comic;');
    		$stmt->execute();
			$stmt->bind_result($count);
			$nextPageFlag = false;
			while ($stmt->fetch()) {
				if ($count > $page * 30) {
					$nextPageFlag = true;
				}	
    		}
			$data = new Comic();
			$data->next_page_flag = $nextPageFlag;
			$data->result = $comics;
    		$response = new Response(200, $data);
		}
		return $response;
	}

	class Comic {
		function __construct(){

		}
	}
?>
