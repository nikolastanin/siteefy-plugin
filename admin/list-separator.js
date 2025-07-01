(function() {
    tinymce.create('tinymce.plugins.siteefy_list_separator', {
        init: function(ed, url) {
            ed.addButton('siteefy_list_separator', {
                title: 'Insert List Separator',
                icon: 'dashicon dashicons-minus', // Use a Dashicon
                onclick: function() {
                    ed.insertContent('<!--list-->');
                }
            });

            // Show a placeholder in the editor for <!--list-->
            ed.on('BeforeSetcontent', function(e) {
                e.content = e.content.replace(/<!--list-->/g, '<hr class="siteefy-list-separator-mce" data-mce-content="<!--list-->" />');
            });
            ed.on('GetContent', function(e) {
                e.content = e.content.replace(/<hr class="siteefy-list-separator-mce" data-mce-content="&lt;!--list--&gt;" ?\/?>/g, '<!--list-->');
            });
        }
    });
    tinymce.PluginManager.add('siteefy_list_separator', tinymce.plugins.siteefy_list_separator);
})();