<?php

require_once get_stylesheet_directory() . '/inc/nitaq-news.php';
require_once get_stylesheet_directory() . '/inc/nitaq-footer-settings.php';
require_once get_stylesheet_directory() . '/inc/nitaq-about-settings.php';
require_once get_stylesheet_directory() . '/inc/nitaq-about-page.php';
require_once get_stylesheet_directory() . '/inc/nitaq-projects.php';
require_once get_stylesheet_directory() . '/inc/nitaq-models.php';

if ( ! function_exists( 'nitaq_enqueue_project_motion' ) ) {
	function nitaq_enqueue_project_motion() {
		if ( ! is_singular( 'nitaq_project' ) && ! is_post_type_archive( 'nitaq_project' ) ) return;
		$js_path = get_stylesheet_directory() . '/assets/js/nitaq-project-motion.js';
		wp_enqueue_script(
			'nitaq-project-motion',
			get_stylesheet_directory_uri() . '/assets/js/nitaq-project-motion.js',
			array(),
			file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0',
			true
		);
	}
	add_action( 'wp_enqueue_scripts', 'nitaq_enqueue_project_motion' );
}

if ( ! function_exists( 'nitaq_enqueue_register_hero' ) ) {
	function nitaq_enqueue_register_hero() {
		if ( ! is_page( 3340 ) ) return;
		wp_enqueue_script(
			'nitaq-register-hero',
			get_stylesheet_directory_uri() . '/assets/js/nitaq-register-hero.js',
			array(),
			'1.0.0',
			true
		);
	}
	add_action( 'wp_enqueue_scripts', 'nitaq_enqueue_register_hero' );
}

if ( ! function_exists( 'nitaq_enqueue_about_motion' ) ) {
	function nitaq_enqueue_about_motion() {
		if ( ! is_page( array( 1172, 'about-us' ) ) ) return;
		$js_path = get_stylesheet_directory() . '/assets/js/nitaq-about-motion.js';
		wp_enqueue_script(
			'nitaq-about-motion',
			get_stylesheet_directory_uri() . '/assets/js/nitaq-about-motion.js',
			array(),
			file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0',
			true
		);
	}
	add_action( 'wp_enqueue_scripts', 'nitaq_enqueue_about_motion' );
}

if ( ! function_exists( 'hendon_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function hendon_child_theme_enqueue_scripts() {
		$main_style = 'hendon-main';
		
		wp_enqueue_style( 'hendon-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ), wp_get_theme()->get( 'Version' ) . '.hero-v2-v23' );
	}
	
	add_action( 'wp_enqueue_scripts', 'hendon_child_theme_enqueue_scripts' );
}

// ── Image quality: keep JPEG at 92 (WP default is 82) ───────────────────────
add_filter( 'jpeg_quality',          fn() => 92 );
add_filter( 'wp_editor_set_quality', fn() => 92 );

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
					'menu_name'          => 'سلايدات الهيرو',
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
			// ── الهوية البصرية ────────────────────────────────────────────────
			'hero_image'           => array( 'label' => 'صورة الخلفية (full-bleed)', 'type' => 'media' ),
			'hero_video'           => array( 'label' => 'فيديو الشريحة (mp4 — اختياري)', 'type' => 'media', 'hint' => 'لو محدد: يُشغَّل بدل الصورة. يُنتقل للتالي عند انتهاء الفيديو.' ),
			'hero_logo'            => array( 'label' => 'شعار المشروع (SVG/PNG، اختياري)', 'type' => 'media' ),
			'hero_project_name'    => array( 'label' => 'اسم المشروع', 'type' => 'text' ),
			'hero_project_city'    => array( 'label' => 'المدينة', 'type' => 'text' ),
			// ── شريط البيانات ──────────────────────────────────────────────────
			'hero_data_location'   => array( 'label' => 'الموقع', 'type' => 'text' ),
			'hero_data_type'       => array( 'label' => 'نوع العقار', 'type' => 'text' ),
			'hero_data_units'      => array( 'label' => 'عدد الوحدات (اختياري)', 'type' => 'text' ),
			'hero_button_link'     => array( 'label' => 'رابط «اكتشف»', 'type' => 'url' ),
			// ── الإعدادات ─────────────────────────────────────────────────────
			'hero_overlay_opacity' => array( 'label' => 'شفافية الطبقة الداكنة (0–1)', 'type' => 'number_step' ),
			'hero_slide_order'     => array( 'label' => 'ترتيب الشريحة', 'type' => 'number' ),
			'hero_is_active'       => array( 'label' => 'تفعيل الشريحة', 'type' => 'checkbox' ),
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
	// @deprecated — v1 legacy render, never invoked.
	// Replaced by v2 definition appended at end of file (grep: nhv2-admin-meta).
	function hendon_child_render_nitaq_hero_slide_meta_box_v1_legacy( $post ) {
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
(function($){
  function nhv2Prev(t,u){
    var w=$('#'+t).closest('.nhv2-mf');
    var img=w.find('.nhv2-mpi');
    var clr=w.find('.nhv2-clr');
    if(u){img.attr('src',u).show();clr.show();}
    else{img.attr('src','').hide();clr.hide();}
  }
  $(document).on('click','.nhv2-pick',function(e){
    e.preventDefault();
    var t=$(this).data('t');
    var frame=wp.media({title:'اختيار الصورة',button:{text:'استخدام هذه الصورة'},multiple:false});
    frame.on('select',function(){
      var f=frame.state().get('selection').first().toJSON();
      $('#'+t).val(f.url).trigger('change');
      nhv2Prev(t,f.url);
    });
    frame.open();
  });
  $(document).on('click','.nhv2-clr',function(e){
    e.preventDefault();
    var t=$(this).data('t');
    $('#'+t).val('').trigger('change');
    nhv2Prev(t,'');
  });
})(jQuery);
JS
		);
	}

	add_action( 'admin_enqueue_scripts', 'hendon_child_nitaq_hero_admin_assets' );
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
		
