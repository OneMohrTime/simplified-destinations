<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
    public function __construct() {
        add_action('after_setup_theme', array($this, 'theme_supports'));
        // add_action('init', array($this, 'register_post_types'));
        // add_action('init', array($this, 'register_taxonomies'));
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
        add_action('after_setup_theme', array($this, 'navigation_menus'));
        add_action('widgets_init', array($this, 'create_sidebars'));

        add_filter('timber/context', array($this, 'add_to_context' ));
        add_filter('timber/twig', array($this, 'add_to_twig' ));
        add_filter('timber/twig/environment/options', [$this, 'update_twig_environment_options']);
        add_filter('wpseo_metabox_prio', array($this, 'move_yoast_seo_metabox'));

        parent::__construct();
    }

    // /**
    //  * This is where you can register custom post types.
    //  */
    // public function register_post_types() {
    // }

    // /**
    //  * This is where you can register custom taxonomies.
    //  */
    // public function register_taxonomies() {
    // }

    /**
     * This is where you load the frontend CSS & JS files
     */
    public function load_scripts() {
        // Main "screen" stylesheet
        wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/app.css', array(), null, 'screen' );

        // Main script file
        wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/app.js', array(), null, true );
    }

    /**
     * This is where you register & use WordPress menus
     */
    public function navigation_menus() {
        register_nav_menus([
            'primary' => 'Primary Navigation',
            'utility' => 'Utility Navigation',
            'footer' => 'Footer Navigation',
        ]);
    }

    /**
     * Create a global site sidebar
     */
    public function create_sidebars() {
        register_sidebar( array(
            'name' => 'Global Sidebar',
            'id' => 'globalSidebar',
            'before_widget' => '<div class="c-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="u-heading">',
            'after_title' => '</h3>',
        ) );
    }

    /**
     * This is where you move SEO fields to the bottom of the page
     */
    public function move_yoast_seo_metabox() {
        return 'low';
    }

    /**
     * This is where you add some context
     *
     * @param string $context context['this'] Being the Twig's {{ this }}.
     */
    public function add_to_context( $context ) {
        $context['site']          = $this;
        $context['is_front_page'] = is_front_page();
        $context['options']       = get_fields('option');
        $context['globalSidebar'] = dynamic_sidebar('globalSidebar');

        $custom_logo_url = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
        $context['siteLogo'] = $custom_logo_url;

        $context['primaryMenu'] = Timber::get_menu('primary');
        $context['utilityMenu'] = Timber::get_menu('utility');
        $context['footerMenu']  = Timber::get_menu('footer');

        return $context;
    }

    public function theme_supports() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
        add_theme_support( 'title-tag' );

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support( 'post-thumbnails' );

        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /*
        * Enable support for Post Formats.
        *
        * See: https://codex.wordpress.org/Post_Formats
        */
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
                'audio',
            )
        );

        add_theme_support( 'menus' );

        add_theme_support( 'custom-logo' );
    }

    /**
     * This is where you can add your own functions to twig.
     *
     * @param Twig\Environment $twig get extension.
     */
    public function add_to_twig( $twig ) {
        /**
         * Required when you want to use Twig’s template_from_string.
         * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
         */
        // $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
        // $twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

        return $twig;
    }

    /**
     * Updates Twig environment options.
     *
     * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
     *
     * \@param array $options An array of environment options.
     *
     * @return array
     */
    function update_twig_environment_options( $options ) {
        // $options['autoescape'] = true;

        return $options;
    }
}
