jQuery(function ($) {

  $('.contact-list-request-update').on('click', function (e) {

    e.preventDefault();    
    $(this).attr('disabled', true);

    $.ajaxSetup({
      crossDomain: true,
    });

    const CONTACT_ID = $(this).data('contact-id');
    const SITE_URL = $(this).data('site-url');
    const UPDATE_URL = $(this).data('update-url')

    const SITE_DOMAIN = SITE_URL.replace(/(^\w+:|^)\/\//, '');

   
    let subject = 'Update request from ' + SITE_DOMAIN;
    let body = 'You have been requested to update your contact info on site.<br /><h4><a href="' + UPDATE_URL + '">Update contact info</a></h4>';
    let url = 'https://mail.contactlistpro.com/request-update-270/';
    let contact_email = $(this).data('email');
    
    var posting = $.post(url, { subject: subject, body: body, recipient_emails: contact_email });

    posting.done(function(data) {
      
      var posting2 = $.post(url, { subject: subject, body: body, recipient_emails: contact_email, s: data });
     
      posting2.done(function(data2) {
        var content = data2;
        var elem_sel = '.contact-list-request-update-info-' + CONTACT_ID;

        $(elem_sel).empty().append(content);
        $(elem_sel).show();
      });

    });

  });


/* Premium Code Stripped by Freemius */


});
