(function() {
	'use strict';

    tinymce.create('tinymce.plugins.Shortcodes', {

        init : function(ed, url) {
        },
        createControl : function(n, cm) {

            if(n=='Shortcodes'){
				var selected;
				var content;
                var mlb = cm.createListBox('Shortcodes', {
                     title : 'Shortcodes',
                     onselect : function(v) {
                        if(v == 'Tabs'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[tabgroup][tab title="Tab 1"]'+selected+'[/tab][tab title="Tab 2"]Enter Text Here[/tab][/tabgroup]';
                            }else{
                                content =  '[tabgroup][tab title="Tab 1"]This is tab 1[/tab][tab title="Tab 2"]This is tab 2[/tab][tab title="Tab 2"]This is tab 3[/tab][/tabgroup]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }

                        if(v == 'Accordion'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[accordiongroup][accordion title="Accordion 1"]'+selected+'[/accordion][accordion title="Accordion 2"]Enter Text Here[/accordion][/accordiongroup]';
                            }else{
                                content =  '[accordiongroup][accordion title="Accordion 1"]Enter Text Here[/accordion][accordion title="Accordion 2"]Enter Text Here[/accordion][/accordiongroup]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
						
                        if(v == 'Dropcap 1'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[dropcaps larg_cap="E" title="Enter Title" type="1"]'+selected+'[/dropcaps]';
                            }else{
                                content =  '[dropcaps larg_cap="N" title="Dropcap one" type="1"]ullam justo metus, pellentesque et cursus in, porttitor id nunc. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos[/dropcaps]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Dropcap 2'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[dropcaps larg_cap="E" title="Enter Title" type="2"]'+selected+'[/dropcaps]';
                            }else{
                                content =  '[dropcaps larg_cap="N" title="Dropcap one" type="2"]ullam justo metus, pellentesque et cursus in, porttitor id nunc. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos[/dropcaps]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Table'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[table cols="'+selected+',Table Header Col2,Table Header Col3" data="Col1 Row1,Col2 Row1,Col3 Row1,Col1 Row2,Col2 Row2,Col3 Row2,Col1 Row3,Col2 Row3,Col3 Row3"]';
                            }else{
                                content =  '[table cols="Table Header Col1,Table Header Col2,Table Header Col3" data="Col1 Row1,Col2 Row1,Col3 Row1,Col1 Row2,Col2 Row2,Col3 Row2,Col1 Row3,Col2 Row3,Col3 Row3"]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Pricing Table'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[pricing_table table_size="four" title="'+selected+'" price="Enter Price" description="Enter Description" button_text="Button Text Here" button_link="Button Link Here"]New Rows separated by|Another Row Here|Unlimited Rows[/pricing_table]';
                            }else{
                                content =  '[pricing_table table_size="four" title="Enter Title" price="Enter Price" description="Enter Description" button_text="Button Text Here" button_link="Button Link Here"]New Rows separated by|Another Row Here|Unlimited Rows[/pricing_table]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Box Standard'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[box type=""]'+selected+'[/box]';
                            }else{
                                content =  '[box type=""]Replace This with your text[/box]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Box Secondary'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[box type="secondary"]'+selected+'[/box]';
                            }else{
                                content =  '[box type="secondary"]Replace This with your text[/box]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Box Success'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[box type="success"]'+selected+'[/box]';
                            }else{
                                content =  '[box type="success"]Replace This with your text[/box]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Box Alert'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[box type="alert"]'+selected+'[/box]';
                            }else{
                                content =  '[box type="alert"]Replace This with your text[/box]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'List Bullet'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[list style="bullet"]'+selected+'|Separate items by|Unlimited items[/list]';
                            }else{
                                content =  '[list style="bullet"]Enter List Item 1|Separate items by|Unlimited items[/list]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'List Links'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[list style="links"]'+selected+'|Separate items by|Unlimited items[/list]';
                            }else{
                                content =  '[list style="links"]Enter List Item 1|Separate items by|Unlimited items[/list]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'List Map'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[list style="map"]'+selected+'|Separate items by|Unlimited items[/list]';
                            }else{
                                content =  '[list style="map"]Enter List Item 1|Separate items by|Unlimited items[/list]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'List Arrow'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[list style="arrow"]'+selected+'|Separate items by|Unlimited items[/list]';
                            }else{
                                content =  '[list style="arrow"]Enter List Item 1|Separate items by|Unlimited items[/list]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column Full Size'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="full" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="full" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column 1/2'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="1/2" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="1/2" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column 1/3'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="1/3" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="1/3" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column 2/3'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="2/3" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="2/3" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column 1/4'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="1/4" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="1/4" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Column 1/6'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[column width="1/6" title="Change With Your Title"]'+selected+'[/column]';
                            }else{
                                content =  '[column width="1/6" title="Change With Your Title"]Change With your text[/column]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Red'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="red" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="red" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Yellow'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="yellow" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="yellow" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Green'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="green" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="green" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Blue'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="blue" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="blue" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Gray'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="gray" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="gray" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Black'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="black" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="black" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Violet'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="violet" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="violet" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Ocean'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="oqean" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="oqean" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Dark-Violet'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="dark-violet" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="dark-violet" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Gold'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="gold" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="gold" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Light Green'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="light-green" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="light-green" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Button Brown'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[button color="brown" url="Enter your URL here"]'+selected+'[/button]';
                            }else{
                                content =  '[button color="brown" url="Enter your URL here"]Button text here[/button]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }
                        if(v == 'Row'){

                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[row]'+selected+'[/row]';
                            }else{
                                content =  '[row]Row content here[/row]';
                            }

                            tinymce.execCommand('mceInsertContent', false, content);

                        }

                     }
                });


                // Add some menu items
                var my_shortcodes = ['Accordion','Box Alert','Box Secondary','Box Standard','Box Success','Button Black','Button Blue','Button Brown','Button Dark-Violet','Button Gold','Button Gray','Button Green','Button Light Green','Button Ocean','Button Red','Button Violet','Button Yellow','Column Full Size','Column 1/2','Column 1/3','Column 2/3','Column 1/4','Column 1/6','Dropcap 1','Dropcap 2','List Arrow','List Bullet','List Links','List Map','Pricing Table','Row','Table','Tabs',];

                for(var i in my_shortcodes)
                    mlb.add(my_shortcodes[i],my_shortcodes[i]);

                return mlb;
            }
            return null;
        }


    });
    tinymce.PluginManager.add('Shortcodes', tinymce.plugins.Shortcodes);
})();