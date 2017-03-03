<a href="news/<?php echo $main_post['id']; ?>" class="homeV1MainPost">
    <div class="overlayBox">
        <div class="homeV1PostDesc">
            <div class="postTime"><?php echo $main_post['published']; ?></div>
            <h3><?php echo $main_post['title']; ?></h3>
        </div>
    </div>
</a>
<div class="blogPostBox clear">
    <?php
        foreach ($posts as $key => $post) {
            if($key > 0){
    ?>
        <div class="blogPostItem">
            <a href="news/<?php echo $post['id']; ?>" class="blogPostImg">
                <img src="<?php echo ($post['image'] != '') ? $post['image'] : 'assets/images/blog_post.jpg'; ?>" alt="Francoise img">
            </a>
            <div class="blogPostTime"><?php echo $post['published']; ?></div>
            <h3 class="postTitle"><a href="news/<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
            <p class="postText"><?php echo $post['text']; ?></p>
        </div>
    <?php
            }
        }
    ?>
</div>
<div class="postPagination">
    <ul class="clear">
        <li class="newPosts"><a href="#">New posts</a></li>
        <li class="olderPosts"><a href="">Older posts</a></li>
    </ul>
</div>