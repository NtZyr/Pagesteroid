<?php
    $wrapper = $options['wrapper'];
    $item = $options['item'];
    $num = ($options['num'] ? $options['num'] : 0 );
    // var_dump($options);
?>
<div class="slide">
    <button class="slide-remove dashicons dashicons-no-alt"></button>
    <input data-field="img" class="slide-input" name="pagesteroid[<?= $wrapper ?>][items][<?= $item; ?>][slides][<?= $num; ?>][img]" type="hidden">
    <h3>Slide <span><?= $num; ?></span></h3>
    <input value="<?= ($data['slide_class'] ? $data['slide_class'] : '') ?>" type="text" name="pagesteroid[<?= $wrapper ?>][items][<?= $item; ?>][slides][<?= $num; ?>][slide_class]" placeholder="<?= __( 'Slide class', 'pagesteroid' ); ?>">
    <?php wp_editor( ($data['text'] ? $data['text'] : ''), $wrapper . '_slide_' . $item, array(
        'textarea_name' => 'pagesteroid[' . $wrapper . '][items][' . $item . '][slides][' . $num . '][text]"',
        'data-field' => 'text',
        'editor_class' => 'slide-input'
    ) ); ?>
</div>