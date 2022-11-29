<?php
    $circles = $this->get_result('circles');
    $autoplay = $this->get_result('autoplay');
    $background = $this->get_background();
    $videotype = $this->get_result('videotype');
    $scrollbased = $this->get_result('scrollbase');

    $classes = ($autoplay == 'yes') ? ' circle-autoplay' : '';
    $classes .= ($videotype == 'yes') ? ' circle-videotype' : '';
    $classes .= ($scrollbased == 'yes') ? ' circle-scrollbased' : '';
    
    $delaynext = $this->get_result('delaynext');
    $delaynext = (isset($delaynext['size']) ? $delaynext['size'] : 2);
    
    $minheight = $this->get_result('blockminheight');
    $minheight = $this->get_option($minheight, 'size'); 
    
    $this->add_render_attribute(
        'circleanimation', [
            'data-delaynext' =>  $delaynext,
            'data-autoplay' => $autoplay,
            'data-videotype' => $videotype,
            'data-scrollbased' => $scrollbased,
            'style' => 'min-height: '.$minheight.'px;',
        ]
    );
?>
<div class="circle-element circle-interact-element troi-circle-gsap-animation <?php echo $background . ' '. $classes; ?>" <?php echo $this->get_render_attribute_string('circleanimation'); ?> >  
<!-- data-autoplay="<?php echo $autoplay; ?>" data-videotype="<?php echo $videotype; ?>"  data-delaynext="<?php echo $delaynext; ?>" -->

 

    <div class="container">
        <?php

        if ($videotype == 'yes' && $autoplay != 'yes') {
        ?>
        <div class="img-block autoplay-circle">
            <img src="<?php echo $this->wwwroot.'assets/img/button.png'; ?>">
        </div>
        <?php
        }

        foreach ($circles as $key => $circle) :
            $text = $this->get_option( $circle, 'description');
            $style = $this->get_option( $circle, 'style' );
            $autoplay = $this->get_option( $circle, 'autoplay' );
            $animationdelay = $this->get_option( $circle, 'animationdelay' );
            $animationdelay = $this->get_option( $animationdelay, 'size' );
            $animclass = (isset($this->animationclass[$style]) ? $this->animationclass[$style] : 'plain-circle-text' );
            $styleclass = (isset($this->styleclass[$style]) ? $this->styleclass[$style] : 'circle-block' );
        ?>
        <?php if ($style == 'style0') : ?>
            <!-- Style 1 -->
            <div class="circle-item"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">
                <div class=" <?php echo $styleclass; ?>">
                    <div class="title-block">
                        <h2 class="circle-description"><?php echo $text; ?></h2>
                    </div>
                </div>
            </div>
            <!-- Stye1 end -->
        <?php endif; ?>

        <?php if ($style == 'style1') :
            $branchs = $this->get_option($circle, 'branchcount');
            $description = $this->get_option($circle, 'description');
        ?>
            <div class="circle-item <?php echo $styleclass; ?>"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">
                <div class="progress">
                    <svg class="progress-circle"  width="1000" height="600" xmlns="http://www.w3.org/2000/svg">
                        <g class="circles" >
                            <circle class="progress-circle-back" cx="50%" cy="50%" r="265" stroke-dasharray="1665, 1665"></circle>
                            <circle class="progress-circle-prog" cx="50%" cy="50%" r="265" stroke-dasharray="0, 1665"></circle>
                        </g>
                        <?php for ( $i=1; $i <= $branchs; $i++ ) :
                            $x = (int) $this->get_option($circle, 'branch['.$i.'][x]');
                            $y = (int) $this->get_option($circle, 'branch['.$i.'][y]');
                            $text = $this->get_option($circle, 'branch['.$i.'][text]');
                            if (!empty($x) && !empty($y)) {
                                $path = 'M'.$x.' '.$y;
                                $path .= ' '.'L';
                                // X > 500 = right.
                                // y > 300 = bottom.
                                $second = (int) ($x > 500 ) ? $x + 60 : $x - 60;
                                $path .= $second;
                                $path .= ' ';
                                $secondy = (int) ($y > 300 ) ? $y + 60 : $y - 60;
                                $path .= $secondy;
                                $path .= ' L';
                                $path .= (($x > 500 ) ? $x + 250 : $x - 250). ' ';
                                $path .= ($y > 300 ) ? $y + 60 : $y - 60;
                                $second = ($x > 500) ? $second : 50;

                                $dasharray = ($x < 500 ) ? 'stroke-dasharray="5, 5"' : '';
                                $dashclass = ($x < 500) ? ' left' : '';
                                echo '<g class="branch-group" >';
                                echo '<path '.$dasharray.' d="'.$path.'" stroke-width="" fill="none" class="branch-path'.$dashclass.'" /> ';
                                echo '<text x="'.$second.'" y="'.($secondy-20).'"  >'.$text.'</text>';
                                echo '</g>';
                            }
                        endfor;
                        ?>
                    </svg>
                    <div class="title-block">
                        <div class="circle-element-content">
                            <div class="block-description" >
                                <p> <?php echo $description; ?> </p>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <style>
                .progress {
                    /*position: absolute;*/
                    height: 600px;
                    width: 1000px;
                    background: none;
                    cursor: pointer;
                    top: 50%;
                    left: 50%;
                    margin: 0 auto;
                }
                .progress .circles circle {
                    transform: rotate(-90deg);
                }
                .progress .circles{
                    transform: translate(20%, 128%)
                }
                .progress-circle-prog {
                    /* transform: rotate(-30deg);  */
                }
                .progress-circle-back {
                    fill: none;
                    stroke: #D2D2D2;
                    stroke-width: 2px;
                }
                .progress-circle-prog {
                    fill: none;
                    stroke: #7E3451;
                    stroke-width: 10px;
                    stroke-dasharray: 0, 1665.4;
                    /* stroke-dashoffset: 0px; */
                    /* transition: stroke-dasharray 0.7s linear 0s; */
                }
            </style>

        <?php endif; ?>

        <?php if ($style == 'style2') :
            $startvalue = $this->get_option($circle, 'startvalue');
            $endvalue = $this->get_option($circle, 'endvalue');
            $startvalue = (empty($startvalue)) ? 0 : $startvalue;
            $endvalue = (empty($endvalue)) ? 0 : $endvalue;
            $symbol = $this->get_option($circle, 'symbol');
            $duration = $this->get_option($circle, 'duration');
            ?>
            <!-- Style 1 -->
            <div class="circle-item "
                data-circleanimation="<?php echo $animclass; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-startvalue="<?php echo $startvalue; ?>"
                data-endvalue="<?php echo $endvalue; ?>"
                data-duration="<?php echo $duration['size'];?>"
                data-animationdelay="<?php echo $animationdelay; ?>"
                >
                <!-- Loading circle + text + counter -->
                <div class="circle-border-block counter-border-block">
                    <svg id="counter-text-circle">
                        <g class="circle-loading-group">
                        <circle fill="none" class="counter-circle-back" cx="50%" cy="50%" r="265" stroke-dasharray="1665, 1665"></circle>
                        <circle fill="none" class="counter-circle-prog" cx="50%" cy="50%" r="265" stroke-dasharray="0, 1665"></circle>
                        </g>
                    </svg>
                    <div class="title-block">
                        <div class="circle-element-content">
                            <h2 class="counter-content">
                                <span class="counter-value" > <?php echo $endvalue; ?> </span>
                                <?php echo ($symbol) ? '<label>'.$symbol.'</label>' : ''; ?>
                            </h2>
                            <h2 class="circle-description"><?php echo $text; ?></h2>
                        </div>
                    </div>
                </div>
                <!-- End of Loading circle + text + counter -->
            </div>
            <style>
                .counter-circle-prog {
                    fill: none;
                    stroke: #7E3451;
                    stroke-width: 10px;
                }

                #counter-text-circle {
                    transform: rotate(-90deg);
                    overflow: inherit;
                }
            </style>

            <!-- Stye1 end -->
        <?php endif; ?>

        <?php if ( $style == 'style3') :

            $caption = $this->get_option($circle, 'caption');
        ?>
        <div class="circle-item "
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>"
                >
            <!-- Get Together -->
            <div class="border-circle-block double-circle">
                <!-- Outer bordered Circle -->
                <!-- End of Outer bordered Circle -->
                <!-- Circle block -->
                <div class="circle-block">
                    <div class="outer-circle-bordered"></div>
                    <div class="title-block">
                        <div class="circle-element-content">
                            <h2><?php echo $caption; ?></h2>
                            <p class="description"> <?php echo $text; ?> </p>
                        </div>
                    </div>

                </div>
                <!-- End of Circle block -->
            </div>
        </div>
            <!-- End of Get together -->
        <?php endif; ?>

        <?php if ($style == 'style4') : ?>
            <!-- Style 1 Pulsing circle -->
            <div class="circle-item pulsing-circle"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>"
            >
            <div class="circle-border-block">
                <svg id="demo" xmlns="http://www.w3.org/2000/svg" width="700" height="700" viewBox="0 0 600 600">
                    <circle r="295" cx="300" cy="300" fill="none" stroke="" stroke-width="2" />
                    <circle r="295" cx="300" cy="300" fill="none" stroke="" stroke-width="5" opacity="1" />
                </svg>
                <div class="title-block">
                    <div class="circle-element-content">
                    <h2 class="circle-description"><?php echo $text; ?></h2>
                    </div>
                </div>
            </div>
		</div>
            <!-- Stye1 end -->
        <?php endif; ?>

        <?php if ($style == 'style5') :
            $image_html = $this->render_image($circle, 'blockicon');
            ?>
            <!-- Style 2 - Growing text outside -->
            <div class="circle-item "
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">
                <div class="circle-block">
                    <div class=" circle-bg-text">
                        <div class="outer-circle-bg"></div> <!-- background circle filled -->
                        <?php if (isset($circle['blockicon']['url']) && !empty($circle['blockicon']['url']) ) : ?>
                        <div class="img-block">
                            <?php echo $image_html; ?>
                        </div>
                        <?php endif; ?>
                        <div class="title-block">
                            <div class="circle-element-content">
                                <h2 class="circle-description"><?php echo $text; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Style2 end -->
        <?php endif; ?>

        <?php if ($style == 'style6') : ?>
            <!-- Style 6 - Rotate arr0w -->
            <div class="circle-item"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">

                <div class="circle-block no-border">
                    <div class="rotate-circle">
		                <img src="<?php echo plugins_url( 'troi-widgets/' );?>assets/img/arrow-circle.png" alt="">
                    </div>
                    <div class="title-block">
                        <div class="circle-element-content">
                            <h2 class="circle-description"><?php echo $text; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Style2 end -->
        <?php endif; ?>
        <!-- Multi circle item -->
        <?php if ($style == 'style7') :
            $value = $this->get_option($circle, 'value');
            $caption = $this->get_option($circle, 'caption');
            $iconcount = $this->get_option($circle, 'iconcount');

            ?>
             <div class="circle-item"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">
                <!-- Multiple circle growing outside -->
                <div class="circle-icon-block">
                    <div class="circle-block"></div>
                    <div class="content-block">
                        <div class="text-block">
                            <h2><?php echo $value; ?></h2>
                            <h3><?php echo $caption; ?></h3>
                            <p><?php echo $text; ?></p>
                        </div>
                    </div>
                    <div class="additional-icons" >
                        <?php
                        for ( $i = 1; $i <= $iconcount; $i++ ) :
                            $icons = $this->get_option($circle, 'icon['.$i.'][img]');
                            $x = $this->get_option($circle, 'icon['.$i.'][x]');
                            $y = $this->get_option($circle, 'icon['.$i.'][y]');
                            $image = $this->render_image($circle, 'icon['.$i.'][img]');
                            $style = 'top: '.$x.'%; left:'.$y.'%;';
                        ?>
                            <!-- Circle icon block -->
                            <div class="item-icon icon-block" style="<?php echo $style; ?>" data-xposition="<?php echo $x."%"; ?>" data-yposition="<?php echo $y."%"; ?>">
                                <div class="icon-circle"></div>
                                <div class="img-block">
                                    <?php echo $image; ?>
                                </div>
                            </div>
                        <?php
                        endfor;
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Clock circle item -->
        <?php if ($style == 'style8') :
            $startvalue = $this->get_option($circle, 'startvalue');
            $endvalue = $this->get_option($circle, 'endvalue');
            $startvalue = (empty($startvalue)) ? 0 : $startvalue;
            $endvalue = (empty($endvalue)) ? 0 : $endvalue;
            $symbol = $this->get_option($circle, 'symbol');
            $duration = $this->get_option($circle, 'duration');
            ?>

             <div class="circle-item"
                data-circleanimation="<?php echo $animclass; ?>"
                data-autoplay="<?php echo $autoplay; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>"
                data-duration="<?php echo $duration['size'];?>" 
                data-startvalue="<?php echo $startvalue; ?>" 
                data-endvalue="<?php echo $endvalue; ?>"
                >

                <div class="counter-block svg-circle-border "  >
                    <svg class="count-circle" version="1.1" id="graphycs" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="auto" height="560px"
                        viewBox="0 0 600 560" enable-background="new 0 0 1140 800" xml:space="preserve">
                        <linearGradient id="linearColors1" x1="1" y1="0.5" x2="1" y2="1" >
                            <stop offset="0%" stop-color="#3c9cfd"></stop>
                            <stop offset="100%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors2" x1="0.5" y1="0" x2="0" y2="0">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors3" x1="1.5" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors4" x1="0.5" y1="0.5" x2=".5" y2="1">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors5" x1="1" y1="0" x2="0.5" y2="0.5">
                            <stop offset="0%" stop-color="#3c9cfd"></stop>
                            <stop offset="100%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors6" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <g id="group">
                            <path class="circlepath" d="M253.9230 70 a120 120 0 0 1 0 120" fill="none" stroke="url(#linearColors1)" stroke-width=".5" />
                            <path class="circlepath" d="M253.9230 190 a120 120 0 0 1 -103.9230 60" fill="none" stroke="url(#linearColors2)" stroke-width=".5" />
                            <path class="circlepath" d="M150 250 a120 120 0 0 1 -103.9230 -60" fill="none" stroke="url(#linearColors3)" stroke-width=".5" />
                            <path class="circlepath" d="M46.077 190 a120 120 0 0 1 0 -120" fill="none" stroke="url(#linearColors4)" stroke-width=".5" />
                            <path class="circlepath" d="M46.077 70 a120 120 0 0 1 103.9230 -60" fill="none" stroke="url(#linearColors5)" stroke-width=".5" />
                            <path class="circlepath" d="M150 10 a120 120 0 0 1 103.9230 60 " fill="none" stroke="url(#linearColors6)" stroke-width=".5" />
                            <g>
                                <clipPath id="SVGID_2_">
                                <use xlink:href="#SVGID_1_"  overflow="visible"/>
                                </clipPath>
                                <path clip-path="url(#SVGID_2_)" id="linepath" fill="none" stroke="#51BBE3" stroke-width=".5" stroke-miterlimit="10" d="M253.9230,1v391.111" />
                            </g>
                        </g>
                    </svg>
                
                    <div class="content-block">
                        <!-- Number of Daily Users -->
                        <h2 class="counter-content">
                            <span class="counter-value" > <?php echo $endvalue; ?> </span>
                            <?php echo ($symbol) ? '<label>'.$symbol.'</label>' : ''; ?>
                        </h2>
                        <!-- Title -->
                        <h2><?php echo $text;?></h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $style == 'style9' ) : ?>
            <!-- Style 1 -->
            <div class="circle-item <?php echo $styleclass; ?>"
                data-circleanimation="<?php echo $animclass; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">

                <div class="outer-circle-bordered"></div>
                <div class="circle-block">
                    <div class="title-block">
                        <div class="circle-element-content">
                            <h2 class="circle-description"><?php echo $text; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stye1 end -->
        <?php endif; ?>

        <?php if ( $style == 'style10' ) :
            $caption = $this->get_option($circle, 'caption' );
            $caption2 = $this->get_option($circle, 'caption2' );

            ?>

            <div class="circle-item <?php echo $styleclass; ?>"
                data-circleanimation="<?php echo $animclass; ?>"
                data-circle-style="<?php echo $style; ?>"
                data-animationdelay="<?php echo $animationdelay; ?>">

                <div class="border-circle-block triple-circle">
                    <!-- Circle block - bg circle -->
                    <div class="combine-item  second-circle-anim">
                        <div class="circle-block  circle-bg-block">
                            <div class="title-block">
                                <div class="circle-element-content">
                                    <h2> <?php echo $caption; ?> </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Circle block - bg circle -->
                    <!-- Circle block -->
                    <div class="combine-item  first-circle-anim">
                        <div class="circle-block">
                            <div class="title-block">
                                <h2> <?php echo $caption2; ?> </h2>
                            </div>
                        </div>
                    </div>
                    <!-- End of Circle block -->

                    <!-- Pulsing Circle block -->
                    <div class="combine-item third-circle-anim">
                        <div class="circle-block circle-border-block ">
                            <svg class="pulsing" id="demo" xmlns="http://www.w3.org/2000/svg" width="700" height="700" viewBox="0 0 600 600">
                                <circle r="295" cx="300" cy="294" fill="none" stroke="" stroke-width="2"></circle>
                                <circle r="295" cx="300" cy="294" fill="none" stroke="" stroke-width="5.0029" opacity="1"></circle>
                            </svg>
                        </div>
                    </div>
                    <!-- End of Pulsing Circle block -->

                    <!-- Arrow Circle block -->
                    <div class="combine-item  fourth-circle-anim">
                        <div class="circle-block  arrow-circle">
                            <div class="rotate-circle" >
                                <img src="<?php echo $this->wwwroot; ?>/assets/img/arrow-circle.png" alt="">
                            </div>
                        </div>
                    </div>

                    <!-- End of Arrow Circle block -->
                </div>
            </div>
            <style>

                .triple-circle .combine-item {
                    display: none;
                }

            </style>
        <?php endif; ?>


        <?php endforeach; ?>
    </div>
</div>