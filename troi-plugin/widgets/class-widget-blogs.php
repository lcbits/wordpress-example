<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Blogs extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-blogs'; }

	public function get_title() { return __('Troi Blogs ', self::$slug); }

	public function get_icon() { return 'fa fa-list'; }

	// public function get_categories() { return [ 'general' ]; }

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $this->control_select( 'headtag', 'Head Level', $this->headtags(), 'h1' );

       // $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

     //   $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        // $options = ['al']
        // $this->control_select('blogs', __('Blogs' , parent::$slug), $options);
  
        $this->control_text('buttontext', __( 'Action Button Text', parent::$slug ), '', __( 'READ MORE', parent::$slug) );
       
        $this->controler->add_control(
            '__target',
            [
                'label' => __( 'Open link in New tab', parent::$slug ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'New', parent::$slug ),
                'label_off' => __( 'Same', parent::$slug ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->controler->add_control(
            'blogsperpage',
            [   
                'label' => __( 'Blogs per page', parent::$slug ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10
            ]
        );
        
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    public function post_title_filter($where, $wp_query){
        global $wpdb;
        // 2. pull the custom query in here:
        if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
        }
        return $where;
    }

    public function render() {

        global $wp;

        // the query
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $search = ( get_query_var( 'search' ) ) ? get_query_var( 'search' ) : '';
        $blogsperpage = $this->get_result('blogsperpage');
        $headtag = $this->get_result('headtag');
        $blogsperpage = ($blogsperpage) ? $blogsperpage : -1;
        // echo $blogsperpage; exit;
        $args = array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $blogsperpage, 'paged' => $paged );
        $args = array_merge($args, ['search_prod_title' => $search]);
        add_filter( 'posts_where', [$this, 'post_title_filter'], 10, 2 );
        $posts = new \WP_Query($args);
        remove_filter( 'posts_where', [$this, 'post_title_filter'], 10 );
        $readmore = $this->get_result('buttontext');
        $target = $this->get_result('__target');
       ?>
        <!-- Blog Module -->
        <div class="blog-elements">
            <div class="container">
                <div class="blog-block">
                    <div class="row" >
                        <div class="col-lg-6">
                        </div>
                        <!--Search block-->
                        <div class="col-lg-6">
                            <div class="search-block">
                                <div class="input-group mb-3">
                                    <form action="<?php echo home_url( $wp->request ); ?>">
                                    <input value="<?php echo $search; ?>" type="text" name="search" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Button</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                            <!--blog element-->
                            <div class="col-lg-6">
                                <div class="blog-mod">
                                    <!--blog time-->
                                    <div class="blog-time">
                                        <p><?php echo get_the_date('d.m.Y'); ?></p>
                                    </div>
                                    <!--blog content-->
                                    <div class="content-block">
                                        <<?php echo $headtag; ?>><?php echo the_title(); ?></<?php echo $headtag; ?>>
                                        <div class="desc-block">
                                            <p><?php echo the_excerpt(); ?></p>
                                        </div>
                                        <!--Read more button-->
                                        <div class="btn-block">
                                            <a <?php echo ($target=='yes') ? 'target="_blank"':""; ?> href="<?php echo get_permalink(); ?>"><i class="glyph-icon flaticon-055-right-2"></i> <span><?php echo $readmore; ?></span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php //wp_reset_postdata(); ?>
                        <?php endwhile; ?>
                        
                    </div>
                </div>

                <div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $posts->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Neuere Beiträge', 'troi' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Ältere Beiträge', 'troi' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
</div>

            </div>
        </div>

        <?php 

    }
}
