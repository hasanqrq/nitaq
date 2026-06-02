<?php
/**
 * Nitaq Model — Custom Post Type, Meta Boxes, Admin Assets
 *
 * Post type:  nitaq_model
 * Public:     false  (admin-only — no front-end URL)
 * Admin:      "أنماط سكنية" in WP sidebar
 * Meta keys:  _nitaq_model_{field_key}
 *             _nitaq_model_floors  (JSON array — floors/rooms repeater)
 *
 * Mirrors patterns from inc/nitaq-projects.php and the
 * nitaq_hero_slide meta box in functions.php.
 */

// ═══════════════════════════════════════════════════════════════════
// 1. CUSTOM POST TYPE
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_register_cpt' ) ) {
	function nitaq_model_register_cpt() {
		$labels = array(
			'name'               => 'أنماط سكنية',
			'singular_name'      => 'نمط سكني',
			'menu_name'          => 'أنماط سكنية',
			'add_new'            => 'إضافة نمط',
			'add_new_item'       => 'إضافة نمط سكني جديد',
			'edit_item'          => 'تعديل النمط السكني',
			'new_item'           => 'نمط سكني جديد',
			'view_item'          => 'عرض النمط',
			'all_items'          => 'كل الأنماط السكنية',
			'search_items'       => 'بحث في الأنماط السكنية',
			'not_found'          => 'لا توجد أنماط سكنية',
			'not_found_in_trash' => 'لا توجد أنماط في المهملات',
		);
		register_post_type(
			'nitaq_model',
			array(
				'labels'          => $labels,
				'description'     => 'Residential model types (Viora, Aurin, …)',
				'public'          => false,   // no front-end URL, no archive
				'show_ui'         => true,    // visible and editable in admin
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-admin-home',
				'menu_position'   => 27,      // below nitaq_project (26)
				'supports'        => array( 'title', 'thumbnail' ),
				// title = display name, e.g. "ڤيورا | Viora"
				'has_archive'     => false,
				'rewrite'         => false,
				'query_var'       => false,
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);
	}
	add_action( 'init', 'nitaq_model_register_cpt' );
}

// ═══════════════════════════════════════════════════════════════════
// 2. META FIELD MAP  (mirrors nitaq_project_meta_sections pattern)
//    key => ['label' => string, 'type' => text|textarea|image]
//    Meta keys stored as  _nitaq_model_{key}
//    Input names       as  nitaq_model_{key}
//    Floors/rooms are handled separately via _nitaq_model_floors (JSON).
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_meta_fields' ) ) {
	function nitaq_model_meta_fields() {
		return array(
			// ── معلومات النمط ──────────────────────────────────────────
			'type'       => array( 'label' => 'نوع النمط (مثال: فلل راقية)', 'type' => 'text' ),
			'body'       => array( 'label' => 'وصف النمط', 'type' => 'textarea' ),
			'land_area'  => array( 'label' => 'مساحة الأرض (مثال: من 250 م²)', 'type' => 'text' ),
			'built_area' => array( 'label' => 'مسطح البناء (مثال: 288.49 م²)', 'type' => 'text' ),
			// ── الصور ─────────────────────────────────────────────────
			'render'     => array( 'label' => 'صورة الرندر (URL)', 'type' => 'image' ),
			'render_alt' => array( 'label' => 'النص البديل للرندر', 'type' => 'text' ),
			'plan'       => array( 'label' => 'صورة المخطط (URL)', 'type' => 'image' ),
			'plan_alt'   => array( 'label' => 'النص البديل للمخطط', 'type' => 'text' ),
		);
	}
}

// ═══════════════════════════════════════════════════════════════════
// 3. META BOX — register
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_add_meta_box' ) ) {
	function nitaq_model_add_meta_box() {
		add_meta_box(
			'nitaq_model_details',
			'بيانات النمط السكني',
			'nitaq_model_render_meta_box',
			'nitaq_model',
			'normal',
			'high'
		);
	}
	add_action( 'add_meta_boxes', 'nitaq_model_add_meta_box' );
}

