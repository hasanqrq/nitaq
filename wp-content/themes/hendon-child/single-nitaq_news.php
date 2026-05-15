<?php
get_header();

$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );

if ( ! $image ) {
	$image = home_url( '/wp-content/uploads/2026/05/theWholeProject.png' );
}
?>

<main class="nitaq-news-page nitaq-news-single" dir="rtl">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article>
			<section class="nitaq-news-single-hero">
				<div class="nitaq-news-single-hero__image" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
				<div class="nitaq-news-single-hero__overlay"></div>
				<div class="nitaq-news-container">
					<span><?php echo esc_html( hendon_child_nitaq_news_date() ); ?></span>
					<h1><?php the_title(); ?></h1>
				</div>
			</section>

			<section class="nitaq-news-single-content">
				<div class="nitaq-news-container nitaq-news-single-content__inner">
					<?php the_content(); ?>
					<a class="nitaq-news-card__button" href="<?php echo esc_url( home_url( '/news/' ) ); ?>">العودة إلى الأخبار</a>
				</div>
			</section>
		</article>
		<?php
	endwhile;

	$related = new WP_Query(
		array(
			'post_type'           => 'nitaq_news',
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		)
	);

	if ( $related->have_posts() ) :
		?>
		<section class="nitaq-news-related">
			<div class="nitaq-news-container">
				<div class="nitaq-news-heading">
					<span>أخبار ذات صلة</span>
					<h2>مستجدات أخرى</h2>
				</div>
				<div class="nitaq-news-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						echo hendon_child_nitaq_news_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
