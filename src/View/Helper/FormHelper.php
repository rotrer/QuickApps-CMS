<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace QuickApps\View\Helper;
use QuickApps\Event\EventTrait;
use Cake\View\Helper\FormHelper as CakeFormHelper;
use Cake\View\Widget\WidgetRegistry;

/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 *
 * @property      HtmlHelper $Html
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html
 */
class FormHelper extends CakeFormHelper {
	use EventTrait;

/**
 * Set the input registry the helper will use.
 *
 * @param \Cake\View\Widget\WidgetRegistry $instance The registry instance to set.
 * @param array $widgets An array of widgets
 * @return \Cake\View\Widget\WidgetRegistry
 */
	public function widgetRegistry(WidgetRegistry $instance = null, $widgets = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.widgetRegistry', $this, $args);
		extract((array)$event->result);

		return parent::widgetRegistry($instance, $widgets);
	}

/**
 * Returns an HTML FORM element.
 *
 * ### Options:
 *
 * - `type` Form method defaults to autodetecting based on the form context. If
 *   the form context's isCreate() method returns false, a PUT request will be done.
 * - `action` The controller action the form submits to, (optional). Use this option if you
 *   don't need to change the controller from the current request's controller.
 * - `url` The URL the form submits to. Can be a string or a URL array. If you use 'url'
 *    you should leave 'action' undefined.
 * - `encoding` Set the accept-charset encoding for the form. Defaults to `Configure::read('App.encoding')`
 * - `templates` The templates you want to use for this form. Any templates will be merged on top of
 *   the already loaded templates. This option can either be a filename in App/Config that contains
 *   the templates you want to load, or an array of templates to use. You can use
 *   resetTemplates() to restore the original templates.
 * - `context` Additional options for the context class. For example the EntityContext accepts a 'table'
 *   option that allows you to set the specific Table class the form should be based on.
 * - `idPrefix` Prefix for generated ID attributes.
 *
 * @param mixed $model The context for which the form is being defined. Can
 *   be an ORM entity, ORM resultset, or an array of meta data. You can use false or null
 *   to make a model-less form.
 * @param array $options An array of html attributes and options.
 * @return string An formatted opening FORM tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-create
 */
	public function create($model = null, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.create', $this, $args);
		extract((array)$event->result);

		return parent::create($model, $options);
	}

/**
 * Closes an HTML form, cleans up values set by FormHelper::create(), and writes hidden
 * input fields where appropriate.
 *
 * @param array $secureAttributes will be passed as html attributes into the hidden input elements generated for the
 *   Security Component.
 * @return string A closing FORM tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#closing-the-form
 */
	public function end($secureAttributes = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.end', $this, $args);
		extract((array)$event->result);

		return parent::end($secureAttributes);
	}

/**
 * Generates a hidden field with a security hash based on the fields used in
 * the form.
 *
 * If $secureAttributes is set, these html attributes will be merged into
 * the hidden input tags generated for the Security Component. This is
 * especially useful to set HTML5 attributes like 'form'.
 *
 * @param array|null $fields If set specifies the list of fields to use when
 *    generating the hash, else $this->fields is being used.
 * @param array $secureAttributes will be passed as html attributes into the hidden
 *    input elements generated for the Security Component.
 * @return string A hidden input field with a security hash
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::secure
 */
	public function secure($fields = array(), $secureAttributes = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.secure', $this, $args);
		extract((array)$event->result);

		return parent::secure($fields, $secureAttributes);
	}

/**
 * Add to or get the list of fields that are currently unlocked.
 * Unlocked fields are not included in the field hash used by SecurityComponent
 * unlocking a field once its been added to the list of secured fields will remove
 * it from the list of fields.
 *
 * @param string $name The dot separated name for the field.
 * @return mixed Either null, or the list of fields.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::unlockField
 */
	public function unlockField($name = null) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.unlockField', $this, $args);
		extract((array)$event->result);

		return parent::unlockField($name);
	}

/**
 * Returns true if there is an error for the given field, otherwise false
 *
 * @param string $field This should be "Modelname.fieldname"
 * @return boolean If there are errors this method returns true, else false.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::isFieldError
 */
	public function isFieldError($field) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.isFieldError', $this, $args);
		extract((array)$event->result);

		return parent::isFieldError($field);
	}

