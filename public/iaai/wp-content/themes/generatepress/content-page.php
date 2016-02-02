<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Generate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork" itemscope="itemscope">
	<div class="inside-article">
		<header class="entry-header">
			<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content" itemprop="text">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generate' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php edit_post_link( __( 'Edit', 'generate' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->
