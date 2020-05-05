<?php
	spl_autoload_register( function( $class_name ) {
    	$p = explode( '\\', $class_name );
    	$file = SYSTEM_PATH.implode( '/', $p );
    	$classFile =$file.'.class.php';
    	$traitFile = $file.'.trait.php';
    	
    	if( file_exists( $classFile ) ){
    		include $classFile;
    	}else{
    		echo $classFile.' not found';
    	}
    	
    	if( file_exists( $traitFile ) ){
    		include $traitFile;
    	}
	});
?>
