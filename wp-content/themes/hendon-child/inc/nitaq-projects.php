<?php
/**
 * Nitaq Projects — Custom Post Type, Meta Boxes, Shortcodes
 *
 * Post type:   nitaq_project
 * Archive:     /projects/
 * Shortcodes:  [nitaq_project_page], [nitaq_projects_grid]
 * Single:      single-nitaq_project.php (child theme root)
 */

// ═══════════════════════════════════════════════════════════════════
// 1. CUSTOM POST TYPE
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_project_register_cpt' ) ) {
	function nitaq_project_register_cpt() {
		$labels = array(
			'name'               => 'المشاريع',
			'singular_name'      => 'مشروع',
			'menu_name'          => 'المشاريع',
			'add_new'            => 'إضافة مشروع',
			'add_new_item'       => 'إضافة مشروع جديد',
			'edit_item'          => 'تعديل المشروع',
			'new_item'           => 'مشروع جديد',
			'view_item'          => 'عرض المشروع',
			'all_items'          => 'كل المشاريع',
			'search_items'       => 'بحث في المشاريع',
			'not_found'          => 'لا توجد مشاريع',
			'not_found_in_trash' => 'لا توجد مشاريع في المهملات',
		);
		register_post_type( 'nitaq_project', array(
			'labels'          => $labels,
			'public'          => true,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-building',
			'menu_position'   => 26,
			'supports'        => array( 'title', 'thumbnail', 'excerpt' ),
			'has_archive'     => 'projects',
			'rewrite'         => array( 'slug' => 'projects', 'with_front' => false ),
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		) );
	}
	add_action( 'init', 'nitaq_project_register_cpt' );
}

// Flush rewrite rules once so /projects/ and /projects/slug/ work immediately
if ( ! function_exists( 'nitaq_project_flush_rewrite_once' ) ) {
	function nitaq_project_flush_rewrite_once() {
		if ( get_option( 'nitaq_project_cpt_flushed_v1' ) ) {
			return;
		}
		flush_rewrite_rules( false );
		update_option( 'nitaq_project_cpt_flushed_v1', 1, false );
	}
	add_action( 'init', 'nitaq_project_flush_rewrite_once', 99 );
}

// ═══════════════════════════════════════════════════════════════════
// 2. META FIELD DEFINITIONS
// ═══════════════════════════════════════════════════════════════════

