<?php 
    $categories = get_categories();
?>
<select name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][category]" data-field="category">
    <option value=""><?= __( 'All', 'pagesteroid' ); ?></option>
<?php foreach( $categories as $category ) : ?>
    <option <?= ( $item['category'] == $category->term_id ? 'selected' : '' ); ?> value="<?= $category->term_id; ?>"><?= $category->name; ?></option>    
<?php endforeach; ?>
</select>

<input value="<?= ($item['post_num'] ? $item['post_num'] : ''); ?>" type="text" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][post_num]" data-field="post_num" placeholder="<?= __( 'Number of posts', 'pagesteroid' ); ?>">
<input value="<?= ($item['box_class'] ? $item['box_class'] : ''); ?>" type="text" name="pagesteroid[<?= $wrapper ?>][items][<?= $num ?>][box_class]" data-field="box_class" placeholder="<?= __( 'Box Class', 'pagesteroid' ); ?>">