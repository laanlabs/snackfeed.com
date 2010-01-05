<?


function render_partial( $name , $options ) {
	
	global $partial_options;
	$partial_options = $options;
	include TEMPLATES."/_inc/partials/".$name.".php";
	
}

?>