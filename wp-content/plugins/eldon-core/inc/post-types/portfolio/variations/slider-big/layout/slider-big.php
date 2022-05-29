<?php
// Hook to include additional content before portfolio single item
do_action( 'eldon_core_action_before_portfolio_single_item' );
?>
	<article <?php post_class( 'qodef-portfolio-single-item qodef-variations--big qodef-e' ); ?>>
		<div class="qodef-e-inner">
			<div class="qodef-media qodef-swiper-container qodef--slider">
				<div class="swiper-wrapper">
					<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/media', 'slider' ); ?>
				</div>
				<?php eldon_core_template_part( 'content', 'templates/swiper-nav', '', array( 'slider_navigation' => 'yes' ) ); ?>
			</div>
			<div class="qodef-e-content qodef-grid qodef-layout--template qodef--no-bottom-space <?php echo eldon_core_get_grid_gutter_classes(); ?>">
				<div class="qodef-grid-inner clear">
					<div class="qodef-grid-item qodef-col--9">
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/title' ); ?>
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/content' ); ?>
					</div>
					<div class="qodef-grid-item qodef-col--3 qodef-portfolio-info">
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/custom-fields' ); ?>
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/date' ); ?>
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/categories' ); ?>
						<?php eldon_core_template_part( 'post-types/portfolio', 'templates/parts/post-info/social-share' ); ?>
					</div>
				</div>
			</div>
		</div>
	</article>
<?php
// Hook to include additional content after portfolio single item
do_action( 'eldon_core_action_after_portfolio_single_item' );
?>
