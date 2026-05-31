<?php
/**
 * Nitaq Footer — dashboard settings page + frontend renderer.
 *
 * Replaces the Hendon parent-theme sidebar-based footer with a
 * settings-driven custom footer. The parent footer action is removed
 * via after_setup_theme and our renderer is added in its place.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ─── Default values ─────────────────────────────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_defaults' ) ) {
	function hendon_child_nitaq_footer_defaults() {
		return array(
			// Brand
			'logo_url'          => '',
			'company_name'      => 'شركة نطاق الأولى للتطوير العقاري',
			'company_desc'      => 'نطاق الأولى تطوّر مجتمعات سكنية عصرية ترتكز على جودة الحياة، التخطيط المتكامل، والشراكات الموثوقة.',
			// CTA
			'cta_enabled'       => '1',
			'cta_heading'       => 'ابدأ رحلتك مع نطاق الأولى',
			'cta_text'          => 'اكتشف مجتمعات سكنية مصممة حول جودة الحياة.',
			'cta_btn_label'     => 'سجّل اهتمامك',
			'cta_btn_url'       => '/register-interest/',
			// Quick links
			'links_title'       => 'روابط سريعة',
			'link_1_label'      => 'الرئيسية',
			'link_1_url'        => '/',
			'link_2_label'      => 'من نحن',
			'link_2_url'        => '/about-us/',
			'link_3_label'      => 'مشاريعنا',
			'link_3_url'        => '/projects/',
			'link_4_label'      => 'المخطط العام',
			'link_4_url'        => '/master-plan/',
			'link_5_label'      => 'تواصل معنا',
			'link_5_url'        => '/contact-us/',
			'link_6_label'      => '',
			'link_6_url'        => '',
			// Projects
			'projects_title'    => 'مشاريعنا',
			'proj_1_label'      => 'ذا جروفز',
			'proj_1_url'        => '/projects/the-groves/',
			'proj_2_label'      => '',
			'proj_2_url'        => '',
			'proj_3_label'      => '',
			'proj_3_url'        => '',
			// Contact
			'contact_title'     => 'تواصل معنا',
			'contact_company'   => 'شركة نطاق الأولى للتطوير العقاري',
			'contact_address'   => 'مبنى 3769 - أ. بكر الصديق الفرعي - حي الربيع، الرياض 13316 - 8580، المملكة العربية السعودية',
			'contact_phone'     => '920017206',
			'contact_btn_label' => 'اتصل بنا',
			'contact_btn_url'   => 'tel:920017206',
			// Bottom
			'copyright'         => 'جميع الحقوق محفوظة لشركة نطاق الأولى للتطوير العقاري © 2025',
		);
	}
}

/* ─── Get merged settings (saved + defaults) ─────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_get' ) ) {
	function hendon_child_nitaq_footer_get() {
		$saved = get_option( 'nitaq_footer_settings', array() );
		return wp_parse_args( is_array( $saved ) ? $saved : array(), hendon_child_nitaq_footer_defaults() );
	}
}

/* ─── URL sanitizer — accepts relative paths, tel, mailto, http/s ── */

if ( ! function_exists( 'nitaq_sanitize_footer_url' ) ) {
	function nitaq_sanitize_footer_url( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return '';
		}

		// Relative path
		if ( '/' === $value[0] ) {
			return esc_url_raw( $value );
		}

		// Anchor
		if ( '#' === $value[0] ) {
			return '#' . sanitize_text_field( substr( $value, 1 ) );
		}

		// Allowed protocols: http, https, tel, mailto
		if (
			0 === strncmp( $value, 'tel:', 4 )     ||
			0 === strncmp( $value, 'mailto:', 7 )  ||
			0 === strncmp( $value, 'http://', 7 )  ||
			0 === strncmp( $value, 'https://', 8 )
		) {
			return esc_url_raw( $value );
		}

		// Anything else: treat as relative path by prepending /
		return esc_url_raw( '/' . ltrim( $value, '/' ) );
	}
}

