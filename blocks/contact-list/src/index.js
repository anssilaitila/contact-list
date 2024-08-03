/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import { ComboboxControl, CheckboxControl, PanelBody, Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import apiFetch from '@wordpress/api-fetch';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
  edit: ({ attributes, setAttributes }) => {
     const { contactId, hideSearch, hideFilters } = attributes;
     const blockProps = useBlockProps();
     const [contacts, setContacts] = useState([]);
     const [isLoading, setIsLoading] = useState(true);

     useEffect(() => {
       apiFetch({ path: '/wp/v2/contact-list?per_page=100' }).then((contacts) => {
         setContacts(contacts.map(contact => {
           const lastName = contact.last_name || '';
           const firstName = contact.first_name || '';
           const label = `${firstName} ${lastName}`.trim() || '';
           return { label, value: contact.id };
         }));
         setIsLoading(false);
       });
     }, []);

     const handleContactChange = (value) => {
       setAttributes({ contactId: value ? parseInt(value, 10) : 0 });
     };

     return (
       <div {...blockProps}>
         <InspectorControls>
          <PanelBody title={__('Select options', 'contact-list')}>
             <CheckboxControl
               label={__('Hide search', 'contact-list')}
               checked={hideSearch}
               onChange={(value) => setAttributes({ hideSearch: value })}
             />
             <CheckboxControl
                label={__('Hide filters', 'contact-list')}
                checked={hideFilters}
                onChange={(value) => setAttributes({ hideFilters: value })}
              />
             {!isLoading && (
               <ComboboxControl
                 label={__('Contact', 'contact-list')}
                 value={contactId}
                 options={[{ label: __('Select a contact', 'contact-list'), value: 0 }, ...contacts]}
                 onChange={handleContactChange}
               />
             )}
           </PanelBody>
         </InspectorControls>
         <Disabled>
           <ServerSideRender block="contact-list/contacts-default" attributes={{ contactId, hideSearch, hideFilters }} />
         </Disabled>
       </div>
     );
   },
   save: () => {
     return null; // Server-side rendering is used.
   },
} );
