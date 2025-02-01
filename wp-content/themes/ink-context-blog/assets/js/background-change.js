/**
 *  banner background made fixed after scroll to top and vice versa
 */
function ink_context_blog_isElementInViewport(el) {
    var elementTop = el.offset().top;
    var elementBottom = elementTop + el.outerHeight();
    var viewportTop = jQuery(window).scrollTop();
    var viewportBottom = viewportTop + jQuery(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
}

jQuery(window).on(
    'scroll', function () {
        
        var ink_context_blog_targetclass4 = document.querySelector('.banner-author')
       
        if (ink_context_blog_targetclass4 != null) {
            var ink_context_blog_targetclass3 = jQuery('.banner-author');
            var ink_context_blog_divTop1 = jQuery('.banner-author').offset().top;
            if (jQuery(window).scrollTop() > ink_context_blog_divTop1) {
                if (ink_context_blog_targetclass3.length > 0) {
                    if (ink_context_blog_isElementInViewport(ink_context_blog_targetclass3)) {
                        jQuery(".banner-author .img-holder").css({ "background-attachment": 'fixed' });

                    } else {
                        jQuery(".banner-author .img-holder").css({ "background-attachment": 'scroll' });

                    }
                }
            } else {
                jQuery(".banner-author .img-holder").css({ "background-attachment": 'scroll' });

            }
        }
    }
);