<?php echo $script;?>
<?php 
    $uri = $_SERVER['REQUEST_URI'];
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //'http://clientapp.narola.online/HD/akhbaruae/news/3'; 
    $cnt = 0;
    function display_replies($temp, $li_cnt){ 
        global $cnt;
?>
        <?php foreach($temp as $k => $v){ ?>
            <li id="comment-<?php echo $k; ?>" class="comment byuser depth-<?php echo $li_cnt; ?>">
                <a id="view-comment-3" class="comment-anchor"></a>
                <article id="div-comment-3" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <img  width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                        </div>
                        <?php if($li_cnt < 3){ ?>
                        <div class="reply">
                            <div>
                                <a class="comment-reply-link" href="javascript:void(0)" onclick="open_modal(<?php echo $v['id']; ?>)"><?php echo lang('reply'); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                    </footer>
                    <div class="comment-wrapper">
                        <cite class="fn"><?php echo $v['author_name']; ?></cite>
                        <span class="comment-metadata">
                            <a href="javascript:void(0);">
                                <time datetime="2015-05-05"><?php echo date('F d, Y',strtotime($v['created'])).' at '.date('g:i a',strtotime($v['created'])); ?></time>
                            </a>
                        </span>
                        <div class="comment-content">
                            <p><?php echo $v['author_comment']; ?></p>
                        </div>
                        <!-- <div>
                            <input type="text" class="form-control" name="txt_reply_<?php echo $v['id']; ?>">
                        </div> -->
                    </div>
                </article>
        <?php 
            global $cnt;
            if(count($v['replies'])>0){
                $cnt++;
                echo '<ol class="children">';
                display_replies($v['replies'], $li_cnt + 1);
            }else{
                for($i=1;$i<=$cnt;$i++){
                    echo "</li></ol>";
                }
                $cnt = 0;
            }
        } 
    ?>
        </li>
<?php
    }
?>

<!--<div class="contentLeft">-->
<div class="singlePostMeta">
    <div class="singlePostTime"><?php echo date('d.m.Y', strtotime($post['published'])); ?></div>
    <h1><?php echo $post['title']; ?></h1>
    <!--<a href="#" class="singlePostCategory"><?php echo $post['site_categories']; ?></a>-->
</div>
<div class="singlePostWrap">
    <div class="singlePostImg">
        <img src="<?php echo ($post['image'] != '') ? $post['image'] : 'assets/images/main_post.jpg'; ?>">
    </div>
    <p><?php echo $post['text']; ?></p>
    <div class="sourceLinks">
        <p class="heading_text"><?php echo lang('source_link'); ?></p>
        <ul>
            <li><a href="<?php echo $post['url'] ?>" target="_blank"><?php echo $post['url'] ?></a></li>
        </ul> 
    </div>
    
    <div class="footerSocial newsSocial">
        <div class="clear">
            <div class="footerSocialItem">
                <a href="javascript:void(0)" class="icon-fb" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>')" title="Facebook Share">
                    <i class="fa fa-facebook"></i>
                    <p><?php echo lang('facebook'); ?></p>
                    <!--<p><?php echo $post['facebook_shares']; ?></p>-->
                </a>
            </div>
            <div class="footerSocialItem">
                <a href="javascript:void(0)" class="icon-google-plus" onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $url; ?>')" title="Google Plus Share">
                    <i class="fa fa-google-plus"></i>
                    <p><?php echo lang('gplus'); ?></p>
                    <!--<p><?php echo $post['gplus_shares']; ?></p>-->
                </a>
            </div>
            <div class="footerSocialItem">
                <a href="javascript:void(0)" class="icon-linked_in" onclick="javascript:genericSocialShare('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>')" title="LinkedIn Share">
                    <i class="fa fa-linkedin"></i>
                    <p><?php echo lang('linked_in'); ?></p>
                    <!--<p><?php echo $post['linkedin_shares']; ?></p>-->
                </a>
            </div>
            <!--
            <div class="footerSocialItem">
                <a href="javascript:void(0);" class="icon-pinterest" onclick="javascript:genericSocialShare('http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>')" title="Piterest">
                    <i class="fa fa-pinterest"></i>
                    <p><?php echo lang('pinterest'); ?></p>
                    <p><?php echo $post['pinterest_shares']; ?></p>
                </a>
            </div>
            <div class="footerSocialItem">
                <a href="javascript:void(0)" class="icon-fb" onclick="javascript:genericSocialShare('http://vk.com/share.php?url=<?php echo $url; ?>')" title="Facebook Share">
                    <i class="fa fa-vk"></i>
                    <p><?php echo lang('vk'); ?></p>
                    <p><?php echo $post['vk_shares']; ?></p>
                </a>
            </div>
            <div class="footerSocialItem">
                <a href="javascript:void(0)" class="icon-fb" onclick="javascript:genericSocialShare('http://www.stumbleupon.com/submit?url=<?php echo $url; ?>')" title="Stumbled Upon Share">
                    <i class="fa fa-stumbleupon"></i>
                    <p><?php echo lang('stumbleupon'); ?></p>
                    <p><?php echo $post['stumbledupon_shares']; ?></p>
                </a>
            </div>
            -->
        </div>
    </div>
</div>

<!-- Comment Box -->
<div id="comments" class="commentsBox">
    <h2 class="comments-title"><?php echo count($commArr) . ' ' . lang('comments'); ?></h2>
    <ol class="comment-list commentList">
        <?php display_replies($commArr,1); ?>
    </ol>

    <div id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title"><?php echo lang('post_comment'); ?></h3>
        <form id="commentform" action="news/add_comment/<?php echo $post['id']; ?>" method="post" class="comment-form" novalidate="" onSubmit="return comment_form_validate()" >
            <p class="comment-form-author">
                <label><?php echo lang('name'); ?>*</label>
                <input id="txt_author_name" type="text" class="<?php if(form_error('txt_author_name')!=''){ echo 'custom_error_msg_border'; } ?>" aria-required="true" size="30" value="<?php echo set_value('txt_author_name'); ?>" name="txt_author_name">
                <span id="txt_author_name-error"><?php echo form_error('txt_author_name') ?></span>
            </p>
            <p class="comment-form-email">
                <label><?php echo lang('email'); ?>*</label>
                <input id="txt_author_email" type="text" class="<?php if(form_error('txt_author_email')!=''){ echo 'custom_error_msg_border'; } ?>" placeholder="" aria-required="true" size="30" value="<?php echo set_value('txt_author_email'); ?>" name="txt_author_email">
                <span id="txt_author_email-error"><?php echo form_error('txt_author_email') ?></span>
            </p>

            <p class="comment-form-comment">
                <label><?php echo lang('your_comment'); ?>*</label>
                <textarea id="txt_author_comment" placeholder="" aria-required="true" rows="8" cols="45" name="txt_author_comment"><?php echo set_value('txt_author_comment'); ?></textarea>
                <span id="txt_author_comment-error"><?php echo form_error('txt_author_comment') ?></span>
            </p>
            <?php echo $comment_widget;?>
            <p class="form-submit clear">
                <input id="submit" class="submit" type="submit" value="<?php echo lang('add_comment'); ?>" name="submit">
            </p>
        </form>
    </div>
</div>
<!-- /Comment Box -->

<!-- Reply Popup -->
<div id="reply-form" class="commentsBox" style="display:none">
    <div id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title"><?php echo lang('post_reply'); ?></h3>
        <form id="commentform" action="news/add_comment/<?php echo $post['id']; ?>" method="post" class="comment-form" novalidate="">
            <p class="comment-form-author">
                <label><?php echo lang('name'); ?>*</label>
                <input id="txt_author_name" type="text" class="<?php if(form_error('txt_author_name')!=''){ echo 'custom_error_msg_border'; } ?>" aria-required="true" size="30" value="<?php echo set_value('txt_author_name'); ?>" name="txt_author_name">
                <span id="txt_author_name-error"><?php echo form_error('txt_author_name') ?></span>
            </p>
            <p class="comment-form-email">
                <label><?php echo lang('email'); ?>*</label>
                <input id="txt_author_email" type="text" class="<?php if(form_error('txt_author_email')!=''){ echo 'custom_error_msg_border'; } ?>" placeholder="" aria-required="true" size="30" value="<?php echo set_value('txt_author_email'); ?>" name="txt_author_email">
                <span id="txt_author_email-error"><?php echo form_error('txt_author_email') ?></span>
            </p>
            <p class="comment-form-comment">
                <label><?php echo lang('your_comment'); ?>*</label>
                <textarea id="txt_author_comment" placeholder="" aria-required="true" rows="8" cols="45" name="txt_author_comment"><?php echo set_value('txt_author_comment'); ?></textarea>
                <span id="txt_author_comment-error"><?php echo form_error('txt_author_comment') ?></span>
            </p>
            <?php echo $reply_widget;?>
            <p class="form-submit clear">
                <input type="hidden" name="hidden_post_id" id="hidden_post_id" value="">
                <input id="submit" class="submit" type="submit" value="<?php echo lang('add_comment'); ?>" name="submit">
        </form>
    </div>
</div>
<!-- /Reply Popup -->
<script type="text/javascript" async >
    function genericSocialShare(url){
        window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
        return true;
    }
</script>
<script>
    function open_modal(id){
        $('#hidden_post_id').val(id);
        $('#reply-form').modal();
        $('.close-modal').html('');
        grecaptcha.render('reply_widget', {'sitekey' : '6LeEnhcUAAAAAN37cyl-mqLwvuLqKrlc9u4Mho5P'});
        
    }
    function comment_form_validate(){
        var err_cnt = 0;
        var txt_author_name = $('#txt_author_name').val();
        var txt_author_email = $('#txt_author_email').val();
        var txt_author_comment = $('#txt_author_comment').val();

        if(txt_author_name == ''){
            $('#txt_author_name').addClass('custom_error_msg_border');
            $('#txt_author_name-error').html('<span class="custom_error_msg_style">This field is required.</span>');
            err_cnt = 1;
        }else{
            $('#txt_author_name').removeClass('custom_error_msg_border');
            $('#txt_author_name-error').html('');
        }

        if(txt_author_email == ''){
            $('#txt_author_email').addClass('custom_error_msg_border');
            $('#txt_author_email-error').html('<span class="custom_error_msg_style">This field is required.</span>');
            err_cnt = 1;
        }else{
            $('#txt_author_email').removeClass('custom_error_msg_border');
            $('#txt_author_email-error').html('');
        }
        
        if(txt_author_comment == ''){
            $('#txt_author_comment').addClass('custom_error_msg_border');
            $('#txt_author_comment-error').html('<span class="custom_error_msg_style">This field is required.</span>');
            err_cnt = 1;
        }else{
            $('#txt_author_comment').removeClass('custom_error_msg_border');
            $('#txt_author_comment-error').html('');
        }

        if(err_cnt==0){
            return true;
        }else{
            return false;
        }
    }
</script>