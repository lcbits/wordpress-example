(function($) {

    var ELEMENT, slideClass = 'cta-slide-item',
        slideSelector = ".block-item.content-block",
        caption = 'h3',
        description = '.description-block',
        activeClass = 'active',
        activeSelector = ".cta-slide-item.active";



    $.fn.CTA_Animation = function() {

        i = 0;

        var activeCTA = function(method='next') {
            activeSlide = ELEMENT.find(activeSelector);
            if (activeSlide.length == 0) {
                if (method == 'prev') {
                    ELEMENT.find('.cta-slide-item:last').addClass('active');
                } else {
                    ELEMENT.find('.cta-slide-item:first').addClass('active');
                }
                //activeSlide = ELEMENT.find(activeSelector);
            }
        };

        var prevCTA = function() {
            activeCTA('prev')
            var prev = (activeSlide.length > 0) ? activeSlide.prev(slideSelector) : [];
            if ( prev.length > 0 ) {
                // prev.show();
                prev.addClass(activeClass);
                activeSlide.removeClass(activeClass);
                activeSlideHide(prev);
            } else {
                activeCTA()
                activeSlideHide(activeSlide);
            }

        };

        var nextCTA = function() {
            activeCTA()
            var next = activeSlide.next(slideSelector);
            if ( next.length > 0 ) {
                next.addClass(activeClass);
                activeSlide.removeClass(activeClass);
                activeSlideHide(next);
            } else {

            }
        };

        var activeSlideHide = function(next) {
            activeCTA();
            title = activeSlide.find(caption);
            hideDesc = activeSlide.find(description);
            // gsap.to(next, 2, { top: -(ELEMENT[0].offsetTop - 100), ease: "power2.inOut" });
            if (next != undefined && next.length > 0) {
                gsap.to(window, {
                    scrollTo: {y: next, autoKill: false},
                    // duration: 1,
                });
            }
            // ELEMENT.bind('wheel');
        }

        return this.each(function() {

            ScrollTrigger.create({
                trigger: this,
                end: 'bottom top+1',
                onLeave: function() {
                    $(this).find(activeSelector).removeClass('active');
                }
            })
            ELEMENT = $(this);

            let sections = gsap.utils.toArray(slideSelector);
          /*   gsap.to(sections, {
                scrollTrigger: {
                    trigger: '.cta-slide-item',
                    start: "top top",
                    pin: true,
                    scrub: 1,
                    snap: 1 / (sections.length - 1 ) ,
                }
                // onEnter: () => nextCTA(),
                // on
            });
 */
            color = ['red', "green", "blue", "orange", 'yellow' ];
            $(this).find(slideSelector).each(function() {
                // if (i == 0) {
                //     $(this).addClass('active');
                //     activeSlide = $(this);
                // }
                // $(this).css({'height': $(this).height() });
                // $(this).css({'background-color': color[i] } );/
                $(this).addClass(slideClass);
                i++;

                ScrollTrigger.create({
                    trigger: $(this),
                    start: "top top",
                    // toggleActions: "none none none none",
                    // snap: 1,
                    // end: "bottom bottom",
                    onEnter: () => nextCTA(),
                    // onEnterBack: () => prevCTA(),
                    // on
                });

                ScrollTrigger.create({
                    trigger: $(this),
                    start: "bottom top+=1",
                    // end: "bottom top+=1",
                    // toggleActions: "none none none none",
                    // snap: $(this),
                    onEnterBack: () => prevCTA(),
                });

                /* ScrollTrigger.create( {
                    trigger: $(this),
                    start: "top top",
                    pin: true,
                    scrub: 1,
                    snap: 1 / (sections.length - 1 ) ,
                }) */
            });



            // $(this).on('wheel', function(e) {
            //     position = e.originalEvent.deltaY;
            //     // $(this).unbind('wheel');
            //     // activeCTA();
            //     // Move upwards
            //     if ( position > 0 ) {
            //         nextCTA();
            //     } else { // Downwards.
            //         prevCTA();
            //     }

            // })


            // activeSlideHide();

        })
    }

}) (jQuery);