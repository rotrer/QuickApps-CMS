<h1><?php echo $node->title; ?></h1>
<?php foreach ($node->_fields as $fieldhandler => $field): ?>
	<h2><?php echo $field->label; ?></h2>
	<p><?php echo $field->data; ?></p>
<?php endforeach; ?>

<div class="well">
	<?php pr($node); ?>
</div>