<?php
	$publicHtmlPath = explode( "public_html", getcwd())[0];
	require_once($publicHtmlPath . 'public_html/model/response/ApiError.php');
	require_once($publicHtmlPath . 'public_html/model/response/MessageResponse.php');
	class Response {
		function __construct($code, $data) {
			switch ($code) {
				case 200:
					$this->code = "HTTP/1.1 " . $code . " OK";
					break;
				
				case 400:
					$this->code = "HTTP/1.1 " . $code . " BAD REQUEST";
					break;

				case 401:
					$this->code = "HTTP/1.1 " . $code . " UNAUTHORIZED";
					break;
				
				default:
					$this->code = "HTTP/1.1 " . $code . " API ERROR";
					break;
			}
			$this->value = $data;
		}

		static function getSQLConnectionError() {
			return new Response(500, new ApiError(500, "Không thể kết nối đến cơ sở dữ liệu của serve."));
		}
		static function getAuthorizationError() {
			return new Response(401, new ApiError(401, "Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại để tiếp tục."));
		}
		static function getNormalError() {
			return new Response(678, new ApiError(678, "Xãy ra lỗi. Vui lòng thử lại sau."));
		}
		static function getMessageResponseWithMessage($message) {
			return new Response(200, new MessageResponse($message));
		}
		static function getNormalErrorWithMessage($message) {
			return new Response(678, new ApiError(678, $message));
		}
		static function getMissingDataError() {
			return new Response(678, new ApiError(678, "Thiếu dữ liệu."));
		}

		static function get400Error($message) {
			return new Response(400, new ApiError(400, $message));
		}

		static function getUnAuthorizionError() {
			return new Response(401, new ApiError(401, "Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại để tiếp tục."));
		}
	}
?>
