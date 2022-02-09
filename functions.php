<?php

//autoload classes
spl_autoload_register( function($classname) {
    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, $classname ); 
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
    if ( file_exists( $classpath) ) {
        include_once $classpath;
    }
} );


add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );
function myplugin_add_meta_box() {
    add_meta_box('myplugin_sectionid', 'Testing', 'myplugin_meta_box_callback', 'radio' );
}
function myplugin_meta_box_callback ( $post ) {
    echo 'stream: ' . get_post_meta( $post->ID, 'stream', true ) . '<br/>';
    echo 'stream_type: ' . get_post_meta( $post->ID, 'streamtype', true ) . '<br/>';
    echo 'source: ' . get_post_meta( $post->ID, 'city_url', true ) . '<br/>';

    echo 'email_meta: ' . get_post_meta( $post->ID, 'email_meta', true ) . '<br/>';
    echo 'phone_meta: ' . get_post_meta( $post->ID, 'phone_meta', true ) . '<br/>';
    echo 'address_meta: ' . get_post_meta( $post->ID, 'address_meta', true ) . '<br/>';
    echo 'radioid: ' . get_post_meta( $post->ID, 'radioid', true ) . '<br/>';
    echo 'hasProgram: ' . get_post_meta( $post->ID, 'hasProgram', true ) . '<br/>';

};

