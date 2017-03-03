<style>
    label.error {
        color: #D8000C;
    }
</style>
<!-- <script type="text/javascript" src="assets/admin/js/plugins/forms/selects/bootstrap_select.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/admin/js/pages/form_bootstrap_select.js"></script> -->
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users4 position-left"></i> Users</a></li>
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
            <form class="form-horizontal form-validate" action="" id="user_info" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <fieldset class="alpha-primary" style="margin-bottom:5px;padding-left:5px;">
                            <?php 
                                if(isset($user_data['id']) && $user_data['id'] != $this->session->userdata('admin')['id']){
                            ?>
                            <legend class="text-semibold">
                                <i class="icon-lock4 position-left"></i>
                                USER ACCOUNT INFORMATION
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">User Type:</label>
                                <div class="col-lg-4">
                                    <select name="user_role" id="user_role" class="form-control">
                                        <?php if($user_data['user_role'] == 'user'){ ?>
                                            <option selected value="user">User</option>
                                        <?php } else { ?> 
                                            <option value="user">User</option>
                                        <?php } ?>
                                        <?php if($user_data['user_role'] == 'admin'){ ?>
                                            <option value="admin" selected>Admin</option>
                                        <?php } else { ?> 
                                            <option value="admin">Admin</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                            <?php
                            if (!isset($user_data)) {
                                ?>
                                <legend class="text-semibold">
                                    <i class="icon-lock4 position-left"></i>
                                    USER ACCOUNT INFORMATION
                                </legend>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">User Type:</label>
                                    <div class="col-lg-4">
                                        <select name="user_role" id="user_role" class="form-control">
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Email:</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="email_id" id="email_id" placeholder="Enter Email" class="form-control" value="<?php echo set_value('email_id'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Username:</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" value="<?php echo set_value('username'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Password:</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" value="<?php echo set_value('password'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Confirm Password:</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter cofirm password" class="form-control" value="<?php echo set_value('confirm_password'); ?>">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-reading position-left"></i>
                                USER personal INFORMATION
                            </legend> 
                            <div id="demo2" class="collapse in" aria-expanded="true" style="">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">First Name:</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="first_name" id="first_name" placeholder="Enter first name" class="form-control" value="<?php echo (isset($user_data['first_name'])) ? $user_data['first_name'] : set_value('first_name'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Last Name:</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="last_name" id="last_name" placeholder="Enter last name" class="form-control" value="<?php echo (isset($user_data['last_name'])) ? $user_data['last_name'] : set_value('last_name'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Gender:</label>
                                    <div class="col-lg-4">
                                        <input type="radio" name="gender" id="gender" value="0" <?php
                                        if (isset($user_data['gender']) && $user_data['gender'] == 0)
                                            echo 'checked';
                                        else
                                            echo 'checked';
                                        ?>>&nbsp;Male
                                        <input type="radio" name="gender" id="gender" value="1" <?php
                                        if (isset($user_data['gender']) && $user_data['gender'] == 1)
                                            echo 'checked';
                                        else
                                            echo '';
                                        ?>>&nbsp;Female
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Date Of Birth:</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                            <input type="text" value="<?php
                                            if (isset($user_data['date_of_birth']))
                                                echo $user_data['date_of_birth'];
                                            else
                                                echo '1990-01-01';
                                            ?>" class="form-control birth_date" name="date_of_birth" id="date_of_birth">
                                        </div>
                                    </div>
                                </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-phone2 position-left"></i>
                                USER contact INFORMATION
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Country:</label>
                                <div class="col-lg-4">
                                    <select name="country_id" id="country_id" class="form-control" onchange = "get_states();">
                                        <option value="">Country</option>
                                        <?php
                                        if ($countries) {
                                            foreach ($countries as $key => $value) {
                                                if ($value['id'] == $user_data['country_id']) {
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
                            <div class="form-group">
                                <label class="col-lg-2 control-label">State:</label>
                                <div class="col-lg-4">
                                    <select name="state_id" class="form-control" id="state_id" onchange = "get_cities();">
                                        <option value="">State</option>
                                        <?php
                                        if ($states) {
                                            foreach ($states as $key => $value) {
                                                if ($value['id'] == $user_data['state_id']) {
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
                            <div class="form-group">
                                <label class="col-lg-2 control-label">City:</label>
                                <div class="col-lg-4">
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="">City</option>
                                        <?php
                                        if ($cities) {
                                            foreach ($cities as $key => $value) {
                                                if ($value['id'] == $user_data['city_id']) {
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
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Contact Number:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="contact_number"  name="contact_number" value="<?php echo isset($user_data['contact_number']) ? $user_data['contact_number'] : set_value('contact_number'); ?>" class="form-control" placeholder="Contact Number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Street:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="street" id="street" placeholder="Enter street" class="form-control" value="<?php echo (isset($user_data['street'])) ? $user_data['street'] : set_value('street'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">House Number:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="house_number" id="house_number" placeholder="Enter house number" class="form-control" value="<?php echo (isset($user_data['house_number'])) ? $user_data['house_number'] : set_value('house_number'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Zip code:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="zipcode" id="zipcode" placeholder="Enter zip code" class="form-control" value="<?php echo (isset($user_data['zipcode'])) ? $user_data['zipcode'] : set_value('zipcode'); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-semibold">
                                <i class="icon-earth position-left"></i>
                                USER social connections
                            </legend>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Facebook:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="facebook_link" id="facebook_link" value="<?php echo isset($user_data['facebook_link']) ? $user_data['facebook_link'] : 'https://facebook.com/'; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Twitter:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="twitter_link" id="twitter_link" value="<?php echo isset($user_data['twitter_link']) ? $user_data['twitter_link'] : 'http://twitter.com/'; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Instagram:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="instagram_link" id="instagram_link" value="<?php echo isset($user_data['instagram_link']) ? $user_data['instagram_link'] : 'http://instagram.com/'; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">500px:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="500px_link" id="500px_link" value="<?php echo isset($user_data['500px_link']) ? $user_data['500px_link'] : 'http://500px.com/'; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Youpic:</label>
                                <div class="col-lg-4">
                                    <input type="text" name="youpic_link" id="youpic_link" value="<?php echo isset($user_data['youpic_link']) ? $user_data['youpic_link'] : 'https://youpic.com/'; ?>" class="form-control">
                                </div>
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
    $('document').ready(function () {
        user_id = "<?php echo (isset($user_data['id'])) ? $user_data['id'] : ''; ?>";
        if (user_id != '') {
            $("#user_info").validate({
                rules: {
                    first_name: {
                        required: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        lettersonly: true
                    },
                    email_id: {
                        required: true,
                    },
                    gender: {
                        required: true
                    },
                    country_id: {
                        required: true,
                    },
                    zipcode: {
                        maxlength: 10,
                        number: true
                    },
                    contact_number: {
                        phonenumber: true,
                        maxlength: 15
                    },
                    facebook_link: {
                        url: true
                    },
                    twitter_link: {
                        url: true
                    },
                    instagram_link: {
                        url: true
                    },
                    '500px_link': {
                        url: true
                    },
                    youpic_link: {
                        url: true
                    },
                    date_of_birth: {
                        required: true,
                        dateISO: true
                    }
                },
                messages: {
                    "zipcode": {
                        number : "Please enter valid zipcode.",
                        minlength : "Please enter valid zipcode."
                    },
                    "contact_number": {
                        phonenumber : "Please enter valid contact number."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                },
            });
        } else {
            $("#user_info").validate({
                rules: {
                    first_name: {
                        required: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        lettersonly: true
                    },
                    email_id: {
                        required: true,
                    },
                    gender: {
                        required: true
                    },
                    country_id: {
                        required: true,
                    },                    
                    zipcode: {
                        number: true,
                        maxlength: 10
                    },
                    contact_number: {
                        phonenumber: true,
                        maxlength: 15
                    },
                    email_id: {
                        required: true,
                        first_email: true,
                        email: true
                    },
                    username: {
                        required: true,
                        userval: /^[a-z][\w.-]{4,100}$/i,
                        minlength: 5,
                        maxlength: 100
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        equalTo: '#password'
                    },
                    facebook_link: {
                        url: true
                    },
                    twitter_link: {
                        url: true
                    },
                    instagram_link: {
                        url: true
                    },
                    '500px_link': {
                        url: true
                    },
                    youpic_link: {
                        url: true
                    },
                    date_of_birth: {
                        required: true,
                        dateISO: true
                    }
                },
                messages: {
                    username: {
                        required: "Please enter Username",
                        userval: 'Invalid user name',
                        minlength: "Username should be of minimum 5 chars",
                    },
                    "zipcode": {
                        number : "Please enter valid zipcode.",
                        maxlength : "Please enter valid zipcode."
                    },
                    "contact_number": {
                        phonenumber : "Please enter valid contact number.",
                        maxlength : "Please enter valid contact number."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                },
            });
        }
    });

    function get_states() {
        country_id = $('#country_id').val();
        $.ajax({
            url: 'admin/users/get_states',
            type: 'POST',
            data: {country_id: country_id},
            success: function (response) {
                data = JSON.parse(response);
                if (data != '') {
                    str = '<option value="">State</option>';
                    $.each(data, function (i, item) {
                        str += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $('#state_id').val('');
                    $('#city_id').val('');
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
            url: 'admin/users/get_cities',
            type: 'POST',
            data: {state_id: state_id},
            success: function (response) {
                data = JSON.parse(response);
                if (data != '') {
                    str = '<option value="">City</option>';
                    $.each(data, function (i, item) {
                        str += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $('#city_id').val('');
                    $('#city_id').html(str);
                } else {
                    str = '<option value="">No cities found</option>';
                    $('#city_id').html(str);
                }
            }
        });
    }
    $(function () {
        $('.birth_date').daterangepicker({
            singleDatePicker: true,
            maxDate : new Date,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD',
            }
        });
    });
</script>