<?php /* Template Name: Profile Page Template */ ?>
<?php 
get_header();

$user_id = get_current_user_id();
$user_meta_data = get_user_meta($user_id);

?>

<div class="page-account-content">
    <div class="my-5">
        <div class="card">
            <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_personal_identification">Personal Identification</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_emergency_contacts">Emergency Contacts</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_allergies">Allergies</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_current_medications">Current Medications</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_medical_conditions">Medical Conditions</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_medical_history">Medical History</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_insurance">Insurance</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_physicians">Physicians</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_addresses">Addresses</span>
                        </li>
                        <li class="list-group-item">
                            <span class="btn profile-sub-page-link" sub-page-target="#sp_profile_photo">Profile Photo</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="mt-3">
                        <?php include('profile-sub-pages/personal_identification.php')?>
                        <?php include('profile-sub-pages/emergency_contacts.php')?>
                        <?php include('profile-sub-pages/allergies.php')?>
                        <?php include('profile-sub-pages/current_medications.php')?>
                        <?php include('profile-sub-pages/medical_conditions.php')?>
                        <?php include('profile-sub-pages/medical_history.php')?>
                        <?php include('profile-sub-pages/insurance.php')?>
                        <?php include('profile-sub-pages/physicians.php')?>
                        <?php include('profile-sub-pages/addresses.php')?>
                        <?php include('profile-sub-pages/profile_photo.php')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();