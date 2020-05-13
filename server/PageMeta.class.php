<?php
	namespace webe\server;
	
	class PageMeta{
	
		protected $data = array();
		
		function __construct( $pageFile ){
			$file = $pageFile.".meta";
			if( file_exists( $file ) ){
				include $file;
				if( isset( $metadata ) && is_array( $metadata ) ){
					$this->data = $metadata;
				}
			}
		}
		
		function set( $key, $value ){
			$this->data[ $key ] = $value;
		}
		
		function get( $key ){
			if( array_key_exists( $key, $this->data ) ){
				return $this->data[ $key ];
			}
			
			return "";
		}
	} 
?>
