<?php
/*
  Author: Primer Co
  URL: htp://byprimer.co
*/


/************* INCLUDE NEEDED FILES ***************/


/*
1. library/primer.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/primer.php'); // if you remove this, primer will break
require_once('library/acf_blocks.php'); // ACF Gutenberg Blocks
require_once('wp_bootstrap_navwalker.php'); // Bootstrap Nav Walker

/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default

/*
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default


/************* THUMBNAIL SIZE OPTIONS *************/


// Thumbnail sizes
add_image_size( 'primer-1400', 1400, 0, true );



/************* ACTIVE SIDEBARS ********************/


// Sidebars & Widgetizes Areas
function primer_register_sidebars() {
  
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => __('Sidebar 1', 'primertheme'),
    	'description' => __('The first (primary) sidebar.', 'primertheme'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

}




/************* COMMENT LAYOUT *********************/

		
// Comment Layout
function primer_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php 
			    /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */ 
			    ?>
			    <!-- custom gravatar call -->
			    <?php
			    	// create variable
			    	$bgauthemail = get_comment_author_email();
			    ?>
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'primertheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'primertheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'primertheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'primertheme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!


/************* SEARCH FORM LAYOUT *****************/


// Search Form
function primer_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search', 'primertheme') . '</label>
    <div class="form-group">
      <input type="text" class="form-control" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search...','primertheme').'" />
    </div>
    <input type="submit" class="btn btn-primary" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!


/************* IMAGE FORMATTING *****************/


// Allow SVG Upload to WP
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


/************* ACF *****************/


// Add ACF Options Page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

include('constants.php');

function existWristbandID($data) {
	$sn = isset($data['sn']) ? $data['sn'] : '';
	$pin = isset($data['pin']) ? $data['pin'] : '';

	$users = get_users( array( 'role__in' => array( 'subscriber' ) ) );
	// Array of WP_User objects.
	foreach ( $users as $user ) {
		$wristbands = get_posts(array(
			'post_type' => 'wristband',
			'numberposts' => -1,
			'author' => $user->ID,
			'post_status' => array('private')
		));
		
		foreach($wristbands as $wristband) {
			$wristband_sn = get_post_meta($wristband->ID, 'sn', true);
			$wristband_pin = get_post_meta($wristband->ID, 'pin', true);

			if ($wristband_sn == $sn && $wristband_pin == $pin) {
				return true;
			}
		}
	}

	return false;
}

function addWristband() {
	$user = wp_get_current_user();

	$resp = array(
		'success' => false,
	);

	$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
	$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
	$status = isset($_POST['status']) ? $_POST['status'] : '';
	$date = isset($_POST['date']) ? $_POST['date'] : '';

	if (existWristbandID(array('sn' => $sn, 'pin' => $pin))) {
		$resp['message'] = 'Wristband already exists!';
		echo json_encode($resp);
		die();
	}
	
	$wristband_id = wp_insert_post(array (
		'post_type' => 'wristband',
		'post_title' => $sn.'-'.$pin,
		'post_content' => '',
		'post_status' => 'private',
		'author' => $user->ID,
		'comment_status' => 'closed',   // if you prefer
		'ping_status' => 'closed',      // if you prefer
	));

	if ($wristband_id) {
		add_post_meta($wristband_id, 'sn', $sn);
		add_post_meta($wristband_id, 'pin', $pin);
		add_post_meta($wristband_id, 'status', $status);
		add_post_meta($wristband_id, 'date', $date);

		$resp['success'] = true;
		ob_start();
		showWristbands();
		$wristband_list_html = ob_get_contents();
		ob_end_clean();
		$resp['html'] = $wristband_list_html;
	}

	echo json_encode($resp);

	die();
}
add_action('wp_ajax_add_wristband', 'addWristband');
add_action('wp_ajax_nopriv_add_wristband', 'addWristband');

function updateWristband() {
	$resp = array(
		'success' => false
	);

	$wristband_id = isset($_POST['wristband_id']) ? $_POST['wristband_id'] : '';
	$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
	$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
	$status = isset($_POST['status']) ? $_POST['status'] : '';
	$date = isset($_POST['date']) ? $_POST['date'] : '';

	if (existWristbandID(array('sn' => $sn, 'pin' => $pin))) {
		$resp['message'] = 'Wristband already exists!';
		echo json_encode($resp);
		die();
	}

	if ($wristband_id != '') {
		wp_update_post(array(
			'ID' => $_POST['wristband_id'],
			'post_title' => $sn.'-'.$pin,
		));

		update_post_meta($wristband_id, 'sn', $sn);
		update_post_meta($wristband_id, 'pin', $pin);
		update_post_meta($wristband_id, 'status', $status);
		update_post_meta($wristband_id, 'date', $date);

		$resp['success'] = true;
		ob_start();
		showWristbands();
		$wristband_list_html = ob_get_contents();
		ob_end_clean();
		$resp['html'] = $wristband_list_html;
	}
	echo json_encode($resp);
	die();
}

add_action('wp_ajax_update_wristband', 'updateWristband');
add_action('wp_ajax_nopriv_update_wristband', 'updateWristband');

function deleteWristband() {
	$resp = array(
		'success' => false
	);

	$wristband_id = isset($_POST['wristband_id']) ? $_POST['wristband_id'] : '';

	if ($wristband_id != '') {
		wp_delete_post($wristband_id);

		$resp['success'] = true;
		ob_start();
		showWristbands();
		$wristband_list_html = ob_get_contents();
		ob_end_clean();
		$resp['html'] = $wristband_list_html;
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_delete_wristband', 'deleteWristband');
add_action('wp_ajax_nopriv_delete_wristband', 'deleteWristband');

function showWristbands() {
	$user = wp_get_current_user();
	$wristbands = get_posts(array(
		'post_type' => 'wristband',
		'numberposts' => -1,
		'author' => $user->ID,
		'post_status' => array('private')
	));

	$wristband_index = 1;
	foreach($wristbands as $wristband) {
		?>
		<tr wristband-id="<?php echo $wristband->ID?>">
			<td class="td-sn"><?php the_field('sn', $wristband->ID)?></td>
			<td class="td-pin"><?php the_field('pin', $wristband->ID)?></td>
			<td class="td-status">
				<?php
				$status = get_field('status', $wristband->ID);
				if ($status == 'active') {
					echo '<span class="badge bg-blue">Active</span>';
				}
				else if ($status == 'inactive') {
					echo '<span class="badge bg-danger">Inactive</span>';
				}
				else if ($status == 'lost') {
					echo '<span class="badge bg-warning text-dark">Lost</span>';
				}
				else if ($status == 'stolen') {
					echo '<span class="badge bg-warning text-dark">Stolen</span>';
				}
				?>
			</td>
			<td class="td-date"><?php the_field('date', $wristband->ID)?></td>
			<td>
				<a class="wristband-action-btn wristband-edit-btn text-blue">Edit</a>
				<a class="wristband-action-btn wristband-delete-btn text-danger">Delete</a>
			</td>
		</tr>
		<?php
	}
}

function logOut() {
	$_SESSION['loginUser'] = '';
	wp_logout();
	echo json_encode(array(
		'logout' => true
	));
	die();
}

add_action('wp_ajax_logout', 'logOut');
add_action('wp_ajax_nopriv_logout', 'logOut');

function ajax_login_init(){

    // wp_register_script('ajax-login-script', get_template_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
    // wp_enqueue_script('ajax-login-script');

    // wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
    //     'ajaxurl' => admin_url( 'admin-ajax.php' ),
    //     'redirecturl' => home_url(),
    //     'loadingmessage' => __('Sending user info, please wait...')
    // ));

    // Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_customer_login', 'customerLogin' );
    add_action( 'wp_ajax_nopriv_customer_login', 'customerLogin' );

	add_action('wp_ajax_responder_login', 'responderLogin');
	add_action('wp_ajax_nopriv_responder_login', 'responderLogin');
}

function responderLogin() {
	$_SESSION['loginUser'] = '';
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
	$pin = isset($_POST['pin']) ? $_POST['pin'] : '';

	$users = get_users( array( 'role__in' => array( 'subscriber' ) ) );
	$user_id = null;
	// Array of WP_User objects.
	foreach ( $users as $user ) {
		$wristbands = get_posts(array(
			'post_type' => 'wristband',
			'numberposts' => -1,
			'author' => $user->ID,
			'post_status' => array('private')
		));
		
		foreach($wristbands as $wristband) {
			$wristband_sn = get_field('sn', $wristband->ID);
			$wristband_pin = get_field('pin', $wristband->ID);

			if ($wristband_sn == $sn && $wristband_pin == $pin) {
				$user_id = $user->ID;
				break;
			}
		}
	}

	if ($user_id != null) {
		wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        echo json_encode(array(
			'loggedin' => true, 
			'message' => __('Login successful, redirecting...')
		));
		$_SESSION['loginUser'] = 'FR';
	}
	else {
		echo json_encode(array(
			'loggedin' => false, 
		));
	}

	die();
}
// session_start();
// $_SESSION['loginUser'] = 'CT';
add_action('init', 'cyb_start_session', 1);
add_action('wp_logout', 'cyb_end_session');
// add_action('wp_login', 'cyb_end_session');

function cyb_start_session() {
    if( ! session_id() ) {
        session_start();
        // now you can load your library that use $_SESSION
    }
}

function cyb_end_session() {
    session_destroy();
}

function customerLogin(){
	$_SESSION['loginUser'] = '';
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( !is_wp_error($user_signon) ){
        wp_set_current_user($user_signon->ID);
        wp_set_auth_cookie($user_signon->ID);
        echo json_encode(array(
			'loggedin' => true, 
			'message' => __('Login successful, redirecting...')
		));
		$_SESSION['loginUser'] = 'CT';
    }
	else {
		echo json_encode(array(
			'loggedin' => false, 
		));
	}

    die();
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function updateForm() {
	$ignore_field_names = ['user_id', 'form_name', 'meta_type', 'list_count', 'list_index', 'form_action', 'action'];

	$resp = [
		'success' => false
	];
	
	if(isset($_POST['user_id']) && isset($_POST['form_name'])) {

		if(isset($_POST['meta_type']) && $_POST['meta_type'] == 'list') {
						
			if(isset($_POST['form_action']) && $_POST['form_action'] == 'delete') {
				if(isset($_POST['list_index']) && $_POST['list_index'] != '-1') {
					$list_index = (int)$_POST['list_index'];
				}
				
				if(isset($_POST['list_count'])) {
					$list_count = (int)$_POST['list_count'];
				}

				for($index = $list_index; $index < ($list_count - 1 ); $index ++) {
					// move data
					$next_index = $index + 1;
					$field_names = array_keys($_POST);
					foreach($field_names as $field_name) {
						if(in_array($field_name, $ignore_field_names)) {
							continue;
						}
			
						$meta_field_name_src = $_POST['form_name'].'_list_'.$next_index.'_'.$field_name;
						$meta_data = get_user_meta($_POST['user_id'], $meta_field_name_src);
						
						$meta_field_name_des = $_POST['form_name'].'_list_'.$index.'_'.$field_name;
						update_user_meta($_POST['user_id'], $meta_field_name_des, $meta_data[0]);
					}	
				}

				if($list_count >= 0) {
					update_user_meta($_POST['user_id'], $_POST['form_name'].'_'.'list', $list_count - 1);
				}
			}
			else {
				if(isset($_POST['list_index']) && $_POST['list_index'] != '-1') {
					$list_index = (int)$_POST['list_index'];
					$list_count = null;
				}
				else if(isset($_POST['list_count'])) {
					$list_index = (int)$_POST['list_count'];
					$list_count = (int)$_POST['list_count'] + 1;
				}

				$field_names = array_keys($_POST);
				foreach($field_names as $field_name) {
					if(in_array($field_name, $ignore_field_names)) {
						continue;
					}
		
					$meta_field_name = $_POST['form_name'].'_list_'.$list_index.'_'.$field_name;
					update_user_meta($_POST['user_id'], $meta_field_name, isset($_POST[$field_name]) ? $_POST[$field_name] : '');
				}

				if($list_count) {
					update_user_meta($_POST['user_id'], $_POST['form_name'].'_'.'list', $list_count);
				}
			}

			ob_start();

			if($_POST['form_name'] == 'emergency_contacts') {
				loadEmergencyContacts($_POST['user_id']);
			}

			if($_POST['form_name'] == 'allergies') {
				loadAllergies($_POST['user_id']);
			}

			if($_POST['form_name'] == 'current_medications') {
				loadCurrentMedications($_POST['user_id']);
			}

			if($_POST['form_name'] == 'medical_conditions') {
				loadMedicalConditions($_POST['user_id']);
			}

			if($_POST['form_name'] == 'insurance') {
				loadInsurances($_POST['user_id']);
			}

			if($_POST['form_name'] == 'physicians') {
				loadPhysicians($_POST['user_id']);
			}

			if($_POST['form_name'] == 'security_questions') {
				loadSecurityQuestions($_POST['user_id']);
			}

			$html = ob_get_contents();
			ob_end_clean();
			$resp['html'] = $html;
			
		}
		else {
			$field_names = array_keys($_POST);
			foreach($field_names as $field_name) {
				if(in_array($field_name, $ignore_field_names)) {
					continue;
				}
	
				$meta_field_name = $_POST['form_name'].'_'.$field_name;
				update_user_meta($_POST['user_id'], $meta_field_name, isset($_POST[$field_name]) ? $_POST[$field_name] : '');
			}
		}
		
		$resp['success'] = true;
	}
	
	echo json_encode($resp);
	die();
}

add_action('wp_ajax_update_form', 'updateForm');
add_action('wp_ajax_nopriv_update_form', 'updateForm');

function updateAvatar() {
	$resp = [
		'success' => false
	];

	if(isset($_POST['user_id'])) {
		global $wpdb;

		if(isset($_FILES['profile_img'])){
			$filename = $_FILES['profile_img']['name'];
			$filename = str_replace(' ', '', $filename);
            // Get extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Valid image extension
            $valid_ext = array("png","jpeg","jpg");

            // Check extension
            if(in_array($ext, $valid_ext)){

				$wp_upload_dir = wp_upload_dir();
    			$upload_location = $wp_upload_dir['path'] . '/';
                // File path
                $path = $upload_location.$filename;

                // Upload file
                if(move_uploaded_file($_FILES['profile_img']['tmp_name'], $path)){
                    $guids = $wp_upload_dir['url'].'/'.$filename;

                    $attachment = array(
                        'guid'=> $wp_upload_dir['url'].'/'.$filename, 
                        'post_mime_type' => 'image/'.$ext,
                        'post_title' => 'Avatar Image -'.$filename,
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    $image_id = wp_insert_attachment($attachment, $wp_upload_dir['url'].'/'.$filename);
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' ); 
                    // Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata( $image_id, $wp_upload_dir['url'].'/'.$filename );
                    wp_update_attachment_metadata( $image_id, $attach_data );

					update_user_meta($_POST['user_id'], 'profile_photo_image', $image_id);
                }
            }
        }

		$resp['success'] = true;
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_update_avatar', 'updateAvatar');
add_action('wp_ajax_nopriv_update_avatar', 'updateAvatar');

function loadEmergencyContacts($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'emergency_contacts', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="">
				<span class="td-name"><?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'first_name', $index).' '.getUserMetaListData($user_meta_data, 'emergency_contacts', 'middle_name', $index).' '.getUserMetaListData($user_meta_data, 'emergency_contacts', 'last_name', $index)?></span>
				<span class="td-first-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'first_name', $index)?></span>
				<span class="td-middle-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'middle_name', $index)?></span>
				<span class="td-last-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'last_name', $index)?></span>
				<span class="td-email" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'email', $index)?></span>
			</td>
			<td class="td-relationship">
				<?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'relationship', $index)?>
			</td>
			<td class="td-phone">
				<?php echo getUserMetaListData($user_meta_data, 'emergency_contacts', 'phone', $index)?>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn emergency-contact-btn emergency-contact-edit-btn text-blue">Edit</a>
					<a class="action-btn emergency-contact-btn emergency-contact-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn emergency-contact-btn emergency-contact-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadAllergies($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'allergies', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-type">
				<?php echo getUserMetaListData($user_meta_data, 'allergies', 'type', $index)?>
			</td>
			<td class="td-allergy">
				<?php echo getUserMetaListData($user_meta_data, 'allergies', 'allergy', $index)?>
			</td>
			<td class="">
				<span class="td-severity"><?php echo getUserMetaListData($user_meta_data, 'allergies', 'severity', $index)?></span>
				<span class="td-notes" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'allergies', 'notes', $index)?></span>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn allergy-btn allergy-edit-btn text-blue">Edit</a>
					<a class="action-btn allergy-btn allergy-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn allergy-btn allergy-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadCurrentMedications($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'current_medications', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-name">
				<?php echo getUserMetaListData($user_meta_data, 'current_medications', 'name', $index)?>
			</td>
			<td class="td-dosage">
				<?php echo getUserMetaListData($user_meta_data, 'current_medications', 'dosage', $index)?>
			</td>
			<td class="">
				<span class="td-type"><?php echo getUserMetaListData($user_meta_data, 'current_medications', 'type', $index)?></span>
				<span class="td-unit" style="display:none"><?php echo get_sub_field('unit')?></span>
			</td>
			<td>
				<span class="td-frequency"><?php echo getUserMetaListData($user_meta_data, 'current_medications', 'frequency', $index)?></span>
				<span class="td-reason" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'current_medications', 'reason', $index)?></span>
				<span class="td-notes" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'current_medications', 'notes', $index)?></span>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn current-medication-btn current-medication-edit-btn text-blue">Edit</a>
					<a class="action-btn current-medication-btn current-medication-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn current-medication-btn current-medication-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadMedicalConditions($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'medical_conditions', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-condition">
				<?php echo getUserMetaListData($user_meta_data, 'medical_conditions', 'condition', $index)?>
			</td>
			<td>
				<span class="td-severity"><?php echo getUserMetaListData($user_meta_data, 'medical_conditions', 'severity', $index)?></span>
				<span class="td-notes" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'medical_conditions', 'notes', $index)?></span>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn medical-condition-btn medical-condition-edit-btn text-blue">Edit</a>
					<a class="action-btn medical-condition-btn medical-condition-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn medical-condition-btn medical-condition-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadInsurances($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'insurance', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-type">
				<?php echo getUserMetaListData($user_meta_data, 'insurance', 'type', $index)?>
			</td>
			<td>
				<span class="td-company"><?php echo getUserMetaListData($user_meta_data, 'insurance', 'company', $index)?></span>
				<span class="td-group" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'insurance', 'group', $index)?></span>
				<span class="td-identification" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'insurance', 'identification', $index)?></span>
				<span class="td-additional" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'insurance', 'additional', $index)?></span>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn insurance-btn insurance-edit-btn text-blue">Edit</a>
					<a class="action-btn insurance-btn insurance-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn insurance-btn insurance-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadPhysicians($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'physicians', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-speciality">
				<?php echo getUserMetaListData($user_meta_data, 'physicians', 'speciality', $index)?>
			</td>
			<td>
				<span class="td-name"><?php echo getUserMetaListData($user_meta_data, 'physicians', 'first_name', $index).' '.getUserMetaListData($user_meta_data, 'physicians', 'middle_name', $index).' '.getUserMetaListData($user_meta_data, 'physicians', 'last_name', $index)?></span>
				<span class="td-first-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'physicians', 'first_name', $index)?></span>
				<span class="td-middle-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'physicians', 'middle_name', $index)?></span>
				<span class="td-last-name" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'physicians', 'last_name', $index)?></span>
				<span class="td-notes" style="display:none"><?php echo getUserMetaListData($user_meta_data, 'physicians', 'notes', $index)?></span>
			</td>
			<td class="td-phone">
				<?php echo getUserMetaListData($user_meta_data, 'physicians', 'phone', $index)?>
			</td>
			<td class="td-email">
				<?php echo getUserMetaListData($user_meta_data, 'physicians', 'email', $index)?>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn physician-btn physician-edit-btn text-blue">Edit</a>
					<a class="action-btn physician-btn physician-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn physician-btn physician-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function loadSecurityQuestions($user_id) {
	$user_meta_data = get_user_meta($user_id);
	$list_count = (int)getUserMetaData($user_meta_data, 'security_questions', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		?>
		<tr index="<?php echo $index?>">
			<td class="td-question">
				<?php echo getUserMetaListData($user_meta_data, 'security_questions', 'question', $index)?>
			</td>
			<td class="td-answer">
				<?php echo getUserMetaListData($user_meta_data, 'security_questions', 'answer', $index)?>
			</td>
			<td>
				<?php
				if($_SESSION['loginUser'] == 'CT') {
					?>
					<a class="action-btn security-question-btn security-question-edit-btn text-blue">Edit</a>
					<a class="action-btn security-question-btn security-question-delete-btn text-danger">Delete</a>
					<?php
				}
				else if($_SESSION['loginUser'] == 'FR') {
					?>
					<a class="action-btn security-question-btn security-question-view-btn text-blue">View</a>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}
}

