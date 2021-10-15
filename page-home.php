<?php /* Template Name: Home Page Template */ ?>
<?php 
get_header();

?>

<div class="page-home-content">
    <div class="row my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">FIRST RESPONDER LOGIN</h2>
                    <div class="mt-3">
                        <label for="digitSerial" class="form-label">8-Digit Serial #</label>
                        <input type="text" class="form-control" id="digitSerial" maxlength="8" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="digitPin" class="form-label">5-Digit PIN</label>
                        <input type="text" class="form-control" id="digitPin" maxlength="5" placeholder="">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100">Login</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">CUSTOMER LOGIN</h2>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-blue w-100">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();