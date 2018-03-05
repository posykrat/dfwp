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
	Config::set('svg-path',wp_make_link_relative(get_stylesheet_directory_uri().'/src/assets/svg/generated/sprite.svg'));

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
	register_nav_menus( array(
		'menu-header' => 'Navigation principale'
	));

	//Chargement des fichiers javascript
	function dfwp_enqueueScripts()
	{
		//Le nom du fichier js du projet
		$projectJsName = (Config::getDebug() === false) ? 'bundle.min.js' :  'bundle.js';

		//Enregistrer le script dans la pile
		wp_register_script(
			'dfwp_index',
			get_stylesheet_directory_uri().'/dist/js/'.$projectJsName,
			array(
				'svg4everybody'
			),
			1,
			true
		);

		//svg4everybody
		wp_register_script(
			'svg4everybody',
			get_stylesheet_directory_uri().'/build/node_modules/svg4everybody/dist/svg4everybody.min.js',
			array(
			),
			1,
			true
		);

		//Charger des fichiers js du projet 
		wp_enqueue_script('dfwp_index');

		//Décharger les scripts non nécéssaires
		wp_deregister_script('jquery');
		wp_deregister_script('wp-embed');
	}
	add_action('wp_enqueue_scripts', 'dfwp_enqueueScripts');

	//Chargement styles en front
	function dfwp_enqueueStyle()
	{
		//Le nom du fichier css du projet
		$projectCssName = (Config::getDebug() === false) ? 'index.min.css' :  'index.css';

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

		//Enregistrer la css de la maintenance
		wp_register_style( 
			'dfwp_maintenance',
			get_stylesheet_directory_uri().'/dist/css/maintenance.min.css'
		);

		//Charger le css du projet
        wp_enqueue_style('dfwp_index');
    
        //On decharge la css pour l'admin bar du front de SeoPress
		//wp_dequeue_style('seopress-admin-bar');
		
		//Pour la page pattern uniquement
		if(is_page_Template('page-styleguide.php'))
		{
			//On charge la css qui va bien
			wp_enqueue_style('dfwp_styleguide');
		}

		//Si la maintenance est activée
		if(get_field('dfwp_options_is_maintenance','option') === true)
		{
			//Si on est pas sur l'admin, qu'on est pas un utilisateur connecté ou que l'on est pas sur la page de login
			if(!is_admin() && !is_user_logged_in() && (Login::isLoginPage() == false))
			{
				//On charge la feuille de style de la maintenance
				wp_dequeue_style('dfwp_index');
				wp_enqueue_style('dfwp_maintenance');
			}
		}
	}
	add_action('wp_enqueue_scripts', 'dfwp_enqueueStyle');

	//Add custom query vars for styleguide
	function dfwp_addQueryVars( $vars ){
		$vars[] = "components";
		$vars[] = "bodyclass";
		return $vars;
	}
	add_filter( 'query_vars', 'dfwp_addQueryVars' );
?>