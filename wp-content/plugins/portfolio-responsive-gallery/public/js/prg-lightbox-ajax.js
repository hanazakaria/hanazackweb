(function ($) {
    $(function () {
        $(document).on('click', '.open_project_lightbox', launchLightbox);

        let owl = "";
        let thumbs = "";
        let syncedSecondary = true;
        let slidesPerPage = 5; //globally define number of elements per page

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }

            //end block

            thumbs
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = thumbs.find('.owl-item.active').length - 1;
            var start = thumbs.find('.owl-item.active').first().index();
            var end = thumbs.find('.owl-item.active').last().index();

            if (current > end) {
                thumbs.data('owl.carousel').to(current, 100, true);
            }
            if (current < start) {
                thumbs.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                let number = el.item.index;
                owl.data('owl.carousel').to(number, 100, true);
            }
        }

        function refreshOwl() {
            if ($('#carousel-custom-dots').length>0) {
                let projectWidth = $('.ays_project_images').width() - 50;
                let imagesCount = +$("#ays_project_images_ul").attr('data-count');
                slidesPerPage = parseInt(projectWidth/110);
                slidesPerPage = imagesCount>slidesPerPage?slidesPerPage:imagesCount;
                let options = $('#carousel-custom-dots').data('owl.carousel').options;
                options.items = slidesPerPage;
                $('#carousel-custom-dots').trigger('refresh.owl.carousel');
            }
        }

        function launchLightbox() {
            addLayer();
            let cell = $(this).parent().parent();
            let index = +cell.attr('data-index')
            if (isNaN(index)) {
                cell = $(this).parent();
                index = +cell.attr('data-index')
            }
            let cellCount = cell.attr('data-count');

            let uniqId = cell.attr('data-prg')
            let next = index == cellCount - 1 ? 0 : index + 1;
            let prev = index == 0 ? cellCount - 1 : index - 1;
            let leftArrow = $(`<div class="prg-arrows" id="prg-left" data-prg="${uniqId}" data-index="${prev}">
                <svg enable-background="new 0 0 35 35" height="35px" id="Layer_1" version="1.1" viewBox="0 0 35 35" width="35px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path d="M7.701,14.276l9.586-9.585c0.879-0.878,2.317-0.878,3.195,0l0.801,0.8c0.878,0.877,0.878,2.316,0,3.194  L13.968,16l7.315,7.315c0.878,0.878,0.878,2.317,0,3.194l-0.801,0.8c-0.878,0.879-2.316,0.879-3.195,0l-9.586-9.587  C7.229,17.252,7.02,16.62,7.054,16C7.02,15.38,7.229,14.748,7.701,14.276z" fill="#d3d3d3"/>
                </svg>
            </div>`);
            let rightArrow = $(`<div class="prg-arrows" id="prg-right" data-prg="${uniqId}" data-index="${next}">
                <svg enable-background="new 0 0 35 35" height="35px" id="Layer_1" version="1.1" viewBox="0 0 35 35" width="35px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path d="M7.701,14.276l9.586-9.585c0.879-0.878,2.317-0.878,3.195,0l0.801,0.8c0.878,0.877,0.878,2.316,0,3.194  L13.968,16l7.315,7.315c0.878,0.878,0.878,2.317,0,3.194l-0.801,0.8c-0.878,0.879-2.316,0.879-3.195,0l-9.586-9.587  C7.229,17.252,7.02,16.62,7.054,16C7.02,15.38,7.229,14.748,7.701,14.276z" fill="#d3d3d3"/>
                </svg>
            </div>`);

            let data = {
                project_id: $(this).attr('data-project'),
                action:'ays_portfolio_load_project'
            };
            $.post({
                url: prg_ajax_public.ajax_url,
                data,
                success: function (resp) {
                    $.lightbox($(resp), {
                        fixed: true,
                        retina: true,
                        requestKey: 'fs-lightbox',
                        overlay: true,
                        labels: {close: 'X'}
                    });
                    window.removeEventListener('resize', refreshOwl);
                    setTimeout(() => {
                        window.addEventListener('resize', refreshOwl);

                        owl = $("#ays_project_images_ul");

                        let projectWidth = $('.ays_project_images').width() - 50;
                        let imagesCount = +owl.attr('data-count');
                        slidesPerPage = parseInt(projectWidth/110);
                        slidesPerPage = imagesCount>slidesPerPage?slidesPerPage:imagesCount;

                        owl.owlCarousel({
                            loop: true,
                            margin: 0,
                            nav: false,
                            items: 1,
                            dots: false,
                            responsiveRefreshRate: 200,
                            slideSpeed: 2000,
                            autoplay: false,
                        }).on('changed.owl.carousel', syncPosition);
                        $('.carousel-custom-dots').css({
                            width: (slidesPerPage*110) + "px"
                        });
                        thumbs = $('#carousel-custom-dots');
                        thumbs
                            .on('initialized.owl.carousel', function() {
                                thumbs.find(".owl-item").eq(0).addClass("current");
                            })
                            .owlCarousel({
                                items: slidesPerPage,
                                dots: false,
                                nav: false,
                                margin:5,
                                smartSpeed: 200,
                                slideSpeed: 500,
                                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                                responsiveRefreshRate: 100
                            })
                            .on('changed.owl.carousel', syncPosition2)
                            .on("click", ".owl-item", function(e) {
                            e.preventDefault();
                            let number = $(this).index();
                            owl.data('owl.carousel').to(number, 300, true);
                        });

                        $('.ays_project').prepend(leftArrow)
                        $('.ays_project').append(rightArrow)
                    }, 500)
                }
            });
        }
    })
})(jQuery)