<?php

if ( ! function_exists( 'kossy_category' ) ) {
	function kossy_category( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<span class="category "> ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . '</a>';
			} else {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . '</a>';
			}
		}
		echo '</span>';
	}
}

if ( ! function_exists( 'kossy_center_meta' ) ) {
	function kossy_center_meta( $post ) {
		// format
		$post_format = get_post_format();
		$id = get_the_author_meta( 'ID' );
		echo '<div class="entry-meta">';
		if(!is_single()){
			the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
		} else {
			the_title( '<h4 class="entry-title">', '</h4>' );
		}
			echo "<div class='entry-create'>";
			echo "<span class='entry-date'>". get_the_date( 'M jS, Y' ).'</span>';
			echo "<span class='author'>".esc_html__( ' / By: ', 'kossy' ).'<a href='.esc_url(get_author_posts_url( $id )).'>'.get_the_author().'</a>' .'</span>';
			echo '</div>';
		echo '</div>';
	}
}



if ( ! function_exists( 'kossy_full_top_meta' ) ) {
	function kossy_full_top_meta( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<header class="entry-create ' . $header_class . '">';
		if(!is_single()){
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		// details
		$id = get_the_author_meta( 'ID' );
		echo '<span class="entry-date">' . esc_html( get_the_date( 'M jS, Y' ) ) . '</span><span class="entry-profile">
			
			
			<span class="entry-author-link">
				' . esc_html__( 'by:', 'kossy' ) . '
				<span class="author vcard">
				<a class="url fn n" href="' . esc_url(get_author_posts_url( $id )) . '" rel="author">' . get_the_author() . '</a>
				</span>
			</span>
			
		</span>';
		// comments
		echo '<span class="entry-categories">in: ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . '</a>';
			} else {
				echo '<a href="' . get_category_link( $categories->term_id ) . '" class="categories-name">' . $categories->name . ', </a>';
			}
		}
		echo '</span>';

		if ( ! is_search() ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-comments-link">';
				comments_popup_link( esc_html__( '0 comments', 'kossy' ), esc_html__( '1 comment' , 'kossy' ), esc_html__( '% comments', 'kossy' ) );
				echo '</span>';
			}
		}
		echo '</header>';
	}
}

