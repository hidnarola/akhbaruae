<html>
    <title>Spotashoot - Admin newslettes in progress</title>
    <head>
        <link href="<?php echo base_url(); ?>assets/images/spotfav.png" rel='shortcut icon' type='image/x-icon'/>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/core/libraries/jquery.min.js"></script>
        <script>
            $( document ).ready(function() {
                newsletter_id = "<?php echo $newsletter_id; ?>";
                type = "<?php echo $type; ?>";
                $.ajax({
                    url: '<?php echo site_url() ?>admin/newsletters/send_newsletter',
                    data : {newsletter_id : newsletter_id, type : type},
                    type : "POST",
                    success : function(result){
                        if(result == 'success'){
                            window.top.close();
                        }
                    }
                });
            }); 
        </script>
        <style>
            body {
                font-family: arial, sans-serif;
                text-align: center;
            }

            p {
                margin: 50px 0 20px;
            }

            .cssload-container {
                width: 100%;
                height: 49px;
                text-align: center;
                color: #ccc;
            }

            .cssload-speeding-wheel {
                width: 49px;
                height: 49px;
                margin: 80px auto;
                border: 3px solid  #ccc;
                color: #ccc;
                border-radius: 50%;
                border-left-color: transparent;
                border-right-color: transparent;
                animation: cssload-spin 575ms infinite linear;
                    -o-animation: cssload-spin 575ms infinite linear;
                    -ms-animation: cssload-spin 575ms infinite linear;
                    -webkit-animation: cssload-spin 575ms infinite linear;
                    -moz-animation: cssload-spin 575ms infinite linear;
            }



            @keyframes cssload-spin {
                100%{ transform: rotate(360deg); transform: rotate(360deg); }
            }

            @-o-keyframes cssload-spin {
                100%{ -o-transform: rotate(360deg); transform: rotate(360deg); }
            }

            @-ms-keyframes cssload-spin {
                100%{ -ms-transform: rotate(360deg); transform: rotate(360deg); }
            }

            @-webkit-keyframes cssload-spin {
                100%{ -webkit-transform: rotate(360deg); transform: rotate(360deg); }
            }

            @-moz-keyframes cssload-spin {
                100%{ -moz-transform: rotate(360deg); transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <div style="color: #ccc;margin-top:50px;">
            Please do not close tab or refresh tab or press back button. Page will automatically close after all newsletters sent to users.
        </div>
    </body>
</html>