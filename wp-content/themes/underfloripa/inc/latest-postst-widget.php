<?php
if (! defined('ABSPATH')) {
    exit;
}

class Latest_Posts_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'latest_posts_widget',
            __('Latest Posts (Custom)', 'your-textdomain'),
            ['description' => __('Displays the latest 10 posts with thumbnail, category, and title.', 'your-textdomain')]
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        $query = new WP_Query([
            'posts_per_page' => 10,
            'ignore_sticky_posts' => true,
        ]);

        if ($query->have_posts()) {
            echo '<div class="latest-posts-widget">';
            echo '<h3 class="widget-heading">Últimas Publicações</h3>';

            while ($query->have_posts()) {
                $query->the_post();
?>
                <article class="latest-post-card">
                    <a href="<?php the_permalink(); ?>" class="latest-post-thumb">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('square');
                        } ?>
                    </a>
                    <div class="latest-post-content">
                        <span class="latest-post-category">
                            <?php
                            $category = get_the_category();
                            if ($category) {
                                echo esc_html($category[0]->name);
                            }
                            ?>
                        </span>
                        <h4 class="latest-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </div>
                </article>
<?php
            }
            echo '</div>';
        }
        wp_reset_postdata();

        echo $args['after_widget'];
    }
}

function register_latest_posts_widget()
{
    register_widget('Latest_Posts_Widget');
}
add_action('widgets_init', 'register_latest_posts_widget');