if ( ! function_exists( 'kossy_post_tags' ) ) {
	function kossy_post_tags() {
		$posttags = get_the_tags();
		if ( $posttags ) {
			echo '<span class="entry-tags-list"><strong>'.esc_html__( 'Tags: ' , 'kossy' ).'</strong> ';
			$i = 1;
			$size = count( $posttags );
			foreach ( $posttags as $tag ) {
				echo '<a href="' . get_tag_link( $tag->term_id ) . '">';
				echo esc_attr($tag->name);
				echo '</a>';
				$i ++;
			}
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'kossy_post_format_link_helper' ) ) {
	function kossy_post_format_link_helper( $content = null, $title = null, $post = null ) {
		if ( ! $content ) {
			$post = get_post( $post );
			$title = $post->post_title;
			$content = $post->post_content;
		}
		$link = kossy_get_first_url_from_string( $content );
		if ( ! empty( $link ) ) {
			$title = '<a href="' . esc_url( $link ) . '" rel="bookmark">' . $title . '</a>';
			$content = str_replace( $link, '', $content );
		} else {
			$pattern = '/^\<a[^>](.*?)>(.*?)<\/a>/i';
			preg_match( $pattern, $content, $link );
			if ( ! empty( $link[0] ) && ! empty( $link[2] ) ) {
				$title = $link[0];
				$content = str_replace( $link[0], '', $content );
			} elseif ( ! empty( $link[0] ) && ! empty( $link[1] ) ) {
				$atts = shortcode_parse_atts( $link[1] );
				$target = ( ! empty( $atts['target'] ) ) ? $atts['target'] : '_self';
				$title = ( ! empty( $atts['title'] ) ) ? $atts['title'] : $title;
				$title = '<a href="' . esc_url( $atts['href'] ) . '" rel="bookmark" target="' . $target . '">' . $title . '</a>';
				$content = str_replace( $link[0], '', $content );
			} else {
				$title = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>';
			}
		}
		$out['title'] = '<h2 class="entry-title">' . $title . '</h2>';
		$out['content'] = $content;

		return $out;
	}
}

if ( !function_exists('kossy_get_page_title') ) {
	function kossy_get_page_title() {
		$title = '';
		if ( !is_front_page() || is_paged() ) {
			global $post;
			$homeLink = esc_url( home_url('/') );

			if ( is_home() ) {
				$title = esc_html__( 'The Blogs', 'kossy' );
			} elseif (is_category()) {
				$title = esc_html__( 'The Blogs', 'kossy' );
			} elseif (is_day()) {
				$title = get_the_time('d');
			} elseif (is_month()) {
				$title = get_the_time('F');
			} elseif (is_year()) {
				$title = get_the_time('Y');
			} elseif (is_single() && !is_attachment()) {
				if ( get_post_type() != 'post' ) {
					$title = get_the_title();
				} else {
					$title = esc_html__( 'Blog', 'kossy' );
				}
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_author() && !is_search() ) {
				$post_type = get_post_type_object(get_post_type());
				if (is_object($post_type)) {
					$title = $post_type->labels->singular_name;
				}
			} elseif (is_attachment()) {
				$title = get_the_title();
			} elseif ( is_page() && !$post->post_parent ) {
				$title = get_the_title();
			} elseif ( is_page() && $post->post_parent ) {
				$title = get_the_title();
			} elseif ( is_search() ) {
				$title = esc_html__('Search results for "','kossy')  . get_search_query();
			} elseif ( is_tag() ) {
				$title = esc_html__('Posts tagged "', 'kossy'). single_tag_title('', false) . '"';
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				$title = $userdata->display_name;
			} elseif ( is_404() ) {
				$title = esc_html__('Error 404', 'kossy');
			}
		}else{
			$title = get_the_title();
		}
		return $title;
	}
}

if ( ! function_exists( 'kossy_breadcrumbs' ) ) {
	function kossy_breadcrumbs() {

		$delimiter = ' ';
		$home = esc_html__('Home', 'kossy');
		$before = '<li><span class="active">';
		$after = '</span></li>';
		if ( !is_front_page() || is_paged()) {
			global $post;
			$homeLink = esc_url( home_url('/') );
			
			echo '<div class="breadscrumb-inner">';
			echo '<ol class="breadcrumb">';


			echo '<li><a href="' . esc_url($homeLink) . '">' . $home . '</a> ' . $delimiter . '</li> ';

			if (is_category()) {
				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category($thisCat);
				$parentCat = get_category($thisCat->parent);
				echo '<li>';
				if ($thisCat->parent != 0)
					echo get_category_parents($parentCat, TRUE, '</li><li>');
				echo '<span class="active">'.single_cat_title('', false) . $after;
			} elseif (is_day()) {
				echo '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
				echo '<li><a href="' . esc_url( get_month_link(get_the_time('Y'),get_the_time('m')) ) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
				echo trim($before) . get_the_time('d') . $after;
			} elseif (is_month()) {
				echo '<a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
				echo trim($before) . get_the_time('F') . $after;
			} elseif (is_year()) {
				echo trim($before) . get_the_time('Y') . $after;
			} elseif (is_single() && !is_attachment()) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					
					echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
					echo trim($before) . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					echo '<li>'.get_category_parents($cat, TRUE, '</li><li>');
					echo '<span class="active">'.get_the_title() . $after;
				}
			} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_author() && !is_search()) {
				$post_type = get_post_type_object(get_post_type());
				if (is_object($post_type)) {
					echo trim($before) . $post_type->labels->singular_name . $after;
				}
			} elseif (is_attachment()) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				echo '<li>';
				if ( !empty($cat) ) {
					$cat = $cat[0];
					echo get_category_parents($cat, TRUE, '</li><li>');
				}
				if ( !empty($parent) ) {
					echo '<a href="' . esc_url( get_permalink($parent) ) . '">' . $parent->post_title . '</a></li><li>';
				}
				echo '<span class="active">'.get_the_title() . $after;
			} elseif ( is_page() && !$post->post_parent ) {
				echo trim($before) . get_the_title() . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a></li>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) {
					echo trim($crumb) . ' ' . $delimiter . ' ';
				}
				echo trim($before) . get_the_title() . $after;
			} elseif ( is_search() ) {
				echo trim($before) . sprintf(__('Search results for "%s"','kossy'), get_search_query()) . $after;
			} elseif ( is_tag() ) {
				echo trim($before) . sprintf(__('Posts tagged "%s"', 'kossy'), single_tag_title('', false)) . $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo trim($before) . esc_html__('Articles posted by ', 'kossy') . $userdata->display_name . $after;
			} elseif ( is_404() ) {
				echo trim($before) . esc_html__('Error 404', 'kossy') . $after;
			} elseif ( is_home() ) {
				echo trim($before) . esc_html__('The Blogs', 'kossy') . $after;
			}

			echo '</ol>';
			echo '</div>';
			
		}
	}
}

