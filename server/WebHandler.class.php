<?php
	namespace webe\server;
	
	class WebHandler{
		
		public $baseUrl = "/";
		public $path = "";
		public $templatePath = "";
		public $template = "default";
		
		function handleRequest( $url ){
			$u = $this->cleanUrl($url);
			$e = $this->getFileExtension( $u );
			
			if( $e != "" ){
				$this->handleFileRequest( $u, $e );
			}else{
				$this->handlePageRequest( $u );
			}
		}
		
		function cleanUrl( $url ){
			
			$pat = "/".$this->baseUrl."\//";
			
			if( $this->baseUrl != "/" ){
				$url = preg_replace( $pat, "", $url, 1 );
			}
			$ps = explode( "/", $url );
			$a = array();
			foreach( $ps as $p ){
				if( $p != "." && $p != ".."){
					array_push( $a, $p );
				}
			}
			
			return implode( "/", $a );
		}
		
		function getFileExtension( $url ){
			$l1 = $this->getLast( "/", $url );
			$ext = $this->getLast( ".", $l1 );
			if( $ext == $l1 ){
				return "";
			}else{
				return $ext;
			}
		}
		
		function getLast( $delimeter, $subject ){
			$parts = explode( $delimeter, $subject );
			$c = count( $parts );
			return $parts[$c-1];
		}
		
		function handleFileRequest( $url, $extension ){
			$file = $this->path.$url;
			if( !file_exists( $file ) ){
				header( "HTTP/1.1 404 Not Found" );
				echo '<!DOCTYPE html>';
				echo '<html>';
				echo '<head><title>Not Found</title></head>';
				echo '<body><h1>Not Found</h1></body>';
				echo '</html>';
				exit;
			}
			
			header( "Content-Type:".mime_content_type($file));
			readfile( $file );
		}
		
		function handlePageRequest( $url ){
			$pageFile = $this->path.$url;
			$meta = new PageMeta( $pageFile );
			if($meta->get('title')==""){
				$meta->set('title','Welcome');
			}
			$template = $this->templatePath.$this->template."/frame.php";
			$allOk = false;
			
			if( !file_exists( $pageFile ) ){
				header("HTTP/1.1 404 Not Found");
				$meta->set('title','Not Found');
				$meta->set('page_heading','Not Found');
			}else{
				$allOk=true;
			}
			
			if( file_exists( $template ) ){
				include $template;
				exit;
			}
			
			if( $allOk ){
				include $pageFile;
			}
		}
	}
?>
