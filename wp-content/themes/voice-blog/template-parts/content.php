<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="card wow fadeInUp" >
        <?php if ( ! has_post_thumbnail() ) {
            if ( get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Grey image if feature image is not used','voice-blog'),'1') ==1) { ?>
            <div>
                <img  class="card-img-top " src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/500x400.jpg " >
            </div>
            <?php } 
            
        } else if ( has_post_thumbnail() ) {
            voice_blog_post_thumbnail();
        }  ?>
        <div class="card-body">
        
            <header class="entry-header">
                <?php the_title( '<h2 class=" text-left card-title blog-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                
                <div class="tag-date-comment">
                    <?php if(absint(get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Category','voice-blog'),'1'))==1):
                    voice_blog_cat();
                    endif; ?>
                    <ul class="pro-meta mb-3">
                        <?php if(absint(get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Read time','voice-blog'),'1'))==1):
                             voice_blog_count_content_words($post->ID);
                        endif; ?>
                        <?php if(absint(get_theme_mod('voice_blog_blog_post_time_ago_enable','1'))==1): ?>
                            <li><span><a><i class="fa fa-calendar-times-o"></i>
                            <span class="pl-1"> <?php  echo voice_blog_time_ago(); ?> </span> 
                            </a></span> </li>
                        <?php endif; 
                        if(absint(get_theme_mod('voice_blog_blog_post_video_count_enable','1'))==1):
                           voice_blog_videocount($post->ID);
                        endif;
                        if(absint(get_theme_mod('voice_blog_blog_post_image_count_enable','1'))==1):
                            voice_blog_imagecount($post->ID);
                        endif; ?>
                    </ul>
                    <?php the_excerpt(); ?>
                    <ul class="date-comment">
                        <?php if(absint(get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Date','voice-blog'),'1'))==1): ?>
                            <li> <?php voice_blog_posted_on() ?></li>
                        <?php endif; ?>
                        <?php if(absint(get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Comment','voice-blog'),'1'))==1): ?>
                            <li><?php voice_blog_post_comment() ?></li>
                        <?php endif; ?>
                        <li><?php  voice_blog_edit_post() ?></li>
                    </ul>
                    <?php if(absint(get_theme_mod('voice_blog_blog_post_post_taxonomy_'.__('Tag','voice-blog'),'1'))==1): ?>
                        <span class ="tag"> <?php voice_blog_post_tag() ?></span>
                    <?php endif; ?>
                </div>
            </header>
            
            
        </div>
    </div>
    <footer class="entry-footer">
        <?php voice_blog_modal(); ?>
    </footer>
</article>