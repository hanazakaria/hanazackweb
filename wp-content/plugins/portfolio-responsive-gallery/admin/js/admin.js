(function($) {
    'use strict';

    $('[data-slug="portfolio-responsive-gallery"] .deactivate a').on('click', function() {
        swal({
            html: "<h2>Do you want to upgrade to Pro version or permanently delete the plugin?</h2><ul><li>Upgrade: Your data will be saved for upgrade.</li><li>Deactivate: Your data will be deleted completely.</li></ul>",
            footer: '<a href="javascript:void(0);" class="ays-prg-temporary-deactivation">Temporary deactivation</a>',
            type: 'question',
            showCloseButton: true,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upgrade',
            cancelButtonText: 'Deactivate',
            confirmButtonClass: "ays-prg-upgrade-button",
            cancelButtonClass: "ays-prg-cancel-button"
        }).then((result) => {
            let upgrade_plugin = false;
            if (result.value) upgrade_plugin = true;

            if( result.dismiss && result.dismiss == 'close' ){
                return false;
            }

            let data = {
                action: 'prg_deactivate_plugin_option',
                upgrade_plugin: upgrade_plugin
            };
            $.ajax({
                url: apm_admin_ajax_obj.ajaxUrl,
                dataType: 'json',
                method: 'post',
                data: data,
                success() {
                    window.location.replace($('[data-slug="portfolio-responsive-gallery"] .deactivate a').attr('href'))
                }
            });
        });
        return false;
    });
    $(document).on('click', '.ays-prg-temporary-deactivation', function (e) {
        e.preventDefault();
        $(document).find('.ays-prg-upgrade-button').trigger('click');
    });
})(jQuery);

