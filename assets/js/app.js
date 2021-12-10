const customOptions = {
    daysSimple: ["Nd", "Po", "Wt", "Śr", "Cz", "Pt", "So"],
    monthsSimple: ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"],
    monthsFull: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
    labels: {
        today: "DZISIAJ",
        gotoDateInput: "WPISZ DATE",
        gotoDateButton: "UŻYJ",
        clearButton: "WYCZYŚĆ",
    }
}

$(window).on('load', function () {
    // grooming.main.reload();
    grooming.main.init();

    $('.vote .row').jScrollPane();
})


$(window).resize(function () {
    grooming.main.reload();
});

$(window).scroll(function () {
    const height = $(window).scrollTop();

    if (height > 10) {
        $('nav').addClass('fixed');
    } else {
        $('nav').removeClass('fixed');
    }
});

const grooming = {
    _var: {
        controller: null,
        scene_vote: null,
        scene_rating: null,
        scene_products: null,
        scene_contact: null,
        scene_p2s1: null,
        SDW: 0,
        BAL: 0,
        SW: 0,
        SH: 0,
        BW: 0,
        BH: 0,
        BAB: 0,
        BAT: 0,
        BAR: 0,
        SDH: 0,
        BDW: 0,
        BDH: 0,
        BDAB: 0,
        BDAT: 0,
        BDAR: 0,
    },

    _con: {},

    main: {
        init: function () {
            grooming._var.controller = new ScrollMagic();

            grooming.main.click();
            grooming.main.submit();
            // grooming.main.timer();
            grooming.main.scroller();
            grooming.main.parallax();
            grooming.main.active_menu();
            grooming.main.selectbox();
            grooming.main.datapicker();
            grooming.main.fancybox();

        },


        click: function () {
            // $(document).on("click", 'a[href^="#"]', function (e) {
            //     var id = $(this).attr("href");
            //
            //     if ($(id).length > 0) {
            //         e.preventDefault();
            //
            //         // trigger scroll
            //         grooming._var.controller.scrollTo(id, {duration: 'slow'});
            //
            //         // if supported by the browser we can even update the URL.
            //         if (window.history && window.history.pushState) {
            //             history.pushState("", document.title, id);
            //         }
            //         return false;
            //     }
            //     return true;
            // });

            $(document).on("click", ".all-products .row.buttons a", function () {
                const $this = $(this);

                $(".all-products .row a.select").removeClass('select');
                $this.addClass('select');

                $(".all-products .row.select").removeClass('select');
                $(".all-products .row." + $this.attr('id')).addClass('select');

                return false;
            });

            $(document).on('click', '.form label', function () {
                const $this = $(this);

                if ($this.hasClass('check')) {
                    $this.removeClass('check');
                } else {
                    $this.addClass('check');
                }
            });
        },

        submit: function () {
            $(document).on('submit', '#flashlight form', function () {
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            location.href = data.redirect;
                        } else {
                            $('.error-post').text('');

                            $.each(data.errors, function(key, item) {
                                $(`#flashlight_form_${key}`).closest('.element').find('.error-post').text(item);
                                $(`#trip_form_${key}`).closest('.element').find('.error-post').text(item);
                            });
                        }
                    },
                    error: function () {
                        console.error('Błąd sieciowy');
                    }
                });

                return false;
            });

            $(document).on('submit', '#contact form', function () {
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            location.href = data.redirect;
                        } else {
                            // Wyświetlenie komunikatów błędów
                            const errorContainer = $('#contact .error-container');
                            errorContainer.html('');

                            data.errors.forEach(function (error) {
                                const errorElement = $('<div>').text(error);
                                errorContainer.append(errorElement);
                            });
                        }
                    },
                    error: function () {
                        console.error('Błąd sieciowy');
                    }
                });

                return false;
            })
        },

        reload: function () {
            grooming._var.SDW = $(window).width();
            grooming._var.BAL = (grooming._var.SDW / 2) - 120 - 450;

            $(".lax-one .border").css({
                left: grooming._var.BAL + 'px',
            });

            // SECTION HIGHT
            grooming._var.SW = 1300;

            // SECTION WIDTH
            grooming._var.SH = 590;

            // BORDER WIDTH
            grooming._var.BW = 440;

            // BORDER HEIGHT
            grooming._var.BH = 280;

            // BORDER ABSOLUTE BOTTOM
            grooming._var.BAB = 87;

            // BORDER ABSOLUTE TOP
            grooming._var.BAT = 221;

            // BORDER ABSOLUTE RIGHT
            grooming._var.BAR = 92;

            // SECTION DYNAMIC WIDTH
            grooming._var.SDW = $(window).width();

            // SECTION DYNAMIC HEIGHT
            grooming._var.SDH = grooming._var.SDW * grooming._var.SH / grooming._var.SW;

            // BORDER DYNAMIC WIDTH
            grooming._var.BDW = grooming._var.SDW * grooming._var.BW / grooming._var.SW;

            // BORDER DYNAMIC HEIGHT
            grooming._var.BDH = grooming._var.BDW * grooming._var.BH / grooming._var.BW;

            // BORDER DYNAMIC ABSOLUTE BOTTOM
            grooming._var.BDAB = grooming._var.SDH * grooming._var.BAB / grooming._var.SH;

            // BORDER DYNAMIC ABSOLUTE TOP
            grooming._var.BDAT = grooming._var.SDH * grooming._var.BAB / grooming._var.SH;

            // BORDER DYNAMIC ABSOLUTE RIGHT
            grooming._var.BDAR = grooming._var.SDW * grooming._var.BAR / grooming._var.SW;

            $(".lax-two").css({
                height: grooming._var.SDH + 'px',
            });

            $(".lax-two .border").css({
                width: grooming._var.BDW + 'px',
                height: grooming._var.BDH + 'px',
                bottom: grooming._var.BDAB + 'px',
                right: grooming._var.BDAR + 'px',
            });

            if (grooming._var.scene_p2s1 !== null) {
                grooming._var.scene_p2s1 = grooming._var.scene_p2s1.destroy(true);
            }

            // PARALLAX 2 : SCENE 1 : [LAX-TWO]
            const P2S1_duration = grooming._var.SDH * 1100 / 1300;
            const P2S1_bgPosMovement = "0 -" + (P2S1_duration * 0.5) + "px";
            const p2s1_controller = new ScrollMagic({
                globalSceneOptions: {
                    triggerHook: "onEnter",
                    duration: P2S1_duration
                }
            });
            grooming._var.scene_p2s1 = new ScrollScene({triggerElement: "#trigger3"})
                .setTween(TweenMax.to("#parallax2", 1, {backgroundPosition: P2S1_bgPosMovement, ease: Linear.easeNone}))
                .addTo(p2s1_controller);
        },

        datapicker: function () {
            //$( ".datapicker" ).datepicker({
            //  changeMonth: true,
            //  changeYear: true,
            //  defaultDate: new Date ('1975-10-15')
            //});
        },

        selectbox: function () {
            const f_gender = $('select[name="flashlight_form[sex]"]');
            const f_shop = $('select[name="flashlight_form[shop]"]');
            const f_category = $('select[name="flashlight_form[category]"]');

            if (f_gender.length > 0) {
                f_gender.selectbox({});
            }
            if (f_shop.length > 0) {
                f_shop.selectbox({});
            }
            if (f_category.length > 0) {
                f_category.selectbox({});
            }
        },

        scroller: function () {
            // build scene
            grooming._var.scene_vote = new ScrollScene({
                triggerElement: "#vote",
                duration: 200,
                triggerHook: "onLeave"
            }).addTo(grooming._var.controller);
            grooming._var.scene_rating = new ScrollScene({
                triggerElement: "#rating",
                duration: 200,
                triggerHook: "onLeave"
            }).addTo(grooming._var.controller);
            grooming._var.scene_products = new ScrollScene({
                triggerElement: "#products",
                duration: 200,
                triggerHook: "onLeave"
            }).addTo(grooming._var.controller);
            grooming._var.scene_contact = new ScrollScene({
                triggerElement: "#contact",
                duration: 200,
                triggerHook: "onLeave"
            }).addTo(grooming._var.controller);

            // change behaviour of controller to animate scroll instead of jump
            grooming._var.controller.scrollTo(function (newpos) {
                TweenMax.to(window, 0.5, {scrollTo: {y: newpos}});
            });
        },

        parallax: function () {

            // PARALLAX 1 : SCENE 1 : [LAX-ONE]
            const P1S1_duration = 620;
            const P1S1_bgPosMovement = "0 -" + (P1S1_duration * 0.4) + "px";
            const p1s1_controller = new ScrollMagic({
                globalSceneOptions: {
                    triggerHook: "onEnter",
                    duration: P1S1_duration
                }
            });
            new ScrollScene({triggerElement: "#trigger1"})
                .setTween(TweenMax.to("#parallax1", 1, {backgroundPosition: P1S1_bgPosMovement, ease: Linear.easeNone}))
                .addTo(p1s1_controller);

            // PARALLAX 1 : SCENE 2 : [LAX-ONE]
            const P1S2_top = "" + 250 + "px";
            const p1s2_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: 250}});
            new ScrollScene({triggerElement: "#trigger2"})
                .setTween(TweenMax.to("#parallax1 .border", 1, {top: P1S2_top, ease: Linear.easeNone}))
                .addTo(p1s2_controller);

            // PARALLAX 2 : SCENE 1 : [LAX-TWO]
            // JEST W RELOAD

            // PARALLAX 3 : SCENE 1 : [PRODUCTS INDESTRUCTBLE]
            const P3S1_duration = $('#b1').height() * 0.75;
            const P3S1_left = "-" + 325 + "px";
            const p3s1_controller = new ScrollMagic({
                globalSceneOptions: {
                    triggerHook: "onEnter",
                    duration: P3S1_duration
                }
            });
            new ScrollScene({triggerElement: "#trigger4"})
                .setTween(TweenMax.to("#b1 .thumb", 1, {left: P3S1_left, ease: Linear.easeNone}))
                .addTo(p3s1_controller);
            //.addIndicators({zindex: 1000});

            // PARALLAX 3 : SCENE 2 : [PRODUCTS VACUUM]
            const P3S2_duration = $('#b2').height() * 0.75;
            const P3S2_right = "-" + 400 + "px";
            const p3s2_controller = new ScrollMagic({
                globalSceneOptions: {
                    triggerHook: "onEnter",
                    duration: P3S2_duration
                }
            });
            new ScrollScene({triggerElement: "#trigger5"})
                .setTween(TweenMax.to("#b2 .thumb", 1, {right: P3S2_right, ease: Linear.easeNone}))
                .addTo(p3s2_controller)
            //.addIndicators({zindex: 1000});

            // PARALLAX 3 : SCENE 3 : [PRODUCTS HYPERFLEX]
            const P3S3_duration = $('#b3').height() * 0.75;
            const P3S3_left = "-" + 345 + "px";
            const p3s3_controller = new ScrollMagic({
                globalSceneOptions: {
                    triggerHook: "onEnter",
                    duration: P3S3_duration
                }
            });
            new ScrollScene({triggerElement: "#trigger6"})
                .setTween(TweenMax.to("#b3 .thumb", 1, {left: P3S3_left, ease: Linear.easeNone}))
                .addTo(p3s3_controller);
            //.addIndicators({zindex: 1000});

        },

        active_menu: function () {

            if ($("#awards").length > 0) {
                new ScrollScene({triggerElement: "#awards"})
                    .setClassToggle("nav .menu li a[href='#awards']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.awards').height()}}));
            }

            if ($("#take").length > 0) {
                new ScrollScene({triggerElement: "#take"})
                    .setClassToggle("nav .menu li a[href='#take']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.take').height()}}));
            }

            if ($("#vote").length > 0) {
                new ScrollScene({triggerElement: "#vote"})
                    .setClassToggle("nav .menu li a[href='#vote']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.vote').height()}}));
            }

            if ($("#rating").length > 0) {
                new ScrollScene({triggerElement: "#rating"})
                    .setClassToggle("nav .menu li a[href='#rating']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.rating').height()}}));
            }

            if ($("#products").length > 0) {
                new ScrollScene({triggerElement: "#products"})
                    .setClassToggle("nav .menu li a[href='#products']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.products').height()}}));
            }

            if ($("#about").length > 0) {
                new ScrollScene({triggerElement: "#about"})
                    .setClassToggle("nav .menu li a[href='#about']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.about').height()}}));
            }

            if ($("#contact").length > 0) {
                new ScrollScene({triggerElement: "#contact"})
                    .setClassToggle("nav .menu li a[href='#contact']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.contact').height()}}));
            }

        },

        fancybox: function () {
            $(".product .buy, .box .buy").fancybox({
                maxWidth: 790,
                maxHeight: 460,
                //fitToView	: false,
                width: '70%',
                height: '70%',
                autoSize: false,
                closeClick: false,
                openEffect: 'none',
                closeEffect: 'none',
                padding: 0,
                beforeLoad: function () {

                    this.content.find('a').attr('href', '#');

                    if ($(this.element).data('shop-p00') !== 'none')
                        this.content.find('.p00').attr('href', $(this.element).data('shop-p00'));

                    if ($(this.element).data('shop-p01') !== 'none')
                        this.content.find('.p01').attr('href', $(this.element).data('shop-p01'));

                    if ($(this.element).data('shop-p02') !== 'none')
                        this.content.find('.p02').attr('href', $(this.element).data('shop-p02'));

                    if ($(this.element).data('shop-p03') !== 'none')
                        this.content.find('.p03').attr('href', $(this.element).data('shop-p03'));

                    if ($(this.element).data('shop-p04') !== 'none')
                        this.content.find('.p04').attr('href', $(this.element).data('shop-p04'));

                    if ($(this.element).data('shop-p05') !== 'none')
                        this.content.find('.p05').attr('href', $(this.element).data('shop-p05'));

                    if ($(this.element).data('shop-p06') !== 'none')
                        this.content.find('.p06').attr('href', $(this.element).data('shop-p06'));

                    if ($(this.element).data('shop-p07') !== 'none')
                        this.content.find('.p07').attr('href', $(this.element).data('shop-p07'));

                    if ($(this.element).data('shop-p08') !== 'none')
                        this.content.find('.p08').attr('href', $(this.element).data('shop-p08'));

                    if ($(this.element).data('shop-p09') !== 'none')
                        this.content.find('.p09').attr('href', $(this.element).data('shop-p09'));

                    if ($(this.element).data('shop-p10') !== 'none')
                        this.content.find('.p10').attr('href', $(this.element).data('shop-p10'));

                    if ($(this.element).data('shop-p11') !== 'none')
                        this.content.find('.p11').attr('href', $(this.element).data('shop-p11'));

                    if ($(this.element).data('shop-p12') !== 'none')
                        this.content.find('.p12').attr('href', $(this.element).data('shop-p12'));

                    if ($(this.element).data('shop-p13') !== 'none')
                        this.content.find('.p13').attr('href', $(this.element).data('shop-p13'));

                    if ($(this.element).data('shop-p14') !== 'none')
                        this.content.find('.p14').attr('href', $(this.element).data('shop-p14'));

                    if ($(this.element).data('shop-p15') !== 'none')
                        this.content.find('.p15').attr('href', $(this.element).data('shop-p15'));


                }
            });
        },

        timer: function () {
            const year = 2015;
            const month = 1;
            const day = 13;
            const hour = 0;
            const minute = 0;
            const second = 0;

            grooming.main.r('.vote .row .timer', year, month, day, hour, minute, second);
        },

        cd: function (d, o, t, x) {
            return [x = ~~(t = (d - o) / 864e5), x = ~~(t = (t - x) * 24), x = ~~(t = (t - x) * 60), ~~((t - x) * 60)];
        },

        r: function (selector, yy, mm, dd, g, m, s, t) {
            t = grooming.main.cd(new Date(yy, mm - 1, dd, g, m, s), new Date());

            $(selector + ' .dd').text((t[0] < 10) ? '0' + t[0] : t[0]);
            $(selector + ' .hh').text((t[1] < 10) ? '0' + t[1] : t[1]);
            $(selector + ' .mm').text((t[2] < 10) ? '0' + t[2] : t[2]);

            setTimeout('grooming.main.r("' + selector + '",' + yy + ',' + mm + ',' + dd + ',' + g + ',' + m + ',' + s + ')', 1e3);
        },


    }

};
