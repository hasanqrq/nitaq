<?php
get_header();
?>

<main class="nitaq-news-page nitaq-news-archive" dir="rtl">
	<section class="nitaq-news-hero">
		<div class="nitaq-news-container">
			<span>شركة نطاق الأولى للتطوير العقاري</span>
			<h1>الأخبار</h1>
			<p>آخر أخبار ومستجدات شركة نطاق الأولى للتطوير العقاري</p>
		</div>
	</section>

	<section class="nitaq-news-listing">
		<div class="nitaq-news-container">
			<?php if ( have_posts() ) : ?>
				<div class="nitaq-news-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						echo hendon_child_nitaq_news_card(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					endwhile;
					?>
				</div>
				<div class="nitaq-news-pagination">
					<?php
					the_posts_pagination(
						array(
							'prev_text' => 'السابق',
							'next_text' => 'التالي',
						)
					);
					?>
				</div>
			<?php else : ?>
				<p class="nitaq-news-empty">سيتم نشر الأخبار قريبًا.</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
