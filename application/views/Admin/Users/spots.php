<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-images2"></i> <span class="text-semibold">Active spots</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users position-left"></i> Users</a></li>
            <li class="active">Active spots</li>
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
    <div class="panel panel-flat">
        <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/spots/add/?user_id='.$user_data['id']); ?>" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Add new spot</a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <!-- <th>Address</th> -->
                    <th>Location</th>
                    <!-- <th>Contact Number</th> -->
                    <!-- <th>Email</th> -->
                    <!-- <th>Price</th> -->
                    <th>Created Date</th>
                    <th>Gallery</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script>
    $(function () {
    $('.datatable-basic').dataTable({
        processing: true,
        serverSide: true,
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        order: [[0, "desc"]],
        ajax: 'admin/users/list_spots/'+'<?php echo $user_data['id'] ?>',
        columns: [
            {
                data: "test_id",
                visible: true
            },
            {
                data: "title",
                visible: true
            },
            {
                data: "description",
                visible: true
            },
            {
                data: "location",
                visible: true
            },
            {
                data: "created_date",
                visible: true
            },
            {
                visible: true,
                searchable: false,
                sortable: false,
                render: function (data, type, full, meta) {
                    var status = '<a href="<?php echo site_url('admin/spots/view_gallery'); ?>/'+full.slug+'/<?php echo $user_data['id'] ?>" class="btn border-info text-info-600 btn-flat btn-icon" type="button"><i class="icon-images2"></i></a>';
                    return status;
                }
            },
            {
                data: "spot_status",
                visible: true,
                searchable: false,
                sortable: false,
                render: function (data, type, full, meta) {
                    var status = '<span class="label bg-success">Active</span>';
                    if (full.is_delete  != 0 ) {
                        status = '<span class="label bg-warning">Deleted</span>';
                    }
                    return status;
                }
            },
            {
                data: "is_delete",
                visible: true,
                searchable: false,
                sortable: false,
                width: 200,
                render: function (data, type, full, meta) {
                    var action = '';
                    if (full.is_delete == '0' || full.is_delete == null) {
                        action += '<a href="'+site_url+'admin/spots/edit/' + full.id + '/<?php echo $user_data['id'] ?>" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm"><i class="icon-pencil3"></i></a>';
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/spots/delete/' + full.id + '/<?php echo $user_data['id'] ?>" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded"><i class="icon-cross2"></i></a>'
                    } else {
                        action += '<a href="'+site_url+'admin/spots/activate/' + full.id + '/<?php echo $user_data['id'] ?>" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-checkmark"></i></a>'
                    }
                    return action;
                }
            }
        ]
    });

    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
});
</script>