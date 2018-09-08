<?php

namespace Pagesteroid;

class Widget {
    public $widget_name;
    public $widget_label;

    public function __construct( $widget_name, $widget_label ) {
        $this->widget_name = $widget_name;
        $this->widget_label = $widget_label;
    }

    static function admin( $widget_name, $wrapper = 0, $num = 0, $item = null ) {
?>
<div class="pagesteroid-row pagesteroid-item codeindesign-col-1">
    <div class="pagesteroid-row-title">
        <span class="pagesteroid-handle dashicons dashicons-sort"></span>
        <span class="pagesteroid-toggle dashicons dashicons-arrow-up-alt2"></span>
        <span class="pagesteroid-remove dashicons dashicons-trash"></span>
    </div>
    
    <div class="column-controls">
        <label>ID: <input value="<?= $item['id']; ?>" data-field="id" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][id]" class="item-input" type="text" placeholder="<?= __( 'Column ID', 'pagesteroid' ); ?>"></label>
        <label>Classes: <input value="<?= $item['classes']; ?>" data-field="classes" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][classes]" class="item-input" type="text" placeholder="<?= __( 'Column Class', 'pagesteroid' ); ?>"></label>
    </div>

    <div class="pagesteroid-row-fields">
        <?php 
            if( file_exists(plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/admin.php') ) {
                require plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/admin.php';                 
            }
        ?>
        <input class="item-input" type="hidden" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][type]" data-field="type" value="<?= $widget_name; ?>">
    </div>
</div>
<?php
    }

    static function front( $widget_name, $item = null ) {
        if( file_exists(plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/front.php') ) {
            require plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/front.php';
        }
    }

    static function particial( $widget_name, $template_name, $options = array(), $data = null ) {
        if( file_exists(plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/particial/' . $template_name . '.php') ) {
            require plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_name . '/particial/' . $template_name . '.php';
        }
    }
}

class Widget_List {
    private $list = array();

    public function __construct( $widgets = array() ) {
        foreach( $widgets as $widget) {
            $this->list[] = $widget;
        }

        return $this->list();
    }

    public function list() {
        $widget_list = $this->list;
?>
    <ul class="wrapper-add-menu">
    <?php foreach( $widget_list as $widget ) : ?>
        <li><a data-widget="<?= $widget->widget_name; ?>" class="add-row" href="#"><?= $widget->widget_label; ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php
    }
}