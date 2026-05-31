<?php
/**
 * Nitaq About Page — Admin Settings
 * Appearance > إعدادات صفحة من نحن
 *
 * Option key: nitaq_about_settings
 */

if ( ! function_exists( 'nitaq_about_defaults' ) ) {

	function nitaq_about_defaults() {
		return array(

			/* ── HERO ── */
			'hero_kicker'       => 'شركة نطاق الأولى للتطوير العقاري',
			'hero_h1'           => 'عن نطاق الأولى',
			'hero_h2'           => "نطوّر وجهات سكنية عصرية\nترتقي بجودة الحياة",
			'hero_body'         => 'نطاق الأولى شركة تطوير عقاري سعودية تبني مجتمعات متكاملة تجمع بين الفخامة، التخطيط الحضري الذكي، المساحات الخضراء، والمرافق الحيوية التي تمنح العائلة أسلوب حياة أكثر راحة واتزانًا.',
			'hero_btn1_label'   => 'استكشف مشاريعنا',
			'hero_btn1_url'     => '/projects/',
			'hero_btn2_label'   => 'سجّل اهتمامك',
			'hero_btn2_url'     => '/register-interest/',
			'hero_image'        => '/wp-content/uploads/2026/05/theWholeProject.png',
			'hero_video_url'    => 'https://nitaq-re.com/wp-content/uploads/2026/05/villa.webm',
			'hero_poster_image' => '/wp-content/uploads/2026/05/theWholeProject.png',
			'hero_metric1_num'  => '3.9+',
			'hero_metric1_unit' => 'مليون م²',
			'hero_metric1_lbl'  => 'مساحة الوجهة',
			'hero_metric2_num'  => '778+',
			'hero_metric2_unit' => 'ألف م²',
			'hero_metric2_lbl'  => 'مساحات خضراء',
			'hero_metric3_num'  => '8,100+',
			'hero_metric3_unit' => '',
			'hero_metric3_lbl'  => 'وحدة سكنية',
			/* Colors — empty = use existing CSS class default */
			'hero_bg_color'      => '',
			'hero_heading_color' => '',
			'hero_text_color'    => '',

			/* ── INTRO (من نحن) ── */
			'intro_kicker'  => 'من نحن',
			'intro_h2'      => 'نطاق الأولى للتطوير العقاري',
			'intro_lead'    => 'نطوّر مجتمعات سكنية عصرية تُصمّم حول الإنسان، وتجمع بين الخصوصية، الطبيعة، وسهولة الوصول إلى تفاصيل الحياة اليومية.',
			'intro_body1'   => 'تعمل نطاق الأولى على بناء أحياء متكاملة ترتقي بجودة الحياة، من خلال تخطيط حضري مبتكر، تنفيذ دقيق، وشراكات موثوقة تعزز ثقة العملاء وتواكب تطلعات المدن السعودية الحديثة.',
			'intro_body2'   => 'نحن لا ننظر إلى المشروع كمساحات ووحدات فقط، بل كوجهة يومية يعيش فيها الإنسان تجربة أكثر هدوءًا وراحة واستدامة.',
			'intro_image'   => '/wp-content/uploads/2026/05/villa4.png',
			'intro_img_alt' => 'واجهة سكنية من مشاريع نطاق الأولى',
			'intro_bg_color'      => '',
			'intro_heading_color' => '',
			'intro_text_color'    => '',

			/* ── SIGNATURE / PHILOSOPHY ── */
			'sig_kicker' => 'فلسفتنا',
			'sig_h2'     => "نحن لا نطوّر مباني فقط.\nنحن نصمّم مجتمعات تُعاش.",
			'sig_body'   => 'كل تفصيلة في مشاريعنا تبدأ من سؤال واحد: كيف نجعل الحياة اليومية أكثر جودة؟',

			/* ── VISION / MISSION ── */
			'vision_kicker'  => 'رؤيتنا',
			'vision_h2'      => 'أحياء متكاملة بقيمة مستدامة',
			'vision_body'    => 'أن نكون من المطورين العقاريين الرائدين في تطوير أحياء سكنية متكاملة تُعرف بجودة التخطيط، راحة العيش، واستدامة القيمة.',
			'mission_kicker' => 'رسالتنا',
			'mission_h2'     => 'الإنسان في قلب التصميم',
			'mission_body'   => 'تطوير مجتمعات سكنية تضع الإنسان في قلب التجربة، وتوفّر بيئة متوازنة تجمع بين الخصوصية، الطبيعة، وسهولة الوصول إلى المرافق والخدمات.',

			/* ── TRILOGY CARD IMAGES & COLORS ── */
			'trilogy_img1'          => 'https://nitaq-re.com/wp-content/uploads/2026/05/villaAbout2.png',
			'trilogy_img2'          => 'https://nitaq-re.com/wp-content/uploads/2026/05/villaAbout3.png',
			'trilogy_img3'          => 'https://nitaq-re.com/wp-content/uploads/2026/05/villa-about4.png',
			'trilogy_bg_color'      => '',
			'trilogy_heading_color' => '',
			'trilogy_text_color'    => '',

			/* ── VALUES ── */
			'values_kicker'   => 'قيمنا',
			'values_h2'       => 'قيم تقود كل تفصيلة',
			'values_subhead'  => 'قيم واضحة تمنح كل مشروع هويته، وتحوّل التخطيط العقاري إلى تجربة حياة متكاملة.',
			'value1_num'      => '01',
			'value1_title'    => 'الجودة',
			'value1_body'     => 'مشاريع مصممة بعناية تجمع بين الدقة، الراحة، والجمال المعماري.',
			'value2_num'      => '02',
			'value2_title'    => 'الاستدامة',
			'value2_body'     => 'بيئات عمرانية تراعي جودة الحياة وتدعم مستقبلًا أكثر توازنًا.',
			'value3_num'      => '03',
			'value3_title'    => 'الثقة',
			'value3_body'     => 'علاقات طويلة الأمد مع العملاء والشركاء عبر الوضوح والالتزام.',
			'value4_num'      => '04',
			'value4_title'    => 'الابتكار',
			'value4_body'     => 'حلول عمرانية حديثة تستلهم هوية المكان وتواكب تطلعات الأسرة السعودية.',
			'values_bg_color'      => '',
			'values_heading_color' => '',
			'values_text_color'    => '',

			/* ── WHY NITAQ ── */
			'why_kicker'   => 'لماذا نطاق الأولى؟',
			'why_h2'       => 'تجربة تطوير تبدأ من جودة الحياة',
			'why_subhead'  => 'نطوّر الوجهات السكنية كبيئات متكاملة، لا كمبانٍ منفصلة.',
			'why_reason1'  => 'تخطيط حضري متكامل',
			'why_reason2'  => 'مجتمعات سكنية عصرية',
			'why_reason3'  => 'مواقع استراتيجية',
			'why_reason4'  => 'جودة حياة أفضل',
			'why_reason5'  => 'شراكات موثوقة',
			'why_reason6'  => 'تصميم يجمع الفخامة بالوظيفة',
			'why_bg_color'      => '',
			'why_heading_color' => '',
			'why_text_color'    => '',

			/* ── GROVES FEATURE ── */
			'groves_kicker'   => 'مشروع ذا جروفز',
			'groves_h2'       => 'نموذج لرؤية نطاق الأولى',
			'groves_lead'     => 'يمثل ذا جروفز نموذجًا عمليًا لرؤية نطاق الأولى في تطوير مجتمعات سكنية متكاملة، حيث يلتقي السكن بالطبيعة والرفاهية وسهولة الوصول.',
			'groves_li1'      => 'ضمن وجهة لازورد في الخبر',
			'groves_li2'      => 'موقع قريب من المرافق اليومية والحيوية',
			'groves_li3'      => 'تجربة سكنية تحاكي نبض البحر وروح الخبر',
			'groves_li4'      => 'بيئة آمنة ومستدامة وحدائق خضراء',
			'groves_li5'      => 'ممرات للمشاة والدراجات ومناطق مفتوحة',
			'groves_li6'      => 'مرافق تعليمية وصحية وتجارية قريبة',
			'groves_btn_label'=> 'استكشف ذا جروفز',
			'groves_btn_url'  => '/projects/the-groves/',
			'groves_image'    => '/wp-content/uploads/2026/05/حياة-تغمرها-الطبيعة.png',
			'groves_img_alt'  => 'مشروع ذا جروفز ضمن وجهة لازورد',
			'groves_bg_color'      => '',
			'groves_heading_color' => '',
			'groves_text_color'    => '',

			/* ── DESTINATION / LAZORD ── */
			'dest_kicker'   => 'وجهة تنبض بالحياة',
			'dest_h2'       => 'لازورد والخبر.. قرب يمنح الحياة اتزانها',
			'dest_body1'    => 'تستمد مشاريع نطاق الأولى روحها من المواقع التي تمنح السكان تجربة معيشية متكاملة. وفي وجهة لازورد، تلتقي الراحة مع قرب الخدمات لتمنح العائلات أسلوب حياة أكثر رفاهية وارتباطًا بالطبيعة.',
			'dest_body2'    => 'بين جسر الملك فهد وكورنيش الخبر وجامعة الأمير محمد بن فهد، تتكامل المساحات الخضراء والمناطق المفتوحة مع المرافق التعليمية والصحية والتجارية لتصنع وجهة يومية أكثر راحة.',
			'dest_image'    => '/wp-content/uploads/2026/05/الموقع-العام-للوجهة.png',
			'dest_img_alt'  => 'وجهة لازورد في الخبر',
			'dest_bg_color'      => '',
			'dest_heading_color' => '',
			'dest_text_color'    => '',

			/* ── STATS ── */
			'stats_kicker'   => 'أرقام وجهة لازورد',
			'stats_h2'       => 'مؤشرات تعكس حجم الوجهة',
			'stats_subhead'  => 'الأرقام التالية مرتبطة بوجهة لازورد ككل، وتوضح حجم البيئة العمرانية التي ينتمي إليها مشروع ذا جروفز.',
			'stat1_num'      => '3.9',
			'stat1_decimals' => '1',
			'stat1_suffix'   => '+ مليون م²',
			'stat1_label'    => 'المساحة الإجمالية',
			'stat2_num'      => '778',
			'stat2_decimals' => '0',
			'stat2_suffix'   => '+ ألف م²',
			'stat2_label'    => 'مساحات خضراء ومناطق مفتوحة',
			'stat3_num'      => '8100',
			'stat3_decimals' => '0',
			'stat3_suffix'   => '+',
			'stat3_label'    => 'وحدة سكنية',
			'stat4_num'      => '19',
			'stat4_decimals' => '0',
			'stat4_suffix'   => '%',
			'stat4_label'    => 'للمسطحات الخضراء والمناطق المفتوحة',
			'stats_bg_color'      => '',
			'stats_heading_color' => '',
			'stats_text_color'    => '',

			/* ── FINAL CTA ── */
			'cta_kicker'     => 'مع نطاق الأولى',
			'cta_h2'         => 'ابدأ رحلتك نحو مجتمع سكني متكامل',
			'cta_body'       => 'من الفكرة إلى التنفيذ، تعمل نطاق الأولى على بناء وجهات سكنية تجمع بين الراحة، الجمال، والاستدامة.',
			'cta_btn1_label' => 'سجّل اهتمامك',
			'cta_btn1_url'   => '/register-interest/',
			'cta_btn2_label' => 'تواصل معنا',
			'cta_btn2_url'   => '/contact-us/',
			'cta_bg_color'      => '',
			'cta_heading_color' => '',
			'cta_text_color'    => '',
		);
	}
}

