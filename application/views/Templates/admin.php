<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="favicon.ico" rel='shortcut icon' type='image/x-icon'/>
        <?php 
            $this->load->view('Templates/admin_common_head');
        ?>
        <link href="assets/admin/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
        <!-- Core JS files -->
        <script type="text/javascript" src="assets/admin/js/plugins/loaders/pace.min.js"></script>
        <!-- <script type="text/javascript" src="assets/admin/js/jquery.validate.js"></script> -->
        <!-- /core JS files -->
        <script>
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
        </script>
    </head>
    <body>
    <!-- Main navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo site_url('admin'); ?>"><img width="209" src="assets/images/logo.png" alt=""></a>
            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>
        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/images/uae.png" alt="">
                        <span><?php echo $this->session->userdata('admin')['first_name'].' '.$this->session->userdata('admin')['last_name'] ?></span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="<?php echo site_url('admin/change_password'); ?>"><i class="icon-pencil"></i> Change Password</a></li>
                        <li><a href="<?php echo site_url('admin/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
            <div class="page-content">
            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">
                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="category-content">
                            <div class="media">
                                <a href="#" class="media-left"><img src="assets/images/uae.png" class="img-circle img-sm" alt=""></a>
                                <div class="media-body">
                                    <span class="media-heading text-semibold"><?php echo $this->session->userdata('admin')['first_name'].' '.$this->session->userdata('admin')['last_name'] ?></span>
                                    <div class="text-size-mini text-muted">
                                        <i class="icon-user"></i> &nbsp;Admin
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /user menu -->
                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">
                                <?php 
                                    $controller = $this->router->fetch_class(); 
                                    $action = $this->router->fetch_method(); 
                                ?>
                                <li class="navigation-header"><span>Menu</span><i class="icon-menu" title="Menu"></i> </li>
                                <li class="<?php echo ($controller == 'home') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/home');?>"><i class="icon-home4"></i> <span>Dashboard</span></a>
                                </li>
                                <li class="<?php echo ($controller == 'news') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/news');?>"><i class="icon-newspaper2"></i> <span>News</span></a>
                                </li>
                                <li class="<?php echo ($controller == 'pages') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/pages');?>"><i class=" icon-magazine"></i> <span>Manage Pages</span></a>
                                </li>
                                <li class="<?php echo ($controller == 'header_footer_control') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/header_footer_control');?>"><i class="icon-cog3"></i> <span>Header/Footer Setting</span></a>
                                </li>
                                <li class=""><a href="admin/logout"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->
                </div>
            </div>
            <div class="content-wrapper">
            <!-- Page header -->
            <?php echo $body; ?>
            </div>
        </div>
    </div>
    <!-- <div class="loading"><div class="loading-div"><img src="assets/images/loader1.gif"></div></div> -->
    <!-- /page container -->
</body>
</html>
