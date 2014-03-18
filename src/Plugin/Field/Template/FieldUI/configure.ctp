<?php echo $this->Form->create($instance, ['role' => 'form']); ?>
	<fieldset>
		<legend><?php echo __('Basic Information'); ?></legend>
		<div class="form-group"><?php echo $this->Form->input('label'); ?></div>
		<div class="checkbox"><?php echo $this->Form->checkbox('required'); ?></div>
		<div class="form-group">
				<?php echo $this->Form->textarea('description'); ?>
				<span class="help-block"><?php echo __('Instructions to present to the user below this field on the editing form.'); ?></span>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