function nitaq_project_meta_sections() {
	return array(
		'hero' => array(
			'label'  => 'قسم الهيرو',
			'fields' => array(
				'hero_kicker'    => array( 'label' => 'الكيكر (النص الصغير فوق العنوان)', 'type' => 'text' ),
				'hero_h1'        => array( 'label' => 'العنوان الرئيسي H1', 'type' => 'text' ),
				'hero_h2'        => array( 'label' => 'العنوان الثانوي H2', 'type' => 'text' ),
				'hero_body'      => array( 'label' => 'الفقرة', 'type' => 'textarea' ),
				'hero_image'     => array( 'label' => 'صورة الخلفية', 'type' => 'image' ),
				'hero_btn_label' => array( 'label' => 'نص الزر', 'type' => 'text' ),
				'hero_btn_url'   => array( 'label' => 'رابط الزر', 'type' => 'url' ),
				'hero_video_webm' => array( 'label' => 'فيديو الهيرو (WebM URL)', 'type' => 'url' ),
			),
		),
		'intro' => array(
			'label'  => 'قسم المقدمة',
			'fields' => array(
				'intro_kicker'  => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'intro_h2'      => array( 'label' => 'العنوان', 'type' => 'text' ),
				'intro_lead'    => array( 'label' => 'الفقرة الأولى', 'type' => 'textarea' ),
				'intro_body2'   => array( 'label' => 'الفقرة الثانية (اختياري)', 'type' => 'textarea' ),
				'intro_image'   => array( 'label' => 'الصورة', 'type' => 'image' ),
				'intro_img_alt' => array( 'label' => 'النص البديل للصورة', 'type' => 'text' ),
			),
		),
		'stats' => array(
			'label'  => 'قسم الأرقام',
			'fields' => array(
				'stats_kicker' => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'stats_h2'     => array( 'label' => 'العنوان', 'type' => 'text' ),
				'stats_lead'   => array( 'label' => 'وصف قصير', 'type' => 'text' ),
				'stat1_num'    => array( 'label' => 'رقم 1 — القيمة', 'type' => 'text' ),
				'stat1_unit'   => array( 'label' => 'رقم 1 — الوحدة', 'type' => 'text' ),
				'stat1_cap'    => array( 'label' => 'رقم 1 — التسمية', 'type' => 'text' ),
				'stat2_num'    => array( 'label' => 'رقم 2 — القيمة', 'type' => 'text' ),
				'stat2_unit'   => array( 'label' => 'رقم 2 — الوحدة', 'type' => 'text' ),
				'stat2_cap'    => array( 'label' => 'رقم 2 — التسمية', 'type' => 'text' ),
				'stat3_num'    => array( 'label' => 'رقم 3 — القيمة', 'type' => 'text' ),
				'stat3_unit'   => array( 'label' => 'رقم 3 — الوحدة', 'type' => 'text' ),
				'stat3_cap'    => array( 'label' => 'رقم 3 — التسمية', 'type' => 'text' ),
				'stat4_num'    => array( 'label' => 'رقم 4 — القيمة', 'type' => 'text' ),
				'stat4_unit'   => array( 'label' => 'رقم 4 — الوحدة', 'type' => 'text' ),
				'stat4_cap'    => array( 'label' => 'رقم 4 — التسمية', 'type' => 'text' ),
			),
		),
		'cards' => array(
			'label'  => 'بطاقات القيمة',
			'fields' => array(
				'card1_kicker' => array( 'label' => 'بطاقة 1 — الكيكر', 'type' => 'text' ),
				'card1_h2'     => array( 'label' => 'بطاقة 1 — العنوان', 'type' => 'text' ),
				'card1_body'   => array( 'label' => 'بطاقة 1 — النص', 'type' => 'textarea' ),
				'card2_kicker' => array( 'label' => 'بطاقة 2 — الكيكر', 'type' => 'text' ),
				'card2_h2'     => array( 'label' => 'بطاقة 2 — العنوان', 'type' => 'text' ),
				'card2_body'   => array( 'label' => 'بطاقة 2 — النص', 'type' => 'textarea' ),
			),
		),
		'location' => array(
			'label'  => 'قسم الموقع',
			'fields' => array(
				'loc_kicker'  => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'loc_h2'      => array( 'label' => 'العنوان', 'type' => 'text' ),
				'loc_lead'    => array( 'label' => 'الفقرة الأولى', 'type' => 'textarea' ),
				'loc_body2'   => array( 'label' => 'الفقرة الثانية (اختياري)', 'type' => 'textarea' ),
				'loc_image'   => array( 'label' => 'الصورة', 'type' => 'image' ),
				'loc_img_alt' => array( 'label' => 'النص البديل', 'type' => 'text' ),
			),
		),
		'masterplan' => array(
			'label'  => 'المخطط العام',
			'fields' => array(
				'plan_kicker'  => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'plan_h2'      => array( 'label' => 'العنوان', 'type' => 'text' ),
				'plan_body'    => array( 'label' => 'النص', 'type' => 'textarea' ),
				'plan_image'   => array( 'label' => 'الصورة الكبيرة', 'type' => 'image' ),
				'plan_img_alt' => array( 'label' => 'النص البديل', 'type' => 'text' ),
			),
		),
		'models' => array(
			'label'  => 'النماذج السكنية',
			'fields' => array(
				'models_kicker' => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'models_h2'     => array( 'label' => 'العنوان', 'type' => 'text' ),
				'model1_image'  => array( 'label' => 'نموذج 1 — الصورة', 'type' => 'image' ),
				'model1_alt'    => array( 'label' => 'نموذج 1 — النص البديل', 'type' => 'text' ),
				'model1_h3'     => array( 'label' => 'نموذج 1 — الاسم', 'type' => 'text' ),
				'model1_body'   => array( 'label' => 'نموذج 1 — الوصف', 'type' => 'textarea' ),
				'model2_image'  => array( 'label' => 'نموذج 2 — الصورة', 'type' => 'image' ),
				'model2_alt'    => array( 'label' => 'نموذج 2 — النص البديل', 'type' => 'text' ),
				'model2_h3'     => array( 'label' => 'نموذج 2 — الاسم', 'type' => 'text' ),
				'model2_body'   => array( 'label' => 'نموذج 2 — الوصف', 'type' => 'textarea' ),
			),
		),
		'architecture' => array(
			'label'  => 'المعمار والتصميم',
			'fields' => array(
				'arch_kicker'  => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'arch_h2'      => array( 'label' => 'العنوان', 'type' => 'text' ),
				'arch_lead'    => array( 'label' => 'الفقرة الأولى', 'type' => 'textarea' ),
				'arch_body2'   => array( 'label' => 'الفقرة الثانية (اختياري)', 'type' => 'textarea' ),
				'arch_image'   => array( 'label' => 'الصورة', 'type' => 'image' ),
				'arch_img_alt' => array( 'label' => 'النص البديل', 'type' => 'text' ),
			),
		),
		'lifestyle' => array(
			'label'  => 'أسلوب الحياة والمرافق',
			'fields' => array(
				'life_kicker'   => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'life_h2'       => array( 'label' => 'العنوان', 'type' => 'text' ),
				'life_img1'     => array( 'label' => 'الصورة 1', 'type' => 'image' ),
				'life_img1_alt' => array( 'label' => 'الصورة 1 — النص البديل', 'type' => 'text' ),
				'life_img2'     => array( 'label' => 'الصورة 2', 'type' => 'image' ),
				'life_img2_alt' => array( 'label' => 'الصورة 2 — النص البديل', 'type' => 'text' ),
				'amenity1'      => array( 'label' => 'ميزة 1', 'type' => 'text' ),
				'amenity2'      => array( 'label' => 'ميزة 2', 'type' => 'text' ),
				'amenity3'      => array( 'label' => 'ميزة 3', 'type' => 'text' ),
				'amenity4'      => array( 'label' => 'ميزة 4', 'type' => 'text' ),
				'amenity5'      => array( 'label' => 'ميزة 5', 'type' => 'text' ),
				'amenity6'      => array( 'label' => 'ميزة 6', 'type' => 'text' ),
			),
		),
		'cta' => array(
			'label'  => 'الدعوة للتصرف (CTA)',
			'fields' => array(
				'cta_kicker'    => array( 'label' => 'الكيكر', 'type' => 'text' ),
				'cta_h2'        => array( 'label' => 'العنوان', 'type' => 'text' ),
				'cta_body'      => array( 'label' => 'النص', 'type' => 'textarea' ),
				'cta_btn_label' => array( 'label' => 'نص الزر', 'type' => 'text' ),
				'cta_btn_url'   => array( 'label' => 'رابط الزر', 'type' => 'url' ),
				'cta_bg_image'  => array( 'label' => 'صورة الخلفية (اختياري)', 'type' => 'image' ),
			),
		),
	);
}

