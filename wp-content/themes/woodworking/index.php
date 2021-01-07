<?php //include("header.php"); 
 get_header();
?>

		<!-- end #menu -->
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content">
							<?php if ( have_posts() ) : 
								while ( have_posts() ) : the_post(); ?>
									<div class="post">
										<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<p class="meta">Posted by <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a> on <?php 
										$val = get_the_date();
										echo $val;
											if (  has_category() ) {
												?>
												<div class="entry-categories">
													<span class="screen-reader-text"><?php _e( 'Categories', 'woodworking' ); ?></span>
													<div class="entry-categories-inner">
														<?php the_category( ' ' ); ?>
													</div><!-- .entry-categories-inner -->
												</div><!-- .entry-categories -->
												<?php
											}?>
										&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
										<div class="entry">
								
										<p><?php  the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php the_content(); ?> </p>
										</div>
									</div>
								<?php endwhile; 
							 endif; ?>
						</div>
					<?php //include("sidebar.php"); 
					get_sidebar();?>
					<!-- end #content -->
					<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
		</div>
		<!-- end #page -->
		<?php get_footer(); ?>