if ( ! function_exists( 'nitaq_about_get' ) ) {
	function nitaq_about_get() {
		$saved = get_option( 'nitaq_about_settings', array() );
		return wp_parse_args( $saved, nitaq_about_defaults() );
	}
}

if ( ! function_exists( 'nitaq_sanitize_about_url' ) ) {
	function nitaq_sanitize_about_url( $url ) {
		$url = trim( $url );
		if ( '' === $url ) return '';
		if ( strpos( $url, 'tel:' ) === 0 || strpos( $url, 'mailto:' ) === 0 ) {
			return esc_url_raw( $url );
		}
		if ( strpos( $url, '/' ) === 0 || strpos( $url, '#' ) === 0 ) {
			return sanitize_text_field( $url );
		}
		return esc_url_raw( $url );
	}
}

if ( ! function_exists( 'nitaq_sanitize_about_settings' ) ) {
	function nitaq_sanitize_about_settings( $input ) {
		$defaults  = nitaq_about_defaults();
		$clean     = array();
		$url_keys  = array(
			'hero_btn1_url', 'hero_btn2_url', 'hero_image',
			'hero_video_url', 'hero_poster_image',
			'intro_image',
			'trilogy_img1', 'trilogy_img2', 'trilogy_img3',
			'groves_btn_url', 'groves_image',
			'dest_image',
			'cta_btn1_url', 'cta_btn2_url',
		);
		$int_keys  = array(
			'stat1_decimals', 'stat2_decimals', 'stat3_decimals', 'stat4_decimals',
		);
		$float_keys = array(
			'stat1_num', 'stat2_num', 'stat3_num', 'stat4_num',
		);
		$color_keys = array(
			'hero_bg_color', 'hero_heading_color', 'hero_text_color',
			'intro_bg_color', 'intro_heading_color', 'intro_text_color',
			'trilogy_bg_color', 'trilogy_heading_color', 'trilogy_text_color',
			'values_bg_color', 'values_heading_color', 'values_text_color',
			'why_bg_color', 'why_heading_color', 'why_text_color',
			'groves_bg_color', 'groves_heading_color', 'groves_text_color',
			'dest_bg_color', 'dest_heading_color', 'dest_text_color',
			'stats_bg_color', 'stats_heading_color', 'stats_text_color',
			'cta_bg_color', 'cta_heading_color', 'cta_text_color',
		);

		foreach ( $defaults as $key => $default_val ) {
			if ( ! isset( $input[ $key ] ) ) {
				$clean[ $key ] = '';
				continue;
			}
			$val = $input[ $key ];

			if ( in_array( $key, $url_keys, true ) ) {
				$clean[ $key ] = nitaq_sanitize_about_url( $val );
			} elseif ( in_array( $key, $color_keys, true ) ) {
				$sanitized     = sanitize_hex_color( $val );
				$clean[ $key ] = $sanitized ? $sanitized : '';
			} elseif ( in_array( $key, $int_keys, true ) ) {
				$clean[ $key ] = (string) absint( $val );
			} elseif ( in_array( $key, $float_keys, true ) ) {
				$clean[ $key ] = (string) floatval( $val );
			} else {
				$clean[ $key ] = sanitize_textarea_field( $val );
			}
		}

		return $clean;
	}
}

