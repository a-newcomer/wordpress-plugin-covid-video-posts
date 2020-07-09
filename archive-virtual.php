<?php
/* This page goes with the vx(virtual) post types plugin custom built for the SpeakWellBeing Website to showcase speakers during the Coronavirus pandemic.
	
* * * * Styles are to be found in the vx-post-types plugin folder */
?>

<?php
	get_header();
	// Get site options
	$site_info = get_fields('option');

	// Set post data so we don't have to use the wp loop
	setup_postdata($post);

	if (is_single()) {
		// See if the current page has a featured image
		$attachment_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
	
		// Use featured image if present, sub page default if not
		$bg_src = !empty($attachment_src[0]) ? $attachment_src[0] : $site_info['default_background_image'];
	} else {
		$bg_src = $site_info['default_background_image'];
	}
?>
<!-- content -->

<div id="blogPage virtualResourcesPage" class="container-fluid no-gutter sub-page-wrapper">
	<div id="subPageHead" class="col-xs-12 no-gutter parallax-window" data-parallax="scroll" data-image-src="<?= $bg_src; ?>">
	</div><!-- subPageHead -->

	<div class="sub-page-container container">
		<div class="row">
			<header class="entry-header col-xs-12">
				
					<h1 class="entry-title">
						Resources for Hosting Virtual Events
						<?php if ( is_category() ): ?>
							<?php echo 'Category: ' . single_cat_title( '', false); ?>
						<?php endif ?>
					</h1>
				
			</header><!-- .entry-header -->
		</div>

		<!-- posts/pages for current URL? -->
		<?php if ( have_posts() ) : ?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 <?= ( is_single() ? 'blog-entry' : 'blog-list' ) ?>">
			<!-- Start the Loop -->
			<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('content', get_post_format()) ?>
		<!-- here is where i removed the blog loop for archive page blog entries and put them in content and video-content files -->

			<?php endwhile; // have_posts() ?>
			</div>

			<!-- <div id="blogSidebar" class="col-xs-12 col-sm-4 blog-sidebar">
				<ul id="sidebar">
				<?php if ( !dynamic_sidebar(__('Blog Sidebar')) ) : ?>
				<?php endif; ?>
				</ul>
			</div> -->
		
		
		</div>

		<div class="row">
			<?php if ( is_single() ) : ?>
			<nav id="blogNavigation" class="col-xs-12 blog-navigation">
				<div class="col-xs-6 text-left"><?php previous_post_link() ?></div>
				<div class="col-xs-6 text-right"><?php next_post_link() ?></div>
			</nav>
			<?php else : ?>
			<nav id="blogPagination" class="col-xs-12 blog-pagination">
				<ul class="pagination">
					<?php
						$links = paginate_links([
							'prev_text'          => '&laquo;',
							'next_text'          => '&raquo;',
							'type'               => 'array',
						]);

						if (!empty($links)) {
							echo implode('', array_map(function($link) {
								if (strpos($link, 'aria-current') !== false) {
									return '<li class="active">' . $link . '</li>';
								} elseif (strpos($link, 'page-numbers dots') !== false) {
									return '<li class="disabled">' . $link . '</li>';
								} else {
									return '<li>' . $link . '</li>';
								}
							}, $links));
						}
					?>
				</ul>
			</nav>
			<?php endif ?>
		</div>
		<?php endif; // have_posts() ?>
	</div><!-- container -->
</div><!-- container-fluid -->

<?php
	get_footer();
?>
