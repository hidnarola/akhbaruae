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
    if(validation_errors() != ''){
    ?>
    <div class="content pt0">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">×</a>
        <?php
            echo validation_errors();
        ?>
        </div>
    </div>
    <?php 
    }
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="user_info" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Username: <strong><?php echo $userdata['username'] ?></strong></label>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Password:</label>
                            <div class="col-lg-4">
                                <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" value="<?php echo set_value('password'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Confirm Password:</label>
                            <div class="col-lg-4">
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter cofirm password" class="form-control" value="<?php echo set_value('confirm_password'); ?>">
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $('document').ready(function () {
        $("#user_info").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    equalTo: '#password'
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    });
</script>