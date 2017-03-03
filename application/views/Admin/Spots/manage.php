<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script src="assets/js/dropzone.min.js" type="text/javascript"></script>
<link href="assets/css/dropzone.css" rel="stylesheet" type="text/css">
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-image2"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <?php 
                if(isset($user_id)){
                    ?>
                    <li><a href="<?php echo site_url('admin/users/spots/'.$user_id); ?>"><i class="icon-images2 position-left"></i> Active Spots</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="<?php echo site_url('admin/spots/active'); ?>"><i class="icon-images2 position-left"></i> Active Spots</a></li>
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
    if(isset($error)){
        echo '<div class="alert alert-error alert-danger"><a class="close" data-dismiss="alert">×</a><strong>'.$error.'</strong></div>';
    }
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <!-- Basic layout-->
                <form action="" method="post" id="submit_listing_form" class="validate-form" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <legend class="text-semibold">
                                Descriptions
                            </legend>
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" placeholder="Title" name="title" id="title" data-rule-required="true" value="<?php echo (isset($spot_data['title'])) ? $spot_data['title'] : set_value('title'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea class="form-control" placeholder="Spot Description" rows="8" name="description" id="description"><?php echo (isset($spot_data['description'])) ? $spot_data['description'] : set_value('description'); ?></textarea>
                            </div>
                            <div class="row">
                                <?php 
                                    if(isset($spot_data['spot_image'])){
                                ?>
                                    <div class="col-md-3" style="width:118px;">
                                        <img src="<?php echo base_url(SPOT_GALLARY_THUMB.'/'.$spot_data['spot_image']) ?>" alt="">
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Main Photo:</label>
                                        <div class="uploader">
                                            <input type="file" name="cover_photo" id="cover_photo" class="file-styled">
                                            <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                            <span class="action btn bg-pink-400" style="-moz-user-select: none;">Choose File</span>
                                        </div>
                                        <span class="help-block">Accepted formats: png, jpg, jpeg. Max file size 20MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category:</label>
                                        <select class="form-control" name="category_id" id="category_id" data-rule-required="true"> 
                                            <option value="">Category</option>
                                            <?php 
                                                if($categories){
                                                    foreach ($categories as $key => $value) {
                                                        if($value['id'] == $spot_data['category_id']){
                                                            ?>
                                                                <option selected value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <legend class="text-semibold">
                                Map Position
                            </legend>
                            <div class="form-group">
                                <input style="width:350px;margin-top:10px;" id="pac-input" name="location" class="controls form-control mb30" type="text" placeholder="Enter a location" data-rule-required="true" value="<?php echo (isset($spot_data['location'])) ? $spot_data['location'] : set_value('location'); ?>">
                                <div id="map-canvas" style="height:350px;"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Latitude" id="input-latitude" name="latitude"  data-rule-required="true" value="<?php echo (isset($spot_data['latitude'])) ? $spot_data['latitude'] : set_value('latitude'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Longitude" id="input-longitude" name="longitude" data-rule-required="true" value="<?php echo (isset($spot_data['longitude'])) ? $spot_data['longitude'] : set_value('longitude'); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                                if(!isset($spot_data['id'])){
                            ?>
                            <legend class="text-semibold">
                                Upload gallery
                            </legend>
                            <div action="#" class="dropzone" id="dropzone_remove"></div>
                            <?php } ?>
                            <legend class="text-semibold">
                                Spot features
                            </legend>
                            <div class="row">
                                <div class="form-group">
                                    <?php 
                                        if($amenities){
                                            $ar = array();
                                            foreach ($amenities as $key => $value) {
                                                if(isset($spot_data['amenities'])){
                                                    $ar = explode(',', $spot_data['amenities']);
                                                }
                                                ?>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <label>
                                                                <div class="checker">
                                                                    <?php 
                                                                        if(in_array($value['id'], $ar)){
                                                                    ?>
                                                                        <span class="checked">
                                                                        <input checked type="checkbox" name="amenities[]" id="amenity-<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>" class="styled">

                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                        <span class="">
                                                                        <input type="checkbox" name="amenities[]" id="amenity-<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>" class="styled">

                                                                    <?php 
                                                                        }
                                                                    ?>
                                                                    </span>
                                                                </div>
                                                                <?php echo $value['name'] ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="button" id="btn_submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /basic layout -->
            </div>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script>
    var lat_exist = "<?php echo isset($spot_data['latitude']) ? $spot_data['latitude'] : '' ?>";
    var long_exist = "<?php echo isset($spot_data['longitude']) ? $spot_data['longitude'] : '' ?>";
</script>
<!-- <script src="assets/js/map.js" type="text/javascript"></script> -->
<script src="http://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=AIzaSyBR_zVH9ks9bWwA-8AzQQyD6mkawsfF9AI" type="text/javascript"></script>
<script src="assets/js/map.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="assets/libraries/jquery-google-map/infobox.js"></script>
<script type="text/javascript" src="assets/libraries/jquery-google-map/markerclusterer.js"></script>
<script type="text/javascript" src="assets/libraries/jquery-google-map/jquery-google-map.js"></script> -->
<script type="text/javascript">
    $(document).on('click','.styled', function () {
        if($(this).parent().attr('class') == 'checked') {
            $(this).parent().removeClass('checked');
            $(this).prop('checked', false);
        }
        else {
            $(this).parent().addClass('checked');
            $(this).prop('checked', true);
        }
    });
    $('document').ready(function () {
        spot_id = "<?php echo isset($spot_data['id']) ? $spot_data['id'] : '' ?>";
        if(spot_id != ''){
            $('#btn_submit').on('click', function (){
                if($('#submit_listing_form').valid()){
                    $('#submit_listing_form').submit();
                }
            });
            $("#submit_listing_form").validate({
                rules: {
                    title: {
                        required: true
                    },
                    // country_id: {
                    //     required: true
                    // },
                    // state_id: {
                    //     required: true
                    // },
                    // city_id: {
                    //     required: true
                    // },
                    category_id: {
                        required: true
                    },
                    latitude: {
                        required: true,
                        number: true
                    },
                    longitude: {
                        required: true,
                        number: true
                    },
                    cover_photo: {
                        // required: true,
                        extension: "jpg|png|jpeg",
                        maxFileSize: {
                            "unit": "MB",
                            "size": 20
                        }
                    }
                },
                errorPlacement: function (error, element) {
                    if(element.attr("name") == "cover_photo"){
                        error.insertAfter($(".uploader"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        } else {
            Dropzone.autoDiscover = false;
            // Removable thumbnails
            $("#dropzone_remove").dropzone({
                paramName: "files[]", // The name that will be used to transfer the file
                dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
                maxFilesize: 20, // MB
                addRemoveLinks: true,
                autoProcessQueue: false,
                maxFiles: 5,
                acceptedFiles: '.jpg, .png, .jpeg',
                init: function () {
                    var submitButton = document.querySelector("#btn_submit")
                    myDropzone = this;
                    submitButton.addEventListener("click", function () {
                        if ($('#submit_listing_form').valid()) {
                            $('.loading').show();
                            $('#btn_submit').prop('disabled',true);
                            $('#btn_submit').html('Loading <i class="icon-spinner2 spinner"></i>');
                            var formElement = document.querySelector("#submit_listing_form");
                            var fd = new FormData(formElement);
                            <?php 
                                if($this->input->get('user_id') != '') 
                                    $user_id = $this->input->get('user_id');
                                else 
                                    $user_id = null ;
                            ?>
                            user_id = "<?php echo $user_id ?>";
                            url = 'admin/spots/add';
                            if(user_id != null){
                                url = 'admin/spots/add/?user_id=' + user_id;
                            }
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: fd,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    data = JSON.parse(response);
                                    if(data.insert_id != ''){
                                        if(myDropzone.files.length > 0) {
                                            myDropzone.options.autoProcessQueue = true;
                                            myDropzone.options.url = "admin/spots/upload_gallary/" + data.slug;
                                            myDropzone.processQueue();
                                        } else {
                                            <?php 
                                                $spot_id = $this->uri->segment(4);
                                                $user_id = '';
                                                if($this->uri->segment(5) != '') 
                                                    $user_id = $this->uri->segment(5);
                                                else if($this->input->get('user_id') != '') 
                                                    $user_id = $this->input->get('user_id');
                                                else 
                                                    $user_id = null ;
                                            ?>
                                            user_id = "<?php echo $user_id; ?>";
                                            spot_id = "<?php echo $spot_id; ?>";
                                            if(user_id != '')
                                                window.location.href = 'admin/users/spots/' + user_id;
                                            else
                                                window.location.href = 'admin/spots/active';
                                        }
                                    } else {
                                        alert('Failed to upload, Please try again later!');
                                    }
                                }
                            });
                        }
                    });
                    myDropzone.on("addedfile", function (file) {
                        if (!file.type.match(/image.*/)) {
                            if (file.type.match(/application.zip/)) {
                                myDropzone.emit("thumbnail", file, "path/to/img");
                            } else {
                                myDropzone.emit("thumbnail", file, "path/to/img");
                            }
                        }
                    });
                    myDropzone.on("complete", function (file) {
                        $('.loading').hide();
                        if (file.size > 20*1024*1024) {
                            return false;
                        } else if(!file.type.match('image.*')) {
                            return false;
                        } else {
                            if(file.type == 'image/svg+xml')
                                return false;
                            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                myDropzone.removeFile(file);
                                <?php 
                                    $spot_id = $this->uri->segment(4);
                                    $user_id = '';
                                    if($this->uri->segment(5) != '') 
                                        $user_id = $this->uri->segment(5);
                                    else if($this->input->get('user_id') != '') 
                                        $user_id = $this->input->get('user_id');
                                    else 
                                        $user_id = null ;
                                ?>
                                user_id = "<?php echo $user_id; ?>";
                                spot_id = "<?php echo $spot_id; ?>";
                                if(user_id != '')
                                    window.location.href = 'admin/users/spots/' + user_id;
                                else
                                    window.location.href = 'admin/spots/active';
                            }
                        }
                    });
                },
            });
            $("#submit_listing_form").validate({
                rules: {
                    title: {
                        required: true
                    },
                    // country_id: {
                    //     required: true
                    // },
                    // state_id: {
                    //     required: true
                    // },
                    // city_id: {
                    //     required: true
                    // },
                    category_id: {
                        required: true
                    },
                    latitude: {
                        required: true,
                        number: true
                    },
                    longitude: {
                        required: true,
                        number: true
                    },
                    cover_photo: {
                        required: true,
                        extension: "jpg|png|jpeg",
                        maxFileSize: {
                            "unit": "MB",
                            "size": 20
                        }
                    }
                },
                errorPlacement: function (error, element) {
                    if(element.attr("name") == "cover_photo"){
                        error.insertAfter($(".uploader"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        }
    });

    function get_states() {
        country_id = $('#country_id').val();
        $.ajax({
            url: 'admin/spots/get_states',
            type: 'POST',
            data: {country_id : country_id},
            success: function(response) {
                data = JSON.parse(response);
                if(data != ''){
                    str = '<option value="">State</option>';
                    $.each(data, function(i, item) {
                        str += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#state_id').html(str);
                } else {
                    str = '<option value="">No states found</option>';
                    $('#city_id').html(str);
                }
            }
        });
    }

    function get_cities() {
        state_id = $('#state_id').val();
        $.ajax({
            url: 'admin/spots/get_cities',
            type: 'POST',
            data: {state_id : state_id},
            success: function(response) {
                data = JSON.parse(response);
                if(data != ''){
                    str = '<option value="">City</option>';
                    $.each(data, function(i, item) {
                        str += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#city_id').html(str);
                } else {
                    str = '<option value="">No cities found</option>';
                    $('#city_id').html(str);
                }
            }
        });
    }

    document.getElementById('cover_photo').onchange = function () {
        var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
        $('.filename').html(filename);
    };

</script>