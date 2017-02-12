=== Frequently Searched Words ===
Contributors: miiitaka
Tags: search, shortcode
Requires at least: 4.7.2
Tested up to: 4.7.2
Stable tag: 1.0.0

It is possible to register and display frequently searched words in site search.

== Description ==

You can check the count number of words searched in the site search in the administration menu.
If you paste the following shortcode into a template, post, etc., you can output it.

[ Example ]
`
<?php
if ( shortcode_exists( 'wp-frequently-searched-words' ) ) {
	echo do_shortcode( '[wp-frequently-searched-words]' );
}
?>
`

= Attributes that can be set for short code =

* id    : e.g) id="example"
* class : e.g) class="example"
* limit : e.g) limit="5" (default: 10)

== Installation ==

* A plug-in installation screen is displayed in the WordPress admin panel.
* It installs in `wp-content/plugins`.
* The plug-in is activated.

== Screenshots ==


== Changelog ==

= 1.0.0 (2017-02-xx) =
* The first release.

== Contact ==

* email to foundationmeister[at]outlook.com
* twitter @miiitaka