/**
 * Returns a formatted error message for given form field, '' if no errors.
 *
 * Uses the `error`, `errorList` and `errorItem` templates. The `errorList` and
 * `errorItem` templates are used to format multiple error messages per field.
 *
 * ### Options:
 *
 * - `escape` boolean - Whether or not to html escape the contents of the error.
 *
 * @param string $field A field name, like "Modelname.fieldname"
 * @param string|array $text Error message as string or array of messages. If an array,
 *   it should be a hash of key names => messages.
 * @param array $options See above.
 * @return string Formatted errors or ''.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::error
 */
	public function error($field, $text = null, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.error', $this, $args);
		extract((array)$event->result);

		return parent::error($field, $text, $options);
	}

/**
 * Returns a formatted LABEL element for HTML forms.
 *
 * Will automatically generate a `for` attribute if one is not provided.
 *
 * ### Options
 *
 * - `for` - Set the for attribute, if its not defined the for attribute
 *   will be generated from the $fieldName parameter using
 *   FormHelper::_domId().
 *
 * Examples:
 *
 * The text and for attribute are generated off of the fieldname
 *
 * {{{
 * echo $this->Form->label('published');
 * <label for="PostPublished">Published</label>
 * }}}
 *
 * Custom text:
 *
 * {{{
 * echo $this->Form->label('published', 'Publish');
 * <label for="published">Publish</label>
 * }}}
 *
 * Custom class name:
 *
 * {{{
 * echo $this->Form->label('published', 'Publish', 'required');
 * <label for="published" class="required">Publish</label>
 * }}}
 *
 * Custom attributes:
 *
 * {{{
 * echo $this->Form->label('published', 'Publish', array(
 *   'for' => 'post-publish'
 * ));
 * <label for="post-publish">Publish</label>
 * }}}
 *
 * Nesting an input tag:
 *
 * {{{
 * echo $this->Form->label('published', 'Publish', array(
 *   'for' => 'published',
 *   'input' => $this->text('published')
 * ));
 * <label for="post-publish">Publish <input type="text" name="published"></label>
 * }}}
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param string $text Text that will appear in the label field. If
 *   $text is left undefined the text will be inflected from the
 *   fieldName.
 * @param array|string $options An array of HTML attributes, or a string, to be used as a class name.
 * @return string The formatted LABEL element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::label
 */
	public function label($fieldName, $text = null, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.label', $this, $args);
		extract((array)$event->result);

		return parent::label($fieldName, $text, $options);
	}

/**
 * Generate a set of inputs for `$fields`. If $fields is null the fields of current model
 * will be used.
 *
 * You can customize individual inputs through `$fields`.
 * {{{
 * $this->Form->inputs([
 *   'name' => ['label' => 'custom label']
 * ]);
 * }}}
 *
 * You can exclude fields using the `$blacklist` parameter:
 *
 * {{{
 * $this->Form->inputs(null, ['title']);
 * }}}
 *
 * In the above example, no field would be generated for the title field.
 *
 * In addition to controller fields output, `$fields` can be used to control legend
 * and fieldset rendering.
 * `$this->Form->inputs('My legend');` Would generate an input set with a custom legend.
 *
 * @param array $fields An array of customizations for the fields that will be
 *   generated. This array allows you to set custom types, labels, or other options.
 * @param array $blacklist A list of fields to not create inputs for.
 * @param array $options Options array. Valid keys are:
 * - `fieldset` Set to false to disable the fieldset.
 * - `legend` Set to false to disable the legend for the generated input set. Or supply a string
 *    to customize the legend text.
 * @return string Completed form inputs.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::inputs
 */
	public function inputs($fields = null, $blacklist = null, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.inputs', $this, $args);
		extract((array)$event->result);

		return parent::inputs($fields, $blacklist, $options);
	}

