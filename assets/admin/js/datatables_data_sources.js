$(function () {
    $('.datatable-ajax-user-list').dataTable({

        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 5 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        },
        processing: true,
        serverSide: true,
        order: [[4, "desc"]],
        ajax: 'admin/users/list_user',
        columns: [
            {
                data: "id",
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
                data: "email_id",
                visible: true
            },
            // {
            //     data: "type",
            //     visible: true
            // },
            {
                data: "created_date",
                visible: true
            }
            // {
            //     data: "is_verified",
            //     visible: true,
            //     searchable: false,
            //     sortable: false,
            //     render: function (data, type, full, meta) {
            //         var status = '<span class="label bg-success">Active</span>';
            //         if (data == '0') {
            //             status = '<span class="label bg-grey">Not Verified</span>';
            //         }
            //         if (full.is_deleted == '1') {
            //             status = '<span class="label bg-danger">Deleted</span>';
            //         }
            //         return status;
            //     }
            // },
            // {
            //     data: "is_deleted",
            //     visible: true,
            //     searchable: false,
            //     sortable: false,
            //     width: 150,
            //     render: function (data, type, full, meta) {
            //         var action = '';
            //         if (full.is_deleted == '0') {
            //             action += '<a href="user/edit/' + full.id + '" class="btn btn-success"><i class="icon-pencil6"></i></a>';
            //             action += '&nbsp;&nbsp;<a href="user/delete/' + full.id + '" class="btn btn-danger"><i class="icon-cross2"></i></a>'
            //         } else {
            //             action += '<a href="user/activate/' + full.id + '" class="btn bg-blue"><i class="icon-checkmark"></i></a>'
            //         }
            //         return action;
            //     }
            // },
        ]
    });

    

});
