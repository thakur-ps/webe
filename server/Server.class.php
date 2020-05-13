<?php
	namespace webe\server;
	
	class Server{
		
		public $defaultUrl = 'home';
		public $sites = array();
		
		function start(){
			$this->handleRequest();
		}
		
		function handleRequest(){
			$url = $this->getUrl();
			$handler = $this->getHandler( $url );
			$handler->handleRequest( $url );
		}
		
		function getUrl(){
			$url = "";
			if( isset( $_REQUEST['_url'] ) && trim( $_REQUEST['_url'] ) != "" ){
				$url = $_REQUEST['_url'];
			}else{
				$url = $this->defaultUrl;
			}
			
			return $this->removeLeadingSlash($url);
		}
		
		function removeLeadingSlash( $url ){
			if( substr($url,0,1)=='/'){
				return substr($url,1,strlen($url)-1);
			}
			
			return $url;
		}
		
		function setSite( $name, $handler ){
			$this->sites[ $name ] = $handler;
		}
		
		function getHandler( $url ){
			$site = $this->getSite( $url );
			
			if( array_key_exists( $site, $this->sites ) ){
				return $this->sites[ $site ];
			}
			
			$site = "/";
			if( array_key_exists( $site, $this->sites ) ){
				return $this->sites[ $site ];
			}
			
			die( 'no default handler' );
		}
		
		function getSite( $url ){
			$ps = explode("/", $url );
			return $ps[0];
		}
	}
?>
