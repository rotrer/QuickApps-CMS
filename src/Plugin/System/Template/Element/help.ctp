<h2>About</h2>
<p>
	The System plugin is integral to the site, and provides basic but extensible functionality for use by other plugins and themes.
	Some integral elements of QuickApps are contained in and managed by the System plugin, including caching, enabling and disabling plugins and themes and configuring fundamental site settings.
</p>

<h2>Uses</h2>
<dl class="dl-inline">
	<dt>Hooktags</dt>
	<dd>
		<p>
			A Hooktag is a QuickApps-specific code that lets you do nifty things with very little effort.
			Hooktags can for example print current language code/name/nativeName or call especifics plugins/themes functions.
			For example, block plugin has the 'block' hooktag which will print out the indicated block by id:
		</p>

		<p>Plugins and themes are able to define their own hooktags.</p>

		<hr />

		Some useful built-in Hookags are:
		<p>
			<code>[locale OPTION/]</code>
			<p>
				Possible values of OPTION are: <em>code, name, native or direction.</em>
				<ul>
					<li><strong>code</strong>: Returns language's <a href="http://www.sil.org/iso639-3/codes.asp" target="_blank">ISO 639-2 code</a> (en, es, fr, etc)</li>
					<li><strong>name</strong>: Returns language's english name (English, Spanish, German, French, etc)</li>
					<li><strong>native</strong>: Returns language's native name (English, Español, Deutsch, Fraçais, etc)</li>
					<li><strong>direction</strong>: Returns direction that text is presented. <em>lft</em> (Left To Right) or <em>rtl</em> (Right to Left)</li>
				</ul>
			</p>
		</p>

		<p>
			<code>[locale /]</code>
			<p>Shortcut for [language code] which return current language code (en, es, fr, etc).</p>
		</p>

		<p>
			<code>[t domain=DOMAIN]text to translate by domain[/t]</code>
			<p>Search for translation in specified domain, e.g: [t domain=System]Help[/t] will try to find translation for <em>Help</em> in <em>System</em> plugin translation table.</p>
		</p>

		<p>
			<code>[t]text to translate using default domain[/t]</code>
			<p>
				Search for translation in (in the following order, if one fails then try the next method):
				<ul>
					<li>active runing plugin domain.</li>
					<li>default domain ([t domain=default]...[/t]). </li>
					<li>translatable entries table. (see <em>Locale</em> plugin)</li>
				</ul>
			</p>
		</p>

		<p>
			<code>[url]/some_path/image.jpg[/url]</code>
			<p>Return well formatted url. URL can be an relative url (/type-of-content/my-post.html) or external (http://www.example.com/my-url).</p>
		</p>

		<p>
			<code>[date format=FORMAT]TIME_STAMP_OR_ENGLISH_DATE[/date]</code>
			<p>
				Returns php result of <em>date(FORMAT, TIME_STAMP_OR_ENGLISH_DATE)</em>. <a href="http://www.php.net/manual/function.date.php" target="_blank">More info about date()</a><br/>
				It accepts both: numeric time stamp or english formatted date (Year-month-day Hours:Mins:Secs) as second parameter.
			</p>
		</p>

		<p>
			<code>[date format=FORMAT /]</code>
			<p>Returns php result of <em>date(FORMAT)</em>. <a href="http://www.php.net/manual/function.date.php" target="_blank">More info about date()</a></p>
		</p>

		<p>
			<code>[rand]values,by,comma[/rand]</code>
			<p>
				Returns a radom value from the specified group. e.g.: [rand]one,two,three[/rand].<br />
				If only two numeric values are given as group, then PHP function <a href="http://www.php.net/manual/function.rand.php" target="_blank">rand</a>(num1, num2) is returned. e.g.: [rand=3,10]
			</p>
		</p>
	</dd>

	<dt>Managing plugins</dt>
	<dd>
		The System plugin allows users with the appropriate permissions to enable and disable plugins on the
		<?php echo $this->Html->link('Plugins administration page', '/admin/system/plugins'); ?>.
		QuickAppsCMS comes with a number of core plugins, and each plugin provides a discrete set of features and may be enabled or disabled depending on the needs of the site.
	</dd>

	<dt>Managing themes</dt>
	<dd>
		The System plugin allows users with the appropriate permissions to enable and disable themes on the <a href="<?php echo $this->Html->url('/admin/system/themes'); ?>">Appearance administration page</a>.
		Themes determine the design and presentation of your site.
		QuickAppsCMS comes packaged with one core theme (Default).
	</dd>

	<dt>Configuring basic site settings</dt>
	<dd>
		The System plugin also handles basic configuration options for your site,
		including Date and time settings, Site name and other information</a>.
	</dd>
</dl>