/* ── Admin menu ── */
if ( ! function_exists( 'nitaq_about_settings_menu' ) ) {
	function nitaq_about_settings_menu() {
		add_theme_page(
			'إعدادات صفحة من نحن',
			'إعدادات صفحة من نحن',
			'manage_options',
			'nitaq-about-settings',
			'nitaq_about_settings_render'
		);
	}
	add_action( 'admin_menu', 'nitaq_about_settings_menu' );
}

/* ── Enqueue media uploader only on this page ── */
if ( ! function_exists( 'nitaq_about_admin_enqueue' ) ) {
	function nitaq_about_admin_enqueue( $hook ) {
		if ( 'appearance_page_nitaq-about-settings' !== $hook ) return;
		wp_enqueue_media();
		wp_add_inline_script( 'jquery-core', nitaq_about_media_js() );
	}
	add_action( 'admin_enqueue_scripts', 'nitaq_about_admin_enqueue' );
}

function nitaq_about_media_js() {
	return '
jQuery(function($){
  $(document).on("click",".nitaq-media-btn",function(e){
    e.preventDefault();
    var btn       = $(this);
    var target    = btn.data("target");
    var preview   = btn.data("preview");
    var mediaType = btn.data("media-type") || "image";
    var title     = mediaType === "video" ? "اختر فيديو" : "اختر صورة";
    var frame = wp.media({title:title,button:{text:"اختر"},multiple:false,library:{type:mediaType}});
    frame.on("select",function(){
      var att = frame.state().get("selection").first().toJSON();
      $("#"+target).val(att.url);
      if(preview){
        if(mediaType === "video"){
          $("#"+preview).text(att.url).show();
        } else {
          $("#"+preview).attr("src",att.url).show();
        }
      }
    });
    frame.open();
  });
  /* Color picker sync */
  $(document).on("input",".nitaq-color-picker",function(){
    var hidden = $("#"+$(this).data("hidden"));
    hidden.val($(this).val());
  });
  $(document).on("input",".nitaq-color-text",function(){
    var val = $(this).val();
    if(/^#[0-9a-fA-F]{6}$/.test(val)){
      $("#"+$(this).data("picker")).val(val);
    }
  });
  $(document).on("click",".nitaq-color-clear",function(){
    var base = $(this).data("base");
    $("#"+base).val("");
    $("#"+base+"_picker").val("#000000");
  });
});
';
}