if ( ! function_exists( 'kossy_render_breadcrumbs' ) ) {
	function kossy_render_breadcrumbs() {
		global $post;
		$has_bg = '';
		$show = true;
		$style = array();
		$full_width = 'container';
		if ( is_page() && is_object($post) ) {
			$show = get_post_meta( $post->ID, 'apus_page_show_breadcrumb', true );
			if ( $show == 'no' ) {
				return ''; 
			}
			$bgimage = get_post_meta( $post->ID, 'apus_page_breadcrumb_image', true );
			$bgcolor = get_post_meta( $post->ID, 'apus_page_breadcrumb_color', true );
			$style = array();
			if ( $bgcolor ) {
				$style[] = 'background-color:'.$bgcolor;
			}
			if ( $bgimage ) { 
				$style[] = 'background-image:url(\''.esc_url($bgimage).'\')';
				$has_bg = 1;
			}
			$full_width = apply_filters('kossy_page_content_class', 'container');
		} elseif ( is_singular('post') || is_category() || is_home() || is_search() ) {
			$show = kossy_get_config('show_blog_breadcrumbs', true);
			if ( !$show || is_front_page() ) {
				return ''; 
			}
			$breadcrumb_img = kossy_get_config('blog_breadcrumb_image');
	        $breadcrumb_color = kossy_get_config('blog_breadcrumb_color');
	        $style = array();
	        if ( $breadcrumb_color ) {
	            $style[] = 'background-color:'.$breadcrumb_color;
	        }
	        if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) ) {
	            $style[] = 'background-image:url(\''.esc_url($breadcrumb_img['url']).'\')';
	            $has_bg = 1;
	        }
	        $full_width = apply_filters('kossy_blog_content_class', 'container');
		}
		$estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";
		($has_bg) ? $has_bg = 'has_bg' :'';
		echo '<section id="apus-breadscrumb" class="breadcrumb-page apus-breadscrumb '.$has_bg.'"'.$estyle.'><div class="'.$full_width.'"><div class="wrapper-breads '.$has_bg.' "><div class="wrapper-breads-inner">';
			if(kossy_get_page_title()){
				echo '<h3 class="bread-title">'.kossy_get_page_title().'</h3>';
			}
			kossy_breadcrumbs();
		echo '</div></div></div></section>';
	}
}

if ( !function_exists( 'kossy_print_style_footer' ) ) {
	function kossy_print_style_footer() {
    	$footer = kossy_get_footer_layout();
    	if ( $footer ) {
    		$args = array(
				'name'        => $footer,
				'post_type'   => 'apus_footer',
				'post_status' => 'publish',
				'numberposts' => 1
			);
			$posts = get_posts($args);
			foreach ( $posts as $post ) {
	      		return get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
	 	 	}
    	}
    	return '';
	}
}