/**
 * Generates a form input element complete with label and wrapper div
 *
 * ### Options
 *
 * See each field type method for more information. Any options that are part of
 * $attributes or $options for the different **type** methods can be included in `$options` for input().i
 * Additionally, any unknown keys that are not in the list below, or part of the selected type's options
 * will be treated as a regular html attribute for the generated input.
 *
 * - `type` - Force the type of widget you want. e.g. `type => 'select'`
 * - `label` - Either a string label, or an array of options for the label. See FormHelper::label().
 * - `options` - For widgets that take options e.g. radio, select.
 * - `error` - Control the error message that is produced. Set to `false` to disable any kind of error reporting (field
 *    error and error messages).
 * - `empty` - String or boolean to enable empty select box options.
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @return string Completed form widget.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#creating-form-elements
 */
	public function input($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.input', $this, $args);
		extract((array)$event->result);

		return parent::input($fieldName, $options);
	}

/**
 * Creates a checkbox input widget.
 *
 * ### Options:
 *
 * - `value` - the value of the checkbox
 * - `checked` - boolean indicate that this checkbox is checked.
 * - `hiddenField` - boolean to indicate if you want the results of checkbox() to include
 *    a hidden input with a value of ''.
 * - `disabled` - create a disabled input.
 * - `default` - Set the default value for the checkbox. This allows you to start checkboxes
 *    as checked, without having to check the POST data. A matching POST data value, will overwrite
 *    the default value.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 * @return string An HTML text input element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function checkbox($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.checkbox', $this, $args);
		extract((array)$event->result);

		return parent::checkbox($fieldName, $options);
	}

/**
 * Creates a set of radio widgets.
 *
 * ### Attributes:
 *
 * - `value` - Indicate a value that is should be checked
 * - `label` - boolean to indicate whether or not labels for widgets show be displayed
 * - `hiddenField` - boolean to indicate if you want the results of radio() to include
 *    a hidden input with a value of ''. This is useful for creating radio sets that non-continuous
 * - `disabled` - Set to `true` or `disabled` to disable all the radio buttons.
 * - `empty` - Set to `true` to create a input with the value '' as the first option. When `true`
 *   the radio label will be 'empty'. Set this option to a string to control the label value.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Radio button options array.
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function radio($fieldName, $options = [], $attributes = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.radio', $this, $args);
		extract((array)$event->result);

		return parent::radio($fieldName, $options, $attributes);
	}

/**
 * Missing method handler - implements various simple input types. Is used to create inputs
 * of various types. e.g. `$this->Form->text();` will create `<input type="text" />` while
 * `$this->Form->range();` will create `<input type="range" />`
 *
 * ### Usage
 *
 * `$this->Form->search('User.query', array('value' => 'test'));`
 *
 * Will make an input like:
 *
 * `<input type="search" id="UserQuery" name="User[query]" value="test" />`
 *
 * The first argument to an input type should always be the fieldname, in `Model.field` format.
 * The second argument should always be an array of attributes for the input.
 *
 * @param string $method Method name / input type to make.
 * @param array $params Parameters for the method call
 * @return string Formatted input method.
 * @throws \Cake\Error\Exception When there are no params for the method call.
 */
	public function __call($method, $params) {
		return parent::__call($method, $param);
	}

/**
 * Creates a textarea widget.
 *
 * ### Options:
 *
 * - `escape` - Whether or not the contents of the textarea should be escaped. Defaults to true.
 *
 * @param string $fieldName Name of a field, in the form "Modelname.fieldname"
 * @param array $options Array of HTML attributes, and special options above.
 * @return string A generated HTML text input element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::textarea
 */
	public function textarea($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.textarea', $this, $args);
		extract((array)$event->result);

		return parent::textarea($fieldName, $options);
	}

/**
 * Creates a hidden input field.
 *
 * @param string $fieldName Name of a field, in the form of "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 * @return string A generated hidden input
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::hidden
 */
	public function hidden($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.hidden', $this, $args);
		extract((array)$event->result);

		return parent::hidden($fieldName, $options);
	}

/**
 * Creates file input widget.
 *
 * @param string $fieldName Name of a field, in the form "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 * @return string A generated file input.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::file
 */
	public function file($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.file', $this, $args);
		extract((array)$event->result);

		return parent::file($fieldName, $options);
	}