// ═══════════════════════════════════════════════════════════════════
// 3. ADMIN: ENQUEUE MEDIA UPLOADER
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_project_admin_enqueue' ) ) {
	function nitaq_project_admin_enqueue( $hook ) {
		global $post;
		if ( ( 'post.php' !== $hook && 'post-new.php' !== $hook )
			|| ! isset( $post )
			|| 'nitaq_project' !== $post->post_type ) {
			return;
		}
		wp_enqueue_media();
		// Inline JS — single-quoted PHP string, no PHP variable interpolation
		wp_add_inline_script( 'jquery-core', '
(function($){
  $(document).on("click", ".nitaq-proj-media-btn", function(e){
    e.preventDefault();
    var target = $(this).data("target");
    var frame = wp.media({title: "اختيار صورة", button: {text: "اختيار"}, multiple: false});
    frame.on("select", function(){
      var att = frame.state().get("selection").first().toJSON();
      $("#" + target).val(att.url);
      var prev = $("#" + target + "_preview");
      if(prev.length){ prev.attr("src", att.url).show(); }
    });
    frame.open();
  });
})(jQuery);
' );
	}
	add_action( 'admin_enqueue_scripts', 'nitaq_project_admin_enqueue' );
}

// ═══════════════════════════════════════════════════════════════════
// 4. META BOXES
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_project_add_meta_boxes' ) ) {
	function nitaq_project_add_meta_boxes() {
		add_meta_box(
			'nitaq_project_details',
			'تفاصيل المشروع',
			'nitaq_project_render_meta_box',
			'nitaq_project',
			'normal',
			'high'
		);
	}
	add_action( 'add_meta_boxes', 'nitaq_project_add_meta_boxes' );
}

