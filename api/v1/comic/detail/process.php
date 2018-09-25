<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/database/DBConnection.php');
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/util/Util.php');

	function getComicDetail($userId, $id) {
		$mysql = DBConnection::getConnection();
		$response = Response::getSQLConnectionError();
		if ($mysql) {
			$stmt = $mysql->prepare('SELECT id, name, description, author, view_count, getLikeFlag(?, id), getLikeCount(id) as like_count, image FROM Comic WHERE id = ?;');
			$stmt->bind_param('ii', $userId, $id);
			$stmt->execute();
			$stmt->bind_result($id, $name, $description, $author, $view_count, $like_flag, $like_count, $image);
			$stmt->store_result();
			$comic = new Comic();
			if ($stmt->num_rows == 1) {
				while ($stmt->fetch()) {
				$comic->id = $id;
				$comic->name = $name;
				$comic->description = $description;
				$comic->author = $author;
				$comic->view_count = $view_count;
				$comic->like_flag = $like_flag == 1;
				$comic->like_count = $like_count;
				$comic->image = $image;
    			}
    			$response = new Response(200, $comic);
			} else {
    			$response = Response::get400Error("Truyện không tồn tại.");
			}
		}
		return $response;
	}

	class Comic {
		function __construct(){

		}
	}
?>