// ═══════════════════════════════════════════════════════════════════
// 4. META BOX — render
//    Sections: معلومات النمط | الصور | تفاصيل الأدوار والغرف (repeater)
//    Image fields: nhv2 picker pattern (.nmdl-mf / .nmdl-pick / .nmdl-clr)
//    Repeater: each floor block contains room rows; JS add/remove via
//    hidden <script type="text/html"> templates with __F__ / __R__ tokens.
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_render_meta_box' ) ) {
	function nitaq_model_render_meta_box( $post ) {
		wp_nonce_field( 'nitaq_model_meta_save', 'nitaq_model_meta_nonce' );

		$fields = nitaq_model_meta_fields();

		// Load saved floors; fall back to one empty starter floor with one room
		$floors_raw = get_post_meta( $post->ID, '_nitaq_model_floors', true );
		$floors     = json_decode( $floors_raw, true );
		if ( ! is_array( $floors ) || empty( $floors ) ) {
			$floors = array(
				array( 'label' => '', 'rooms' => array( array( 'name' => '', 'size' => '' ) ) ),
			);
		}
		?>
		<style>
		.nmdl-meta { direction: rtl; font-family: 'Tahoma', 'Arial', sans-serif; }
		.nmdl-meta h3 {
			margin: 18px 0 10px; padding: 7px 12px;
			background: #f8f9fa; border-right: 3px solid #B8AA76;
			font-size: 13px; font-weight: 600; border-radius: 2px;
		}
		.nmdl-field { margin-bottom: 16px; display: grid; gap: 5px; }
		.nmdl-field label { font-weight: 600; font-size: 12px; color: #444; }
		.nmdl-field input[type="text"],
		.nmdl-field textarea {
			width: 100%; padding: 7px 10px; border: 1px solid #ccc;
			border-radius: 4px; font-size: 14px; direction: rtl;
			font-family: inherit; box-sizing: border-box;
		}
		.nmdl-field textarea { height: 80px; resize: vertical; }
		.nmdl-mf-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
		.nmdl-mf-row input { flex: 1; min-width: 200px; direction: ltr;
			text-align: left; font-size: 12px; padding: 7px 10px;
			border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
		.nmdl-mpi { display: block; max-width: 260px; max-height: 150px;
			margin-top: 8px; border: 1px solid #ddd; border-radius: 4px;
			object-fit: cover; }
		/* ── Repeater ── */
		.nmdl-floor-block {
			border: 1px solid #ddd; border-radius: 4px; padding: 12px 14px;
			margin-bottom: 12px; background: #fff;
		}
		.nmdl-floor-header {
			display: flex; gap: 8px; align-items: center; margin-bottom: 10px;
		}
		.nmdl-floor-header input[type="text"] {
			flex: 1; padding: 6px 10px; border: 1px solid #ccc;
			border-radius: 4px; font-size: 13px; direction: rtl;
			font-family: inherit; box-sizing: border-box;
		}
		.nmdl-room-row {
			display: flex; gap: 8px; align-items: center; margin-bottom: 6px;
		}
		.nmdl-room-row input[type="text"] {
			padding: 5px 8px; border: 1px solid #ddd; border-radius: 4px;
			font-size: 13px; font-family: inherit; box-sizing: border-box;
		}
		.nmdl-room-row .nmdl-room-name { flex: 2; direction: rtl; }
		.nmdl-room-row .nmdl-room-size { flex: 1; direction: ltr; text-align: left; }
		</style>
		<div class="nmdl-meta">

			<h3>📋 معلومات النمط</h3>
			<div style="padding: 0 6px 4px;">
			<?php
			foreach ( array( 'type', 'body', 'land_area', 'built_area' ) as $key ) :
				$field      = $fields[ $key ];
				$meta_key   = '_nitaq_model_' . $key;
				$input_name = 'nitaq_model_' . $key;
				$value      = get_post_meta( $post->ID, $meta_key, true );
			?>
				<div class="nmdl-field">
					<label for="<?php echo esc_attr( $input_name ); ?>">
						<?php echo esc_html( $field['label'] ); ?>
					</label>
					<?php if ( 'textarea' === $field['type'] ) : ?>
						<textarea
							id="<?php echo esc_attr( $input_name ); ?>"
							name="<?php echo esc_attr( $input_name ); ?>"
						><?php echo esc_textarea( $value ); ?></textarea>
					<?php else : ?>
						<input type="text"
							id="<?php echo esc_attr( $input_name ); ?>"
							name="<?php echo esc_attr( $input_name ); ?>"
							value="<?php echo esc_attr( $value ); ?>">
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
			</div>

			<h3>🖼 الصور</h3>
			<div style="padding: 0 6px 4px;">
			<?php
			$image_pairs = array(
				array( 'img_key' => 'render', 'alt_key' => 'render_alt',
				       'img_label' => 'صورة الرندر', 'alt_label' => 'نص بديل — رندر' ),
				array( 'img_key' => 'plan',   'alt_key' => 'plan_alt',
				       'img_label' => 'صورة المخطط', 'alt_label' => 'نص بديل — مخطط' ),
			);
			foreach ( $image_pairs as $pair ) :
				$img_name = 'nitaq_model_' . $pair['img_key'];
				$alt_name = 'nitaq_model_' . $pair['alt_key'];
				$img_val  = get_post_meta( $post->ID, '_nitaq_model_' . $pair['img_key'], true );
				$alt_val  = get_post_meta( $post->ID, '_nitaq_model_' . $pair['alt_key'], true );
			?>
				<div class="nmdl-field">
					<label><?php echo esc_html( $pair['img_label'] ); ?></label>
					<div class="nmdl-mf" data-key="<?php echo esc_attr( $img_name ); ?>">
						<div class="nmdl-mf-row">
							<input type="url"
								id="<?php echo esc_attr( $img_name ); ?>"
								name="<?php echo esc_attr( $img_name ); ?>"
								value="<?php echo esc_url( $img_val ); ?>"
								placeholder="https://">
							<button type="button" class="button nmdl-pick"
								data-t="<?php echo esc_attr( $img_name ); ?>">📂 اختر</button>
							<button type="button" class="button nmdl-clr"
								data-t="<?php echo esc_attr( $img_name ); ?>"
								style="color:#b32d2e;<?php echo $img_val ? '' : 'display:none;'; ?>">✕ إزالة</button>
						</div>
						<img class="nmdl-mpi"
							src="<?php echo esc_url( $img_val ); ?>"
							style="<?php echo $img_val ? '' : 'display:none;'; ?>">
					</div>
				</div>
				<div class="nmdl-field">
					<label for="<?php echo esc_attr( $alt_name ); ?>">
						<?php echo esc_html( $pair['alt_label'] ); ?>
					</label>
					<input type="text"
						id="<?php echo esc_attr( $alt_name ); ?>"
						name="<?php echo esc_attr( $alt_name ); ?>"
						value="<?php echo esc_attr( $alt_val ); ?>">
				</div>
			<?php endforeach; ?>
			</div>

			<?php /* ─── FLOORS / ROOMS REPEATER ──────────────────────────────────
			       Input naming:
			         nitaq_model_floors[FINDEX][label]
			         nitaq_model_floors[FINDEX][rooms][RINDEX][name]
			         nitaq_model_floors[FINDEX][rooms][RINDEX][size]
			       PHP-rendered indexes are 0-based integers.
			       JS uses an ever-incrementing counter (starts at 10000) so
			       new indexes never collide with PHP-rendered ones.
			       Removing a row just deletes the DOM node; PHP reindexes on save.
			       ─────────────────────────────────────────────────────────────── */ ?>
			<h3>🏠 تفاصيل الأدوار والغرف</h3>
			<div style="padding: 0 6px 4px;" id="nmdl-floors-wrap">

				<?php foreach ( $floors as $fi => $floor ) :
					$floor_label = isset( $floor['label'] ) ? $floor['label'] : '';
					$rooms       = ( isset( $floor['rooms'] ) && is_array( $floor['rooms'] ) )
					               ? $floor['rooms']
					               : array( array( 'name' => '', 'size' => '' ) );
				?>
				<div class="nmdl-floor-block">
					<div class="nmdl-floor-header">
						<input type="text"
							name="nitaq_model_floors[<?php echo (int) $fi; ?>][label]"
							value="<?php echo esc_attr( $floor_label ); ?>"
							placeholder="اسم الدور (مثال: الدور الأرضي)">
						<button type="button" class="button nmdl-remove-floor"
							style="color:#b32d2e;">حذف الدور</button>
					</div>
					<div class="nmdl-rooms-wrap">
						<?php foreach ( $rooms as $ri => $room ) :
							$room_name = isset( $room['name'] ) ? $room['name'] : '';
							$room_size = isset( $room['size'] ) ? $room['size'] : '';
						?>
						<div class="nmdl-room-row">
							<input type="text"
								class="nmdl-room-name"
								name="nitaq_model_floors[<?php echo (int) $fi; ?>][rooms][<?php echo (int) $ri; ?>][name]"
								value="<?php echo esc_attr( $room_name ); ?>"
								placeholder="اسم الغرفة">
							<input type="text"
								class="nmdl-room-size"
								name="nitaq_model_floors[<?php echo (int) $fi; ?>][rooms][<?php echo (int) $ri; ?>][size]"
								value="<?php echo esc_attr( $room_size ); ?>"
								dir="ltr"
								placeholder="4.10 × 4.30 م">
							<button type="button" class="button nmdl-remove-room"
								style="color:#b32d2e;">✕</button>
						</div>
						<?php endforeach; ?>
					</div><!-- /.nmdl-rooms-wrap -->
					<button type="button" class="button nmdl-add-room"
						style="margin-top:6px;font-size:12px;">+ إضافة غرفة</button>
				</div><!-- /.nmdl-floor-block -->
				<?php endforeach; ?>

				<button type="button" class="button button-secondary nmdl-add-floor"
					style="margin-top:4px;">+ إضافة دور</button>

			</div><!-- /#nmdl-floors-wrap -->

			<?php /* ── Hidden templates: __F__ = floor index token, __R__ = room index token ── */ ?>

			<script type="text/html" id="nmdl-tpl-floor">
			<div class="nmdl-floor-block">
				<div class="nmdl-floor-header">
					<input type="text"
						name="nitaq_model_floors[__F__][label]"
						value=""
						placeholder="اسم الدور (مثال: الدور الأرضي)">
					<button type="button" class="button nmdl-remove-floor"
						style="color:#b32d2e;">حذف الدور</button>
				</div>
				<div class="nmdl-rooms-wrap">
					<div class="nmdl-room-row">
						<input type="text"
							class="nmdl-room-name"
							name="nitaq_model_floors[__F__][rooms][__R__][name]"
							value=""
							placeholder="اسم الغرفة">
						<input type="text"
							class="nmdl-room-size"
							name="nitaq_model_floors[__F__][rooms][__R__][size]"
							value=""
							dir="ltr"
							placeholder="4.10 × 4.30 م">
						<button type="button" class="button nmdl-remove-room"
							style="color:#b32d2e;">✕</button>
					</div>
				</div>
				<button type="button" class="button nmdl-add-room"
					style="margin-top:6px;font-size:12px;">+ إضافة غرفة</button>
			</div>
			</script>

			<script type="text/html" id="nmdl-tpl-room">
			<div class="nmdl-room-row">
				<input type="text"
					class="nmdl-room-name"
					name="nitaq_model_floors[__F__][rooms][__R__][name]"
					value=""
					placeholder="اسم الغرفة">
				<input type="text"
					class="nmdl-room-size"
					name="nitaq_model_floors[__F__][rooms][__R__][size]"
					value=""
					dir="ltr"
					placeholder="4.10 × 4.30 م">
				<button type="button" class="button nmdl-remove-room"
					style="color:#b32d2e;">✕</button>
			</div>
			</script>

		</div><!-- /.nmdl-meta -->
		<?php
	}
}

// ═══════════════════════════════════════════════════════════════════
// 5. SAVE HANDLER
//    Single nonce covers both simple fields and the floors repeater.
//    Mirrors nitaq_hero_slide save: nonce → autosave → capability → sanitize.
//    Floors: read $_POST['nitaq_model_floors'], sanitize each field,
//    skip empty rooms/floors, reindex with array_values(), save as JSON.
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_save_meta' ) ) {
	function nitaq_model_save_meta( $post_id ) {

		// Nonce check
		if ( ! isset( $_POST['nitaq_model_meta_nonce'] ) ||
			 ! wp_verify_nonce(
				 sanitize_text_field( wp_unslash( $_POST['nitaq_model_meta_nonce'] ) ),
				 'nitaq_model_meta_save'
			 ) ) {
			return;
		}

		// Autosave bail-out
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Capability check
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// ── Simple fields ─────────────────────────────────────────────
		$fields = nitaq_model_meta_fields();
		foreach ( $fields as $key => $field ) {
			$input_name = 'nitaq_model_' . $key;
			$meta_key   = '_nitaq_model_' . $key;
			$raw        = isset( $_POST[ $input_name ] )
			              ? wp_unslash( $_POST[ $input_name ] )
			              : '';

			if ( 'textarea' === $field['type'] ) {
				$value = sanitize_textarea_field( $raw );
			} elseif ( 'image' === $field['type'] ) {
				$value = esc_url_raw( trim( (string) $raw ) );
			} else {
				$value = sanitize_text_field( $raw );
			}

			update_post_meta( $post_id, $meta_key, $value );
		}

		// ── Floors / rooms repeater ────────────────────────────────────
		// $_POST['nitaq_model_floors'] is a numerically-indexed array from
		// the form, potentially with gaps from removed rows — PHP preserves
		// those gaps; we rebuild a clean dense array here.
		$raw_floors = ( isset( $_POST['nitaq_model_floors'] ) && is_array( $_POST['nitaq_model_floors'] ) )
		              ? wp_unslash( $_POST['nitaq_model_floors'] )
		              : array();

		$clean_floors = array();

		foreach ( $raw_floors as $floor_data ) {
			if ( ! is_array( $floor_data ) ) {
				continue;
			}

			$floor_label = sanitize_text_field(
				trim( isset( $floor_data['label'] ) ? (string) $floor_data['label'] : '' )
			);

			$clean_rooms = array();
			$raw_rooms   = ( isset( $floor_data['rooms'] ) && is_array( $floor_data['rooms'] ) )
			               ? $floor_data['rooms']
			               : array();

			foreach ( $raw_rooms as $room_data ) {
				if ( ! is_array( $room_data ) ) {
					continue;
				}
				$r_name = sanitize_text_field( trim( isset( $room_data['name'] ) ? (string) $room_data['name'] : '' ) );
				$r_size = sanitize_text_field( trim( isset( $room_data['size'] ) ? (string) $room_data['size'] : '' ) );

				// Skip room if BOTH name and size are empty
				if ( '' === $r_name && '' === $r_size ) {
					continue;
				}
				$clean_rooms[] = array( 'name' => $r_name, 'size' => $r_size );
			}

			// Skip floor if its label is empty AND it has no rooms
			if ( '' === $floor_label && empty( $clean_rooms ) ) {
				continue;
			}

			$clean_floors[] = array(
				'label' => $floor_label,
				'rooms' => $clean_rooms,
			);
		}

		// array_values() reindexes the final array (dense 0-based)
		$clean_floors = array_values( $clean_floors );

		update_post_meta(
			$post_id,
			'_nitaq_model_floors',
			wp_json_encode( $clean_floors, JSON_UNESCAPED_UNICODE )
		);
	}
	add_action( 'save_post_nitaq_model', 'nitaq_model_save_meta' );
}

