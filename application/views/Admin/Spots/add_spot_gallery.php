<style>
    .responstable {
        margin: 1em 0;
        width: 100%;
        overflow: hidden;
        background: #FFF;
        border-radius: 10px;
    }
    .responstable td:last-child {
        display: table-cell;
        text-align: center;
    }
</style>
<!-- <link rel="stylesheet" href="assets/css/blueimp/blueimp-gallery.min.css"> -->
<link rel="stylesheet" href="assets/css/blueimp/jquery.fileupload.css">
<!-- <link rel="stylesheet" href="assets/css/blueimp/jquery.fileupload-ui.css"> -->
<noscript><link rel="stylesheet" href="assets/css/blueimp/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="assets/css/blueimp/jquery.fileupload-ui-noscript.css"></noscript>
<script src="assets/js/blueimp/jquery.ui.widget.js"></script>
<script src="assets/js/blueimp/tmpl.min.js"></script>
<script src="assets/js/blueimp/load-image.all.min.js"></script>
<script src="assets/js/blueimp/canvas-to-blob.min.js"></script>
<script src="assets/js/blueimp/jquery.blueimp-gallery.min.js"></script>
<script src="assets/js/blueimp/jquery.iframe-transport.js"></script>
<script src="assets/js/blueimp/jquery.fileupload.js"></script>
<script src="assets/js/blueimp/jquery.fileupload-process.js"></script>
<script src="assets/js/blueimp/jquery.fileupload-image.js"></script>
<script src="assets/js/blueimp/jquery.fileupload-validate.js"></script>
<script src="assets/js/blueimp/jquery.fileupload-ui.js"></script>
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
            if (isset($user_id)) {
                ?>
                <li><a href="<?php echo site_url('admin/users/spots/' . $user_id); ?>"><i class="icon-images2 position-left"></i> Active spots</a></li>
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
            <div class="login_form upload_images_main background-white">
                <form id="fileupload" action="admin/spots/upload_gallary/<?php echo $slug; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row fileupload-buttonbar">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Add files...</span>
                                    <input type="file" name="files[]" multiple >
                                </span>
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>Start upload</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancel upload</span>
                                </button>
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                            <span class="fileupload-process"></span>
                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-5 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress state -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The table listing the files available for upload/download -->
                    <span class="er" style="font-size: 18px;color: red; margin-bottom: 10px;"></span>
                    <table role="presentation" class="responstable"><tbody class="files"></tbody></table>
                </form>
                <!-- The template to display files available for upload -->
                <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                    <tr class="template-upload fade">
                    <td>
                    <span class="preview"></span>
                    </td>
                    <td>
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                    </td>
                    <td>
                    <p class="size">Processing...</p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                    </td>
                    <td>
                    {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                    </button>
                    {% } %}
                    {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                    </button>
                    {% } %}
                    </td>
                    </tr>
                    {% } %}
                </script>
                <!-- The template to display files available for download -->
                <script id="template-download" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                    <tr class="template-download fade" id="{%=btoa(file.name)%}">
                    <td>
                    <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                    </span>
                    </td>
                    <td>
                    <p class="name">
                    {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                    <span>{%=file.name%}</span>
                    {% } %}
                    </p>
                    {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                    </td>
                    <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                    </td>
                    <td>
                    {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                    {% } else { %}
                    <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                    </button>
                    {% } %}
                    </td>
                    </tr>
                    {% } %}
                </script>
                <a onclick="window.history.back();" class="btn btn-default btn-xl pull-right">Cancel</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'uploads/index/' . $this->uri->segment(3); ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                            data = $this.data();
                    $this
                            .off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        var img_arr = [];
        $('#fileupload').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 1400 * 1000, // 700 KB
            maxNumberOfFiles: 6,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            success: function (response) {
                var resError = response.files[0].error;
                if (typeof (resError) == "undefined") {
                    img_arr.push(window.btoa(response.files.name));
                }
                $("input[name='images_arr']").val(img_arr);
            },
            error: function () {
                console.log("Error");
            }
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>').append($('<span/>').text(file.name));
                if (!index) {
                    node.append('<br>').append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node.prepend(file.preview);
            }
            if (file.error) {
                node.append('<br>');
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    // var link = $('<a>')
                    //         .attr('target', '_blank')
                    //         .prop('href', file.url);
                    // $(data.context.children()[index])
                    // .wrap(link);
                    $(data.context).removeClass('fade');
                } else if (file.error) {
                    $(".er").show().html(file.error);
                    $('.er').delay(5000).fadeOut();
                    data.context.remove();
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function (e, data) {
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
                img_arr.splice(index, 1);
                $("input[name='images_arr']").val(img_arr);

            }
            data.context.remove();
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    var _URL = window.URL || window.webkitURL;
    $("input[name=app_banner]").change(function () {
        var img = $("input[name='app_banner']").val();
        if (img != "") {
            $("#btnBannerContinue").prop("disabled", false)
        } else {
            $("#btnBannerContinue").prop("disabled", true)
        }
        var thisIcon = $(this);
        var file, img, width, height;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                width = this.width;
                height = this.height;
                if (width >= 640) {
                    if (height >= 360) {
                        $('#preview_icon').attr('src', $(this).attr("src"));
                        $("#imgError").hide();
                        thisIcon.removeClass("error-box");
                    } else {
                        thisIcon.val("");
                        $("#imgError").show();
                        thisIcon.addClass("error-box");
                        $('#preview_icon').removeAttr("src");
                        $("#btnBannerContinue").prop("disabled", true)
                    }
                } else {
                    thisIcon.val("");
                    $("#imgError").show();
                    $('#preview_icon').removeAttr("src");
                    thisIcon.addClass("error-box");
                    $("#btnBannerContinue").prop("disabled", true)
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    });
</script>