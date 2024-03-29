<?php /* Template Name: Account Page Template */ ?>
<?php 
get_header();

?>

<div class="page-account-content">
    <div class="my-5">
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="card-title">Profile</h2>
                <?php
                if($_SESSION['loginUser'] == 'CT') {
                    ?>
                    <div class="text-end">
                        <a class="btn btn-blue" href="<?php echo get_permalink(get_page_by_path('account/profile'))?>">Edit Profile</a>
                    </div>
                <?php
                }
                else {
                    ?>
                    <div class="text-end">
                        <a class="btn btn-blue" href="<?php echo get_permalink(get_page_by_path('account/profile'))?>">Info</a>
                    </div>
                    <?php
                }
                ?>
                <div class="erp-list mt-3">
                    <div class="erp-row">
                        <div class="erp-row-wrap">
                            <?php
                            $user_id = get_current_user_id();
                            $user_meta_data = get_user_meta($user_id);

                            // $img_url = get_avatar_url($user_id);
                            $img_url = get_template_directory_uri()."/library/images/erp-no-image.png";
                            $img_id = getUserMetaData($user_meta_data, 'profile_photo', 'image');
                            if( $img_id != '') {
                                $img_url = wp_get_attachment_url($img_id);
                                $img_url = preg_replace('/ /', '%20', $img_url);
                            }
                            ?>
                            <img class="erp-row__img" src="<?php echo $img_url?>">
                            <div class="erp-row-info">
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Name:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'first_name')?> <?php echo getUserMetaData($user_meta_data, 'personal_identification', 'last_name')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Home Phone:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'phone')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">ICE 1:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'ice1')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">ICE 2:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'ice2')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Organ Donor:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'organ_donor')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Ethnicity:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'personal_identification', 'ethnicity')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Allergies:</span>
                                    <span class="erp-info__value">
                                    <?php
                                        $list_count = (int)getUserMetaData($user_meta_data, 'allergies', 'list');
                                        for($index = 0; $index < $list_count; $index ++) {
                                            echo getUserMetaListData($user_meta_data, 'allergies', 'type', $index);
                                            if($index < ($list_count - 1)) {
                                                echo ", ";
                                            }
                                        }
                                    ?>
                                    </span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Medications Taking:</span>
                                    <span class="erp-info__value">
                                    <?php
                                        $list_count = (int)getUserMetaData($user_meta_data, 'current_medications', 'list');
                                        for($index = 0; $index < $list_count; $index ++) {
                                            echo getUserMetaListData($user_meta_data, 'current_medications', 'name', $index);
                                            if($index < ($list_count - 1)) {
                                                echo ", ";
                                            }
                                        }
                                    ?>
                                    </span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Address:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'addresses', 'line1')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'line2')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'line3')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'line4')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'city')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'country')?> <?php echo getUserMetaData($user_meta_data, 'addresses', 'pcode')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Doctor:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'additional_information', 'doctor')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Hospital:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'additional_information', 'hospital')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Religion:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'additional_information', 'religion')?></span>
                                </div>
                                <div class="erp-info-row">
                                    <span class="erp-info__title">Additional Information:</span>
                                    <span class="erp-info__value"><?php echo getUserMetaData($user_meta_data, 'additional_information', 'notes')?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if($_SESSION['loginUser'] == 'CT') {
            ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h2 class="card-title">Emergency IDs</h2>  
                    <div class="text-end">
                        <button class="btn btn-blue" id="add_wristband_modal_btn" style="display: none">Add Emergency ID</button>
                    </div>
                    <div class="wristband-list mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">8 Digit Serial</th>
                                    <th scope="col">5-Digit Pin</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="wristband_list">
                                <?php
                                showWristbands();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="wristband_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title modal-title-new">Add Emergency ID</h3>
                <h3 class="modal-title modal-title-edit">Edit Emergency ID</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="sn" class="form-label">8 Digit Serial</label>
                    <input type="text" class="form-control" id="sn" maxlength="8" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="pin" class="form-label">5 Digit Pin</label>
                    <input type="text" class="form-control" id="pin" maxlength="5" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="stolen">Stolen</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Date</label>
                    <input type="text" id="date" class="form-control boostrap-datepicker" placeholder="">
                </div>
                <input type="hidden" id="wristband_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-blue" id="wristband_add_btn">Add</button>
                <button type="button" class="btn btn-blue" id="wristband_update_btn">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="wristband_confirm_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title modal-title-new">Are you sure to delete?</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" id="wristband_confirm_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="wristband_delete_btn">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){

        function checkWristbandCanAdd() {
            var wristbands_count = jQuery('#wristband_list tr').length;
            if(wristbands_count >= MAX_WRIST_BANDS) {
                jQuery('#add_wristband_modal_btn').hide();
            }
            else {
                jQuery('#add_wristband_modal_btn').show();
            }
        }
        
        checkWristbandCanAdd();
        
        jQuery(".boostrap-datepicker").datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            // container: '#wristband_modal modal-body'
        });

        const wristband_modal = jQuery('#wristband_modal');
        const wristband_confirm_modal = jQuery('#wristband_confirm_modal');

        jQuery(document).on('click', '#add_wristband_modal_btn', function() {
            jQuery(wristband_modal).removeClass('edit');

            jQuery(wristband_modal).find('#sn').val('');
            jQuery(wristband_modal).find('#pin').val('');
            jQuery(wristband_modal).find('#status').val('');
            jQuery(wristband_modal).find('#date').val('');

            jQuery(wristband_modal).modal('toggle');

        })
        jQuery(document).on('click', '#wristband_add_btn', function() {
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'add_wristband',
                    sn: jQuery('#sn').val(),
                    pin: jQuery('#pin').val(),
                    status: jQuery('#status').val(),
                    date: jQuery('#date').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#wristband_list').html(resp.html);
                        checkWristbandCanAdd();
                        jQuery(wristband_modal).modal('toggle');
                    }
                    else {
                        alert(resp.message);
                    }
                }
            })
        })

        jQuery(document).on('click', '.wristband-edit-btn', function() {
            const wristband_row = jQuery(this).parents('tr');
            const wristband_id = jQuery(wristband_row).attr('wristband-id');

            jQuery(wristband_modal).find('#sn').val(jQuery(wristband_row).find('.td-sn').text());
            jQuery(wristband_modal).find('#pin').val(jQuery(wristband_row).find('.td-pin').text());
            jQuery(wristband_modal).find('#status').val(jQuery(wristband_row).find('.td-status span').text().toLowerCase());
            jQuery(wristband_modal).find('#date').val(jQuery(wristband_row).find('.td-date').text());
            jQuery(wristband_modal).find('#wristband_id').val(wristband_id);

            jQuery(wristband_modal).addClass('edit');
            jQuery(wristband_modal).modal('toggle');

        })

        jQuery(document).on('click', '#wristband_update_btn', function() {

            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'update_wristband',
                    wristband_id: jQuery('#wristband_id').val(),
                    sn: jQuery('#sn').val(),
                    pin: jQuery('#pin').val(),
                    status: jQuery('#status').val(),
                    date: jQuery('#date').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#wristband_list').html(resp.html);
                        checkWristbandCanAdd();
                        jQuery(wristband_modal).modal('toggle');
                    }
                    else {
                        alert(resp.message);
                    }
                }
            })
        })

        jQuery(document).on('click', '.wristband-delete-btn', function() {
            const wristband_row = jQuery(this).parents('tr');
            const wristband_id = jQuery(wristband_row).attr('wristband-id');

            jQuery(wristband_confirm_modal).find('#wristband_confirm_id').val(wristband_id);
            jQuery(wristband_confirm_modal).modal('toggle');
        })

        jQuery(document).on('click', '#wristband_delete_btn', function() {
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'delete_wristband',
                    wristband_id: jQuery('#wristband_confirm_id').val(),
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#wristband_list').html(resp.html);
                        checkWristbandCanAdd();
                    }

                    jQuery(wristband_confirm_modal).modal('toggle');
                }
            })
        })
    })

</script>
<?php
get_footer();