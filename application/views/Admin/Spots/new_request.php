<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-images2"></i> <span class="text-semibold">New spots requests</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">New spot requests</li>
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
        <table class="table datatable-basic" style="width:100%;">
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
        scrollX: true,
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        order: [[0, "desc"]],
        ajax: 'admin/spots/list_new_request_spots',
        columns: [
            {
                data: "test_id",
                visible: true,
                sortable:false,
            },
            {
                data: "title",
                visible: true
            },
            {
                data: "description",
                visible: true
            },
            // {
            //     data: "address",
            //     visible: true
            // },
            {
                data: "location",
                visible: true
            },
            // {
            //     data: "contact_number",
            //     visible: true
            // },
            // {
            //     data: "email_id",
            //     visible: true
            // },
            // {
            //     data: "price",
            //     visible: true
            // },
            {
                data: "created_date",
                visible: true
            },
            {
                data: "spot_status",
                visible: true,
                searchable: false,
                sortable: false,
                render: function (data, type, full, meta) {
                    var status = '<span class="label bg-grey">Not Approved</span>';
                    if (full.is_delete != 0) {
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
                render: function (data, type, full, meta) {
                    var action = '';
                    if (full.is_delete == '0' || full.is_delete == null) {
                         action += '<a href="'+site_url+'admin/spots/edit/' + full.id + '?redirect=new_request" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm"><i class="icon-pencil3"></i></a>';
                        action += '&nbsp;&nbsp;<a title="Approve spot" href="'+site_url+'admin/spots/approve/' + full.id + '?redirect=true" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class=" icon-thumbs-up2"></i></a>'
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/spots/unapprove/' + full.id + '?redirect=true" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_alert(this);"><i class="icon-thumbs-down2"></i></a>'
                        // action += '&nbsp;&nbsp;<a href="'+site_url+'admin/spots/delete/' + full.id + '?redirect=true" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded"><i class="icon-cross2"></i></a>'
                        action += '&nbsp;&nbsp;<a target="_blank" href="'+site_url+'spot/' + full.slug + '" class="btn border-info text-info-600 btn-flat btn-icon btn-rounded"><i class="icon-eye"></i></a>'
                    } else {
                        action += '<a href="'+site_url+'admin/spots/activate/' + full.id + '?redirect=true" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-checkmark"></i></a>'
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

function confirm_alert(e) {
    swal({
        title: "Are you sure?",
        text: "You will be able to recover this spot!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FF7043",
        confirmButtonText: "Yes, delete it!"
    },
    function (isConfirm) {
        if (isConfirm) {
            window.location.href = $(e).attr('href');
            return true;
        }
        else {
            return false;
        }
    });
    return false;
}
</script>