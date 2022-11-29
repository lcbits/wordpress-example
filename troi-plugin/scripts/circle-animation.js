(function($) {

    function pathPrepare($el) {
        var lineLength = $el[0].getTotalLength();
        $el.css("stroke-dasharray", lineLength);
        $el.css("stroke-dashoffset", lineLength);
    }

    $.fn.circleAnimation = function() {

        var timeline = new TimelineMax();

        var animation_styles = {};

        var isVideotype;

        var isAutoplay;

        var isScrollbased;

        var reset_timeline = function() {
            timeline = new TimelineMax();
        };


        animation_styles[0] = function(element) {
            var animationdelay = $(element).data('animationdelay');
            var text = $(element).find('.circle-description'); // Description.
            start = new TimelineMax().set(text, { autoAlpha: 0 });
            // text.hide();
            timeline.set( text, { scale: 0, autoAlpha: 0 } );
            timeline.add( TweenMax.to( text, animationdelay, { scale: 1, autoAlpha: 1 }) );
            timeline.add( TweenMax.to( text, animationdelay, { scale: 2, autoAlpha: 0 }) );

            var result = { animation: timeline };
            if ( isEndAnimation ) {
                result.endAnimation = new TimelineMax().add( TweenMax.to( text, 0.5, {autoAlpha: 0, scale: 0}) );
            }
            return result;

        };

        animation_styles[1] = function(element) {

            var animationdelay = $(element).data('animationdelay');
            var blockProgress = $(element).find('.progress-circle-prog');
            var blockBranch = $(element).find("path.branch-path");
            var percent = 35;
            var circumference = 2 * Math.PI * 265;

            var circleProgress =  percent / 100 * circumference;
            var dasharray = `${circleProgress} ${circumference}`;
            if (blockBranch.length != '') {
                pathPrepare(blockBranch);
            }

            var texts = $(element).find('.branch-group').find('text');
            gsap.set(texts, {opacity: 0} );
            var circlesvg = $(element);
            var start = new TimelineMax().add(circlesvg, { autoAlpha: 0, scale: 0 });

            var tween = new TimelineMax();
            tween.set(texts, {opacity: 0} );
            // tween.add( TweenMax.fromTo(circlesvg, animationdelay,  { autoAlpha: 0, scale: 0 }, { autoAlpha: 1, scale: 1, transformOrigin: '56% 50%' }) );
            // tween.add( TweenMax.to(circlesvg, animationdelay,  { autoAlpha: 1, scale: 1 }) );
            tween.add( TweenMax.to(blockProgress, (animationdelay + (animationdelay / 2) ), { css: {  strokeDasharray: dasharray, ease: Power4.easeIn } }) );
            // tween.set( blockBranch, { strokeDasharray: 0, strokeDashoffset: 0  })
            gsap.utils.toArray(blockBranch).forEach((box) => {
                text = $(box).parent('g.branch-group').find('text');
                var list = box.classList
                if ( Object.values(list).indexOf('left') == 1) {
                    tween.add(TweenMax.to(box, animationdelay, { strokeDasharray: '5', strokeDashoffset: 5 }, "+=1" ));
                } else {
                    tween.add(TweenMax.to(box, animationdelay, { strokeDashoffset: 0, ease: Linear.easeNone, stagger: true }, "+=1.5" ));
                }
                tween.add(TweenMax.to(text, animationdelay, { opacity: 1, ease: Power4.easeIn } ));
            });

            var result = { animation: tween, startAnimation: start};
            // Hide the texts.
            if ( isEndAnimation ) {
                result.endAnimation = new TimelineMax().set(texts, { css: { opacity: 0} }, "+=1" );
            }
            return result;

        };

        // Counter + load  text
        animation_styles[2] = function(element) {

            var animationdelay = $(element).data('animationdelay');

            var countcontent = $(element).find('.counter-content');
            var count = $(element).find('.counter-value');
            var startvalue = $(element).data('startvalue');
            var endvalue = $(element).data('endvalue');
            var value = {score: startvalue};
            var duration = $(element).data('duration');

            var blockProgress = $(element).find('.counter-circle-prog');
            var percent = 100;
            var circumference = 2571;//2 * Math.PI * 250;
            var circleProgress =  percent / 100 * circumference;
            var dasharray = `${circleProgress} ${circumference}`;
            // Hide percentage before start.
            var start = new TimelineMax()
                .set(countcontent, { autoAlpha: 0, scale: 0 });
            // timeline.add(TweenMax.to());
            var ctl = new TimelineLite();
            // Circle Progress.
            ctl.to(blockProgress, (animationdelay * 5), { css: {  strokeDasharray: dasharray, ease: Power2.easeIn } });
            ctl.to(countcontent, animationdelay, { autoAlpha: 1, scale: 1 }, '-=' + (animationdelay * 5) );
            ctl.to(value, ((duration != '') ? duration : 5), {
                score: endvalue,
                roundProps: 'score', onUpdate: () => {
                    count.html(value.score);
                },
                duration: (duration != '') ? duration : 2,
                ease: Linear.easeNone
            }, "-=" + (animationdelay * 6) )
            .to(blockProgress, (animationdelay), {scale: 2, autoAlpha: 0, transformOrigin: '56% 50%' } )

            var result = {animation: ctl, startAnimation: start};
            if ( isEndAnimation ) {
                result.endAnimation = new TimelineMax()
                    .set(blockProgress, {scale: 0 })
                    .set(countcontent, { autoAlpha: 0, scale: 0 })
                    .set(count, { innerHTML: "0" });
            }
            return result;
        };

        // Gettogther.
        animation_styles[3] = function(element) {

            var animationdelay = $(element).data('animationdelay');

            var circle = $(element).find('.circle-block');
            var outercircle = $(element).find('.outer-circle-bordered');
            var caption = circle.find('h1');
            var description = circle.find('.description');

            var start = new TimelineMax().set([caption, description], {autoAlpha: 0});

            var timeline = gsap.timeline();
            timeline.add( TweenMax.set([caption, description], { autoAlpha: 0 }) );
            timeline.add( TweenMax.fromTo(caption, animationdelay, { y: 100 }, { y: 0, autoAlpha: 1 }) );
            timeline.add( TweenMax.fromTo(description, animationdelay, { y: 100 }, { y: 0, autoAlpha: 1 }) );
            timeline.add( TweenMax.to(outercircle, (animationdelay + ( animationdelay / 2 ) ), { css: {left: "0px"} } ) );
            timeline.add( TweenMax.to(outercircle, 0, { opacity: 0 } ));


            var result = { startAnimation: start, animation: timeline, toggleActions: "play none none none" };
            if (isEndAnimation) {
                result.endAnimation = new TimelineMax().set([caption, description], {autoAlpha: 0});
            }
            return result;
        };

        // Pulsing circle.
        animation_styles[4] = function(element) {

            var animationdelay = $(element).data('animationdelay');

            var rings = $(element).find('circle:eq(1)');
            let action = gsap.timeline({paused:true, defaults: { ease: "none" }})
            .to(rings, {duration: animationdelay, attr: {r:295, "stroke-width":15}}, '-=0.05')
            .to(rings, {duration: animationdelay, attr: {r:295, "stroke-width":5}}, '-=0.05');
            //special ease for entire timeline - tween the timeline ...
            // var animation = timeline.to( action, 2,  {time:action.duration(), duration: action.duration(),
                // ease:"power1.out", repeat:-1, repeatDelay:0});
            if (isVideotype) {
                var animation = timeline.to(action, animationdelay,  {time:action.duration(), ease:"power1.out", repeat: 2, repeatDelay:0 } );
            } else {
                var animation = timeline.to(action, animationdelay,  {time:action.duration(), ease:"power1.out", repeat:-1, repeatDelay:0 } );
            }

            return { animation: animation };
        };

        // Growing out side circle.
        animation_styles[5] = function(element) {
            var animationdelay = $(element).data('animationdelay');
            var text = $(element).find('.outer-circle-bg');
            timeline.to( text, 0, { opacity: 0, scale: 0.7 } );
            // timeline.to( element, 0, { width: "100%" } );
            timeline.to( text, animationdelay, { opacity: 1, scale: 1 }, "+=" + animationdelay );
            timeline.to( text, animationdelay, { scale: 2, opacity: 0 }, "+=" + animationdelay );
            timeline.to( text, 0, { scale: 1 });

            var start = new TimelineMax().set(text, { opacity: 0, scale: 0.7 } );
            
            return { animation: timeline, startAnimation: start };

        };

        // Rotate circle.
        animation_styles[6] = function(element) {
            var animationdelay = $(element).data('animationdelay');
            var rotateobj = $(element).find('.rotate-circle');
            timeline.add( TweenMax.set(rotateobj, { autoAlpha: 0 } ) );
            timeline.add( TweenMax.to(rotateobj, (animationdelay / 2), {autoAlpha: 1} ), "+=" + (animationdelay * 2) );
            timeline.add( TweenMax.to(rotateobj, ( animationdelay + (animationdelay / 2) ) , { rotation: 360 }) );

            var start = new TimelineMax().set(rotateobj, { autoAlpha: 0 });
            return { animation: timeline, startAnimation: start };

        };

        // Multi circle item.
        animation_styles[7] = function(element) {

            var parentCircle = $(element).find('.circle-block');
            var icons = $(element).find('.item-icon');
            icons.each(function() {
                icon = $(this);
                leftPercent = icon.data('xposition');
                topPercent = icon.data('yposition');

                gsap.set( icon, {css: { top: topPercent, left: leftPercent } });
                var childCircle = icon.find('.icon-circle');
                var childAnim = gsap.to(childCircle, {duration: 1, scale: 2});
                if (!isVideotype) {
                    gsapScrollTrigger(childCircle, {
                        animation: childAnim,
                        scrub: true
                    })
                }
            });
            var parentAnim = gsap.to(parentCircle, {duration: 0.5, scale: 1.3, opacity: 0});
            if (!isVideotype && !isScrollbased) {
                gsapScrollTrigger(parentCircle, { animation: parentAnim, scrub:true });
                return false;
            }
            return { animation: parentAnim }
        };


        animation_styles[8] = function(element) {
            var animationdelay = $(element).data('animationdelay');

            var countcontent = $(element).find('.counter-content');
            var count = $(element).find('.counter-value');
            var startvalue = $(element).data('startvalue');
            var endvalue = $(element).data('endvalue');
            var value = {score: startvalue};
            var duration = $(element).data('duration');

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
            var blockLineFirst = $(element).find("path#linepath");
            var blockCircleFirst = $(element).find("path.circlepath");

            // prepare SVG paths
            pathPrepare(blockLineFirst);
            pathPrepare(blockCircleFirst);

            blockTriggerHeight = count.height();
            // Hide percentage before start.
            var start = new TimelineMax()
                .set(countcontent, { autoAlpha: 0, scale: 0 });
            // timeline.add(TweenMax.to());
            var ctl = new TimelineLite();
            ctl.to(countcontent, animationdelay, { autoAlpha: 1, scale: 1 }, "+="+animationdelay);//, '-=' + (animationdelay * 5) );
            ctl.to(value, (duration != '') ? duration : 5, {
                score: endvalue,
                roundProps: 'score',
                onUpdate: () => {
                    count.html(value.score);
                },
                // duration: (duration != '') ? duration : 2,
                ease: Linear.easeNone
                // timeline: ctl
            });

            //
            ctl.add( TweenMax.to( blockLineFirst, 0.4, { strokeDashoffset: 0, ease: Linear.easeNone }), "-="+animationdelay) // Draw word for 0.3
            gsap.utils.toArray(blockCircleFirst).forEach((box) => {
                ctl.add( TweenMax.to( box, animationdelay, { strokeDashoffset: 0, ease: Linear.easeNone, stagger: true } ));//, "-=" + animationdelay);
            })
            ctl.add( TweenMax.to( $(element).find('.count-circle'), 2, {scale: 2.3, transformOrigin: '56% 50%', autoAlpha: 0, ease: Power4.easeOut}) )
            ctl.add( TweenMax.to( $(element).find('.count-circle'), 2, {scale: 0}) )

            var result = { animation:ctl, startAnimation: start };
            if ( isEndAnimation ) {
                result.endAnimation = new TimelineMax()
                    .set(blockCircleFirst, {scale: 0 })
                    .set(countcontent, { autoAlpha: 0, scale: 0 })
                    .set(count, { innerHTML: "0" });//
                // return {animation: ctl, endAnimation: endAnimation, startAnimation: start};
            }
            return result; //{ animation: ctl, startAnimation: start };
        };


        animation_styles[9] = function(element) {
            var animationdelay = $(element).data('animationdelay');

            var text = $(element).find('.circle-description');
            var dotted = $(element).find('.outer-circle-bordered');
            var circleblock = $(element).find('.circle-block');

            // timeline.set( circleblock, { autoAlpha: 0 } );
            var start = new TimelineMax().set( dotted, { autoAlpha: 0 } ) // Hide dotted circle.
                .set( text, { opacity: 0, scale: 0.7 } );

            timeline.set( dotted, { autoAlpha: 0 } ); // Hide dotted circle.
            timeline.to( text, 0, { opacity: 0, scale: 0.7 } ); // Hide text.
            timeline.to( circleblock, 0, { autoAlpha: 1 } ); // #1 show
            timeline.to( text, animationdelay, { opacity: 1, scale: 1 }, "+=" + (animationdelay) ); // #2 Text show
            timeline.to( dotted, ( animationdelay - animationdelay / 2 ), { autoAlpha: 1 } );
            timeline.to( [text, dotted], animationdelay, { scale: 2, opacity: 0 });

            return { animation: timeline, startAnimation: start };
        };

        animation_styles[10] = function(element) {
            var animationdelay = $(element).data('animationdelay');
            // caption 2 - right to left.
            var firstcircle = $(element).find('.first-circle-anim');
            // Caption 1 = left to right with circle.
            var secondcircle = $(element).find('.second-circle-anim');
            // pulse
            var thirdanim = $(element).find('.third-circle-anim');
            // Rotate-arrow.
            var fourthanim = $(element).find('.fourth-circle-anim');
            var rotateobj = fourthanim.find('.rotate-circle');
            var description = $(element).find('.description');

            var rings = $(element).find('svg.pulsing').find('circle:eq(1)');
            let action = gsap.timeline({paused:true, defaults: { ease: "none" }})
            .to(rings, {duration: (animationdelay * 2), attr: {r:295, "stroke-width":15}}, '-=0.05')
            .to(rings, {duration: (animationdelay * 2), attr: {r:295, "stroke-width":5}}, '-=0.05');
            //special ease for entire timeline - tween the timeline ...
            // var animation = timeline.to( action, 2,  {time:action.duration(), duration: action.duration(),
                // ease:"power1.out", repeat:-1, repeatDelay:0});

            // tween = new TimelineMax();
            timeline.add( TweenMax.fromTo(firstcircle, (animationdelay * 2), { x: 500 }, { x: 0,  display: "block" } ) );
            timeline.add( TweenMax.fromTo(secondcircle, (animationdelay * 2), { x: -500  }, { x: 0 , display: "block" } ) );
            timeline.add( TweenMax.to( thirdanim, animationdelay, {display: "block"}) );
            if (isVideotype) {
                timeline.add( action, (animationdelay * 2), { time:action.duration(), ease:"power1.out", repeat: 2, repeatDelay:0 } );
            } else {
                timeline.add( action, (animationdelay * 2), { time:action.duration(), ease:"power1.out", repeat:-1, repeatDelay:0 } );
            }
            timeline.add( TweenMax.to( fourthanim, animationdelay, {display: "block"}) );
            timeline.add( TweenMax.to( rotateobj, ( animationdelay + animationdelay / 2 ), { rotation: 360 }) );

            if (isEndAnimation) {
                var endAnimation = new TimelineMax().to($(element).find(".combine-item"), delaynext, {display: "none"} );
                return {animation: timeline, endAnimation: endAnimation};
            }
            return { animation: timeline }
        };

        var gsapScrollTrigger = function(element, options) {

            var defaultAnim = {
                animation: timeline,
                trigger: element,
                start: "50% 50%",
                
                toggleActions: 'restart resume restart restart'
            };
            //, toggleActions: 'pause restart restart restart' };
            var settings = $.extend({}, defaultAnim, options);
            // Create scroll trigger.
            ScrollTrigger.create(settings);
            if (isVideotype) {
                ScrollTrigger.paused(true);
            }
        }


        this.each(function() {


            isVideotype = ( $(this).data('videotype') == 'yes' ) ? true : false;// $(this).find('.circle-item').length > 1 ? true : false;

            isAutoplay = ( $(this).data('autoplay') == 'yes' ) ? true : false;

            delaynext = ( $(this).data('delaynext') != '' ) ? $(this).data('delaynext') : 1;

            isScrollbased = ( $(this).data('scrollbased') != '' ) ? true : false;
            
            isEndAnimation = (isVideotype);

            // { repeat: -1, repeatDelay: 1 }
            var masterTimeline = new TimelineMax({ paused: true, repeat: -1, repeatDelay: 1 });

            var circles = $(this).find('.circle-item');

            if (isVideotype) {
                circles.hide();
            }
            

            gsap.utils.toArray(circles).forEach( function( circle, key ) {
                var style = $(circle).data('circle-style');
                style = style.replace('style', '');
                var stylefunction = parseInt(style);
                styleAnim = animation_styles[stylefunction](circle);
                reset_timeline();
                if (styleAnim) {
                    // Scrollbased animation updated - 15-05-2021.
                    if (isScrollbased) {
                        if (typeof styleAnim.animation !== undefined) {
                            // $(circle).css({ "background-color": "#ccc" });

                            $(circle).css({'height': $(circle).outerHeight() * 2 })                            
                            gsap.set($(circle), {autoAlpha: 0, ease: Power1.easeOut} );

                            var scrollTimeline = new TimelineMax();
                            if (typeof styleAnim.startAnimation !== undefined) {
                                // var startAnimation = new TimelineMax()
                                scrollTimeline.add( TweenMax.to( $(circle), 0.1, { autoAlpha: 0, ease: Power1.easeOut }) )
                                scrollTimeline.add( styleAnim.startAnimation );

                                // gsapScrollTrigger( $(circle), { animation: startAnimation, scrub: false, pin: false, markers:true, start:"10% 90%" });
                            }
                            // Show the circle Block.
                            // masterTimeline.add( TweenMax.to( $(circle), 0, { autoAlpha: 0, ease: Power1.easeOut }), "-=1" );
                            // masterTimeline.add( TweenMax.to( $(circle), 0.5, { css: { visibility: "visible" } }) );
                            scrollTimeline.add( TweenMax.to( $(circle), 0.5, { autoAlpha: 1, ease: Power1.easeIn }) );
                            // Animation from style.
                            scrollTimeline.add( styleAnim.animation );
                            // Hide circle.
                            scrollTimeline.add( TweenMax.to($(circle), 0.5, { autoAlpha: 0, ease: Power1.easeOut } ));

                            var  options = {
                                start: "10% 30%",
                                pin: true,
                                pinSpacing: false,
                                scrub: true,
                                // markers: true,
                                end: $(circle).outerHeight() + 200 + " 30%",
                                animation: scrollTimeline
                            };
                            // Circle item main animations.
                            gsapScrollTrigger( $(circle), options );
                        }

                    } else if (!isVideotype) {

                        if (typeof styleAnim.animation !== undefined) {
                            gsapScrollTrigger($(circle), { animation: styleAnim.animation });
                        }

                    } else {
                        if (typeof styleAnim.startAnimation !== undefined) {
                            masterTimeline.add(styleAnim.startAnimation);
                        }
                        masterTimeline.add( TweenMax.to( $(circle), 0.5, { css: { display: "block" } }) );
                        masterTimeline.add( TweenMax.to( $(circle), 0.5, { autoAlpha: 1, ease: Power1.easeIn }), "-=1" );
                        masterTimeline.add( styleAnim.animation );
                        if (isVideotype) {
                            masterTimeline.add( TweenMax.to($(circle), 1, { autoAlpha: 0, ease: Power1.easeOut } ), '+='+ delaynext);
                            if (typeof styleAnim.endAnimation !== undefined) {
                                masterTimeline.add(styleAnim.endAnimation);
                            }
                            masterTimeline.add( TweenMax.to( $(circle), 0, {css: { display: "none" }} ) );
                        }
                    }
                } else {
                    $(circle).show();
                }
            });

            if (isVideotype) {
                masterTimeline.repeat(-1)
            }


            $(this).click(function() {
                $(this).find('.autoplay-circle').fadeOut();
                if ( masterTimeline.isActive() ) {
                    masterTimeline.paused(true);
                    $(this).find('.autoplay-circle').fadeIn();

                } else {
                    masterTimeline.resume();
                }
            });

            if ( isAutoplay ) {
                ScrollTrigger.create({
                    animation: masterTimeline,
                    trigger: $(this),
                    start: "10% 70%",
                    // scrub: true,
                    // pin: true,
                    // pinSpacing: false,
                    end: $(this).outerHeight()
                })
            }
        })
    }

}) (jQuery);