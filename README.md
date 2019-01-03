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

### 2.1.0 (2019-01-09)
- Updated : Added line number.
- Check : WordPress version 5.0.2 operation check.
- Check : WordPress version 5.0.1 operation check.
- Check : WordPress version 5.0.0 operation check.

### 2.0.0 (2018-08-08)
- Updated : If there are zero search results, do not register keywords.
- Checked : WordPress version 4.9.8 operation check.
- Checked : WordPress version 4.9.7 operation check.

### 1.1.2 (2018-06-18)
- Checked : WordPress version 4.9.6 operation check.
- Checked : WordPress version 4.9.5 operation check.
- Checked : WordPress version 4.9.4 operation check.
- Checked : WordPress version 4.9.3 operation check.

### 1.1.1 (2018-01-24)
- Checked : WordPress version 4.9.2 operation check.

### 1.1.0 (2017-12-04)
- Checked : WordPress version 4.9.1 operation check.
- Checked : WordPress version 4.9.0 operation check.
- Updated : ShortCode copy.
- Fixed : SSL decode save.

### 1.0.8 (2017-11-07)
- Checked : WordPress version 4.8.3 operation check.

### 1.0.7 (2017-09-25)
- Checked : WordPress version 4.8.2 operation check.

### 1.0.6 (2017-08-23)
- Checked : WordPress version 4.8.1 operation check.

### 1.0.5 (2017-06-15)
- Checked : WordPress version 4.8.0 operation check.

### 1.0.4 (2017-05-19)
- Checked : WordPress version 4.7.5 operation check.

### 1.0.3 (2017-05-02)
- Fixed : Half width conversion omission.

### 1.0.2 (2017-04-24)
- Checked : WordPress version 4.7.4 operation check.
- Fixed : Exclude whitespace.

### 1.0.1 (2017-03-08)
- Checked : WordPress version 4.7.3 operation check.

### 1.0.0 (2017-02-24)
- The first release.