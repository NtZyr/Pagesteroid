<div class="<?= $item['box_class']; ?>">
    <div <?= $item['id'] != null ? 'id="'. $item['id'] .'"' : ' ' ?><?= $item['classes'] != null ? 'class="'. $item['classes'] .'"' : ' ' ?>>
        <?php if( $item['slides'] && is_array( $item['slides'] ) ) : ?>
            <?php foreach( $item['slides'] as $slide ) : ?>
                <figure class="<?= ( $slide['slide_class'] ? $slide['slide_class'] .'"' : '' ) . '' . ( $item['slides_class'] ? $item['slides_class'] .'"' : '' ); ?>">
                    <figcaption>
                        <?= $slide['text']; ?>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        <?php else : ?>
        <?php endif; ?>
    </div>
</div>