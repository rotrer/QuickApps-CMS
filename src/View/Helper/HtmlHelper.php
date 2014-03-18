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
 * @since         CakePHP(tm) v 0.9.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace QuickApps\View\Helper;
use QuickApps\Utility\EventTrait;
use Cake\View\Helper\HtmlHelper as CakeHtmlHelper;

/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html
 */
class HtmlHelper extends CakeHtmlHelper {
	use EventTrait;

/**
 * Adds a link to the breadcrumbs array.
 *
 * @param string $name Text for link
 * @param string $link URL for link (if empty it won't be a link)
 * @param string|array $options Link attributes e.g. array('id' => 'selected')
 * @return void
 * @see HtmlHelper::link() for details on $options that can be used.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
 */
	public function addCrumb($name, $link = null, $options = null) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.addCrumb', $this, $args);
		extract((array)$event->result);

		parent::addCrumb($name, $link, $options);
		return $this; // chained add
	}

/**
 * Returns a doctype string.
 *
 * Possible doctypes:
 *
 *  - html4-strict:  HTML4 Strict.
 *  - html4-trans:  HTML4 Transitional.
 *  - html4-frame:  HTML4 Frameset.
 *  - html5: HTML5. Default value.
 *  - xhtml-strict: XHTML1 Strict.
 *  - xhtml-trans: XHTML1 Transitional.
 *  - xhtml-frame: XHTML1 Frameset.
 *  - xhtml11: XHTML1.1.
 *
 * @param string $type Doctype to use.
 * @return string Doctype string
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::docType
 */
	public function docType($type = 'html5') {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.docType', $this, $args);
		extract((array)$event->result);

		return parent::docType($type);
	}

/**
 * Creates a link to an external resource and handles basic meta tags
 *
 * Create a meta tag that is output inline:
 *
 * `$this->Html->meta('icon', 'favicon.ico');
 *
 * Append the meta tag to custom view block "meta":
 *
 * `$this->Html->meta('description', 'A great page', array('block' => true));`
 *
 * Append the meta tag to custom view block:
 *
 * `$this->Html->meta('description', 'A great page', array('block' => 'metaTags'));`
 *
 * ### Options
 *
 * - `block` - Set to true to append output to view block "meta" or provide
 *   custom block name.
 *
 * @param string $type The title of the external resource
 * @param string|array $url The address of the external resource or string for content attribute
 * @param array $options Other attributes for the generated tag. If the type attribute is html,
 *    rss, atom, or icon, the mime-type is returned.
 * @return string A completed `<link />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::meta
 */
	public function meta($type, $url = null, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.meta', $this, $args);
		extract((array)$event->result);
	
		return parent::meta($type, $url, $options);
	}

/**
 * Returns a charset META-tag.
 *
 * @param string $charset The character set to be used in the meta tag. If empty,
 *  The App.encoding value will be used. Example: "utf-8".
 * @return string A meta tag containing the specified character set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::charset
 */
	public function charset($charset = null) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.charset', $this, $args);
		extract((array)$event->result);

		return parent::charset($charset);
	}

/**
 * Creates an HTML link.
 *
 * If $url starts with "http://" this is treated as an external link. Else,
 * it is treated as a path to controller/action and parsed with the
 * HtmlHelper::url() method.
 *
 * If the $url is empty, $title is used instead.
 *
 * ### Options
 *
 * - `escape` Set to false to disable escaping of title and attributes.
 * - `escapeTitle` Set to false to disable escaping of title. (Takes precedence over value of `escape`)
 * - `confirm` JavaScript confirmation message.
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @param string|array $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
 * @param array $options Array of options and HTML attributes.
 * @param string $confirmMessage JavaScript confirmation message.
 * @return string An `<a />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::link
 */
	public function link($title, $url = null, $options = array(), $confirmMessage = false) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.link', $this, $args);
		extract((array)$event->result);

		return parent::link($title, $url, $options, $confirmMessage);
	}

