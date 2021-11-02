<?php /* Template Name: Report Page Template */ ?>
<?php 
get_header();

?>

<div class="page-report-content">
    <div class="row my-5">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">REPORT</h2>
                    <div class="alert alert-danger" role="alert" id="report_alert_fail" style="display: none"></div>
                    <div class="alert alert-success" role="alert" id="report_alert_success" style="display: none">Success to report</div>
                    <div class="mt-3">
                        <label for="sn" class="form-label">8-Digit Serial #</label>
                        <input type="text" class="form-control" id="sn" maxlength="8" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="pin" class="form-label">5-Digit PIN</label>
                        <input type="text" class="form-control" id="pin" maxlength="5" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="status" class="form-label">Reason</label>
                        <select class="form-select" aria-label="" id="status">
                            <option value="">-- Select --</option>
                            <option value="lost">I lost my ID</option>
                            <option value="stolen">I found someone's ID</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Date</label>
                        <input type="text" id="date" class="form-control boostrap-datepicker" placeholder="">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100" id="report_btn">Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery(".boostrap-datepicker").datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            // container: '#wristband_modal modal-body'
        });

        jQuery(document).on('click', '#report_btn', function() {
            jQuery('#report_alert_success').hide();
            jQuery('#report_alert_fail').hide();
            jQuery.ajax({
                url: wp_admin_url,
                type: 'post',
                data: {
                    action: 'report',
                    sn: jQuery('#sn').val(),
                    pin: jQuery('#pin').val(),
                    status: jQuery('#status').val(),
                    date: jQuery('#date').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.success) {
                        jQuery('#report_alert_success').show();
                    }
                    else {
                        jQuery('#report_alert_fail').text(resp.message);
                        jQuery('#report_alert_fail').show();
                    }
                }
            })
        })
    })
</script>
<?php
get_footer();