<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hendon_child_nitaq_news_register_post_type' ) ) {
	function hendon_child_nitaq_news_register_post_type() {
		register_post_type(
			'nitaq_news',
			array(
				'labels'       => array(
					'name'               => 'الأخبار',
					'singular_name'      => 'خبر',
					'menu_name'          => 'الأخبار',
					'add_new'            => 'إضافة خبر',
					'add_new_item'       => 'إضافة خبر جديد',
					'edit_item'          => 'تعديل الخبر',
					'new_item'           => 'خبر جديد',
					'view_item'          => 'عرض الخبر',
					'search_items'       => 'البحث في الأخبار',
					'not_found'          => 'لا توجد أخبار',
					'featured_image'     => 'صورة الخبر',
					'set_featured_image' => 'تعيين صورة الخبر',
				),
				'public'       => true,
				'has_archive'  => 'news',
				'rewrite'      => array(
					'slug'       => 'news',
					'with_front' => false,
				),
				'menu_icon'    => 'dashicons-megaphone',
				'menu_position'=> 20,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
				'show_in_rest' => true,
			)
		);
	}

add_action( 'init', 'hendon_child_nitaq_news_register_post_type' );
}

if ( ! function_exists( 'hendon_child_nitaq_news_archive_title' ) ) {
	function hendon_child_nitaq_news_archive_title( $title ) {
		if ( is_post_type_archive( 'nitaq_news' ) ) {
			return 'نطاق الأولى للتطوير العقاري';
		}

		return $title;
	}

	add_filter( 'get_the_archive_title', 'hendon_child_nitaq_news_archive_title' );
	add_filter( 'hendon_filter_page_title_text', 'hendon_child_nitaq_news_archive_title' );
}

if ( ! function_exists( 'hendon_child_nitaq_news_add_meta_boxes' ) ) {
	function hendon_child_nitaq_news_add_meta_boxes() {
		add_meta_box(
			'nitaq_news_details',
			'تفاصيل الخبر',
			'hendon_child_nitaq_news_details_meta_box',
			'nitaq_news',
			'normal',
			'high'
		);
	}

	add_action( 'add_meta_boxes', 'hendon_child_nitaq_news_add_meta_boxes' );
}