if ( ! function_exists( 'nitaq_project_render_meta_box' ) ) {
	function nitaq_project_render_meta_box( $post ) {
		wp_nonce_field( 'nitaq_project_meta_save', 'nitaq_project_meta_nonce' );
		$sections = nitaq_project_meta_sections();
		?>
		<style>
		.nitaq-proj-meta { direction: rtl; font-family: 'Tahoma', 'Arial', sans-serif; }
		.nitaq-proj-meta details { margin-bottom: 12px; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; }
		.nitaq-proj-meta summary {
			background: #0F302D; color: #B8AA76; padding: 10px 16px;
			cursor: pointer; font-size: 14px; font-weight: 600; list-style: none;
			display: flex; align-items: center; gap: 8px;
		}
		.nitaq-proj-meta summary::-webkit-details-marker { display: none; }
		.nitaq-proj-meta summary::before { content: '▶'; font-size: 10px; transition: transform 0.2s; }
		.nitaq-proj-meta details[open] summary::before { transform: rotate(90deg); }
		.nitaq-proj-section-inner { padding: 16px; background: #fafafa; }
		.nitaq-proj-field { margin-bottom: 14px; }
		.nitaq-proj-field label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px; color: #333; }
		.nitaq-proj-field input[type="text"],
		.nitaq-proj-field input[type="url"],
		.nitaq-proj-field textarea {
			width: 100%; padding: 7px 10px; border: 1px solid #ccc; border-radius: 4px;
			font-size: 14px; direction: rtl; font-family: inherit; box-sizing: border-box;
		}
		.nitaq-proj-field textarea { height: 80px; resize: vertical; }
		.nitaq-proj-field input[type="url"] { direction: ltr; text-align: left; }
		.nitaq-proj-image-row { display: flex; align-items: center; gap: 10px; }
		.nitaq-proj-image-row input { flex: 1; }
		.nitaq-proj-img-preview {
			max-height: 60px; max-width: 100px; border-radius: 4px;
			border: 1px solid #ddd; display: block; margin-top: 6px;
		}
		.nitaq-proj-meta details[open] { border-color: #B8AA76; }
		</style>
		<div class="nitaq-proj-meta">
		<?php foreach ( $sections as $section_key => $section ) : ?>
			<details <?php echo ( 'hero' === $section_key ) ? 'open' : ''; ?>>
				<summary><?php echo esc_html( $section['label'] ); ?></summary>
				<div class="nitaq-proj-section-inner">
				<?php foreach ( $section['fields'] as $field_key => $field ) :
					$value = get_post_meta( $post->ID, '_nitaq_proj_' . $field_key, true );
					$input_id = 'nitaq_proj_' . $field_key;
				?>
					<div class="nitaq-proj-field">
						<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
						<?php if ( 'textarea' === $field['type'] ) : ?>
							<textarea id="<?php echo esc_attr( $input_id ); ?>"
								name="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
						<?php elseif ( 'image' === $field['type'] ) : ?>
							<div class="nitaq-proj-image-row">
								<input type="text" id="<?php echo esc_attr( $input_id ); ?>"
									name="<?php echo esc_attr( $input_id ); ?>"
									value="<?php echo esc_url( $value ); ?>"
									placeholder="https://">
								<button type="button" class="button nitaq-proj-media-btn"
									data-target="<?php echo esc_attr( $input_id ); ?>">اختيار</button>
							</div>
							<?php if ( $value ) : ?>
								<img id="<?php echo esc_attr( $input_id ); ?>_preview"
									src="<?php echo esc_url( $value ); ?>"
									class="nitaq-proj-img-preview" alt="">
							<?php else : ?>
								<img id="<?php echo esc_attr( $input_id ); ?>_preview"
									src="" class="nitaq-proj-img-preview" alt=""
									style="display:none;">
							<?php endif; ?>
						<?php elseif ( 'url' === $field['type'] ) : ?>
							<input type="text" id="<?php echo esc_attr( $input_id ); ?>"
								name="<?php echo esc_attr( $input_id ); ?>"
								value="<?php echo esc_attr( $value ); ?>"
								placeholder="/contact-us/ أو https://">
						<?php else : ?>
							<input type="text" id="<?php echo esc_attr( $input_id ); ?>"
								name="<?php echo esc_attr( $input_id ); ?>"
								value="<?php echo esc_attr( $value ); ?>">
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
				</div>
			</details>
		<?php endforeach; ?>
		</div>
		<?php
	}
}

// ═══════════════════════════════════════════════════════════════════
// 5. SAVE META
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_project_save_meta' ) ) {
	function nitaq_project_save_meta( $post_id ) {
		if ( ! isset( $_POST['nitaq_project_meta_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nitaq_project_meta_nonce'] ) ), 'nitaq_project_meta_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$sections = nitaq_project_meta_sections();
		foreach ( $sections as $section ) {
			foreach ( $section['fields'] as $field_key => $field ) {
				$input_name = 'nitaq_proj_' . $field_key;
				if ( ! isset( $_POST[ $input_name ] ) ) {
					continue;
				}
				$raw = wp_unslash( $_POST[ $input_name ] );
				if ( 'url' === $field['type'] || 'image' === $field['type'] ) {
					$value = nitaq_project_sanitize_url( $raw );
				} elseif ( 'textarea' === $field['type'] ) {
					$value = sanitize_textarea_field( $raw );
				} else {
					$value = sanitize_text_field( $raw );
				}
				update_post_meta( $post_id, '_nitaq_proj_' . $field_key, $value );
			}
		}
	}
	add_action( 'save_post_nitaq_project', 'nitaq_project_save_meta' );
}

// Auto-set qodef display meta so every new project looks correct immediately
if ( ! function_exists( 'nitaq_project_set_display_meta' ) ) {
	function nitaq_project_set_display_meta( $post_id, $post, $update ) {
		if ( 'nitaq_project' !== $post->post_type ) {
			return;
		}
		// Only set on first save; subsequent edits leave the meta untouched
		if ( $update && '' !== get_post_meta( $post_id, 'qodef_enable_page_title', true ) ) {
			return;
		}
		$defaults = array(
			'qodef_enable_page_title'               => 'no',
			'qodef_divided_header_background_color' => 'rgba(0,0,0,0)',
			'qodef_content_behind_header'           => 'yes',
			'qodef_header_layout'                   => 'divided',
			'qodef_header_skin'                     => 'light',
			'qodef_page_content_padding'            => '0 0 0 0',
			'qodef_page_content_padding_mobile'     => '0 0 0 0',
			'qodef_page_background_color'           => '#000000',
			'qodef_enable_page_footer'              => 'yes',
			'qodef_top_footer_area_background_color'    => '#000000',
			'qodef_bottom_footer_area_background_color' => '#000000',
		);
		foreach ( $defaults as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}
	add_action( 'wp_insert_post', 'nitaq_project_set_display_meta', 10, 3 );
}

// ═══════════════════════════════════════════════════════════════════
// 6. URL SANITIZER
// ═══════════════════════════════════════════════════════════════════

function nitaq_project_sanitize_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	// Allow relative URLs starting with /
	if ( '/' === substr( $url, 0, 1 ) ) {
		return preg_replace( '/[^a-zA-Z0-9\-._~:/?#\[\]@!$&\'()*+,;=%]/', '', $url );
	}
	// Allow tel: and mailto:
	if ( 0 === strncasecmp( $url, 'tel:', 4 ) || 0 === strncasecmp( $url, 'mailto:', 7 ) ) {
		return esc_url_raw( $url );
	}
	// Block dangerous protocols
	$protocol = strtolower( explode( ':', $url )[0] );
	if ( in_array( $protocol, array( 'javascript', 'data', 'vbscript' ), true ) ) {
		return '';
	}
	return esc_url_raw( $url );
}

// ═══════════════════════════════════════════════════════════════════
// 7. DATA GETTER
// ═══════════════════════════════════════════════════════════════════

function nitaq_project_get_data( $post_id ) {
	$sections = nitaq_project_meta_sections();
	$data     = array( 'post_id' => $post_id );
	foreach ( $sections as $section ) {
		foreach ( $section['fields'] as $field_key => $field ) {
			$data[ $field_key ] = get_post_meta( $post_id, '_nitaq_proj_' . $field_key, true );
		}
	}
	return $data;
}

// ═══════════════════════════════════════════════════════════════════
// 8. PROJECT RENDERER
// ═══════════════════════════════════════════════════════════════════

/**
 * Reusable: render the .nitaq-project-models section from the nitaq_model CPT.
 *
 * Queries published nitaq_model posts ordered date ASC (preserves admin order).
 * Each card carries data-attributes for plan URL and floors JSON so the
 * nitaq-models-explorer.js can read them without hardcoded lookup maps.
 *
 * @param string $kicker  Optional kicker text above the heading.
 * @param string $heading Optional section heading h2.
 * @return string HTML — the complete section, or '' if no models published.
 */
/**
 * Returns ONLY the .nitaq-project-grid.nitaq-project-models card grid,
 * with all data-attributes the explorer JS reads.
 * Reusable on any page: project page, homepage Groves section, etc.
 * Returns '' if no nitaq_model posts are published.
 */
function nitaq_model_cpt_cards_markup() {
	$query = new WP_Query( array(
		'post_type'      => 'nitaq_model',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC',
	) );

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '';
	}

	ob_start();
	?>
		<div class="nitaq-project-grid nitaq-project-models">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$mid        = get_the_ID();
				$title      = get_the_title();
				$render_url = get_post_meta( $mid, '_nitaq_model_render',      true );
				$render_alt = get_post_meta( $mid, '_nitaq_model_render_alt',  true );
				$body       = get_post_meta( $mid, '_nitaq_model_body',        true );
				$plan_url   = get_post_meta( $mid, '_nitaq_model_plan',        true );
				$floors_raw = get_post_meta( $mid, '_nitaq_model_floors',      true );
				$model_type = get_post_meta( $mid, '_nitaq_model_type',        true );
				$land_area  = get_post_meta( $mid, '_nitaq_model_land_area',   true );
				$built_area = get_post_meta( $mid, '_nitaq_model_built_area',  true );

				// Decode floors and re-encode for esc_attr safety:
				// json_decode → PHP array → wp_json_encode with UNESCAPED_UNICODE
				// so Arabic text stays readable; esc_attr handles the HTML quoting.
				$floors_decoded = json_decode( $floors_raw, true );
				$floors_attr    = esc_attr(
					wp_json_encode(
						is_array( $floors_decoded ) ? $floors_decoded : array(),
						JSON_UNESCAPED_UNICODE
					)
				);
			?>
			<article class="nitaq-project-model-card"
				data-plan-url="<?php echo esc_url( $plan_url ); ?>"
				data-floors="<?php echo $floors_attr; ?>"
				data-type="<?php echo esc_attr( $model_type ); ?>"
				data-land="<?php echo esc_attr( $land_area ); ?>"
				data-built="<?php echo esc_attr( $built_area ); ?>">
				<?php if ( $render_url ) : ?>
				<img src="<?php echo esc_url( $render_url ); ?>"
					alt="<?php echo esc_attr( $render_alt ); ?>"
					loading="lazy">
				<?php endif; ?>
				<div>
					<h3><?php echo esc_html( $title ); ?></h3>
					<?php if ( $body ) : ?>
					<p><?php echo esc_html( $body ); ?></p>
					<?php endif; ?>
				</div>
			</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div><!-- /.nitaq-project-models -->
	<?php
	return ob_get_clean();
}

