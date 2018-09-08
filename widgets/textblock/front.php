<div <?= $item['id'] != null ? 'id="'. $item['id'] .'"' : ' ' ?><?= $item['classes'] != null ? 'class="'. $item['classes'] .'"' : ' ' ?>>
    <?= $item['content']; ?>
</div>