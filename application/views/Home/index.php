<?php if(!empty($posts)){ ?>
<a target="_blank" href="<?php echo $posts->posts[0]->url; ?>" class="homeV1MainPost">
    <img src="<?php echo ($posts->posts[0]->thread->main_image != '') ? $posts->posts[0]->thread->main_image : 'assets/images/main_post.jpg'; ?>" alt="Francoise img">
    <div class="overlayBox">
        <div class="homeV1PostDesc">
            <div class="postTime"><?php echo date('d.m.Y',  strtotime($posts->posts[0]->published)); ?></div>
            <h3><?php echo $posts->posts[0]->title; ?></h3>
        </div>
    </div>
</a>
<div class="blogPostBox clear">
    <?php
    if (isset($posts->posts)){
        foreach ($posts->posts as $key => $post) {
            if($key > 0){
    ?>
        <div class="blogPostItem">
            <a target="_blank" href="<?php echo $post->url; ?>" class="blogPostImg">
                <img src="<?php echo ($post->thread->main_image != '') ? $post->thread->main_image : 'assets/images/blog_post.jpg'; ?>" alt="Francoise img">
            </a>
            <div class="blogPostTime"><?php echo date('d.m.Y',  strtotime($post->published)); ?></div>
            <h3 class="postTitle"><a target="_blank" href="<?php echo $post->url; ?>"><?php echo $post->title; ?></a></h3>
            <p class="postText"><?php echo $post->text; ?></p>
        </div>
    <?php
            }
        }
    }
    ?>
</div>
<div class="postPagination">
    <ul class="clear">
        <li class="newPosts"><a href="#">New posts</a></li>
        <li class="olderPosts"><a href="#">Older posts</a></li>
    </ul>
</div><?php } ?>
