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
                    <div class="alert alert-success" role="alert" id="register_alert_success" style="display: none">You are now Registered, you must now Login and Activate your ID Profile Information.</div>
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
                        <label for="password" class="form-label">Security Questions</label>
                        <div>
                            <span class="btn btn-blue" id="btn_add">Add</span>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Question</th>
                                    <th scope="col">Answer</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="security_questions_list">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100" id="register_btn">Register</button>
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
<!-- Modal -->
<div class="modal fade profile-form-modal" id="modal_security_questions" tabindex="-1" aria-labelledby="modal_security_questions_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title modal-title-add" id="modal_security_questions_label">Add Security Question</h4>
                <h4 class="modal-title modal-title-edit" id="modal_security_questions_label">Edit Security Question</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="profile-form" id="security_questions">
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <select class="form-select" aria-label="" name="question">
                        <option value="">-- Select --</option>
                        <?php
                            foreach($security_questions as $question) {
                                ?>
                                <option value="<?php echo $question?>"><?php echo $question?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="answer" class="form-label">Answer</label>
                    <input type="text" class="form-control" name="answer" aria-describedby="answer">
                </div>
                <input type="hidden" class="form-control" name="list_index" aria-describedby="list_index">
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-blue btn-save" id="btn_save">Add</button>
                <button type="button" class="btn btn-blue btn-update" id="btn_update">Update</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_security_questions_confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="modal_security_questions_confirm_btn">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    (function($){
        var security_questions_list_count = 0;

        var security_questions_list = $('#security_questions_list');

        var modal_security_questions_confirm = $('#modal_security_questions_confirm');
        var modal_security_questions_results = $('#modal_security_questions_results');

        $(document).on('click', '#modal_security_questions #btn_save', function() {
            
            let trHtml = '';
            let question = $('#security_questions [name="question"]').val();
            let answer = $('#security_questions [name="answer"]').val();

            if(question == '') {
                alert('Please select question');
                return;
            }

            if(answer == '') {
                alert('Please enter answer');
                return;
            }

            // search already added question
            let questions = $("#security_questions_list .td-question");
            for(var index = 0; index < questions.length; index ++) {
                let added_question = $(questions[index]).text();
                if(added_question == question) {
                    alert('Already added question');
                    return;
                }
            }
            trHtml = '<tr>';
            trHtml += '<td class="td-question">' + question + '</td>';
            trHtml += '<td class="td-answer">' + answer + '</td>';
            trHtml += '<td><a class="action-btn security-question-btn security-question-edit-btn text-blue">Edit</a><a class="action-btn security-question-btn security-question-delete-btn text-danger">Delete</a></td>';
            trHtml += '</tr>';
            
            $(security_questions_list).append(trHtml);
            modal_security_questions.toggle();
        })

        $(document).on('click', '#modal_security_questions #btn_update', function() {
            let question = $('#security_questions [name="question"]').val();
            let answer = $('#security_questions [name="answer"]').val();

            if(question == '') {
                alert('Please select question');
                return;
            }

            if(answer == '') {
                alert('Please enter answer');
                return;
            }

            let questions = $("#security_questions_list .td-question");
            for(var index = 0; index < questions.length; index ++) {
                let tr = $(questions[index]).parents('tr');
                if(!tr.hasClass('edit')) {
                    let added_question = $(questions[index]).text();
                    if(added_question == question) {
                        alert('Already added question');
                        return;
                    }
                }
            }

            $("#security_questions_list tr.edit .td-question").text(question);
            $("#security_questions_list tr.edit .td-answer").text(answer);

            modal_security_questions.toggle();
        })

        var modal_security_questions = new bootstrap.Modal(document.getElementById('modal_security_questions'), {
            keyboard: false
        });
        var $modal_security_questions = $('#modal_security_questions');

        $(document).on('click', '#btn_add', function() {
            $($modal_security_questions).removeClass('edit');
            $($modal_security_questions).find('input').val('');
            $($modal_security_questions).find('select').val('');
            $($modal_security_questions).find('textarea').val('');

            modal_security_questions.toggle();
        })

        $(document).on('click', '.security-question-edit-btn', function() {
            var tr = $(this).parents('tr');
            $(security_questions_list).find('tr').removeClass('edit');
            $(tr).addClass('edit');

            $($modal_security_questions).addClass('edit');

            $($modal_security_questions).find('[name="question"]').val($(tr).find('.td-question').text().trim());
            $($modal_security_questions).find('[name="answer"]').val($(tr).find('.td-answer').text().trim());
            $($modal_security_questions).find('[name="list_index"]').val($(tr).attr('index'));

            modal_security_questions.toggle();
        })

        $(document).on('click', '.security-question-delete-btn', function() {
            $(security_questions_list).find('tr').removeClass('delete');
            var tr = $(this).parents('tr');
            $(tr).addClass('delete');
            $(modal_security_questions_confirm).modal('toggle');
        })

        $(document).on('click', '#modal_security_questions_confirm_btn', function() {
            $(modal_security_questions_confirm).modal('toggle');

            $(security_questions_list).find('tr.delete').remove();
        })
    })(jQuery)
    jQuery(document).ready(function(){
        jQuery(document).on('click', '#register_btn', function() {
            jQuery('#register_alert_success').hide();
            jQuery('#register_alert_fail').hide();
            // questions
            let questionsData = [];
            let questions = jQuery("#security_questions_list tr");
            for(var index = 0; index < questions.length; index ++) {
                let question = jQuery(questions[index]).find('.td-question').text();
                let answer = jQuery(questions[index]).find('.td-answer').text();
                
                questionsData.push({
                    question: question,
                    answer: answer
                });
            }

            if(questionsData.length == 0) {
                alert('Please add security questions');
                return;
            }

            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'register',
                    username: jQuery('#username').val(),
                    email: jQuery('#email').val(),
                    password: jQuery('#password').val(),
                    questionsData: questionsData
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