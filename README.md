# Frequently Searched Words
https://wordpress.org/plugins/wp-frequently-searched-words/

It is possible to register and display frequently searched words in site search.

## Description

You can check the count number of words searched in the site search in the administration menu.
If you paste the following shortcode into a template, post, etc., you can output it.

[ Example ]
```
<?php
if ( shortcode_exists( 'wp-frequently-searched-words' ) ) {
	echo do_shortcode( '[wp-frequently-searched-words]' );
}
?>
```

### Attributes that can be set for short code

- id    : e.g) id="example"
- class : e.g) class="example"
- limit : e.g) limit="5" (default: 10)

## Changelog

### 1.0.0 (2017-02-24)
- The first release.