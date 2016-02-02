<?php function effective_hp() {
     
     if(eff_option('hp_display') == 'blog') {
        
        if(eff_option('slider_blog') == true) {
            eff_slider();
        }
        if(eff_option('c_blog') == true) {
            eff_scroller();
        }
         eff_blog();
        } else {
               
        global $smof_data;
        $homePage = $smof_data['homepage_build']['enabled'];

        if ($homePage):

        foreach ($homePage as $key=>$value) {

        switch($key) {

                case 'nb1':
                ?>
                <?php eff_news_box(1); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'nb2':
                ?>
                <?php eff_news_box(2); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'nb3':
                ?>
                <?php eff_news_box(3); ?>
                <?php
                break;
                ?>
            
                <?php
                 case 'nb4':
                ?>
                <?php eff_news_box(4); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'nb5':
                ?>
                <?php eff_news_box(5); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'nb6':
                ?>
                <?php eff_news_box(6); ?>
                <?php
                break;
                ?>
            
                <?php
                 case 'nb7':
                ?>
                <?php eff_news_box(7); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'nb8':
                ?>
                <?php eff_news_box(8); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'nb9':
                ?>
                <?php eff_news_box(9); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'nb10':
                ?>
                <?php eff_news_box(10); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'ads1':
                ?>
                <?php hp_banner(1); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'ads2':
                ?>
                <?php hp_banner(2); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'ads3':
                ?>
                <?php hp_banner(3); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'ads4':
                ?>
                <?php hp_banner(4); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'ads5':
                ?>
                <?php hp_banner(5); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'nip':
                ?>
                <?php eff_nip(); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'nc':
                ?>
                <?php eff_scroller(); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'slider':
                ?>
                <?php eff_slider(); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'lv':
                ?>
                <?php eff_latest_videos(); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'tabs':
                ?>
                <?php eff_tabs(); ?>
                <?php
                break;
                ?>
                
                <?php
                //repeat as many times necessary    
            
                }
            
            }
            
        endif;
        
        }
}
function effective_bottom() {
   
   global $smof_data;
        $bottomarea = $smof_data['bottom_build']['enabled'];

        if ($bottomarea):

        foreach ($bottomarea as $key=>$value) {

        switch($key) {

                case 'bb1':
                ?>
                <?php eff_bottom_box(1); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'bb2':
                ?>
                <?php eff_bottom_box(2); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'bb3':
                ?>
                <?php eff_bottom_box(3); ?>
                <?php
                break;
                ?>
            
                <?php
                 case 'bb4':
                ?>
                <?php eff_bottom_box(4); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'bb5':
                ?>
                <?php eff_bottom_box(5); ?>
                <?php
                break;
                ?>
                
                <?php
                case 'bb6':
                ?>
                <?php eff_bottom_box(6); ?>
                <?php
                break;
                ?>
            
                <?php
                 case 'bb7':
                ?>
                <?php eff_bottom_box(7); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'bb8':
                ?>
                <?php eff_bottom_box(8); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'bb9':
                ?>
                <?php eff_bottom_box(9); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'bb10':
                ?>
                <?php eff_bottom_box(10); ?>
                <?php
                break;
                ?>
                
               <?php
                 case 'bb11':
                ?>
                <?php eff_bottom_box(11); ?>
                <?php
                break;
                ?>
                
                <?php
                 case 'bb12':
                ?>
                <?php eff_bottom_box(12); ?>
                <?php
                break;
                ?>
                
                <?php
                //repeat as many times necessary    
            
                }
            
            }
            
        endif;
}