function wpdocs_theme_name_scripts() {
	wp_enqueue_style( 'iflag', get_stylesheet_directory_uri(). '/assets/css/iflags.css?v='.rand(0, 10000), array());
    wp_enqueue_style( 'style_def_main', get_stylesheet_directory_uri(). '/assets/css/def_main.css?v='.rand(0, 10000), array());
    //wp_enqueue_style( 'landing', get_stylesheet_directory_uri(). '/assets/css/landing1.css' );
    wp_enqueue_script( 'script_bootstrap_js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_style( 'maincss', get_stylesheet_directory_uri(). '/assets/css/maincss.css?v='.rand(0, 10000), array() );
    wp_enqueue_script( 'historyjquery', get_stylesheet_directory_uri() . '/assets/js/jquery.history.js', array('jquery'));
    wp_enqueue_script( 'mainjs', get_stylesheet_directory_uri() . '/assets/js/main_js.js', array('jquery'));
     wp_enqueue_script('videojs', get_stylesheet_directory_uri() . '/assets/js/video.min.js?v='.rand(0, 10000),array('jquery'));
      wp_enqueue_script( 'def_main', get_stylesheet_directory_uri() . '/assets/js/def_main.v1.js?v='.rand(0, 10000), array('jquery', 'videojs'));
      /*wp_localize_script( 'def_main', 'def_main', array(
				'single' => is_single() ? 1 : 0,
			) );*/
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

add_action('init', 'RadioType_init');
function RadioType_init(){
	register_post_type('radio', array(
		'labels'             => array(
			'name'               => 'Радио', // Основное название типа записи
			'singular_name'      => 'Радио', // отдельное название записи типа Book
			'add_new'            => 'Добавить новое',
			'add_new_item'       => 'Добавить новое Радио',
			'edit_item'          => 'Редактировать Радио',
			'new_item'           => 'Новое Радио',
			'view_item'          => 'Посмотреть Радио',
			'search_items'       => 'Найти Радио',
			'not_found'          => 'Радио не найдено',
			'not_found_in_trash' => 'В корзине Радио не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Радио'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		//'taxonomies'          => array( 'category' ),
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
	) );

		register_taxonomy( 'location', [ 'radio' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Регион',
			'singular_name'     => 'Онлайн радио',
			'search_items'      => 'Найти Регион',
			'all_items'         => 'Все Регионы',
			'view_item '        => 'Смотреть Регион',
			'parent_item'       => 'Родительский Регион',
			'parent_item_colon' => 'Родительские Регион:',
			'edit_item'         => 'Редактировать Регион',
			'update_item'       => 'Обновить Регион',
			'add_new_item'      => 'Добавить новый Регион',
			'new_item_name'     => 'Новый Регион',
			'menu_name'         => 'Регион',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		// 'publicly_queryable'    => null, // равен аргументу public
		// 'show_in_nav_menus'     => true, // равен аргументу public
		// 'show_ui'               => true, // равен аргументу public
		// 'show_in_menu'          => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
		'hierarchical'          => true,

		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );

		register_taxonomy( 'genre', [ 'radio' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Жанр',
			'singular_name'     => 'Жанр',
			'search_items'      => 'Найти Жанр',
			'all_items'         => 'Все Жанры',
			'view_item '        => 'Смотреть Жанр',
			'parent_item'       => 'Родительский Жанр',
			'parent_item_colon' => 'Родительские Жанры:',
			'edit_item'         => 'Редактировать Жанр',
			'update_item'       => 'Обновить Жанр',
			'add_new_item'      => 'Добавить новый Жанр',
			'new_item_name'     => 'Новый Жанр',
			'menu_name'         => 'Жанр',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		// 'publicly_queryable'    => null, // равен аргументу public
		// 'show_in_nav_menus'     => true, // равен аргументу public
		// 'show_ui'               => true, // равен аргументу public
		// 'show_in_menu'          => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
		'hierarchical'          => true,

		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );

}


$initTheme = new InitThemeChild();


//add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 1 );
add_action('wp_head', 'filter_the_content_in_the_main_loop');
function filter_the_content_in_the_main_loop( $content = '' ) {
	$loadinggif = '<div id="loadingpage_gif"></div>';
    if ( true
    	//is_singular() && in_the_loop() && is_main_query() && get_post_type() == 'radio'
    ) {
				global $post;
				$stream = get_post_meta($post->ID, 'stream', 1);
				$streamtype = get_post_meta($post->ID, 'streamtype', 1);
				$listeners = get_post_meta($post->ID, 'listeners', 1);
				//!empty($stream)
				$hasProgram = get_post_meta( $post->ID, 'hasProgram', true );
				$default_type = 'video';
				/*if($streamtype=='mp3'){
					$default_type = 'audio';
				}*/
				$radioid = get_post_meta( $post->ID, 'radioid', true );
				 	$button =  '<'.$default_type.' id="top_player" playsinline>
				        <source src="'.$stream.'" type="application/x-mpegURL">
				      </'.$default_type.'>

				 	';
			 	$player = $button . '<div class="player">
				<div class="player__section">
					<div class="player__station">
						<figure class="player__station__title" id="top_player_title"><a href="#" class="ajax"><img class="player__station__logo" src="'.get_the_post_thumbnail_url( $post->ID, 'thumbnail' ).'" alt="'.$post->post_title.'"><figcaption class="player__station__name">'.$post->post_title.'</figcaption></a></figure>
						<span id="top_player_track" class="player__station__track" loading="загружается" playing="проигрывается" error="ошибка проигрывания" not_supported="this browser can\'t play it" external="Слушать сейчас (Открывается в popup player)" stopped="вещание остановлено" geo_blocked="Недоступно в вашем регионе"></span>
					<!--/player__station-->
					</div>

					<div class="player__controls" role="toolbar">
						<button class="b-play" id="b_top_play" role="button" title="Слушать радио" '.($hasProgram ? 'radioHasProgram="true"' : '').' radioId="'.$radioid.'" data-stream="'.$stream.'" data-type="'.$streamtype.'" radioname="'.$post->post_title.'" listeners="'.$listeners.'"></button>

						<div class="player__volume" id="top_vol_panel">
							<button class="b-volume" id="b_vol_control" title="Регулировка громкости"></button>
							<div class="player__volume__slider" role="slider" id="top_volume_slider" aria-label="volume_level" aria-valuemin="0" aria-valuemax="100" aria-valuenow="" aria-orientation="vertical">
								<div class="b-slider" id="top_volume_control"></div>
							</div>
						</div>
					</div>
					
				</div>
			</div>'; 
        echo $player . $content . $loadinggif;
    }

    echo $content;
}

function contacts_add_to_content( $content ) {    
    if( is_single() ) {
    	global $post;
    	$email = get_post_meta( $post->ID, 'email_meta', true );
    	$phone = get_post_meta( $post->ID, 'phone_meta', true );
    	$address = get_post_meta( $post->ID, 'address_meta', true );
    	if($email || $phone || $address){
    		$content .= '<h5><strong>Контакты</h5></strong>';
		    if($email) { $content .= get_post_meta( $post->ID, 'email_meta', true ) . '<br/>'; }
		    if($phone) { $content .= get_post_meta( $post->ID, 'phone_meta', true ) . '<br/>'; }
		    if($address) { $content .= get_post_meta( $post->ID, 'address_meta', true ) . '<br/>'; }
    	}
    }
    return $content;
}
add_filter( 'the_content', 'contacts_add_to_content' );

add_filter('the_content', function($content){
	global $post;
	$player_btn = '';
    if ( is_singular() && in_the_loop() && is_main_query() && get_post_type() == 'radio') {
				global $post;
				$stream = get_post_meta($post->ID, 'stream', 1);
				$streamtype = get_post_meta($post->ID, 'streamtype', 1);
				$listeners = get_post_meta($post->ID, 'listeners', 1);
				//!empty($stream)
				$hasProgram = get_post_meta( $post->ID, 'hasProgram', true );
				$radioid = get_post_meta( $post->ID, 'radioid', true );
	$player_btn .= '<button class="b-play" id="b_top_play2" role="button" title="Слушать радио" '.($hasProgram ? 'radioHasProgram="true"' : '').' radioId="'.$radioid.'" data-stream="'.$stream.'" data-type="'.$streamtype.'" radioname="'.$post->post_title.'" listeners="'.$listeners.'"></button>';
	}
 return  $player_btn . $content;
});

add_filter('the_content', function($content){
	global $post;
	$genres = '';
	    $taxonomyTerms = wp_get_post_terms( $post->ID, 'genre', 'orderby=name&hide_empty=0' );
	    if( $taxonomyTerms ){ 
	    	$genres = '<hr/><ul class="station__tags" style="margin-left:0" role="list">';
		    foreach ( $taxonomyTerms as $taxonomyTerm ) {
		        $genres .= '<li><a href="'.get_term_link($taxonomyTerm->term_id).'" class="ajax">'.$taxonomyTerm->name.' </a></li>';
		    }
		    $genres .= '</ul><br/>'; 
	    }
 return  $content . $genres;
});

function yoast_breadcrumb($start,$end) {
	if(is_single() || is_archive() || is_tax()) {
	$output= '';	
	$current_term_html = '';
	$show_top_bread = 0; //верхние хлебные крошки
	global $meta_position;
	$meta_position = 1;
    if(is_single()) {
    	global $post;
    	if(!$post) { return; }
        $postId = $post->ID;
		$output =  '<ul class="breadcrumbs" itemscope="" itemtype="https://schema.org/BreadcrumbList" role="navigation">';

		if($show_top_bread){
			$output .= '<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
	        <a class="ajax" itemprop="item" itemtype="https://schema.org/Thing" href="' . home_url() . '"><span itemprop="name">'.__('Главная').'</span></a><meta property="position" content="'.$meta_position.'"></li>';
	        $meta_position++;
	        $output .= get_regions() . '<hr/>';
		}

		$output .=  taxonomy_hierarchy();

       	$output .= '<li>'. $post->post_title . '<meta property="position" content="'.$meta_position.'"></li>';
        $output .= '</ul>';

	}

    if(is_archive()) {
		$queried_object = get_queried_object('term');
		$term_parent = $queried_object->term_id;
		$btn_all = $queried_object->taxonomy;
		$orderby = 'name';
		$order = 'asc';
		if($queried_object->taxonomy == 'location'){
			$output = '<ul class="breadcrumbs" itemscope="" itemtype="https://schema.org/BreadcrumbList" role="navigation">';

			if($show_top_bread){
				$output .= '<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
		        <a class="ajax" itemprop="item" itemtype="https://schema.org/Thing" href="' . home_url() . '"><span itemprop="name">'.__('Главная').'</span></a><meta property=\"position\" content="'.$meta_position.'"></li>';
		        $meta_position++;
		        $output .= get_regions() . '<hr/>';
		    }

			$termobject_parent = $queried_object->parent;
			if($termobject_parent){
				$output .= taxonomy_hierarchy() . $current_term_html;
			}

			$output .= '</ul>';
			$args = array(
			  'parent' => $term_parent,
			  'orderby' => $orderby,
			  'order' => $order,
			  'hide_empty' => 0,
			  );
			$terms = get_terms( 'location', $args );
			$btn_all = 'регионы';

		}elseif($queried_object->taxonomy == 'genre'){
			$args = array(
			  'orderby' => $orderby,
			  'order' => $order,
			  'hide_empty' => 0,
			  );
			$terms = get_terms( 'genre', $args );
			$output .='<h2>'.__('Жанры').'</h2>';
			$btn_all = 'жанры';
		}else{
			//default load location 
			$output = '<ul class="breadcrumbs" itemscope="" itemtype="https://schema.org/BreadcrumbList" role="navigation">';
			$output .= '<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
	        <a class="ajax" itemprop="item" itemtype="https://schema.org/Thing" href="' . home_url() . '"><span itemprop="name">'.__('Главная').'</span></a><meta propetry=\"position\" content="'.$meta_position.'"></li>';
	        $meta_position++;
	        $output .= get_regions() . '<hr/>';

			$termobject_parent = $queried_object->parent;
			if($termobject_parent){
				$output .= taxonomy_hierarchy() . $current_term_html;
			}

			$output .= '</ul>';
			$args = array(
			  'parent' => $term_parent,
			  'orderby' => $orderby,
			  'order' => $order,
			  'hide_empty' => 0,
			  );
			$terms = get_terms( 'location', $args );
		}



		
		if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			$offset_show = 6;
		
			$output .= '<div class="regions" aria-label="regions" role="directory">';
			 
			$first_panel = array_slice($terms, 0, $offset_show, true);
			if($first_panel){
				$output .= '<div class="panel"><ul class="regions-list" id="top-regions" aria-expanded="true">';
			    foreach ( $first_panel as $term ) {
			    	$isCountry = !get_term($term->parent)->parent ? true : false;
			       	$output .= '<li><a class="ajax '.($isCountry ? get_term_meta($term->term_id,'class',1) : '').'" href="' . get_category_link( $term ) . '">' . $term->name . '</a>
			       	<meta property="position" content="'.$meta_position.'"></li>';
			       	$meta_position++;
			    }
			if(count($terms)>$offset_show){
				$second_panel = array_slice($terms, $offset_show);
				    foreach ( $second_panel as $term ) {
				    	$isCountry = !get_term($term->parent)->parent ? true : false;
				       	$output .= '<li class="sub_regions-list"><a class="ajax '.($isCountry ? get_term_meta($term->term_id,'class',1) : '').'" href="' . get_category_link( $term ) . '">' . $term->name . '</a>
				       	<meta property="position" content="'.$meta_position.'"></li>';
				       	$meta_position++;
				    }
			}
			    $output .= '</ul>
						</div>';
			}
			if(count($terms)>$offset_show){
				$output .= '
					<span class="more--regions collapsed"  style="padding-top: 25px;" id="all_region_collapse" data-toggle="collapse" data-parent=".regions" data-target="#regions_all" aria-expanded="false" role="button">'.__('Все') . ' ' .$btn_all.'</span>
					';
			}

			$output .= '
				</div>';

		}

	}


		echo do_shortcode( $start  . $output . $end );
	}
}

function getParentBreadTax_clear($parent, $out = ''){
	$term = get_term($parent);
	if(is_wp_error( $term )){ return ''; }
	if($term->parent && !empty($term->parent)){
		return getParentBreadTax_clear($term->parent, $out);
	}
	return $parent;
}

function get_hierarchy($term_id, $tax, $hierarchy = array()){
	$term = get_term($term_id, $tax);
	if(!$term){ return $term; }
	if($term->parent != 0 ){
		$hierarchy[] = $term;
		return get_hierarchy($term->parent, $tax , $hierarchy);
	}
	$hierarchy[] = $term;
	return $hierarchy;
}

function get_list_terms_after_term($term, $tax, $limit = 10){
	global $wpdb;
	$sql = "SELECT
	        $wpdb->terms.term_id, $wpdb->terms.name
	    FROM
	        $wpdb->terms
	    LEFT JOIN
	        $wpdb->term_taxonomy ON
	            $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
	    LEFT JOIN
	        $wpdb->termmeta ON
	            $wpdb->terms.term_id = $wpdb->termmeta.term_id
	    WHERE
	        $wpdb->term_taxonomy.taxonomy = '$tax' 
	        AND
	        $wpdb->terms.term_id < $term->term_id
	        AND
	        $wpdb->termmeta.meta_key = 'class'
	        AND  $wpdb->term_taxonomy.parent = " . ($term->parent ? $term->parent : 0) . "
	    ORDER BY 
	    	$wpdb->term_taxonomy.term_id desc
	    LIMIT 0, $limit
	        ";
	$terms = $wpdb->get_results($sql);
	return $terms;
}

add_shortcode( 'get_location_links', function($atts){
	global $post;
	$taxonomy = 'location';
	$myparent = 0;
	$term_list = false;
	$hierarchy = false;
	$limit = !empty($atts) && isset($atts['count']) && !empty($atts['count']) ? $atts['count'] : 10;
	$myclass = !empty($atts) && isset($atts['class']) && !empty($atts['class']) ? $atts['class'] : '';
	$a_class = !empty($atts) && isset($atts['a_class']) && !empty($atts['a_class']) ? $atts['a_class'] : '';
	$padding_bottom = !empty($atts) && isset($atts['padding-bottom']) && !empty($atts['padding-bottom']) ? intval($atts['padding-bottom']) : 50;
	$show_class = false;
	$centered = false;
	if(!empty($atts) && is_array($atts)){
		foreach ($atts as $key => $att) {
			if($att=='showicon'){
				$show_class = 1;
			}
			if($att=='centered'){
				$centered = 1;
			}
		}
	}

	$country = false;
	if(is_archive()){
		$queried_object = get_queried_object('term');
		if($queried_object){
			$hierarchy = get_hierarchy($queried_object->term_id, $taxonomy);
			if(!empty($hierarchy) && is_array($hierarchy)){
				$hierarchy = array_reverse($hierarchy);
				if($hierarchy && isset($hierarchy[1])){
					$country = $hierarchy[1];
				}else{
					if(isset($hierarchy[0])){
						$country = get_terms(array(
							'taxonomy' => $taxonomy,
							'hide_empty' => false,
							'number' => 1,
							'parent' => $hierarchy[0]->term_id,
						));
						if(!empty($country)){
							$country = $country[0];
						}
					}
				}
			}else{
				$country = get_terms(array(
					'taxonomy' => $taxonomy,
					'hide_empty' => false,
					'number' => 1,
					'parent' => $queried_object->term_id,
					'orderby' => 'id',
					'order' => 'desc',
				));
				if(!empty($country)){
					$country = $country[0];
				}
			}
			if($country){
				$term_list = get_list_terms_after_term($country, $taxonomy, $limit);
				if(!$term_list && $hierarchy && isset($hierarchy[0])){
					$firstcountry = get_terms(array(
						'taxonomy' => $taxonomy,
						'hide_empty' => false,
						'number' => 1,
						'parent' => $hierarchy[0]->term_id,
						'orderby' => 'id',
						'order' => 'desc',
					));
					if(!empty($firstcountry)){
						$firstcountry = $firstcountry[0];
					}
					$term_list = get_list_terms_after_term($firstcountry, $taxonomy, $limit);
				}
				if($term_list && count($term_list)<=$limit && $hierarchy && isset($hierarchy[0])){
					$morecountry = get_terms(array(
						'taxonomy' => $taxonomy,
						'hide_empty' => false,
						'number' => 1,
						'parent' => $hierarchy[0]->term_id,
						'orderby' => 'id',
						'order' => 'desc',
					));
					if(!empty($morecountry)){
						$morecountry = $morecountry[0];
						$term_list_next = get_list_terms_after_term($morecountry, $taxonomy, $limit-count($term_list));
						if($term_list_next){
							$term_list = array_merge($term_list, $term_list_next);
						}
					}
				}
			}
		}
	}
	if($post && is_single()){ 
		$terms_curr = wp_get_post_terms( $post->ID, $taxonomy, array( 'orderby' => 'term_id' ) );
		if(isset($terms_curr[1])){
			$term_list = get_list_terms_after_term( $terms_curr[1], $taxonomy, $limit);
				if($term_list && count($term_list)<=$limit && $terms_curr && isset($terms_curr[0])){
					$morecountry = get_terms(array(
						'taxonomy' => $taxonomy,
						'hide_empty' => false,
						'number' => 1,
						'parent' => $terms_curr[0]->term_id,
						'orderby' => 'id',
						'order' => 'desc',
					));
					if(!empty($morecountry) && !is_wp_error($morecountry)){
						$morecountry = $morecountry[0];
						$term_list_next = get_list_terms_after_term($morecountry, $taxonomy, $limit-count($term_list));
						if($term_list_next){
							$term_list = array_merge($term_list, $term_list_next);
						}
					}
				}
		}
	}


	if(!$term_list){
		$options = get_option( 'themeothersettings_options' );
		if(isset($options['random_countries']) && !empty($options['random_countries']) && is_array($options['random_countries'])){
			$random_c_limit = $limit;
			$opt_rnd_c_count = count($options['random_countries']);
			if($limit>$opt_rnd_c_count){ $random_c_limit = $opt_rnd_c_count; }
			$get_limit_random_countries = array_rand($options['random_countries'], $random_c_limit);
			if($get_limit_random_countries){
				//shuffle($get_limit_random_countries);
				foreach ($get_limit_random_countries as $key => $term_random_index) {
					$term_list[] = get_term($options['random_countries'][$term_random_index], $taxonomy);
				}
			}
		}else{
			$random_primary = get_terms(array(
						'taxonomy' => $taxonomy,
						'hide_empty' => false,
						'number' => 1,
						'parent' => 0,
					));
			if($random_primary && !is_wp_error($random_primary) && isset($random_primary[0])){
				$search_first_child = get_terms(array(
						'taxonomy' => $taxonomy,
						'hide_empty' => false,
						'number' => 1,
						'parent' => $random_primary[0]->term_id,
					));
				if( $search_first_child && !is_wp_error($search_first_child) && isset( $search_first_child[0] ) ){
						$term_list = get_list_terms_after_term( $search_first_child[0], $taxonomy, $limit);
				}
			}
		}
	}

	$result = '';
	$args = array(
	'taxonomy' => $taxonomy,
	'hide_empty' => true,
	'parent' => 0,
	'number' => $limit,
	   'meta_key' => 'class',
	   'orderby' => 'meta_value',
	   'order' => 'DESC',
	);

	$terms = $term_list ? $term_list : get_terms( $args );
	if(!$terms){ return $result; }
	foreach ($terms as $key => $term) {
		$term_id = (int) $term->term_id;
		$link = get_term_link($term_id, 'location');
		
		if($show_class){
			$class = get_term_meta($term_id, 'class', 1);
		}

		$result .= '<a class="' . $a_class . ' ' .($show_class && !empty($class) ? $class : $show_class).'" href="'. $link .'">'.$term->name.'</a>' . '<br/>';
	}

	$result = '<div class="'.$myclass.'" style="padding-bottom: '.$padding_bottom.'px;">' . $result . '</div>';


	if($centered){
		$result = '<div style="margin: 0 auto; text-align: left;width: fit-content;">' . $result . '</center>';
	}

	return $result;
} );


add_shortcode( 'get_current_title', function(){
	return get_the_title();
} );

function get_post_genres_fnc() {
	if(is_archive()){ 
		$term = get_queried_object('term');
		return $term->name;
	}
    global $post;
    $taxonomyTerms = wp_get_post_terms( $post->ID, 'genre', 'orderby=name&hide_empty=0' );
    if(!$taxonomyTerms){ return '';}
    $term_array = array();
    foreach ($taxonomyTerms as $taxonomyTerm) {
        $term_array[] = $taxonomyTerm->name;
    }
    return implode( ', ', $term_array );
}
add_shortcode('get_post_genres', 'get_post_genres_fnc');

add_shortcode( 'get_current_region', function(){
	if(is_archive()){ return ''; }
	global $post;
	if(!$post){ return ''; }
	$taxonomy = 'location'; 
	$terms = wp_get_post_terms( $post->ID, $taxonomy, array( 'orderby' => 'term_id' ) );
	$myparent = false;
	if(!$terms) { return ''; }
	foreach ( $terms as $term )
    {
		if ($term->parent == 0){
			$myparent = $term;
		}
    }
    return $myparent ? $myparent->name : '';
} );

add_shortcode( 'get_random_radio', function($atts){
	$number = !empty($atts) && isset($atts['count']) && !empty($atts['count']) ? $atts['count'] : 10;
    $randomposts = get_posts(array(
        'post_type' => 'radio',
        'numberposts' => $number,
        'orderby' => 'rand'
    ));
    $result = '';
    if($randomposts){
    	foreach ($randomposts as $key => $post) {
    		$thumb_img = get_the_post_thumbnail( $post->ID, 'thumbnail' );
    		$result .= '<a href="'.get_post_permalink( $post->ID).'">'.$thumb_img.'<br/><strong>'.$post->post_title.'</strong></a>';
    	}
    }


    return '<div class="rnd-radio" style="display: flex;flex-wrap: wrap;">' . $result . '</div>';
} );

add_shortcode( 'get_current_country', function(){
	if(is_archive()){ return ''; }
	global $post;
	if(!$post){ return ''; }
	$taxonomy = 'location'; 
	$terms = wp_get_post_terms( $post->ID, $taxonomy, array( 'orderby' => 'term_id' ) );
	$myparent = false;
	if(!$terms) { return ''; }
	foreach ( $terms as $term )
    {
		if ($term->parent == 0){
			$myparent = $term;
		}
    }

    $country = false;
	foreach ( $terms as $term )
    {
		if ($term->parent == $myparent->term_id){
			$country = $term;
		}
    }
    return $country ? $country->name : '';
} );

add_shortcode( 'get_current_oblast', function(){
	if(is_archive()){ return ''; }
	global $post;
	if(!$post){ return ''; }
	$taxonomy = 'location'; 
	$terms = wp_get_post_terms( $post->ID, $taxonomy, array( 'orderby' => 'term_id' ) );
	$myparent = false;
	if(!$terms || count($terms)<=3) { return ''; }
	foreach ( $terms as $term )
    {
		if ($term->parent == 0){
			$myparent = $term;
		}
    }

    $country = false;
	foreach ( $terms as $term )
    {
		if ($term->parent == $myparent->term_id){
			$country = $term;
		}
    }

    $oblast = false;
	foreach ( $terms as $term )
    {
		if ($term->parent == $country->term_id){
			$oblast = $term;
		}
    }
    return $oblast ? $oblast->name : '';
} );

add_shortcode( 'get_current_city', function(){
	if(is_archive()){ return ''; }
	global $post;
	if(!$post){ return ''; }
	$taxonomy = 'location'; 
	$terms = wp_get_post_terms( $post->ID, $taxonomy, array( 'orderby' => 'term_id' ) );
	$city = false; 
	if($terms){
		$city = end($terms);
	}

    return $city ? $city->name : '';
} );

add_shortcode( 'get_taxonoms', function(){

if(!is_archive()){ return ''; }

$result = '';
$delimiter = ' ';

$term = get_queried_object('term');
$parents = get_term_parents_list_cleared($term->term_id, 'location');
$result .= $term->name . $delimiter;
if($parents){
	foreach ($parents as $key => $parent) {
		$pterm = get_term($parent);
		if($pterm && !is_wp_error($parent)){
			$result .= $pterm->name . $delimiter;
		}
	}
}

return $result;

} );
function taxonomy_hierarchy() {
	global $meta_position;
	global $post;
	$post_id = false;
	if($post){
		$post_id = $post->ID;
	}else{
		$post_id = get_queried_object('term')->parent;
		if(!$post_id){
			$post_id = get_queried_object('term')->term_id;
		}
	}
	$current_term_id = get_queried_object('term')->term_id;
	$out = '';
	$taxonomy = 'location'; 
	$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'orderby' => 'term_id' ));
	if(!$terms) { return; }
	foreach ( $terms as $term )
    {
		$out .= '<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
       			<a class="ajax" itemprop="item" itemtype="https://schema.org/Thing" href="' . get_term_link($term->term_id) . '"><span itemprop="name">' . $term->name . '</span></a>
       			<meta property="position" content="'.$meta_position.'"></li>';
       			$meta_position++;
    	if($term->term_id == $current_term_id){
    		break;
    	}
    }
    return  $out;	
}

function get_regions(){
	global $meta_position;
	$terms = get_terms( array( 
    'taxonomy' => 'location',
    'parent'   => 0,
    'hide_empty' => 0,
    'number' => 10,
	) );

	$mainparent_id = false;
	$taxonomy = 'location'; 
	
	if(is_single()){
		global $post;
		$terms_search_mainparent = wp_get_post_terms( $post->ID, $taxonomy );
		if($terms_search_mainparent){ 
			foreach ( $terms_search_mainparent as $term )
		    {
					if ($term->parent == 0){
						$mainparent_id = $term->term_id;
					}
		    }
		}
	}else{
		$parent = get_queried_object('term')->parent;
		if(!$parent){
			$parent = get_queried_object('term')->term_id;
		}
		$mainparent_id = getParentBreadTax_clear($parent);
	}

	$result = '';
	foreach ($terms as $key => $term) {
		if($mainparent_id != $term->term_id){
			$result .= '<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
			       			<a class="ajax" itemprop="item" itemtype="https://schema.org/Thing" href="' . get_term_link($term->term_id) . '"><span itemprop="name">' . $term->name . '</span>
			       			<meta property="position" content="'.$meta_position.'"></a></li>';
			       			$meta_position++;
		}else{
			$result .= '<li>'.$term->name.'</li>';
		}
		
	}
	return $result;
}	
add_filter( 'rank_math/frontend/title', function( $title ) {
	$title = do_shortcode($title);
	return $title;
});

add_filter( 'rank_math/frontend/description', function( $description ) {
    $description = apply_shortcodes( $description );
    return $description;
});

//301 редирект по регулярке
if(preg_match('/\/\?radio=(.*?)/isU', $_SERVER['REQUEST_URI'], $matches))
{
	if($matches && isset($matches[1]) && !empty($matches[1])){

		wp_redirect( home_url() . '/' . $matches[1], 301 );
		exit;
	}
}

function get_term_parents_list_cleared( $term_id, $taxonomy, $args = array() ) {
    $list = '';
    $term = get_term( $term_id, $taxonomy );
 
    if ( is_wp_error( $term ) ) {
        return $term;
    }
 
    if ( ! $term ) {
        return $list;
    }
 
    $term_id = $term->term_id;
 
	$parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
 
    return $parents;
}