/**
 * Creates a `<button>` tag.
 *
 * The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function button($title, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.button', $this, $args);
		extract((array)$event->result);

		return parent::button($title, $options);
	}

/**
 * Create a `<button>` tag with a surrounding `<form>` that submits via POST.
 *
 * This method creates a `<form>` element. So do not use this method in an already opened form.
 * Instead use FormHelper::submit() or FormHelper::button() to create buttons inside opened forms.
 *
 * ### Options:
 *
 * - `data` - Array with key/value to pass in input hidden
 * - Other options is the same of button method.
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string|array $url URL as string or array
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::postButton
 */
	public function postButton($title, $url, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.postButton', $this, $args);
		extract((array)$event->result);

		return parent::postButton($title, $url, $options);
	}

/**
 * Creates an HTML link, but access the URL using the method you specify (defaults to POST).
 * Requires javascript to be enabled in browser.
 *
 * This method creates a `<form>` element. So do not use this method inside an existing form.
 * Instead you should add a submit button using FormHelper::submit()
 *
 * ### Options:
 *
 * - `data` - Array with key/value to pass in input hidden
 * - `method` - Request method to use. Set to 'delete' to simulate HTTP/1.1 DELETE request. Defaults to 'post'.
 * - `confirm` - Can be used instead of $confirmMessage.
 * - `block` - Set to true to append form to view block "postLink" or provide
 *   custom block name.
 * - Other options are the same of HtmlHelper::link() method.
 * - The option `onclick` will be replaced.
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @param string|array $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
 * @param array $options Array of HTML attributes.
 * @param boolean|string $confirmMessage JavaScript confirmation message.
 * @return string An `<a />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::postLink
 */
	public function postLink($title, $url = null, $options = array(), $confirmMessage = false) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.postLink', $this, $args);
		extract((array)$event->result);

		return parent::postLink($title, $url, $options, $confirmMessage);
	}

/**
 * Creates a submit button element. This method will generate `<input />` elements that
 * can be used to submit, and reset forms by using $options. image submits can be created by supplying an
 * image path for $caption.
 *
 * ### Options
 *
 * - `type` - Set to 'reset' for reset inputs. Defaults to 'submit'
 * - Other attributes will be assigned to the input element.
 *
 * @param string $caption The label appearing on the button OR if string contains :// or the
 *  extension .jpg, .jpe, .jpeg, .gif, .png use an image if the extension
 *  exists, AND the first character is /, image is relative to webroot,
 *  OR if the first character is not /, image is relative to webroot/img.
 * @param array $options Array of options. See above.
 * @return string A HTML submit button
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::submit
 */
	public function submit($caption = null, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.submit', $this, $args);
		extract((array)$event->result);

		return parent::submit($caption, $options);
	}

/**
 * Returns a formatted SELECT element.
 *
 * ### Attributes:
 *
 * - `multiple` - show a multiple select box. If set to 'checkbox' multiple checkboxes will be
 *   created instead.
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `escape` - If true contents of options will be HTML entity encoded. Defaults to true.
 * - `val` The selected value of the input.
 * - `disabled` - Control the disabled attribute. When creating a select box, set to true to disable the
 *   select box. Set to an array to disable specific option elements.
 *
 * ### Using options
 *
 * A simple array will create normal options:
 *
 * {{{
 * $options = array(1 => 'one', 2 => 'two);
 * $this->Form->select('Model.field', $options));
 * }}}
 *
 * While a nested options array will create optgroups with options inside them.
 * {{{
 * $options = array(
 *  1 => 'bill',
 *  'fred' => array(
 *     2 => 'fred',
 *     3 => 'fred jr.'
 *  )
 * );
 * $this->Form->select('Model.field', $options);
 * }}}
 *
 * If you have multiple options that need to have the same value attribute, you can
 * use an array of arrays to express this:
 *
 * {{{
 * $options = array(
 *  array('name' => 'United states', 'value' => 'USA'),
 *  array('name' => 'USA', 'value' => 'USA'),
 * );
 * }}}
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the OPTION elements (as 'value'=>'Text' pairs) to be used in the
 *   SELECT element
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted SELECT element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 * @see \Cake\View\Helper\FormHelper::multiCheckbox() for creating multiple checkboxes.
 */
	public function select($fieldName, $options = [], $attributes = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.select', $this, $args);
		extract((array)$event->result);

		return parent::select($fieldName, $options, $attributes);
	}

