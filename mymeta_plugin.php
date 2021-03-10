
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

defined( 'ABSPATH' ) or die();
class mymeta_plugin{

function __construct(){
add_action("admin_init",array($this,"custom_metabox"));
add_action("save_post",array($this,"save_detail"));
add_action('wp_enqueue_scripts',array($this,'use_style'));
add_filter("the_content",array($this,"display_fun"));
}//function to the hook functions
function custom_metabox(){
	add_meta_box("custom_metabox_01","Custom Metabox",array($this,"custom_metabox_field"),"post","normal","low");
}//function to add a meta box
function custom_metabox_field(){
	global $post;

	$data = get_post_custom($post->ID);
	$val = isset($data['textbox'])? esc_attr($data['textbox'][0]): 'no value';

	echo'<input type="text" name="textbox" id="textbox" value="'.$val.'"/>';?>
	<label for="checkbox_value">Show</label>

	<?php
	$custom_checkbox=esc_attr(get_post_meta($post->ID,'checkbox_value',true));
	if($custom_checkbox == ""){
		?>
		<input name="checkbox_value" type="checkbox" value="true"/>
		<?php
	}
	else if($custom_checkbox == "true"){
		?>
		<input name="checkbox_value" type="checkbox" value="true" checked/>
		<?php
	}
		
}	// function to work in backend where we accept input	
function display_fun($content){
	global $post;


	$custom_checkbox = esc_attr(get_post_meta($post->ID,'checkbox_value',true));
	if($custom_checkbox == "true"){
		$callback_fun = esc_attr(get_post_meta($post->ID,'textbox',true));
		$post1 = "<div class='display_meta'>$callback_fun</div>";
		return $post1 . $content;
	}
	else{
		return $content;
	}
	

}//function to display the content in  frontend

function use_style() {
    wp_register_style( 'namespace', 'http://localhost/wordpress_t4/wp-content/plugins/mymeta_plugin/style.css' );
    wp_enqueue_style( 'namespace' );
    //wp_enqueue_script( 'namespaceformyscript', 'http://locationofscript.com/myscript.js', array( 'jquery' ) );
}//function to attach css and js file
function save_detail(){
	global $post;
	if(defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE){
		return $post->ID;
	}
	
	$txtbox = sanitize_text_field($_POST['textbox']);
	update_post_meta($post->ID,'textbox',$txtbox);
	$chkbox = sanitize_key($_POST['checkbox_value']);
	update_post_meta($post->ID,'checkbox_value',$chkbox);
	
}//where the data are saved to the database

}
$mymeta = new mymeta_plugin();//created an object variable to call the class
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

