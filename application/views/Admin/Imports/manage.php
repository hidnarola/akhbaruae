<style>
label.error {
    color: #D8000C;
}
</style>
<script type="text/javascript" src="assets/admin/js/plugins/uploaders/fileinput.min.js"></script>
<script type="text/javascript" src="assets/admin/js/pages/uploader_bootstrap.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<!-- <script type="text/javascript" src="assets/admin/js/plugins/forms/selects/bootstrap_select.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/admin/js/pages/form_bootstrap_select.js"></script> -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-upload"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
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
                    <form class="form validate-form" method="post" id="import_data" name="import_data">
                        <div class="form-group">
                            <label class="col-lg-2 control-label text-semibold">Hidden thumbnails:</label>
                            <div class="col-lg-10">
                                <input type="file" class="file-input1" data-show-preview="false" id="userfile" name="userfile">
                                <span class="help-block">Hide file preview thumbnails.</span>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-info btn-labeled btn-xlg pull-right" type="button"><b><i class="icon-download"></i></b> Download file format</button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script>
    $("#import_data").validate({
        rules: {
            spots_file: {
                required: true,
                extension: "csv",
                maxFileSize: {
                    "unit": "KB",
                    "size": 700
                }
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // $(".file-input1").fileinput({
    //     browseLabel: 'Browse',
    //     browseClass: 'btn btn-primary',
    //     uploadClass: 'btn btn-default',
    //     browseIcon: '<i class="icon-file-plus"></i>',
    //     uploadIcon: '<i class="icon-file-upload2"></i>',
    //     removeIcon: '<i class="icon-cross3"></i>',
    //     layoutTemplates: {
    //         icon: '<i class="icon-file-check"></i>'
    //     },
    //     maxFilesNum: 10,
    //     allowedFileExtensions: ["jpg", "gif", "png", "txt"]
    // });


$(function() {
    $('.file-input1').fileinput({
        uploadUrl: "<?php echo site_url() ?>admin/imports/upload_spots", // server upload action
        uploadAsync: true,
        browseLabel: 'Browse',
        browseIcon: '<i class="icon-file-plus"></i>',
        uploadIcon: '<i class="icon-file-upload2"></i>',
        removeIcon: '<i class="icon-cross3"></i>',
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>'
        },
        initialCaption: "No file selected",
        allowedFileExtensions: ["csv"]
    });
});
</script>