<style>
label.error {
    color: #D8000C;
}
</style>
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<!-- <script type="text/javascript" src="assets/admin/js/core/app.js"></script> -->
<!-- <script type="text/javascript" src="assets/admin/js/pages/editor_ckeditor.js"></script> -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-magazine"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/pages'); ?>"><i class="icon-magazine position-left"></i> Pages</a></li>
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
            <div class="col-md-12">
                <!-- Basic layout-->
                <form action="" method="post" id="page_info" class="validate-form" enctype="multipart/form-data">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Select Parent Page:</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">None</option>
                                    <?php 
                                        if(isset($pages)){
                                            foreach ($pages as $key => $value) {
                                                $selected = '';
                                                if($page_data['parent_id'] == $value['id']){
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                    <option <?php echo $selected; ?> value="<?php echo $value['id'] ?>"><?php echo $value['title']; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Navigation Name:</label>
                                <input type="text" name="navigation_name" id="navigation_name" class="form-control" value="<?php echo isset($page_data['navigation_name']) ? $page_data['navigation_name'] : set_value('navigation_name'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Page Title:</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo isset($page_data['title']) ? $page_data['title'] : set_value('title'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" id="description" rows="4" cols="4">
                                    <?php echo isset($page_data['description']) ? $page_data['description'] : set_value('description'); ?>
                                </textarea>
                            </div>
                            <div class="row">
                                <?php 
                                    if(isset($page_data['banner_image'])){
                                ?>
                                    <div class="col-md-3">
                                        <img heigth="100" width="170" src="<?php echo base_url(PAGE_BANNER.'/'.$page_data['banner_image']) ?>" alt="">
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Banner Image:</label>
                                        <div class="uploader">
                                            <input type="file" name="banner_image" id="banner_image" class="file-styled">
                                            <span class="filename" style="">No file selected</span>
                                            <span class="action btn bg-pink-400" style="">Choose File</span>
                                        </div>
                                        <span class="help-block">Accepted formats: png, jpg, jpeg. Max file size 700Kb</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Button Text:</label>
                                <input type="text" name="ext_txt" id="ext_txt" class="form-control" value="<?php echo isset($page_data['ext_txt']) ? $page_data['ext_txt'] : set_value('ext_txt'); ?>"> 
                            </div>
                            <div class="form-group">
                                <label>Banner Url:</label>
                                <input type="text" name="ext_url" id="ext_url" class="form-control" value="<?php echo isset($page_data['ext_url']) ? $page_data['ext_url'] : set_value('ext_url'); ?>">
                            </div>
                            <div class="form-group">
                                <label>SEO Meta title:</label>
                                <input type="text" name="meta_title" id="meta_title" class="form-control" value="<?php echo isset($page_data['meta_title']) ? $page_data['meta_title'] : set_value('meta_title'); ?>">
                            </div>
                            <div class="form-group">
                                <label>SEO Meta keyword:</label>
                                <input type="text" name="meta_keyword" id="meta_keyword" class="form-control" value="<?php echo isset($page_data['meta_keyword']) ? $page_data['meta_keyword'] : set_value('meta_keyword'); ?>">
                            </div>
                            <div class="form-group">
                                <label>SEO Meta Description:</label>
                                <input type="text" name="meta_description" id="meta_description" class="form-control" value="<?php echo isset($page_data['meta_description']) ? $page_data['meta_description'] : set_value('meta_description'); ?>">
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
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
<script type="text/javascript">
    $('document').ready(function () {
        CKEDITOR.replace('description', {
            height: '400px'
        });
        $("#page_info").validate({
            rules: {
                navigation_name: {
                    required: true,
                },
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                ext_url: {
                    url:true
                },
                meta_title: {
                    required:true
                },
                meta_description: {
                    required:true,
                },
                meta_keyword: {
                    required:true,
                },
                banner_image: {
                    // required: true,
                    extension: "jpg|png|jpeg",
                    maxFileSize: {
                        "unit": "KB",
                        "size": 700
                    }
                }
            },
            errorPlacement: function (error, element) {
                if(element.attr("name") == "banner_image"){
                    error.insertAfter($(".uploader"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    });

    function get_states() {
        country_id = $('#country_id').val();
        $.ajax({
            url: 'admin/users/get_states',
            type: 'POST',
            data: {country_id : country_id},
            success: function(response) {
                data = JSON.parse(response);
                if(data != ''){
                    str = '<option value="">State</option>';
                    $.each(data, function(i, item) {
                        str += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#state_id').val('');
                    $('#city_id').val('');
                    $('#state_id').html(str);
                    // $('#state_id').select2('refresh');
                }
            }
        });
    }

    function get_cities() {
        state_id = $('#state_id').val();
        $.ajax({
            url: 'admin/users/get_cities',
            type: 'POST',
            data: {state_id : state_id},
            success: function(response) {
                data = JSON.parse(response);
                if(data != ''){
                    str = '<option value="">City</option>';
                    $.each(data, function(i, item) {
                        str += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#city_id').val('');
                    $('#city_id').html(str);
                    // $('#city_id').select2('refresh');
                }
            }
        });
    }

    document.getElementById('banner_image').onchange = function () {
       var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
        $('.filename').html(filename);
    };
</script>