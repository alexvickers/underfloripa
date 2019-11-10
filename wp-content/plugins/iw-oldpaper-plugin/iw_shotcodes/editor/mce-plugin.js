(function() {
    tinymce.create('tinymce.plugins.exc', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            
            // add favicon
            
            ed.addCommand('faicon', function() {
                var id = prompt("What icon? (ex. fa-bolt) You can add all the class: http://fortawesome.github.io/Font-Awesome/examples/"), 
                    shortcode;
                shortcode = '[i class="' + id + '"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('faicon', {
                title : 'Add a FontAwesome icon in the text',
                cmd : 'faicon',
                image : url + '/ico-faicon.png'
            });
            
            // add lead text
            
            ed.addCommand('lead', function() {
                var text = prompt("Insert yout lead text here:"), 
                    shortcode;
                shortcode = '[lead]' + text + '[/lead]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('lead', {
                title : 'Add a lead text',
                cmd : 'lead',
                image : url + '/ico-lead.png'
            });
            
            // add posts carousel
            
            ed.addCommand('carousel', function() {
                var category = prompt("What category of posts? (use the slut)"), 
                	count = prompt("How many posts? 1, 2, 3, 6, 10?"),
                	columns = prompt("How many columns? 3, 4?"), 
                    shortcode;
                shortcode = '[carousel category="' + category + '" count="' + count + '" columns="' + columns + '" title="show or hide"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('carousel', {
                title : 'Add a carousel of recent posts',
                cmd : 'carousel',
                image : url + '/ico-carousel.png'
            });
            
            // add posts slider
            
            ed.addCommand('slider', function() {
                var category = prompt("What category of posts? (use the slut)"), 
                	count = prompt("How many posts?"), 
                    shortcode;
                shortcode = '[slider category="' + category + '" count="' + count + '"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('slider', {
                title : 'Add a slider of recent posts',
                cmd : 'slider',
                image : url + '/ico-slider.png'
            });

            
            //add a list of posts
            
            ed.addCommand('posts', function() {
                var shortcode,
                	cat = prompt("Insert the category-slug of the articles to show"),
                	count = prompt("How many posts?");
                shortcode = '[postsincol category="' + cat + '" col="3" count="' + count + '" excerpt="show or hide"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('posts', {
                title : 'A list of last posts in the page',
                cmd : 'posts',
                image : url + '/ico-posts.png'
            });
            
            //add alert
            
            ed.addCommand('alert', function() {
                var shortcode,
                	message = prompt("Insert the message of the alert box");
                shortcode = '[alert type="default or success or info or warning or danger"]'+message+'[/alert]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('alert', {
                title : 'Add an alert box with custom message',
                cmd : 'alert',
                image : url + '/ico-alert.png'
            });
            
            //add progress bar
            
            ed.addCommand('progress', function() {
                var shortcode,
                	percentage = prompt("Insert the percentage of the progress bar (form 0 to 100)");
                shortcode = '[progress type="primary or success or info or warning or danger" percentage="' + percentage + '" showlabel="true or false"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('progress', {
                title : 'Add an progress bar with percentage',
                cmd : 'progress',
                image : url + '/ico-progress.png'
            });
            
            //add a simple grid shortcode
            
            ed.addCommand('grid', function() {
                var shortcode;
                shortcode = '[row][col w="6"] Add content here (w = 1~12 ) [/col][col w="6"] Add content here [/col][/row]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('grid', {
                title : 'Add an example grid with shortcodes',
                cmd : 'grid',
                image : url + '/ico-grid.png'
            });
            
            //hr
            
            ed.addCommand('hr', function() {
                var shortcode,
                	gap = prompt("How many space before and after the line? (ex: 30)");
                	
                shortcode = '[hr gap="' + gap + '"]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('hr', {
                title : 'Insert an horizontal line',
                cmd : 'hr',
                image : url + '/ico-hr.png'
            });
            
            //dropcaps
            
            ed.addCommand('dropcap', function() {
                var shortcode;
                	
                shortcode = '[dropcap style="normal or inverse or boxed"]Y[/dropcap]our text with dropcaps here';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('dropcap', {
                title : 'Insert an dropcap letter at the begin of the text line',
                cmd : 'dropcap',
                image : url + '/ico-dropcap.png'
            });
            
            
            //add a simple button via bootstrap
            
            ed.addCommand('btn', function() {
                var link = prompt("Insert the URL of the link"), 
                	text = prompt("Insert the text of the button"),
                    shortcode;
                shortcode = '[btn type="default or primary or success or info or warning or danger or link" link="' + link + '"]' + text + '[/btn]';
                ed.execCommand('mceInsertContent', 0, shortcode);     
            });
            
            ed.addButton('btn', {
                title : 'Add a button with a link',
                cmd : 'btn',
                image : url + '/ico-btn.png'
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                    longname	: 'exc Buttons',
                    author		: 'Andrea',
                    authorurl	: 'http://www.orangedropdesign.com',
                    infourl		: 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                    version		: "0.1"
            };
        }
        
        
    });

    // Register plugin
    tinymce.PluginManager.add('exc', tinymce.plugins.exc);
})();