// ═══════════════════════════════════════════════════════════════════
// 6. ADMIN ASSETS
//    Mirrors hendon_child_nitaq_hero_admin_assets() pattern.
//    Single inline JS block covers both:
//      a) Media pickers (.nmdl-pick / .nmdl-clr)
//      b) Floors/rooms repeater (add/remove floor, add/remove room)
//
//    Repeater JS notes:
//    - nmdlCtr starts at 10000 to avoid collisions with PHP-rendered
//      integer indexes (which are always 0-based and < number of floors).
//    - Add-floor clones #nmdl-tpl-floor, replacing __F__ and __R__.
//    - Add-room clones #nmdl-tpl-room, finding floor index from an
//      existing sibling input's name attribute, then replacing __F__/__R__.
//    - Remove: just removes the nearest .nmdl-floor-block or .nmdl-room-row.
//      PHP reindexes on save — no JS reindex needed.
// ═══════════════════════════════════════════════════════════════════

if ( ! function_exists( 'nitaq_model_admin_assets' ) ) {
	function nitaq_model_admin_assets( $hook ) {
		$screen = get_current_screen();

		if ( ! $screen || 'nitaq_model' !== $screen->post_type ) {
			return;
		}

		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );

		wp_add_inline_script(
			'jquery-core',
			<<<'JS'
(function($){

  /* ── Media pickers ─────────────────────────────────────────────── */

  function nmdlPreview(t, u) {
    var w = $('#' + t).closest('.nmdl-mf');
    var img = w.find('.nmdl-mpi');
    var clr = w.find('.nmdl-clr');
    if (u) {
      img.attr('src', u).show();
      clr.show();
    } else {
      img.attr('src', '').hide();
      clr.hide();
    }
  }

  $(document).on('click', '.nmdl-pick', function(e) {
    e.preventDefault();
    var t = $(this).data('t');
    var frame = wp.media({
      title:  'اختيار الصورة',
      button: { text: 'استخدام هذه الصورة' },
      multiple: false
    });
    frame.on('select', function() {
      var f = frame.state().get('selection').first().toJSON();
      $('#' + t).val(f.url).trigger('change');
      nmdlPreview(t, f.url);
    });
    frame.open();
  });

  $(document).on('click', '.nmdl-clr', function(e) {
    e.preventDefault();
    var t = $(this).data('t');
    $('#' + t).val('').trigger('change');
    nmdlPreview(t, '');
  });

  /* ── Floors / rooms repeater ────────────────────────────────────
     nmdlCtr: ever-incrementing counter, starts at 10000 so new
     indexes never collide with the 0-based PHP-rendered indexes.    */

  var nmdlCtr = 10000;

  /* Render a new floor block (includes one starter room) */
  function nmdlNewFloor() {
    var f = nmdlCtr++;
    var r = nmdlCtr++;
    var tpl = $('#nmdl-tpl-floor').html();
    return tpl.replace(/__F__/g, String(f)).replace(/__R__/g, String(r));
  }

  /* Render a new room row, scoped to a known floor index */
  function nmdlNewRoom(fIdx) {
    var r = nmdlCtr++;
    var tpl = $('#nmdl-tpl-room').html();
    return tpl.replace(/__F__/g, String(fIdx)).replace(/__R__/g, String(r));
  }

  /* Extract floor index from the first input name inside a .nmdl-floor-block */
  function nmdlFloorIdx(floorBlock) {
    var inp = floorBlock.find('input[name*="nitaq_model_floors["]').first();
    if (!inp.length) { return nmdlCtr++; }
    var m = inp.attr('name').match(/nitaq_model_floors\[(\d+)\]/);
    return m ? m[1] : String(nmdlCtr++);
  }

  /* Add floor — insert before the "إضافة دور" button */
  $(document).on('click', '.nmdl-add-floor', function(e) {
    e.preventDefault();
    $(this).before(nmdlNewFloor());
  });

  /* Add room — scoped to the floor block containing the clicked button */
  $(document).on('click', '.nmdl-add-room', function(e) {
    e.preventDefault();
    var floor = $(this).closest('.nmdl-floor-block');
    var fIdx  = nmdlFloorIdx(floor);
    floor.find('.nmdl-rooms-wrap').append(nmdlNewRoom(fIdx));
  });

  /* Remove floor */
  $(document).on('click', '.nmdl-remove-floor', function(e) {
    e.preventDefault();
    $(this).closest('.nmdl-floor-block').remove();
  });

  /* Remove room */
  $(document).on('click', '.nmdl-remove-room', function(e) {
    e.preventDefault();
    $(this).closest('.nmdl-room-row').remove();
  });

})(jQuery);
JS
		);
	}
	add_action( 'admin_enqueue_scripts', 'nitaq_model_admin_assets' );
}
