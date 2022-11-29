(function($) {

    gsap.registerPlugin('ScrollTrigger');

    // $('[data-widget_type="troi-imagetext-box.default"]').attr('data-widget_type', 'video.default' )

    function addAnimation(element) {
        var animation = 'animate__animated '+ 'animate__'+element.data('animation');
        element.addClass(animation);
    }

    function removeAnimation(element) {
        var animation = 'animate__animated '+ 'animate__'+element.data('animation');
        element.removeClass(animation);
    }


    // Check if element is scrolled into view
    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }



    // **************************** Circle Module **************************** //
    if ( $('.troi-circle-gsap-animation').length > 0 ) {
        $('.troi-circle-gsap-animation').circleAnimation();
    }

    // ****************************** Form module submission ********************//

    var formModule = $('.troi-widget-form');
    formModule.each(function() {
        var form = $(this);
        form.on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            var formid = $(this).attr('id');
            var url = $(this).attr('action');
            var email = $(this).find('[name=sendemail]').val();
            if (url != '' ) {
                $.ajax({
                    url: url,
                    data: $(this).serializeArray(),
                    type: "post",
                    success: function(data) {
                        $('#'+formid).find('.notify-user').html(
                            $('#'+formid).find('.notify-user').data('msg')
                        );
                    }
                })
            }

            $.ajax({
                url: troi_widgets_jsdata.admin_ajax_url,
                data: { formdata: data, action: 'form_send_mail', nonce: troi_widgets_jsdata.nonce  },
                success: function(data) {
                    $('#'+formid).find('.notify-user').append(data.message);
                }
            })
        })
    })

    /**************** Form module animation ***************************************/
    $(".troi-form-animation").each(function() {
        var trigger = this;
        var tls = gsap.timeline();
        height = $(trigger).outerHeight();
        $(this).find('.troi-animation').each(function() {
            var animationin = "animate__"+ $(this).data('animation');

            gsap.to(this, {
                scrollTrigger: {
                    trigger: this,
                    start: "top 90%",
                    // markers: true,
                    scrub: true,
                    toggleClass: animationin, // { target: this, className: "animate_animated " + animationin }
                    repeat: 0,
                    end: "+="+height+" 1%"
                },
                // Multi element inside animation element make delay to animate.
                duration: $(this).hasClass('troi-delay') ? 2 : 1,
            })
        });
    })

    $(".troi-form-popup-animation").each(function() {
        var trigger = this;

        height = $(trigger).outerHeight();
        $(this).find('.troi-animation').each(function() {
            var animationin = "animate__"+ $(this).data('animation');
            gsap.to(this, {
                scrollTrigger: {
                    trigger: this,
                    start: "top 90%",
                    // markers: true,
                    scrub: true,
                    toggleClass: animationin, // { target: this, className: "animate_animated " + animationin }
                    repeat: 0,
                    end: "+="+height+" 1%"
                },
                // Multi element inside animation element make delay to animate.
                duration: $(this).hasClass('troi-delay') ? 2 : 1,
            })
        });

        var formTL = gsap.timeline({
            scrollTrigger: {
                trigger: ".troi-form-popup-animation",
                start: "top 75%",
                end: "top 85%",
                scrub: true,
                // markers: true
                // yoyo:true
            }
        });

        formTL.set('.form-contianer', {  css: { width: "0%", padding: "0px" }});
        formTL.to('.form-contianer', {  css: { width: "50%", padding: "0px 0px 0px 160px" }, ease: Power1.easeIn })

    })



    /******************************************************************************/

    var controller = new ScrollMagic.Controller();

    // Build scene for the bild text gallery.
    var textgallery = $('.bild-text-gallery');
    // let timeline = gsap.timeline();
    textgallery.each(function() {
        var image = $(this).find('.troi-animation-zoom .img-block');
        image.each(function() {
            var element = $(this);
            gsap.registerPlugin('ScrollTrigger');
            var bildTrigger = ScrollTrigger.matchMedia({
                "(min-width: 768px)" : function() {

                    let bildTL = gsap.timeline({
                        scrollTrigger: {
                            trigger: element,
                            start: "top 85%",
                            end: "+=300",
                           toggleActions: 'reset reset reset reset',
                            scrub: true,
                            // markers: true,
                            // id: 'first'
                        }
                        // scale: 1.7,
                        // ease: "none",
                        // duration: 3,
                        // immediateRender: false
                    });
                    bildTL.fromTo(element, {scale: 1}, {scale: 1.3, duration: 3})

                },

                "(max-width: 767px)" : function() {

                    let bildTL2 = gsap.timeline({
                        scrollTrigger: {
                            trigger: element,
                            start: "top 85%",
                            end: "+=300",
                           toggleActions: 'reset reset reset reset',
                            scrub: true,
                            // markers: true,
                            // id: 'first'
                        }
                        // scale: 1.7,
                        // ease: "none",
                        // duration: 3,
                        // immediateRender: false
                    });
                    bildTL2.fromTo(element, {scale: 0.7}, {scale: 1.2, duration: 3})
                }
            });

            $('.gsap-pagination').each(function() {
                var pagination = $(this);
                pagination.find('.gsap-pagination-nav li.page-item').click(function(e) {
                    e.preventDefault();
                    var href = $(this).find('a').attr('href');
                    var content = pagination.find('.pagination-content');
                    var imageboxtl = new TimelineMax();
                    imageboxtl.add( TweenMax.to( content, 1, { opacity: 0, display: 'none' }) );
                    imageboxtl.add( TweenMax.to( $(href), 1, { opacity: 1, display: 'block' }), "+=1" );
                    // $(window).resize();
                    // bildTrigger.reset();
                })
            })

        })
    });

    /************************ CIRCLE CTA *********************************/

    gsap.registerPlugin('ScrollToPlugin');

    let tl = gsap.timeline();

    function goToSection(i, anim) {
        gsap.to(window, {
          scrollTo: {y:  i*innerHeight, autoKill: false},
          duration: 1
        });

        if(anim) {
          anim.restart();
        }
      }
      color = ['red', "green", "blue" ];

    //   $('.circle-cta-block').each(function() {
    //     var itemSelector = $(this).find(".block-item.content-block");
    //     gsap.utils.toArray(itemSelector).forEach((panel, i) => {
    //         gsap.set(panel, { backgroundColor: color[i] })
    //         ScrollTrigger.create({
    //             trigger: panel,
    //             onEnter: () => goToSection(i)
    //         });

    //         ScrollTrigger.create({
    //             trigger: panel,
    //             start: "bottom bottom",
    //             onEnterBack: () => goToSection(i),
    //         });
    //     });
    // })

    $('.circle-cta-block').CTA_Animation();

    // var slideClass = 'cta-slide-item';
    // $('.circle-cta-block').each(function() {

    //     $(this).find(".block-item.content-block").each(function() {

    //         if (i == 0) {
    //             $(this).addClass('active');
    //         } else {
    //             gsap.set( $(this), { display: "none" } );
    //         }
    //         $(this).addClass(slideClass);

    //     });

    //     $(this).on('wheel', function(e) {
    //         position = e.originalEvent.deltaY;
    //         // Move upwards
    //         if ( position > 0 ) {
    //             showPrevCTA();
    //         } else { // Downwards.
    //             showNextCTA();
    //         }
    //     })

    //     function getActiveCTA() {

    //     }

    //     function showPrevCTA() {

    //     }

    //     function showNextCTA() {

    //     }

    //     $(this).find(".block-item.content-block").each(function() {

    //         var end = $(this);
    //         var description = $(this).find('p.description');
    //         var heading = $(this).find('h3');
    //         var hideBlock = $(this).find('.btn-block');//.offsetHeight;

            // var descShow = new TimelineMax({ repeat: 0, repeatDelay: -1 });
            // descShow.set(description, {autoAlpha: 0});
            // descShow.add( TweenMax.fromTo(description, 0.5, { autoAlpha: 0 }, { autoAlpha: 1 } ) );
            // var animationin = "animate__"+ description.data('animation');
            // ScrollTrigger.create({
            //     trigger: description,
            //     animation: descShow,
            //     start: "top 95%",
            //     end: "top 40%",
            //     // markers: true,
            //     toggleClass: animationin,
            //     toggleActions: 'restart none none pause'
            // })
            // // Hide heading.
            // var headinghide = new TimelineMax({ repeat: 0, repeatDelay: -1 });
            // headinghide.add( TweenMax.to(heading, 1, { autoAlpha: 0} ) );
            // ScrollTrigger.create({
            //     trigger: heading,
            //     animation: headinghide,
            //     start: "top 50%",
            //     end: "top 50%",
            //     // markers: true,
            //     scrub: true,
            // })
            // // Hide description and buttons.
            // var hideBlockTL = new TimelineMax({ repeat: 0, repeatDelay: -1 });
            // hideBlockTL.add( TweenMax.to(hideBlock, 1, { autoAlpha: 0} ) );
            // hideBlockTL.add( TweenMax.to(description, 1, { autoAlpha: 0} ) );
            // ScrollTrigger.create({
            //     trigger: hideBlock,
            //     animation: hideBlockTL,
            //     start: "top 50%",
            //     end: "top 50%",
            //     // markers: true,
            //     scrub: true,
            // })

    //     });

    // })

    // ****************** Switch Box animation ************* //
    $(".switch-box-parallax").each(function() {
        trigger = $(this).find('.content-block');
        console.log(trigger.outerHeight());
        element = '.switch-parallax-background';
        switchbox = TweenMax.to(element, 1, {height: trigger.outerHeight() + 200, ease:Back.easeOut});
        // gsap.to(element, {
            ScrollTrigger.create({
                trigger: trigger,
                animation: switchbox,
                start: '20% 80%',
                scrub: true,
                // // markers: true
            })
            // height: trigger.outerHeight(),
            // duration: 1
        // });
    })

    // ********************** Elementor WorkFlow BOX ****************** //
    var workflowContainer = $(".workflow-animation");
    workflowContainer.each(function() {
        var element = $(this).find('.circle-img-block');
        var circleround = TweenMax.to(element, 5, { rotation: 180 } );
        ScrollTrigger.create({
            trigger: element,
            animation: circleround,
            start: '20% 80%',
            scrub: true,
            // // markers: true
        })
    })


    // ********************** Elementor WorkFlow BOX ****************** //
    var linearflowContainer = $(".linear-flow-animation");
    linearflowContainer.each(function() {
        var linearBlocks = $(this).find('.linear-block');
        var line = $(this).find('.linear-scroll-line');
        var lineTL = new TimelineMax();
        var firstblock = $(this).find('.linear-block:first');
        var secondblock = $(this).find('.linear-block:eq(1)');
        var lastblock = $(this).find('.linear-block:last');
        lineTL.add( TweenMax.set(line, { css: { top: ( firstblock.height() )  } }) );
        lineTL.add( TweenMax.fromTo(line, 1, { y: -100,  visibility: 'hidden' }, { y: 0, visibility: 'visible' }) )

        ScrollTrigger.create({
            trigger: line,
            animation: lineTL,
            start: "10% 70%",
        });
        var increaseTop = new TimelineMax();
        $(this).find('.linear-block').each(function() {
            nextblock = $(this).next('.linear-block');
            if (nextblock.length != '') {
              //  var increaseTop = new TimelineMax().add( TweenMax.to(line, 5, { top: ( nextblock.position().top - line.height() ) }) );
                let tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: $(this),
                        //animation: increaseTop,
                        start: "10% 50%",
                        scrub: 1,
                        // markers: true,
                        // pin: line,
                        // endTrigger: nextblock,//'.linear-block:last',
                        // toggleActions: 'restart none none pause'
                    },
                    defaults: {duration: 1}
                });
                tl.to(line, 5, { top: ( nextblock.position().top - line.height() ) })
            }
        })

        gsap.utils.toArray(linearBlocks).forEach((block) => {
            var linearTime = gsap.timeline();
            var first = $(block).find('.gsap-animate-fadeindown');
            var second = $(block).find('.flowcaption.gsap-animate-fadeinup');
            var third = $(block).find('.flowdescription.gsap-animate-fadeinup');
            linearTime.add( TweenMax.set([first, second], { visibility: 'hidden' } ) );
            // TweenMax.set(first, {opacity: 0});
            var slideInDown = TweenMax.fromTo(first, 1, { y: -100,  visibility: 'hidden' }, { y: 0, visibility: 'visible' });
            linearTime.add(slideInDown);

            // TweenMax.set(first, {opacity: 0});
            var slideInDown = TweenMax.fromTo(second, 0.5, { y: 100,  visibility: 'hidden' }, { y: 0, visibility: 'visible' });
            linearTime.add(slideInDown);

            var slideInDown = TweenMax.fromTo(third, 0.5, { y: 100,  visibility: 'hidden' }, { y: 0, visibility: 'visible' });
            linearTime.add(slideInDown, '-=.3');

            ScrollTrigger.create({
                animation: linearTime,
                trigger: $(block),
                start: "10% 90%",
                // // markers: true,
                toggleActions: 'restart none none pause'
            })
        })


    })

    // ********************* Testimonial ********************* //
    var testimonials = $('.testimonial-element');
    testimonials.each(function() {
        var parent = $(this);
        var items  = $(this).find('.carousel-item');
        items.on('click', function() {
            var trigger = $(this);
            var modal = trigger.find('.testimonial-block');
            $('.carousel.slide').carousel('pause');
            trigger.parents('.testimonial-element').addClass('testimonial-popup');
            modal.addClass('popup-content');
        })
    })


    $(document).bind('click', function(e) {
        // alert();
        // console.log(e.target);
        if( !$(e.target).hasClass('popup-tmonial')) {
            // alert('removed');
            $('.testimonial-block').removeClass('popup-content');
            $('.testimonial-element').removeClass('testimonial-popup');
        }
    });



    // ****************** Counter animation ***************//
    var counterselector = '.counter-widget';

    gsap.utils.toArray(counterselector).forEach((counter) => {

        $(counter).find('.counter-block').each(function() {

            var trigger = $(this);

            var count = $(this).find('.counter-value');
            var startvalue = $(this).data('startvalue');
            var endvalue = $(this).data('endvalue');
            var style = $(this).data('style');
            var duration = $(this).data('duration');
            console.log(duration);
            var value = {score: startvalue};

            var ctl = new TimelineLite().to(value, (duration != '') ? duration : 5, {
                score: endvalue,
                roundProps: 'score',
                onUpdate: () => {
                    count.html(value.score);
                },
                //duration: (duration != '') ? duration : 2,
                ease: Linear.easeNone
                // timeline: ctl
            });
            ScrollTrigger.create({
                animation: ctl,
                trigger: count,
                // scrub: true,
                // // markers: true,
                start: 'center 90%'
            })
            // gsap.to()

            if (style == 'style4') {
                //store trigger heights
                var blockTriggerHeight;


                // For each path, set the stroke-dasharray and stroke-dashoffset
                // equal to the path's total length, hence rendering it invisible
                function pathPrepare($el) {
                    var lineLength = $el[0].getTotalLength();
                    $el.css("stroke-dasharray", lineLength);
                    $el.css("stroke-dashoffset", lineLength);
                }

                function pathPrepareCircle($el) {
                    var lineLength;
                    $el.each((key , value) => {
                        console.log(value);
                        lineLength = value.getTotalLength();
                        $(value).css("stroke-dasharray", lineLength);
                        $(value).css("stroke-dashoffset", lineLength);
                    })
                }

                // Store a reference to our paths
                var blockLineFirst = $(this).find("path#linepath");
                var blockCircleFirst = $(this).find("path.circlepath");

                // prepare SVG paths
                pathPrepare(blockLineFirst);
                pathPrepare(blockCircleFirst);

                blockTriggerHeight = count.height();

                // Create a timeline for ease of manipulation and the possibility
                // to play the animation back and forth at the requested speed.
                // Add each separate line animation to the timeline, animating the
                // stroke-dashoffset to 0. Use the duration, delay and easing to
                // achieve the perfect animation.

                // build tween.
                var tween = new TimelineMax()
                    .add(TweenMax.to(blockLineFirst, 0.4, { strokeDashoffset: 0, ease: Linear.easeNone })) // draw word for 0.3
                    // .add(TweenMax.to(blockCircleFirst, 2, { strokeDashoffset: 0, ease: Linear.easeNone }))
                    gsap.utils.toArray(blockCircleFirst).forEach((box) => {
                        tween.add(TweenMax.to(box, 1, { strokeDashoffset: 0, ease: Linear.easeNone, stagger: true }, "+=1.5" ));
                    })
                    tween.add( TweenMax.to($(this).find('.count-circle'), 2, {scale: 2.3, transformOrigin: '56% 50%', autoAlpha: 0, ease: Power4.easeOut}) )
                    tween.add( TweenMax.to($(this).find('.count-circle'), 2, {scale: 0}) )
                    // .add(TweenMax.to(blockCircleFirst, 2, {autoAlpha: 0, ease: Power4.easeOut } ))

                var circletrigger = ScrollTrigger.create({
                    animation: tween,
                    trigger: count,
                    // scrub: true,
                    // // markers: true,
                    start: 'top 90%',
                    toggleActions: 'restart restart restart restart',
                    // onUpdate: () => { console.log(tween); tween.repeat() }
                })


                $(window).scroll(()=> { tween.restart() });
            }
            // var scene = new ScrollMagic.Scene({ triggerElement: blockTrigger, duration: blockTriggerHeight, tweenChanges: true })
            //     .setTween(tween)
            //     .addTo(controller);

        })
    })

    $(".team-animation-row").each(function() {
        var trigger = this;
        var tls = gsap.timeline();
        height = $(trigger).outerHeight();
        $(this).find('.troi-animation').each(function() {
            var animationin = "animate__"+ $(this).data('animation');

            gsap.to(this, {
                scrollTrigger: {
                    trigger: this,
                    start: "top 90%",
                    // markers: true,
                    scrub: true,
                    toggleClass: animationin, // {target: this, className: "animate_animated " + animationin }
                    repeat: 0,
                    end: "+="+height+" 1%"
                },
                // className: "+="+animationin,
                duration: $(this).hasClass('troi-delay') ? 2 : 1,
            })
        });
    })

    $(".troi-paragraph, .troi-icon-box, .image-gallery-block").each(function() {
        var trigger = this;
        var tls = gsap.timeline();
        height = $(trigger).outerHeight();
        $(this).find('.troi-animation').each(function() {
            var animationin = "animate__"+ $(this).data('animation');
            gsap.to(this, {
                scrollTrigger: {
                    trigger: this,
                    start: "top 90%",
                    // markers: true,
                    scrub: true,
                    toggleClass: animationin, // {target: this, className: "animate_animated " + animationin }
                    repeat: 0
                },
                duration: $(this).hasClass('troi-delay') ? 2 : 1,
            })
        });
    });






    /******************************* Image Text Box **************************************/
    $('.troi-video-animation').each(function() {

        var element = $(this).find('.elementor-fit-aspect-ratio');
        if (element.length >= 1) {
            $('.elementor-widget-troi-imagetext-box').click(function() {
                        $(".elementor-custom-embed-play").trigger('click');

            });
            // gsap.to(element, {
            //     scrollTrigger: {
            //         trigger: element,
            //         // scrub: true,
            //         onEnter: function() {
            //             $(".elementor-custom-embed-play").trigger('click');
            //         }
            //     }
            // })
        }
        var parallax = $(this).parent('.image-text-element').attr('parallax');
        if ( element.length >= 1 || parallax == 'yes' ) {
            height = $(this).next('.container').find('.image-text-block').outerHeight();
            // gsap.set(element, {y: `${-innerHeight / 2}px`});
            // gsap.to(element, {
            //     y: `${outerHeight - height }px`,
            //     ease: "none",
            //     scrollTrigger: {
            //         trigger: element,
            //         scrub: true,
            //         start: "top top",
            //         end: "bottom top"
            //     }
            // });
        }
    })


    if ( $(".elementor-widget-troi-imagetext-box .troi-video-animation").length > 0) {
        $(".elementor-widget-troi-imagetext-box").videoBackground({});
    }

    $(".elementor-widget-troi-imagetext-box").each(function() {


        var parallax = $(this).find('.image-text-element').attr('parallax');
        if ( parallax == 'yes' ) {
            var bg = $(this).find('.elementor-widget-container');
            bg.css({"background-position": `50% ${-innerHeight / 2}px`});
            gsap.to(bg, {
                backgroundPosition: `50% ${innerHeight / 2}px`,
                ease: "none",
                scrollTrigger: {
                trigger: $(this),
                scrub: true,
                start: "top top",
                end: "bottom top"
                }
            });
        }
    });

    $(".goto-next-icon").click(function() {
        var widgets = [];
        $('.elementor-element.elementor-widget').each(function() {
            widgets.push($(this).data('id'));
        })
        var dataid = $(this).parents('.elementor-widget.elementor-widget-troi-paragraph').data('id');
        position = widgets.indexOf(dataid);
        if (position >= 0 && position < widgets.length - 1 ) {
            var nextSection = widgets[position+1];
            if ($('[data-id="'+nextSection+'"]').length > 0) {
                TweenMax.to(window, 0, {scrollTo: $('[data-id="'+nextSection+'"]')[0] } );
            }
        }
    });


    // document.addEventListener( 'DOMContentLoaded', function() {
    //     var i,
    //     video = document.getElementsByClassName( 'troi-youtube-player' );

    //     for (i = 0; i <= video.length; i++) {
    //         // We get the thumbnail image from the YouTube ID
    //         video[i].style.backgroundImage = 'url(//i.ytimg.com/vi/' + video[i].dataset.id + '/maxresdefault.jpg)';

    //         video[i].onclick = function() {
    //             var iframe  = document.createElement( 'iframe' ),
    //             embed   = 'https://www.youtube.com/embed/ID?autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0&amp;mute=0&amp;wmode=opaque';
    //             iframe.setAttribute( 'src', embed.replace( 'ID', this.dataset.id ) );
    //             iframe.setAttribute( 'frameborder', '0' );
    //             iframe.setAttribute( 'allowfullscreen', '1' );
    //             this.parentNode.replaceChild( iframe, this );
    //         }
    //     }

    // });

}) (jQuery)