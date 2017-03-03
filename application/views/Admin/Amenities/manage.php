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
            <h4><i class="icon-primitive-dot"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/amenities'); ?>"><i class="icon-grid2 position-left"></i> Spot Features</a></li>
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
            <form class="form-horizontal form-validate" action="" id="amenit_info" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Feature Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="name" id="name" placeholder="Enter spot feature name" class="form-control" value="<?php echo (isset($amenitie_data['name'])) ? $amenitie_data['name'] : set_value('name'); ?>">
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
        $("#amenit_info").validate({
            rules: {
                name: {
                    required: true
                },
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    });
</script>