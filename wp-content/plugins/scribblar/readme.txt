=== Scribblar ===
Contributors: scribblar
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: admin, tutorials, scribblar
Requires at least: 3.4
Tested up to: 4.4.1
Stable tag: 1.0.20

Provides a way of embedding Scribblar Pro into your WordPress site

== Description ==

This plugin provides a quick way of embedding Scribblar with your WordPress site. It will create a new post type called Room and will allow you to synchronise your Scribblar rooms and users with your WordPress site.

== Installation ==

1. Upload the 'scribblar' folder to the '/wp-content/plugins/' directory
2. Activate the Scribblar plugin through the 'Plugins' menu in WordPress
3. Add your scribblar API key when requested.

== Frequently Asked Questions ==

1. How can I translate the user interface labels?
The languages folder contains a POT file, use it to translate the interface into your own language (http://codex.wordpress.org/Translating_WordPress)


== Screenshots ==
1. An example of the controls for adding a new room.
2. An example of listing and then copying rooms from Scribblar.
3. An example of listing users from Scribblar


== Changelog ==

= 1.0.21 =
* Updated room template.

= 1.0.20 =
* Updated room template.


= 1.0.19 =
* Disabling the user sychronisation.

= 1.0.18 =
* Ability to delete users from Scribblar.
* Ensure the Scribblar rooms are correctly displayed.

= 1.0.17 =
* Add the ability to set the password to a room seperately from WordPress password protection.
* Ensure the new list of Scribblar roles is adhered to in WordPress.

= 1.0.16 =
* Fix the plugin update mechanism.
* Emphasis the password protection for each room.


= 1.0.15 =
* Increase the timeout limit for API requests to 25 seconds.


= 1.0.14 =
* Ensure that password protected rooms request a password for access

= 1.0.13 =
* Room API warning message corrections
* Ensure that rooms copied from Scribblar are indicated that they came from Scribblar
* Indicate any errors when communcation via the API
* Ensure that a user is assigned a WordPress role when copied from Scribblar


= 1.0.12 =
* Pre-select the public option for new rooms

= 1.0.11 =
* Ability to make a room public or to make sure that only authenticated users can access the room.

= 1.0.10 =
* Fix an array merge problem when the plugin is used without being activated

= 1.0.9 =
* Remove the extra Scribblar roles from the WordPress roles

= 1.0.8 =
* Permanently deleting a room on WordPress will now delete it from Scribblar. Please note that adding a room to the bin will not delete it from Scribblar
* Roles are now seperated so you can adjust the Scribblar role seperately from the WordPress roles
* If a user is deleted from Scribblar the link will be removed with that user on Wordpress - the WordPress used is not deleted
* The user listing page now indicates if that user exists on Scribblar and displays an option to copy the user to Scribblar

= 1.0.7 =
* Update to keep Scribblar updated with the latest user details (once a user profile has been linked with Scribblar)
* Update to the room saving to ensure that the room appears on Scribblar
* Checking of user roles between WordPress and Scribblar
* New user role of Moderator - this is to match those that exist on Scribblar

= 1.0.6 =
* Update to the room template
* Update to the room and user synchronisation between WordPress and Scribblar

= 1.0.5 =
* Translation POT file
* Code commenting

= 1.0.4 =
* Ability to synchronise users on WordPress with those in Scribblar

= 1.0.3 =
* Ability to synchronise rooms on WordPress with those in Scribblar

= 1.0.2 =
* API room updates

= 1.0.1 =
* Introduction of the update system

= 1.0 =

* This is the first initial release to test the concept
