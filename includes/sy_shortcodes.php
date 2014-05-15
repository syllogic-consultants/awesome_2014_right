<?php
//Series of shortcodes created for accessing various meta fields from wordpress

// [syUserName ID="id" email="" ]
function syUserName_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id',$ID);
	if(is_null($user)) return "No User found";
	return "{$user->first_name} {$user->last_name}";
}
add_shortcode( 'syUserName', 'syUserName_shortcode' );

// [syUserBio ID="id" email="" ]
function syUserBio_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id',$ID);
	if(is_null($user)) return "No User found";
	return "<p>{$user->description}</p>";
}
add_shortcode( 'syUserBio', 'syUserBio_shortcode' );

// [syUserTitle ID="id" email="" ]
function syUserTitle_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id',$ID);
	if(is_null($user)) return "No User found";
	$title = get_user_meta($user->ID, 'title');
	return "<h6>{$title}</h6>";
}
add_shortcode( 'syUserTitle', 'syUserTitle_shortcode' );

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Extra profile information", "blank"); ?></h3>

<table class="form-table">
<tr>
<th><label for="title"><?php _e("Position Title"); ?></label></th>
<td>
<input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your title."); ?></span>
</td>
</tr>
</table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
  update_user_meta( $user_id, 'title', $_POST['title'] );
}
// [syGoogleSpreadsheet link="" ]
function syGoogleSpreadsheet_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'link' => ''
	), $atts ) );
	$imgPath = get_stylesheet_directory_uri()."/includes/images";
	$css = "background-image: url({$imgPath}/google-docs-sprite.png);";
	$css .= "background-position:-12em 0;";
	$css .= "background-size: cover;";
	$css .= "float: left;";
	$css .= "margin-right: 5px;";
	$css .= "width: 6em;";
	return "<a href=\"{$link}\" target=\"_blank\"><img src=\"{$imgPath}/google-docs-trans.png\" style=\"{$css}\"/></a>";
}
add_shortcode( 'syGoogleSpreadsheet', 'syGoogleSpreadsheet_shortcode' );
// [syGoogleDrive link="" ]
function syGoogleDrive_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'link' => ''
	), $atts ) );
	$imgPath = get_stylesheet_directory_uri()."/includes/images";
	$css = "background-image: url({$imgPath}/google-docs-sprite.png);";
	$css .= "background-position:0 0;";
	$css .= "background-size: cover;";
	$css .= "float: left;";
	$css .= "margin-right: 5px;";
	$css .= "width: 6em;";
	return "<a href=\"{$link}\" target=\"_blank\"><img src=\"{$imgPath}/google-docs-trans.png\" style=\"{$css}\"/></a>";
}
add_shortcode( 'syGoogleDrive', 'syGoogleDrive_shortcode' );
// [syGoogleDoc link="" ]
function syGoogleDoc_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'link' => ''
	), $atts ) );
	$imgPath = get_stylesheet_directory_uri()."/includes/images";
	$css = "background-image: url({$imgPath}/google-docs-sprite.png);";
	$css .= "background-position:-6em 0;";
	$css .= "background-size: cover;";
	$css .= "float: left;";
	$css .= "margin-right: 5px;";
	$css .= "width: 6em;";
	return "<a href=\"{$link}\" target=\"_blank\"><img src=\"{$imgPath}/google-docs-trans.png\" style=\"{$css}\"/></a>";
}
add_shortcode( 'syGoogleDoc', 'syGoogleDoc_shortcode' );
// [syGooglePpt link="" ]
function syGooglePpt_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'link' => ''
	), $atts ) );
	$imgPath = get_stylesheet_directory_uri()."/includes/images";
	$css = "background-image: url({$imgPath}/google-docs-sprite.png);";
	$css .= "background-position:-18em 0;";
	$css .= "background-size: cover;";
	$css .= "float: left;";
	$css .= "margin-right: 5px;";
	$css .= "width: 6em;";
	return "<a href=\"{$link}\" target=\"_blank\"><img src=\"{$imgPath}/google-docs-trans.png\" style=\"{$css}\"/></a>";
}
add_shortcode( 'syGooglePpt', 'syGooglePpt_shortcode' );
?>