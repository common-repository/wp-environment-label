=== WP Environment Label ===
Contributors: konradwww,konradwww2
Tags: label, environment, development label, staging label, environment info
Requires at least: 3.7
Requires PHP >=: 5.4
Tested up to: 4.9.1
Stable tag: 1.1
License: GPLv2 or later

WP Environment Label - shows label with current server/environment name defined by config or admin-panel.

== Description ==

WP Environment Label shows on the frontside and in admin panel small label in the right bottom corner of screen. You can define name over config variable 'WP_ENVIRONMENT_LABEL', alternative you can do it over settings section.

== Installation ==

Upload the WP Environment Label plugin to your blog, Activate it, then set in your wp-config.php:

define('WP_ENVIRONMENT_LABEL', 'YOUR_LABEL_NAME');


== Changelog ==
= 1.1 =
*Release Date - 19.10.2017*

* Added contributor konradwww2
* Added Wordpress Version and PHP Version check
* Label css style z-index increased to 9999999

= 1.0 =
*Release Date - 12.10.2017*

* First public release
