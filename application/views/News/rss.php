<?php  echo '<?xml version="1.0" encoding="' . $encoding . '"?>' . "\n"; ?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
     
        <title><?php echo $feed_name; ?></title>
        <link><?php echo $feed_url; ?></link>
        <description><?php echo $page_description; ?></description>
        <dc:creator><?php echo $creator_email; ?></dc:creator>

        <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
        
        <?php  foreach ($posts as $post) { ?>

            <item>
                <title><?php echo $post['title']; ?></title>
                <author><?php echo $post['author']; ?></author>
                <pubDate><?php echo $post['published']; ?></pubDate>
                <link><?php echo base_url() . 'news/' . $post['id']; ?></link>
                <description><?php echo character_limiter($post['text'], 400); ?></description>
                <source url="<?php echo $post['url']; ?>"><?php echo $post['url']; ?></source>
            </item>


        <?php } ?>

    </channel>
</rss>