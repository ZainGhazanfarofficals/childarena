<?php
/**
 * Custom template tags for Kossy
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Kossy
 * @since Kossy 1.0
 */

if ( ! function_exists( 'kossy_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Kossy 1.0
 */
function kossy_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'kossy' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'kossy' ) ) ) :
					printf( '<div class="nav-previous"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> %s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'kossy' ) ) ) :
					printf( '<div class="nav-next">%s <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'kossy_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Kossy 1.0
 */
function kossy_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'kossy' ) );
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'kossy' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'kossy' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( 'post' == get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'kossy' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'kossy' ) );
		if ( $categories_list && kossy_categorized_blog() ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'kossy' ),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'kossy' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'kossy' ),
				$tags_list
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'kossy' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( esc_html__( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'kossy' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since Kossy 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function kossy_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'kossy_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'kossy_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so kossy_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so kossy_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in {@see kossy_categorized_blog()}.
 *
 * @since Kossy 1.0
 */
function kossy_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'kossy_categories' );
}
add_action( 'edit_category', 'kossy_category_transient_flusher' );
add_action( 'save_post',     'kossy_category_transient_flusher' );

if ( ! function_exists( 'kossy_post_thumbnail' ) ) {
	function kossy_post_thumbnail($thumbsize = '', $link = '') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		global $post;
		$link = empty( $link ) ? get_permalink() : $link;
		$html = '';
		if ( is_singular('post') && is_single($post) ) {
			$html .= '<div class="post-thumbnail">';
			$product_thumbnail_id = get_post_thumbnail_id();
			$html .= kossy_get_attachment_thumbnail($product_thumbnail_id, 'full');
			$html .= '</div>';

		} else {
			$html .= '<figure class="entry-thumb">';
				$html .= '<a class="post-thumbnail" href="'.esc_url($link).'" aria-hidden="true">';
						if ( function_exists('wpb_getImageBySize') && !empty($thumbsize) && !in_array($thumbsize, array('thumbnail', 'medium', 'large', 'full')) ) {
							$post_thumbnail = wpb_getImageBySize( array( 'post_id' => get_the_ID(), 'thumb_size' => $thumbsize ) );
							$html .= trim($post_thumbnail['thumbnail']);
						} else {
							$product_thumbnail_id = get_post_thumbnail_id();
							$html .= kossy_get_attachment_thumbnail($product_thumbnail_id, $thumbsize);
						}
				$html .= '</a>';
				
			$html .= '</figure>';
		} // End is_singular()

		return $html;
	}
}

if ( ! function_exists( 'kossy_post_categories' ) ) {
	function kossy_post_categories( $post ) {
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
	}
}

if ( ! function_exists( 'kossy_short_top_meta' ) ) {
	function kossy_short_top_meta( $post ) {
		
		?>
		<span class="entry-date"><?php the_time( 'M d, Y' ); ?></span>
        <span class="author"><?php esc_html_e('/ By: ', 'kossy'); the_author_posts_link(); ?></span>
		<?php
	}
}

if ( ! function_exists( 'kossy_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Kossy 1.0
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function kossy_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'kossy_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since Kossy 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function kossy_excerpt_more( $more ) {
	$link = sprintf( '<br /><a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( 'Continue reading %s', 'kossy' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'kossy_excerpt_more' );
endif;

if ( ! function_exists( 'kossy_display_post_thumb' ) ) {
	function kossy_display_post_thumb($thumbsize) {
		$post_format = get_post_format();
		$output = '';
		if ($post_format == 'gallery') {
	        $output = kossy_post_gallery( get_the_content() );
	    } elseif ($post_format == 'audio' || $post_format == 'video') {
	        $media = kossy_post_media( get_the_content() );
	        if ($media) {
	            $output = $media;
	        } elseif ( has_post_thumbnail() ) {
	            $output = kossy_post_thumbnail($thumbsize);
	        }
	    } else {
	        if ( has_post_thumbnail() ) {
	            if ($post_format == 'link') {
	                $format = kossy_post_format_link_helper( get_the_content(), get_the_title() );
	                $title = $format['title'];
	                $link = kossy_get_link_attributes( $title );

	                $output = kossy_post_thumbnail($thumbsize, $link);
	            } else {
	                $output = kossy_post_thumbnail($thumbsize);
	            }
	        }
	    }
	    return $output;
	}
}

function kossy_get_attachment_thumbnail($attachment_id, $size = 'thumbnail', $icon = false, $attr = '', $wrapper = true) {
	$html = '';
	$image = wp_get_attachment_image_src($attachment_id, $size, $icon);
	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		$size_class = $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$attachment = get_post($attachment_id);

		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size_class size-$size_class",
			'alt'	=> trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
		);

		$attr = wp_parse_args( $attr, $default_attr );
		
		// Generate 'srcset' and 'sizes' if not already present.
		if ( kossy_get_config('image_lazy_loading') ) {
			$src_layzy = kossy_create_placeholder(array($width, $height));
			$attr['data-src'] = $src;
			$attr['src'] = $src_layzy;
			$attr['class'] .= ' unveil-image';

			if ( empty( $attr['data-srcset'] ) ) {
				$image_meta = wp_get_attachment_metadata( $attachment_id );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset = '';
					if ( function_exists('apus_framework_image_srcset') ) {
						$srcset = apus_framework_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					}
					$sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

					if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
						$attr['data-srcset'] = $srcset;

						if ( empty( $attr['data-sizes'] ) ) {
							$attr['data-sizes'] = $sizes;
						}
					}
				}
			} 
			if ( !empty($attr['srcset'])) {
				unset($attr['srcset']);
			}
			if ( !empty($attr['sizes'])) {
				unset($attr['sizes']);
			}
		} else {
			if ( empty( $attr['srcset'] ) ) {
				$image_meta = wp_get_attachment_metadata( $attachment_id );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset = '';
					if ( function_exists('apus_framework_image_srcset') ) {
						$srcset = apus_framework_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					}
					$sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

					if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
						$attr['srcset'] = $srcset;

						if ( empty( $attr['sizes'] ) ) {
							$attr['sizes'] = $sizes;
						}
					}
				}
			} 
		}

		if ( $wrapper ) {
			$html .= '<div class="image-wrapper">';
		}
		/**
		 * Filters the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param array        $attr       Attributes for the image markup.
		 * @param WP_Post      $attachment Image attachment post.
		 * @param string|array $size       Requested size. Image size or array of width and height values
		 *                                 (in that order). Default 'thumbnail'.
		 */
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
		$attr = array_map( 'esc_attr', $attr );
		$html .= rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';

		if ( $wrapper ) {
			$html .= '</div>';
		}
	}

	return $html;
}