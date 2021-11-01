<?php 
?>
<div class="profile-sub-page" id="sp_allergies">
    <h3>Allergies</h3>
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
                <th scope="col">Allergy</th>
                <th scope="col">Severity</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="allergies_list">
            <?php
            loadAllergies($user_id);
            ?>        
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_allergies" tabindex="-1" aria-labelledby="modal_allergies_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_allergies_label">Add Allergy</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_allergies_label">Edit Allergy</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="profile-form" id="allergies">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" aria-label="" name="type">
                            <option value="">-- Select --</option>
                            <?php
                                foreach($const_allergy_types as $type) {
                                    ?>
                                    <option value="<?php echo $type?>"><?php echo $type?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="allergy" class="form-label">Allergy</label>
                        <select class="form-select" aria-label="" name="allergy">
                            <option value="">-- Select --</option>
                            <?php
                                foreach($const_allergies as $allery) {
                                    ?>
                                    <option value="<?php echo $allery?>"><?php echo $allery?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="severity" class="form-label">Severity</label>
                        <select class="form-select" aria-label="" name="severity">
                            <option value="">-- Select --</option>
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
        <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_allergies_confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="modal_allergies_confirm_btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade profile-results-modal" tabindex="-1" id="modal_allergies_results">
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
            var allergies_list_count = <?php echo getUserMetaData($user_meta_data, 'allergies', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'allergies', 'list')?>;

            var allergies_list = $('#allergies_list');

            var modal_allergies_confirm = $('#modal_allergies_confirm');
            var modal_allergies_results = $('#modal_allergies_results');

            $(document).on('click', '#modal_allergies #btn_save', function() {
                $('#allergies [name="list_index"]').val(-1);
                let formData = new FormData($('#allergies')[0]);
                formData.append('form_name', 'allergies');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('list_count', allergies_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_allergies_results).removeClass('fail');
                            $(modal_allergies_results).modal('toggle');
                            
                            $(allergies_list).html(resp.html);
                            allergies_list_count++;
                        }
                        else {
                            $(modal_allergies_results).addClass('fail');
                            $(modal_allergies_results).modal('toggle');
                        }
                        modal_allergies.toggle();
                    }
                })
            })

            $(document).on('click', '#modal_allergies #btn_update', function() {
                let formData = new FormData($('#allergies')[0]);
                formData.append('form_name', 'allergies');
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
                            $(modal_allergies_results).removeClass('fail');
                            $(modal_allergies_results).modal('toggle');

                            $(allergies_list).html(resp.html);
                        }
                        else {
                            $(modal_allergies_results).addClass('fail');
                            $(modal_allergies_results).modal('toggle');
                        }
                        modal_allergies.toggle();
                    }
                })
            })

            var modal_allergies = new bootstrap.Modal(document.getElementById('modal_allergies'), {
                keyboard: false
            });
            var $modal_allergies = $('#modal_allergies');

            $(document).on('click', '#sp_allergies #btn_add', function() {
                $($modal_allergies).removeClass('edit');
                $($modal_allergies).find('input').val('');
                $($modal_allergies).find('select').val('');
                $($modal_allergies).find('textarea').val('');

                modal_allergies.toggle();
            })

            $(document).on('click', '.allergy-edit-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_allergies).addClass('edit');

                $($modal_allergies).find('[name="type"]').val($(tr).find('.td-type').text().trim());
                $($modal_allergies).find('[name="allergy"]').val($(tr).find('.td-allergy').text().trim());
                $($modal_allergies).find('[name="severity"]').val($(tr).find('.td-severity').text().trim());
                $($modal_allergies).find('[name="notes"]').val($(tr).find('.td-notes').text().trim());
                $($modal_allergies).find('[name="list_index"]').val($(tr).attr('index'));

                modal_allergies.toggle();
            })

            $(document).on('click', '.allergy-delete-btn', function() {
                var tr = $(this).parents('tr');
                $($modal_allergies).find('[name="list_index"]').val($(tr).attr('index'));
                $(modal_allergies_confirm).modal('toggle');
            })

            $(document).on('click', '#modal_allergies_confirm_btn', function() {
                $(modal_allergies_confirm).modal('toggle');

                let formData = new FormData($('#allergies')[0]);
                formData.append('form_name', 'allergies');
                formData.append('meta_type', 'list');
                formData.append('user_id', <?php echo $user_id?>);
                formData.append('action', 'update_form');
                formData.append('form_action', 'delete');
                formData.append('list_count', allergies_list_count);
                $.ajax({
                    url: wp_admin_url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.success) {
                            $(modal_allergies_results).removeClass('fail');
                            $(modal_allergies_results).modal('toggle');

                            $(allergies_list).html(resp.html);

                            allergies_list_count--;
                        }
                        else {
                            $(modal_allergies_results).addClass('fail');
                            $(modal_allergies_results).modal('toggle');
                        }
                    }
                })
            })
            <?php
        }
        else if($_SESSION['loginUser'] == 'FR') {
            ?>
            $('#allergies input').attr('disabled', true);
            $('#allergies select').attr('disabled', true);
            $('#allergies textarea').attr('disabled', true);

            var modal_allergies = new bootstrap.Modal(document.getElementById('modal_allergies'), {
                keyboard: false
            });
            var $modal_allergies = $('#modal_allergies');

            $(document).on('click', '.allergy-view-btn', function() {
                var tr = $(this).parents('tr');

                $($modal_allergies).addClass('view');

                $($modal_allergies).find('[name="type"]').val($(tr).find('.td-type').text().trim());
                $($modal_allergies).find('[name="allergy"]').val($(tr).find('.td-allergy').text().trim());
                $($modal_allergies).find('[name="severity"]').val($(tr).find('.td-severity').text().trim());
                $($modal_allergies).find('[name="notes"]').val($(tr).find('.td-notes').text().trim());
                $($modal_allergies).find('[name="list_index"]').val($(tr).attr('index'));

                modal_allergies.toggle();
            })

            <?php
        }
        ?>
        

    })(jQuery)
</script>