/* ─── Admin menu registration ────────────────────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_admin_menu' ) ) {
	function hendon_child_nitaq_footer_admin_menu() {
		add_theme_page(
			'إعدادات فوتر نطاق',
			'إعدادات فوتر نطاق',
			'manage_options',
			'nitaq-footer-settings',
			'hendon_child_nitaq_footer_admin_page'
		);
	}
	add_action( 'admin_menu', 'hendon_child_nitaq_footer_admin_menu' );
}

/* ─── Admin page + inline save ───────────────────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_admin_page' ) ) {
	function hendon_child_nitaq_footer_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$notice = '';

		if (
			isset( $_POST['nitaq_footer_nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nitaq_footer_nonce'] ) ), 'nitaq_footer_save' )
		) {
			$raw      = isset( $_POST['nitaq_footer'] ) && is_array( $_POST['nitaq_footer'] )
				? wp_unslash( $_POST['nitaq_footer'] ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				: array();
			$defaults = hendon_child_nitaq_footer_defaults();
			$clean    = array();

			$url_keys = array(
				'logo_url',
				'cta_btn_url',
				'link_1_url', 'link_2_url', 'link_3_url',
				'link_4_url', 'link_5_url', 'link_6_url',
				'proj_1_url', 'proj_2_url', 'proj_3_url',
				'contact_btn_url',
			);

			foreach ( array_keys( $defaults ) as $key ) {
				if ( 'cta_enabled' === $key ) {
					$clean[ $key ] = ! empty( $raw[ $key ] ) ? '1' : '0';
				} elseif ( in_array( $key, $url_keys, true ) ) {
					$clean[ $key ] = isset( $raw[ $key ] ) ? nitaq_sanitize_footer_url( $raw[ $key ] ) : '';
				} else {
					$clean[ $key ] = isset( $raw[ $key ] ) ? sanitize_textarea_field( $raw[ $key ] ) : '';
				}
			}

			update_option( 'nitaq_footer_settings', $clean );
			$notice = '<div class="notice notice-success is-dismissible"><p>تم حفظ إعدادات الفوتر بنجاح.</p></div>';
		}

		$s = hendon_child_nitaq_footer_get();

		echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already escaped above
		?>
		<div class="wrap" dir="rtl" style="max-width:920px;">
			<h1 style="margin-bottom:24px;">إعدادات فوتر نطاق</h1>
			<form method="post" action="">
				<?php wp_nonce_field( 'nitaq_footer_save', 'nitaq_footer_nonce' ); ?>

				<?php
				// Helpers — defined as closures inside the function scope
				$text_row = function( $label, $key, $type = 'text' ) use ( $s ) {
					$id  = 'nf_' . esc_attr( $key );
					$val = esc_attr( isset( $s[ $key ] ) ? $s[ $key ] : '' );
					printf(
						'<tr><th scope="row"><label for="%1$s">%2$s</label></th>'
						. '<td><input id="%1$s" name="nitaq_footer[%3$s]" type="%4$s" value="%5$s" class="regular-text" dir="rtl"></td></tr>',
						$id,
						esc_html( $label ),
						esc_attr( $key ),
						esc_attr( $type ),
						$val
					);
				};

				$textarea_row = function( $label, $key ) use ( $s ) {
					$id  = 'nf_' . esc_attr( $key );
					$val = esc_textarea( isset( $s[ $key ] ) ? $s[ $key ] : '' );
					printf(
						'<tr><th scope="row"><label for="%1$s">%2$s</label></th>'
						. '<td><textarea id="%1$s" name="nitaq_footer[%3$s]" rows="3" class="large-text" dir="rtl">%4$s</textarea></td></tr>',
						$id,
						esc_html( $label ),
						esc_attr( $key ),
						$val
					);
				};

				$section_head = function( $title ) {
					echo '<h2 style="border-bottom:1px solid #ddd;padding-bottom:8px;margin-top:32px;">'
						. esc_html( $title ) . '</h2>';
				};

				// URL fields use type="text" + LTR direction so relative paths,
				// tel:, mailto:, and anchors are all accepted without browser errors.
				$url_row = function( $label, $key ) use ( $s ) {
					$id  = 'nf_' . esc_attr( $key );
					$val = esc_attr( isset( $s[ $key ] ) ? $s[ $key ] : '' );
					printf(
						'<tr><th scope="row"><label for="%1$s">%2$s</label></th>'
						. '<td>'
						. '<input id="%1$s" name="nitaq_footer[%3$s]" type="text" value="%4$s" class="regular-text" dir="ltr">'
						. '<p class="description" style="margin-top:6px;">يمكن استخدام رابط نسبي مثل <code>/contact-us/</code> أو رابط كامل مثل <code>https://example.com</code> أو <code>tel:920017206</code></p>'
						. '</td></tr>',
						$id,
						esc_html( $label ),
						esc_attr( $key ),
						$val
					);
				};
				?>

				<?php $section_head( 'القسم الأول — الهوية والشعار' ); ?>
				<table class="form-table" role="presentation">
					<?php
					$url_row( 'رابط الشعار (URL)', 'logo_url' );
					$text_row( 'اسم الشركة', 'company_name' );
					$textarea_row( 'وصف الشركة', 'company_desc' );
					?>
				</table>

				<?php $section_head( 'القسم الثاني — شريط الدعوة (CTA)' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">تفعيل شريط الدعوة</th>
						<td>
							<label>
								<input type="checkbox" name="nitaq_footer[cta_enabled]" value="1"
									<?php checked( '1', $s['cta_enabled'] ); ?>>
								إظهار شريط الدعوة في أعلى الفوتر
							</label>
						</td>
					</tr>
					<?php
					$text_row( 'عنوان الدعوة', 'cta_heading' );
					$text_row( 'نص الدعوة', 'cta_text' );
					$text_row( 'نص الزر', 'cta_btn_label' );
					$url_row( 'رابط الزر', 'cta_btn_url' );
					?>
				</table>

				<?php $section_head( 'القسم الثالث — الروابط السريعة' ); ?>
				<table class="form-table" role="presentation">
					<?php $text_row( 'عنوان القسم', 'links_title' ); ?>
					<?php for ( $i = 1; $i <= 6; $i++ ) :
						$lkey = 'link_' . $i . '_label';
						$ukey = 'link_' . $i . '_url';
						$lval = esc_attr( isset( $s[ $lkey ] ) ? $s[ $lkey ] : '' );
						$uval = esc_attr( isset( $s[ $ukey ] ) ? $s[ $ukey ] : '' );
						?>
					<tr>
						<th scope="row"><?php echo esc_html( 'رابط ' . $i ); ?></th>
						<td>
							<input name="nitaq_footer[<?php echo esc_attr( $lkey ); ?>]"
								type="text" value="<?php echo $lval; ?>"
								placeholder="التسمية" style="width:180px;margin-left:12px;" dir="rtl">
							<input name="nitaq_footer[<?php echo esc_attr( $ukey ); ?>]"
								type="text" value="<?php echo $uval; ?>"
								placeholder="/path/" style="width:280px;" dir="ltr">
						</td>
					</tr>
					<?php endfor; ?>
				</table>

				<?php $section_head( 'القسم الرابع — المشاريع' ); ?>
				<table class="form-table" role="presentation">
					<?php $text_row( 'عنوان القسم', 'projects_title' ); ?>
					<?php for ( $i = 1; $i <= 3; $i++ ) :
						$lkey = 'proj_' . $i . '_label';
						$ukey = 'proj_' . $i . '_url';
						$lval = esc_attr( isset( $s[ $lkey ] ) ? $s[ $lkey ] : '' );
						$uval = esc_attr( isset( $s[ $ukey ] ) ? $s[ $ukey ] : '' );
						?>
					<tr>
						<th scope="row"><?php echo esc_html( 'مشروع ' . $i ); ?></th>
						<td>
							<input name="nitaq_footer[<?php echo esc_attr( $lkey ); ?>]"
								type="text" value="<?php echo $lval; ?>"
								placeholder="اسم المشروع" style="width:180px;margin-left:12px;" dir="rtl">
							<input name="nitaq_footer[<?php echo esc_attr( $ukey ); ?>]"
								type="text" value="<?php echo $uval; ?>"
								placeholder="/projects/..." style="width:280px;" dir="ltr">
						</td>
					</tr>
					<?php endfor; ?>
				</table>

				<?php $section_head( 'القسم الخامس — التواصل' ); ?>
				<table class="form-table" role="presentation">
					<?php
					$text_row( 'عنوان القسم', 'contact_title' );
					$text_row( 'اسم الشركة (في عمود التواصل)', 'contact_company' );
					$textarea_row( 'العنوان', 'contact_address' );
					$text_row( 'رقم الهاتف', 'contact_phone' );
					$text_row( 'نص زر التواصل', 'contact_btn_label' );
					$url_row( 'رابط زر التواصل', 'contact_btn_url' );
					?>
				</table>

				<?php $section_head( 'القسم السادس — شريط الحقوق' ); ?>
				<table class="form-table" role="presentation">
					<?php $text_row( 'نص حقوق الملكية', 'copyright' ); ?>
				</table>

				<?php submit_button( 'حفظ الإعدادات', 'primary', 'submit', true, array( 'style' => 'margin-top:20px;' ) ); ?>
			</form>
		</div>
		<?php
	}
}

/* ─── Frontend renderer ──────────────────────────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_render' ) ) {
	function hendon_child_nitaq_footer_render() {
		$s = hendon_child_nitaq_footer_get();

		// Resolve logo: settings URL → WP custom logo → nothing
		$logo_url = '';
		if ( ! empty( $s['logo_url'] ) ) {
			$logo_url = esc_url( $s['logo_url'] );
		} else {
			$logo_id = get_theme_mod( 'custom_logo' );
			if ( $logo_id ) {
				$logo_src = wp_get_attachment_image_src( (int) $logo_id, 'medium' );
				$logo_url = ! empty( $logo_src[0] ) ? esc_url( $logo_src[0] ) : '';
			}
		}

		$cta_on = ( '1' === $s['cta_enabled'] );
		?>
<footer class="nitaq-footer" dir="rtl">

	<?php if ( $cta_on ) : ?>
	<div class="nitaq-footer__cta">
		<div class="nitaq-footer__inner">
			<div class="nitaq-footer__cta-inner">
				<div class="nitaq-footer__cta-text">
					<h2 class="nitaq-footer__cta-heading"><?php echo esc_html( $s['cta_heading'] ); ?></h2>
					<?php if ( ! empty( $s['cta_text'] ) ) : ?>
					<p class="nitaq-footer__cta-sub"><?php echo esc_html( $s['cta_text'] ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $s['cta_btn_label'] ) && ! empty( $s['cta_btn_url'] ) ) : ?>
				<a href="<?php echo esc_url( $s['cta_btn_url'] ); ?>" class="nitaq-footer__cta-btn">
					<?php echo esc_html( $s['cta_btn_label'] ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="nitaq-footer__main">
		<div class="nitaq-footer__inner">
			<div class="nitaq-footer__grid">

				<!-- Column 1 — Brand -->
				<div class="nitaq-footer__col nitaq-footer__brand">
					<?php if ( $logo_url ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nitaq-footer__logo-wrap"
						aria-label="<?php echo esc_attr( $s['company_name'] ); ?>">
						<img src="<?php echo $logo_url; ?>"
							alt="<?php echo esc_attr( $s['company_name'] ); ?>"
							class="nitaq-footer__logo" loading="lazy">
					</a>
					<?php else : ?>
					<p class="nitaq-footer__company-name"><?php echo esc_html( $s['company_name'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $s['company_desc'] ) ) : ?>
					<p class="nitaq-footer__description"><?php echo esc_html( $s['company_desc'] ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Column 2 — Quick links -->
				<div class="nitaq-footer__col">
					<?php if ( ! empty( $s['links_title'] ) ) : ?>
					<h3 class="nitaq-footer__heading"><?php echo esc_html( $s['links_title'] ); ?></h3>
					<?php endif; ?>
					<ul class="nitaq-footer__links">
						<?php
						for ( $i = 1; $i <= 6; $i++ ) {
							$lbl = isset( $s[ 'link_' . $i . '_label' ] ) ? $s[ 'link_' . $i . '_label' ] : '';
							$url = isset( $s[ 'link_' . $i . '_url' ] )   ? $s[ 'link_' . $i . '_url' ]   : '';
							if ( '' === $lbl ) {
								continue;
							}
							if ( '' !== $url ) {
								echo '<li><a href="' . esc_url( $url ) . '" class="nitaq-footer__link">'
									. esc_html( $lbl ) . '</a></li>';
							} else {
								echo '<li><span class="nitaq-footer__link">' . esc_html( $lbl ) . '</span></li>';
							}
						}
						?>
					</ul>
				</div>

				<!-- Column 3 — Projects -->
				<div class="nitaq-footer__col">
					<?php if ( ! empty( $s['projects_title'] ) ) : ?>
					<h3 class="nitaq-footer__heading"><?php echo esc_html( $s['projects_title'] ); ?></h3>
					<?php endif; ?>
					<ul class="nitaq-footer__links">
						<?php
						for ( $i = 1; $i <= 3; $i++ ) {
							$lbl = isset( $s[ 'proj_' . $i . '_label' ] ) ? $s[ 'proj_' . $i . '_label' ] : '';
							$url = isset( $s[ 'proj_' . $i . '_url' ] )   ? $s[ 'proj_' . $i . '_url' ]   : '';
							if ( '' === $lbl ) {
								continue;
							}
							if ( '' !== $url ) {
								echo '<li><a href="' . esc_url( $url ) . '" class="nitaq-footer__link">'
									. esc_html( $lbl ) . '</a></li>';
							} else {
								echo '<li><span class="nitaq-footer__link">' . esc_html( $lbl ) . '</span></li>';
							}
						}
						?>
					</ul>
				</div>

				<!-- Column 4 — Contact -->
				<div class="nitaq-footer__col nitaq-footer__contact">
					<?php if ( ! empty( $s['contact_title'] ) ) : ?>
					<h3 class="nitaq-footer__heading"><?php echo esc_html( $s['contact_title'] ); ?></h3>
					<?php endif; ?>
					<address>
						<?php if ( ! empty( $s['contact_company'] ) ) : ?>
						<p class="nitaq-footer__contact-name"><?php echo esc_html( $s['contact_company'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['contact_address'] ) ) : ?>
						<p><?php echo esc_html( $s['contact_address'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['contact_phone'] ) ) :
							$phone_tel = preg_replace( '/[^0-9+]/', '', $s['contact_phone'] );
							?>
						<p>
							<a href="tel:<?php echo esc_attr( $phone_tel ); ?>">
								<?php echo esc_html( $s['contact_phone'] ); ?>
							</a>
						</p>
						<?php endif; ?>
					</address>
					<?php if ( ! empty( $s['contact_btn_label'] ) && ! empty( $s['contact_btn_url'] ) ) : ?>
					<a href="<?php echo esc_url( $s['contact_btn_url'] ); ?>" class="nitaq-footer__contact-btn">
						<?php echo esc_html( $s['contact_btn_label'] ); ?>
					</a>
					<?php endif; ?>
				</div>

			</div><!-- /.nitaq-footer__grid -->
		</div><!-- /.nitaq-footer__inner -->
	</div><!-- /.nitaq-footer__main -->

	<div class="nitaq-footer__bottom">
		<div class="nitaq-footer__inner">
			<p class="nitaq-footer__copyright"><?php echo esc_html( $s['copyright'] ); ?></p>
		</div>
	</div>

</footer>
		<?php
	}
}

/* ─── Hook: swap parent footer for ours ─────────────────────────── */

if ( ! function_exists( 'hendon_child_nitaq_footer_init' ) ) {
	function hendon_child_nitaq_footer_init() {
		// Remove the Hendon parent footer (registered in inc/footer/helper.php at priority 10)
		remove_action( 'hendon_action_page_footer_template', 'hendon_load_page_footer' );
		// Register our replacement at the same hook
		add_action( 'hendon_action_page_footer_template', 'hendon_child_nitaq_footer_render' );
	}
	add_action( 'after_setup_theme', 'hendon_child_nitaq_footer_init', 20 );
}
