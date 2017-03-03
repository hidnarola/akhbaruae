<?php 
    $last_page = ceil($total_news / $limit);
//    echo '$page = ' . $page . '<br>';
//    echo '$total_news = ' . $total_news . '<br>';
//    echo '$limit = ' . $limit . '<br>';
//    echo '$last_page = ' . $last_page . '<br>';
//    exit;
?>
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
        <?php if($page != $last_page) { ?>
        <li class="newPosts <?php echo ($page != $last_page) ? 'my_pagination' : ''; ?>">
            <a href="javascript:void(0)" data-page="<?php echo ($page + 1); ?>">New posts</a>
        </li>
        <?php } ?>
        <?php if($page > 1) { ?>
        <li class="olderPosts <?php echo ($page > 1) ? 'my_pagination' : 'disable_pagination'; ?>">
            <a href="#" data-page="<?php echo ($page - 1); ?>">Older posts</a>
        </li>
        <?php } ?>
    </ul>
</div>