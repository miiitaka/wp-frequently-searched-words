=== Frequently Searched Words ===
Contributors: miiitaka
Tags: search, shortcode
Requires at least: 4.7.2
Tested up to: 4.8.1
Stable tag: 1.0.6

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

1. Save the word you searched in the site search and display it in a favorite place with a short code.

2. You can see the number of words searched on the administration menu.

== Changelog ==

= 1.0.6 (2017-08-23) =
* Checked : WordPress version 4.8.1 operation check.

= 1.0.5 (2017-06-15) =
* Checked : WordPress version 4.8.0 operation check.

= 1.0.4 (2017-05-19) =
* Checked : WordPress version 4.7.5 operation check.

= 1.0.3 (2017-05-02) =
* Fixed : Half width conversion omission.

= 1.0.2 (2017-04-24) =
* Checked : WordPress version 4.7.4 operation check.
* Fixed : Exclude whitespace.

= 1.0.1 (2017-03-08) =
* Checked : WordPress version 4.7.3 operation check.

= 1.0.0 (2017-02-24) =
* The first release.

== Contact ==

* email to foundationmeister[at]outlook.com
* twitter @miiitaka