<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AkhbarUAE - Admin login</title>
    <!-- Global stylesheets -->
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url(); ?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="assets/admin/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="assets/admin/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/admin/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/admin/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/admin/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/admin/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="assets/admin/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="assets/admin/js/core/app.js"></script>
    <script type="text/javascript" src="assets/admin/js/pages/login_validation.js"></script>
    <!-- /theme JS files -->
</head>
<body class="login-container login-cover">
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content pb-20">
                    <!-- Form with validation -->
                    <form action="" class="form-validate" method="POST">
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-slate-300 text-slate-300"><img src="assets/images/spotashoot.png" alt=""></div>
                                <h5 class="content-group">Welcome to AkhbarUAE <small class="display-block">Login to your account</small></h5>
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
                            } else if(validation_errors()) {
                                ?>
                                    <div class="alert alert-danger">
                                        <a class="close" data-dismiss="alert">×</a>
                                            <?php echo validation_errors(); ?>
                                        </div>
                                <?php
                            }
                            ?>
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" class="form-control" placeholder="Username" name="username" required="required">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
