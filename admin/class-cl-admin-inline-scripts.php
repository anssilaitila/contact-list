<?php

class ContactListAdminInlineScripts {

  public function inline_scripts() {

      ?>

      <?php $current_screen = get_current_screen(); ?>
       
      <?php if (isset($current_screen->id) && ($current_screen->id === 'edit-contact' || $current_screen->id === 'edit-contact-group')): ?>
  
        <link rel="stylesheet" href="<?= CONTACT_LIST_URI ?>dist/tipso.min.css">
        <script src="<?= CONTACT_LIST_URI ?>dist/tipso.min.js"></script>
        <script src="<?= CONTACT_LIST_URI ?>dist/clipboard.min.js"></script>
    
        <script>
          
          jQuery(function ($) {

            jQuery(document).on('click', '.contact-list-copy', function (e) {
              e.preventDefault();
            });
              
            var clipboard = new ClipboardJS('.contact-list-copy');
        
            clipboard.on('success', function(e) {

              e.clearSelection();
      
              let clipboardtarget = jQuery(e.trigger).data('clipboard-target');
      
              jQuery(clipboardtarget).tipso({
                content: "<?= __('Shortcode copied to clipboard!', 'contact-list') ?>",
                width: 240
              });
      
              jQuery(clipboardtarget).tipso('show');
              
              setTimeout(function () {
                showpanel(clipboardtarget);
              }, 2000);
              
              function showpanel(clipboardtarget) {
                jQuery(clipboardtarget).tipso('hide');
                jQuery(clipboardtarget).tipso('destroy');
              }
              
            });
        
            clipboard.on('error', function(e) {
  //          console.log(e);
            });
      
          });
  
        </script>
      
      <?php endif; ?>
      
      <?php

  }

}