/**
 * Creates a link element for CSS stylesheets.
 *
 * ### Usage
 *
 * Include one CSS file:
 *
 * `echo $this->Html->css('styles.css');`
 *
 * Include multiple CSS files:
 *
 * `echo $this->Html->css(array('one.css', 'two.css'));`
 *
 * Add the stylesheet to view block "css":
 *
 * `$this->Html->css('styles.css', array('block' => true));`
 *
 * Add the stylesheet to a custom block:
 *
 * `$this->Html->css('styles.css', array('block' => 'layoutCss'));`
 *
 * ### Options
 *
 * - `block` Set to true to append output to view block "css" or provide
 *   custom block name.
 * - `plugin` False value will prevent parsing path as a plugin
 * - `rel` Defaults to 'stylesheet'. If equal to 'import' the stylesheet will be imported.
 * - `fullBase` If true the URL will get a full address for the css file.
 *
 * @param string|array $path The name of a CSS style sheet or an array containing names of
 *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
 *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
 * @param array $options Array of options and HTML arguments.
 * @return string CSS <link /> or <style /> tag, depending on the type of link.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::css
 */
	public function css($path, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.css', $this, $args);
		extract((array)$event->result);
	
		return parent::css($path, $options);
	}

/**
 * Returns one or many `<script>` tags depending on the number of scripts given.
 *
 * If the filename is prefixed with "/", the path will be relative to the base path of your
 * application. Otherwise, the path will be relative to your JavaScript path, usually webroot/js.
 *
 *
 * ### Usage
 *
 * Include one script file:
 *
 * `echo $this->Html->script('styles.js');`
 *
 * Include multiple script files:
 *
 * `echo $this->Html->script(array('one.js', 'two.js'));`
 *
 * Add the script file to a custom block:
 *
 * `$this->Html->script('styles.js', null, array('block' => 'bodyScript'));`
 *
 * ### Options
 *
 * - `block` Set to true to append output to view block "script" or provide
 *   custom block name.
 * - `once` Whether or not the script should be checked for uniqueness. If true scripts will only be
 *   included once, use false to allow the same script to be included more than once per request.
 * - `plugin` False value will prevent parsing path as a plugin
 * - `fullBase` If true the url will get a full address for the script file.
 *
 * @param string|array $url String or array of javascript files to include
 * @param array $options Array of options, and html attributes see above.
 * @return mixed String of `<script />` tags or null if block is specified in options
 *   or if $once is true and the file has been included before.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::script
 */
	public function script($url, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.script', $this, $args);
		extract((array)$event->result);

		return parent::script($url, $options);
	}

/**
 * Wrap $script in a script tag.
 *
 * ### Options
 *
 * - `safe` (boolean) Whether or not the $script should be wrapped in <![CDATA[ ]]>
 * - `block` Set to true to append output to view block "script" or provide
 *   custom block name.
 *
 * @param string $script The script to wrap
 * @param array $options The options to use. Options not listed above will be
 *    treated as HTML attributes.
 * @return mixed string or null depending on the value of `$options['block']`
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::scriptBlock
 */
	public function scriptBlock($script, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.scriptBlock', $this, $args);
		extract((array)$event->result);

		return parent::scriptBlock($script, $options);
	}

/**
 * Begin a script block that captures output until HtmlHelper::scriptEnd()
 * is called. This capturing block will capture all output between the methods
 * and create a scriptBlock from it.
 *
 * ### Options
 *
 * - `safe` Whether the code block should contain a CDATA
 * - `block` Set to true to append output to view block "script" or provide
 *   custom block name.
 *
 * @param array $options Options for the code block.
 * @return void
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::scriptStart
 */
	public function scriptStart($options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.scriptStart', $this, $args);
		extract((array)$event->result);

		return parent::scriptStart($options);
	}

/**
 * End a Buffered section of JavaScript capturing.
 * Generates a script tag inline or appends to specified view block depending on
 * the settings used when the scriptBlock was started
 *
 * @return mixed depending on the settings of scriptStart() either a script tag or null
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::scriptEnd
 */
	public function scriptEnd() {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.scriptEnd', $this, $args);
		extract((array)$event->result);

		return parent::scriptEnd();
	}

/**
 * Builds CSS style data from an array of CSS properties
 *
 * ### Usage:
 *
 * {{{
 * echo $this->Html->style(array('margin' => '10px', 'padding' => '10px'), true);
 *
 * // creates
 * 'margin:10px;padding:10px;'
 * }}}
 *
 * @param array $data Style data array, keys will be used as property names, values as property values.
 * @param boolean $oneline Whether or not the style block should be displayed on one line.
 * @return string CSS styling data
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::style
 */
	public function style($data, $oneline = true) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.style', $this, $args);
		extract((array)$event->result);

		return parent::style($data, $oneline);
	}

