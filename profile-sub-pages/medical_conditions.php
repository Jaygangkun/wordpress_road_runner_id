<?php 
?>
<div class="profile-sub-page" id="sp_medical_conditions">
    <h3>Medical Conditions</h3>
    <div class="text-end">
        <span class="btn btn-blue" id="btn_add">Add</span>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Medical Condition</th>
                <th scope="col">Severity</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="medical_conditions_list">
			<?php
            loadMedicalConditions($user_id);
            ?>    
        </tbody>
    </table>
	<!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_medical_conditions" tabindex="-1" aria-labelledby="modal_medical_conditions_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_medical_conditions_label">Add Medical Condition</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_medical_conditions_label">Edit Medical Condition</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
					<form class="profile-form" id="medical_conditions">
						<div class="mb-3">
							<label for="condition" class="form-label">Medical Condition</label>
							<select class="form-select" aria-label="" name="condition">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_medical_conditions as $condition) {
                                    ?>
                                    <option value="<?php echo $condition?>"><?php echo $condition?></option>
                                    <?php
                                }
                                ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="severity" class="form-label">Severity</label>
							<select class="form-select" aria-label="" name="severity">
								<option value="">--Select --</option>
								<?php
                                foreach($const_severities as $severity) {
                                    ?>
                                    <option value="<?php echo $severity?>"><?php echo $severity?></option>
                                    <?php
                                }
                                ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="notes" class="form-label">Notes</label>
							<textarea class="form-control" name="notes" rows="3"></textarea>
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

    <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_medical_conditions_confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal_medical_conditions_confirm_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_medical_conditions_results">
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
</div>
<script>
    (function($){
        var medical_conditions_list_count = <?php echo getUserMetaData($user_meta_data, 'medical_conditions', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'medical_conditions', 'list') ?>;

        var medical_conditions_list = $('#medical_conditions_list');

        var modal_medical_conditions_confirm = $('#modal_medical_conditions_confirm');
        var modal_medical_conditions_results = $('#modal_medical_conditions_results');

        $(document).on('click', '#modal_medical_conditions #btn_save', function() {
            $('#medical_conditions [name="list_index"]').val(-1);
            let formData = new FormData($('#medical_conditions')[0]);
            formData.append('form_name', 'medical_conditions');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('list_count', medical_conditions_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_medical_conditions_results).removeClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');
                        
                        $(medical_conditions_list).html(resp.html);
                        medical_conditions_list_count++;
                    }
                    else {
                        $(modal_medical_conditions_results).addClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');
                    }
                    modal_medical_conditions.toggle();
                }
            })
        })

        $(document).on('click', '#modal_medical_conditions #btn_update', function() {
            let formData = new FormData($('#medical_conditions')[0]);
            formData.append('form_name', 'medical_conditions');
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
                        $(modal_medical_conditions_results).removeClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');

                        $(medical_conditions_list).html(resp.html);
                    }
                    else {
                        $(modal_medical_conditions_results).addClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');
                    }
                    modal_medical_conditions.toggle();
                }
            })
        })

        var modal_medical_conditions = new bootstrap.Modal(document.getElementById('modal_medical_conditions'), {
            keyboard: false
        });
        var $modal_medical_conditions = $('#modal_medical_conditions');

        $(document).on('click', '#sp_medical_conditions #btn_add', function() {
            $($modal_medical_conditions).removeClass('edit');
            $($modal_medical_conditions).find('input').val('');
            $($modal_medical_conditions).find('select').val('');
            $($modal_medical_conditions).find('textarea').val('');

            modal_medical_conditions.toggle();
        })

        $(document).on('click', '.medical-condition-edit-btn', function() {
            var tr = $(this).parents('tr');

            $($modal_medical_conditions).addClass('edit');

            $($modal_medical_conditions).find('[name="condition"]').val($(tr).find('.td-condition').text().trim());
            $($modal_medical_conditions).find('[name="severity"]').val($(tr).find('.td-severity').text().trim());
            $($modal_medical_conditions).find('[name="notes"]').val($(tr).find('.td-notes').text().trim());
            $($modal_medical_conditions).find('[name="list_index"]').val($(tr).attr('index'));

            modal_medical_conditions.toggle();
        })

        $(document).on('click', '.medical-condition-delete-btn', function() {
            var tr = $(this).parents('tr');
            $($modal_medical_conditions).find('[name="list_index"]').val($(tr).attr('index'));
            $(modal_medical_conditions_confirm).modal('toggle');
        })

        $(document).on('click', '#modal_medical_conditions_confirm_btn', function() {
            $(modal_medical_conditions_confirm).modal('toggle');

            let formData = new FormData($('#medical_conditions')[0]);
            formData.append('form_name', 'medical_conditions');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('form_action', 'delete');
            formData.append('list_count', medical_conditions_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_medical_conditions_results).removeClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');

                        $(medical_conditions_list).html(resp.html);

                        medical_conditions_list_count--;
                    }
                    else {
                        $(modal_medical_conditions_results).addClass('fail');
                        $(modal_medical_conditions_results).modal('toggle');
                    }
                }
            })
        })

    })(jQuery)
</script>