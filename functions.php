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

function addWristband() {
	$user = wp_get_current_user();

	$resp = array(
		'success' => false,
	);

	$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
	$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
	$status = isset($_POST['status']) ? $_POST['status'] : '';
	$date = isset($_POST['date']) ? $_POST['date'] : '';

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
	}
	else {
		echo json_encode(array(
			'loggedin' => false, 
		));
	}

	die();
}

function customerLogin(){

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

?>