/**
 * Returns the breadcrumb trail as a sequence of &raquo;-separated links.
 *
 * If `$startText` is an array, the accepted keys are:
 *
 * - `text` Define the text/content for the link.
 * - `url` Define the target of the created link.
 *
 * All other keys will be passed to HtmlHelper::link() as the `$options` parameter.
 *
 * @param string $separator Text to separate crumbs.
 * @param string|array|boolean $startText This will be the first crumb, if false it defaults to first crumb in array. Can
 *   also be an array, see above for details.
 * @return string Composed bread crumbs
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
 */
	public function getCrumbs($separator = '&raquo;', $startText = false) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.getCrumbs', $this, $args);
		extract((array)$event->result);

		return parent::getCrumbs($separator, $startText);
	}

/**
 * Returns breadcrumbs as a (x)html list
 *
 * This method uses HtmlHelper::tag() to generate list and its elements. Works
 * similar to HtmlHelper::getCrumbs(), so it uses options which every
 * crumb was added with.
 *
 * ### Options
 *
 * - `separator` Separator content to insert in between breadcrumbs, defaults to ''
 * - `firstClass` Class for wrapper tag on the first breadcrumb, defaults to 'first'
 * - `lastClass` Class for wrapper tag on current active page, defaults to 'last'
 *
 * @param array $options Array of html attributes to apply to the generated list elements.
 * @param string|array|boolean $startText This will be the first crumb, if false it defaults to first crumb in array. Can
 *   also be an array, see `HtmlHelper::getCrumbs` for details.
 * @return string breadcrumbs html list
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
 */
	public function getCrumbList($options = array(), $startText = false) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.getCrumbList', $this, $args);
		extract((array)$event->result);

		return parent::getCrumbList($options, $startText);
	}

/**
 * Creates a formatted IMG element.
 *
 * This method will set an empty alt attribute if one is not supplied.
 *
 * ### Usage:
 *
 * Create a regular image:
 *
 * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP'));`
 *
 * Create an image link:
 *
 * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP', 'url' => 'http://cakephp.org'));`
 *
 * ### Options:
 *
 * - `url` If provided an image link will be generated and the link will point at
 *   `$options['url']`.
 * - `fullBase` If true the src attribute will get a full address for the image file.
 * - `plugin` False value will prevent parsing path as a plugin
 *
 * @param string $path Path to the image file, relative to the app/webroot/img/ directory.
 * @param array $options Array of HTML attributes. See above for special options.
 * @return string completed img tag
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::image
 */
	public function image($path, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.image', $this, $args);
		extract((array)$event->result);
	
		return parent::image($path, $options);
	}

/**
 * Returns a row of formatted and named TABLE headers.
 *
 * @param array $names Array of tablenames. Each tablename also can be a key that points to an array with a set
 *     of attributes to its specific tag
 * @param array $trOptions HTML options for TR elements.
 * @param array $thOptions HTML options for TH elements.
 * @return string Completed table headers
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::tableHeaders
 */
	public function tableHeaders($names, $trOptions = null, $thOptions = null) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.tableHeaders', $this, $args);
		extract((array)$event->result);

		return parent::tableHeaders($names, $trOptions, $thOptions);
	}

/**
 * Returns a formatted string of table rows (TR's with TD's in them).
 *
 * @param array $data Array of table data
 * @param array $oddTrOptions HTML options for odd TR elements if true useCount is used
 * @param array $evenTrOptions HTML options for even TR elements
 * @param boolean $useCount adds class "column-$i"
 * @param boolean $continueOddEven If false, will use a non-static $count variable,
 *    so that the odd/even count is reset to zero just for that call.
 * @return string Formatted HTML
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::tableCells
 */
	public function tableCells($data, $oddTrOptions = null, $evenTrOptions = null, $useCount = false, $continueOddEven = true) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.tableCells', $this, $args);
		extract((array)$event->result);

		return parent::tableCells($data, $oddTrOptions, $evenTrOptions, $useCount, $continueOddEven);
	}