<script>
(function(){
  var s=document.querySelector('.nitaq-groves');
  if(!s)return;
  var items=s.querySelectorAll('.nitaq-groves__reveal');
  if(!items.length)return;
  var reduce=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(reduce||!('IntersectionObserver' in window))return;
  s.classList.add('nitaq-groves--js');
  items.forEach(function(el,i){el.style.transitionDelay=(i*130)+'ms';});
  var io=new IntersectionObserver(function(ents){
    ents.forEach(function(e){if(e.isIntersecting){e.target.classList.add('is-in');io.unobserve(e.target);}});
  },{threshold:0.18});
  items.forEach(function(el){io.observe(el);});
  setTimeout(function(){items.forEach(function(el){el.classList.add('is-in');});},2600);
})();
</script>
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

		echo do_shortcode( '[nitaq_hero_v2]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'hendon_action_before_page_inner', 'hendon_child_nitaq_front_page_video_hero', 4 );
}

if ( ! function_exists( 'hendon_child_nitaq_stats_items' ) ) {
	/**
	 * Statistics displayed on the homepage.
	 */
	function hendon_child_nitaq_stats_items() {
		return array(
			array(
				'number' => '340119',
				'unit'   => 'م²',
				'label'  => 'مساحة المشروع',
				'prefix' => '',
			),
			array(
				'number' => '455',
				'unit'   => '',
				'label'  => 'وحدة سكنية (فيلا)',
				'prefix' => '',
			),
			array(
				'number' => '200',
				'unit'   => 'م²',
				'label'  => 'مساحات الأراضي',
				'prefix' => 'من ',
			),
		);
	}
}