/**
 * Creates a set of checkboxes out of options.
 *
 * ### Options
 *
 * - `escape` - If true contents of options will be HTML entity encoded. Defaults to true.
 * - `val` The selected value of the input.
 * - `class` - When using multiple = checkbox the class name to apply to the divs. Defaults to 'checkbox'.
 * - `disabled` - Control the disabled attribute. When creating checkboxes, `true` will disable all checkboxes.
 *   You can also set disabled to a list of values you want to disable when creating checkboxes.
 * - `hiddenField` - Set to false to remove the hidden field that ensures a value
 *   is always submitted.
 *
 * Can be used in place of a select box with the multiple attribute.
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the OPTION elements (as 'value'=>'Text' pairs) to be used in the
 *   checkboxes element.
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted SELECT element
 * @see \Cake\View\Helper\FormHelper::select() for supported option formats.
 */
	public function multiCheckbox($fieldName, $options, $attributes = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.multiCheckbox', $this, $args);
		extract((array)$event->result);

		return parent::multiCheckbox($fieldName, $options, $attributes);
	}

/**
 * Returns a SELECT element for days.
 *
 * ### Options:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` The selected value of the input.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $option Options & HTML attributes for the select element
 * @return string A generated day select box.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::day
 */
	public function day($fieldName = null, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.day', $this, $args);
		extract((array)$event->result);

		return parent::day($fieldName, $options);
	}

/**
 * Returns a SELECT element for years
 *
 * ### Attributes:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `orderYear` - Ordering of year values in select options.
 *   Possible values 'asc', 'desc'. Default 'desc'
 * - `value` The selected value of the input.
 * - `maxYear` The max year to appear in the select element.
 * - `minYear` The min year to appear in the select element.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Options & attributes for the select elements.
 * @return string Completed year select input
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::year
 */
	public function year($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.widgetRegistry', $this, $args);
		extract((array)$event->result);

		return parent::widgetRegistry($instance, $widgets);
	}

/**
 * Returns a SELECT element for months.
 *
 * ### Options:
 *
 * - `monthNames` - If false, 2 digit numbers will be used instead of text.
 *   If an array, the given array will be used.
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` The selected value of the input.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Attributes for the select element
 * @return string A generated month select dropdown.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::month
 */
	public function month($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.month', $this, $args);
		extract((array)$event->result);

		return parent::month($fieldName, $options);
	}

/**
 * Returns a SELECT element for hours.
 *
 * ### Attributes:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` The selected value of the input.
 * - `format` Set to 12 or 24 to use 12 or 24 hour formatting. Defaults to 12.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $attributes List of HTML attributes
 * @return string Completed hour select input
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::hour
 */
	public function hour($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.hour', $this, $args);
		extract((array)$event->result);

		return parent::hour($fieldName, $options);
	}

/**
 * Returns a SELECT element for minutes.
 *
 * ### Attributes:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` The selected value of the input.
 * - `interval` The interval that minute options should be created at.
 * - `round` How you want the value rounded when it does not fit neatly into an
 *   interval. Accepts 'up', 'down', and null.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Array of options.
 * @return string Completed minute select input.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::minute
 */
	public function minute($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.minute', $this, $args);
		extract((array)$event->result);

		return parent::minute($fieldName, $options);
	}

/**
 * Returns a SELECT element for AM or PM.
 *
 * ### Attributes:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` The selected value of the input.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Array of options
 * @return string Completed meridian select input
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::meridian
 */
	public function meridian($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.meridian', $this, $args);
		extract((array)$event->result);

		return parent::meridian($fieldName, $options);
	}

