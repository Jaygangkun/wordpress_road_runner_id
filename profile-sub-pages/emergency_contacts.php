<?php 
?>
<div class="profile-sub-page" id="sp_emergency_contacts">
    <h3>Emergency Contacts</h3>
    <div class="text-end">
        <span class="btn btn-blue" id="btn_add">Add</span>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Relationship</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="emergency_contacts_list">
            <?php
            loadEmergencyContacts($user_id);
            ?>            
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade profile-form-modal" id="modal_emergency_contacts" tabindex="-1" aria-labelledby="modal_emergency_contacts_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-add" id="modal_emergency_contacts_label">Add Emergency Contact</h4>
                    <h4 class="modal-title modal-title-edit" id="modal_emergency_contacts_label">Edit Emergency Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="profile-form" id="emergency_contacts">
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
                            <label for="relationship" class="form-label">Relationship</label>
                            <select class="form-select" aria-label="" name="relationship">
                                <option value="">-- Select --</option>
                                <?php
                                foreach($const_relationships as $relationship) {
                                    ?>
                                    <option value="<?php echo $relationship?>"><?php echo $relationship?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                            
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" aria-describedby="phone">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" aria-describedby="email">
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

    <div class="modal fade profile-confirm-modal" tabindex="-1" id="modal_emergency_contacts_confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal_emergency_contacts_confirm_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_emergency_contacts_results">
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
        var emergency_contacts_list_count = <?php echo getUserMetaData($user_meta_data, 'emergency_contacts', 'list') == '' ? 0 : getUserMetaData($user_meta_data, 'emergency_contacts', 'list') ?>;

        var emergency_contacts_list = $('#emergency_contacts_list');

        var modal_emergency_contacts_confirm = $('#modal_emergency_contacts_confirm');
        var modal_emergency_contacts_results = $('#modal_emergency_contacts_results');

        $(document).on('click', '#modal_emergency_contacts #btn_save', function() {
            $('#emergency_contacts [name="list_index"]').val(-1);
            let formData = new FormData($('#emergency_contacts')[0]);
            formData.append('form_name', 'emergency_contacts');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('list_count', emergency_contacts_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_emergency_contacts_results).removeClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');
                        
                        $(emergency_contacts_list).html(resp.html);
                        emergency_contacts_list_count++;
                    }
                    else {
                        $(modal_emergency_contacts_results).addClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');
                    }
                    modal_emergency_contacts.toggle();
                }
            })
        })

        $(document).on('click', '#modal_emergency_contacts #btn_update', function() {
            let formData = new FormData($('#emergency_contacts')[0]);
            formData.append('form_name', 'emergency_contacts');
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
                        $(modal_emergency_contacts_results).removeClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');

                        $(emergency_contacts_list).html(resp.html);
                    }
                    else {
                        $(modal_emergency_contacts_results).addClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');
                    }
                    modal_emergency_contacts.toggle();
                }
            })
        })

        var modal_emergency_contacts = new bootstrap.Modal(document.getElementById('modal_emergency_contacts'), {
            keyboard: false
        });
        var $modal_emergency_contacts = $('#modal_emergency_contacts');

        $(document).on('click', '#sp_emergency_contacts #btn_add', function() {
            $($modal_emergency_contacts).removeClass('edit');
            $($modal_emergency_contacts).find('input').val('');
            $($modal_emergency_contacts).find('select').val('');
            $($modal_emergency_contacts).find('textarea').val('');

            modal_emergency_contacts.toggle();
        })

        $(document).on('click', '.emergency-contact-edit-btn', function() {
            var tr = $(this).parents('tr');

            $($modal_emergency_contacts).addClass('edit');

            $($modal_emergency_contacts).find('[name="first_name"]').val($(tr).find('.td-first-name').text().trim());
            $($modal_emergency_contacts).find('[name="middle_name"]').val($(tr).find('.td-middle-name').text().trim());
            $($modal_emergency_contacts).find('[name="last_name"]').val($(tr).find('.td-last-name').text().trim());
            $($modal_emergency_contacts).find('[name="relationship"]').val($(tr).find('.td-relationship').text().trim());
            $($modal_emergency_contacts).find('[name="phone"]').val($(tr).find('.td-phone').text().trim());
            $($modal_emergency_contacts).find('[name="email"]').val($(tr).find('.td-email').text().trim());
            $($modal_emergency_contacts).find('[name="list_index"]').val($(tr).attr('index'));

            modal_emergency_contacts.toggle();
        })

        $(document).on('click', '.emergency-contact-delete-btn', function() {
            var tr = $(this).parents('tr');
            $($modal_emergency_contacts).find('[name="list_index"]').val($(tr).attr('index'));
            $(modal_emergency_contacts_confirm).modal('toggle');
        })

        $(document).on('click', '#modal_emergency_contacts_confirm_btn', function() {
            $(modal_emergency_contacts_confirm).modal('toggle');

            let formData = new FormData($('#emergency_contacts')[0]);
            formData.append('form_name', 'emergency_contacts');
            formData.append('meta_type', 'list');
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_form');
            formData.append('form_action', 'delete');
            formData.append('list_count', emergency_contacts_list_count);
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_emergency_contacts_results).removeClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');

                        $(emergency_contacts_list).html(resp.html);

                        emergency_contacts_list_count--;
                    }
                    else {
                        $(modal_emergency_contacts_results).addClass('fail');
                        $(modal_emergency_contacts_results).modal('toggle');
                    }
                }
            })
        })

    })(jQuery)
</script>