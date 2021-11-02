<?php /* Template Name: Register Page Template */ ?>
<?php 
get_header();

?>

<div class="page-register-content">
    <div class="row mt-5">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">REGISTER</h2>
                    <div class="alert alert-danger" role="alert" id="register_alert_fail" style="display: none"></div>
                    <div class="alert alert-success" role="alert" id="register_alert_success" style="display: none">Success to register</div>
                    <div class="mt-3">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="username" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100" id="register_btn">Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col-lg-12 text-center">
            <a class="text-blue" href="<?php echo get_permalink(get_page_by_path('/home'))?>">Login</a>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery(document).on('click', '#register_btn', function() {
            jQuery('#register_alert_success').hide();
            jQuery('#register_alert_fail').hide();
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'register',
                    username: jQuery('#username').val(),
                    email: jQuery('#email').val(),
                    password: jQuery('#password').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#register_alert_success').show();
                    }
                    else {
                        jQuery('#register_alert_fail').text(resp.message);
                        jQuery('#register_alert_fail').show();
                    }
                }
            })
        })
    })
</script>
<?php
get_footer();