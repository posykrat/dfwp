<?php
	
	//Exit si accès direct
	if (!defined('ABSPATH')) exit; 

	/*******************************
	 * GESTION DE LA CONFIGURATION DU THEME
	 */
	
	use Doublefou\Helper\Theme;
	use Doublefou\Helper\Yoast;
	use Doublefou\Core\Debug;
	use Doublefou\Core\Config;
	use Doublefou\Helper\Login;

	//Sprite SVG PATH
	Config::set('svg-path',wp_make_link_relative(get_stylesheet_directory_uri().'/src/assets/svg/sprite.svg'));

	//On cache l'admin bar sur le front 
	Theme::hideAdminBar();

	//On clean le head
	Theme::cleanHeader();

	//Désactiver les EMOJI
	Theme::disableEmoji();

	//On ajoute la gestion du <title> par un plugin tiers
	add_theme_support( 'title-tag' );

	//Chargement des langues
	//load_theme_textdomain('dfwpchild',get_stylesheet_directory().'/languages');
	
	//Custom menus
	// register_nav_menus( array(
	// 	'menu-header' => 'Navigation principale'
	// ));

	//Chargement des fichiers javascript
	function dfwp_enqueueScripts()
	{
		//Le nom du fichier js du projet
		$projectJsName = (WP_DEBUG === false) ? 'bundle.min.js' :  'bundle.js';

		//Enregistrer le script dans la pile
		wp_register_script(
			'dfwp_index',
			get_stylesheet_directory_uri().'/dist/js/'.$projectJsName,
			array('svgxuse'),
			1,
			false
        );
        
        //Svgxuse
		wp_register_script(
			'svgxuse',
			get_stylesheet_directory_uri().'/build/node_modules/svgxuse/svgxuse.min.js',
			array(),
			false,
			false
		);

		//Charger des fichiers js du projet 
		wp_enqueue_script('dfwp_index');

        //Décharger les scripts non nécéssaires en front
		if(!is_admin()){
			wp_deregister_script('jquery');
			wp_deregister_script('jquery-migrate');
		}
	}
    add_action('wp_enqueue_scripts', 'dfwp_enqueueScripts');
    
    //Dequeue wp embed
    add_action( 'wp_footer', function(){
        wp_dequeue_script('wp-embed');
    });

	//Chargement styles en front
	function dfwp_enqueueStyle()
	{
		//Le nom du fichier css du projet
		$projectCssName = (WP_DEBUG === false) ? 'index.min.css' :  'index.css';

		//Enregistrer la css dans la pile
		wp_register_style( 
			'dfwp_index',
			get_stylesheet_directory_uri().'/dist/css/'.$projectCssName
		);

		//Enregistrer la css de la styleguide
		wp_register_style( 
			'dfwp_styleguide',
			get_stylesheet_directory_uri().'/dist/css/styleguide.min.css'
		);

		//Charger le css du projet
        wp_enqueue_style('dfwp_index');
    
		//Pour la page styleguide uniquement
		if(is_page_Template('page-styleguide.php')){
			wp_enqueue_style('dfwp_styleguide');
        }
        
        //On decharge la css pour l'admin bar du front de SeoPress
		//wp_dequeue_style('seopress-admin-bar');
	}
	add_action('wp_enqueue_scripts', 'dfwp_enqueueStyle');

	//Add custom query vars for styleguide
	function dfwp_addQueryVars( $vars ){
		$vars[] = "components";
		$vars[] = "bodyclass";
		return $vars;
	}
    add_filter( 'query_vars', 'dfwp_addQueryVars' );
    
    function add_defer_async_attribute($tag, $handle) {
		$scripts_to_defer = array('dfwp_index');
		$scripts_to_async = array('svgxuse');

		foreach($scripts_to_defer as $defer_script) {
			if ($defer_script === $handle) {
				return str_replace(' src', ' defer="defer" src', $tag);
			}
		}
		
		foreach($scripts_to_async as $async_script) {
		   if ($async_script === $handle) {
			  return str_replace(' src', ' async="async" src', $tag);
		   }
		}
		
		return $tag;
	}
	add_filter('script_loader_tag', 'add_defer_async_attribute', 10, 2);
    
?>