<?php wp_editor( $item['content'], $wrapper . '_content_' . $num, array(
    'textarea_name' => 'pagesteroid[' . $wrapper . '][items][' . $num . '][content]"',
    'data-field' => 'content',
    'editor_class' => 'item-input'
) ); ?>