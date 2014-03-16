<table class="table table-hover">
	<thead>
		<tr>
			<th><?php echo __('Label'); ?></th>
			<th><?php echo __('Machine name'); ?></th>
			<th><?php echo __('Handler'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($instances as $instance): ?>
		<tr>
			<td><?php echo $instance->label; ?></td>
			<td><?php echo $instance->slug; ?></td>
			<td><?php echo $instance->plugin; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
