<?php

require_once get_stylesheet_directory() . '/inc/nitaq-news.php';

if ( ! function_exists( 'hendon_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function hendon_child_theme_enqueue_scripts() {
		$main_style = 'hendon-main';
		
		wp_enqueue_style( 'hendon-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ), wp_get_theme()->get( 'Version' ) . '.stats-section-1' );
	}
	
	add_action( 'wp_enqueue_scripts', 'hendon_child_theme_enqueue_scripts' );
}

if ( ! function_exists( 'hendon_child_register_nitaq_hero_slide_post_type' ) ) {
	/**
	 * Register a lightweight admin-managed hero slide post type.
	 */
	function hendon_child_register_nitaq_hero_slide_post_type() {
		register_post_type(
			'nitaq_hero_slide',
			array(
				'labels'        => array(
					'name'               => 'شرائح الواجهة',
					'singular_name'      => 'شريحة واجهة',
					'menu_name'          => 'شرائح الواجهة',
					'add_new'            => 'إضافة شريحة',
					'add_new_item'       => 'إضافة شريحة واجهة',
					'edit_item'          => 'تعديل شريحة الواجهة',
					'new_item'           => 'شريحة واجهة جديدة',
					'view_item'          => 'عرض الشريحة',
					'search_items'       => 'البحث في شرائح الواجهة',
					'not_found'          => 'لا توجد شرائح واجهة',
					'not_found_in_trash' => 'لا توجد شرائح في سلة المهملات',
					'all_items'          => 'كل شرائح الواجهة',
				),
				'description'   => 'Hero Slides',
				'public'        => false,
				'show_ui'       => true,
				'show_in_menu'  => true,
				'menu_icon'     => 'dashicons-slides',
				'menu_position' => 22,
				'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
				'hierarchical'  => false,
				'has_archive'   => false,
				'rewrite'       => false,
				'query_var'     => false,
				'capability_type' => 'post',
			)
		);
	}

	add_action( 'init', 'hendon_child_register_nitaq_hero_slide_post_type' );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_slide_defaults' ) ) {
	/**
	 * Default slide values used as fallback and starter content.
	 */
	function hendon_child_nitaq_hero_slide_defaults() {
		return array(
			'hero_title'           => 'نطوّر مجتمعات سكنية تنبض بالحياة',
			'hero_subtitle'        => 'وجهات سكنية عصرية تجمع بين الفخامة، جودة الحياة، والتخطيط المتكامل في قلب الخبر.',
			'hero_kicker'          => 'شركة نطاق الأولى للتطوير العقاري',
			'hero_button_text'     => 'سجل اهتمامك',
			'hero_button_link'     => '/register-interest/',
			'hero_video_webm'      => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/the-groves-20260514-185802.webm',
			'hero_video_mp4'       => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/the-groves-20260514-185802.mp4',
			'hero_poster_image'    => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/higher-resolution.png',
			'hero_slide_order'     => 1,
			'hero_is_active'       => '1',
			'hero_overlay_opacity' => '0.24',
		);
	}
}

if ( ! function_exists( 'hendon_child_create_default_nitaq_hero_slide' ) ) {
	/**
	 * Seed one editable starter hero slide the first time the site runs this code.
	 */
	function hendon_child_create_default_nitaq_hero_slide() {
		if ( get_option( 'nitaq_hero_slide_starter_created' ) ) {
			return;
		}

		$existing = get_posts(
			array(
				'post_type'      => 'nitaq_hero_slide',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $existing ) {
			update_option( 'nitaq_hero_slide_starter_created', 1, false );
			return;
		}

		$defaults = hendon_child_nitaq_hero_slide_defaults();
		$post_id  = wp_insert_post(
			array(
				'post_type'    => 'nitaq_hero_slide',
				'post_status'  => 'publish',
				'post_title'   => $defaults['hero_title'],
				'menu_order'   => 1,
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			return;
		}

		foreach ( $defaults as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		$poster_id = attachment_url_to_postid( $defaults['hero_poster_image'] );
		if ( $poster_id ) {
			set_post_thumbnail( $post_id, $poster_id );
		}

		update_option( 'nitaq_hero_slide_starter_created', 1, false );
	}

	add_action( 'init', 'hendon_child_create_default_nitaq_hero_slide', 12 );
}

if ( ! function_exists( 'hendon_child_update_nitaq_groves_hero_slide' ) ) {
	/**
	 * Keep the first homepage hero slide on the approved The Groves assets.
	 */
	function hendon_child_update_nitaq_groves_hero_slide() {
		if ( '20260514-groves-video-polished' === get_option( 'nitaq_hero_slide_assets_version' ) ) {
			return;
		}

		$defaults = hendon_child_nitaq_hero_slide_defaults();
		$slides   = get_posts(
			array(
				'post_type'      => 'nitaq_hero_slide',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'ASC',
				),
				'order'          => 'ASC',
			)
		);

		if ( empty( $slides ) ) {
			update_option( 'nitaq_hero_slide_assets_version', '20260514-groves-video-polished', false );
			return;
		}

		foreach ( $slides as $index => $slide ) {
			if ( 0 === $index ) {
				wp_update_post(
					array(
						'ID'         => $slide->ID,
						'post_title' => $defaults['hero_title'],
						'menu_order' => 1,
					)
				);

				foreach ( $defaults as $key => $value ) {
					update_post_meta( $slide->ID, $key, $value );
				}

				$poster_id = attachment_url_to_postid( $defaults['hero_poster_image'] );
				if ( $poster_id ) {
					set_post_thumbnail( $slide->ID, $poster_id );
				}
			} else {
				update_post_meta( $slide->ID, 'hero_is_active', '0' );
			}
		}

		update_option( 'nitaq_hero_slide_assets_version', '20260514-groves-video-polished', false );
	}

	add_action( 'init', 'hendon_child_update_nitaq_groves_hero_slide', 13 );
}

if ( ! function_exists( 'hendon_child_required_nitaq_hero_slides' ) ) {
	/**
	 * Required homepage text slides over the single shared hero video.
	 */
	function hendon_child_required_nitaq_hero_slides() {
		$global_video = array(
			'hero_video_webm'      => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/the-groves-20260514-185802.webm',
			'hero_video_mp4'       => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/the-groves-20260514-185802.mp4',
			'hero_poster_image'    => 'http://nitaq-hendon.local/wp-content/uploads/2026/05/higher-resolution.png',
			'hero_overlay_opacity' => '0.24',
			'hero_is_active'       => '1',
		);

		return array(
			array_merge(
				$global_video,
				array(
					'hero_title'       => 'نطوّر مجتمعات سكنية تنبض بالحياة',
					'hero_kicker'      => 'شركة نطاق الأولى للتطوير العقاري',
					'hero_subtitle'    => 'وجهات سكنية عصرية تجمع بين الفخامة، جودة الحياة، والتخطيط المتكامل في قلب الخبر.',
					'hero_button_text' => 'سجل اهتمامك',
					'hero_button_link' => '/register-interest/',
					'hero_slide_order' => 1,
				)
			),
			array_merge(
				$global_video,
				array(
					'hero_title'       => 'ذا جروفز… تجربة سكنية تحاكي روح الخبر',
					'hero_kicker'      => 'مشروع ذا جروفز',
					'hero_subtitle'    => 'مجتمع سكني عصري ضمن وجهة لازورد، يجمع بين الخصوصية، المساحات الخضراء، وسهولة الوصول إلى أهم معالم المدينة.',
					'hero_button_text' => 'اكتشف المشروع',
					'hero_button_link' => '/projects/',
					'hero_slide_order' => 2,
				)
			),
			array_merge(
				$global_video,
				array(
					'hero_title'       => 'لازورد… وجهة تعيد تعريف جودة الحياة',
					'hero_kicker'      => 'وجهة لازورد في الخبر',
					'hero_subtitle'    => 'موقع استراتيجي بالقرب من البحر، ومرافق متكاملة، ومساحات مفتوحة تمنح السكان أسلوب حياة أكثر توازنًا ورفاهية.',
					'hero_button_text' => 'تحميل البروشورات',
					'hero_button_link' => '/brochures/',
					'hero_slide_order' => 3,
				)
			),
		);
	}
}

if ( ! function_exists( 'hendon_child_seed_required_nitaq_hero_slides' ) ) {
	/**
	 * Create/update the three approved hero text slides without duplicating them.
	 */
	function hendon_child_seed_required_nitaq_hero_slides() {
		if ( '20260514-three-text-slides' === get_option( 'nitaq_required_hero_slides_version' ) ) {
			return;
		}

		$required_slides = hendon_child_required_nitaq_hero_slides();
		$required_titles = wp_list_pluck( $required_slides, 'hero_title' );
		$kept_ids        = array();

		foreach ( $required_slides as $slide ) {
			$matches = get_posts(
				array(
					'post_type'      => 'nitaq_hero_slide',
					'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
					'title'          => $slide['hero_title'],
					'posts_per_page' => -1,
					'orderby'        => 'ID',
					'order'          => 'ASC',
				)
			);

			$post_id = ! empty( $matches ) ? (int) $matches[0]->ID : 0;

			if ( ! $post_id ) {
				$post_id = wp_insert_post(
					array(
						'post_type'   => 'nitaq_hero_slide',
						'post_status' => 'publish',
						'post_title'  => $slide['hero_title'],
						'menu_order'  => (int) $slide['hero_slide_order'],
					)
				);
			} else {
				wp_update_post(
					array(
						'ID'          => $post_id,
						'post_status' => 'publish',
						'post_title'  => $slide['hero_title'],
						'menu_order'  => (int) $slide['hero_slide_order'],
					)
				);
			}

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}

			foreach ( $slide as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}

			$poster_id = attachment_url_to_postid( $slide['hero_poster_image'] );
			if ( $poster_id ) {
				set_post_thumbnail( $post_id, $poster_id );
			}

			$kept_ids[] = (int) $post_id;

			if ( count( $matches ) > 1 ) {
				foreach ( array_slice( $matches, 1 ) as $duplicate ) {
					update_post_meta( $duplicate->ID, 'hero_is_active', '0' );
				}
			}
		}

		$all_slides = get_posts(
			array(
				'post_type'      => 'nitaq_hero_slide',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		foreach ( $all_slides as $slide_id ) {
			$title = get_the_title( $slide_id );
			if ( ! in_array( (int) $slide_id, $kept_ids, true ) || ! in_array( $title, $required_titles, true ) ) {
				update_post_meta( $slide_id, 'hero_is_active', '0' );
			}
		}

		update_option( 'nitaq_required_hero_slides_version', '20260514-three-text-slides', false );
	}

	add_action( 'init', 'hendon_child_seed_required_nitaq_hero_slides', 14 );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_slide_meta_fields' ) ) {
	/**
	 * Meta field map for the hero slide edit screen.
	 */
	function hendon_child_nitaq_hero_slide_meta_fields() {
		return array(
			'hero_title'           => array( 'label' => 'العنوان الرئيسي', 'type' => 'text' ),
			'hero_subtitle'        => array( 'label' => 'النص الفرعي', 'type' => 'textarea' ),
			'hero_kicker'          => array( 'label' => 'النص العلوي الصغير', 'type' => 'text' ),
			'hero_button_text'     => array( 'label' => 'نص الزر', 'type' => 'text' ),
			'hero_button_link'     => array( 'label' => 'رابط الزر', 'type' => 'text' ),
			'hero_video_webm'      => array( 'label' => 'رابط فيديو WebM', 'type' => 'media' ),
			'hero_video_mp4'       => array( 'label' => 'رابط فيديو MP4', 'type' => 'media' ),
			'hero_poster_image'    => array( 'label' => 'صورة الغلاف / Poster', 'type' => 'media' ),
			'hero_slide_order'     => array( 'label' => 'ترتيب الشريحة', 'type' => 'number' ),
			'hero_is_active'       => array( 'label' => 'تفعيل الشريحة', 'type' => 'checkbox' ),
			'hero_overlay_opacity' => array( 'label' => 'شفافية الطبقة الداكنة', 'type' => 'number_step' ),
		);
	}
}

if ( ! function_exists( 'hendon_child_add_nitaq_hero_slide_meta_box' ) ) {
	/**
	 * Add native WordPress fields for easy hero slide management.
	 */
	function hendon_child_add_nitaq_hero_slide_meta_box() {
		add_meta_box(
			'nitaq_hero_slide_details',
			'بيانات شريحة الواجهة',
			'hendon_child_render_nitaq_hero_slide_meta_box',
			'nitaq_hero_slide',
			'normal',
			'high'
		);
	}

	add_action( 'add_meta_boxes', 'hendon_child_add_nitaq_hero_slide_meta_box' );
}

if ( ! function_exists( 'hendon_child_render_nitaq_hero_slide_meta_box' ) ) {
	/**
	 * Render hero slide fields.
	 */
	function hendon_child_render_nitaq_hero_slide_meta_box( $post ) {
		$defaults = hendon_child_nitaq_hero_slide_defaults();
		$fields   = hendon_child_nitaq_hero_slide_meta_fields();

		wp_nonce_field( 'nitaq_hero_slide_meta', 'nitaq_hero_slide_meta_nonce' );
		?>
		<div class="nitaq-admin-fields" dir="rtl">
			<p style="margin:0 0 18px;color:#555;">أضف بيانات الشريحة، الفيديو، صورة الغلاف، الزر، وحالة التفعيل. يتم عرض الشرائح المفعلة فقط في الواجهة الرئيسية.</p>
			<?php foreach ( $fields as $key => $field ) : ?>
				<?php
				$value = get_post_meta( $post->ID, $key, true );
				if ( '' === $value && isset( $defaults[ $key ] ) ) {
					$value = $defaults[ $key ];
				}
				?>
				<p style="display:grid;gap:8px;margin:0 0 16px;">
					<label for="<?php echo esc_attr( $key ); ?>" style="font-weight:700;"><?php echo esc_html( $field['label'] ); ?></label>
					<?php if ( 'textarea' === $field['type'] ) : ?>
						<textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="4" style="width:100%;direction:rtl;text-align:right;"><?php echo esc_textarea( $value ); ?></textarea>
					<?php elseif ( 'checkbox' === $field['type'] ) : ?>
						<label style="display:flex;align-items:center;gap:8px;">
							<input id="<?php echo esc_attr( $key ); ?>" type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $value, '1' ); ?>>
							<span>Active / تفعيل الشريحة</span>
						</label>
					<?php elseif ( 'media' === $field['type'] ) : ?>
						<span style="display:flex;gap:8px;align-items:center;">
							<input id="<?php echo esc_attr( $key ); ?>" class="nitaq-hero-media-url" type="url" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_url( $value ); ?>" style="width:100%;direction:ltr;text-align:left;">
							<button type="button" class="button nitaq-hero-media-button" data-target="<?php echo esc_attr( $key ); ?>">اختيار ملف</button>
						</span>
					<?php elseif ( 'number' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="number" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" min="0" step="1" style="width:160px;">
					<?php elseif ( 'number_step' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="number" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" min="0" max="1" step="0.05" style="width:160px;">
					<?php else : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="<?php echo esc_attr( $field['type'] ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;direction:rtl;text-align:right;">
					<?php endif; ?>
				</p>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hendon_child_save_nitaq_hero_slide_meta' ) ) {
	/**
	 * Save hero slide fields.
	 */
	function hendon_child_save_nitaq_hero_slide_meta( $post_id ) {
		if (
			! isset( $_POST['nitaq_hero_slide_meta_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nitaq_hero_slide_meta_nonce'] ) ), 'nitaq_hero_slide_meta' )
		) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( hendon_child_nitaq_hero_slide_meta_fields() as $key => $field ) {
			if ( 'checkbox' === $field['type'] ) {
				update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '0' );
				continue;
			}

			$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';

			if ( in_array( $field['type'], array( 'url', 'media' ), true ) || 'hero_button_link' === $key ) {
				$value = esc_url_raw( $value );
			} elseif ( in_array( $field['type'], array( 'number', 'number_step' ), true ) ) {
				$value = (string) max( 0, (float) $value );
				if ( 'hero_overlay_opacity' === $key ) {
					$value = (string) min( 1, (float) $value );
				}
			} else {
				$value = sanitize_textarea_field( $value );
			}

			update_post_meta( $post_id, $key, $value );
		}

		$order = isset( $_POST['hero_slide_order'] ) ? (int) $_POST['hero_slide_order'] : 0;
		remove_action( 'save_post_nitaq_hero_slide', 'hendon_child_save_nitaq_hero_slide_meta' );
		wp_update_post(
			array(
				'ID'         => $post_id,
				'menu_order' => $order,
			)
		);
		add_action( 'save_post_nitaq_hero_slide', 'hendon_child_save_nitaq_hero_slide_meta' );
	}

	add_action( 'save_post_nitaq_hero_slide', 'hendon_child_save_nitaq_hero_slide_meta' );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_admin_assets' ) ) {
	/**
	 * Enable Media Library picker on hero slide fields.
	 */
	function hendon_child_nitaq_hero_admin_assets( $hook ) {
		$screen = get_current_screen();

		if ( ! $screen || 'nitaq_hero_slide' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
		wp_add_inline_script(
			'jquery-core',
			<<<'JS'
(function($){$(document).on('click','.nitaq-hero-media-button',function(e){e.preventDefault();var target=$('#'+$(this).data('target'));var frame=wp.media({title:'اختيار ملف الشريحة',button:{text:'استخدام هذا الملف'},multiple:false});frame.on('select',function(){var file=frame.state().get('selection').first().toJSON();target.val(file.url).trigger('change');});frame.open();});})(jQuery);
JS
		);
	}

	add_action( 'admin_enqueue_scripts', 'hendon_child_nitaq_hero_admin_assets' );
}

if ( ! function_exists( 'hendon_child_register_nitaq_stat_post_type' ) ) {
	/**
	 * Register editable homepage statistics.
	 */
	function hendon_child_register_nitaq_stat_post_type() {
		register_post_type(
			'nitaq_stat',
			array(
				'labels'          => array(
					'name'               => 'إحصائيات نطاق',
					'singular_name'      => 'إحصائية نطاق',
					'menu_name'          => 'إحصائيات نطاق',
					'add_new'            => 'إضافة إحصائية',
					'add_new_item'       => 'إضافة إحصائية جديدة',
					'edit_item'          => 'تعديل الإحصائية',
					'new_item'           => 'إحصائية جديدة',
					'view_item'          => 'عرض الإحصائية',
					'search_items'       => 'البحث في الإحصائيات',
					'not_found'          => 'لا توجد إحصائيات',
					'not_found_in_trash' => 'لا توجد إحصائيات في سلة المهملات',
					'all_items'          => 'كل الإحصائيات',
				),
				'description'     => 'Nitaq homepage statistics',
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-chart-bar',
				'menu_position'   => 23,
				'supports'        => array( 'title', 'page-attributes' ),
				'hierarchical'    => false,
				'has_archive'     => false,
				'rewrite'         => false,
				'query_var'       => false,
				'capability_type' => 'post',
			)
		);
	}

	add_action( 'init', 'hendon_child_register_nitaq_stat_post_type' );
}

if ( ! function_exists( 'hendon_child_nitaq_stat_defaults' ) ) {
	/**
	 * Default statistics shown if the dashboard has no stat posts yet.
	 */
	function hendon_child_nitaq_stat_defaults() {
		return array(
			array(
				'stat_label'       => 'المساحة الإجمالية',
				'stat_number'      => '9.3',
				'stat_unit'        => '+ مليون م²',
				'stat_description' => 'وجهة واسعة بتخطيط عمراني متكامل',
				'stat_order'       => 1,
				'stat_is_active'   => '1',
			),
			array(
				'stat_label'       => 'المسطحات الخضراء',
				'stat_number'      => '877',
				'stat_unit'        => '+ ألف م²',
				'stat_description' => 'مساحات مفتوحة تعزز جودة الحياة',
				'stat_order'       => 2,
				'stat_is_active'   => '1',
			),
			array(
				'stat_label'       => 'مرافق تجارية',
				'stat_number'      => '14',
				'stat_unit'        => 'مرفق',
				'stat_description' => 'خدمات قريبة تلبي احتياجات السكان',
				'stat_order'       => 3,
				'stat_is_active'   => '1',
			),
			array(
				'stat_label'       => 'مرافق تعليمية',
				'stat_number'      => '10',
				'stat_unit'        => 'مرافق',
				'stat_description' => 'بيئة متكاملة للعائلات والمجتمع',
				'stat_order'       => 4,
				'stat_is_active'   => '1',
			),
		);
	}
}

if ( ! function_exists( 'hendon_child_create_default_nitaq_stats' ) ) {
	/**
	 * Seed default statistics only when no stat posts exist.
	 */
	function hendon_child_create_default_nitaq_stats() {
		$existing = get_posts(
			array(
				'post_type'      => 'nitaq_stat',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $existing ) {
			return;
		}

		foreach ( hendon_child_nitaq_stat_defaults() as $stat ) {
			$post_id = wp_insert_post(
				array(
					'post_type'   => 'nitaq_stat',
					'post_status' => 'publish',
					'post_title'  => $stat['stat_label'],
					'menu_order'  => (int) $stat['stat_order'],
				)
			);

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}

			foreach ( $stat as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	add_action( 'init', 'hendon_child_create_default_nitaq_stats', 12 );
}

if ( ! function_exists( 'hendon_child_nitaq_stat_meta_fields' ) ) {
	/**
	 * Meta field map for statistics.
	 */
	function hendon_child_nitaq_stat_meta_fields() {
		return array(
			'stat_label'       => array( 'label' => 'العنوان / Label', 'type' => 'text' ),
			'stat_number'      => array( 'label' => 'الرقم', 'type' => 'text' ),
			'stat_unit'        => array( 'label' => 'الوحدة', 'type' => 'text' ),
			'stat_description' => array( 'label' => 'الوصف المختصر', 'type' => 'textarea' ),
			'stat_order'       => array( 'label' => 'ترتيب العرض', 'type' => 'number' ),
			'stat_is_active'   => array( 'label' => 'تفعيل الإحصائية', 'type' => 'checkbox' ),
		);
	}
}

if ( ! function_exists( 'hendon_child_add_nitaq_stat_meta_box' ) ) {
	/**
	 * Add native dashboard fields for statistics.
	 */
	function hendon_child_add_nitaq_stat_meta_box() {
		add_meta_box(
			'nitaq_stat_details',
			'بيانات الإحصائية',
			'hendon_child_render_nitaq_stat_meta_box',
			'nitaq_stat',
			'normal',
			'high'
		);
	}

	add_action( 'add_meta_boxes', 'hendon_child_add_nitaq_stat_meta_box' );
}

if ( ! function_exists( 'hendon_child_render_nitaq_stat_meta_box' ) ) {
	/**
	 * Render stat fields.
	 */
	function hendon_child_render_nitaq_stat_meta_box( $post ) {
		$fields = hendon_child_nitaq_stat_meta_fields();

		wp_nonce_field( 'nitaq_stat_meta', 'nitaq_stat_meta_nonce' );
		?>
		<div class="nitaq-admin-fields" dir="rtl">
			<p style="margin:0 0 18px;color:#555;">عدّل العنوان، الرقم، الوحدة، الوصف، الترتيب، وحالة التفعيل. تظهر الإحصائيات المفعلة فقط في الصفحة الرئيسية.</p>
			<?php foreach ( $fields as $key => $field ) : ?>
				<?php $value = get_post_meta( $post->ID, $key, true ); ?>
				<p style="display:grid;gap:8px;margin:0 0 16px;">
					<label for="<?php echo esc_attr( $key ); ?>" style="font-weight:700;"><?php echo esc_html( $field['label'] ); ?></label>
					<?php if ( 'textarea' === $field['type'] ) : ?>
						<textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="3" style="width:100%;direction:rtl;text-align:right;"><?php echo esc_textarea( $value ); ?></textarea>
					<?php elseif ( 'checkbox' === $field['type'] ) : ?>
						<label style="display:flex;align-items:center;gap:8px;">
							<input id="<?php echo esc_attr( $key ); ?>" type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $value, '1' ); ?>>
							<span>Active / تفعيل الإحصائية</span>
						</label>
					<?php elseif ( 'number' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="number" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" min="0" step="1" style="width:160px;">
					<?php else : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="text" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;direction:rtl;text-align:right;">
					<?php endif; ?>
				</p>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hendon_child_save_nitaq_stat_meta' ) ) {
	/**
	 * Save statistic fields.
	 */
	function hendon_child_save_nitaq_stat_meta( $post_id ) {
		if (
			! isset( $_POST['nitaq_stat_meta_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nitaq_stat_meta_nonce'] ) ), 'nitaq_stat_meta' )
		) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( hendon_child_nitaq_stat_meta_fields() as $key => $field ) {
			if ( 'checkbox' === $field['type'] ) {
				update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '0' );
				continue;
			}

			$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';

			if ( 'number' === $field['type'] ) {
				$value = (string) max( 0, (int) $value );
			} else {
				$value = sanitize_textarea_field( $value );
			}

			update_post_meta( $post_id, $key, $value );
		}

		$order = isset( $_POST['stat_order'] ) ? (int) $_POST['stat_order'] : 0;
		remove_action( 'save_post_nitaq_stat', 'hendon_child_save_nitaq_stat_meta' );
		wp_update_post(
			array(
				'ID'         => $post_id,
				'menu_order' => $order,
			)
		);
		add_action( 'save_post_nitaq_stat', 'hendon_child_save_nitaq_stat_meta' );
	}

	add_action( 'save_post_nitaq_stat', 'hendon_child_save_nitaq_stat_meta' );
}

if ( ! function_exists( 'hendon_child_nitaq_stat_columns' ) ) {
	/**
	 * Dashboard list columns for statistics.
	 */
	function hendon_child_nitaq_stat_columns( $columns ) {
		return array(
			'cb'          => $columns['cb'],
			'title'       => 'Label',
			'stat_number' => 'Number',
			'stat_unit'   => 'Unit',
			'stat_order'  => 'Order',
			'stat_active' => 'Active',
			'date'        => $columns['date'],
		);
	}

	add_filter( 'manage_nitaq_stat_posts_columns', 'hendon_child_nitaq_stat_columns' );
}

if ( ! function_exists( 'hendon_child_nitaq_stat_column_content' ) ) {
	/**
	 * Render dashboard column content for statistics.
	 */
	function hendon_child_nitaq_stat_column_content( $column, $post_id ) {
		if ( 'stat_number' === $column ) {
			echo esc_html( get_post_meta( $post_id, 'stat_number', true ) );
		}

		if ( 'stat_unit' === $column ) {
			echo esc_html( get_post_meta( $post_id, 'stat_unit', true ) );
		}

		if ( 'stat_order' === $column ) {
			echo esc_html( get_post_meta( $post_id, 'stat_order', true ) );
		}

		if ( 'stat_active' === $column ) {
			echo '1' === get_post_meta( $post_id, 'stat_is_active', true ) ? esc_html__( 'Yes', 'hendon' ) : esc_html__( 'No', 'hendon' );
		}
	}

	add_action( 'manage_nitaq_stat_posts_custom_column', 'hendon_child_nitaq_stat_column_content', 10, 2 );
}

if ( ! function_exists( 'hendon_child_get_nitaq_stats' ) ) {
	/**
	 * Get active homepage statistics ordered by stat order.
	 */
	function hendon_child_get_nitaq_stats() {
		$query = new WP_Query(
			array(
				'post_type'      => 'nitaq_stat',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'   => 'stat_is_active',
						'value' => '1',
					),
				),
				'meta_key'       => 'stat_order',
				'orderby'        => array(
					'meta_value_num' => 'ASC',
					'menu_order'     => 'ASC',
					'date'           => 'ASC',
				),
				'order'          => 'ASC',
			)
		);

		$stats = array();

		foreach ( $query->posts as $post ) {
			$stats[] = array(
				'label'       => get_post_meta( $post->ID, 'stat_label', true ) ?: get_the_title( $post ),
				'number'      => get_post_meta( $post->ID, 'stat_number', true ),
				'unit'        => get_post_meta( $post->ID, 'stat_unit', true ),
				'description' => get_post_meta( $post->ID, 'stat_description', true ),
				'order'       => get_post_meta( $post->ID, 'stat_order', true ),
			);
		}

		wp_reset_postdata();

		if ( empty( $stats ) ) {
			foreach ( hendon_child_nitaq_stat_defaults() as $stat ) {
				if ( '1' === $stat['stat_is_active'] ) {
					$stats[] = array(
						'label'       => $stat['stat_label'],
						'number'      => $stat['stat_number'],
						'unit'        => $stat['stat_unit'],
						'description' => $stat['stat_description'],
						'order'       => $stat['stat_order'],
					);
				}
			}
		}

		return $stats;
	}
}

if ( ! function_exists( 'hendon_child_nitaq_stats_markup' ) ) {
	/**
	 * Render the replacement homepage statistics section.
	 */
	function hendon_child_nitaq_stats_markup() {
		$stats = hendon_child_get_nitaq_stats();

		if ( empty( $stats ) ) {
			return '';
		}

		ob_start();
		?>
		<section class="nitaq-stats-new" dir="rtl" data-nitaq-stats-replacement hidden aria-label="<?php echo esc_attr__( 'Nitaq statistics', 'hendon' ); ?>">
			<div class="nitaq-stats-new__inner">
				<div class="nitaq-stats-new__header">
					<span class="nitaq-stats-new__kicker">نطاق الأولى</span>
					<h2>أرقام تعكس حجم الوجهة</h2>
					<p>مساحات ومرافق صُممت لتمنح السكان تجربة حياة متكاملة في قلب الخبر.</p>
				</div>

				<div class="nitaq-stats-new__grid">
					<?php foreach ( $stats as $stat ) : ?>
						<article class="nitaq-stats-new__item">
							<?php if ( ! empty( $stat['label'] ) ) : ?>
								<div class="nitaq-stats-new__label"><?php echo esc_html( $stat['label'] ); ?></div>
							<?php endif; ?>
							<div class="nitaq-stats-new__value">
								<?php if ( '' !== (string) $stat['number'] ) : ?>
									<span class="nitaq-stats-new__number" dir="ltr" data-final-number="<?php echo esc_attr( $stat['number'] ); ?>" data-target="<?php echo esc_attr( $stat['number'] ); ?>"><?php echo esc_html( $stat['number'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $stat['unit'] ) ) : ?>
									<span class="nitaq-stats-new__unit" dir="rtl"><?php echo esc_html( $stat['unit'] ); ?></span>
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $stat['description'] ) ) : ?>
								<div class="nitaq-stats-new__description"><?php echo esc_html( $stat['description'] ); ?></div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_stats_shortcode' ) ) {
	/**
	 * Shortcode fallback for the dashboard-managed statistics.
	 */
	function hendon_child_nitaq_stats_shortcode() {
		return hendon_child_nitaq_stats_markup();
	}

	add_shortcode( 'nitaq_stats', 'hendon_child_nitaq_stats_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_front_page_stats_replacement' ) ) {
	/**
	 * Replace the broken Elementor statistics block in-place on the homepage.
	 */
	function hendon_child_nitaq_front_page_stats_replacement() {
		if ( ! is_front_page() ) {
			return;
		}

		echo hendon_child_nitaq_stats_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<script>
			(function () {
				function initNitaqStatsReplacement() {
					var replacement = document.querySelector('[data-nitaq-stats-replacement]');
					var root = document.querySelector('body.home #qodef-page-inner');

					if (!replacement || !root || replacement.dataset.nitaqStatsReady === 'true') {
						return;
					}

					var labels = ['المساحة الإجمالية', 'المسطحات الخضراء', 'مرافق تجارية', 'مرافق تعليمية'];

					function hasLabels(element) {
						var text = element ? element.textContent || '' : '';
						return labels.filter(function (label) {
							return text.indexOf(label) > -1;
						}).length >= 3;
					}

					function findOldStatsSection() {
						var candidates = Array.prototype.slice.call(root.querySelectorAll('.elementor-section, section, .e-con, .elementor-container, .qodef-row-grid-section'));

						return candidates.find(function (section) {
							return section !== replacement &&
								!section.closest('.nitaq-hero-slider, [data-nitaq-stats-replacement], #qodef-page-footer, [id^="image-map-pro-"], .imp-wrap') &&
								hasLabels(section);
						}) || null;
					}

					function animateNumber(number) {
						if (!number || number.dataset.counted === 'true') {
							return;
						}

						var finalRaw = number.dataset.finalNumber || number.textContent;
						var finalValue = parseFloat(String(finalRaw).replace(/,/g, ''));
						var decimals = String(finalRaw).indexOf('.') > -1 ? String(finalRaw).split('.')[1].length : 0;
						var duration = 1400;
						var startTime = null;

						if (!isFinite(finalValue)) {
							return;
						}

						number.setAttribute('dir', 'ltr');
						number.style.direction = 'ltr';
						number.style.unicodeBidi = 'isolate';

						function format(value) {
							return decimals > 0 ? value.toFixed(decimals) : String(Math.round(value));
						}

						function tick(timestamp) {
							if (!startTime) {
								startTime = timestamp;
							}

							var progress = Math.min((timestamp - startTime) / duration, 1);
							var eased = 1 - Math.pow(1 - progress, 3);
							number.textContent = format(finalValue * eased);
							number.setAttribute('dir', 'ltr');

							if (progress < 1) {
								window.requestAnimationFrame(tick);
							} else {
								number.textContent = finalRaw;
								number.setAttribute('dir', 'ltr');
								number.dataset.counted = 'true';
							}
						}

						window.requestAnimationFrame(tick);
					}

					function initCountUp() {
						var numbers = Array.prototype.slice.call(replacement.querySelectorAll('.nitaq-stats-new__number'));

						if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
							numbers.forEach(function (number) {
								number.textContent = number.dataset.finalNumber || number.textContent;
								number.setAttribute('dir', 'ltr');
								number.dataset.counted = 'true';
							});
							return;
						}

						var observer = new IntersectionObserver(function (entries) {
							entries.forEach(function (entry) {
								if (entry.isIntersecting) {
									numbers.forEach(animateNumber);
									observer.unobserve(entry.target);
								}
							});
						}, {
							threshold: 0.25,
							rootMargin: '0px 0px -8% 0px'
						});

						observer.observe(replacement);
					}

					var oldSection = findOldStatsSection();

					if (oldSection && oldSection.parentNode) {
						oldSection.parentNode.insertBefore(replacement, oldSection);
						oldSection.classList.add('nitaq-stats-old-hidden');
					} else {
						var hero = document.querySelector('.nitaq-hero-slider');
						if (hero && hero.parentNode) {
							hero.parentNode.insertBefore(replacement, hero.nextSibling);
						}
					}

					replacement.hidden = false;
					replacement.dataset.nitaqStatsReady = 'true';
					initCountUp();
				}

				document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', initNitaqStatsReplacement) : initNitaqStatsReplacement();
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_nitaq_front_page_stats_replacement', 95 );
}

if ( ! function_exists( 'hendon_child_get_nitaq_hero_slides' ) ) {
	/**
	 * Get active hero slides ordered by custom order.
	 */
	function hendon_child_get_nitaq_hero_slides() {
		$query = new WP_Query(
			array(
				'post_type'      => 'nitaq_hero_slide',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'   => 'hero_is_active',
						'value' => '1',
					),
				),
				'meta_key'       => 'hero_slide_order',
				'orderby'        => array(
					'meta_value_num' => 'ASC',
					'menu_order'     => 'ASC',
					'date'           => 'ASC',
				),
				'order'          => 'ASC',
			)
		);

		$slides = array();

		foreach ( $query->posts as $post ) {
			$defaults = hendon_child_nitaq_hero_slide_defaults();
			$slide    = array();

			foreach ( array_keys( $defaults ) as $key ) {
				$value         = get_post_meta( $post->ID, $key, true );
				$slide[ $key ] = '' !== $value ? $value : $defaults[ $key ];
			}

			$featured = get_the_post_thumbnail_url( $post, 'full' );
			if ( $featured && empty( $slide['hero_poster_image'] ) ) {
				$slide['hero_poster_image'] = $featured;
			}

			$slide['post_id'] = $post->ID;
			$slides[]         = $slide;
		}

		wp_reset_postdata();

		if ( empty( $slides ) ) {
			$slides = array( hendon_child_nitaq_hero_slide_defaults() );
		}

		return $slides;
	}
}

if ( ! function_exists( 'hendon_child_nitaq_hero_slider_markup' ) ) {
	/**
	 * Render the Nitaq homepage hero slider.
	 */
	function hendon_child_nitaq_hero_slider_markup() {
		$slides       = hendon_child_get_nitaq_hero_slides();
		$default      = hendon_child_nitaq_hero_slide_defaults();
		$background   = $slides[0] ?? $default;
		$webm_url     = ! empty( $background['hero_video_webm'] ) ? $background['hero_video_webm'] : $default['hero_video_webm'];
		$mp4_url      = ! empty( $background['hero_video_mp4'] ) ? $background['hero_video_mp4'] : $default['hero_video_mp4'];
		$poster_url   = ! empty( $background['hero_poster_image'] ) ? $background['hero_poster_image'] : $default['hero_poster_image'];
		$overlay      = isset( $background['hero_overlay_opacity'] ) ? min( 1, max( 0, (float) $background['hero_overlay_opacity'] ) ) : 0.24;

		ob_start();
		?>
		<section class="nitaq-hero-slider" dir="rtl" data-interval="7000" style="--nitaq-hero-overlay-opacity: <?php echo esc_attr( $overlay ); ?>;" aria-label="<?php echo esc_attr__( 'Nitaq homepage hero slider', 'hendon' ); ?>">
			<?php if ( $webm_url || $mp4_url ) : ?>
				<video class="nitaq-hero-global-video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( $poster_url ); ?>" aria-hidden="true">
					<?php if ( $webm_url ) : ?>
						<source src="<?php echo esc_url( $webm_url ); ?>" type="video/webm">
					<?php endif; ?>
					<?php if ( $mp4_url ) : ?>
						<source src="<?php echo esc_url( $mp4_url ); ?>" type="video/mp4">
					<?php endif; ?>
				</video>
			<?php elseif ( $poster_url ) : ?>
				<img class="nitaq-hero-poster" src="<?php echo esc_url( $poster_url ); ?>" alt="" aria-hidden="true">
			<?php endif; ?>

			<div class="nitaq-hero-overlay" aria-hidden="true"></div>

			<div class="nitaq-hero-text-slides">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<div class="nitaq-hero-slide <?php echo 0 === $index ? 'is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( $index ); ?>">
						<div class="nitaq-hero-content">
							<?php if ( ! empty( $slide['hero_kicker'] ) ) : ?>
								<span class="nitaq-hero-kicker"><?php echo esc_html( $slide['hero_kicker'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $slide['hero_title'] ) ) : ?>
								<h1><?php echo esc_html( $slide['hero_title'] ); ?></h1>
							<?php endif; ?>
							<?php if ( ! empty( $slide['hero_subtitle'] ) ) : ?>
								<p><?php echo esc_html( $slide['hero_subtitle'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $slide['hero_button_text'] ) && ! empty( $slide['hero_button_link'] ) ) : ?>
								<a href="<?php echo esc_url( $slide['hero_button_link'] ); ?>" class="nitaq-hero-btn"><?php echo esc_html( $slide['hero_button_text'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( count( $slides ) > 1 ) : ?>
				<div class="nitaq-hero-arrows" aria-label="Hero slide controls">
					<button type="button" class="nitaq-hero-arrow nitaq-hero-arrow--prev" data-slide-direction="-1" aria-label="Previous slide"></button>
					<button type="button" class="nitaq-hero-arrow nitaq-hero-arrow--next" data-slide-direction="1" aria-label="Next slide"></button>
				</div>
				<div class="nitaq-hero-dots" aria-label="Hero slide navigation">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<button type="button" class="<?php echo 0 === $index ? 'is-active' : ''; ?>" data-slide-to="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( 'Slide ' . ( $index + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_video_hero_markup' ) ) {
	/**
	 * Backward-compatible alias for the previous video hero function.
	 */
	function hendon_child_nitaq_video_hero_markup() {
		return hendon_child_nitaq_hero_slider_markup();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_video_hero_shortcode' ) ) {
	/**
	 * Shortcode fallback for placing the video hero manually if needed.
	 */
	function hendon_child_nitaq_video_hero_shortcode() {
		return hendon_child_nitaq_video_hero_markup();
	}

	add_shortcode( 'nitaq_video_hero', 'hendon_child_nitaq_video_hero_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_slider_shortcode' ) ) {
	/**
	 * Admin-managed hero slider shortcode.
	 */
	function hendon_child_nitaq_hero_slider_shortcode() {
		return hendon_child_nitaq_hero_slider_markup();
	}

	add_shortcode( 'nitaq_hero_slider', 'hendon_child_nitaq_hero_slider_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_front_page_video_hero' ) ) {
	/**
	 * Render the admin-managed hero slider on the homepage before Elementor page content.
	 */
	function hendon_child_nitaq_front_page_video_hero() {
		if ( ! is_front_page() ) {
			return;
		}

		echo do_shortcode( '[nitaq_hero_slider]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'hendon_action_before_page_inner', 'hendon_child_nitaq_front_page_video_hero', 4 );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_slider_script' ) ) {
	/**
	 * Lightweight vanilla JS slider for the Nitaq hero.
	 */
	function hendon_child_nitaq_hero_slider_script() {
		?>
		<script>
			(function () {
				function initNitaqHeroSlider(slider) {
					if (!slider || slider.dataset.nitaqHeroReady === 'true') {
						return;
					}

					var slides = Array.prototype.slice.call(slider.querySelectorAll('.nitaq-hero-slide'));
					var dots = Array.prototype.slice.call(slider.querySelectorAll('.nitaq-hero-dots button'));
					var arrows = Array.prototype.slice.call(slider.querySelectorAll('.nitaq-hero-arrow'));
					var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

					if (!slides.length) {
						return;
					}

					var current = Math.max(0, slides.findIndex(function (slide) {
						return slide.classList.contains('is-active');
					}));
					var timer = null;
					var paused = false;
					var interval = parseInt(slider.dataset.interval || '7000', 10);

					function show(index) {
						current = (index + slides.length) % slides.length;

						slides.forEach(function (slide, slideIndex) {
							slide.classList.toggle('is-active', slideIndex === current);
						});

						dots.forEach(function (dot, dotIndex) {
							dot.classList.toggle('is-active', dotIndex === current);
							dot.setAttribute('aria-current', dotIndex === current ? 'true' : 'false');
						});
					}

					function start() {
						if (reducedMotion || slides.length < 2) {
							return;
						}

						clearInterval(timer);
						timer = window.setInterval(function () {
							if (!paused) {
								show(current + 1);
							}
						}, interval);
					}

					dots.forEach(function (dot) {
						dot.addEventListener('click', function () {
							paused = true;
							show(parseInt(dot.dataset.slideTo || '0', 10));
							window.setTimeout(function () {
								paused = false;
							}, interval);
						});
					});

					arrows.forEach(function (arrow) {
						arrow.addEventListener('click', function () {
							paused = true;
							show(current + parseInt(arrow.dataset.slideDirection || '1', 10));
							window.setTimeout(function () {
								paused = false;
							}, interval);
						});
					});

					['mouseenter', 'focusin', 'touchstart', 'pointerdown'].forEach(function (eventName) {
						slider.addEventListener(eventName, function () {
							paused = true;
						}, { passive: true });
					});

					['mouseleave', 'focusout', 'touchend', 'pointerup'].forEach(function (eventName) {
						slider.addEventListener(eventName, function () {
							window.setTimeout(function () {
								paused = false;
							}, 1800);
						}, { passive: true });
					});

					slider.dataset.nitaqHeroReady = 'true';
					var video = slider.querySelector('.nitaq-hero-global-video');
					if (video && video.play) {
						video.play().catch(function () {});
					}
					show(current);
					start();
				}

				function initAllNitaqHeroSliders() {
					Array.prototype.slice.call(document.querySelectorAll('.nitaq-hero-slider')).forEach(initNitaqHeroSlider);
				}

				document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', initAllNitaqHeroSliders) : initAllNitaqHeroSliders();
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_nitaq_hero_slider_script', 97 );
}

if ( ! function_exists( 'hendon_child_nitaq_mobile_hero_slider' ) ) {
	/**
	 * Lightweight mobile-only carousel for the custom Nitaq homepage hero.
	 */
	function hendon_child_nitaq_mobile_hero_slider() {
		?>
		<script>
			(function () {
				function initNitaqMobileHeroSlider() {
					var slider = document.querySelector('.nitaq-mobile-slider');

					if (!slider || slider.dataset.nitaqSliderReady === 'true') {
						return;
					}

					var slides = Array.prototype.slice.call(slider.querySelectorAll('.nitaq-mobile-slide'));
					var dots = Array.prototype.slice.call(slider.querySelectorAll('.nitaq-mobile-slider__dots button'));

					if (slides.length < 2) {
						return;
					}

					var current = Math.max(0, slides.findIndex(function (slide) {
						return slide.classList.contains('is-active');
					}));
					var timer = null;
					var paused = false;

					function show(index) {
						current = (index + slides.length) % slides.length;

						slides.forEach(function (slide, slideIndex) {
							slide.classList.toggle('is-active', slideIndex === current);
						});

						dots.forEach(function (dot, dotIndex) {
							dot.classList.toggle('is-active', dotIndex === current);
						});
					}

					function start() {
						clearInterval(timer);
						timer = setInterval(function () {
							if (!paused && window.matchMedia('(max-width: 767px)').matches) {
								show(current + 1);
							}
						}, 4500);
					}

					dots.forEach(function (dot) {
						dot.addEventListener('click', function () {
							paused = true;
							show(parseInt(dot.dataset.slideTo || '0', 10));
							window.setTimeout(function () {
								paused = false;
							}, 6500);
						});
					});

					['touchstart', 'pointerdown', 'mouseenter', 'focusin'].forEach(function (eventName) {
						slider.addEventListener(eventName, function () {
							paused = true;
						}, { passive: true });
					});

					['touchend', 'pointerup', 'mouseleave', 'focusout'].forEach(function (eventName) {
						slider.addEventListener(eventName, function () {
							window.setTimeout(function () {
								paused = false;
							}, 2500);
						}, { passive: true });
					});

					slider.dataset.nitaqSliderReady = 'true';
					show(current);
					start();
				}

				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', initNitaqMobileHeroSlider);
				} else {
					initNitaqMobileHeroSlider();
				}
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_nitaq_mobile_hero_slider', 98 );
}

if ( ! function_exists( 'hendon_child_nitaq_news_card_date' ) ) {
	/**
	 * Keep homepage news cards on the requested Arabic month label.
	 */
	function hendon_child_nitaq_news_card_date( $time ) {
		if ( is_admin() ) {
			return $time;
		}

		$post = get_post();

		if ( $post && 'post' === $post->post_type && in_array( (int) $post->ID, array( 615, 619 ), true ) ) {
			return 'مايو 2025';
		}

		return $time;
	}

	add_filter( 'the_time', 'hendon_child_nitaq_news_card_date', 10, 1 );
	add_filter( 'get_the_time', 'hendon_child_nitaq_news_card_date', 10, 1 );
}

if ( ! function_exists( 'hendon_child_image_map_mobile_tooltips' ) ) {
	/**
	 * Open Image Map Pro tooltips on tap for mobile-sized viewports.
	 */
	function hendon_child_image_map_mobile_tooltips() {
		?>
		<script>
			(function () {
				var lastTap = 0;

				function isMobileMapViewport() {
					return window.matchMedia('(max-width: 767px), (pointer: coarse)').matches;
				}

				function getImageMapInstance(mapId) {
					if (!window.ImageMapPro || !ImageMapPro.instances) {
						return null;
					}

					return Object.keys(ImageMapPro.instances).map(function (key) {
						return ImageMapPro.instances[key];
					}).find(function (instance) {
						return instance && instance.store && instance.store.getID && instance.store.getID() === mapId;
					}) || null;
				}

				function getObjectFromEvent(event) {
					var point = event.changedTouches && event.changedTouches.length ? event.changedTouches[0] : event;
					var target = event.target && event.target.closest ? event.target.closest('.imp-object[data-object-id][data-image-map-id]') : null;

					if (target) {
						return target;
					}

					target = document.elementFromPoint(point.clientX, point.clientY);

					if (target && target.closest) {
						target = target.closest('.imp-object[data-object-id][data-image-map-id]');
					}

					if (target) {
						return target;
					}

					return Array.prototype.find.call(document.querySelectorAll('.imp-object[data-object-id][data-image-map-id]'), function (object) {
						var rect = object.getBoundingClientRect();

						return point.clientX >= rect.left &&
							point.clientX <= rect.right &&
							point.clientY >= rect.top &&
							point.clientY <= rect.bottom;
					}) || null;
				}

				function openMobileTooltip(event) {
					if (!isMobileMapViewport()) {
						return;
					}

					var object = getObjectFromEvent(event);

					if (!object) {
						return;
					}

					var now = Date.now();
					if (now - lastTap < 350) {
						return;
					}
					lastTap = now;

					var instance = getImageMapInstance(object.dataset.imageMapId);
					if (!instance || !instance.store || !instance.store.dispatch) {
						return;
					}

					event.preventDefault();

					instance.store.dispatch('unhighlightAllObjects');
					instance.store.dispatch('highlightObject', {
						objectId: object.dataset.objectId,
						showTooltip: true,
						hideAllTooltips: true
					});
				}

				document.addEventListener('touchend', openMobileTooltip, { passive: false });
				document.addEventListener('pointerup', openMobileTooltip, false);
				document.addEventListener('click', openMobileTooltip, false);
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_image_map_mobile_tooltips', 99 );
}

if ( ! function_exists( 'hendon_child_nitaq_interest_form_validation' ) ) {
	/**
	 * Field-specific Arabic validation for the Nitaq interest form.
	 */
	function hendon_child_nitaq_interest_form_validation( $result, $tag ) {
		$form = class_exists( 'WPCF7_ContactForm' ) ? WPCF7_ContactForm::get_current() : null;

		if ( ! $form || 260 !== (int) $form->id() ) {
			return $result;
		}

		$name  = $tag->name;
		$value = isset( $_POST[ $name ] ) ? trim( wp_unslash( (string) $_POST[ $name ] ) ) : '';

		if ( 'your-name' === $name && '' === $value ) {
			$result->invalidate( $tag, 'يرجى إدخال الاسم الكامل.' );
		}

		if ( 'your-phone' === $name ) {
			if ( '' === $value || ! preg_match( '/^\+?[0-9\s\-\(\)]{7,20}$/', $value ) ) {
				$result->invalidate( $tag, 'يرجى إدخال رقم الجوال.' );
			}
		}

		if ( 'your-email' === $name ) {
			if ( '' === $value || ! is_email( $value ) ) {
				$result->invalidate( $tag, 'يرجى إدخال بريد إلكتروني صحيح.' );
			}
		}

		if ( 'your-message' === $name && '' === $value ) {
			$result->invalidate( $tag, 'يرجى كتابة رسالتك.' );
		}

		return $result;
	}

	add_filter( 'wpcf7_validate_text*', 'hendon_child_nitaq_interest_form_validation', 5, 2 );
	add_filter( 'wpcf7_validate_tel*', 'hendon_child_nitaq_interest_form_validation', 5, 2 );
	add_filter( 'wpcf7_validate_email*', 'hendon_child_nitaq_interest_form_validation', 5, 2 );
	add_filter( 'wpcf7_validate_textarea*', 'hendon_child_nitaq_interest_form_validation', 5, 2 );
}

if ( ! function_exists( 'hendon_child_nitaq_interest_form_feedback' ) ) {
	/**
	 * Keep AJAX validation messages specific after Contact Form 7 builds its response.
	 */
	function hendon_child_nitaq_interest_form_feedback( $response, $result ) {
		if ( empty( $response['contact_form_id'] ) || 260 !== (int) $response['contact_form_id'] ) {
			return $response;
		}

		if ( empty( $response['invalid_fields'] ) || ! is_array( $response['invalid_fields'] ) ) {
			return $response;
		}

		$messages = array(
			'your-name'    => 'يرجى إدخال الاسم الكامل.',
			'your-phone'   => 'يرجى إدخال رقم الجوال.',
			'your-email'   => 'يرجى إدخال بريد إلكتروني صحيح.',
			'your-message' => 'يرجى كتابة رسالتك.',
		);

		foreach ( $response['invalid_fields'] as &$field ) {
			if ( ! empty( $field['field'] ) && isset( $messages[ $field['field'] ] ) ) {
				$field['message'] = $messages[ $field['field'] ];
			}
		}

		unset( $field );

		return $response;
	}

	add_filter( 'wpcf7_feedback_response', 'hendon_child_nitaq_interest_form_feedback', 20, 2 );
}
