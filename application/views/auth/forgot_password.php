<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="login-logo">
    <a href="#"><b>HappyKid</b></a>
</div>

<div class="login-box-body">
    <span style="color: red;"> <?php echo $message; ?> </span>
    <?php echo form_open('auth/forgot_password'); ?>
    <div class="form-group has-feedback">
        <?php echo form_input($emailid); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <?php echo form_input($security_password); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">

        </div>
        <div class="col-xs-4">
            <?php echo form_submit('submit', "Reset", array('class' => 'btn btn-primary btn-block btn-flat')); ?>
        </div>
    </div>
    <?php echo form_close();  ?>
</div>
