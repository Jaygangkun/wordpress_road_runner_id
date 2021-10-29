<?php 
?>
<div class="profile-sub-page" id="sp_personal_identification">
    <form class="profile-form" id="personal_identification">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav_basic_info_tab" data-bs-toggle="tab" data-bs-target="#nav_basic_info" type="button" role="tab" aria-controls="nav_basic_info" aria-selected="true">Basic Information</button>
                <button class="nav-link" id="nav_phy_info_tab" data-bs-toggle="tab" data-bs-target="#nav_phy_info" type="button" role="tab" aria-controls="nav_phy_info" aria-selected="false">Physical Description</button>
                <button class="nav-link" id="nav_gov_info_tab" data-bs-toggle="tab" data-bs-target="#nav_gov_info" type="button" role="tab" aria-controls="nav_gov_info" aria-selected="false">Government ID</button>
            </div>
        </nav>
        <div class="tab-content pt-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav_basic_info" role="tabpanel" aria-labelledby="nav_basic_info_tab">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" aria-describedby="first_name" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'first_name')?>">
                </div>
                <div class="mb-3">
                    <label for="middle_name" class="form-label">Middle Name/Initial</label>
                    <input type="text" class="form-control" name="middle_name" aria-describedby="middle_name" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'middle_name')?>">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" aria-describedby="last_name" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'last_name')?>">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Date of Birth</label>
                    <div class="row">
                        <div class="col-lg-4">
                            <select class="form-select" aria-label="" name="dob_month">
                                <option value="">-- Month --</option>
                                <?php
                                $dob_month = getUserMetaData($user_meta_data, 'personal_identification', 'dob_month');
                                foreach($const_months as $month) {
                                    ?>
                                    <option <?php echo $dob_month == $month ? "selected" : "" ?> value="<?php echo $month?>"><?php echo $month?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-select" aria-label="" name="dob_day">
                                <option value="">-- Day --</option>
                                <?php
                                $dob_day = getUserMetaData($user_meta_data, 'personal_identification', 'dob_day');
                                foreach(range(1, 31) as $day) {
                                    ?>
                                    <option <?php echo $dob_day == $day ? "selected" : "" ?> value="<?php echo $day?>"><?php echo $day?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-select" aria-label="" name="dob_year">
                                <option value="">-- Year --</option>
                                <?php
                                $dob_year = getUserMetaData($user_meta_data, 'personal_identification', 'dob_year');
                                foreach(range(2021, 1901) as $year) {
                                    ?>
                                    <option <?php echo $dob_year == $year ? "selected" : "" ?> value="<?php echo $year?>"><?php echo $year?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" aria-describedby="phone" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'phone')?>">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Language & Mastery</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <select class="form-select" aria-label="" name="language">
                                <option value="">-- Select --</option>
                                <?php
                                $m_language = getUserMetaData($user_meta_data, 'personal_identification', 'language');
                                foreach($const_languages as $language) {
                                    ?>
                                    <option <?php echo $m_language == $language ? "selected" : "" ?> value="<?php echo $language?>"><?php echo $language?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-select" aria-label="" name="language_mastery">
                                <option value="">-- Select --</option>
                                <?php
                                $m_language_mastery = getUserMetaData($user_meta_data, 'personal_identification', 'language_mastery');
                                foreach($const_language_masteries as $language_mastery) {
                                    ?>
                                    <option <?php echo $m_language_mastery == $language_mastery ? "selected" : "" ?> value="<?php echo $language_mastery?>"><?php echo $language_mastery?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav_phy_info" role="tabpanel" aria-labelledby="">
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" aria-label="" name="gender">
                        <option value="">-- Select --</option>
                        <?php
                        $m_gender = getUserMetaData($user_meta_data, 'personal_identification', 'gender');
                        foreach($const_genders as $gender) {
                            ?>
                            <option <?php echo $m_gender == $gender ? "selected" : "" ?> value="<?php echo $gender?>"><?php echo $gender?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="blood_type" class="form-label">Blood Type</label>
                    <select class="form-select" aria-label="" name="blood_type">
                        <option value="">-- Select --</option>
                        <?php
                        $m_blood_type = getUserMetaData($user_meta_data, 'personal_identification', 'blood_type');
                        foreach($const_blood_types as $blood_type) {
                            ?>
                            <option <?php echo $m_blood_type == $blood_type ? "selected" : "" ?> value="<?php echo $blood_type?>"><?php echo $blood_type?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="organ_donor" class="form-label">Organ Donor</label>
                    <select class="form-select" aria-label="" name="organ_donor">
                        <option value="">-- Select --</option>
                        <?php
                        $m_organ_donor = getUserMetaData($user_meta_data, 'personal_identification', 'organ_donor');
                        foreach($const_organ_donors as $organ_donor) {
                            ?>
                            <option <?php echo $m_organ_donor == $organ_donor ? "selected" : "" ?> value="<?php echo $organ_donor?>"><?php echo $organ_donor?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="height" class="form-label">Height</label>
                    <select class="form-select" aria-label="" name="height">
                        <option value="">-- Select --</option>
                        <?php
                        $m_height = getUserMetaData($user_meta_data, 'personal_identification', 'height');
                        foreach($const_heights as $height) {
                            ?>
                            <option <?php echo $m_height == $height ? "selected" : "" ?> value="<?php echo $height?>"><?php echo $height?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight</label>
                    <select class="form-select" aria-label="" name="weight">
                        <option value="">-- Select --</option>
                        <?php
                        $m_weight = getUserMetaData($user_meta_data, 'personal_identification', 'weight');
                        foreach($const_weights as $weight) {
                            ?>
                            <option <?php echo $m_weight == $weight ? "selected" : "" ?> value="<?php echo $weight?>"><?php echo $weight?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hair_color" class="form-label">Hair Color</label>
                    <select class="form-select" aria-label="" name="hair_color">
                        <option value="">-- Select --</option>
                        <?php
                        $m_hair_color = getUserMetaData($user_meta_data, 'personal_identification', 'hair_color');
                        foreach($const_hair_colors as $hair_color) {
                            ?>
                            <option <?php echo $m_hair_color == $hair_color ? "selected" : "" ?> value="<?php echo $hair_color?>"><?php echo $hair_color?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="eye_color" class="form-label">Eye Color</label>
                    <select class="form-select" aria-label="" name="eye_color">
                        <option value="">-- Select --</option>
                        <?php
                        $m_eye_color = getUserMetaData($user_meta_data, 'personal_identification', 'eye_color');
                        foreach($const_eye_colors as $eye_color) {
                            ?>
                            <option <?php echo $m_eye_color == $eye_color ? "selected" : "" ?> value="<?php echo $eye_color?>"><?php echo $eye_color?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ethnicity" class="form-label">Ethnicity</label>
                    <select class="form-select" aria-label="" name="ethnicity">
                        <option value="">-- Select --</option>
                        <?php
                        $m_ethnicity = getUserMetaData($user_meta_data, 'personal_identification', 'ethnicity');
                        foreach($const_ethnicities as $ethnicity) {
                            ?>
                            <option <?php echo $m_ethnicity == $ethnicity ? "selected" : "" ?> value="<?php echo $ethnicity?>"><?php echo $ethnicity?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="tab-pane fade" id="nav_gov_info" role="tabpanel" aria-labelledby="nav_gov_info_tab">
                <div class="mb-3">
                    <label for="drivers_license" class="form-label">Drivers License #</label>
                    <input type="text" class="form-control" name="drivers_license" aria-describedby="drivers_license" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'drivers_license')?>">
                </div>
                <div class="mb-3">
                    <label for="issuing_country" class="form-label">Issuing Country</label>
                    <select class="form-select" aria-label="" name="issuing_country">
                        <option value="">-- Select --</option>
                        <?php
                        $issuing_country = getUserMetaData($user_meta_data, 'personal_identification', 'issuing_country');
                        foreach($const_countries as $country) {
                            ?>
                            <option <?php echo $issuing_country == $country ? "selected" : "" ?> value="<?php echo $country?>"><?php echo $country?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gov_id" class="form-label">Government ID</label>
                    <select class="form-select" aria-label="" name="gov_id">
                        <option value="">-- Select --</option>
                        <?php
                        $m_gov_id = getUserMetaData($user_meta_data, 'personal_identification', 'gov_id');
                        foreach($const_gov_ids as $gov_id) {
                            ?>
                            <option <?php echo $m_gov_id == $gov_id ? "selected" : "" ?> value="<?php echo $gov_id?>"><?php echo $gov_id?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control mt-2" name="gov_id_val" aria-describedby="gov_id_val" value="<?php echo getUserMetaData($user_meta_data, 'personal_identification', 'gov_id_val')?>">
                </div>
            </div>
        </div>
        <div class="text-end">
            <span class="btn btn-blue" id="btn_save">Save</span>
        </div>
    </form>
    <div class="modal fade profile-results-modal" tabindex="-1" id="modal_personal_identification_results">
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
        
        var modal_personal_identification_results = $('#modal_personal_identification_results');

        $(document).on('click', '#personal_identification #btn_save', function() {
            let formData = new FormData($('#personal_identification')[0]);
            formData.append('form_name', 'personal_identification');
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
                        $(modal_personal_identification_results).removeClass('fail');
                        $(modal_personal_identification_results).modal('toggle');
                    }
                    else {
                        $(modal_personal_identification_results).addClass('fail');
                        $(modal_personal_identification_results).modal('toggle');
                    }
                }
            })
        })
    })(jQuery)
</script>