/**
 * Returns a set of SELECT elements for a full datetime setup: day, month and year, and then time.
 *
 * ### Date Options:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 *   that string is displayed as the empty element.
 * - `value` | `default` The default value to be used by the input. A value in `$this->data`
 *   matching the field name will override this value. If no default is provided `time()` will be used.
 * - `monthNames` If false, 2 digit numbers will be used instead of text.
 *   If an array, the given array will be used.
 * - `minYear` The lowest year to use in the year select
 * - `maxYear` The maximum year to use in the year select
 * - `orderYear` - Order of year values in select options.
 *   Possible values 'asc', 'desc'. Default 'desc'.
 *
 * ### Time options:
 *
 * - `empty` - If true, the empty select option is shown. If a string,
 * - `value` | `default` The default value to be used by the input. A value in `$this->data`
 *   matching the field name will override this value. If no default is provided `time()` will be used.
 * - `timeFormat` The time format to use, either 12 or 24.
 * - `interval` The interval for the minutes select. Defaults to 1
 * - `round` - Set to `up` or `down` if you want to force rounding in either direction. Defaults to null.
 * - `second` Set to true to enable seconds drop down.
 *
 * To control the order of inputs, and any elements/content between the inputs you
 * can override the `dateWidget` template. By default the `dateWidget` template is:
 *
 * `{{month}}{{day}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}`
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Array of Options
 * @return string Generated set of select boxes for the date and time formats chosen.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::dateTime
 */
	public function dateTime($fieldName, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.dateTime', $this, $args);
		extract((array)$event->result);

		return parent::dateTime($fieldName, $options);
	}

/**
 * Generate time inputs.
 *
 * ### Options:
 *
 * See dateTime() for time options.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Array of Options
 * @return string Generated set of select boxes for time formats chosen.
 * @see Cake\View\Helper\FormHelper::dateTime() for templating options.
 */
	public function time($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.time', $this, $args);
		extract((array)$event->result);

		return parent::time($fieldName, $options);
	}

/**
 * Generate date inputs.
 *
 * ### Options:
 *
 * See dateTime() for date options.
 *
 * @param string $fieldName Prefix name for the SELECT element
 * @param array $options Array of Options
 * @return string Generated set of select boxes for time formats chosen.
 * @see Cake\View\Helper\FormHelper::dateTime() for templating options.
 */
	public function date($fieldName, $options = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.date', $this, $args);
		extract((array)$event->result);

		return parent::date($fieldName, $options);
	}

/**
 * Add a new context type.
 *
 * Form context types allow FormHelper to interact with
 * data providers that come from outside CakePHP. For example
 * if you wanted to use an alternative ORM like Doctrine you could
 * create and connect a new context class to allow FormHelper to
 * read metadata from doctrine.
 *
 * @param string $type The type of context. This key
 *   can be used to overwrite existing providers.
 * @param callable $check A callable that returns a object
 *   when the form context is the correct type.
 * @return void
 */
	public function addContextProvider($name, callable $check) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.addContextProvider', $this, $args);
		extract((array)$event->result);

		return parent::addContextProvider($name, $check);
	}

/**
 * Get the context instance for the current form set.
 *
 * If there is no active form null will be returned.
 *
 * @return null|\Cake\View\Form\ContextInterface The context for the form.
 */
	public function context() {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.context', $this, $args);
		extract((array)$event->result);

		return parent::context();
	}

/**
 * Add a new widget to FormHelper.
 *
 * Allows you to add or replace widget instances with custom code.
 *
 * @param string $name The name of the widget. e.g. 'text'.
 * @param array|WidgetInterface Either a string class name or an object
 *    implementing the WidgetInterface.
 * @return void
 */
	public function addWidget($name, $spec) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.addWidget', $this, $args);
		extract((array)$event->result);

		return parent::addWidget($name, $spec);
	}

/**
 * Render a named widget.
 *
 * This is a lower level method. For built-in widgets, you should be using
 * methods like `text`, `hidden`, and `radio`. If you are using additional
 * widgets you should use this method render the widget without the label
 * or wrapping div.
 *
 * @param string $name The name of the widget. e.g. 'text'.
 * @param array $attrs The attributes for rendering the input.
 * @return void
 */
	public function widget($name, array $data = []) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.widget', $this, $args);
		extract((array)$event->result);

		return parent::widget($name, $data);
	}

/**
 * Restores the default values built into FormHelper.
 *
 * This method will not reset any templates set in custom widgets.
 *
 * @return void
 */
	public function resetTemplates() {
		$args = get_defined_vars();
		$event = $this->event('Helper.Form.resetTemplates', $this, $args);
		extract((array)$event->result);

		return parent::resetTemplates();
	}
}