<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-users4"></i> <span class="text-semibold">Users</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Users</li>
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
            <a href="<?php echo site_url('admin/users/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-user-plus"></i></b> Add new user</a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Total spots</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Registration Date</th>
                    <th>Is Feature</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script>
    $(document).on('click','.styled', function () {
        data_type = $(this).data('type');
        data_id = $(this).data('id');
        if($(this).parent().attr('class') == 'checked') {
            $(this).parent().removeClass('checked');
            $(this).prop('checked', false);
            value = 0;
        }
        else {
            $(this).parent().addClass('checked');
            $(this).prop('checked', true);
            value = 1;
        }

        $.ajax({
            url: "<?php site_url() ?>admin/users/change_data_status",
            data: { id : data_id, value : value},
            type : "POST",
            success: function(result){
                swal("Success!", "Record successfully updated!", "success");
            }
        });
    });

    $(function () {
    $('.datatable-basic').dataTable({
        scrollX:        true,
        scrollCollapse: true,
        processing: true,
        serverSide: true,
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        order: [[8, "desc"]],
        ajax: 'admin/users/list_user',
        columns: [
            {
                data: "test_id",
                sortable:false,
                visible: true
            },
            {
                data: "first_name",
                visible: true
            },
            {
                data: "last_name",
                visible: true
            },
            {
                data: "username",
                visible: true
            },
            {
                data: "email_id",
                visible: true
            },
            {
                data: "cnt_total",
                visible: true
            },
            {
                data: "type",
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
                    var status;
                    if (full.is_feature == 1 && full.is_delete == 0) {
                        status = '<div class="checkbox"><label><div class="checker"><span class="checked"><input type="checkbox" class="styled" value="1" data-id="'+full.id+'" data-type="show_in_header"></span></div></label></div>';
                    } else if(full.is_feature == 0 && full.is_delete == 0) {
                        status = '<div class="checkbox"><label><div class="checker"><span class=""><input type="checkbox" class="styled" value="1" data-id="'+full.id+'" data-type="show_in_header"></div></label></div>';
                    } else {
                        status = '';
                    }
                    return status;
                }
            },
            {
                data: "status",
                visible: true,
                searchable: false,
                sortable: false,
                render: function (data, type, full, meta) {
                    var status = '<span class="label bg-success">Active</span>';
                    if (data == 'inactive') {
                        status = '<span class="label bg-grey">Not Verified</span>';
                    }
                    if (full.is_delete == '1') {
                        status = '<span class="label bg-danger">Deleted</span>';
                    }
                    if (full.is_delete == '2') {
                        status = '<span class="label bg-warning">Blocked</span>';
                    }
                    return status;
                }
            },
            {
                data: "is_deleted",
                visible: true,
                searchable: false,
                sortable: false,
                render: function (data, type, full, meta) {
                    var action = '';
                    if (full.is_delete == '0' || full.is_delete == null) {
                        action += '<a href="'+site_url+'admin/users/edit/' + full.id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm"><i class="icon-pencil3"></i></a>';
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/users/block/' + full.id + '" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded"><i class="icon-user-block"></i></a>'
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/users/delete/' + full.id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_alert(this);"><i class="icon-cross2"></i></a>'
                    } else if(full.is_delete == 2) {
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/users/activate/' + full.id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-user-plus"></i></a>'
                        action += '&nbsp;&nbsp;<a href="'+site_url+'admin/users/delete/' + full.id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_alert(this);"><i class="icon-cross2"></i></a>'
                    } else {
                        action += '<a href="'+site_url+'admin/users/activate/' + full.id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded are_you_delete"><i class="icon-checkmark"></i></a>'
                    }
                    action += '&nbsp&nbsp<a href="'+site_url+'admin/users/change_password/' + full.id + '" class="btn border-brown text-brown-600 btn-flat btn-icon btn-rounded"><i class="icon-lock2"></i></a>'
                    action += '&nbsp&nbsp<a href="admin/users/spots/'+full.id+'" class="btn border-info text-info-600 btn-flat btn-icon btn-rounded are_you_delete">Manage Spots</a>';
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
        text: "You will not be able to recover this user!",
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