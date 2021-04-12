=== WordPress Business Directory, Staff Directory and Address Book Plugin - Contact List ===
Contributors: anssilaitila, freemius
Tags: business directory, business listing, staff directory, staff list, address book, company directory, church directory, contact directory, directory, contacts, directory plugin, chamber of commerce
Requires at least: 4.0.0
Tested up to: 5.7
Stable tag: 2.9.32
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A full-featured directory plugin for creating a business directory, staff directory or an address book. Usable for chamber of commerce, company directory and many more...

== Description ==
= The most user friendly business directory for WordPress =
Create an address book or a company directory with ease. With this directory plugin you can list any contact data including i.e. name, email, phone and social media links. Contacts or businesses may also have necessary custom fields.

Send email directly to contacts using a built-in form on the front-end (featuring reCAPTCHA). Contact's email address can be completely hidden in the Pro version but still email can be sent to the contact.

**7-day free trial available for Pro version, no credit card required.**

See live demos at [contactlistpro.com](https://www.contactlistpro.com/contact-list/).

= Contact List Free features: =
* <strong>Send email directly to contacts from the frontend form</strong>
* <strong>2 different views: a complete list of all contact data and a simpler table type view</strong>
* Obfuscated emails to prevent spam
* Contacts may belong to groups
* Fast search targeting all contacts
* Filter contacts by country, state, city and category (country and state can be renamed and used for any kind of information)
* <strong>Country and state dropdowns are generated automatically from contact data</strong>
* 1 custom field
* Choose a layout from 4 different ones
* All sent mail is logged
* Printable contact list

= Contact List Pro features: =
* Multiple different shortcodes/views for various use cases
* Support for pagination
* Contact database may be built with publicly available form
* 6 custom fields and WYSIWYG editor
* Settings available for customization
* Send email to all contacts or contacts in a specific group
* reCAPTCHA can be activated to public contact forms
* Excel import: <strong>Import contacts from a CSV file</strong>
* Excel export: <strong>Export contacts to a CSV file</strong>
* Customize fields in any way: change titles and hide specific fields from public form or admin area
* Request contacts to update their existing contact info simply clicking a button
* <strong>More features on the way based on user feedback</strong>

= Some use cases for this plugin: =
* Address book
* Business directory
* Online directory
* Member directory
* Contact directory
* Business listing
* Yellow pages directory
* List of any kind of contacts like companies or offices
* Phone book
* Faculty and Staff Directory
* Medical Staff Directory
* Church Directory
* Directory of Doctors and Medical Staff
* Employee Directory
* Medical Personnel Directory
* Team Members Directory
* Staff list
* Chamber of commerce
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
* Address (incl. country, state and city in separate fields)
* Custom fields
* WYSIWYG editor
* Category
* Photo / image
* Multiple custom fields

Contact author [here](https://www.contactlistpro.com/support/).

== Installation ==

1. Activate the plugin from WordPress plugin directory or manually upload it to your site
2. See the Help / Support page for further instructions

== Frequently Asked Questions ==

= Can I use the plugin for business listing? =

Yes! Contact List is suitable for listing any kind of contact information. Basically you can use it for any kind of online directory.

= Can I use it for listing company staff? =

Yes! Contact List is the perfect WP staff list plugin for creating any kind of member directory. 

= Do you offer support? =

Of course! We offer support in the forums here on WordPress.org and if you have a paid subscription we offer priority email support.

= Does Contact List Free or Contact List Pro work with some other plugin? =

You may contact us directly [here](https://www.contactlistpro.com/support/) if there's any kind of compatibility issue with some other plugin. We will then do our best to solve that issue.

= Can the visitors add contacts? =

That kind of contact form is a feature in the Pro version. Using that form you can collect contact data with a publicly available form from anyone who has access to the page that the form is on.

= Can I use the plugin as a contact manager? =

Yes, you can use it as a contact manager. You don't necessarily have to add any publicly available list of contacts on your site, you can just use the admin tools to manage contacts.

= Is this a business directory, staff directory, yellow pages directory or what? =

You can use the Contact List plugin for any purpose that suits your needs. That could be yellow pages, business listing, member directory, staff list or pretty much anything you can think of. The basic idea is to present a user friendly list of contacts on your site. :)

== Screenshots ==

1. List of contacts on your site
2. Send message to a contact
3. List of contacts in 4 columns (more layout options available)
4. Simple list
5. Form for gathering the contact database (including more fields)
6. Contact management

== Changelog ==

= 2.9.32 - 2021-04-12 =
* Pro: New shortcode [contact_list_send_email group=GROUP_SLUG]. Can be used to send email to a group from the frontend.
* Pro: Missing country, state and city added to shortcode [contact_list_form] (can be hidden from the settings)
* Bug fixes

= 2.9.31 - 2021-03-17 =
* (Pro) Fix regarding the shortcode [contact_list_groups groups__and="groups-slug-1,group-slug-2"]: now only the contacts belonging to all of these groups are listed
* (Pro) City added to simple list search
* (Free and Pro) New setting (Layout-tab): "Show contact images when using 3 or 4 columns view"
* Some minor bug fixes

= 2.9.30 - 2021-03-16 =
* New setting: "Disable mail log"
* New feature: Empty mail log
* New parameter for [contact_list_groups]: You can now define many groups like so (comma separated group slugs): [contact_list_groups groups__and="groups-slug-1,group-slug-2"] (the contacts must belong to all of these groups)
* Fix: setting "Hide job title" for simple list now works normally
* Fix: search for simple list now searches all contacts instead of the ones visible on current page (when using pagination)
* Fix: sender email address is now shown also in the email content
* Fix for [contact_list_form]: Extra numbers removed after custom field titles

= 2.9.29 - 2021-02-16 =
* (Pro): Support for pagination added to simple list
* (Pro): New parameter for simple list: [contact_list_simple contacts_per_page=20] (20 can be any number)
* Freemius WordPress SDK updated

= 2.9.28 - 2021-02-01 =
* (Free and Pro): Support for alt text added to contact image and social media icons

= 2.9.27 - 2021-01-20 =
* (Free and Pro) Affiliation program introduced. Also a new setting (Pro): "Hide affiliation link"
* (Pro) Fix to the import tool: line endings in the CSV file are now detected in a more reliable way
* (Pro) New setting for simple list: "Show titles for columns"
* (Pro) New setting for simple list: "Show city"
* (Pro) 2 new settings for sent emails: "Email footer text" and "Remove email footer completely"

= 2.9.26 - 2021-01-14 =
* Photo added to public contact form
* CSS fixes

= 2.9.25 - 2021-01-02 =
* Minor improvements and bug fixes

= 2.9.24 - 2020-12-19 =
* New field: City. Works together with country and state.
* Pro: Fields country, state and city can now be renamed in the settings
* You can now add multiple instances of [contact_list_groups group=GROUP_SLUG] and [contact_list_search] to the same page, and they all work as they should
* Bug fixes

= 2.9.23 - 2020-12-05 =
* New feature (Pro): Exclude contacts using parameter exclude="123,456,789" (for all shortcodes, comma separated list of contact id's)
* New feature (Free & Pro): Simple list added to printable list options
* New parameter (Pro): group-parameter for simple list to show contacts from a specific group: [contact_list_simple group=GROUP_SLUG]
* New parameter (Pro): card_height-parameter can now be defined for each shortcode like so: [contact_list card_height=200]
* New option (Pro): Show send message -button for simple list
* New feature (Pro): Category dropdown (search filter) now supports subcategories and shows the number of contacts (can be reverted back to the previous, simpler version from the settings)
* New feature/option (Pro): Link country and state (on Layout-tab in the settings). Country and state (or whatever you are using them for) can now be linked, meaning that a country must be selected first, and then the available states for that country will be displayed in the state dropdown.

= 2.9.22 =
* 2 more options on Layout-tab: "Show groups on contact card" and "Title above the groups"
* Texts for dropdowns "Select country" and "Select state" can now be renamed

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

= 2.4.0 =
* Contacts can now be sorted by custom order
* Image field added for contacts
* User submitted contacts can now be automatically published (see options)

= 2.3.11 =
* Bug fix
* New option: "Show contacts from subgroups in the main group view". If this is checked, all contacts belonging to any subgroups are listed below the main group contacts. If not, there are links to any subgroups under the main group title.

= 2.3.10 =
* Bug fix
* Some new options
* Custom fields added to CSV import

= 2.3.9 =
* New feature: CSV import

= 2.3.8 =
* Bug fix

= 2.3.7 =
* Bug fixes
* 4 custom fields added

= 2.3.6 =
* "Back"-link made fully customizable
* Finnish translations added

= 2.3.5 =
* More texts made translatable
* Some more options

= 2.3.4 =
* Plugin made translatable

= 2.3.3 =
* New feature: Send email to contacts

= 2.3.2 =
* New setting: you may now define whether the contacts are sorted by last name or first name

= 2.3.1 =
* New feature: display group checkboxes on the public form (may be activated in the settings)

= 2.3.0 =
* New feature: email notify when a new contact is added (may be activated in the settings)

= 2.2.1 =
* Updated Help / Support page
* Minor bug fixes

= 2.2.0 =
* New shortcodes for displaying contacts from specific group and for a single contact (see Help / Support page)

= 2.1.1 =
* Missing fields added to settings page: email and social media urls
* Groups list view modified so that there's not limitation regarding the depth of group/subgroup hierarchy anymore

= 2.1.0 =
* Settings page added: You may now define alternative field titles and texts to be used throughout the plugin
* Groups list view made more simple: There is now only one search form, targeting all contacts in every group

= 2.0.1 =
* Fixes relating to the new shortcode views

= 2.0.0 =
* New feature: Contacts may now optionally belong to group(s)
* New feature: Possibility to embed a form to any page to allow visitors to add new contacts (with spam prevention)
* New shortcodes for embeddable form and groups list (see Help / Support -page)

= 1.1.0 =
* New field for contacts added: Additional information (wysiwyg-editor)

= 1.0.6 =
* Added feedback form to Help / Support page

= 1.0.5 =
* Public contact list is now sorted by last name (and if necessary by first name) + admin view is sortable the same way (last name column is clickable).

= 1.0.4 =
* Support page updated

= 1.0.3 =
* Added 4 fields for contact address

= 1.0.2 =
* Bug fixes
* Housekeeping
* Testing on Gutenberg

= 1.0.1 =
* Social media icons added

= 1.0.0 =
* Initial release / 2018-07-13