/* ── Save handler ── */
if ( ! function_exists( 'nitaq_about_settings_save' ) ) {
	function nitaq_about_settings_save() {
		if (
			! isset( $_POST['nitaq_about_nonce'] ) ||
			! wp_verify_nonce( $_POST['nitaq_about_nonce'], 'nitaq_about_save' ) ||
			! current_user_can( 'manage_options' )
		) {
			return;
		}

		$raw   = isset( $_POST['nitaq_about'] ) ? (array) $_POST['nitaq_about'] : array();
		$clean = nitaq_sanitize_about_settings( $raw );
		update_option( 'nitaq_about_settings', $clean );

		/* ── Purge all caches so the live page reflects the new settings immediately ── */
		wp_cache_flush();
		// LiteSpeed Cache plugin
		do_action( 'litespeed_purge_all' );
		// W3 Total Cache
		if ( function_exists( 'w3tc_flush_all' ) ) { w3tc_flush_all(); }
		// WP Super Cache
		if ( function_exists( 'wp_cache_clear_cache' ) ) { wp_cache_clear_cache(); }
		// WP Rocket
		if ( function_exists( 'rocket_clean_domain' ) ) { rocket_clean_domain(); }

		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>تم حفظ إعدادات صفحة "من نحن" بنجاح — تم تحديث الكاش تلقائيًا.</p></div>';
		} );
	}
	add_action( 'admin_init', 'nitaq_about_settings_save' );
}