/**
 * Returns a formatted block tag, i.e DIV, SPAN, P.
 *
 * ### Options
 *
 * - `escape` Whether or not the contents should be html_entity escaped.
 *
 * @param string $name Tag name.
 * @param string $text String content that will appear inside the div element.
 *   If null, only a start tag will be printed
 * @param array $options Additional HTML attributes of the DIV tag, see above.
 * @return string The formatted tag element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::tag
 */
	public function tag($name, $text = null, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.tableHeaders', $this, $args);
		extract((array)$event->result);

		return parent::tag($name, $text, $options);
	}

/**
 * Returns a formatted DIV tag for HTML FORMs.
 *
 * ### Options
 *
 * - `escape` Whether or not the contents should be html_entity escaped.
 *
 * @param string $class CSS class name of the div element.
 * @param string $text String content that will appear inside the div element.
 *   If null, only a start tag will be printed
 * @param array $options Additional HTML attributes of the DIV tag
 * @return string The formatted DIV element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::div
 */
	public function div($class = null, $text = null, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.div', $this, $args);
		extract((array)$event->result);

		return parent::div($class, $text, $options);
	}

/**
 * Returns a formatted P tag.
 *
 * ### Options
 *
 * - `escape` Whether or not the contents should be html_entity escaped.
 *
 * @param string $class CSS class name of the p element.
 * @param string $text String content that will appear inside the p element.
 * @param array $options Additional HTML attributes of the P tag
 * @return string The formatted P element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::para
 */
	public function para($class, $text, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.para', $this, $args);
		extract((array)$event->result);

		return parent::para($class, $text, $options);
	}

/**
 * Returns an audio/video element
 *
 * ### Usage
 *
 * Using an audio file:
 *
 * `echo $this->Html->media('audio.mp3', array('fullBase' => true));`
 *
 * Outputs:
 *
 * `<video src="http://www.somehost.com/files/audio.mp3">Fallback text</video>`
 *
 * Using a video file:
 *
 * `echo $this->Html->media('video.mp4', array('text' => 'Fallback text'));`
 *
 * Outputs:
 *
 * `<video src="/files/video.mp4">Fallback text</video>`
 *
 * Using multiple video files:
 *
 * {{{
 * echo $this->Html->media(
 * 		array('video.mp4', array('src' => 'video.ogv', 'type' => "video/ogg; codecs='theora, vorbis'")),
 * 		array('tag' => 'video', 'autoplay')
 * );
 * }}}
 *
 * Outputs:
 *
 * {{{
 * <video autoplay="autoplay">
 * 		<source src="/files/video.mp4" type="video/mp4"/>
 * 		<source src="/files/video.ogv" type="video/ogv; codecs='theora, vorbis'"/>
 * </video>
 * }}}
 *
 * ### Options
 *
 * - `tag` Type of media element to generate, either "audio" or "video".
 * 	If tag is not provided it's guessed based on file's mime type.
 * - `text` Text to include inside the audio/video tag
 * - `pathPrefix` Path prefix to use for relative URLs, defaults to 'files/'
 * - `fullBase` If provided the src attribute will get a full address including domain name
 *
 * @param string|array $path Path to the video file, relative to the webroot/{$options['pathPrefix']} directory.
 *  Or an array where each item itself can be a path string or an associate array containing keys `src` and `type`
 * @param array $options Array of HTML attributes, and special options above.
 * @return string Generated media element
 */
	public function media($path, $options = array()) {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.meta', $this, $args);
		extract((array)$event->result);
	
		return parent::media($path, $options);
	}

/**
 * Build a nested list (UL/OL) out of an associative array.
 *
 * @param array $list Set of elements to list
 * @param array $options Additional HTML attributes of the list (ol/ul) tag or if ul/ol use that as tag
 * @param array $itemOptions Additional HTML attributes of the list item (LI) tag
 * @param string $tag Type of list tag to use (ol/ul)
 * @return string The nested list
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::nestedList
 */
	public function nestedList($list, $options = array(), $itemOptions = array(), $tag = 'ul') {
		$args = get_defined_vars();
		$event = $this->event('Helper.Html.nestedList', $this, $args);
		extract((array)$event->result);
	
		return parent::nestedList($list, $options, $itemOptions, $tag);
	}
}