if ( ! function_exists( 'hendon_child_nitaq_news_details_meta_box' ) ) {
	function hendon_child_nitaq_news_details_meta_box( $post ) {
		wp_nonce_field( 'nitaq_news_details', 'nitaq_news_details_nonce' );

		$date       = get_post_meta( $post->ID, '_nitaq_news_date', true );
		$title_en   = get_post_meta( $post->ID, '_nitaq_news_title_en', true );
		$excerpt_en = get_post_meta( $post->ID, '_nitaq_news_excerpt_en', true );
		$content_en = get_post_meta( $post->ID, '_nitaq_news_content_en', true );
		$link       = get_post_meta( $post->ID, '_nitaq_news_button_link', true );
		?>
		<div class="nitaq-news-admin-fields" dir="rtl">
			<p><strong>طريقة الاستخدام:</strong> اكتب عنوان الخبر بالعربية في خانة العنوان بالأعلى، ومحتوى الخبر بالعربية في المحرر الرئيسي، ثم أضف صورة الخبر من صندوق "صورة الخبر".</p>
			<p>
				<label for="nitaq_news_date"><strong>تاريخ الخبر الظاهر</strong></label><br>
				<input id="nitaq_news_date" name="nitaq_news_date" type="text" value="<?php echo esc_attr( $date ); ?>" placeholder="مثال: مايو 2025" style="width:100%;max-width:420px;">
			</p>
			<p>
				<label for="nitaq_news_button_link"><strong>رابط الزر اختياري</strong></label><br>
				<input id="nitaq_news_button_link" name="nitaq_news_button_link" type="url" value="<?php echo esc_url( $link ); ?>" placeholder="<?php echo esc_url( home_url( '/projects/the-groves/' ) ); ?>" style="width:100%;max-width:720px;direction:ltr;text-align:left;">
			</p>
			<hr>
			<p>
				<label for="nitaq_news_title_en"><strong>English title</strong></label><br>
				<input id="nitaq_news_title_en" name="nitaq_news_title_en" type="text" value="<?php echo esc_attr( $title_en ); ?>" style="width:100%;max-width:720px;direction:ltr;text-align:left;">
			</p>
			<p>
				<label for="nitaq_news_excerpt_en"><strong>English excerpt</strong></label><br>
				<textarea id="nitaq_news_excerpt_en" name="nitaq_news_excerpt_en" rows="3" style="width:100%;max-width:720px;direction:ltr;text-align:left;"><?php echo esc_textarea( $excerpt_en ); ?></textarea>
			</p>
			<p>
				<label for="nitaq_news_content_en"><strong>English content</strong></label><br>
				<textarea id="nitaq_news_content_en" name="nitaq_news_content_en" rows="6" style="width:100%;direction:ltr;text-align:left;"><?php echo esc_textarea( $content_en ); ?></textarea>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hendon_child_nitaq_news_save_meta' ) ) {
	function hendon_child_nitaq_news_save_meta( $post_id ) {
		if ( ! isset( $_POST['nitaq_news_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nitaq_news_details_nonce'] ) ), 'nitaq_news_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = array(
			'_nitaq_news_date'        => 'nitaq_news_date',
			'_nitaq_news_title_en'    => 'nitaq_news_title_en',
			'_nitaq_news_excerpt_en'  => 'nitaq_news_excerpt_en',
			'_nitaq_news_content_en'  => 'nitaq_news_content_en',
			'_nitaq_news_button_link' => 'nitaq_news_button_link',
		);

		foreach ( $fields as $meta_key => $post_key ) {
			$value = isset( $_POST[ $post_key ] ) ? wp_unslash( $_POST[ $post_key ] ) : '';
			$value = '_nitaq_news_button_link' === $meta_key ? esc_url_raw( $value ) : sanitize_textarea_field( $value );
			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	add_action( 'save_post_nitaq_news', 'hendon_child_nitaq_news_save_meta' );
}

if ( ! function_exists( 'hendon_child_nitaq_news_admin_columns' ) ) {
	function hendon_child_nitaq_news_admin_columns( $columns ) {
		$new_columns = array();

		foreach ( $columns as $key => $label ) {
			$new_columns[ $key ] = $label;

			if ( 'title' === $key ) {
				$new_columns['nitaq_news_date'] = 'تاريخ الخبر';
			}
		}

		return $new_columns;
	}

	add_filter( 'manage_nitaq_news_posts_columns', 'hendon_child_nitaq_news_admin_columns' );

	function hendon_child_nitaq_news_admin_column_content( $column, $post_id ) {
		if ( 'nitaq_news_date' === $column ) {
			echo esc_html( hendon_child_nitaq_news_date( $post_id ) );
		}
	}

	add_action( 'manage_nitaq_news_posts_custom_column', 'hendon_child_nitaq_news_admin_column_content', 10, 2 );
}

if ( ! function_exists( 'hendon_child_nitaq_news_date' ) ) {
	function hendon_child_nitaq_news_date( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$date    = get_post_meta( $post_id, '_nitaq_news_date', true );

		return $date ? $date : get_the_date( 'F Y', $post_id );
	}
}

if ( ! function_exists( 'hendon_child_nitaq_news_excerpt' ) ) {
	function hendon_child_nitaq_news_excerpt( $post_id = null, $length = 26 ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$excerpt = get_the_excerpt( $post_id );

		if ( ! $excerpt ) {
			$excerpt = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
		}

		return wp_trim_words( $excerpt, $length, '...' );
	}
}

if ( ! function_exists( 'hendon_child_nitaq_news_card' ) ) {
	function hendon_child_nitaq_news_card( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$link    = get_permalink( $post_id );
		$image   = get_the_post_thumbnail_url( $post_id, 'large' );

		if ( ! $image ) {
			$image = home_url( '/wp-content/uploads/2026/05/theWholeProject.png' );
		}

		ob_start();
		?>
		<article class="nitaq-news-card">
			<a class="nitaq-news-card__image" href="<?php echo esc_url( $link ); ?>" aria-label="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
				<span><?php echo esc_html( hendon_child_nitaq_news_date( $post_id ) ); ?></span>
			</a>
			<div class="nitaq-news-card__content">
				<h3><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
				<p><?php echo esc_html( hendon_child_nitaq_news_excerpt( $post_id ) ); ?></p>
				<a class="nitaq-news-card__button" href="<?php echo esc_url( $link ); ?>">اقرأ المزيد</a>
			</div>
		</article>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_news_latest_shortcode' ) ) {
	function hendon_child_nitaq_news_latest_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'posts' => 3,
			),
			$atts,
			'nitaq_news_latest'
		);

		$query = new WP_Query(
			array(
				'post_type'           => 'nitaq_news',
				'posts_per_page'      => max( 1, (int) $atts['posts'] ),
				'post_status'         => 'publish',
				'orderby'             => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
				'ignore_sticky_posts' => true,
			)
		);

		ob_start();
		?>
		<section class="nitaq-news-section" dir="rtl">
			<div class="nitaq-news-container">
				<div class="nitaq-news-heading">
					<span>الأخبار</span>
					<h2>آخر مستجدات نطاق الأولى</h2>
					<p>تابع أحدث أخبار مشاريعنا، ومراحل التطوير، والشراكات التي تساهم في بناء مجتمعات سكنية أكثر تكاملاً.</p>
				</div>
				<div class="nitaq-news-grid nitaq-news-grid--latest">
					<?php
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) :
							$query->the_post();
							echo hendon_child_nitaq_news_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p class="nitaq-news-empty">سيتم نشر الأخبار قريبًا.</p>
					<?php endif; ?>
				</div>
				<div class="nitaq-news-more">
					<a class="nitaq-news-card__button" href="<?php echo esc_url( home_url( '/news/' ) ); ?>">عرض جميع الأخبار</a>
				</div>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}

	add_shortcode( 'nitaq_news_latest', 'hendon_child_nitaq_news_latest_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_news_archive_order' ) ) {
	function hendon_child_nitaq_news_archive_order( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'nitaq_news' ) ) {
			return;
		}

		$query->set(
			'orderby',
			array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			)
		);
	}

	add_action( 'pre_get_posts', 'hendon_child_nitaq_news_archive_order' );
}
