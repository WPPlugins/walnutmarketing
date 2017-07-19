
(function() {
    tinymce.create('tinymce.plugins.activedemand', {
        init : function(ed, url) {


            ed.addButton('insert_form_shortcode', {
                title : 'Insert Walnut Marketing shortcode',
                cmd : 'insert_form_shortcode',
                image : url + '/icons/favicon.png'
            });


            ed.addCommand('insert_form_shortcode', function() {

                jQuery('#activedemand_editor').dialog({
                    height: 500,
                    width: '600px',
                    buttons: {
                        "Insert Shortcode": function() {

                            var short_code = jQuery('#activedemand_editor input[type=radio]:checked').val();
                            var Editor = tinyMCE.get('content');
                            Editor.focus();
                            Editor.selection.setContent(short_code);


                            jQuery( this ).dialog( "close" );
                        },
                        Cancel: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                }).dialog('open');

            });
        }

    });

    tinymce.PluginManager.add( 'activedemand', tinymce.plugins.activedemand );
})();