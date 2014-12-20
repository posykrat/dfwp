<?php
	/*
	 * SEO
	 */
	namespace Doublefou\Helper;
	use Doublefou\Core\Singleton;

	abstract Class Seo extends Singleton
	{
		/**
		 * Get the title of current page
		 * @return string
		 */
		public static function getTitle()
		{
			if(is_home()){
				if(is_paged()){
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
					return strip_tags(get_bloginfo('name')).' / page '.$paged;
				}else{
					return strip_tags(get_bloginfo('name'));
				}
			}
			
			if(is_single()){
				$cat = get_the_category();
				if($cat[0] != null){
					return strip_tags($cat[0]->name.' - '.get_the_title());	
				}else{
					return strip_tags(get_the_title());
				}			
			}
			
			if(is_category()){						
				$currentCat = Category::getCurrentCategory();
				if($currentCat != false){
					return strip_tags($currentCat->name);
				}else{
					return "";
				}
			}
		
			if(is_tax() || is_tag()){
				global $wp_query;
				$term = $wp_query->get_queried_object();
				
				if(is_paged()){
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
					return $term->name.' / page '.$paged;
				}else{
					 return $term->name;
				}
			}
			
			if(is_page()){			
				return strip_tags(get_the_title());
			}
					
			if(Post::isCustomPostType()){
				global $wp;
				return ucfirst($wp->request);
			}
		}
		
		/**
		 * Get the description of current page. Si Yoast installé, ne pas utiliser dans le head
		 * @return string
		 */
		public static function getDescription()
		{
			if(is_single() || is_page()){
				global $post;
				$return = StringTool::cutByWords(apply_filters('the_excerpt_rss', str_replace("\n","",htmlentities(strip_tags($post->post_content),ENT_QUOTES,'UTF-8'))), 30,'...');
				if(empty($return)){
					$return = strip_tags(get_the_title());
				}
				return $return;		
			}
			
			if(is_category()){
				$currentCatDesc = Category::getCurrentDescription();
				if($currentCatDesc != false){
					return str_replace("\n","",htmlentities(strip_tags($currentCatDesc),ENT_QUOTES,'UTF-8'));
				}
			}
			
			if(is_home()){
				if(is_paged()){
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
					return get_bloginfo('description').' / page '.$paged;
				}else{
					return get_bloginfo('description');
				}
			}
			
			if(is_tag()){
				global $wp_query;
				$term = $wp_query->get_queried_object();
				
				if(is_paged()){
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
					return $term->name.' / page '.$paged;
				}else{
					return $term->name;
				}
			}
		}
		
		/**
		 * Get keywords
		 * @todo A COMPLETER
		 */
		public static function getKeywords()
		{
			
		}

		/**
		 * Gestion du titre et de la description de la page
		 * Fait appel à Yoast ou SeoCustom en fonction de leurs disponibilités
		 */
		public static function initHeader()
		{
			//Gestion du titre
			add_action('wp_title',function(){

				///Si Yoast n'est pas activé
				if (!class_exists('WPSEO_Frontend')){

					//On utilsie la gestion Seo de DFWP
					echo self::getTitle();			
				}
				
				//Sinon on utilise le titre généré par Yoast
				else{
					global $wpseo_front;
					$title = $wpseo_front->title('');
				}
			});

			//GEstion de la description
			add_action('wp_head', function(){

				///Si Yoast n'est pas activé
				if (!class_exists('WPSEO_Frontend')){

					//On utilsie la gestion Seo de DFWP
					echo '<meta name="description" content="'.self::getDescription().'" />';
				}
				
				//Sinon si Yoast est actif
				else{
					
					//Si la description n'est pas remplie en administration
					if(wpseo_get_value('metadesc') == false){

						//On utilsie la gestion Seo de DFWP
						echo '<meta name="description" content="'.self::getDescription().'" />';							
					}			
				}
			});
		}

		/**
		 * Supprimer les commentaires html injecté par Yoast dans le footer
		 *@todo a tester
		 */
		public static function removeYoastFooter()
		{
			add_action('get_header', function (){
				ob_start(function($output){
					if (defined('WPSEO_VERSION')) {
						$output = str_ireplace('<!-- This site is optimized with the Yoast WordPress SEO plugin v' . WPSEO_VERSION . ' - https://yoast.com/wordpress/plugins/seo/ -->', '', $output);
						$output = str_ireplace('<!-- Avis pour l\'administrateur&nbsp;: cette page n\'affiche pas de méta description car elle n\'en a pas. Vous pouvez donc soit l\'ajouter spécifiquement pour cette page soit aller dans vos réglages (SEO -> Titres) pour configurer un modèle. -->', '', $output);
						$output = str_ireplace('<!-- / Yoast WordPress SEO plugin. -->', '', $output);
					}
					return $output;	
				});
			});
			add_action('wp_head', function(){
				ob_end_flush();
			}, 100);
		}
	}
?>