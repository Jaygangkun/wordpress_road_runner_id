<?php /* Template Name: Profile Page Template */ ?>
<?php 
get_header();

?>

<div class="page-account-content">
    <div class="my-5">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Who Is This Profile For?</h2>
                <p>To begin creating an Emergency Response Profile, please key the First Name and Last Name of the person to which this profile will be assigned.</p>
                <div class="row">
                    <div class="col-6">
                        <label for="exampleFormControlInput1" class="form-label">First Name<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                    <div class="col-6">
                        <label for="exampleFormControlInput1" class="form-label">Last Name<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Activate an Interactive ID to a new ERP?</h2>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                    Yes. I have an Interactive ID(s) that I want to Activate to the ERP that I'm about to create for W. We.
                    </label>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="exampleFormControlInput1" class="form-label">8 Digit Serial Number<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                    <div class="col-6">
                        <label for="exampleFormControlInput1" class="form-label">5 Digit PIN<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                    No. I have not yet received my Interactive ID(s) that I want to Activate to the ERP that I'm about to create for W. We.
                    </label>
                </div>
            </div>
        </div>
        <div class="px-3">
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-outline-secondary">Cancel</button>
                <button class="btn btn-blue">Continue</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">W. We - Emergency Response Profile</h2>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_personal_identification_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_personal_identification" aria-expanded="false" aria-controls="erp_personal_identification">
                                Personal Identification
                            </button>
                        </h2>
                        <div id="erp_personal_identification" class="accordion-collapse collapse" aria-labelledby="erp_personal_identification_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Welcome W.!

                                You are about to embark on an exciting adventure. Yep, you guessed it...you are just moments away from creating your Emergency Response Profile (ERP).

                                Creating your ERP is a pretty quick and painless process. This said, you do not have to complete all sections of information right now. We will securely save all your data for you. You can come back and update it as often as you like.

                                Let's get started...
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_emergency_contacts_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_emergency_contacts" aria-expanded="false" aria-controls="erp_emergency_contacts">
                                Emergency Contacts
                            </button>
                        </h2>
                        <div id="erp_emergency_contacts" class="accordion-collapse collapse" aria-labelledby="erp_emergency_contacts_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Would you like to provide your Emergency Contacts now?
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_allergies_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_allergies" aria-expanded="false" aria-controls="erp_allergies">
                                Allergies
                            </button>
                        </h2>
                        <div id="erp_allergies" class="accordion-collapse collapse" aria-labelledby="erp_allergies_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Allergies
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_current_medications_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_current_medications" aria-expanded="false" aria-controls="erp_current_medications">
                                Current Medications
                            </button>
                        </h2>
                        <div id="erp_current_medications" class="accordion-collapse collapse" aria-labelledby="erp_current_medications_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Current Medications
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_medical_conditions_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_medical_conditions" aria-expanded="false" aria-controls="erp_medical_conditions">
                                Medical Conditions
                            </button>
                        </h2>
                        <div id="erp_medical_conditions" class="accordion-collapse collapse" aria-labelledby="erp_medical_conditions_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Medical Conditions
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_medical_history_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_medical_history" aria-expanded="false" aria-controls="erp_medical_history">
                                Medical History
                            </button>
                        </h2>
                        <div id="erp_medical_history" class="accordion-collapse collapse" aria-labelledby="erp_medical_history_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Medical History
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_insurance_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_insurance" aria-expanded="false" aria-controls="erp_insurance">
                                Insurance
                            </button>
                        </h2>
                        <div id="erp_insurance" class="accordion-collapse collapse" aria-labelledby="erp_insurance_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Insurance
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_physicians_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_physicians" aria-expanded="false" aria-controls="erp_physicians">
                                Physicians
                            </button>
                        </h2>
                        <div id="erp_physicians" class="accordion-collapse collapse" aria-labelledby="erp_physicians_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Physicians
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_addresses_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_addresses" aria-expanded="false" aria-controls="erp_addresses">
                                Addresses
                            </button>
                        </h2>
                        <div id="erp_addresses" class="accordion-collapse collapse" aria-labelledby="erp_addresses_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Addresses
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_profile_photo_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_profile_photo" aria-expanded="false" aria-controls="erp_profile_photo">
                                Profile Photo
                            </button>
                        </h2>
                        <div id="erp_profile_photo" class="accordion-collapse collapse" aria-labelledby="erp_profile_photo_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Profile Photo
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();