function getUserMetaData($meta, $form_name, $field_name) {
	$meta_field_name = $form_name.'_'.$field_name;
	return isset($meta[$meta_field_name]) ? $meta[$meta_field_name][0] : '';
}

function getUserMetaListData($meta, $form_name, $field_name, $index) {
	$meta_field_name = $form_name.'_list_'.$index."_".$field_name;
	return isset($meta[$meta_field_name]) ? $meta[$meta_field_name][0] : '';
}

function report() {
	$resp = array(
		'success' => false
	);

	$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
	$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
	$status = isset($_POST['status']) ? $_POST['status'] : '';
	$date = isset($_POST['date']) ? $_POST['date'] : '';

	if($status == '') {
		$resp['message'] = 'No Reason';
	}
	else {
		$users = get_users( array( 'role__in' => array( 'subscriber' ) ) );
		$found_wristband = null;
		// Array of WP_User objects.
		foreach ( $users as $user ) {
			$wristbands = get_posts(array(
				'post_type' => 'wristband',
				'numberposts' => -1,
				'author' => $user->ID,
				'post_status' => array('private')
			));
			
			foreach($wristbands as $wristband) {
				$wristband_sn = get_field('sn', $wristband->ID);
				$wristband_pin = get_field('pin', $wristband->ID);
	
				if ($wristband_sn == $sn && $wristband_pin == $pin) {
					$found_wristband = $wristband;
					break;
				}
			}
		}

		if($found_wristband) {
			wp_update_post(array(
				'ID' => $_POST['wristband_id'],
				'post_title' => $sn.'-'.$pin,
			));
	
			update_post_meta($found_wristband->ID, 'status', $status);
			update_post_meta($found_wristband->ID, 'date', $date);
			$resp['success'] = true;
		}
		else {
			$resp['message'] = 'No Found ID';
		}
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_report', 'report');
add_action('wp_ajax_nopriv_report', 'report');

function register() {
	$resp = array(
		'success' => false
	);

	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	
	if($username == '' || $email == '' || $password == '') {
		$resp['message'] = 'No Username or Email or Password';
	}
	else {
		if(username_exists($username)) {
			$resp['message'] = 'Username already exists';
		}
		else if(email_exists($email)) {
			$resp['message'] = 'Email already exists';
		}
		else {
			$user_id = wp_create_user($username, $password, $email);

			if(!is_wp_error($user_id)) {
				$user = new WP_User($user_id);
				$user->set_role('subscriber');
			}

			$resp['success'] = true;
		}
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_register', 'register');
add_action('wp_ajax_nopriv_register', 'register');

function slugify($text, $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function renderSecurityQuestionsAdded() {
	$user_meta_data = get_user_meta(get_current_user_id());
	$list_count = (int)getUserMetaData($user_meta_data, 'security_questions', 'list');
	for($index = 0; $index < $list_count; $index ++) {
		$question = getUserMetaListData($user_meta_data, 'security_questions', 'question', $index);
		?>
		<div class="mt-3">
			<label for="question_<?php echo $index?>" class="form-label"><?php echo $question?></label>
			<input type="text" class="form-control" id="question_<?php echo $index?>" placeholder="">
		</div>
		<?php
	}
}

function resetPwCheckUser() {
	$resp = array(
		'success' => false
	);

	$email = isset($_POST['email']) ? $_POST['email'] : '';

	if($email != '') {
		$user = get_user_by('email', $email);

		if(!$user) {
			$resp['message'] = 'Not find user';	
		}
		else {
			$resp['user_id'] = $user->ID;
			$questions = array();
			$user_meta_data = get_user_meta($user->ID);
			$list_count = (int)getUserMetaData($user_meta_data, 'security_questions', 'list');
			for($index = 0; $index < $list_count; $index ++) {
				$questions[] = getUserMetaListData($user_meta_data, 'security_questions', 'question', $index);
			}
			$resp['questions'] = $questions;

			$resp['success'] = true;
		}
	}
	else {
		$resp['message'] = 'Email is empty';
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_reset_pw_check_user', 'resetPwCheckUser');
add_action('wp_ajax_nopriv_reset_pw_check_user', 'resetPwCheckUser');

function checkSecurityQuestionAnswers() {
	$resp = array(
		'success' => false
	);

	$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
	$data = isset($_POST['data']) ? $_POST['data'] : null;

	if($user_id && $data) {
		$user_meta_data = get_user_meta($user_id);
		$list_count = (int)getUserMetaData($user_meta_data, 'security_questions', 'list');

		$questions = array();
		for($index = 0; $index < $list_count; $index ++) {
			$questions[] = array(
				'question' => getUserMetaListData($user_meta_data, 'security_questions', 'question', $index),
				'answer' => getUserMetaListData($user_meta_data, 'security_questions', 'answer', $index)
			);
		}

		$qa_match = true;
		foreach($data as $qa) {
			$question_index = $qa['question_index'];
			if($question_index < count($questions)) {
				if($questions[$question_index]['answer'] != $qa['answer']) {
					$qa_match = false;
				}
			}
			else {
				$qa_match = false;
			}
		}

		if($qa_match) {
			$resp['success'] = true;
		}
		else {
			$resp['message'] = 'Answers are incorrect.';	
		}
	}
	else {
		$resp['message'] = 'No user id or answers data';
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_check_security_question_answers', 'checkSecurityQuestionAnswers');
add_action('wp_ajax_nopriv_check_security_question_answers', 'checkSecurityQuestionAnswers');

function resetUserPassword() {
	$resp = array(
		'success' => false
	);

	$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
	$password = isset($_POST['password']) ? $_POST['password'] : null;

	if($user_id && $password) {
		$user = get_user_by('ID', $user_id);
		if($user) {
			reset_password($user, $password);
			$resp['success'] = true;
		}
		else {
			$resp['message'] = 'No found user';	
		}
	}
	else {
		$resp['message'] = 'No user id or empty password';
	}

	echo json_encode($resp);
	die();
}

add_action('wp_ajax_reset_user_password', 'resetUserPassword');
add_action('wp_ajax_nopriv_reset_user_password', 'resetUserPassword');

function myroadid_change_cookie_logout( $expiration){
    
    return 5 * 60;
}
 
add_filter( 'auth_cookie_expiration','myroadid_change_cookie_logout', 10, 3 );

define ('MAX_WRIST_BANDS', 5);
define ('MAX_EMERGENCY_CONTACTS', 3);
?>
