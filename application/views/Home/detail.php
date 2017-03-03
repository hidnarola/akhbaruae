<?php function display_replies($temp){ ?>
    <ol class="children">
        <?php foreach($temp as $k => $v){ ?>
            <li id="comment-<?php echo $k+1; ?>" class="comment byuser depth-2">
                <a id="view-comment-3" class="comment-anchor"></a>
                <article id="div-comment-3" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <img  width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                        </div>
                        <div class="reply">
                            <div>
                                <a class="comment-reply-link" href="#">Reply</a>
                            </div>
                        </div>
                    </footer>
                    <div class="comment-wrapper">
                        <cite class="fn"><?php echo $v['author_name']; ?></cite>
                        <span class="comment-metadata">
                            <a href="#">
                                <time datetime="2015-05-05"><?php echo date('F d, Y',strtotime($v['created'])).' at '.date('g:i a',strtotime($v['created'])); ?></time>
                            </a>
                        </span>
                        <div class="comment-content">
                            <p><?php echo $v['author_comment']; ?></p>
                        </div>
                    </div>
                </article>
            </li>
        <?php 
            if(count($v['replies'])>0){
                display_replies($v['replies']);
            }
        } ?>
    </ol>
<?php
    }
?>

<!--<div class="contentLeft">-->
<div class="singlePostMeta">
    <div class="singlePostTime"><?php echo date('d.m.Y', strtotime($post['published'])); ?></div>
    <h1><?php echo $post['title']; ?></h1>
    <a href="#" class="singlePostCategory"><?php echo $post['site_categories']; ?></a>
</div>
<div class="singlePostWrap">
    <div class="singlePostImg">
        <img src="<?php echo ($post['image'] != '') ? $post['image'] : 'assets/images/main_post.jpg'; ?>">
    </div>
    <p><?php echo $post['text']; ?></p>
    <?php if ($post['external_links'] != '') { ?>
        <ul>
            <?php
            $links = explode('|', $post['external_links']);
            foreach ($links as $link) {
                ?>
                <li><a href="<?php echo $link; ?>"><?php echo $link; ?></a></li>
                <?php
            }
            ?>
        </ul>
    <?php } ?>
</div>
<div class="footerSocial newsSocial">
    <div class="clear">
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-vk"></i>
                VK <br>
                <?php echo $post['vk_shares']; ?>
            </a>
        </div>
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-facebook"></i>
                Facebook <br>
                <?php echo $post['facebook_shares']; ?>
            </a>
        </div>
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-stumbleupon"></i>
                Stumbled Upon <br>
                <?php echo $post['stumbledupon_shares']; ?>
            </a>
        </div>
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-linkedin"></i>
                LinkedIn <br>
                <?php echo $post['linkedin_shares']; ?>
            </a>
        </div>
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-pinterest"></i>
                Pinterest <br>
                <?php echo $post['pinterest_shares']; ?>
            </a>
        </div>
        <div class="footerSocialItem">
            <a href="#" class="">
                <i class="fa fa-google-plus"></i>
                Google + <br>
                <?php echo $post['gplus_shares']; ?>
            </a>
        </div>
    </div>
</div>