if ( ! function_exists( 'kossy_paging_nav' ) ) {
	function kossy_paging_nav() {
		global $wp_query, $wp_rewrite;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => esc_html__( '< Prev', 'kossy' ),
			'next_text' => esc_html__( 'Next >', 'kossy' ),
		) );

		if ( $links ) :

		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text hidden"><?php esc_html_e( 'Posts navigation', 'kossy' ); ?></h1>
			<div class="apus-pagination">
				<?php echo trim($links); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
		endif;
	}
}

if ( ! function_exists( 'kossy_post_nav' ) ) {
	function kossy_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		?>
		<nav class="navigation post-navigation" role="navigation">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'kossy' ); ?></h3>
			<div class="nav-links clearfix">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link','<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'kossy').'</span></div>');
				else :
					previous_post_link( '%link','<div class="pull-left"><span class="meta-nav">'. esc_html__('Previous Post', 'kossy').'</span></div>' );
					next_post_link( '%link', '<div class="pull-right"><span class="meta-nav">' . esc_html__('Next Post', 'kossy').'</span><span></span></div>');
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

if ( !function_exists('kossy_pagination') ) {
    function kossy_pagination($per_page, $total, $max_num_pages = '') {
    	global $wp_query, $wp_rewrite;
        ?>
        <div class="apus-pagination">
        	<?php
        	$prev = esc_html__('< Prev','kossy');
        	$next = esc_html__('Next >','kossy');
        	$pages = $max_num_pages;
        	$args = array('class'=>'');

        	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	        if ( empty($pages) ) {
	            global $wp_query;
	            $pages = $wp_query->max_num_pages;
	            if ( !$pages ) {
	                $pages = 1;
	            }
	        }
	        $pagination = array(
	            'base' => @add_query_arg('paged','%#%'),
	            'format' => '',
	            'total' => $pages,
	            'current' => $current,
	            'prev_text' => $prev,
	            'next_text' => $next,
	            'type' => 'array'
	        );

	        if( $wp_rewrite->using_permalinks() ) {
	            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	        }
	        
	        if ( isset($_GET['s']) ) {
	            $cq = $_GET['s'];
	            $sq = str_replace(" ", "+", $cq);
	        }
	        
	        if ( !empty($wp_query->query_vars['s']) ) {
	            $pagination['add_args'] = array( 's' => $sq);
	        }
	        $paginations = paginate_links( $pagination );
	        if ( !empty($paginations) ) {
	            echo '<ul class="pagination '.esc_attr( $args["class"] ).'">';
	                foreach ($paginations as $key => $pg) {
	                    echo '<li>'. $pg .'</li>';
	                }
	            echo '</ul>';
	        }
        	?>
            
        </div>
    <?php
    }
}

if ( !function_exists('kossy_comment_form') ) {
	function kossy_comment_form($arg, $class = 'btn-primary') {
		global $post;
		if ('open' == $post->comment_status) {
			ob_start();
	      	comment_form($arg);
	      	$form = ob_get_clean();
	      	?>
	      	<div class="commentform row reset-button-default">
		    	<div class="col-sm-12">
			    	<?php
			      	echo str_replace('id="submit"','id="submit" class="btn '.$class.'"', $form);
			      	?>
		      	</div>
	      	</div>
	      	<?php
	      }
	}
}

if (!function_exists('kossy_list_comment') ) {
	function kossy_list_comment($comment, $args, $depth) {
		if ( is_file(get_template_directory().'/list-comments.php') ) {
	        require get_template_directory().'/list-comments.php';
      	}
	}
}

