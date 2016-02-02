<?php
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_name] = $of_cat->cat_ID;} 

$of_tags = array();  
$of_tags_obj = get_tags('hide_empty=0');
foreach ($of_tags_obj as $of_tag) {
    $of_tags[$of_tag->name] = $of_tag->name;}

wpb_map( array(
   "name" => __("Clear"),
   "base" => "clear",
   "class" => "",
   "icon" => "icon-wpb-clear",
   "category" => __('Effective Lab'),
) );	    
wpb_map( array(
   "name" => __("Video"),
   "base" => "video",
   "class" => "",
   "icon" => "icon-wpb-video",
   "category" => __('Effective Lab'),
   "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select type"),
         "param_name" => "type",
         "value" => array(
			'Vimeo' => 'vimeo' ,
			'Youtube' => 'youtube'
			),
         "description" => __("Select video type.")
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Width"),
         "param_name" => "width",
         "value" => '',
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Height"),
         "param_name" => "height",
         "value" => '',
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Video ID"),
         "param_name" => "id",
         "value" => '',
      ),
      
   )

) );
wpb_map( array(
   "name" => __("Divide"),
   "base" => "divide",
   "class" => "",
   "icon" => "icon-wpb-divide",
   "category" => __('Effective Lab'),
   "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select Style"),
         "param_name" => "style",
         "value" => array(
			'Simple Line' => '' ,
			'Fancy Line' => '2',
			'Dots' => '3'
			),
      ),
   )

) );
wpb_map( array(
   "name" => __("Toggle"),
   "base" => "toggle",
   "class" => "",
   "icon" => "icon-wpb-toggle",
   "category" => __('Effective Lab'),
   "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Type"),
         "param_name" => "type",
         "value" => array(
			'Framed' => '' ,
			'Minimum' => 'min'
			),
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style"),
         "param_name" => "style",
         "value" => array(
			'Opened ' => '' ,
			'Closed' => 'closed'
			),
      ),
      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title"),
         "param_name" => "title",
         "value" => '',
      ),
      
      array(
         "type" => "textarea",
         "class" => "",
         "heading" => __("Content"),
         "param_name" => "content",
         "value" => '',
      ),
   )

) );
wpb_map( array(
   "name" => __("Bottom News Box"),
   "base" => "bottom_newsbox",
   "class" => "",
   "icon" => "icon-wpb-bnb",
   "category" => __('Effective Lab'),
   "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),
   )

) );
wpb_map( array(
   "name" => __("News Box"),
   "base" => "newsbox",
   "class" => "",
   "icon" => "icon-wpb-nb",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style"),
         "param_name" => "style",
         "value" => array(
			'Style1' => 'style1' ,
			'Style2' => 'style2' ,
			'Style3' => 'style3' ,
			'Style4' => 'style4' ,
			'Style5' => 'style5' ,
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display"),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cat',
			'Tag' => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag"),
         "value" => $of_tags,
         "value" => '',
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Box Title"),
         "param_name" => "title",
         "value" => '',
         "description" => __("insert custom title just if you select display as latest posts.")
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "posts",
         "value" => '',
      ),
   )
));
wpb_map( array(
   "name" => __("Blog Post"),
   "base" => "blog",
   "class" => "",
   "icon" => "icon-wpb-blog",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style"),
         "param_name" => "style",
         "value" => array(
			'Style1' => 'style1' ,
			'Style2' => 'style2'
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display"),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cat'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "posts",
         "value" => '',
      ),
   )
));
wpb_map( array(
   "name" => __("Slider"),
   "base" => "slider",
   "class" => "",
   "icon" => "icon-wpb-slider",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Type"),
         "param_name" => "type",
         "value" => array(
			'Default' => 'def',
			'Cycle' => 'cyc' ,
			'Filex' => 'filex',
			'Caro' => 'caro',
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display"),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'lates' ,
			'Category' => 'category',
			'Tags' => 'tag',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tags"),
         "param_name" => "tag",
         "value" => $of_tags,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "count",
         "value" => '',
      ),
   )
));
wpb_map( array(
   "name" => __("News Picture"),
   "base" => "newspicture",
   "class" => "",
   "icon" => "icon-wpb-nip",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style"),
         "param_name" => "style",
         "value" => array(
			'Style1' => 'style1',
			'Style2' => 'style2' ,
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display"),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cat',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),
      
	array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title"),
         "param_name" => "title",
         "value" => '',
	 "description" => __("insert custom title just if you select display as latest posts.")
      ),
    
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "count",
         "value" => '',
      ),
   )
));
wpb_map( array(
   "name" => __("News Scroller"),
   "base" => "scroller",
   "class" => "",
   "icon" => "icon-wpb-scroll",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style"),
         "param_name" => "style",
         "value" => array(
			'Style1' => 'style1',
			'Style2' => 'style2' ,
			),
      ),


      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display"),
         "param_name" => "display",
         "value" => array(
			'Latest Posts' => 'latest' ,
			'Category' => 'cat',
			'Tags' => 'tag',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category"),
         "param_name" => "cat",
         "value" => $of_categories,
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tags"),
         "param_name" => "tag",
         "value" => $of_tags,
      ),
      
	array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title"),
         "param_name" => "title",
         "value" => '',
	 "description" => __("insert custom title just if you select display as latest posts.")
      ),
    
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "posts",
         "value" => '',
      ),
   )
));
wpb_map( array(
   "name" => __("Latest Videos"),
   "base" => "latestvideo",
   "class" => "",
   "icon" => "icon-wpb-lvideo",
   "category" => __('Effective Lab'),
   "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Order"),
         "param_name" => "order",
         "value" => array(
			'Random' => 'rand',
			'Popular' => 'comment_count',
			'Latest' =>'',
			),
      ),
      
	array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title"),
         "param_name" => "title",
         "value" => '',
      ),
    
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts"),
         "param_name" => "count",
         "value" => '',
      ),
   )
));
