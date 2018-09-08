<?php

namespace Pagesteroid;
require plugin_dir_path( __FILE__ ) . 'class-widget.php';

class Wrapper {
    public $wrapper_name;
    public $wrapper_label;

    public function __construct( $wrapper_name, $wrapper_label ) {
        $this->wrapper_name = $wrapper_name;
        $this->wrapper_label = $wrapper_label;
    }

    static function admin( $wrapper_name, $num = 0, $wrapper_id = null, $wrapper_classes = null, $items = array() ) {
?>
<div class="pagesteroid-wrap wrapper-1">
    <div class="wrapper-controls">
        <input type="hidden" data-field="type" class="wrapper-input" name="pagesteroid[<?= $num ?>][type]" value="<?= $wrapper_name; ?>">
        <span class="wrapper-handle dashicons dashicons-sort"></span>
        <label>ID: <input data-field="id" class="wrapper-input" value="<?= $wrapper_id; ?>" name="pagesteroid[<?= $num ?>][id]" type="text" placeholder="<?= __( 'Wrapper ID', 'pagesteroid' ); ?>"></label>
        <label>Classes: <input data-field="classes" class="wrapper-input" value="<?= $wrapper_classes; ?>" type="text" name="pagesteroid[<?= $num ?>][classes]" placeholder="<?= __( 'Wrapper Class', 'pagesteroid' ); ?>"></label>
        <?php wrapper_menu(); ?>
    </div>
    <div class="wrapper-settings">
        <?php require plugin_dir_path( __DIR__ ) . 'wrappers/' . $wrapper_name . '/admin.php'; ?>
    </div>
    <div class="pagesteroid-wrap-content">
        <?php if( $items && is_array( $items ) ) : ?>
            <?php foreach( $items as $item_num => $item ) {
                Widget::admin( $item['type'], $num, $item_num, $item );
            } ?>
        <?php else : ?>
            <p class="pagesteroid-rows-message"><?= __( 'Manage rows here', 'pagesteroid' ); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php
    }

    static function front( $wrapper_name, $wrapper_id = null, $wrapper_classes = null, $items = array() ) {
?>
    <div <?= $wrapper_id != null ? 'id="'. $wrapper_id .'"' : ' ' ?><?= $wrapper_classes != null ? 'class="'. $wrapper_classes .'"' : ' ' ?>>
        <?php foreach( $items as $item ) {
            Widget::front( $item['type'], $item );
        } ?>
    </div>
<?php
    }
}