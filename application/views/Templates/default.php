<!DOCTYPE html>
<html lang="uk">
    <head>
        <title>AkhbarUAE - Home</title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <base href="<?php echo base_url(); ?>">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="assets/css/bxslider.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="assets/css/adaptive.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="assets/css/custom.css" media="screen" />
        <script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
    </head>
    <!--<body class="page-grid">-->
    <body class="single-post">
        <header id="header">
            <div class="siteHeader">
                <div class="wrapper clear">
                    <a href="index.html" class="mobile-logo">
                        <img src="assets/images/mobile-logo.png" alt="Francoise img">
                    </a>
                    <ul class="mainMenu clear">
                        <li>
                            <a href="">Home</a>
                            <ul>
                                <li><a href="index-slider.html">Home slider</a></li>
                                <li><a href="index-fullsize.html">Home fullsize</a></li>
                                <li><a href="index-masonry.html">Home masonry</a></li>
                                <li class="current-menu-item"><a href="index-grid.html">Home grid</a></li>
                                <li><a href="index-list.html">Home list </a></li>
                                <li><a href="404.html">404 page</a></li>
                                <li><a href="single-post.html">Single post</a></li>
                            </ul>
                        </li>
                        <li><a href="news">News</a></li>
<!--                        <li><a href="category.html">lifestyle</a></li>
                        <li>
                            <a href="category.html">travel</a>
                            <ul>
                                <li><a href="#">Submenu one</a></li>
                                <li><a href="#">Submenu two</a></li>
                                <li><a href="#">Submenu three</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#">Submenu four</a>
                                    <ul>
                                        <li><a href="#">Submenu one</a></li>
                                        <li><a href="#">Submenu two</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="category.html">fashion</a></li>
                        <li><a href="category.html">inspiration</a></li>
                        <li><a href="about.html">about</a></li>
                        <li><a href="contact.html">contact</a></li>-->
                    </ul>
<!--                    <div class="pull-right clear">
                        <div class="headerSocialLinks clear">
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                        <div class="searchIcon"></div>
                    </div>-->
                    <span class="showMobileMenu">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>	
            </div>
            <a href="#" class="logo"><img src="assets/images/logo.png" alt="Francoise img"></a>
        </header>
        <section class="container">
            <div class="wrapper clear">
                <?php echo $body; ?>
            </div>
        </section>
        <footer id="footer">
<!--            <div class="footerSocial">
                <div class="wrapper clear">
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-instagram"></i>
                            Instagram <br>
                            10 537
                        </a>
                    </div>
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-facebook"></i>
                            facebook <br>
                            103 537
                        </a>
                    </div>
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-twitter"></i>
                            Twitter <br>
                            27 129
                        </a>
                    </div>
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-heart"></i>
                            bloglovin <br>
                            98 122
                        </a>
                    </div>
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-pinterest"></i>
                            Pinterest <br>
                            10 641
                        </a>
                    </div>
                    <div class="footerSocialItem">
                        <a href="#" class="">
                            <i class="fa fa-google-plus"></i>
                            google + <br>
                            17 324
                        </a>
                    </div>
                </div>
            </div>-->
            <div class="wrapper">
                <ul class="footerMenu">
                    <li><a href="category.html">Lyfestyle</a></li>
                    <li><a href="category.html">travel</a></li>
                    <li><a href="category.html">fashion</a></li>
                    <li><a href="category.html">Inspiration</a></li>
                    <li><a href="about.html">about</a></li>
                    <li><a href="contact.html">contact</a></li>
                </ul>
                <p class="copyright">© 2015 Francoise</p>
            </div>	
        </footer>
        <div class="mobileMenu">
            <div class="mobileSearch">
                <form action="index.html">
                    <input class="" type="text" name="" size="32" value="" placeholder="Search">	
                    <input class="" type="submit" value="">
                </form>
            </div>
            <ul>
                <li>
                    <a href="index.html">home</a>
                    <ul>
                        <li><a href="index-slider.html">Home slider</a></li>
                        <li><a href="index-fullsize.html">Home fullsize</a></li>
                        <li><a href="index-masonry.html">Home masonry</a></li>
                        <li class="current-menu-item"><a href="index-grid.html">Home grid</a></li>
                        <li><a href="index-list.html">Home list </a></li>
                        <li><a href="404.html">404 page</a></li>
                        <li><a href="single-post.html">Single post</a></li>
                    </ul>
                </li>
                <li><a href="category.html">lifestyle</a></li>
                <li>
                    <a href="category.html">travel</a>
                    <ul>
                        <li><a href="#">Submenu one</a></li>
                        <li><a href="#">Submenu two</a></li>
                        <li><a href="#">Submenu three</a></li>
                        <li class="menu-item-has-children">
                            <a href="#">Submenu four</a>
                            <ul>
                                <li><a href="#">Submenu one</a></li>
                                <li><a href="#">Submenu two</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="category.html">fashion</a></li>
                <li><a href="category.html">inspiration</a></li>
                <li><a href="about.html">about</a></li>
                <li><a href="contact.html">contact</a></li>
            </ul>
            <div class="mobileSocial clear">
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-heart"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
        </div>
        <div class="searchPopup">
            <span class="closeBtn"></span>
            <div class="wrapper">
                <form action="index.html">
                    <input class="" type="text" name="" size="32" value="" placeholder="Search">
                </form>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="assets/js/masonry.pkgd.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.dotdotdot.min.js"></script>
        <script type="text/javascript" src="assets/js/script.js"></script>
        <script type="text/javascript">
            $(function () {
                $(document).find('.blogPostItem p.postText,.blogPostItem h3.postTitle').dotdotdot();
            });
        </script>
    </body>
</html>