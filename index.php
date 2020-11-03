<?php
/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

get_header();

$page_id = get_option( 'page_for_posts' );
?>
<div class="row">
	<div class="col-md-12">
		<?php
		get_template_part( 'index', 'preview' );
		?>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">

		<h3>
		<span class="d-block p-2 bg-primary text-white">
			<?php
			echo get_the_title( $page_id );
				edit_post_link( __( 'Edit', 'leatherblacksmith' ), '<span class="edit-link">', '</span>', $page_id );
			?>
		</span>
		</h3>
	</div><!-- /.col -->
	<div class="col-md-12">
		<?php
			get_template_part( 'archive', 'loop' );
		?>
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
get_footer();
