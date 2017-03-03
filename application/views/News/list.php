<?php if (!empty($main_post)){ ?>
<a href="news/<?php echo $main_post['id']; ?>" class="homeV1MainPost">
    <img src="<?php echo ($main_post['image'] != '') ? $main_post['image'] : 'assets/images/main_post.jpg'; ?>" alt="Francoise img">
    <div class="overlayBox">
        <div class="homeV1PostDesc">
            <div class="postTime"><?php echo $main_post['published']; ?></div>
            <h3><?php echo $main_post['title']; ?></h3>
        </div>
    </div>
</a>
<?php } ?>
<div class="blogPostWrapper">
    <?php echo $news_list_html; ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.my_pagination > a', function(){
            $('#loader').fadeIn();
            var page = $(this).attr('data-page');
            console.log(page);
            console.log('<?php echo base_url(); ?>more_news/' + page);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>more_news/' + page,
                dataType: 'JSON',
                async: false,
                success: function (data) {
                    $('#loader').fadeIn();
                    if (data.success == 1) {
                        $(document).find('.blogPostWrapper').html(data.html);
                        $(document).find('.blogPostItem p.postText,.blogPostItem h3.postTitle').dotdotdot();
                        $('#loader').fadeOut();
                    }
                }
            });
        });
    });
</script>