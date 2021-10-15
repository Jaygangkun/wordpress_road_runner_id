<?php /* Template Name: Home Page Template */ ?>
<?php 
get_header();

?>

<div class="page-home-content">
    <div class="row my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">FIRST RESPONDER LOGIN</h2>
                    <div class="alert alert-danger" role="alert" id="responder_login_alert_fail" style="display: none">Fail to login</div>
                    <div class="alert alert-success" role="alert" id="responder_login_alert_success" style="display: none">Success to login</div>
                    <div class="mt-3">
                        <label for="sn" class="form-label">8-Digit Serial #</label>
                        <input type="text" class="form-control" id="sn" maxlength="8" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="pin" class="form-label">5-Digit PIN</label>
                        <input type="text" class="form-control" id="pin" maxlength="5" placeholder="">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100" id="responder_login_btn">Login</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">CUSTOMER LOGIN</h2>
                    <div class="alert alert-danger" role="alert" id="customer_login_alert_fail" style="display: none">Fail to login</div>
                    <div class="alert alert-success" role="alert" id="customer_login_alert_success" style="display: none">Success to login</div>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="">
                    </div>
                    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100" id="customer_login_btn">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery(document).on('click', '#responder_login_btn', function() {
            jQuery('#responder_login_alert_success').hide();
            jQuery('#responder_login_alert_fail').hide();
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'responder_login',
                    sn: jQuery('#sn').val(),
                    pin: jQuery('#pin').val(),
                    security: jQuery('#security').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.loggedin) {
                        jQuery('#responder_login_alert_success').show();
                        document.location.href = login_redirecturl;
                    }
                    else {
                        jQuery('#responder_login_alert_fail').show();
                    }
                }
            })
        })

        jQuery(document).on('click', '#customer_login_btn', function() {
            jQuery('#customer_login_alert_success').hide();
            jQuery('#customer_login_alert_fail').hide();
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'customer_login',
                    username: jQuery('#email').val(),
                    password: jQuery('#password').val(),
                    security: jQuery('#security').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.loggedin) {
                        jQuery('#customer_login_alert_success').show();
                        document.location.href = login_redirecturl;
                    }
                    else {
                        jQuery('#customer_login_alert_fail').show();
                    }
                }
            })
        })
    })
</script>
<?php
get_footer();