<?php 
?>
<div class="profile-sub-page" id="sp_insurance">
    <h3>Insurance</h3>
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
                <th scope="col">Type</th>
                <th scope="col">Company</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="insurance_list">
			<?php
            loadInsurances($user_id);
            ?>  
        </tbody>
    </table>
	<!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_insurance" tabindex="-1" aria-labelledby="modal_insurance_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_insurance_label">Add Insurance</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_insurance_label">Edit Insurance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
					<form class="profile-form" id="insurance">
						<div class="mb-3">
							<label for="type" class="form-label">Type</label>
							<select class="form-select" aria-label="" name="type">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_insurance_types as $type) {
                                    ?>
                                    <option value="<?php echo $type?>"><?php echo $type?></option>
                                    <?php
                                }
                                ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="company" class="form-label">Company</label>
							<select class="form-select" aria-label="" name="company">
								<option value="">-- Select --</option>
								<?php
                                foreach($const_insurance_companies as $company) {
                                    ?>
                                    <option value="<?php echo $company?>"><?php echo $company?></option>
                                    <?php
                                }
                                ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="group" class="form-label">Group</label>
							<input type="text" class="form-control" name="group" aria-describedby="group">
							<div id="emailHelp" class="form-text">(ex: 00195700)</div>
						</div>
							
						<div class="mb-3">
							<label for="identification" class="form-label">Identification Number</label>
							<input type="text" class="form-control" name="identification" aria-describedby="identification">
							<div id="emailHelp" class="form-text">(ex: YRM123M45678)</div>
						</div>
						
						<div class="mb-3">
							<label for="additional" class="form-label">Additional Medical Insurance Information</label>
							<textarea class="form-control" name="additional" rows="3"></textarea>
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
        <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_insurance_confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="modal_insurance_confirm_btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade profile-results-modal" tabindex="-1" id="modal_insurance_results">
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
            var insurance_list_count = <?php echo getUserMetaData($user_meta_data, 'insurance', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'insurance', 'list') ?>;

            var insurance_list = $('#insurance_list');

            var modal_insurance_confirm = $('#modal_insurance_confirm');
            var modal_insurance_results = $('#modal_insurance_results');

            $(document).on('click', '#modal_insurance #btn_save', function() {
                $('#insurance [name="list_index"]').val(-1);
                let formData = new FormData($('#insurance')[0]);
                formData.append('form_name', 'insurance');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('list_count', insurance_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_insurance_results).removeClass('fail');
                            $(modal_insurance_results).modal('toggle');
                            
                            $(insurance_list).html(resp.html);
                            insurance_list_count++;
                        }
                        else {
                            $(modal_insurance_results).addClass('fail');
                            $(modal_insurance_results).modal('toggle');
                        }
                        modal_insurance.toggle();
                    }
                })
            })

            $(document).on('click', '#modal_insurance #btn_update', function() {
                let formData = new FormData($('#insurance')[0]);
                formData.append('form_name', 'insurance');
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
                            $(modal_insurance_results).removeClass('fail');
                            $(modal_insurance_results).modal('toggle');

                            $(insurance_list).html(resp.html);
                        }
                        else {
                            $(modal_insurance_results).addClass('fail');
                            $(modal_insurance_results).modal('toggle');
                        }
                        modal_insurance.toggle();
                    }
                })
            })

            var modal_insurance = new bootstrap.Modal(document.getElementById('modal_insurance'), {
                keyboard: false
            });
            var $modal_insurance = $('#modal_insurance');

            $(document).on('click', '#sp_insurance #btn_add', function() {
                $($modal_insurance).removeClass('edit');
                $($modal_insurance).find('input').val('');
                $($modal_insurance).find('select').val('');
                $($modal_insurance).find('textarea').val('');

                modal_insurance.toggle();
            })

            $(document).on('click', '.insurance-edit-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_insurance).addClass('edit');

                $($modal_insurance).find('[name="type"]').val($(tr).find('.td-type').text().trim());
                $($modal_insurance).find('[name="company"]').val($(tr).find('.td-company').text().trim());
                $($modal_insurance).find('[name="group"]').val($(tr).find('.td-group').text().trim());
                $($modal_insurance).find('[name="identification"]').val($(tr).find('.td-identification').text().trim());
                $($modal_insurance).find('[name="additional"]').val($(tr).find('.td-additional').text().trim());
                $($modal_insurance).find('[name="list_index"]').val($(tr).attr('index'));

                modal_insurance.toggle();
            })

            $(document).on('click', '.insurance-delete-btn', function() {
                var tr = $(this).parents('tr');
                $($modal_insurance).find('[name="list_index"]').val($(tr).attr('index'));
                $(modal_insurance_confirm).modal('toggle');
            })

            $(document).on('click', '#modal_insurance_confirm_btn', function() {
                $(modal_insurance_confirm).modal('toggle');

                let formData = new FormData($('#insurance')[0]);
                formData.append('form_name', 'insurance');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('form_action', 'delete');
                formData.append('list_count', insurance_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_insurance_results).removeClass('fail');
                            $(modal_insurance_results).modal('toggle');

                            $(insurance_list).html(resp.html);

                            insurance_list_count--;
                        }
                        else {
                            $(modal_insurance_results).addClass('fail');
                            $(modal_insurance_results).modal('toggle');
                        }
                    }
                })
            })
            <?php
        }
        else if($_SESSION['loginUser'] == 'FR') {
            ?>
            $('#insurance input').attr('disabled', true);
            $('#insurance select').attr('disabled', true);
            $('#insurance textarea').attr('disabled', true);

            var modal_insurance = new bootstrap.Modal(document.getElementById('modal_insurance'), {
                keyboard: false
            });
            var $modal_insurance = $('#modal_insurance');

            $(document).on('click', '.insurance-view-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_insurance).addClass('view');

                $($modal_insurance).find('[name="type"]').val($(tr).find('.td-type').text().trim());
                $($modal_insurance).find('[name="company"]').val($(tr).find('.td-company').text().trim());
                $($modal_insurance).find('[name="group"]').val($(tr).find('.td-group').text().trim());
                $($modal_insurance).find('[name="identification"]').val($(tr).find('.td-identification').text().trim());
                $($modal_insurance).find('[name="additional"]').val($(tr).find('.td-additional').text().trim());
                $($modal_insurance).find('[name="list_index"]').val($(tr).attr('index'));

                modal_insurance.toggle();
            })
            <?php
        }
        ?>
    })(jQuery)
</script>