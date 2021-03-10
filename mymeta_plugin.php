
<?php
/**
 * Plugin Name: My Meta Plugin
 * Plugin URI: https://mymeta_plugin.com/
 * Description: This is the second plugin that I have created and I have created this plugin to do some functions within the metabox.
 * Version: 1.0
 * Author: GopikaChandran
 * Author URI: https://GopikaChandran.com/wordpress-plugins/
 *License: GPLv2 or later
 *Text Domain: mymeta_plugin
 */
?><!DOCTYPE html>
<html><head>
	<link href="style.css" rel="stylesheet">
</head><body>
<?php
defined( 'ABSPATH' ) or die();
class mymeta_plugin{

function __construct(){
add_action("admin_init",array($this,"custom_metabox"));
add_action("save_post",array($this,"save_detail"));
add_filter("the_content",array($this,"callback_fun"));
}
function custom_metabox(){
	add_meta_box("custom_metabox_01","Custom Metabox",array($this,"custom_metabox_field"),"post","normal","low");
}
function custom_metabox_field(){
	global $post;

	$data = get_post_custom($post->ID);
	$val = isset($data['custom_input'])? esc_attr($data['custom_input'][0]): 'no value';

	echo'<input type="text" name="custom_input" id="custom_input" value="'.$val.'"/>';?>
	<label for="custom_input_check">Show</label>

	<?php
	$custom_checkbox=esc_attr(get_post_meta($post->ID,'custom_input_check',true));
	if($custom_checkbox == ""){
		?>
		<input name="custom_input_check" type="checkbox" value="true"/>
		<?php
	}
	else if($custom_checkbox == "true"){
		?>
		<input name="custom_input_check" type="checkbox" value="true" checked/>
		<?php
	}

		//$custom_checkbox_val='checked="checked"';
	//	echo'<input type="checkbox" name="custom_input_check" id="custom_input_check" value="'.$val.'"/>';
		//echo'<label>Show</label>';
}		
function callback_fun($content){
	global $post;


	$custom_checkbox = esc_attr(get_post_meta($post->ID,'custom_input_check',true));
	if($custom_checkbox == "true"){
		$callback_fun = esc_attr(get_post_meta($post->ID,'custom_input',true));
		$post1 = "<div class='display_meta'>$callback_fun</div>";
		return $post1 . $content;
	}
	else{
		return $content;
	}
	

}

function save_detail(){
	global $post;
	if(defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE){
		return $post->ID;
	}
	
	$txtbox = sanitize_text_field($_POST['custom_input']);
	update_post_meta($post->ID,'custom_input',$txtbox);
	$chkbox = sanitize_key($_POST['custom_input_check']);
	update_post_meta($post->ID,'custom_input_check',$chkbox);
	
}

}
$mymeta = new mymeta_plugin();
if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
} ?>
</body></html>
