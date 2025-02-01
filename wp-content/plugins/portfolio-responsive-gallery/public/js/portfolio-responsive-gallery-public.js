let addLayer = function () {
};
(function ($) {
    'use strict';
    addLayer = function () {
        $('body, html').addClass('no-scroll');
        // console.log('add');
        if ($('.levon_lightbox_overlay').length == 0) {
            $('body').append("<div class='levon_lightbox_overlay'></div>");
            $('.levon_lightbox_overlay').css({
                display: 'block',
                animation: 'fadeIn .5s'
            }).empty().append(`
                <div>
                    <div class="loader-levon">
                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                           width="100px" height="100px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"      xml:space="preserve">
                        <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,      6.543-14.615,14.615-14.615V6.461z">
                          <animateTransform attributeType="xml"
                            attributeName="transform"
                            type="rotate"
                            from="0 25 25"
                            to="360 25 25"
                            dur="0.8s"
                            repeatCount="indefinite"/>
                          </path>
                        </svg>
                    </div>
                </div>
            `);
        }
    };

    $(function () {
        $(window)
            .on('open.lightbox', addLayer)
            .on('close.lightbox', closeLightBox);

        function closeLightBox() {
            // console.log('close');
            // $(window)
            //     .off('close.lightbox').on('close.lightbox', function () {
            //     $('.levon_lightbox_overlay').remove();
            // });
            $('.levon_lightbox_overlay').remove();
            $('body, html').removeClass('no-scroll');
        }

        $(document).on('click', '#prg-modal-close', function () {
            $(document).find('button.fs-lightbox-close').trigger('click')
        });
        $(document).on('click', '.levon_lightbox_overlay',function () {
            $(document).find('button.fs-lightbox-close').trigger('click')
        });

        //projects slider
        function indexing() {
            let uniqId = 'prgRow' + Date.now();
            let row = $(this);
            let cells = row.children('div');
            let cellsCount = cells.length;
            cells.each(function () {
                let index = +$(this).index();
                $(this).attr('data-index', index);
                $(this).attr('data-count', cellsCount);
                $(this).attr('data-prg', uniqId);
            })
        }

        $('.prg-container .prg_grid_row').each(indexing)
        $('.prg-container .prg_mosaic_row').each(indexing)


        $(document).on('click', '.prg-arrows svg', function () {
            let index = +$(this).parent().attr('data-index');
            let uniqId = $(this).parent().attr('data-prg');
            $(window).off('close.lightbox')
            .one('close.lightbox', addLayer);
            $(document).find('button.fs-lightbox-close').trigger('click');
            setTimeout(() => {
                $(window).on('close.lightbox', closeLightBox);
                $(document)
                    .find(`[data-index="${index}"][data-prg="${uniqId}"]`)
                    .find('.open_project_lightbox')
                    .trigger('click');
            }, 500);
        })

    })
})(jQuery);