<div id="comments" class="commentsBox">
    <h2 class="comments-title"><?php echo count($commArr); ?> comments</h2>
    <ol class="comment-list commentList">
        <?php display_replies($commArr); ?>
        <!-- <?php foreach($commArr as $k => $v){ ?>
            <li id="comment-4" class="comment byuser depth-1">
                <a id="view-comment-4" class="comment-anchor"></a>
                <article id="div-comment-4" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <img  width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                        </div>
                        <div class="reply"> 
                            <div>
                                <a class="comment-reply-link" href="#">Reply</a>
                            </div>
                        </div>
                    </footer>
                    <div class="comment-wrapper">
                        <cite class="fn"><?php echo $v['author_name']; ?></cite>
                        <span class="comment-metadata">
                            <a href="#">
                                <time datetime="2015-05-05"><?php echo date('F d, Y',strtotime($v['created'])).' at '.date('g:i a',strtotime($v['created'])); ?></time>
                            </a>
                        </span>
                        <div class="comment-content">
                            <p><?php echo $v['author_comment']; ?></p>
                        </div>
                    </div>
                </article>
            </li>
        <?php } ?> -->
    
        <!-- <li id="comment-2" class="comment byuser depth-1 parent">
            <a id="view-comment-2" class="comment-anchor"></a>
            <article id="div-comment-2" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <img width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                    </div>
                    <div class="reply">
                        <div>
                            <a class="comment-reply-link" href="#">Reply</a>
                        </div>
                    </div>
                </footer>
                <div class="comment-wrapper">
                    <cite class="fn">Joan Gonzales</cite>
                    <span class="comment-metadata">
                        <a href="#">
                            <time datetime="2015-05-05">July 7, 2014 at 9:25 pm</time>
                        </a>
                    </span>
                    <div class="comment-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                    </div>
                </div>
            </article>
            <ol class="children">
                <li id="comment-3" class="comment byuser depth-2">
                    <a id="view-comment-3" class="comment-anchor"></a>
                    <article id="div-comment-3" class="comment-body">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <img  width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                            </div>
                            <div class="reply">
                                <div>
                                    <a class="comment-reply-link" href="#">Reply</a>
                                </div>
                            </div>
                        </footer>
                        <div class="comment-wrapper">
                            <cite class="fn">Alice Ryan</cite>
                            <span class="comment-metadata">
                                <a href="#">
                                    <time datetime="2015-05-05">July 7, 2014 at 9:25 pm</time>
                                </a>
                            </span>
                            <div class="comment-content">
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                        </div>
                    </article>
                </li>
            </ol>
        </li>
        <li id="comment-4" class="comment byuser depth-1">
            <a id="view-comment-4" class="comment-anchor"></a>
            <article id="div-comment-4" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <img  width="56" height="56" src="http://placehold.it/56x56/8acace/ffffff" alt="Francoise img">
                    </div>
                    <div class="reply"> 
                        <div>
                            <a class="comment-reply-link" href="#">Reply</a>
                        </div>
                    </div>
                </footer>
                <div class="comment-wrapper">
                    <cite class="fn">Catherine Taylor</cite>
                    <span class="comment-metadata">
                        <a href="#">
                            <time datetime="2015-05-05">July 7, 2014 at 9:25 pm</time>
                        </a>
                    </span>
                    <div class="comment-content">
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                    </div>
                </div>
            </article>
        </li> -->
    </ol>

    <div id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title">POST A COMMENT</h3>
        <form id="commentform" action="news/add_comment/<?php echo $post['id']; ?>" method="post" class="comment-form" novalidate="" onSubmit="return comment_form_validate()" >
            <p class="comment-form-author">
                <label>Name*</label>
                <input id="txt_author_name" type="text" class="<?php if(form_error('txt_author_name')!=''){ echo 'custom_error_msg_border'; } ?>" aria-required="true" size="30" value="<?php echo set_value('txt_author_name'); ?>" name="txt_author_name">
                <font id="txt_author_name-error"><?php echo form_error('txt_author_name') ?></font>
            </p>
            <p class="comment-form-email">
                <label>Email*</label>
                <input id="txt_author_email" type="text" class="<?php if(form_error('txt_author_email')!=''){ echo 'custom_error_msg_border'; } ?>" placeholder="" aria-required="true" size="30" value="<?php echo set_value('txt_author_email'); ?>" name="txt_author_email">
                <font id="txt_author_email-error"><?php echo form_error('txt_author_email') ?></font>
            </p>
            <p class="comment-form-url">
                <label>Website</label>
                <input id="txt_author_website" type="text" placeholder="" size="30" value="<?php echo set_value('txt_author_website'); ?>" name="txt_author_website">
                <?php echo form_error('txt_author_website') ?>
            </p>

            <p class="comment-form-comment">
                <label>Your comment</label>
                <textarea id="txt_author_comment" placeholder="" aria-required="true" rows="8" cols="45" name="txt_author_comment"><?php echo set_value('txt_author_comment'); ?></textarea>
                <?php echo form_error('txt_author_comment') ?>
            </p>
            <p class="form-submit clear">
                <input id="submit" class="submit" type="submit" value="Post comment" name="submit">
            </p>
        </form>
    </div>
</div>
<script>
    function comment_form_validate(){
        var err_cnt = 0;
        var txt_author_name = $('#txt_author_name').val();
        var txt_author_email = $('#txt_author_email').val();
        var txt_author_website = $('#txt_author_website').val();
        var txt_author_comment = $('#txt_author_comment').val();

        if(txt_author_name==''){
            $('#txt_author_name').addClass('custom_error_msg_border');
            $('#txt_author_name-error').html('<span class="custom_error_msg_style">This Name field is required.</span>');
            err_cnt = 1;
        }else{
            $('#txt_author_name').removeClass('custom_error_msg_border');
            $('#txt_author_name-error').html('');
        }

        if(txt_author_email==''){
            $('#txt_author_email').addClass('custom_error_msg_border');
            $('#txt_author_email-error').html('<span class="custom_error_msg_style">This Name field is required.</span>');
            err_cnt = 1;
        }else{
            $('#txt_author_email').removeClass('custom_error_msg_border');
            $('#txt_author_email-error').html('');
        }

        if(err_cnt==0){
            return true;
        }else{
            return false;
        }
    }
</script>