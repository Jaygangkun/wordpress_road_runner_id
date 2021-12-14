<?php 
?>
<div class="profile-sub-page" id="sp_additional_information">
    <form class="profile-form" id="additional_information">
        <div class="mb-3">
            <label for="doctor" class="form-label">Doctor</label>
            <input type="text" class="form-control" name="doctor" aria-describedby="doctor" value="<?php echo getUserMetaData($user_meta_data, 'additional_information', 'doctor')?>">
        </div>
        <div class="mb-3">
            <label for="hospital" class="form-label">Hospital</label>
            <input type="text" class="form-control" name="hospital" aria-describedby="hospital" value="<?php echo getUserMetaData($user_meta_data, 'additional_information', 'hospital')?>">
        </div>
        <div class="mb-3">
            <label for="religion" class="form-label">Religion</label>
            <input type="text" class="form-control" name="religion" aria-describedby="religion" value="<?php echo getUserMetaData($user_meta_data, 'additional_information', 'religion')?>">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" name="notes" rows="3"><?php echo getUserMetaData($user_meta_data, 'additional_information', 'notes')?></textarea>
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
        <div class="modal fade profile-results-modal" tabindex="-1" id="modal_additional_information_results">
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
            $('#additional_information input').attr('disabled', true);
            $('#additional_information select').attr('disabled', true);
            $('#additional_information textarea').attr('disabled', true);
            <?php
        }
        else if($_SESSION['loginUser'] == 'CT'){
            ?>
            var modal_additional_information_results = $('#modal_additional_information_results');
            $(document).on('click', '#additional_information #btn_save', function() {
                let formData = new FormData($('#additional_information')[0]);
                formData.append('form_name', 'additional_information');
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
                            $(modal_additional_information_results).removeClass('fail');
                            $(modal_additional_information_results).modal('toggle');
                        }
                        else {
                            $(modal_additional_information_results).addClass('fail');
                            $(modal_additional_information_results).modal('toggle');
                        }
                    }
                })
            })
            <?php
        }
        ?>
    })(jQuery)
</script>