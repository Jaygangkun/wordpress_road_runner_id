<?php 
?>
<div class="profile-sub-page" id="sp_current_medications">
    <h3>Current Medications</h3>
    <div class="text-end">
        <span class="btn btn-blue" id="btn_add">Add</span>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Dosage</th>
                <th scope="col">Type</th>
                <th scope="col">Frequency</th>
				<th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="current_medications_list">
			<?php
            loadCurrentMedications($user_id);
            ?>        
        </tbody>
    </table>
	<!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_current_medications" tabindex="-1" aria-labelledby="modal_current_medications_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_current_medications_label">Add Current Medication</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_current_medications_label">Edit Current Medication</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
					<form class="profile-form" id="current_medications">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<select class="form-select" aria-label="" name="name">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_current_medication_names as $current_medication_name) {
                                    ?>
                                    <option value="<?php echo $current_medication_name?>"><?php echo $current_medication_name?></option>
                                    <?php
                                }
                            	?>
							</select>
						</div>
						<div class="mb-3">
							<label for="dosage" class="form-label">Dosage: (Example: 100)</label>
							<input type="text" class="form-control" name="dosage" aria-describedby="dosage">
						</div>
						<div class="mb-3">
							<label for="unit" class="form-label">Unit of Measurement</label>
							<select class="form-select" aria-label="" name="unit">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_unit_measurements as $unit_measurement) {
                                    ?>
                                    <option value="<?php echo $unit_measurement?>"><?php echo $unit_measurement?></option>
                                    <?php
                                }
                            	?>
							</select>
						</div>
							
						<div class="mb-3">
							<label for="unit" class="form-label">Type</label>
							<select class="form-select" aria-label="" name="type">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_current_medication_types as $type) {
                                    ?>
                                    <option value="<?php echo $type?>"><?php echo $type?></option>
                                    <?php
                                }
                            	?>
							</select>
						</div>
						
						<div class="mb-3">
							<label for="frequency" class="form-label">Frequency</label>
							<select class="form-select" aria-label="" name="frequency">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_frequencies as $frequency) {
                                    ?>
                                    <option value="<?php echo $frequency?>"><?php echo $frequency?></option>
                                    <?php
                                }
                            	?>
							</select>
						</div>
						<div class="mb-3">
							<label for="reason" class="form-label">Reason for Taking</label>
							<input type="email" class="form-control" name="reason" aria-describedby="reason">
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

    <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_current_medications_confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal_current_medications_confirm_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_current_medications_results">
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
        var current_medications_list_count = <?php echo getUserMetaData($user_meta_data, 'current_medications', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'current_medications', 'list') ?>;

        var current_medications_list = $('#current_medications_list');

        var modal_current_medications_confirm = $('#modal_current_medications_confirm');
        var modal_current_medications_results = $('#modal_current_medications_results');

        $(document).on('click', '#modal_current_medications #btn_save', function() {
            $('#current_medications [name="list_index"]').val(-1);
            let formData = new FormData($('#current_medications')[0]);
            formData.append('form_name', 'current_medications');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('list_count', current_medications_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_current_medications_results).removeClass('fail');
                        $(modal_current_medications_results).modal('toggle');
                        
                        $(current_medications_list).html(resp.html);
                        current_medications_list_count++;
                    }
                    else {
                        $(modal_current_medications_results).addClass('fail');
                        $(modal_current_medications_results).modal('toggle');
                    }
                    modal_current_medications.toggle();
                }
            })
        })

        $(document).on('click', '#modal_current_medications #btn_update', function() {
            let formData = new FormData($('#current_medications')[0]);
            formData.append('form_name', 'current_medications');
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
                        $(modal_current_medications_results).removeClass('fail');
                        $(modal_current_medications_results).modal('toggle');

                        $(current_medications_list).html(resp.html);
                    }
                    else {
                        $(modal_current_medications_results).addClass('fail');
                        $(modal_current_medications_results).modal('toggle');
                    }
                    modal_current_medications.toggle();
                }
            })
        })

        var modal_current_medications = new bootstrap.Modal(document.getElementById('modal_current_medications'), {
            keyboard: false
        });
        var $modal_current_medications = $('#modal_current_medications');

        $(document).on('click', '#sp_current_medications #btn_add', function() {
            $($modal_current_medications).removeClass('edit');
            $($modal_current_medications).find('input').val('');
            $($modal_current_medications).find('select').val('');
            $($modal_current_medications).find('textarea').val('');

            modal_current_medications.toggle();
        })

        $(document).on('click', '.current-medication-edit-btn', function() {
            var tr = $(this).parents('tr');

            $($modal_current_medications).addClass('edit');

            $($modal_current_medications).find('[name="name"]').val($(tr).find('.td-name').text().trim());
            $($modal_current_medications).find('[name="dosage"]').val($(tr).find('.td-dosage').text().trim());
            $($modal_current_medications).find('[name="unit"]').val($(tr).find('.td-unit').text().trim());
            $($modal_current_medications).find('[name="type"]').val($(tr).find('.td-type').text().trim());
            $($modal_current_medications).find('[name="frequency"]').val($(tr).find('.td-frequency').text().trim());
            $($modal_current_medications).find('[name="reason"]').val($(tr).find('.td-reason').text().trim());
			$($modal_current_medications).find('[name="notes"]').val($(tr).find('.td-notes').text().trim());
            $($modal_current_medications).find('[name="list_index"]').val($(tr).attr('index'));

            modal_current_medications.toggle();
        })

        $(document).on('click', '.current-medication-delete-btn', function() {
            var tr = $(this).parents('tr');
            $($modal_current_medications).find('[name="list_index"]').val($(tr).attr('index'));
            $(modal_current_medications_confirm).modal('toggle');
        })

        $(document).on('click', '#modal_current_medications_confirm_btn', function() {
            $(modal_current_medications_confirm).modal('toggle');

            let formData = new FormData($('#current_medications')[0]);
            formData.append('form_name', 'current_medications');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('form_action', 'delete');
            formData.append('list_count', current_medications_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_current_medications_results).removeClass('fail');
                        $(modal_current_medications_results).modal('toggle');

                        $(current_medications_list).html(resp.html);

                        current_medications_list_count--;
                    }
                    else {
                        $(modal_current_medications_results).addClass('fail');
                        $(modal_current_medications_results).modal('toggle');
                    }
                }
            })
        })

    })(jQuery)
</script>