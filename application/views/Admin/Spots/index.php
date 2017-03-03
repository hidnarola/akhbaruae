<script src="assets/js/bootstrap/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-images2"></i> <span class="text-semibold">Active spots</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
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
        <div class="panel-heading">
            <strong>Filters:</strong>
            <div class="row">
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="txt_location_search" id="txt_location_search" placeholder="Location...">
                </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <!-- <span class="input-group-addon"><i class="icon-calendar22"></i></span> -->
                            <!-- <input type="text" value="" class="form-control created_date" name="txt_created_date" id="txt_created_date"> -->
                            <input class="datepicker form-control created_date" name="txt_created_date" id="txt_created_date" data-date-format="yyyy/mm/dd" placeholder="Created date...">
                        </div>
                    </div>
                <a href="<?php echo site_url('admin/spots/add'); ?>" class="btn btn-success btn-labeled pull-right"><b><i class="icon-plus3"></i></b> Add new spot</a>
            </div>
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
    var created_date = '';
    $(function () {
        bind();
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
        // $('.created_date').val('');
    });
    
    function bind(){
         var table = $('.datatable-basic').dataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            language: {
                search: '<span>Search:</span> _INPUT_',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            order: [[0, "desc"]],
            ajax: {
                'url' : 'admin/spots/list_spots',
                "data" : {
                    'txt_location_search' : $('#txt_location_search').val(),
                    'txt_created_date' : created_date,
                },
                "type" : "GET"
            },
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
                        var status = '<a href="<?php echo site_url('admin/spots/view_gallery'); ?>/'+full.slug+'" class="btn border-info text-info-600 btn-flat btn-icon" type="button"><i class="icon-images2"></i></a>';
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
                            action += '<a href="'+site_url+'admin/spots/edit/' + full.id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm"><i class="icon-pencil3"></i></a>';
                            action += '&nbsp;&nbsp;<a href="'+site_url+'admin/spots/delete/' + full.id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_alert(this);"><i class="icon-cross2"></i></a>'
                        } else {
                            action += '<a href="'+site_url+'admin/spots/activate/' + full.id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"><i class="icon-checkmark"></i></a>'
                        }
                        return action;
                    }
                }
            ]
        });
    }
    $('#txt_location_search').on( 'keyup', function () {
        $(".datatable-basic").dataTable().fnDestroy();
        bind();
    });
    // $('.created_date').daterangepicker({
    //     singleDatePicker: true,
    //     maxDate : new Date,
    //     locale: {
    //         cancelLabel: 'Clear',
    //         format: 'YYYY-MM-DD',
    //     },
    // },
    // function(start, end, label) {
    //     selected_date = start.format('YYYY-MM-DD');
    //     if(selected_date != ''){
    //         created_date = selected_date;             
    //     }
    //     $(".datatable-basic").dataTable().fnDestroy();
    //     bind();
    // });

    // $('.created_date').on('change.daterangepicker', function(ev, picker) {
    //     //do something, like clearing an input
    //     alert(picker.startDate.format('YYYY-MM-DD'));
    // });
    $('.created_date').datepicker({
        dateFormat: "yyyy-mm-dd",
        endDate: new Date,
    }).on('changeDate', function(en) {
        dateText = $(this).val();
        created_date = dateText;             
        $(".datatable-basic").dataTable().fnDestroy();
        bind();
    }).on('change', function(en) {
        dateText = $(this).val();
        created_date = dateText;             
        $(".datatable-basic").dataTable().fnDestroy();
        bind();
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