<?php 
?>
<div class="profile-sub-page" id="sp_addresses">
    <form class="profile-form" id="addresses">
        <div class="mb-3">
            <label for="type" class="form-label">Address Type</label>
            <select class="form-select" aria-label="" name="type">
                <option value="">-- Select --</option>
                <?php
                $m_type = getUserMetaData($user_meta_data, 'addresses', 'type');
                foreach($const_address_types as $type) {
                    ?>
                    <option <?php echo $m_type == $type ? "selected" : "" ?> value="<?php echo $type?>"><?php echo $type?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" aria-label="" name="country">
                <option value="">-- Select --</option>
                <?php
                $m_country = getUserMetaData($user_meta_data, 'addresses', 'country');
                foreach($const_countries as $country) {
                    ?>
                    <option <?php echo $m_country == $country ? "selected" : "" ?> value="<?php echo $country?>"><?php echo $country?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="line1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" name="line1" aria-describedby="line1" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'line1')?>">
        </div>
        <div class="mb-3">
            <label for="line2" class="form-label">Address Line 2</label>
            <input type="text" class="form-control" name="line2" aria-describedby="line2" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'line2')?>">
        </div>
        <div class="mb-3">
            <label for="line3" class="form-label">Address Line 3</label>
            <input type="text" class="form-control" name="line3" aria-describedby="line3" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'line3')?>">
        </div>
        <div class="mb-3">
            <label for="line4" class="form-label">Address Line 4</label>
            <input type="text" class="form-control" name="line4" aria-describedby="line4" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'line4')?>">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" name="city" aria-describedby="city" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'city')?>">
        </div>
        <div class="mb-3">
            <label for="pcode" class="form-label">Postal Code</label>
            <input type="text" class="form-control" name="pcode" aria-describedby="pcode" value="<?php echo getUserMetaData($user_meta_data, 'addresses', 'pcode')?>">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" name="notes" rows="3"><?php echo getUserMetaData($user_meta_data, 'addresses', 'notes')?></textarea>
        </div>
        <?php
        if($_SESSION['loginUser'] == 'CT') {
            ?>
            <div class="text-end">
                <span class="btn btn-blue" id="btn_save">Save</span>
            </div>
            <?php
        }
        ?>
    </form>
    <?php
    if($_SESSION['loginUser'] == 'CT') {
        ?>
        <div class="modal fade profile-results-modal" tabindex="-1" id="modal_addresses_results">
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
        if($_SESSION['loginUser'] == 'FR') {
            ?>
            $('#addresses input').attr('disabled', true);
            $('#addresses select').attr('disabled', true);
            $('#addresses textarea').attr('disabled', true);
            <?php
        }
        else if($_SESSION['loginUser'] == 'CT'){
            ?>
            var modal_addresses_results = $('#modal_addresses_results');

            $(document).on('click', '#addresses #btn_save', function() {
                let formData = new FormData($('#addresses')[0]);
                formData.append('form_name', 'addresses');
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
                            $(modal_addresses_results).removeClass('fail');
                            $(modal_addresses_results).modal('toggle');
                        }
                        else {
                            $(modal_addresses_results).addClass('fail');
                            $(modal_addresses_results).modal('toggle');
                        }
                    }
                })
            })
            <?php
        }
        ?>
    })(jQuery)
</script>