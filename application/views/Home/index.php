<a href="<?php echo $posts->posts[0]->url; ?>" class="homeV1MainPost">
    <img src="<?php echo ($posts->posts[0]->thread->main_image != '') ? $posts->posts[0]->thread->main_image : 'http://placehold.it/1170x570/8acace/ffffff'; ?>" alt="Francoise img">
    <div class="overlayBox">
        <div class="homeV1PostDesc">
            <div class="postTime">15.05.2015</div>
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
            <a href="<?php echo $post->url; ?>" class="blogPostImg">
                <img src="<?php echo ($post->thread->main_image != '') ? $post->thread->main_image : 'http://placehold.it/370x250/8acace/ffffff'; ?>" alt="Francoise img">
            </a>
            <div class="blogPostTime">15.05.2015</div>
            <h3><a href="#"><?php echo $post->title; ?></a></h3>
            <p class="postText"><?php echo $post->text; ?></p>
        </div>
    <?php
            }
        }
    }
    ?>
<!--    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">CHOCOLATE-COVERED ESPRESSO BEAN BROWNIES</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">ROUNDTABLE: THE CHANGING STATE OF THE SEA</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">CHOCOLATE-COVERED ESPRESSO BEAN BROWNIES</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">NEXT GENERATION: ALESSANDRO CANTI</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">CHOCOLATE-COVERED ESPRESSO BEAN BROWNIES</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">Sed do eiusmod tempor incididunt consectetur adipisicing</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">CHOCOLATE-COVERED ESPRESSO BEAN BROWNIES</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>
    <div class="blogPostItem">
        <a href="#" class="blogPostImg">
            <img src="http://placehold.it/370x250/8acace/ffffff" alt="Francoise img">
        </a>
        <div class="blogPostTime">15.05.2015</div>
        <h3><a href="#">NEXT GENERATION: ALESSANDRO CANTI FASHION SHOW</a></h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt consectetur adipisicing elit sed do eiusmod</p>
    </div>-->
</div>
<div class="postPagination">
    <ul class="clear">
        <li class="newPosts"><a href="#">New posts</a></li>
        <li class="olderPosts"><a href="">Older posts</a></li>
    </ul>
</div>