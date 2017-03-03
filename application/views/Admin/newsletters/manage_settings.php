<script type="text/javascript" src="assets/admin/ckeditor/ckeditor.js"></script>
<link href="assets/css/bootstrap-switch.css" rel="stylesheet">
<script src="assets/js/bootstrap/bootstrap-switch.js"></script>
<script src="assets/js/bootstrap/bootstrap-select.min.js" type="text/javascript"></script>
<link href="assets/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">


<script type="text/javascript" src="assets/admin/js/plugins/forms/tags/tagsinput.min.js"></script>
<link href="assets/admin/css/components.css" rel="stylesheet" type="text/css">

<!-- <script type="text/javascript" src="assets/admin/js/pages/form_tags_input.js"></script> -->

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"> -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-gear"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/newsletters'); ?>"><i class="icon-newspaper2 position-left"></i> Newsletters</a></li>
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
            <form class="form-horizontal form-validate" action="" id="newsletter_settings" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-user position-left"></i>
                                WHO ARE RECEIVE THIS NEWSLETTER
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Select country:</label>
                                <div class="col-lg-4">
                                    <input type="hidden" name="newsletter_id_post" value="<?php echo isset($newsletter_settings['country_id']) ? $newsletter_settings['country_id']: ''?>">
                                    <select name="country_id" id="country_id">
                                        <option value="0">
                                            ALL
                                        </option>
                                        <?php 
                                            if(isset($countries)){
                                                foreach ($countries as $key => $value) {
                                                    if(isset($newsletter_settings['country_id'] )){
                                                        if($newsletter_settings['country_id'] == $value['id'] ){
                                                            ?>
                                                                <option selected value="<?php echo $value['id'] ?>">
                                                                    <?php echo $value['name'] ?>
                                                                </option>
                                                            <?php        
                                                        }
                                                    } else {
                                                        ?>

                                                        <?php
                                                    } if($value['id'] == set_value('country_id')){
                                                        ?>
                                                            <option selected value="<?php echo $value['id'] ?>">
                                                                <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php        
                                                    } else {
                                                        ?>
                                                            <option value="<?php echo $value['id'] ?>">
                                                                <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-gear position-left"></i>
                                OTHER SETTINGS
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">
                                    Is auto:
                                </label>
                                <?php
                                    $check_checked = '';
                                    $duration_box = 'display:none;';
                                    if(isset($newsletter_settings['is_auto'])){
                                        if($newsletter_settings['is_auto'] == 1){
                                            $check_checked = 'checked';
                                            $duration_box = 'display:block;';
                                        }
                                    }
                                ?>
                                <div class="col-lg-4">
                                    <div class="checkbox"><label><div class="checker"><span class="<?php echo $check_checked ?>"><input type="checkbox" class="styled" value="1" data-id="''" data-type="show_in_header" name="is_auto" <?php echo $check_checked ?>></span></div></label></div>
                                </div>
                            </div>
                            <?php 
                                $_2_days = $_4_days = $_7_days = $_30_days = '';
                                if(isset($newsletter_settings['is_auto'])){
                                    if($newsletter_settings['duration'] == '2'){
                                        $_2_days = 'checked';
                                    } elseif ($newsletter_settings['duration'] == '4'){
                                        $_4_days = 'checked';
                                    } elseif ($newsletter_settings['duration'] == '7'){
                                        $_7_days = 'checked';
                                    } else {
                                        $_30_days = 'checked';
                                    }

                                    if($_2_days == '' && $_4_days == '' && $_7_days == ''){
                                        $_30_days = 'checked';
                                    }
                                }
                            ?>
                            <div class="form-group" id="duration_box" style="<?php echo $duration_box; ?>"> 
                                <label class="col-lg-2 control-label">
                                    Duration:
                                </label>
                                <div class="col-lg-8">
                                    <label for="">
                                        <strong>
                                            2 days:
                                        </strong>
                                    </label>
                                    <input type="radio" name="duration" data-radio-all-off="true" class="switch-radio2" value="2" <?php echo $_2_days ?>>

                                    <label for="">
                                        <strong>
                                            4 days:
                                        </strong>
                                    </label>
                                    <input type="radio" name="duration" data-radio-all-off="true" class="switch-radio2" value="4" <?php echo $_4_days ?>>
                                    <label for="">
                                        <strong>
                                            7 days:
                                        </strong>
                                    </label>
                                    <input type="radio" name="duration" data-radio-all-off="true" class="switch-radio2" value="7" <?php echo $_7_days ?>>
                                    <label for="">
                                        <strong>
                                            30 days:
                                        </strong>
                                    </label>
                                    <input type="radio" name="duration" data-radio-all-off="true" class="switch-radio2" value="30" <?php echo $_30_days ?>>
                                </div>
                            </div>
                            <div class="form-group" id="latest_box" style="<?php echo $duration_box; ?>"> 
                                <label class="col-lg-2 control-label">
                                    Number of latest spots:
                                </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" name="number_of_spots" value="<?php if(isset($newsletter_settings['no_of_latest_spots'])) echo $newsletter_settings['no_of_latest_spots']; else set_value('number_of_spots'); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-wrench position-left"></i>
                                TESTING SETTINGS
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">
                                    Email ids:
                                </label>
                                <div class="col-lg-10">
                                    <input type="text" value="<?php if(isset($testing_emails[0]['email_ids'])) echo $testing_emails[0]['email_ids']; ?>" class="tags-input" name="testing_emails">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-newspaper2 position-left"></i>
                                CONTENT OF NEWSLETTER
                            </legend>
                            <div class="form-group">
                                <textarea id='newsletter_content' name="newsletter_content" style="margin-bottom: 30px;"><?php echo isset($newsletter_settings['content'])?$newsletter_settings['content']:''; ?></textarea>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php $this->load->view('Templates/admin_footer'); ?>
</div>
<script type="text/javascript">
    $(function(){
        $('.tags-input').tagsinput({
            maxTags: 5,
            trimValue: true
        });

        $('.tags-input').on('beforeItemAdd', function(event) {
            var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,5}|[0-9]{1,3})(\]?)$/;
            if(pattern.test( event.item ) == false){
                event.cancel = true;
            }
        });

        $(".switch-radio2").bootstrapSwitch();
        // $('#newsletter_content').froalaEditor({
        //     toolbarInline: false,
        //     height: 300
        // });
        CKEDITOR.replace('newsletter_content', {
            height: '400px'
        });
        $('select').selectpicker({
            liveSearch : true,
            size: 5
        });
    });

    $(document).on('click','.styled', function () {
        data_type = $(this).data('type');
        data_id = $(this).data('id');
        if($(this).parent().attr('class') == 'checked') {
            $(this).parent().removeClass('checked');
            $(this).prop('checked', false);
            $('#duration_box').hide(500);
            $('#latest_box').hide(500);
        }
        else {
            $(this).parent().addClass('checked');
            $(this).prop('checked', true);
            $('#duration_box').show(500);
            $('#latest_box').show(500);
        }
    });
</script>