/**
 * Wraps nitaq_model_cpt_cards_markup() in the project-page section shell
 * (.nitaq-project-section--light + optional kicker/h2).
 * Project-page output is identical to before the refactor.
 */
function nitaq_model_cpt_explorer_markup( $kicker = '', $heading = '' ) {
	// Section wrapper removed — returns the card grid directly.
	return nitaq_model_cpt_cards_markup();
}

function nitaq_project_render( $post_id ) {
	$d = nitaq_project_get_data( $post_id );

	// CTA background style
	$cta_style = '';
	if ( ! empty( $d['cta_bg_image'] ) ) {
		$cta_style = ' style="background-image:url(' . esc_url( $d['cta_bg_image'] ) . ');"';
	}

	ob_start();
	?>
<main class="nitaq-project-page" dir="rtl">

	<!-- HERO -->
	<section class="nitaq-project-hero">
		<?php if ( ! empty( $d['hero_image'] ) ) : ?>
		<img class="nitaq-project-hero__image"
			src="<?php echo esc_url( $d['hero_image'] ); ?>"
			alt="<?php echo esc_attr( $d['hero_h1'] ); ?>">
		<?php endif; ?>
		<?php if ( ! empty( $d['hero_video_webm'] ) ) : ?>
		<video class="nitaq-project-hero__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
			<source src="<?php echo esc_url( $d['hero_video_webm'] ); ?>" type="video/webm">
		</video>
		<?php endif; ?>
		<div class="nitaq-project-hero__overlay"></div>
		<div class="nitaq-project-hero__content">
			<?php if ( ! empty( $d['hero_kicker'] ) ) : ?>
			<p class="nitaq-project-kicker"><?php echo esc_html( $d['hero_kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['hero_h1'] ) ) : ?>
			<h1><?php echo esc_html( $d['hero_h1'] ); ?></h1>
			<?php endif; ?>
			<?php if ( ! empty( $d['hero_h2'] ) ) : ?>
			<h2><?php echo esc_html( $d['hero_h2'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $d['hero_body'] ) ) : ?>
			<p><?php echo esc_html( $d['hero_body'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['hero_btn_label'] ) && ! empty( $d['hero_btn_url'] ) ) : ?>
			<a class="nitaq-project-btn" href="<?php echo esc_url( $d['hero_btn_url'] ); ?>">
				<?php echo esc_html( $d['hero_btn_label'] ); ?>
			</a>
			<?php endif; ?>
		</div>
	</section>

	<!-- INTRO -->
	<section class="nitaq-project-section nitaq-project-intro">
		<div class="nitaq-project-grid nitaq-project-grid--split">
			<div>
				<?php if ( ! empty( $d['intro_kicker'] ) ) : ?>
				<p class="nitaq-project-kicker"><?php echo esc_html( $d['intro_kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['intro_h2'] ) ) : ?>
				<h2><?php echo esc_html( $d['intro_h2'] ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $d['intro_lead'] ) ) : ?>
				<p class="nitaq-project-lead"><?php echo esc_html( $d['intro_lead'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['intro_body2'] ) ) : ?>
				<p><?php echo esc_html( $d['intro_body2'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $d['intro_image'] ) ) : ?>
			<figure class="nitaq-project-media">
				<img src="<?php echo esc_url( $d['intro_image'] ); ?>"
					alt="<?php echo esc_attr( $d['intro_img_alt'] ); ?>"
					loading="lazy">
			</figure>
			<?php endif; ?>
		</div>
	</section>

	<!-- STATS -->
	<?php if ( ! empty( $d['stat1_num'] ) || ! empty( $d['stat2_num'] ) || ! empty( $d['stat3_num'] ) || ! empty( $d['stat4_num'] ) ) : ?>
	<section class="nitaq-project-section nitaq-project-stats">
		<div class="nitaq-project-stats__head">
			<?php if ( ! empty( $d['stats_kicker'] ) ) : ?>
			<p class="nitaq-project-kicker nitaq-project-stats__kicker"><?php echo esc_html( $d['stats_kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['stats_h2'] ) ) : ?>
			<h2><?php echo esc_html( $d['stats_h2'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $d['stats_lead'] ) ) : ?>
			<p class="nitaq-project-lead nitaq-project-stats__lead"><?php echo esc_html( $d['stats_lead'] ); ?></p>
			<?php endif; ?>
		</div>
		<div class="nitaq-project-stats__row">
			<?php for ( $i = 1; $i <= 4; $i++ ) :
				$num = $d[ 'stat' . $i . '_num' ];
				if ( empty( $num ) ) { continue; }
				$unit = $d[ 'stat' . $i . '_unit' ];
				$cap  = $d[ 'stat' . $i . '_cap' ];
			?>
			<div class="nitaq-project-stats__cell">
				<div class="nitaq-project-stats__value"><span class="nitaq-stat-num" data-final="<?php echo esc_attr( $num ); ?>"><?php echo esc_html( $num ); ?></span></div>
				<?php if ( ! empty( $unit ) ) : ?><div class="nitaq-project-stats__unit"><?php echo esc_html( $unit ); ?></div><?php endif; ?>
				<?php if ( ! empty( $cap ) ) : ?><div class="nitaq-project-stats__cap"><?php echo esc_html( $cap ); ?></div><?php endif; ?>
			</div>
			<?php endfor; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- VALUE CARDS -->
	<?php if ( ! empty( $d['card1_h2'] ) || ! empty( $d['card2_h2'] ) ) : ?>
	<section class="nitaq-project-section nitaq-project-section--light">
		<div class="nitaq-project-grid nitaq-project-grid--two">
			<article class="nitaq-project-text-card">
				<?php if ( ! empty( $d['card1_kicker'] ) ) : ?>
				<p class="nitaq-project-kicker"><?php echo esc_html( $d['card1_kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['card1_h2'] ) ) : ?>
				<h2><?php echo esc_html( $d['card1_h2'] ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $d['card1_body'] ) ) : ?>
				<p><?php echo esc_html( $d['card1_body'] ); ?></p>
				<?php endif; ?>
			</article>
			<article class="nitaq-project-text-card">
				<?php if ( ! empty( $d['card2_kicker'] ) ) : ?>
				<p class="nitaq-project-kicker"><?php echo esc_html( $d['card2_kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['card2_h2'] ) ) : ?>
				<h2><?php echo esc_html( $d['card2_h2'] ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $d['card2_body'] ) ) : ?>
				<p><?php echo esc_html( $d['card2_body'] ); ?></p>
				<?php endif; ?>
			</article>
		</div>
	</section>
	<?php endif; ?>

	<!-- LOCATION -->
	<?php if ( ! empty( $d['loc_h2'] ) ) : ?>
	<section class="nitaq-project-section">
		<div class="nitaq-project-grid nitaq-project-grid--split nitaq-project-grid--reverse">
			<?php if ( ! empty( $d['loc_image'] ) ) : ?>
			<figure class="nitaq-project-media">
				<img src="<?php echo esc_url( $d['loc_image'] ); ?>"
					alt="<?php echo esc_attr( $d['loc_img_alt'] ); ?>"
					loading="lazy">
			</figure>
			<?php endif; ?>
			<div>
				<?php if ( ! empty( $d['loc_kicker'] ) ) : ?>
				<p class="nitaq-project-kicker"><?php echo esc_html( $d['loc_kicker'] ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $d['loc_h2'] ); ?></h2>
				<?php if ( ! empty( $d['loc_lead'] ) ) : ?>
				<p class="nitaq-project-lead"><?php echo esc_html( $d['loc_lead'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['loc_body2'] ) ) : ?>
				<p><?php echo esc_html( $d['loc_body2'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- MASTERPLAN -->
	<?php if ( ! empty( $d['plan_h2'] ) || ! empty( $d['plan_image'] ) ) : ?>
	<section class="nitaq-project-section nitaq-project-masterplan">
		<div class="nitaq-project-section-head">
			<?php if ( ! empty( $d['plan_kicker'] ) ) : ?>
			<p class="nitaq-project-kicker"><?php echo esc_html( $d['plan_kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['plan_h2'] ) ) : ?>
			<h2><?php echo esc_html( $d['plan_h2'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $d['plan_body'] ) ) : ?>
			<p><?php echo esc_html( $d['plan_body'] ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $d['plan_image'] ) ) : ?>
		<figure class="nitaq-project-wide-media">
			<img src="<?php echo esc_url( $d['plan_image'] ); ?>"
				alt="<?php echo esc_attr( $d['plan_img_alt'] ); ?>"
				loading="lazy">
		</figure>
		<?php endif; ?>
	</section>
	<?php endif; ?>

	<!-- RESIDENTIAL MODELS — rendered from nitaq_model CPT -->
	<?php
	echo nitaq_model_cpt_explorer_markup(
		$d['models_kicker'] ?? '',
		$d['models_h2']     ?? ''
	);
	?>

	<!-- ARCHITECTURE -->
	<?php if ( ! empty( $d['arch_h2'] ) ) : ?>
	<section class="nitaq-project-section nitaq-project-architecture">
		<div class="nitaq-project-grid nitaq-project-grid--split">
			<div>
				<?php if ( ! empty( $d['arch_kicker'] ) ) : ?>
				<p class="nitaq-project-kicker"><?php echo esc_html( $d['arch_kicker'] ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $d['arch_h2'] ); ?></h2>
				<?php if ( ! empty( $d['arch_lead'] ) ) : ?>
				<p class="nitaq-project-lead"><?php echo esc_html( $d['arch_lead'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $d['arch_body2'] ) ) : ?>
				<p><?php echo esc_html( $d['arch_body2'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $d['arch_image'] ) ) : ?>
			<figure class="nitaq-project-media">
				<img src="<?php echo esc_url( $d['arch_image'] ); ?>"
					alt="<?php echo esc_attr( $d['arch_img_alt'] ); ?>"
					loading="lazy">
			</figure>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- LIFESTYLE / AMENITIES -->
	<?php
	$has_amenities = false;
	for ( $i = 1; $i <= 6; $i++ ) {
		if ( ! empty( $d[ 'amenity' . $i ] ) ) { $has_amenities = true; break; }
	}
	if ( ! empty( $d['life_h2'] ) || $has_amenities ) :
	?>
	<section class="nitaq-project-section nitaq-project-lifestyle">
		<div class="nitaq-project-section-head">
			<?php if ( ! empty( $d['life_kicker'] ) ) : ?>
			<p class="nitaq-project-kicker"><?php echo esc_html( $d['life_kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['life_h2'] ) ) : ?>
			<h2><?php echo esc_html( $d['life_h2'] ); ?></h2>
			<?php endif; ?>
		</div>
		<div class="nitaq-project-grid nitaq-project-grid--split">
			<?php if ( $has_amenities ) : ?>
			<ul class="nitaq-project-amenities">
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<?php if ( ! empty( $d[ 'amenity' . $i ] ) ) : ?>
					<li><?php echo esc_html( $d[ 'amenity' . $i ] ); ?></li>
					<?php endif; ?>
				<?php endfor; ?>
			</ul>
			<?php endif; ?>
			<?php if ( ! empty( $d['life_img1'] ) || ! empty( $d['life_img2'] ) ) : ?>
			<div class="nitaq-project-image-pair">
				<?php if ( ! empty( $d['life_img1'] ) ) : ?>
				<img src="<?php echo esc_url( $d['life_img1'] ); ?>"
					alt="<?php echo esc_attr( $d['life_img1_alt'] ); ?>"
					loading="lazy">
				<?php endif; ?>
				<?php if ( ! empty( $d['life_img2'] ) ) : ?>
				<img src="<?php echo esc_url( $d['life_img2'] ); ?>"
					alt="<?php echo esc_attr( $d['life_img2_alt'] ); ?>"
					loading="lazy">
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- FINAL CTA -->
	<?php if ( ! empty( $d['cta_h2'] ) ) : ?>
	<section class="nitaq-project-section nitaq-project-cta"<?php echo $cta_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div>
			<?php if ( ! empty( $d['cta_kicker'] ) ) : ?>
			<p class="nitaq-project-kicker"><?php echo esc_html( $d['cta_kicker'] ); ?></p>
			<?php endif; ?>
			<h2><?php echo esc_html( $d['cta_h2'] ); ?></h2>
			<?php if ( ! empty( $d['cta_body'] ) ) : ?>
			<p><?php echo esc_html( $d['cta_body'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $d['cta_btn_label'] ) && ! empty( $d['cta_btn_url'] ) ) : ?>
			<a href="<?php echo esc_url( $d['cta_btn_url'] ); ?>" class="nitaq-project-btn">
				<?php echo esc_html( $d['cta_btn_label'] ); ?>
			</a>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

</main>
	<?php
	return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════════
// 9. SHORTCODES
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_project_page_shortcode' ) ) {
	function nitaq_project_page_shortcode( $atts ) {
		$atts = shortcode_atts(
			array( 'id' => '', 'slug' => '' ),
			$atts,
			'nitaq_project_page'
		);

		$post_id = 0;

		if ( ! empty( $atts['id'] ) && is_numeric( $atts['id'] ) ) {
			$post_id = absint( $atts['id'] );
		} elseif ( ! empty( $atts['slug'] ) ) {
			$project = get_page_by_path( sanitize_title( $atts['slug'] ), OBJECT, 'nitaq_project' );
			if ( $project ) {
				$post_id = $project->ID;
			}
		}

		// Fall back to latest published project
		if ( ! $post_id ) {
			$latest = get_posts( array(
				'post_type'      => 'nitaq_project',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			if ( ! empty( $latest ) ) {
				$post_id = $latest[0]->ID;
			}
		}

		if ( ! $post_id ) {
			return '<p style="color:#888;text-align:center;">لا يوجد مشروع منشور حتى الآن.</p>';
		}

		return nitaq_project_render( $post_id );
	}
	add_shortcode( 'nitaq_project_page', 'nitaq_project_page_shortcode' );
}

if ( ! function_exists( 'nitaq_projects_grid_shortcode' ) ) {
	function nitaq_projects_grid_shortcode( $atts ) {
		$atts = shortcode_atts(
			array( 'limit' => '12' ),
			$atts,
			'nitaq_projects_grid'
		);

		$projects = get_posts( array(
			'post_type'      => 'nitaq_project',
			'post_status'    => 'publish',
			'posts_per_page' => absint( $atts['limit'] ),
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
		) );

		if ( empty( $projects ) ) {
			return '<p style="color:#888;text-align:center;">لا توجد مشاريع منشورة حتى الآن.</p>';
		}

		ob_start();
		?>
<section class="nitaq-projects-grid-section" dir="rtl">
	<div class="nitaq-projects-grid">
	<?php foreach ( $projects as $project ) :
		$d          = nitaq_project_get_data( $project->ID );
		$thumb      = ! empty( $d['hero_image'] ) ? $d['hero_image'] : get_the_post_thumbnail_url( $project->ID, 'large' );
		$excerpt    = $project->post_excerpt ? $project->post_excerpt : wp_trim_words( $d['intro_lead'], 20, '…' );
		$link       = get_permalink( $project->ID );
	?>
		<article class="nitaq-project-card">
			<?php if ( $thumb ) : ?>
			<a href="<?php echo esc_url( $link ); ?>" class="nitaq-project-card__image-wrap" aria-hidden="true" tabindex="-1">
				<img src="<?php echo esc_url( $thumb ); ?>"
					alt="<?php echo esc_attr( $project->post_title ); ?>"
					loading="lazy">
			</a>
			<?php endif; ?>
			<div class="nitaq-project-card__body">
				<h3 class="nitaq-project-card__title">
					<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $project->post_title ); ?></a>
				</h3>
				<?php if ( $excerpt ) : ?>
				<p class="nitaq-project-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
				<a href="<?php echo esc_url( $link ); ?>" class="nitaq-project-card__btn">استكشف المشروع</a>
			</div>
		</article>
	<?php endforeach; ?>
	</div>
</section>
		<?php
		return ob_get_clean();
	}
	add_shortcode( 'nitaq_projects_grid', 'nitaq_projects_grid_shortcode' );
}

// ═══════════════════════════════════════════════════════════════════
// ENQUEUE: nitaq-stats count-up JS on single project pages
// ═══════════════════════════════════════════════════════════════════
if ( ! function_exists( 'nitaq_project_enqueue_stats_js' ) ) {
	function nitaq_project_enqueue_stats_js() {
		// 3199 = live Arabic homepage (WP front page is the maintenance page).
		if ( ! is_singular( 'nitaq_project' ) && ! is_front_page() && ! is_page( 3199 ) ) {
			return;
		}
		$js_path = get_stylesheet_directory() . '/assets/js/nitaq-stats.js';
		wp_enqueue_script(
			'nitaq-stats',
			get_stylesheet_directory_uri() . '/assets/js/nitaq-stats.js',
			array(),
			file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0',
			true
		);
	}
	add_action( 'wp_enqueue_scripts', 'nitaq_project_enqueue_stats_js' );
}

// ═══════════════════════════════════════════════════════════════════
// ENQUEUE: models explorer JS + CSS on single project pages
// ═══════════════════════════════════════════════════════════════════
if ( ! function_exists( 'nitaq_project_enqueue_models_explorer' ) ) {
	function nitaq_project_enqueue_models_explorer() {
		$css_path = get_stylesheet_directory() . '/assets/css/nitaq-models-explorer.css';
		$js_path  = get_stylesheet_directory() . '/assets/js/nitaq-models-explorer.js';
		$css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0';
		$js_ver   = file_exists( $js_path )  ? filemtime( $js_path )  : '1.0.0';

		// Register so [nitaq_models_explorer] shortcode can enqueue on demand.
		wp_register_style(
			'nitaq-models-explorer',
			get_stylesheet_directory_uri() . '/assets/css/nitaq-models-explorer.css',
			array(),
			$css_ver
		);
		wp_register_script(
			'nitaq-models-explorer',
			get_stylesheet_directory_uri() . '/assets/js/nitaq-models-explorer.js',
			array(),
			$js_ver,
			true
		);

		// Enqueue immediately: project singles, real front page, or live Arabic homepage.
		// 3199 = live Arabic homepage (body: page-id-3199); is_front_page() stays for future promotion.
		if ( is_singular( 'nitaq_project' ) || is_front_page() || is_page( 3199 ) ) {
			wp_enqueue_style( 'nitaq-models-explorer' );
			wp_enqueue_script( 'nitaq-models-explorer' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'nitaq_project_enqueue_models_explorer' );
}

// ═══════════════════════════════════════════════════════════════════
// SHORTCODE: [nitaq_models_explorer kicker="…" heading="…"]
// Enqueues registered CSS/JS handles on demand, then returns the
// full explorer section via nitaq_model_cpt_explorer_markup().
// Defaults match the heading used on the the-groves project page.
// ═══════════════════════════════════════════════════════════════════
if ( ! function_exists( 'nitaq_models_explorer_shortcode' ) ) {
	function nitaq_models_explorer_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'kicker'  => 'أنماط سكنية',
				'heading' => 'أنماط سكنية تلبي كل أسلوب حياة',
			),
			$atts,
			'nitaq_models_explorer'
		);

		// Pull registered handles into the page output.
		wp_enqueue_style( 'nitaq-models-explorer' );
		wp_enqueue_script( 'nitaq-models-explorer' );

		return nitaq_model_cpt_explorer_markup(
			$atts['kicker'],
			$atts['heading']
		);
	}
	add_shortcode( 'nitaq_models_explorer', 'nitaq_models_explorer_shortcode' );
}
