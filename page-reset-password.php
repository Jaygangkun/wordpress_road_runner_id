<?php /* Template Name: Reset Password Page Template */ ?>
<?php 
get_header();

?>

<div class="page-register-content">
    <div class="row mt-5">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">RESET PASSWORD</h2>
                    <div class="alert alert-danger" role="alert" id="res_alert_fail" style="display: none"></div>
                    <div class="alert alert-success" role="alert" id="res_alert_success" style="display: none">Success</div>
                    <div class="reset-password-step" step="1">
                        <div class="mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-blue w-100" id="reset_pw_next_2_btn">Next</button>
                        </div>
                    </div>
                    <div class="reset-password-step" step="2" style="display: none">
                        <div id="security_questions"></div>
                        <div class="mt-3">
                            <button class="btn btn-blue w-100" id="reset_pw_next_3_btn">Next</button>
                        </div>
                        <div class="mt-3 text-center">
                            <a class="text-blue reset-pw-back-btn" href="javascript:void(0)">Back</a>
                        </div>
                    </div>
                    <div class="reset-password-step" step="3" style="display: none">
                        <div class="mt-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="text" class="form-control" id="new_password" placeholder="">
                        </div>
                        <div class="mt-3">
                            <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                            <input type="text" class="form-control" id="confirm_new_password" placeholder="">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-blue w-100" id="reset_pw_reset_btn">Reset</button>
                        </div>
                        <div class="mt-3 text-center">
                            <a class="text-blue reset-pw-back-btn" href="javascript:void(0)">Back</a>
                        </div>
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
    var user_id = null;
    jQuery(document).ready(function(){
        jQuery(document).on('click', '.reset-pw-back-btn', function() {
            jQuery('.alert').hide();
            jQuery('#security_questions').html('');
            jQuery('.reset-password-step').hide();
            jQuery('[step="1"]').show();
        })

        jQuery(document).on('click', '#reset_pw_next_2_btn', function() {
            user_id = null;
            jQuery('.alert').hide();
            if(jQuery('#email').val() == '') {
                jQuery('#res_alert_fail').text('Please Input Email');
                jQuery('#res_alert_fail').show();
                return;
            }

            jQuery('#res_alert_fail').hide();
            
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'reset_pw_check_user',
                    email: jQuery('#email').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {

                        if(resp.questions.length == 0) {
                            jQuery('#res_alert_fail').show();
                            jQuery('#res_alert_fail').text('No added security questions.');
                        }
                        else {
                            var questions = resp.questions;
                            var questions_html = '';
                            for(var index = 0; index < questions.length; index ++) {
                                questions_html += '<div class="mt-3">';
                                questions_html += '<label for="question_' + index + '" class="form-label">' + questions[index] + '</label>';
                                questions_html += '<input type="text" class="form-control answer-input" question-index="' + index + '" id="question_' + index + '" placeholder="">';
                                questions_html += '</div>';
                            }

                            jQuery('#security_questions').html(questions_html);

                            jQuery('.alert').hide();
                            jQuery('.reset-password-step').hide();
                            jQuery('[step="2"]').show();

                            user_id = resp.user_id;
                        }
                    }
                    else {
                        jQuery('#res_alert_fail').show();
                        jQuery('#res_alert_fail').text(resp.message);
                    }
                }
            })
        })

        jQuery(document).on('click', '#reset_pw_next_3_btn', function() {
            jQuery('.alert').hide();
            var answer_inputs = jQuery('.answer-input');
            var existEmptyAnswer = false;
            var data = [];
            for(var index = 0; index < answer_inputs.length; index ++) {
                var answer = jQuery(answer_inputs[index]).val();
                data.push({
                    question_index: jQuery(answer_inputs[index]).attr('question-index'),
                    answer: answer
                });

                if(answer == '') {
                    existEmptyAnswer = true;
                }
            }

            if(existEmptyAnswer) {
                jQuery('#res_alert_fail').text('Please Input All Answers');
                jQuery('#res_alert_fail').show();
                return;
            }

            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'check_security_question_answers',
                    data: data,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('.alert').hide();
                        jQuery('.reset-password-step').hide();
                        jQuery('[step="3"]').show();
                    }
                    else {
                        jQuery('#res_alert_fail').show();
                        jQuery('#res_alert_fail').text(resp.message);
                    }
                }
            })
        })

        jQuery(document).on('click', '#reset_pw_reset_btn', function() {
            jQuery('.alert').hide();
            if(jQuery('#new_password').val() == '') {
                jQuery('#res_alert_fail').text('Please Input Reset Password');
                jQuery('#res_alert_fail').show();
                return;
            }

            if(jQuery('#confirm_new_password').val() == '') {
                jQuery('#res_alert_fail').text('Please Input Confirm Reset Password');
                jQuery('#res_alert_fail').show();
                return;
            }

            if(jQuery('#new_password').val() != jQuery('#confirm_new_password').val()) {
                jQuery('#res_alert_fail').text('Reset Passwords do not match');
                jQuery('#res_alert_fail').show();
                return;
            }

            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'reset_user_password',
                    password: jQuery('#new_password').val(),
                    user_id: user_id
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#res_alert_success').show();
                    }
                    else {
                        jQuery('#res_alert_fail').show();
                        jQuery('#res_alert_fail').text(resp.message);
                    }
                }
            })
        })
    })
</script>
<?php
get_footer();