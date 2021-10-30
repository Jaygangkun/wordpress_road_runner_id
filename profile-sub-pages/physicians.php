<?php 
?>
<div class="profile-sub-page" id="sp_physicians">
    <h3>Physicians</h3>
    <div class="text-end">
        <span class="btn btn-blue" id="btn_add">Add</span>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Speciality</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Acttion</th>
            </tr>
        </thead>
        <tbody id="physicians_list">
            <?php
            loadPhysicians($user_id);
            ?> 
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_physicians" tabindex="-1" aria-labelledby="modal_physicians_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_physicians_label">Add Physician</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_physicians_label">Edit Physician</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="profile-form" id="physicians">
                        <div class="mb-3">
                            <label for="speciality" class="form-label">Speciality</label>
                            <select class="form-select" aria-label="" name="speciality">
                                <option value="">-- Select --</option>
                                <?php
                                foreach($const_specialities as $speciality) {
                                    ?>
                                    <option value="<?php echo $speciality?>"><?php echo $speciality?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" aria-describedby="first_name">
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name/Initial</label>
                            <input type="text" class="form-control" name="middle_name" aria-describedby="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" aria-describedby="last_name">
                        </div>
                            
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" aria-describedby="phone">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" aria-describedby="email">
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

    <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_physicians_confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal_physicians_confirm_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_physicians_results">
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
        var physicians_list_count = <?php echo getUserMetaData($user_meta_data, 'physicians', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'physicians', 'list') ?>;

        var physicians_list = $('#physicians_list');

        var modal_physicians_confirm = $('#modal_physicians_confirm');
        var modal_physicians_results = $('#modal_physicians_results');

        $(document).on('click', '#modal_physicians #btn_save', function() {
            $('#physicians [name="list_index"]').val(-1);
            let formData = new FormData($('#physicians')[0]);
            formData.append('form_name', 'physicians');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('list_count', physicians_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_physicians_results).removeClass('fail');
                        $(modal_physicians_results).modal('toggle');
                        
                        $(physicians_list).html(resp.html);
                        physicians_list_count++;
                    }
                    else {
                        $(modal_physicians_results).addClass('fail');
                        $(modal_physicians_results).modal('toggle');
                    }
                    modal_physicians.toggle();
                }
            })
        })

        $(document).on('click', '#modal_physicians #btn_update', function() {
            let formData = new FormData($('#physicians')[0]);
            formData.append('form_name', 'physicians');
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
                        $(modal_physicians_results).removeClass('fail');
                        $(modal_physicians_results).modal('toggle');

                        $(physicians_list).html(resp.html);
                    }
                    else {
                        $(modal_physicians_results).addClass('fail');
                        $(modal_physicians_results).modal('toggle');
                    }
                    modal_physicians.toggle();
                }
            })
        })

        var modal_physicians = new bootstrap.Modal(document.getElementById('modal_physicians'), {
            keyboard: false
        });
        var $modal_physicians = $('#modal_physicians');

        $(document).on('click', '#sp_physicians #btn_add', function() {
            $($modal_physicians).removeClass('edit');
            $($modal_physicians).find('input').val('');
            $($modal_physicians).find('select').val('');
            $($modal_physicians).find('textarea').val('');

            modal_physicians.toggle();
        })

        $(document).on('click', '.physician-edit-btn', function() {
            var tr = $(this).parents('tr');

            $($modal_physicians).addClass('edit');

            $($modal_physicians).find('[name="speciality"]').val($(tr).find('.td-speciality').text().trim());
            $($modal_physicians).find('[name="first_name"]').val($(tr).find('.td-first-name').text().trim());
            $($modal_physicians).find('[name="middle_name"]').val($(tr).find('.td-middle-name').text().trim());
            $($modal_physicians).find('[name="last_name"]').val($(tr).find('.td-last-name').text().trim());
            $($modal_physicians).find('[name="phone"]').val($(tr).find('.td-phone').text().trim());
            $($modal_physicians).find('[name="email"]').val($(tr).find('.td-email').text().trim());
            $($modal_physicians).find('[name="notes"]').val($(tr).find('.td-notes').text().trim());
            $($modal_physicians).find('[name="list_index"]').val($(tr).attr('index'));

            modal_physicians.toggle();
        })

        $(document).on('click', '.physician-delete-btn', function() {
            var tr = $(this).parents('tr');
            $($modal_physicians).find('[name="list_index"]').val($(tr).attr('index'));
            $(modal_physicians_confirm).modal('toggle');
        })

        $(document).on('click', '#modal_physicians_confirm_btn', function() {
            $(modal_physicians_confirm).modal('toggle');

            let formData = new FormData($('#physicians')[0]);
            formData.append('form_name', 'physicians');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('form_action', 'delete');
            formData.append('list_count', physicians_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_physicians_results).removeClass('fail');
                        $(modal_physicians_results).modal('toggle');

                        $(physicians_list).html(resp.html);

                        physicians_list_count--;
                    }
                    else {
                        $(modal_physicians_results).addClass('fail');
                        $(modal_physicians_results).modal('toggle');
                    }
                }
            })
        })

    })(jQuery)
</script>