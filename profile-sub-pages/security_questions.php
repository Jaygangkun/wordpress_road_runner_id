<?php 
?>
<div class="profile-sub-page" id="sp_security_questions">
    <h3>Security Questions</h3>
    <?php
    if($_SESSION['loginUser'] == 'CT') {
        ?>
        <div class="text-end">
            <span class="btn btn-blue" id="btn_add">Add</span>
        </div>
        <?php
    }
    ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Question</th>
                <th scope="col">Answer</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="security_questions_list">
            <?php
            loadSecurityQuestions($user_id);
            ?>        
        </tbody>
    </table>
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
                    <?php
                    if($_SESSION['loginUser'] == 'CT') {
                        ?>
                        <button type="button" class="btn btn-blue btn-save" id="btn_save">Add</button>
                        <button type="button" class="btn btn-blue btn-update" id="btn_update">Update</button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    if($_SESSION['loginUser'] == 'CT') {
        ?>
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
        <div class="modal fade profile-results-modal" tabindex="-1" id="modal_security_questions_results">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">Success</div>
                        <div class="alert alert-danger" role="alert">Failed</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<script>
    (function($){
        <?php
        if($_SESSION['loginUser'] == 'CT') {
            ?>
            var security_questions_list_count = <?php echo getUserMetaData($user_meta_data, 'security_questions', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'security_questions', 'list')?>;

            var security_questions_list = $('#security_questions_list');

            var modal_security_questions_confirm = $('#modal_security_questions_confirm');
            var modal_security_questions_results = $('#modal_security_questions_results');

            $(document).on('click', '#modal_security_questions #btn_save', function() {
                $('#security_questions [name="list_index"]').val(-1);
                let formData = new FormData($('#security_questions')[0]);
                formData.append('form_name', 'security_questions');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('list_count', security_questions_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_security_questions_results).removeClass('fail');
                            $(modal_security_questions_results).modal('toggle');
                            
                            $(security_questions_list).html(resp.html);
                            security_questions_list_count++;
                        }
                        else {
                            $(modal_security_questions_results).addClass('fail');
                            $(modal_security_questions_results).modal('toggle');
                        }
                        modal_security_questions.toggle();
                    }
                })
            })

            $(document).on('click', '#modal_security_questions #btn_update', function() {
                let formData = new FormData($('#security_questions')[0]);
                formData.append('form_name', 'security_questions');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_security_questions_results).removeClass('fail');
                            $(modal_security_questions_results).modal('toggle');

                            $(security_questions_list).html(resp.html);
                        }
                        else {
                            $(modal_security_questions_results).addClass('fail');
                            $(modal_security_questions_results).modal('toggle');
                        }
                        modal_security_questions.toggle();
                    }
                })
            })

            var modal_security_questions = new bootstrap.Modal(document.getElementById('modal_security_questions'), {
                keyboard: false
            });
            var $modal_security_questions = $('#modal_security_questions');

            $(document).on('click', '#sp_security_questions #btn_add', function() {
                $($modal_security_questions).removeClass('edit');
                $($modal_security_questions).find('input').val('');
                $($modal_security_questions).find('select').val('');
                $($modal_security_questions).find('textarea').val('');

                modal_security_questions.toggle();
            })

            $(document).on('click', '.security-question-edit-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_security_questions).addClass('edit');

                $($modal_security_questions).find('[name="question"]').val($(tr).find('.td-question').text().trim());
                $($modal_security_questions).find('[name="answer"]').val($(tr).find('.td-answer').text().trim());
                $($modal_security_questions).find('[name="list_index"]').val($(tr).attr('index'));

                modal_security_questions.toggle();
            })

            $(document).on('click', '.security-question-delete-btn', function() {
                var tr = $(this).parents('tr');
                $($modal_security_questions).find('[name="list_index"]').val($(tr).attr('index'));
                $(modal_security_questions_confirm).modal('toggle');
            })

            $(document).on('click', '#modal_security_questions_confirm_btn', function() {
                $(modal_security_questions_confirm).modal('toggle');

                let formData = new FormData($('#security_questions')[0]);
                formData.append('form_name', 'security_questions');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('form_action', 'delete');
                formData.append('list_count', security_questions_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_security_questions_results).removeClass('fail');
                            $(modal_security_questions_results).modal('toggle');

                            $(security_questions_list).html(resp.html);

                            security_questions_list_count--;
                        }
                        else {
                            $(modal_security_questions_results).addClass('fail');
                            $(modal_security_questions_results).modal('toggle');
                        }
                    }
                })
            })
            <?php
        }
        else if($_SESSION['loginUser'] == 'FR') {
            ?>
            $('#security_questions input').attr('disabled', true);
            $('#security_questions select').attr('disabled', true);
            $('#security_questions textarea').attr('disabled', true);

            var modal_security_questions = new bootstrap.Modal(document.getElementById('modal_security_questions'), {
                keyboard: false
            });
            var $modal_security_questions = $('#modal_security_questions');

            $(document).on('click', '.security-question-view-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_security_questions).addClass('view');

                $($modal_security_questions).find('[name="question"]').val($(tr).find('.td-question').text().trim());
                $($modal_security_questions).find('[name="answer"]').val($(tr).find('.td-answer').text().trim());
                $($modal_security_questions).find('[name="list_index"]').val($(tr).attr('index'));

                modal_security_questions.toggle();
            })

            <?php
        }
        ?>
        

    })(jQuery)
</script>