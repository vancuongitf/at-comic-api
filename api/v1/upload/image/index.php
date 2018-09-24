<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];	
	require_once($publicHtmlPath . 'public_html/model/response/Response.php');
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	$response = null;
	$check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
    	$target_dir = $publicHtmlPath . "uploads/";
    	$fileName =  (microtime(true)*10000) . basename($_FILES["image"]["name"]);
		$target_file = $target_dir . $fileName;
    	move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		$response = new Response(200, new ImageResponse($fileName));        
    } else {
        $response = new Response(678, new ApiError(678, "Chỉ chấp nhận file hình ảnh."));
    }
    header($response->code);
	echo json_encode($response->value);

	class ImageResponse {
		function __construct($imageName) {
			$this->image_name = $imageName;
		}
	}
?>
