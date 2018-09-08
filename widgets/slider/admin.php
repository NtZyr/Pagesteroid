<input class="item-input" value="<?= ($item['box_class'] ? $item['box_class'] : ''); ?>" type="text" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][box_class]" data-field="box_class" placeholder="<?= __( 'Box Class', 'pagesteroid' ); ?>">
<input class="item-input" value="<?= ($item['slides_class'] ? $item['slides_class'] : ''); ?>" type="text" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][slides_class]" data-field="box_class" placeholder="<?= __( 'Slides Class', 'pagesteroid' ); ?>">

<div class="slides_box">
    <div class="slide_controls">
        <button type="button" class="slide-add dashicons dashicons-plus"></button>
    </div>
    <div class="slides">
        <?php 
            if( $item['slides'] && is_array($item['slides']) ) :
                foreach( $item['slides'] as $slide_num => $slide ) {
                    $data = array(
                        'wrapper' => $wrapper,
                        'item' => $num,
                        'num' => $slide_num
                    );
                    self::particial( $widget_name, 'slide', $data, $slide );
                }
            else : 
                $data = array(
                    'wrapper' => $wrapper,
                    'item' => $num,
                    'num' => 0
                );
                self::particial( $widget_name, 'slide', $data );      
            endif; ?>
    </div>
</div>