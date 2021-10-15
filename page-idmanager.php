<?php /* Template Name: IDManager Page Template */ ?>
<?php 
get_header();

?>

<div class="page-account-content">
    <div class="my-5">
        <div class="card">
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_personal_identification_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_personal_identification" aria-expanded="false" aria-controls="erp_personal_identification">
                                Activate IDs
                            </button>
                        </h2>
                        <div id="erp_personal_identification" class="accordion-collapse collapse" aria-labelledby="erp_personal_identification_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">Please select the Profile you want to Activate your ID to.</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="exampleFormControlInput1" class="form-label">8 Digit Serial Number</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="exampleFormControlInput1" class="form-label">5 Digit PIN</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                    </select>
                                </div>
                                <div class="">
                                    <div class="d-flex justify-content-between mt-3">
                                        <button class="btn btn-outline-secondary">Cancel</button>
                                        <button class="btn btn-blue">Activate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_emergency_contacts_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_emergency_contacts" aria-expanded="false" aria-controls="erp_emergency_contacts">
                                Reassign ID to Profile
                            </button>
                        </h2>
                        <div id="erp_emergency_contacts" class="accordion-collapse collapse" aria-labelledby="erp_emergency_contacts_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_allergies_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_allergies" aria-expanded="false" aria-controls="erp_allergies">
                                Transfer Membership Time
                            </button>
                        </h2>
                        <div id="erp_allergies" class="accordion-collapse collapse" aria-labelledby="erp_allergies_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Transfer Membership Time
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_current_medications_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_current_medications" aria-expanded="false" aria-controls="erp_current_medications">
                                Manage ID Status
                            </button>
                        </h2>
                        <div id="erp_current_medications" class="accordion-collapse collapse" aria-labelledby="erp_current_medications_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Manage ID Status
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="erp_medical_conditions_h">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#erp_medical_conditions" aria-expanded="false" aria-controls="erp_medical_conditions">
                                Manage Nicknames
                            </button>
                        </h2>
                        <div id="erp_medical_conditions" class="accordion-collapse collapse" aria-labelledby="erp_medical_conditions_h" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Manage Nicknames
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