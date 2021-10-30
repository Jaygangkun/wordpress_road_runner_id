<?php 
?>
<div class="profile-sub-page" id="sp_medical_history">
    <form class="profile-form" id="medical_history">
        <div class="mb-3">
            <label for="medical_history" class="form-label">Medical History</label>
            <textarea class="form-control" name="medical_history" rows="3"><?php echo getUserMetaData($user_meta_data, 'medical_history', 'medical_history')?></textarea>
        </div>
        <div class="text-end">
            <span class="btn btn-blue" id="btn_save">Save</span>
        </div>
    </form>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_medical_history_results">
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
        
        var modal_medical_history_results = $('#modal_medical_history_results');

        $(document).on('click', '#medical_history #btn_save', function() {
            let formData = new FormData($('#medical_history')[0]);
            formData.append('form_name', 'medical_history');
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
                        $(modal_medical_history_results).removeClass('fail');
                        $(modal_medical_history_results).modal('toggle');
                    }
                    else {
                        $(modal_medical_history_results).addClass('fail');
                        $(modal_medical_history_results).modal('toggle');
                    }
                }
            })
        })
    })(jQuery)
</script>