/* ── Field helpers ── */
function nitaq_about_field_text( $o, $key, $label, $desc = '' ) {
	$id  = 'nitaq_about_' . $key;
	$val = isset( $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td><input type="text" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" class="regular-text">';
	if ( $desc ) echo '<p class="description">' . esc_html( $desc ) . '</p>';
	echo '</td></tr>';
}

function nitaq_about_field_textarea( $o, $key, $label, $rows = 3, $desc = '' ) {
	$id  = 'nitaq_about_' . $key;
	$val = isset( $o[ $key ] ) ? esc_textarea( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td><textarea id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" rows="' . (int) $rows . '" class="large-text">' . $val . '</textarea>';
	if ( $desc ) echo '<p class="description">' . esc_html( $desc ) . '</p>';
	echo '</td></tr>';
}

function nitaq_about_field_url( $o, $key, $label, $desc = '' ) {
	$id  = 'nitaq_about_' . $key;
	$val = isset( $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td><input type="text" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" class="regular-text" dir="ltr" placeholder="/relative/ or https://">';
	if ( $desc ) echo '<p class="description">' . esc_html( $desc ) . '</p>';
	echo '</td></tr>';
}

function nitaq_about_field_image( $o, $key, $label ) {
	$id       = 'nitaq_about_' . $key;
	$prev_id  = $id . '_preview';
	$val      = isset( $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td>';
	echo '<input type="text" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" class="large-text" dir="ltr">';
	echo ' <button type="button" class="button nitaq-media-btn" data-target="' . esc_attr( $id ) . '" data-preview="' . esc_attr( $prev_id ) . '" data-media-type="image">اختر من المكتبة</button>';
	if ( $val ) {
		echo '<br><img id="' . esc_attr( $prev_id ) . '" src="' . esc_attr( $val ) . '" style="max-height:80px;margin-top:6px;border-radius:4px;">';
	} else {
		echo '<br><img id="' . esc_attr( $prev_id ) . '" src="" style="max-height:80px;margin-top:6px;border-radius:4px;display:none;">';
	}
	echo '</td></tr>';
}

function nitaq_about_field_video( $o, $key, $label ) {
	$id      = 'nitaq_about_' . $key;
	$prev_id = $id . '_preview';
	$val     = isset( $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td>';
	echo '<input type="text" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" class="large-text" dir="ltr">';
	echo ' <button type="button" class="button nitaq-media-btn" data-target="' . esc_attr( $id ) . '" data-preview="' . esc_attr( $prev_id ) . '" data-media-type="video">اختر فيديو من المكتبة</button>';
	echo '<p class="description" id="' . esc_attr( $prev_id ) . '" style="margin-top:4px;word-break:break-all;color:#666;">' . ( $val ? esc_html( basename( $val ) ) : 'لم يُختر فيديو' ) . '</p>';
	echo '</td></tr>';
}

function nitaq_about_field_color( $o, $key, $label ) {
	$id  = 'nitaq_about_' . $key;
	$val = ( isset( $o[ $key ] ) && '' !== $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row">' . esc_html( $label ) . '</th>';
	echo '<td style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;padding-top:6px;">';
	/* Colour swatch picker (syncs to hidden text field) */
	echo '<input type="color" id="' . esc_attr( $id ) . '_picker" value="' . ( $val ?: '#000000' ) . '" class="nitaq-color-picker" data-hidden="' . esc_attr( $id ) . '" style="width:44px;height:34px;padding:2px;cursor:pointer;border-radius:4px;">';
	/* Hidden text field that actually saves */
	echo '<input type="text" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" class="nitaq-color-text small-text" data-picker="' . esc_attr( $id ) . '_picker" maxlength="7" placeholder="#rrggbb" style="width:88px;">';
	echo ' <button type="button" class="button button-small nitaq-color-clear" data-base="' . esc_attr( $id ) . '">مسح (افتراضي)</button>';
	echo '<span class="description" style="flex-basis:100%;margin:2px 0 0;">فارغ = لون القسم الافتراضي</span>';
	echo '</td></tr>';
}

function nitaq_about_field_number( $o, $key, $label, $step = 'any', $desc = '' ) {
	$id  = 'nitaq_about_' . $key;
	$val = isset( $o[ $key ] ) ? esc_attr( $o[ $key ] ) : '';
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td><input type="number" id="' . esc_attr( $id ) . '" name="nitaq_about[' . esc_attr( $key ) . ']" value="' . $val . '" step="' . esc_attr( $step ) . '" class="small-text">';
	if ( $desc ) echo ' <span class="description">' . esc_html( $desc ) . '</span>';
	echo '</td></tr>';
}

function nitaq_about_section_open( $title ) {
	echo '<div class="nitaq-section-card" style="background:#fff;border:1px solid #ddd;border-radius:6px;padding:20px 24px;margin-bottom:20px;">';
	echo '<h2 style="margin-top:0;font-size:15px;border-bottom:1px solid #eee;padding-bottom:10px;margin-bottom:16px;">' . esc_html( $title ) . '</h2>';
	echo '<table class="form-table" role="presentation">';
}

function nitaq_about_section_close() {
	echo '</table></div>';
}

function nitaq_about_color_group( $o, $prefix, $bg_label = 'لون خلفية القسم', $h_label = 'لون العنوان', $tx_label = 'لون النص / الوصف' ) {
	echo '<tr><td colspan="2"><hr style="margin:4px 0 8px;border-color:#eee;"><strong style="font-size:12px;color:#777;">ألوان القسم</strong></td></tr>';
	nitaq_about_field_color( $o, $prefix . '_bg_color',      $bg_label );
	nitaq_about_field_color( $o, $prefix . '_heading_color', $h_label );
	nitaq_about_field_color( $o, $prefix . '_text_color',    $tx_label );
}

/* ── Page renderer ── */
if ( ! function_exists( 'nitaq_about_settings_render' ) ) {
	function nitaq_about_settings_render() {
		if ( ! current_user_can( 'manage_options' ) ) return;

		$o = nitaq_about_get();
		?>
		<div class="wrap" dir="rtl">
			<h1 style="margin-bottom:20px;">إعدادات صفحة "من نحن"</h1>
			<p style="color:#666;margin-bottom:24px;">جميع التعديلات هنا تظهر فورًا في الصفحة دون الحاجة لتعديل الكود. اترك الحقل فارغًا لاستخدام النص أو اللون الافتراضي.</p>

			<form method="post" action="">
				<?php wp_nonce_field( 'nitaq_about_save', 'nitaq_about_nonce' ); ?>

				<?php /* ── HERO ── */ ?>
				<?php nitaq_about_section_open( '1 — قسم الهيرو (Hero)' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_kicker', 'الكيكر (Kicker)' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_h1', 'العنوان H1' ); ?>
				<?php nitaq_about_field_textarea( $o, 'hero_h2', 'العنوان الثانوي H2', 2, 'استخدم سطرًا جديدًا للفصل بين السطرين' ); ?>
				<?php nitaq_about_field_textarea( $o, 'hero_body', 'النص التعريفي', 3 ); ?>
				<?php nitaq_about_field_text( $o, 'hero_btn1_label', 'زر 1 — النص' ); ?>
				<?php nitaq_about_field_url( $o, 'hero_btn1_url', 'زر 1 — الرابط' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_btn2_label', 'زر 2 — النص' ); ?>
				<?php nitaq_about_field_url( $o, 'hero_btn2_url', 'زر 2 — الرابط' ); ?>
				<tr><td colspan="2"><hr style="margin:4px 0 8px;border-color:#eee;"><strong style="font-size:12px;color:#777;">وسائط الهيرو</strong></td></tr>
				<?php nitaq_about_field_video( $o, 'hero_video_url', 'فيديو الخلفية' ); ?>
				<?php nitaq_about_field_image( $o, 'hero_poster_image', 'صورة احتياطية (Poster)' ); ?>
				<?php nitaq_about_field_image( $o, 'hero_image', 'صورة الخلفية (بديل بدون فيديو)' ); ?>
				<tr><td colspan="2"><hr style="margin:4px 0 8px;border-color:#eee;"><strong style="font-size:12px;color:#777;">المؤشرات الثلاثة</strong></td></tr>
				<?php nitaq_about_field_text( $o, 'hero_metric1_num', 'مؤشر 1 — الرقم', 'مثال: 3.9+' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric1_unit', 'مؤشر 1 — الوحدة', 'مثال: مليون م²' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric1_lbl', 'مؤشر 1 — التسمية' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric2_num', 'مؤشر 2 — الرقم' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric2_unit', 'مؤشر 2 — الوحدة' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric2_lbl', 'مؤشر 2 — التسمية' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric3_num', 'مؤشر 3 — الرقم' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric3_unit', 'مؤشر 3 — الوحدة', 'اتركه فارغًا إن لم تكن هناك وحدة' ); ?>
				<?php nitaq_about_field_text( $o, 'hero_metric3_lbl', 'مؤشر 3 — التسمية' ); ?>
				<?php nitaq_about_color_group( $o, 'hero' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── INTRO ── */ ?>
				<?php nitaq_about_section_open( '2 — قسم "من نحن"' ); ?>
				<?php nitaq_about_field_text( $o, 'intro_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'intro_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'intro_lead', 'النص الرئيسي (Lead)', 2 ); ?>
				<?php nitaq_about_field_textarea( $o, 'intro_body1', 'الفقرة الأولى', 3 ); ?>
				<?php nitaq_about_field_textarea( $o, 'intro_body2', 'الفقرة الثانية', 3 ); ?>
				<?php nitaq_about_field_image( $o, 'intro_image', 'صورة القسم' ); ?>
				<?php nitaq_about_field_text( $o, 'intro_img_alt', 'النص البديل للصورة (Alt)' ); ?>
				<?php nitaq_about_color_group( $o, 'intro' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── SIGNATURE / PHILOSOPHY ── */ ?>
				<?php nitaq_about_section_open( '3 — قسم الفلسفة / الرؤية / الرسالة (Trilogy)' ); ?>
				<?php nitaq_about_field_text( $o, 'sig_kicker', 'كيكر الفلسفة' ); ?>
				<?php nitaq_about_field_textarea( $o, 'sig_h2', 'عنوان الفلسفة H2', 2, 'سطران — افصل بسطر جديد' ); ?>
				<?php nitaq_about_field_textarea( $o, 'sig_body', 'نص الفلسفة', 2 ); ?>
				<tr><td colspan="2"><hr style="margin:4px 0 8px;border-color:#eee;"><strong style="font-size:12px;color:#777;">صور الكروت الثلاثة</strong></td></tr>
				<?php nitaq_about_field_image( $o, 'trilogy_img1', 'صورة كارت 1 — فلسفتنا' ); ?>
				<?php nitaq_about_field_image( $o, 'trilogy_img2', 'صورة كارت 2 — رؤيتنا' ); ?>
				<?php nitaq_about_field_image( $o, 'trilogy_img3', 'صورة كارت 3 — رسالتنا' ); ?>
				<?php nitaq_about_field_text( $o, 'vision_kicker', 'الرؤية — الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'vision_h2', 'الرؤية — العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'vision_body', 'الرؤية — النص', 3 ); ?>
				<?php nitaq_about_field_text( $o, 'mission_kicker', 'الرسالة — الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'mission_h2', 'الرسالة — العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'mission_body', 'الرسالة — النص', 3 ); ?>
				<?php nitaq_about_color_group( $o, 'trilogy' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── VALUES ── */ ?>
				<?php nitaq_about_section_open( '4 — قيمنا' ); ?>
				<?php nitaq_about_field_text( $o, 'values_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'values_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_text( $o, 'values_subhead', 'النص التعريفي' ); ?>
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<tr><td colspan="2"><strong style="font-size:13px;">قيمة <?php echo $i; ?></strong></td></tr>
					<?php nitaq_about_field_text( $o, 'value' . $i . '_num',   'الرقم',  'مثال: 0' . $i ); ?>
					<?php nitaq_about_field_text( $o, 'value' . $i . '_title', 'العنوان' ); ?>
					<?php nitaq_about_field_textarea( $o, 'value' . $i . '_body', 'النص', 2 ); ?>
				<?php endfor; ?>
				<?php nitaq_about_color_group( $o, 'values' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── WHY NITAQ ── */ ?>
				<?php nitaq_about_section_open( '5 — لماذا نطاق الأولى؟' ); ?>
				<?php nitaq_about_field_text( $o, 'why_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'why_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_text( $o, 'why_subhead', 'النص التعريفي' ); ?>
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<?php nitaq_about_field_text( $o, 'why_reason' . $i, 'ميزة ' . $i ); ?>
				<?php endfor; ?>
				<?php nitaq_about_color_group( $o, 'why' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── GROVES ── */ ?>
				<?php nitaq_about_section_open( '6 — مشروع ذا جروفز' ); ?>
				<?php nitaq_about_field_text( $o, 'groves_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'groves_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'groves_lead', 'النص الرئيسي (Lead)', 3 ); ?>
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<?php nitaq_about_field_text( $o, 'groves_li' . $i, 'بند قائمة ' . $i ); ?>
				<?php endfor; ?>
				<?php nitaq_about_field_text( $o, 'groves_btn_label', 'الزر — النص' ); ?>
				<?php nitaq_about_field_url( $o, 'groves_btn_url', 'الزر — الرابط' ); ?>
				<?php nitaq_about_field_image( $o, 'groves_image', 'صورة القسم' ); ?>
				<?php nitaq_about_field_text( $o, 'groves_img_alt', 'Alt الصورة' ); ?>
				<?php nitaq_about_color_group( $o, 'groves' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── DESTINATION ── */ ?>
				<?php nitaq_about_section_open( '7 — وجهة لازورد والخبر' ); ?>
				<?php nitaq_about_field_text( $o, 'dest_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'dest_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'dest_body1', 'الفقرة الأولى', 3 ); ?>
				<?php nitaq_about_field_textarea( $o, 'dest_body2', 'الفقرة الثانية', 3 ); ?>
				<?php nitaq_about_field_image( $o, 'dest_image', 'صورة القسم' ); ?>
				<?php nitaq_about_field_text( $o, 'dest_img_alt', 'Alt الصورة' ); ?>
				<?php nitaq_about_color_group( $o, 'dest' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── STATS ── */ ?>
				<?php nitaq_about_section_open( '8 — إحصائيات لازورد' ); ?>
				<?php nitaq_about_field_text( $o, 'stats_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'stats_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'stats_subhead', 'النص التعريفي', 2 ); ?>
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<tr><td colspan="2"><strong style="font-size:13px;">إحصائية <?php echo $i; ?></strong></td></tr>
					<?php nitaq_about_field_number( $o, 'stat' . $i . '_num',      'القيمة العددية', 'any', 'الرقم فقط بدون وحدة أو إضافات' ); ?>
					<?php nitaq_about_field_number( $o, 'stat' . $i . '_decimals', 'عدد الكسور العشرية', '1',   '0 للأعداد الصحيحة' ); ?>
					<?php nitaq_about_field_text(   $o, 'stat' . $i . '_suffix',   'اللاحقة', 'مثال: + مليون م² أو %' ); ?>
					<?php nitaq_about_field_text(   $o, 'stat' . $i . '_label',    'التسمية' ); ?>
				<?php endfor; ?>
				<?php nitaq_about_color_group( $o, 'stats' ); ?>
				<?php nitaq_about_section_close(); ?>

				<?php /* ── CTA ── */ ?>
				<?php nitaq_about_section_open( '9 — قسم CTA الختامي' ); ?>
				<?php nitaq_about_field_text( $o, 'cta_kicker', 'الكيكر' ); ?>
				<?php nitaq_about_field_text( $o, 'cta_h2', 'العنوان H2' ); ?>
				<?php nitaq_about_field_textarea( $o, 'cta_body', 'النص', 2 ); ?>
				<?php nitaq_about_field_text( $o, 'cta_btn1_label', 'زر 1 — النص' ); ?>
				<?php nitaq_about_field_url( $o, 'cta_btn1_url', 'زر 1 — الرابط' ); ?>
				<?php nitaq_about_field_text( $o, 'cta_btn2_label', 'زر 2 — النص' ); ?>
				<?php nitaq_about_field_url( $o, 'cta_btn2_url', 'زر 2 — الرابط' ); ?>
				<?php nitaq_about_color_group( $o, 'cta' ); ?>
				<?php nitaq_about_section_close(); ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary button-large" value="حفظ الإعدادات">
				</p>

			</form>
		</div>
		<?php
	}
}
