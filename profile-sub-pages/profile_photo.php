<?php 
?>
<div class="profile-sub-page" id="sp_profile_photo">
    <form class="profile-form" id="profile_photo">
        <div class="text-end">
            <span class="btn btn-blue" id="btn_save">Update</span>
        </div>
        <?php
        $img_url = get_avatar_url($user_id);
        $img_id = getUserMetaData($user_meta_data, 'profile_photo', 'image');
        if( $img_id != '') {
            $img_url = wp_get_attachment_url($img_id);
            $img_url = preg_replace('/ /', '%20', $img_url);
        }
        ?>
        <div class="profile-image-wrap" style="background-image: url(<?php echo $img_url?>)"></div>
        <input type="file" name="profile_img" accept="image/png, image/gif, image/jpeg" />
    </form>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_profile_photo_results">
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
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-image-wrap').css('background-image', 'url(' + e.target.result + ')');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("[name='profile_img']").change(function(){
            readURL(this);
        });

        var modal_profile_photo_results = $('#modal_profile_photo_results');

        $(document).on('click', '#profile_photo #btn_save', function() {
            let formData = new FormData($('#profile_photo')[0]);
            formData.append('user_id', <?php echo $user_id?>);
            formData.append('action', 'update_avatar');
            $.ajax({
                url: wp_admin_url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        $(modal_profile_photo_results).removeClass('fail');
                        $(modal_profile_photo_results).modal('toggle');
                    }
                    else {
                        $(modal_profile_photo_results).addClass('fail');
                        $(modal_profile_photo_results).modal('toggle');
                    }
                }
            })
        })
    })(jQuery)
</script>