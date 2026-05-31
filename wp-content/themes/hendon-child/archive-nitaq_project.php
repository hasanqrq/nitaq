<?php
/**
 * Archive template for nitaq_project CPT.
 * Renders [nitaq_projects_grid] on /projects/.
 */

get_header();
?>
<div class="nitaq-project-archive-wrapper" dir="rtl" style="background:#0F302D;min-height:60vh;">

	<div class="nitaq-projects-archive-head" style="text-align:center;padding:100px 20px 40px;background:#0F302D;">
		<p class="nitaq-project-kicker" style="color:#B8AA76;font-size:0.85rem;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:12px;">نطاق الأولى للتطوير العقاري</p>
		<h1 style="color:#F7F4EC;font-size:clamp(2rem,5vw,3.2rem);margin:0 0 16px;">مشاريعنا</h1>
		<p style="color:rgba(247,244,236,0.7);font-size:1.05rem;max-width:540px;margin:0 auto;line-height:1.7;">مجتمعات سكنية عصرية ترتكز على جودة الحياة، التخطيط المتكامل، والشراكات الموثوقة.</p>
	</div>

	<?php echo do_shortcode('[nitaq_projects_grid limit="12"]'); ?>

</div>
<?php get_footer(); ?>
