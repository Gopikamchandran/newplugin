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


add_action("admin_init","custom_metabox");
function custom_metabox(){
	add_meta_box("custom_metabox_01","Custom Metabox","custom_metabox_field","post","normal","low");

}
function custom_metabox_field(){
	global $post;

	$data = get_post_custom($post->ID);
	$val = isset($data['custom_input'])? esc_attr($data['custom_input'][0]): 'no value';

	echo'<input type="text" name="custom_input" id="custom_input" value="'.$val.'"/>';
	
	$custom_checkbox=get_post_meta($post->ID,'custom_input_check',true);
	if($custom_checkbox == 'yes')
		$custom_checkbox_val='checked="checked"';
		echo'<input type="checkbox" name="custom_input_check" id="custom_input_check" value="'.$val.'"/>';
		echo'<label>Show</label>';
}		
function callback_fun()
{
	global $post;
/*	
	$custom_checkbox=get_post_meta($post->ID,'custom_input_check',true);
	if($custom_checkbox == 'yes')
		$custom_checkbox_val='checked="checked"';*/
	$data = get_post_custom($post->ID);
	$val = isset($data['custom_input_check'])? esc_attr($data['custom_input_check'][0]): 'no value';

	echo'<input type="text" name="custom_input" id="custom_input" value="'.$val.'"/>';

}

function save_detail(){
	global $post;
	if(defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE){
		return $post->ID;
	}
	//$chk = isset( $_POST['custom_input_check'] )  ? 'on' : 'off';
    //update_post_meta( $post->ID, 'custom_input_check', $chk );
	update_post_meta($post->ID,"custom_input",$_POST["custom_input"]);
	update_post_meta($post->ID,"custom_input_check",$_POST["custom_input_check"]);
	//echo $_POST["custom_input_check"];
}

add_action("save_post","save_detail");
add_filter('the_content','callback_fun');


?>