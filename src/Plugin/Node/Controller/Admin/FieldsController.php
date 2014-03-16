<?php
namespace QuickApps\Node\Controller\Admin;
use QuickApps\Node\Controller\NodeAppController;
use QuickApps\Field\Controller\UITrait;

class FieldsController extends NodeAppController {
	use UITrait;
	public $manageEntity = 'Nodes';
}