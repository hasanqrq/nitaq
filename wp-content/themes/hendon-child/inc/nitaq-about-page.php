<?php
/**
 * Nitaq About Page shortcode
 * Usage: [nitaq_about_page]
 *
 * Content is pulled from Appearance > إعدادات صفحة من نحن.
 * Defaults in nitaq_about_defaults() ensure the page looks correct
 * even before any settings have been saved.
 *
 * Register this file in functions.php AFTER nitaq-about-settings.php:
 *   require_once get_stylesheet_directory() . '/inc/nitaq-about-settings.php';
 *   require_once get_stylesheet_directory() . '/inc/nitaq-about-page.php';
 */

if ( ! function_exists( 'nitaq_about_page_shortcode' ) ) {

	function nitaq_about_page_shortcode() {
		$o = nitaq_about_get();

	/* ── Inline CSS variables for dashboard colour overrides ── */
	$nitaq_section_css = '';
	$sections_colors = array(
		'hero'    => array( 'hero_bg_color',    'hero_heading_color',    'hero_text_color' ),
		'intro'   => array( 'intro_bg_color',   'intro_heading_color',   'intro_text_color' ),
		'trilogy' => array( 'trilogy_bg_color', 'trilogy_heading_color', 'trilogy_text_color' ),
		'values'  => array( 'values_bg_color',  'values_heading_color',  'values_text_color' ),
		'why'     => array( 'why_bg_color',      'why_heading_color',     'why_text_color' ),
		'groves'  => array( 'groves_bg_color',  'groves_heading_color',  'groves_text_color' ),
		'dest'    => array( 'dest_bg_color',    'dest_heading_color',    'dest_text_color' ),
		'stats'   => array( 'stats_bg_color',   'stats_heading_color',   'stats_text_color' ),
		'cta'     => array( 'cta_bg_color',     'cta_heading_color',     'cta_text_color' ),
	);
	foreach ( $sections_colors as $prefix => $keys ) {
		list( $bg_key, $h_key, $tx_key ) = $keys;
		$bg = ( ! empty( $o[ $bg_key ] ) ) ? sanitize_hex_color( $o[ $bg_key ] ) : '';
		$h  = ( ! empty( $o[ $h_key ] )  ) ? sanitize_hex_color( $o[ $h_key ] )  : '';
		$tx = ( ! empty( $o[ $tx_key ] ) ) ? sanitize_hex_color( $o[ $tx_key ] ) : '';
		if ( $bg || $h || $tx ) {
			$sel = '.nitaq-about-' . $prefix;
			if ( $prefix === 'hero' )    $sel = '.nitaq-about-hero';
			if ( $prefix === 'trilogy' ) $sel = '.nitaq-about-trilogy';
			if ( $prefix === 'values' )  $sel = '.nitaq-about-values';
			if ( $prefix === 'why' )     $sel = '.nitaq-about-why';
			if ( $prefix === 'groves' )  $sel = '.nitaq-about-groves';
			if ( $prefix === 'dest' )    $sel = '.nitaq-about-destination';
			if ( $prefix === 'stats' )   $sel = '.nitaq-about-stats';
			if ( $prefix === 'cta' )     $sel = '.nitaq-about-cta';
			if ( $prefix === 'intro' )   $sel = '.nitaq-about-intro';
			$rules = '';
			if ( $bg ) $rules .= '--nitaq-sec-bg:' . $bg . ';';
			if ( $h  ) $rules .= '--nitaq-sec-h:'  . $h  . ';';
			if ( $tx ) $rules .= '--nitaq-sec-tx:' . $tx . ';';
			$nitaq_section_css .= 'body.page-id-1172 ' . $sel . '{' . $rules . '}';
		}
	}
	if ( $nitaq_section_css ) {
		echo '<style id="nitaq-about-colors">' . $nitaq_section_css . '</style>';
	}

		/* Helper: split a textarea value on newlines and wrap each in <br> */
		$h2_nl = function( $text ) {
			$lines = array_filter( array_map( 'trim', explode( "\n", $text ) ) );
			return implode( '<br>', array_map( 'esc_html', $lines ) );
		};

		ob_start();
		?>
<main class="nitaq-about-page nitaq-about-page--luxury" dir="rtl">

	<!-- HERO -->
	<section class="nitaq-about-hero nitaq-about-hero--cinematic">
		<video class="nitaq-about-hero__video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_attr( $o['hero_poster_image'] ); ?>">
			<?php
			$vid_url = esc_attr( $o['hero_video_url'] );
			$ext     = strtolower( pathinfo( $vid_url, PATHINFO_EXTENSION ) );
			$mime    = ( $ext === 'mp4' ) ? 'video/mp4' : 'video/webm';
			?>
			<source src="<?php echo $vid_url; ?>" type="<?php echo $mime; ?>">
		</video>
		<div class="nitaq-about-hero__overlay"></div>

		<div class="nitaq-about-container nitaq-about-hero__content">
			<span class="nitaq-about-kicker"><?php echo esc_html( $o['hero_kicker'] ); ?></span>

			<h1><?php echo esc_html( $o['hero_h1'] ); ?></h1>

			<h2><?php echo $h2_nl( $o['hero_h2'] ); ?></h2>

			<p><?php echo esc_html( $o['hero_body'] ); ?></p>

			<div class="nitaq-about-actions">
				<a class="nitaq-about-button" href="<?php echo esc_url( $o['hero_btn1_url'] ); ?>"><?php echo esc_html( $o['hero_btn1_label'] ); ?></a>
				<a class="nitaq-about-button nitaq-about-button--outline" href="<?php echo esc_url( $o['hero_btn2_url'] ); ?>"><?php echo esc_html( $o['hero_btn2_label'] ); ?></a>
			</div>

			<div class="nitaq-about-hero__metrics" aria-label="مؤشرات مختصرة عن وجهة لازورد">
				<div>
					<strong>
						<bdi dir="ltr"><?php echo esc_html( $o['hero_metric1_num'] ); ?></bdi>
						<?php echo esc_html( $o['hero_metric1_unit'] ); ?>
					</strong>
					<span><?php echo esc_html( $o['hero_metric1_lbl'] ); ?></span>
				</div>
				<div>
					<strong>
						<bdi dir="ltr"><?php echo esc_html( $o['hero_metric2_num'] ); ?></bdi>
						<?php echo esc_html( $o['hero_metric2_unit'] ); ?>
					</strong>
					<span><?php echo esc_html( $o['hero_metric2_lbl'] ); ?></span>
				</div>
				<div>
					<strong>
						<bdi dir="ltr"><?php echo esc_html( $o['hero_metric3_num'] ); ?></bdi>
						<?php if ( $o['hero_metric3_unit'] ) echo ' ' . esc_html( $o['hero_metric3_unit'] ); ?>
					</strong>
					<span><?php echo esc_html( $o['hero_metric3_lbl'] ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- INTRO -->
	<section class="nitaq-about-section nitaq-about-section--light nitaq-about-section--intro">
		<div class="nitaq-about-container nitaq-about-split nitaq-about-split--statement">
			<div class="nitaq-about-copy">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['intro_kicker'] ); ?></span>

				<h2><?php echo esc_html( $o['intro_h2'] ); ?></h2>

				<p class="nitaq-about-lead"><?php echo esc_html( $o['intro_lead'] ); ?></p>

				<?php if ( $o['intro_body1'] ) : ?>
				<p><?php echo esc_html( $o['intro_body1'] ); ?></p>
				<?php endif; ?>

				<?php if ( $o['intro_body2'] ) : ?>
				<p><?php echo esc_html( $o['intro_body2'] ); ?></p>
				<?php endif; ?>
			</div>

			<figure class="nitaq-about-image nitaq-about-image--large">
				<img src="<?php echo esc_url( $o['intro_image'] ); ?>" alt="<?php echo esc_attr( $o['intro_img_alt'] ); ?>" loading="lazy">
			</figure>
		</div>
	</section>

	<!-- TRILOGY: PHILOSOPHY / VISION / MISSION -->
	<section class="nitaq-about-trilogy">
		<div class="nitaq-about-container">
		<!-- Trilogy intro -->
		<div class="nitaq-trilogy-intro nitaq-motion-ready" data-delay="0">
			<span class="nitaq-trilogy-intro__kicker">من نحن</span>
			<h2 class="nitaq-trilogy-intro__heading">
				<?php echo $h2_nl( $o['sig_h2'] ); ?>
			</h2>
			<p class="nitaq-trilogy-intro__lead"><?php echo esc_html( $o['sig_body'] ); ?></p>
			<div class="nitaq-trilogy-intro__divider" aria-hidden="true"></div>
		</div>
			<div class="nitaq-trilogy-grid">

				<article class="nitaq-trilogy-card nitaq-motion-ready" data-delay="0">
					<div class="nitaq-trilogy-card__media">
						<img src="<?php echo esc_url( $o['trilogy_img1'] ); ?>" alt="فلسفتنا" loading="lazy">
					</div>
					<div class="nitaq-trilogy-card__body">
						<span class="nitaq-trilogy-card__kicker"><?php echo esc_html( $o['sig_kicker'] ); ?></span>
						<h3 class="nitaq-trilogy-card__title"><?php echo $h2_nl( $o['sig_h2'] ); ?></h3>
						<p class="nitaq-trilogy-card__text"><?php echo esc_html( $o['sig_body'] ); ?></p>
					</div>
				</article>

				<article class="nitaq-trilogy-card nitaq-motion-ready" data-delay="120">
					<div class="nitaq-trilogy-card__media">
						<img src="<?php echo esc_url( $o['trilogy_img2'] ); ?>" alt="رؤيتنا" loading="lazy">
					</div>
					<div class="nitaq-trilogy-card__body">
						<span class="nitaq-trilogy-card__kicker"><?php echo esc_html( $o['vision_kicker'] ); ?></span>
						<h3 class="nitaq-trilogy-card__title"><?php echo esc_html( $o['vision_h2'] ); ?></h3>
						<p class="nitaq-trilogy-card__text"><?php echo esc_html( $o['vision_body'] ); ?></p>
					</div>
				</article>

				<article class="nitaq-trilogy-card nitaq-motion-ready" data-delay="240">
					<div class="nitaq-trilogy-card__media">
						<img src="<?php echo esc_url( $o['trilogy_img3'] ); ?>" alt="رسالتنا" loading="lazy">
					</div>
					<div class="nitaq-trilogy-card__body">
						<span class="nitaq-trilogy-card__kicker"><?php echo esc_html( $o['mission_kicker'] ); ?></span>
						<h3 class="nitaq-trilogy-card__title"><?php echo esc_html( $o['mission_h2'] ); ?></h3>
						<p class="nitaq-trilogy-card__text"><?php echo esc_html( $o['mission_body'] ); ?></p>
					</div>
				</article>

			</div>
		</div>
	</section>

	<!-- VALUES -->
	<section class="nitaq-about-section nitaq-about-section--light">
		<div class="nitaq-about-container">
			<div class="nitaq-about-heading">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['values_kicker'] ); ?></span>
				<h2><?php echo esc_html( $o['values_h2'] ); ?></h2>
				<p><?php echo esc_html( $o['values_subhead'] ); ?></p>
			</div>

			<div class="nitaq-about-values nitaq-about-values--premium">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<article>
					<span><?php echo esc_html( $o[ 'value' . $i . '_num' ] ); ?></span>
					<h3><?php echo esc_html( $o[ 'value' . $i . '_title' ] ); ?></h3>
					<p><?php echo esc_html( $o[ 'value' . $i . '_body' ] ); ?></p>
				</article>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- WHY NITAQ -->
	<section class="nitaq-about-section nitaq-about-section--green nitaq-about-section--why">
		<div class="nitaq-about-container">
			<div class="nitaq-about-heading">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['why_kicker'] ); ?></span>
				<h2><?php echo esc_html( $o['why_h2'] ); ?></h2>
				<p><?php echo esc_html( $o['why_subhead'] ); ?></p>
			</div>

			<div class="nitaq-about-reasons nitaq-about-reasons--icons">
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<?php if ( $o[ 'why_reason' . $i ] ) : ?>
					<span><?php echo esc_html( $o[ 'why_reason' . $i ] ); ?></span>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- PROJECT FEATURE — The Groves -->
	<section class="nitaq-about-section nitaq-about-section--light">
		<div class="nitaq-about-container nitaq-about-feature nitaq-about-feature--luxury">
			<div class="nitaq-about-feature__media">
				<img src="<?php echo esc_url( $o['groves_image'] ); ?>" alt="<?php echo esc_attr( $o['groves_img_alt'] ); ?>" loading="lazy">
			</div>

			<div class="nitaq-about-feature__text">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['groves_kicker'] ); ?></span>

				<h2><?php echo esc_html( $o['groves_h2'] ); ?></h2>

				<p class="nitaq-about-lead"><?php echo esc_html( $o['groves_lead'] ); ?></p>

				<ul>
					<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
						<?php if ( $o[ 'groves_li' . $i ] ) : ?>
						<li><?php echo esc_html( $o[ 'groves_li' . $i ] ); ?></li>
						<?php endif; ?>
					<?php endfor; ?>
				</ul>

				<a class="nitaq-about-button nitaq-about-button--dark" href="<?php echo esc_url( $o['groves_btn_url'] ); ?>"><?php echo esc_html( $o['groves_btn_label'] ); ?></a>
			</div>
		</div>
	</section>

	<!-- LOCATION / LAZORD -->
	<section class="nitaq-about-section nitaq-about-section--dark nitaq-about-section--destination">
		<div class="nitaq-about-container nitaq-about-split nitaq-about-split--reverse">
			<div class="nitaq-about-copy">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['dest_kicker'] ); ?></span>

				<h2><?php echo esc_html( $o['dest_h2'] ); ?></h2>

				<?php if ( $o['dest_body1'] ) : ?>
				<p><?php echo esc_html( $o['dest_body1'] ); ?></p>
				<?php endif; ?>

				<?php if ( $o['dest_body2'] ) : ?>
				<p><?php echo esc_html( $o['dest_body2'] ); ?></p>
				<?php endif; ?>
			</div>

			<figure class="nitaq-about-image nitaq-about-image--large">
				<img src="<?php echo esc_url( $o['dest_image'] ); ?>" alt="<?php echo esc_attr( $o['dest_img_alt'] ); ?>" loading="lazy">
			</figure>
		</div>
	</section>

	<!-- STATS -->
	<section class="nitaq-about-section nitaq-about-section--stats">
		<div class="nitaq-about-container">
			<div class="nitaq-about-heading">
				<span class="nitaq-about-kicker"><?php echo esc_html( $o['stats_kicker'] ); ?></span>
				<h2><?php echo esc_html( $o['stats_h2'] ); ?></h2>
				<p><?php echo esc_html( $o['stats_subhead'] ); ?></p>
			</div>

			<div class="nitaq-about-stats nitaq-about-stats--luxury">
				<?php for ( $i = 1; $i <= 4; $i++ ) :
					$num      = floatval( $o[ 'stat' . $i . '_num' ] );
					$decimals = absint( $o[ 'stat' . $i . '_decimals' ] );
					$suffix   = $o[ 'stat' . $i . '_suffix' ];
					$label    = $o[ 'stat' . $i . '_label' ];
				?>
				<article>
					<strong>
						<bdi dir="ltr">
							<span class="nitaq-stat-number"
								data-target="<?php echo esc_attr( $num ); ?>"
								data-decimals="<?php echo esc_attr( $decimals ); ?>">0</span><?php
							if ( $suffix ) echo '<span class="nitaq-about-stat-suffix">' . esc_html( ' ' . $suffix ) . '</span>';
						?></bdi>
					</strong>
					<span><?php echo esc_html( $label ); ?></span>
				</article>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- FINAL CTA -->
	<section class="nitaq-about-final nitaq-about-final--luxury">
		<div class="nitaq-about-container">
			<span class="nitaq-about-kicker"><?php echo esc_html( $o['cta_kicker'] ); ?></span>

			<h2><?php echo esc_html( $o['cta_h2'] ); ?></h2>

			<p><?php echo esc_html( $o['cta_body'] ); ?></p>

			<div class="nitaq-about-actions">
				<a class="nitaq-about-button" href="<?php echo esc_url( $o['cta_btn1_url'] ); ?>"><?php echo esc_html( $o['cta_btn1_label'] ); ?></a>
				<a class="nitaq-about-button nitaq-about-button--outline" href="<?php echo esc_url( $o['cta_btn2_url'] ); ?>"><?php echo esc_html( $o['cta_btn2_label'] ); ?></a>
			</div>
		</div>
	</section>

</main>
		<?php
		return ob_get_clean();
	}

	add_shortcode( 'nitaq_about_page', 'nitaq_about_page_shortcode' );
}