if ( ! function_exists( 'hendon_child_nitaq_hero_stats_separator_markup' ) ) {
	/**
	 * Calm visual bridge between the hero video and homepage statistics.
	 */
	function hendon_child_nitaq_hero_stats_separator_markup() {
		ob_start();
		?>
		<div class="nitaq-hero-stats-separator" dir="rtl" aria-hidden="true">
			<div class="nitaq-hero-stats-separator__inner">
				<span class="nitaq-hero-stats-separator__line"></span>
				<span class="nitaq-hero-stats-separator__text">نطاق عمراني يرتقي بتفاصيل الحياة</span>
				<span class="nitaq-hero-stats-separator__line"></span>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_stats_markup' ) ) {
	/**
	 * Render the custom Nitaq statistics section.
	 */
	function hendon_child_nitaq_stats_markup() {
		ob_start();
		?>
		<section class="ncs2" dir="rtl" aria-label="<?php echo esc_attr__( 'Nitaq company section', 'hendon' ); ?>">

			<!-- Image column (left in RTL) -->
			<div class="ncs2__image-col" aria-hidden="true">
				<img
					src="https://nitaq-re.com/wp-content/uploads/2026/05/nitaq-hero-5-scaled.jpg"
					alt=""
					class="ncs2__img"
					loading="lazy"
					decoding="async"
				>
			</div>

			<!-- Content column (right in RTL) -->
			<div class="ncs2__content-col">

				<span class="ncs2__kicker">عن نطاق الأولى</span>

				<h2 class="ncs2__headline">نطوّر مجتمعات سكنية تنبض بالحياة</h2>

				<p class="ncs2__desc">شركة رائدة في التطوير العقاري الفاخر بالمنطقة الشرقية، تجمع بين الاستدامة والجودة في كل تفصيل من تفاصيل الحياة.</p>

				<p class="ncs2__tagline">WHERE LUXURY MEETS SUSTAINABILITY</p>

				<!-- Stats 2×2 grid -->
				<div class="ncs2__grid" role="list">

					<div class="ncs2__stat" role="listitem">
						<span class="ncs2__numline">
							<span class="ncs2__stat-num" dir="ltr" data-nitaq-stat="340119">340,119</span>
							<span class="ncs2__stat-unit">م²</span>
						</span>
						<span class="ncs2__stat-label">مساحة مشروع ذا جروفز</span>
					</div>

					<div class="ncs2__stat" role="listitem">
						<span class="ncs2__stat-num" dir="ltr" data-nitaq-stat="455">455</span>
						<span class="ncs2__stat-unit"></span>
						<span class="ncs2__stat-label">فيلا في ذا جروفز</span>
					</div>

					<div class="ncs2__stat" role="listitem">
						<span class="ncs2__stat-num">نمطان سكنيان</span>
						<span class="ncs2__stat-unit"></span>
						<span class="ncs2__stat-label">فيورا وأورين بتصاميم عصرية تلائم أسلوب حياة العائلة</span>
					</div>

					<div class="ncs2__stat" role="listitem">
						<span class="ncs2__numline">
							<span class="ncs2__stat-num" dir="ltr" data-nitaq-stat="15">15</span>
							<span class="ncs2__stat-unit">دقيقة</span>
						</span>
						<span class="ncs2__stat-label">من جسر الملك فهد</span>
					</div>

				</div><!-- /.ncs2__grid -->

				<div class="ncs2__cta">
					<a href="/about-us/" class="ncs2__btn">المزيد عن نطاق الأولى &#x2190;</a>
				</div>

			</div><!-- /.ncs2__content-col -->

		</section><!-- /.ncs2 -->
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_stats_shortcode' ) ) {
	/**
	 * Shortcode for the custom statistics section.
	 */
	function hendon_child_nitaq_stats_shortcode() {
		return hendon_child_nitaq_stats_markup();
	}

	add_shortcode( 'nitaq_stats', 'hendon_child_nitaq_stats_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_front_page_stats' ) ) {
	/**
	 * Render the replacement statistics section below the homepage hero.
	 */
	function hendon_child_nitaq_front_page_stats() {
		if ( ! is_front_page() ) {
			return;
		}

		echo hendon_child_nitaq_stats_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'hendon_action_before_page_inner', 'hendon_child_nitaq_front_page_stats', 5 );
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

if ( ! function_exists( 'hendon_child_nitaq_stats_script' ) ) {
	/**
	 * Count-up animation for the custom stats section and safe old-stats hiding.
	 */
	function hendon_child_nitaq_stats_script() {
		if ( ! is_front_page() ) {
			return;
		}
		?>
		<script>
			(function () {
				function initNitaqStats() {
					var section = document.querySelector('.nitaq-stats');
					var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

					function hideOldStatsSection() {
						var root = document.querySelector('body.home #qodef-page-inner');
						var oldValues = ['9.3', '877', '4', '10'];

						if (!root) {
							return;
						}

						Array.prototype.slice.call(root.querySelectorAll('.elementor-section, section, .e-con, .elementor-container, .qodef-row-grid-section')).forEach(function (candidate) {
							var text = candidate.textContent || '';
							var matches = oldValues.filter(function (value) {
								return new RegExp('(^|[^\\d.])' + value.replace('.', '\\.') + '([^\\d.]|$)').test(text);
							}).length;

							if (matches >= 3 && !candidate.closest('.nitaq-stats') && !candidate.querySelector('.nitaq-stats')) {
								candidate.classList.add('nitaq-old-stats-hidden');
							}
						});
					}

					function formatValue(value, decimals) {
						var str = decimals > 0 ? value.toFixed(decimals) : String(Math.round(value));
						return str.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
					}

					function animateNumber(element) {
						if (!element || element.dataset.nitaqCounted === 'true') {
							return;
						}

						var finalText = element.dataset.nitaqStat || element.textContent.trim();
						var finalValue = parseFloat(finalText);
						var decimals = finalText.indexOf('.') > -1 ? finalText.split('.')[1].length : 0;
						var duration = 1500;
						var startTime = null;

						if (!isFinite(finalValue)) {
							return;
						}

						if (reducedMotion) {
							element.textContent = finalText;
							element.dataset.nitaqCounted = 'true';
							return;
						}

						element.classList.add('is-counting');

						function tick(timestamp) {
							if (!startTime) {
								startTime = timestamp;
							}

							var progress = Math.min((timestamp - startTime) / duration, 1);
							var eased = 1 - Math.pow(1 - progress, 3);
							element.textContent = formatValue(finalValue * eased, decimals);

							if (progress < 1) {
								window.requestAnimationFrame(tick);
							} else {
								element.textContent = formatValue(parseFloat(finalText), decimals);
								element.classList.remove('is-counting');
								element.dataset.nitaqCounted = 'true';
							}
						}

						window.requestAnimationFrame(tick);
					}

					hideOldStatsSection();

					if (!section || section.dataset.nitaqStatsReady === 'true') {
						return;
					}

					section.dataset.nitaqStatsReady = 'true';

					if (reducedMotion || !('IntersectionObserver' in window)) {
						Array.prototype.slice.call(section.querySelectorAll('.nitaq-stats__number')).forEach(animateNumber);
						return;
					}

					var observer = new IntersectionObserver(function (entries) {
						entries.forEach(function (entry) {
							if (entry.isIntersecting) {
								Array.prototype.slice.call(section.querySelectorAll('.nitaq-stats__number')).forEach(animateNumber);
								section.classList.add('is-visible');
								observer.unobserve(section);
							}
						});
					}, {
						threshold: 0.32,
						rootMargin: '0px 0px -10% 0px'
					});

					observer.observe(section);
				}

				document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', initNitaqStats) : initNitaqStats();
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_nitaq_stats_script', 96 );
}

if ( ! function_exists( 'hendon_child_ncs2_countup_script' ) ) {
	/**
	 * Count-up animation for the .ncs2 stats section.
	 * Targets .ncs2__stat-num[data-nitaq-stat] — separate from the legacy
	 * .nitaq-stats counter which targets a different section entirely.
	 * Uses data-nitaq-stat for raw numeric values (handles "340,119" correctly).
	 * Respects prefers-reduced-motion: shows final value instantly.
	 */
	function hendon_child_ncs2_countup_script() {
		if ( ! is_front_page() ) {
			return;
		}
		?>
		<script>
			(function () {
				function initNcs2CountUp() {
					var section = document.querySelector('.ncs2');
					if ( !section || section.dataset.ncs2CountupReady === 'true' ) { return; }
					section.dataset.ncs2CountupReady = 'true';

					var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

					function formatNum(n) {
						return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
					}

					function animateNum(el) {
						var raw = el.dataset.nitaqStat;
						if ( !raw ) { return; }
						var target = parseFloat(raw);
						if ( !isFinite(target) ) { return; }
						if ( reducedMotion ) {
							el.textContent = formatNum(target);
							return;
						}
						var start = null;
						var dur = 1600;
						el.classList.add('is-counting');
						function tick(ts) {
							if ( !start ) { start = ts; }
							var p = Math.min((ts - start) / dur, 1);
							var e = 1 - Math.pow(1 - p, 3); // ease-out cubic
							el.textContent = formatNum(target * e);
							if ( p < 1 ) {
								requestAnimationFrame(tick);
							} else {
								el.textContent = formatNum(target);
								el.classList.remove('is-counting');
								el.dataset.ncs2Done = 'true';
							}
						}
						requestAnimationFrame(tick);
					}

					function runAll() {
						var nums = section.querySelectorAll('.ncs2__stat-num[data-nitaq-stat]');
						Array.prototype.slice.call(nums).forEach(function (el) {
							if ( !el.dataset.ncs2Done ) { animateNum(el); }
						});
					}

					if ( !('IntersectionObserver' in window) || reducedMotion ) {
						runAll();
						return;
					}

					new IntersectionObserver(function (entries, obs) {
						entries.forEach(function (entry) {
							if ( entry.isIntersecting ) {
								runAll();
								section.classList.add('ncs2--visible');
								obs.unobserve(section);
							}
						});
					}, { threshold: 0.25 }).observe(section);
				}

				document.readyState === 'loading'
					? document.addEventListener('DOMContentLoaded', initNcs2CountUp)
					: initNcs2CountUp();
			})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_ncs2_countup_script', 97 );
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

// 301 redirect: /chelsea/ -> /projects/the-groves/
add_action( 'template_redirect', function () {
	if ( is_admin() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? strtok( $_SERVER['REQUEST_URI'], '?' ) : '';

	if ( untrailingslashit( $request_uri ) === '/chelsea' ) {
		wp_safe_redirect( home_url( '/projects/the-groves/' ), 301 );
		exit;
	}
} );

if ( ! function_exists( 'hendon_child_nitaq_groves_section' ) ) {
	function hendon_child_nitaq_groves_section() {
		if ( ! is_front_page() ) {
			return;
		}
		?>
<section class="nitaq-groves" aria-labelledby="nitaq-groves-title" dir="rtl">
  <span class="nitaq-groves__corner nitaq-groves__corner--tr" aria-hidden="true"></span>
  <span class="nitaq-groves__corner nitaq-groves__corner--tl" aria-hidden="true"></span>
  <span class="nitaq-groves__corner nitaq-groves__corner--br" aria-hidden="true"></span>
  <span class="nitaq-groves__corner nitaq-groves__corner--bl" aria-hidden="true"></span>
  <div class="nitaq-groves__inner">
    <div class="nitaq-groves__topbar">
      <div class="nitaq-groves__kicker nitaq-groves__reveal"><span class="nitaq-groves__kicker-line"></span><span>THE GROVES</span><span class="nitaq-groves__kicker-line"></span></div>
      <div class="nitaq-groves__loc nitaq-groves__reveal">العزيزية، الخبر</div>
    </div>
    <h2 id="nitaq-groves-title" class="nitaq-groves__title nitaq-groves__reveal">ذا جروفز</h2>
    <span class="nitaq-groves__rule nitaq-groves__reveal"></span>
    <div class="nitaq-groves__subtitle nitaq-groves__reveal"><span>مجتمع سكني فاخر ضمن وجهة لازورد · تطوير نطاق الأولى</span></div>
    <p class="nitaq-groves__lede nitaq-groves__reveal">حيث يلتقي السكن بالطبيعة والرفاهية على نسيم الخليج العربي — تصاميم معاصرة مستوحاة من روح الخبر، ومرافق متكاملة على بُعد خطوات، في وجهة تتجاوز مفهوم الحي السكني.</p>
    <div class="nitaq-groves__divider"></div>
    <div class="nitaq-groves__label nitaq-groves__reveal">أنماط السكن في ذا جروفز</div>
    <?php echo nitaq_model_cpt_cards_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    <div class="nitaq-groves__cta nitaq-groves__reveal">
      <a class="nitaq-groves__btn" href="/projects/the-groves/">اكتشف المشروع
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
      </a>
      <span class="nitaq-groves__cta-note">على نسيم الخليج، بين جسر الملك فهد وجامعة الأمير محمد بن فهد</span>
    </div>
  </div>
</section>
		<?php
	}

	add_action( 'hendon_action_before_page_inner', 'hendon_child_nitaq_groves_section', 6 );
}


// ═══════════════════════════════════════════════════════════════════════════
// NITAQ HERO V2 — Retal-style cinematic gallery  (Phase 2a)
// ═══════════════════════════════════════════════════════════════════════════

if ( ! function_exists( 'hendon_child_required_nitaq_hero_v2_slides' ) ) {
	/**
	 * Slide data for the v2 cinematic hero.
	 * hero_image / hero_logo: placeholders — swap once real assets are uploaded.
	 */
	function hendon_child_required_nitaq_hero_v2_slides() {
		return array(
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/higher-resolution.png',
				'hero_logo'            => '',
				'hero_overlay_opacity' => '0.38',
				'hero_data_location'   => 'حي العزيزية، الخبر',
				'hero_data_type'       => 'فلل + تاون هاوس',
				'hero_data_units'      => '455 وحدة',
				'hero_project_name'    => 'ذا جروفز',
				'hero_project_city'    => 'الخبر',
				'hero_button_link'     => '/projects/',
			),
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/theRoverPicturesSM.png',
				'hero_logo'            => '',
				'hero_overlay_opacity' => '0.40',
				'hero_data_location'   => 'الخبر',
				'hero_data_type'       => 'وجهة متكاملة',
				'hero_data_units'      => '+3.9 مليون م²',
				'hero_project_name'    => 'لازورد',
				'hero_project_city'    => 'الخبر',
				'hero_button_link'     => '/projects/',
			),
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/Fronthousing.png',
				'hero_logo'            => '',
				'hero_overlay_opacity' => '0.42',
				'hero_data_location'   => 'الخبر',
				'hero_data_type'       => 'مجتمع سكني',
				'hero_data_units'      => '',
				'hero_project_name'    => 'لازورد',
				'hero_project_city'    => 'الخبر',
				'hero_button_link'     => '/projects/',
			),
		);
	}
}

if ( ! function_exists( 'hendon_child_nitaq_hero_v2_markup' ) ) {
	/**
	 * Render the v2 cinematic hero gallery.
	 */
	function hendon_child_nitaq_hero_v2_markup() {
		$slides = hendon_child_get_nitaq_hero_v2_slides();
		ob_start();
		?>
		<section class="nitaq-hero-v2" dir="rtl" data-interval="6000" aria-label="<?php esc_attr_e( 'معرض الهيرو', 'hendon' ); ?>">
			<?php foreach ( $slides as $index => $slide ) :
				$active  = 0 === $index ? ' is-active' : '';
				$overlay = isset( $slide['hero_overlay_opacity'] ) ? (float) $slide['hero_overlay_opacity'] : 0.38;
			?>
			<div class="nhv2-slide<?php echo esc_attr( $active ); ?>" data-index="<?php echo esc_attr( $index ); ?>">

				<?php if ( ! empty( $slide['hero_video'] ) ) : ?>
				<video class="nhv2-bg nhv2-bg--video"
					src="<?php echo esc_url( $slide['hero_video'] ); ?>"
					autoplay muted playsinline preload="auto"
					<?php if ( ! empty( $slide['hero_image'] ) ) : ?>poster="<?php echo esc_url( $slide['hero_image'] ); ?>"<?php endif; ?>
					aria-label="<?php echo esc_attr( $slide['hero_project_name'] ); ?>"
				></video>
				<?php else : ?>
				<div class="nhv2-bg"
					style="background-image: url('<?php echo esc_url( $slide['hero_image'] ); ?>');"
					role="img"
					aria-label="<?php echo esc_attr( $slide['hero_project_name'] ); ?>"></div>
				<?php endif; ?>

				<div class="nhv2-overlay" style="--nhv2-overlay: <?php echo esc_attr( $overlay ); ?>;"></div>

				<div class="nhv2-databar">
					<?php if ( ! empty( $slide['hero_data_location'] ) ) : ?>
					<div class="nhv2-data-item nhv2-location">
						<span class="nhv2-data-label">الموقع</span>
						<span class="nhv2-data-value"><?php echo esc_html( $slide['hero_data_location'] ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $slide['hero_data_type'] ) ) : ?>
					<div class="nhv2-data-item nhv2-type">
						<span class="nhv2-data-label">النوع</span>
						<span class="nhv2-data-value"><?php echo esc_html( $slide['hero_data_type'] ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $slide['hero_data_units'] ) ) : ?>
					<div class="nhv2-data-item nhv2-units">
						<span class="nhv2-data-label">الوحدات</span>
						<span class="nhv2-data-value"><?php echo esc_html( $slide['hero_data_units'] ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $slide['hero_button_link'] ) ) : ?>
					<a href="<?php echo esc_url( $slide['hero_button_link'] ); ?>" class="nhv2-cta">اكتشف &#x2190;</a>
					<?php endif; ?>
				</div>

				<div class="nhv2-lockup">
					<?php if ( ! empty( $slide['hero_logo'] ) ) : ?>
						<img class="nhv2-logo"
							src="<?php echo esc_url( $slide['hero_logo'] ); ?>"
							alt="<?php echo esc_attr( $slide['hero_project_name'] ); ?>">
					<?php else : ?>
						<span class="nhv2-project-name"><?php echo esc_html( $slide['hero_project_name'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $slide['hero_project_city'] ) ) : ?>
						<span class="nhv2-city"><?php echo esc_html( $slide['hero_project_city'] ); ?></span>
					<?php endif; ?>
				</div>

			</div>
			<?php endforeach; ?>

			<?php if ( count( $slides ) > 1 ) : ?>
			<div class="nhv2-thumbs" aria-hidden="true">
				<?php foreach ( $slides as $index => $slide ) : ?>
				<button
					type="button"
					class="nhv2-thumb <?php echo 0 === $index ? 'is-active' : ''; ?>"
					data-slide-to="<?php echo esc_attr( $index ); ?>"
					style="background-image: url('<?php echo esc_url( $slide['hero_image'] ); ?>');"
					aria-label="<?php echo esc_attr( 'شريحة ' . ( $index + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<?php if ( count( $slides ) > 1 ) : ?>
			<div class="nhv2-dots" aria-label="<?php esc_attr_e( 'التنقل بين الشرائح', 'hendon' ); ?>">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<button
						type="button"
						class="<?php echo 0 === $index ? 'is-active' : ''; ?>"
						data-slide-to="<?php echo esc_attr( $index ); ?>"
						aria-label="<?php echo esc_attr( 'شريحة ' . ( $index + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

		</section>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'hendon_child_nitaq_hero_v2_shortcode' ) ) {
	/**
	 * [nitaq_hero_v2] shortcode.
	 */
	function hendon_child_nitaq_hero_v2_shortcode() {
		return hendon_child_nitaq_hero_v2_markup();
	}

	add_shortcode( 'nitaq_hero_v2', 'hendon_child_nitaq_hero_v2_shortcode' );
}

if ( ! function_exists( 'hendon_child_nitaq_hero_v2_script' ) ) {
	/**
	 * Lightweight JS slider for the v2 hero.
	 * prefers-reduced-motion: disables autoplay.
	 * Thumbnails sync: reserved for Phase 2b.
	 */
	function hendon_child_nitaq_hero_v2_script() {
		?>
		<script>
		(function () {
			function initNitaqHeroV2(slider) {
				if (!slider || slider.dataset.nhv2Ready === 'true') { return; }

				var slides        = Array.prototype.slice.call(slider.querySelectorAll('.nhv2-slide'));
				var dots          = Array.prototype.slice.call(slider.querySelectorAll('.nhv2-dots button'));
				var thumbs        = Array.prototype.slice.call(slider.querySelectorAll('.nhv2-thumb'));
				var reduced       = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

				if (!slides.length) { return; }

				var current       = Math.max(0, slides.findIndex(function (s) { return s.classList.contains('is-active'); }));
				var autoplayTimer = null;
				var playGen       = 0;   // invalidates stale video callbacks on slide change
				var paused        = false;
				var interval      = parseInt(slider.dataset.interval || '6000', 10);

				// ── Schedule next slide (video-aware) ───────────────────────
				function scheduleNext() {
					if (reduced || slides.length < 2) { return; }
					clearTimeout(autoplayTimer);
					var gen = ++playGen;
					var vid = slides[current].querySelector('.nhv2-bg--video');
					if (vid) {
						vid.currentTime = 0;
						vid.addEventListener('ended', function onEnded() {
							vid.removeEventListener('ended', onEnded);
							if (gen === playGen) { show(current + 1); }
						});
						vid.play().catch(function () {
							// Autoplay blocked — fall back to timer
							autoplayTimer = window.setTimeout(function () {
								if (gen === playGen && !paused) { show(current + 1); }
							}, interval);
						});
					} else {
						autoplayTimer = window.setTimeout(function () {
							if (gen === playGen && !paused) { show(current + 1); }
						}, interval);
					}
				}

				// ── Activate a slide ──────────────────────────────────────────
				function show(index) {
					var prev = current;
					current = (index + slides.length) % slides.length;

					// Stop previous video (if any)
					clearTimeout(autoplayTimer);
					if (prev !== current) {
						var prevVid = slides[prev].querySelector('.nhv2-bg--video');
						if (prevVid) { prevVid.pause(); prevVid.currentTime = 0; }
					}

					slides.forEach(function (s, i) {
						s.classList.toggle('is-active', i === current);
					});
					dots.forEach(function (d, i) {
						d.classList.toggle('is-active', i === current);
						d.setAttribute('aria-current', i === current ? 'true' : 'false');
					});
					thumbs.forEach(function (t, i) {
						t.classList.toggle('is-active', i === current);
					});

					scheduleNext();
				}

				// ── Navigation clicks ─────────────────────────────────────
				function onNavClick(targetIndex) {
					paused = true;
					show(targetIndex);
					window.setTimeout(function () {
						paused = false;
						// Image slides need timer restart after pause; video already playing
						if (!slides[current].querySelector('.nhv2-bg--video')) { scheduleNext(); }
					}, interval);
				}

				dots.forEach(function (dot) {
					dot.addEventListener('click', function () {
						onNavClick(parseInt(dot.dataset.slideTo || '0', 10));
					});
				});

				thumbs.forEach(function (thumb) {
					thumb.addEventListener('click', function () {
						onNavClick(parseInt(thumb.dataset.slideTo || '0', 10));
					});
				});

				// ── Hover / focus pause ───────────────────────────────────
				['mouseenter', 'focusin', 'touchstart', 'pointerdown'].forEach(function (ev) {
					slider.addEventListener(ev, function () { paused = true; }, { passive: true });
				});
				['mouseleave', 'focusout', 'touchend', 'pointerup'].forEach(function (ev) {
					slider.addEventListener(ev, function () {
						window.setTimeout(function () {
							paused = false;
							// Restart image timer if current slide has no video
							if (!slides[current].querySelector('.nhv2-bg--video')) { scheduleNext(); }
						}, 1800);
					}, { passive: true });
				});

				// ── Transparent nav on home page ────────────────────────────────
				if (document.body.classList.contains('home')) {
					var onNavScroll = function () {
						document.body.classList.toggle('nitaq-header-scrolled', window.scrollY > 60);
					};
					window.addEventListener('scroll', onNavScroll, { passive: true });
					onNavScroll();
				}

				slider.dataset.nhv2Ready = 'true';
				show(current);
			}

			function initAll() {
				Array.prototype.slice.call(
					document.querySelectorAll('.nitaq-hero-v2')
				).forEach(initNitaqHeroV2);
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initAll);
			} else {
				initAll();
			}
		})();
		</script>
		<?php
	}

	add_action( 'wp_footer', 'hendon_child_nitaq_hero_v2_script', 99 );
}


// ══════════════════════════════════════════════════════════════════════════════
// HERO V2 — CPT DASHBOARD WIRING
// render meta box · get_v2_slides · seed_v2
// ══════════════════════════════════════════════════════════════════════════════

if ( ! function_exists( 'hendon_child_render_nitaq_hero_slide_meta_box' ) ) {
	/**
	 * v2 admin meta box — three groups: visual · databar · settings.
	 * Image fields include WP Media Uploader + live preview + clear button.
	 * Marker: nhv2-admin-meta (grep to find this definition).
	 */
	function hendon_child_render_nitaq_hero_slide_meta_box( $post ) {
		wp_nonce_field( 'nitaq_hero_slide_meta', 'nitaq_hero_slide_meta_nonce' );

		$all_fields = hendon_child_nitaq_hero_slide_meta_fields();

		$groups = array(
			array(
				'label' => '🖼 الهوية البصرية',
				'keys'  => array( 'hero_image', 'hero_video', 'hero_logo', 'hero_project_name', 'hero_project_city' ),
			),
			array(
				'label' => '📊 شريط البيانات',
				'keys'  => array( 'hero_data_location', 'hero_data_type', 'hero_data_units', 'hero_button_link' ),
			),
			array(
				'label' => '⚙️ الإعدادات',
				'keys'  => array( 'hero_overlay_opacity', 'hero_slide_order', 'hero_is_active' ),
			),
		);

		$num_defaults = array( 'hero_overlay_opacity' => '0.38', 'hero_slide_order' => '1' );
		?>
		<div class="nhv2-admin-meta" dir="rtl" style="padding:8px 2px 4px;">
			<?php foreach ( $groups as $group ) : ?>
			<h3 style="margin:18px 0 10px;padding:7px 12px;background:#f8f9fa;border-right:3px solid #B8AA76;font-size:13px;font-weight:600;border-radius:2px;"><?php echo esc_html( $group['label'] ); ?></h3>
			<div style="padding:0 6px 4px;">
				<?php foreach ( $group['keys'] as $key ) :
					if ( ! isset( $all_fields[ $key ] ) ) { continue; }
					$field = $all_fields[ $key ];
					$value = get_post_meta( $post->ID, $key, true );
					if ( '' === $value && isset( $num_defaults[ $key ] ) ) {
						$value = $num_defaults[ $key ];
					}
				?>
				<p style="margin:0 0 14px;display:grid;gap:5px;">
					<label for="<?php echo esc_attr( $key ); ?>" style="font-weight:600;font-size:12px;color:#444;"><?php echo esc_html( $field['label'] ); ?></label>

					<?php if ( 'checkbox' === $field['type'] ) : ?>
						<label style="display:flex;align-items:center;gap:8px;">
							<input id="<?php echo esc_attr( $key ); ?>" type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $value, '1' ); ?>>
							<span style="font-size:13px;">تفعيل — يظهر في الهيرو</span>
						</label>

					<?php elseif ( 'media' === $field['type'] ) : ?>
						<div class="nhv2-mf">
							<div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
								<input id="<?php echo esc_attr( $key ); ?>" type="url" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_url( $value ); ?>" style="flex:1;min-width:200px;direction:ltr;text-align:left;font-size:12px;" placeholder="https://">
								<button type="button" class="button nhv2-pick" data-t="<?php echo esc_attr( $key ); ?>">📂 اختر</button>
								<button type="button" class="button nhv2-clr" data-t="<?php echo esc_attr( $key ); ?>" style="<?php echo $value ? '' : 'display:none;'; ?>color:#b32d2e;">✕ إزالة</button>
							</div>
							<img class="nhv2-mpi" src="<?php echo esc_url( $value ); ?>" style="<?php echo $value ? 'display:block;' : 'display:none;'; ?>max-width:260px;max-height:150px;margin-top:8px;border:1px solid #ddd;border-radius:4px;object-fit:cover;">
						</div>

					<?php elseif ( 'url' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="url" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_url( $value ); ?>" style="width:100%;direction:ltr;text-align:left;">

					<?php elseif ( 'number_step' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="number" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" min="0" max="1" step="0.01" style="width:120px;">

					<?php elseif ( 'number' === $field['type'] ) : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="number" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" min="0" step="1" style="width:120px;">

					<?php else : ?>
						<input id="<?php echo esc_attr( $key ); ?>" type="text" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;direction:rtl;text-align:right;">
					<?php endif; ?>
				</p>
				<?php endforeach; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hendon_child_get_nitaq_hero_v2_slides' ) ) {
	/**
	 * Read active v2 hero slides from CPT, ordered by hero_slide_order.
	 * Falls back to hendon_child_required_nitaq_hero_v2_slides() when no
	 * published+active slides exist (safe fallback — never breaks the page).
	 */
	function hendon_child_get_nitaq_hero_v2_slides() {
		$keys = array_keys( hendon_child_nitaq_hero_slide_meta_fields() );

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
				'meta_key'   => 'hero_slide_order',
				'orderby'    => array(
					'meta_value_num' => 'ASC',
					'menu_order'     => 'ASC',
					'date'           => 'ASC',
				),
				'order' => 'ASC',
			)
		);

		$slides = array();

		foreach ( $query->posts as $post ) {
			$slide = array();
			foreach ( $keys as $key ) {
				$slide[ $key ] = get_post_meta( $post->ID, $key, true );
			}
			$slide['post_id'] = $post->ID;
			$slides[]         = $slide;
		}

		wp_reset_postdata();

		// Fallback: no published/active CPT slides → use hardcoded defaults.
		if ( empty( $slides ) ) {
			return hendon_child_required_nitaq_hero_v2_slides();
		}

		return $slides;
	}
}

if ( ! function_exists( 'hendon_child_seed_nitaq_hero_v2_slides' ) ) {
	/**
	 * Seed v2 meta on the existing three CPT posts (3348/3352/3353).
	 * Runs once (guarded by option). Updates existing posts — never duplicates.
	 * If the three posts don't exist (fresh install), creates them instead.
	 */
	function hendon_child_seed_nitaq_hero_v2_slides() {
		if ( '1' === get_option( 'nitaq_hero_v2_seeded' ) ) {
			return;
		}

		$v2_data = array(
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/higher-resolution.png',
				'hero_logo'            => '',
				'hero_project_name'    => 'ذا جروفز',
				'hero_project_city'    => 'الخبر',
				'hero_data_location'   => 'حي العزيزية، الخبر',
				'hero_data_type'       => 'فلل + تاون هاوس',
				'hero_data_units'      => '455 وحدة',
				'hero_button_link'     => '/projects/',
				'hero_overlay_opacity' => '0.38',
				'hero_slide_order'     => '1',
				'hero_is_active'       => '1',
			),
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/theRoverPicturesSM.png',
				'hero_logo'            => '',
				'hero_project_name'    => 'لازورد',
				'hero_project_city'    => 'الخبر',
				'hero_data_location'   => 'الخبر',
				'hero_data_type'       => 'وجهة متكاملة',
				'hero_data_units'      => '+3.9 مليون م²',
				'hero_button_link'     => '/projects/',
				'hero_overlay_opacity' => '0.40',
				'hero_slide_order'     => '2',
				'hero_is_active'       => '1',
			),
			array(
				'hero_image'           => 'https://nitaq-re.com/wp-content/uploads/2026/05/Fronthousing.png',
				'hero_logo'            => '',
				'hero_project_name'    => 'لازورد',
				'hero_project_city'    => 'الخبر',
				'hero_data_location'   => 'الخبر',
				'hero_data_type'       => 'مجتمع سكني',
				'hero_data_units'      => '',
				'hero_button_link'     => '/projects/',
				'hero_overlay_opacity' => '0.42',
				'hero_slide_order'     => '3',
				'hero_is_active'       => '1',
			),
		);

		// Get existing CPT posts ordered oldest-first (matches the 3 known posts).
		$existing = get_posts(
			array(
				'post_type'      => 'nitaq_hero_slide',
				'post_status'    => 'any',
				'posts_per_page' => 3,
				'orderby'        => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
				'meta_key'       => 'hero_slide_order',
				'order'          => 'ASC',
			)
		);

		foreach ( $v2_data as $i => $meta ) {
			if ( isset( $existing[ $i ] ) ) {
				// Update existing post — set v2 meta without duplicating.
				$pid = $existing[ $i ]->ID;
			} else {
				// Fresh install: create a new post.
				$pid = wp_insert_post(
					array(
						'post_title'  => $meta['hero_project_name'],
						'post_type'   => 'nitaq_hero_slide',
						'post_status' => 'publish',
						'menu_order'  => (int) $meta['hero_slide_order'],
					)
				);
				if ( is_wp_error( $pid ) ) {
					continue;
				}
			}

			foreach ( $meta as $key => $value ) {
				update_post_meta( $pid, $key, $value );
			}
		}

		update_option( 'nitaq_hero_v2_seeded', '1', false );
	}

	add_action( 'init', 'hendon_child_seed_nitaq_hero_v2_slides', 16 );
}
