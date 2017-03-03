<style>
label.error {
    color: #D8000C;
}
</style>
<!-- <script type="text/javascript" src="assets/admin/js/plugins/forms/selects/bootstrap_select.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/admin/js/pages/form_bootstrap_select.js"></script> -->
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users4 position-left"></i> Users</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<?php
if ($this->session->flashdata('success')) {
    ?>
    <div class="content pt0">
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <strong><?= $this->session->flashdata('success') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('success', false);
} else if ($this->session->flashdata('error')) {
    ?>
    <div class="content pt0">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">×</a>
            <strong><?= $this->session->flashdata('error') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('error', false);
} else {
    echo validation_errors();
}
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form method="post" id="reset_password-form" name="reset_password-form">
                    <div class="background-white p20 mb30">    
                        <div class="row">
                            <div class="form-group col-sm-12"> 
                                    <div class="col-sm-2">
                                        <label>New Password</label>
                                    </div>
                                    <div class="col-sm-6">     
                                        <input type="password" name="new_password" id="new_password" value="" class="form-control" placeholder="New Password">
                                    </div>
                            </div> 
                            <div class="form-group col-sm-12">
                                <div class="form-group col-sm-2">
                                    <label>Confirm Password</label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="password" name="confirm_password" id="confirm_password" value="" class="form-control" placeholder="Confirm Password" data-rule-required="true" data-rule-equalto="#new_password">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <input type="submit" name="reset_submit" id="reset_submit" value="Change Password" class="btn btn-primary btn-xs pull-right">
                            </div>                                    
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $('document').ready(function () {
        $("#reset_password-form").validate({
            rules:
            {
                new_password:{
                        required: true,
                        minlength: 5    
                },
                confirm_password: {
                    required: true,
                    equalTo: '#new_password'

                }
             },
             messages:
             {              
                new_password: {
                    required: "Please enter Password",
                    minlength: "Password should be of minimum 5 chars",
                },
                confirm_password: {
                    required: "Please repeat the entered password",
                    equalTo: "Password mismatch"
                }
             },        
                submitHandler: function(form) {
                    form.submit();
            }

        });
    });

    
</script>