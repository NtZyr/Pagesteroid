<div class="<?= $item['box_class']; ?>">
    <div <?= $item['id'] != null ? 'id="'. $item['id'] .'"' : ' ' ?><?= $item['classes'] != null ? 'class="'. $item['classes'] .'"' : ' ' ?>>
        <?php
            $args = array(
                'posts_per_page' => $item['post_num'],
                'category' => $item['category']
            );
    
            $posts = get_posts( $args );
    
            foreach( $posts as $post ) :
        ?>
        <article class="news-card"><a href="/">
            <div class="news-card__inner">
                <div class="news-card__cover">

                </div>
                <div class="news-card__info"><time datetime="2018-07-18T00:00:00.000Z"><?= the_date( $post->ID ); ?></time>
                    <h3 class="news-card__title"><?= $post->post_title; ?></h3>
                </div>
            </div>
        </a>
        </article>
        <?php endforeach; ?>
    </div>
</div>