function kossy_display_footer_builder($footer) {
	$show_footer_desktop_mobile = kossy_get_config('show_footer_desktop_mobile', false);
	global $footer_builder;
	$footer_builder = true;
	$args = array(
		'name'        => $footer,
		'post_type'   => 'apus_footer',
		'post_status' => 'publish',
		'numberposts' => 1
	);
	$posts = get_posts($args);
	foreach ( $posts as $post ) {
		$class = get_post_meta( $post->ID, 'apus_footer_style_class', true );
		$class .= ' '.get_post_meta( $post->ID, 'apus_footer_background_class', true );
		echo '<div id="apus-footer" class="apus-footer footer-builder-wrapper '.esc_attr(!$show_footer_desktop_mobile ? 'hidden-xs hidden-sm ' : ''). esc_attr($class) . ' ' . $post->post_name .'">';
		echo '<div class="apus-footer-inner">';
		echo do_shortcode( $post->post_content );
		echo '</div>';
		echo '</div>';
	}
	$footer_builder = false;
}

function kossy_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'kossy_comment_field_to_bottom' );


/*
 * create placeholder
 * var size: array( width, height )
 */
function kossy_create_placeholder($size) {
	return "data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' viewBox%3D'0 0 ".$size[0]." ".$size[1]."'%2F%3E";
}


function kossy_display_sidebar_left( $sidebar_configs ) {
	if ( isset($sidebar_configs['left']) ) : ?>
		<div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
		  	<aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		  		<div class="close-sidebar-btn hidden-lg hidden-md"> <i class="fa fa-close"></i> <span><?php esc_html_e('Close', 'kossy'); ?></span></div>
		   		<?php if ( is_active_sidebar( $sidebar_configs['left']['sidebar'] ) ): ?>
		   			<?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
		   		<?php endif; ?>
		  	</aside>
		</div>
	<?php endif;
}

function kossy_display_sidebar_right( $sidebar_configs ) {
	if ( isset($sidebar_configs['right']) ) : ?>
		<div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
		  	<aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		  		<div class="close-sidebar-btn hidden-lg hidden-md"><i class="fa fa-close"></i> <span><?php esc_html_e('Close', 'kossy'); ?></span></div>
		   		<?php if ( is_active_sidebar( $sidebar_configs['right']['sidebar'] ) ): ?>
			   		<?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
			   	<?php endif; ?>
		  	</aside>
		</div>
	<?php endif;
}

function kossy_before_content( $sidebar_configs ) {
	if ( isset($sidebar_configs['left']) || isset($sidebar_configs['right']) ) : ?>
		<a href="javascript:void(0)" class="mobile-sidebar-btn hidden-lg hidden-md"> <i class="fa fa-hand-o-right" aria-hidden="true"></i> <?php echo esc_html__('Show Sidebar', 'kossy'); ?></a>
		<div class="mobile-sidebar-panel-overlay"></div>
	<?php endif;
}

function kossy_login_register() {
	if ( kossy_get_config('show_login_register', true) ) {
	?>
		<div class="pull-right">
			<?php if( is_user_logged_in() && has_nav_menu( 'top-menu' ) ){ ?>
		        <div class="top-wrapper-menu">
		            <a class="drop-dow"><i class="ti-user"></i></a>
		            <?php if ( has_nav_menu( 'top-menu' ) ) {
		                    $args = array(
		                        'theme_location' => 'top-menu',
		                        'container_class' => 'inner-top-menu',
		                        'menu_class' => 'nav navbar-nav topmenu-menu',
		                        'fallback_cb' => '',
		                        'menu_id' => '',
		                        'walker' => new Kossy_Nav_Menu()
		                    );
		                    wp_nav_menu($args);
		                }
		            ?>
		        </div>
		    <?php } elseif(!is_user_logged_in()) { ?>
		        <div class="top-wrapper-menu">
		            <a class="drop-dow"><i class="icon_lock_alt"></i></a>
		            <div class="inner-top-menu">
		                <ul class="nav navbar-nav topmenu-menu">
		                    <li><a class="login register-login-action" data-action="#customer_login" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Sign in','kossy'); ?>"><?php esc_html_e('Login', 'kossy'); ?></a></li>
		                    <li><a class="register register-login-action" data-action="#customer_register" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Register','kossy'); ?>"><?php esc_html_e('Register', 'kossy'); ?></a></li>
		                </ul>
		            </div>
		        </div>
		    <?php } ?>
	    </div>
    <?php
	}
}