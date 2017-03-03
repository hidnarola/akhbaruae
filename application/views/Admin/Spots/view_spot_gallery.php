<script type="text/javascript" src="assets/admin/js/plugins/media/fancybox.min.js"></script>
<script type="text/javascript" src="assets/admin/js/core/app.js"></script>
<script type="text/javascript" src="assets/admin/js/pages/gallery.js"></script>
<script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-images2"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <?php
                if(isset($user_id)){
                    ?>
                        <li><a href="<?php echo site_url('admin/users/spots/'.$user_id); ?>"><i class="icon-images2 position-left"></i> Active spots</a></li>
                    <?php
                } else {
                    ?>
                        <li><a href="<?php echo site_url('admin/spots/active'); ?>"><i class="icon-images2 position-left"></i> Active spots</a></li>
                    <?php
                }
            ?>
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
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="panel-heading text-right">
            <?php
                if(isset($user_id)){
                    ?>
                        <a class="btn btn-success btn-labeled" href="<?php echo base_url('admin/spots/add_spot_gallary/'.$slug.'/'.$user_id); ?>"><b><i class="icon-image2"></i></b> Add new gallery</a>
                    <?php
                } else {
                    ?>
                        <a class="btn btn-success btn-labeled" href="<?php echo base_url('admin/spots/add_spot_gallary/'.$slug); ?>"><b><i class="icon-image2"></i></b> Add new gallery</a>
                    <?php
                }
            ?>
                
            </div>
            <div class="row" id="my_result">
            </div>
            <div id="pagination" class="text-right">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    /**
     *   @event : ready
     *   @uses : load data of my spots.
     *   @author : KAP
     **/
    $('document').ready(function () {
        common_call();
    });

    /**
     *   @event : click
     *   @id : #pagination
     *   @uses : load data on click of #pagination pagination's anchor tag (a).
     *   @author : KAP
     **/
    $("#pagination").on("click", ".pagination a", function (e) {
        e.preventDefault();
        var page = parseInt($(this).attr("data-ci-pagination-page")); //get page number from link
        url = $(this).attr('href');
        var afterComma = url.substr(url.indexOf("?") + 1);
        $.ajax({
            url: '<?php echo site_url(); ?>admin/spots/get_my_gallery/<?php echo $slug ?>?'+ afterComma,
            type: 'GET',
            success: function (data) {
                data = JSON.parse(data);
                str = '';
                load_result(data.result);
                $("#pagination").html(data.pagination);
                $('#my_result').html(str);
            }
        });
    });

    /**
     *   @method : common_call
     *   @uses : common function for ajax call ang get result
     *   @author : KAP
     **/
    function common_call(){
        $.ajax({
            url: '<?php echo site_url(); ?>admin/spots/get_my_gallery/<?php echo $slug ?>',
            type: 'POST',
            success: function(response) {
                data = JSON.parse(response);
                str = '';
                if(data.result != ''){
                    load_result(data.result);
                $("#pagination").html(data.pagination);
                } else {
                    str += '<div class="panel-heading">';
                    str += '<div class="alert alert-info alert-styled-left alert-arrow-left alert-component label-default">';
                    str += '<h6 class="alert-heading">Oops</h6>';
                    str += 'No spot gallery found...';
                    str += '</div>';
                    str += '</div>';
                }
                $('#my_result').html(str);
            }
        });
    }

    /**
     *   @method : load_result
     *   @uses : load data on click of #pagination pagination's anchor tag and on load page event.
     *   @author : KAP
     **/
    function load_result(data){
        $.each(data, function(i, item) {
            str += '<div class="col-lg-3 col-sm-6">';
                str += '<div class="thumbnail">';
                    str += '<div class="thumb">';
                        str += '<img onerror="this.src=\'assets/admin/images/placeholder.jpg\'" src="<?php echo SPOT_GALLARY_MEDIUM ?>/'+item.spot_image_name+'" alt="">';
                            str += '<div class="caption-overflow">';
                                str += '<span>';
                                    str += '<a href="<?php echo SPOT_GALLARY_ORIGINAL ?>/'+item.spot_image_name+'" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>';
                                    str += '<a data-id='+item.id+' onclick="delete_gallery('+item.id+');" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-cross2"></i></a>';
                                str += '</span>';
                            str += '</div>';
                        str += '</div>';
                    str += '</div>';
                str += '</div>';
        })
        return str;
    }

     /**
     *   @method : delete_gallery
     *   @uses : delete gallery image with sweet confirmation box
     *   @author : KAP
     **/
    function delete_gallery(id){
        image_id = id;
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes, delete it!"
        }, function() {
            $.ajax(
                {
                    type: "get",
                    url: "<?php echo base_url() ?>admin/spots/delete_spot_gallery_image/"+image_id,
                    success: function(data){
                        console.log(data);
                    }
                }
            ).done(function(data) {
                swal("Canceled!", "Your image was successfully deleted!", "success");
                common_call();
            })
            .error(function(data) {
                swal("Oops", "We couldn't connect to the server!", "error");
            });
        });
    }
</script>