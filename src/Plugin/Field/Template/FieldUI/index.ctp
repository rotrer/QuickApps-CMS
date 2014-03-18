<table class="table table-hover table-bordered table-responsive">
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
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php echo $instance->label; ?> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><?php echo $this->Html->link(__('Configure'), ['plugin' => 'node', 'controller' => 'fields', 'action' => 'configure', $instance->id]); ?></li>
						<li><?php echo $this->Html->link(__('Move Up'), ['plugin' => 'node', 'controller' => 'fields', 'action' => 'move_up', $instance->id]); ?></li>
						<li><?php echo $this->Html->link(__('Move Down'), ['plugin' => 'node', 'controller' => 'fields', 'action' => 'move_down', $instance->id]); ?></li>
						<li class="divider"></li>
						<li><?php echo $this->Html->link(__('Delete'), '/admin/node/fields/'); ?></li>
					</ul>
				</div>
			</td>
			<td><?php echo $instance->slug; ?></td>
			<td><?php echo $instance->plugin; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
