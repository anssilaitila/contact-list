=== WordPress Staff List, Address Book and Business Directory Plugin - Contact List ===
Contributors: anssilaitila, freemius
Tags: staff list, employee list, business directory, church directory, address book
Requires at least: 4.0.0
Tested up to: 5.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create staff list or any contact list for your site. Import existing data easily.

== Description ==
= The most user friendly contact manager for WordPress =
Using Contact List you can list any contact data including i.e. name, email, phone and social media links. Contacts may also have necessary custom fields.

Send email directly to contacts using a built-in form on the front-end (featuring reCAPTCHA). Contact's email address can be completely hidden in the Pro version but still email can be sent to the contact.

**14 days free trial available for Pro version, no credit card required.**

See live demos at [contactlistpro.com](https://www.contactlistpro.com/contact-list/).

= Some use cases for this plugin: =
* Staff list
* Contact directory
* List of any kind of contacts like companies or offices
* Phone book
* Faculty and Staff Directory
* Medical Staff Directory
* Church Directory
* Directory of Doctors and Medical Staff
* Employee Directory
* Medical Personnel Directory
* Team Members Directory
* Send newsletter or any email to a specific group of people

= Fields for each contact: =
* First name
* Last name
* Job title
* Email
* Phone
* LinkedIn URL
* Twitter URL
* Facebook URL
* Address (incl. country and state)
* Custom fields
* WYSIWYG editor
* Category
* Photo / image
* Multiple custom fields

= Features in the Free version: =
* Obfuscated emails to prevent spam
* Simple and clean user interface
* No options to set, ready to use right away
* Contacts may belong to groups
* Fast search targeting all contacts
* Filter contacts by country, state and category
* 1 custom field
* Choose a layout from 4 different ones
* All sent mail is logged
* Printable contact list

= More features in the Pro version: =
* Multiple different shortcodes/views for various use cases
* Support for pagination
* Contact database may be built with publicly available form
* 6 custom fields and WYSIWYG editor
* Settings available for customization
* Send email to all contacts or contacts in a specific group
* reCAPTCHA can be activated to public contact forms
* Import contacts from CSV file
* Export contacts to a CSV file
* Customize fields in any way: change titles and hide specific fields from public form or admin area
* Request contacts to update their existing contact info simply clicking a button
* More features on the way based on user feedback

Contact author [here](https://www.contactlistpro.com/support/).

== Installation ==

1. Activate the plugin from WordPress plugin directory or manually upload it to your site
2. See the Help / Support page for further instructions

== Screenshots ==

1. List of contacts on your site
2. Send message to a contact
3. List of contacts in 4 columns (more layout options available)
4. Simple list
5. Form for gathering the contact database (including more fields)
6. Contact management

== Changelog ==

= 2.9.21 =
* New tab in settings: Simple list
* More texts customizable via settings
* Shortcode documentation updated
* Bug fixes

= 2.9.20 =
* Shortcodes and copy buttons added to Groups -page
* Shortcodes for single contacts and copy buttons added to contact management
* Filters can now be shown for shortcode [contact_list_groups] when a group is pre-defined: [contact_list_groups group=group-slug show_filters=1]
* Shortcodes [contact_list] and [contact_list_groups] can now be ordered with parameter order_by: [contact_list order_by=first_name] | [contact_list order_by=last_name]
* Bug fixes
* CSS fixes

= 2.9.19 =
* New feature: Copy to clipboard -buttons added to Help / Support -page
* New feature (Pro): filters for [contact_list_simple] -> [contact_list_simple show_filters=1] -> See demo: https://www.contactlistpro.com/contact-list/simple-list-with-filters/
* New feature (Pro): 2 more phone fields added for contacts
* Missing Instagram URL added to import & export tool
* CSS fixes
* Social media icons added to admin list
* Freemius SDK updated to 2.4.1 (https://github.com/Freemius/wordpress-sdk/releases/tag/2.4.1)

= 2.9.18 =
* New shortcode: [contact_list_simple] (See https://www.contactlistpro.com/contact-list/simple-list/)

= 2.9.17 =
* CSS fixes

= 2.9.16 =
* Another JS-issue fixed

= 2.9.15 =
* jQuery-issue fixed

= 2.9.14 =
* New option: focus on search field on page load (see "General settings" tab)

= 2.9.13 =
* If an email is entered as a custom field value, it is now automatically converted to a mailto link
* Search now finds both "firstname lastname" and "lastname firstname"

= 2.9.12 =
* Country and state -dropdowns are now sorted alphabetically
* Bug fixes

= 2.9.11 =
* Bug fix: removed unnecessary notification from groups-view

= 2.9.10 =
* Country and state are now displayed also when no other address data is present

= 2.9.9 =
* Country and state added to contact card

= 2.9.8 =
* Some improvements to the printable list
* Bug fixes

= 2.9.7.1 =
* Bug fixes

= 2.9.7 =
* Freemius SDK update
* Tested up to: WP 5.5

= 2.9.6 =
* New setting: Show last name before first name
* New feature: Printable list for contacts
* Fix: Export tool should now handle special characters correctly

= 2.9.5 =
* Markup fixes

= 2.9.4 =
* Adding new contact was broken in the last update, and this is now fixed

= 2.9.3 =
* New field for contacts "Notify emails": if there are email addresses in this field, they will also be recipients for emails sent to that contact using the front-end form
* Bug fixes

= 2.9.2 =
* Plugin settings made more usable
* 1 custom field added to free version
* More icons for custom fields
* New setting: activate monochrome or sepia effect on contact images to make more consistent appearance

= 2.9.1 =
* New field for contacts: Instagram URL
* URLs in custom fields are now automatically turned into links

= 2.9.0 =
* Country and state added to import & export tool
* [contact_list_groups] now also supports the GET-parameter contact_id

= 2.8.9 =
* New feature (Pro): Export contacts to a csv file
* New feature (Pro): Single contact can now be displayed using GET-parameter like so: https://www.contactlistpro.com/contact-list/?contact_id=35 (when [contact_list]-shortcode is used on that page)
* Minor bug fixes

= 2.8.8 =
* Contact email address is now hidden from the modal box if "Hide contact email from contact card" is checked in settings
* Bug fixed regarding writing mail log

= 2.8.7 =
* reCAPTCHA added to [contact_list_form]-view
* Category, country and state dropdown change now updates the results without loading the whole page again
* Bug fixes
* New settings

= 2.8.6 =
* More features are now free: search using [contact_list]-shortcode, filter contacts by categories and layout options (see settings)
* Pro: Layout options now usable in [contact_list_groups]-view (bug fixed)
* Pro: reCAPTCHA for sending messages (may be activated from the settings)
* Pro: New settings for sending email
* Pro: All sent mail is now logged (see the mail log page in the admin area)
* Pro: Contact's email address may now be hidden from contact card still keeping the Send message -button there (see settings)

= 2.8.5 =
* Sending message to a single contact fixed
* More texts made translatable

= 2.8.2 =
* Bug fix

= 2.8.1 =
* Mail delivery is now handled locally by WordPress
* Bug fixes

= 2.8.0 =
* New feature (Pro): New shortcode [contact_list_search], see Help / Support -page
* Some minor bug fixes

= 2.7.6 =
* Support for custom fields added to public form

= 2.7.5 =
* Bug fixes

= 2.7.4 =
* New feature (Pro): Send message to single contacts on contact list

= 2.7.3 =
* New feature (Pro): Define border for contact cards
* New feature (Pro): Imported data may now contain groups

= 2.7.2 =
* New feature (Pro): Option to hide a group from the front-end

= 2.7.1 =
* Settings page made more usable
* New features (Pro): 2 more custom fields and options to set icons instead of titles for custom fields (see settings)

= 2.7.0 =
* New feature (Free & Pro): Request update for contact
* New feature (Pro): Sent mail is now logged

= 2.6.2 =
* Bug fixes

= 2.6.1 =
* Bug fixes

= 2.6.0 =
* New feature: Pagination for contact list (see settings)
* New feature: 4 different layouts (default list and contacts side by side, see options)
* New fields: Country and state
* New feature: Filter contacts by country, state and category (see options)

= 2.5.5 =
* Bug fix: sending email to deeper level subcategory now works

= 2.5.4 =
* More settings to hide any fields from admin area
* Email can now be sent to contacts in specific groups

= 2.5.3 =
* Bug fixes

= 2.5.2 =
* Upgrade link added

= 2.5.1 =
* Minor updates

= 2.5.0 =
* New licensing model / 2019-12-04

= 1.0.0 =
* Initial release / 2018-07-13
