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
    <h2 class="comments-title">2 comments</h2>
    <ol class="comment-list commentList">
        <li id="comment-2" class="comment byuser depth-1 parent">
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
        </li>
    </ol>

    <div id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title">POST A COMMENT</h3>
        <form id="commentform" class="comment-form" novalidate="" method="post" action="news/add_comment/<?php echo $post['id']; ?>">
            <p class="comment-form-author">
                <label>Name*</label>
                <input id="author" type="text" placeholder="" aria-required="true" size="30" value="" name="author">
            </p>
            <p class="comment-form-email">
                <label>Email*</label>
                <input id="email" type="text" placeholder="" aria-required="true" size="30" value="" name="email">
            </p>
            <p class="comment-form-url">
                <label>Website</label>
                <input id="url" type="text" placeholder="" size="30" value="" name="url">
            </p>

            <p class="comment-form-comment">
                <label>Your comment</label>
                <textarea id="comment" placeholder="" aria-required="true" rows="8" cols="45" name="comment"></textarea>
            </p>
            <p class="form-submit clear">
                <input id="submit" class="submit" type="submit" value="Post comment" name="submit">
            </p>
        </form>
    </div>
</div>

<!-- <div id="commentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">POST A COMMENT</h4>
            </div>
            <div class="modal-body">
                <div id="respond" class="comment-respond">
                    <form id="commentform" class="comment-form" novalidate="" method="post" action="http://demoasana.te.ua/wp-comments-post.php">
                        <p class="comment-form-author">
                            <label>Name*</label>
                            <input id="author" type="text" placeholder="" aria-required="true" size="30" value="" name="author">
                        </p>
                        <p class="comment-form-email">
                            <label>Email*</label>
                            <input id="email" type="text" placeholder="" aria-required="true" size="30" value="" name="email">
                        </p>
                        <p class="comment-form-url">
                            <label>Website</label>
                            <input id="url" type="text" placeholder="" size="30" value="" name="url">
                        </p>

                        <p class="comment-form-comment">
                            <label>Your comment</label>
                            <textarea id="comment" placeholder="" aria-required="true" rows="8" cols="45" name="comment"></textarea>
                        </p>
                        <p class="form-submit clear">
                            <input id="submit" class="submit" type="submit" value="Post comment" name="submit">
                        </p>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
<!--</div>-->