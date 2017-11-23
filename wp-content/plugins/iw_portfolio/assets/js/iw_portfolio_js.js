/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {

    var frame;
    //Get image from wp library
    jQuery('.button-add-image .add-new-image').click(function () {
        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: true,
            library: {
                type: 'image'
            }
        };

        frame = wp.media(options).open();

        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection');
                    models.each(function (e) {
                        var url = e.attributes.url;
                        var item_control = '<div class="iw-image-item">';
                        item_control += '<div class="action-overlay">';
                        item_control += '<span class="remove-image">x</span>';
                        item_control += '</div>';
                        item_control += '<img src="' + url + '" width="150"/>';
                        item_control += '<input type="hidden" value="' + e.attributes.id + '" name="iw_information[image_gallery][]"/>';
                        jQuery('.iwc-metabox-fields .list-image-gallery').append(item_control);
                    });
                    frame.close();
                }
            } // end insert
        });
    });


    //Remove image from list gallery
    jQuery('.list-image-gallery .action-overlay .remove-image').live('click', function () {
        jQuery(this).parents('.iw-image-item').hide(200).remove();
    });

});
