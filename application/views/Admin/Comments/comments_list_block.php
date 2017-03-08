
<div class="table-responsive popular_list">
    <table id="comments_dttable" class="table datatable-basic">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

<script type="text/javascript">
    function confirm_remove(e) {
        swal({
            title: "Are you sure?",
            text: "Do you want to remve this comments?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes"
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
    function confirm_add(e) {
        swal({
            title: "Are you sure?",
            text: "Do you want to add this comments?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes"
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
    $(document).ready(function () {
        //datatables
        $('#comments_dttable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                search: '<span>Filter:</span> _INPUT_',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url() . 'admin/comments/filter_comments/' . $news_id; ?>",
                "type": "POST"
            },

            "columns": [
                {
                    'data': 'sr_no',
                    "visible": true,
                    'bSortable': false
                },
                {
                    data: "author_name",
                    visible: true,
                    'bSortable': false,
                },
                {
                    'data': 'author_email',
                    "visible": true,
                    'bSortable': false
                },
                {
                    'data': 'author_comment',
                    "visible": true,
                    'bSortable': false
                },
                {
                    "visible": true,
                    'bSortable': false,
                    "render": function (data, type, full, meta) {
                        var action = '';
                        if(full.active == 1){
                            action += '<a href="<?php echo base_url() ?>admin/comments/remove/' + full.id + '" class="btn border-danger-400 text-danger-600 btn-flat btn-icon btn-rounded" onclick="return confirm_remove(this);"><i class="icon-cross2"></i></a>';
                        } else {
                            action += '<a href="<?php echo base_url() ?>admin/comments/add/' + full.id + '" class="btn border-primary-400 text-primary-600 btn-flat btn-icon btn-rounded" onclick="return confirm_add(this);"><i class="icon-plus3"></i></a>';
                        }
                        return  action;
                    }
                },
            ],

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],

        });
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });
</script>