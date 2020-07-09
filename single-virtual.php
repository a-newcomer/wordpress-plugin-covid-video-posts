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

<div id="blogPage virtual-resources-page" class="container-fluid no-gutter sub-page-wrapper">

	<div class="container">
		<div id="subPageTagLine"><?php the_field('sub_page_tagline', 'option'); ?></div>
	</div>

	<div id="subPageHead" class="col-xs-12 no-gutter parallax-window" data-parallax="scroll" data-image-src="<?= $bg_src; ?>">
	</div><!-- subPageHead -->

	<div class="sub-page-container container">
		<div class="row">
			<header class="entry-header col-xs-12">
				<?php 
					if ( is_single() ) :
						the_title('<h1 class="entry-title">', '</h1>');
					else : 
				?>
					<h1 class="entry-title">
						Resources for Hosting Virtual Events
						<?php if ( is_category() ): ?>
							<?php echo 'Category: ' . single_cat_title( '', false); ?>
						<?php endif ?>
					</h1>
				<?php endif; ?>
			</header><!-- .entry-header -->
		</div>

		<!-- posts/pages for current URL? -->
		<?php if ( have_posts() ) : ?>
		<div class="row">
			<?php if ( is_single() ) : ?>
			<div id="blogBackBtn" class="col-xs-12 text-right">
				<a href="/virtual-resources/" class="btn btn-primary btn-sm">Back to Resources List</a>
			</div>
			<?php endif ?>

			<div class="col-xs-12 col-sm-12 <?= ( is_single() ? 'blog-entry' : 'blog-list' ) ?>">
			<!-- Start the Loop -->
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('col-xs-12'); ?>>
					<?php if ( is_single() ) : ?>
			<!-- ### ### ###   Start - Single Post   ### ### ### -->
						<div id="singlePost" class="col-xs-12 entry-content">

							<?php if (has_post_thumbnail()) : ?>

							<div id="blogImg" class="col-xs-12 col-sm-6" style="border: 3px solid black;background-image: url('<?php  echo wp_get_attachment_image_src( get_post_thumbnail_id($post->ID))[0]; ?>')" >
								<!-- <img style="border: 3px solid black;backgound-image: . <?php the_post_thumbnail('featured-image'); ?> ." />	 -->
							</div>
							
							<?php endif ?>

							<?php the_content(); ?>

							<div class="text-right">
								Virtual Categories: <?php the_category(', '); ?>

								<?php							
								$taxonomy = 'virtual_category';
								
								// Get the term IDs assigned to post.
								$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
								
								// Separator between links.
								$separator = ', ';
								
								if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
								
									$term_ids = implode( ',' , $post_terms );
								
									$terms = wp_list_categories( array(
										'title_li' => '',
										'style'    => 'none',
										'echo'     => false,
										'taxonomy' => $taxonomy,
										'include'  => $term_ids
									) );
								
									$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
								
									// Display post categories.
									echo  $terms;
								}
								?>
							</div><!--/ text-right  -->

							<?php
								wp_link_pages([
									'before'      => '<div class="page-links">Pages:',
									'after'       => '</div>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
								]); 
							?>
							<div class="clearfix"></div>
						</div>

						<div class="blog-footer">
							<?php echo custom_entry_footer(); ?>
						</div>
			<!-- ### ### ###   End - Single Post   ### ### ### -->
					<?php else: ?>
			<!-- ### ### ###   Start - Posts List Page   ### ### ###  -->
						<div class="col-xs-12 blog-in-list">
							<header class="col-xs-12 entry-header">
								<?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
							</header><!-- col-xs-12 entry-header -->

							<?php
								if ( get_the_post_thumbnail() !== '' ) :
									$content_class = 'col-xs-12 col-sm-6 col-md-8 entry-content';
							?>
								<div class="col-xs-12 col-sm-6 col-md-4 post-thumbnail">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('featured-image'); ?>
									</a>
								</div><!-- .post-thumbnail -->
							<?php
								else :
									$content_class = 'col-xs-12 entry-content';
								endif; // !is_single() && has thumbnail
							?>

							<div class="<?= $content_class ?>">
								<div class="text-left">
									<?php the_excerpt('Continue reading<span class="sr-only"> "'.get_the_title().'"</span>'); ?>
								</div>
								
								<div class="text-right">
									More Resources Like This: <!-- <?php the_category(', '); ?> -->
								</div>
							</div><!-- entry-content -->
						</div><!-- col-xs-12 blog-in-list -->
			<!-- ### ### ###   End - Posts List Page   ### ### ###  -->
					<?php endif; // is_single() ?>
				</article>
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
