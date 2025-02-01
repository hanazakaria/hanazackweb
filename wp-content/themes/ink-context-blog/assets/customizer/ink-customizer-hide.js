/*==================================
File Name: ink-customizer-hide.js 
Description: allow to hide and show remaining parameters of customizer while enable and disable of section
====================================*/ 

jQuery(document).ready(
    function () {
        /* below function is made to repeat */
        function ink_context_blog_customizer_hide(controlValueId, control,controlContainerSelectorArray)
        {
            if(jQuery(controlValueId).find('input[type=checkbox]').val() != 1) {
                jQuery.each(
                    controlContainerSelectorArray, function (index, value) {
                        jQuery(value).hide();
                    }
                );
            }
  
            control.container.on(
                'click', 'input[type=checkbox]', function ( event ) {
                    if(jQuery(this).is(":checked")) {
                        jQuery.each(
                            controlContainerSelectorArray, function (index, value) {
                                jQuery(value).show();
                            }
                        );
                    }
                    else{
                        jQuery.each(
                            controlContainerSelectorArray, function (index, value) {
                                jQuery(value).hide();
                            }
                        );
                    }
        
                } 
            );
        }

        $ink_context_blog_post_taxonomy_meta = ink_taxonomy_translate.ink_context_blog_meta_translate;
        $ink_context_blog_post_taxonomy_date = ink_taxonomy_translate.ink_context_blog_date_translate;
        $ink_context_blog_post_taxonomy_comment = ink_taxonomy_translate.ink_context_blog_comment_translate;
        $ink_context_blog_post_taxonomy_category = ink_taxonomy_translate.ink_context_blog_category_translate;
        $ink_context_blog_post_taxonomy_excerpt = ink_taxonomy_translate.ink_context_blog_excerpt_translate;

        wp.customize.control(
            'context_blog_card_slider_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_card_slider_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_card_slider_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-context_blog_card_slider_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-context_blog_card_slider_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");


                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);
            } 
        );

        wp.customize.control(
            'context_blog_home_main_blog_enable', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_home_main_blog_title').selector,
                wp.customize.control('context_blog_main_blog_excerpt_limit').selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_meta).selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_comment).selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_category).selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_excerpt).selector,
                wp.customize.control('context_blog_main_blog_readmore').selector,
                wp.customize.control('context_blog_mainblog_related_customize_heading').selector,
                wp.customize.control('context_blog_mainblog_related_post_text').selector,
                wp.customize.control('context_blog_main_blog_excerpt_limit').selector,

                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );


        wp.customize.control(
            'context_blog_sidebar_fullwidth_enable', function (control) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray = [
                    wp.customize.control('context_blog_sidebar_fullwidth_order').selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_category_name').selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_number_of_display').selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_meta).selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_date).selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_comment).selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_category).selector,
                ];
                ink_context_blog_customizer_hide(controlValueId, control, controlContainerSelectorArray);

            }
        );
        wp.customize.control(
            'context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_meta, function (control) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray = [
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_date).selector,
                    wp.customize.control('context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");

                ink_context_blog_customizer_hide(controlValueId, control, controlContainerSelectorArray);

            }
        );

        wp.customize.control(
            'context_blog_sidebar_about_author_enable', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_sidebar_about_author_heading').selector,
                wp.customize.control('context_blog_sidebar_about_author_textarea').selector,
                wp.customize.control('context_blog_about_author_readmore_text').selector,
                wp.customize.control('context_blog_about_author_readmore_url').selector,
                wp.customize.control('context_blog_about_author_social_enable').selector,
                wp.customize.control('context_blog_sidebar_about_image').selector

       
                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_sidebar_stay_connected_enable', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_stay_connected_heading').selector,

                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_sidebar_quote_enable', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_sidebar_quote_heading').selector,
                wp.customize.control('context_blog_sidebar_quote_texarea').selector,

                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_footer_first_list_post', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_footer_news1_title').selector,
                wp.customize.control('context_blog_footer_news1_order').selector,
                wp.customize.control('context_blog_footer_news1_category_name').selector,
                wp.customize.control('context_blog_footer_news1_number').selector,
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_meta).selector,
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_comment).selector,
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_category).selector,
                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_footer_second_list_post', function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_footer_news2_title').selector,
                wp.customize.control('context_blog_footer_news2_order').selector,
                wp.customize.control('context_blog_footer_news2_category_name').selector,
                wp.customize.control('context_blog_footer_news2_number').selector,
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_meta).selector,
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_comment).selector,
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_category).selector,
                ];

                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('ink_context_blog_main_blog_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-ink_context_blog_main_blog_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-ink_context_blog_main_blog_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");
                
                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_sidebar_fullwidth_slider_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_sidebar_fullwidth_slider_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_sidebar_fullwidth_slider_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-ink_context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-ink_context_blog_sidebar_fullwidth_slider_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");
                
                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_footer_news1_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-context_blog_footer_news1_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-context_blog_footer_news1_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");
                
                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );

        wp.customize.control(
            'context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_footer_news2_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-context_blog_footer_news2_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-context_blog_footer_news2_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");
                
                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );


        wp.customize.control(
            'context_blog_singlepage_'+$ink_context_blog_post_taxonomy_meta, function ( control ) {

                var controlValueId = control.selector;
                var controlContainerSelectorArray =  [
                wp.customize.control('context_blog_singlepage_'+$ink_context_blog_post_taxonomy_date).selector,
                wp.customize.control('context_blog_singlepage_'+$ink_context_blog_post_taxonomy_comment).selector,
                ];
                jQuery('#customize-control-context_blog_singlepage_' + $ink_context_blog_post_taxonomy_date).css("margin-left", "20px");
                jQuery('#customize-control-context_blog_singlepage_' + $ink_context_blog_post_taxonomy_comment).css("margin-left", "20px");
                
                ink_context_blog_customizer_hide(controlValueId,control,controlContainerSelectorArray);

            } 
        );


        // it is used to hide section in blog page in case setting >>reading is posts, cause in this condtion your homepage is itself blog page.
        if(phpInfo.show_on_front_value == 'posts' ) {    
            jQuery('#customize-control-context_blog_sidebar_enable_blogpage').css('display','none');
            jQuery('#customize-control-context_blog_card_slider_enable_blogpage').css('display','none');
            jQuery('#customize-control-context_blog_header_image_enable_blogpage').css('display','none');

        };
    }
);