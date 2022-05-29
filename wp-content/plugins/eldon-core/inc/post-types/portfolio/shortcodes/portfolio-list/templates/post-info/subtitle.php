<?php
$portfolio_subtitle = get_post_meta( get_the_ID(), 'qodef_portfolio_subtitle', true );

if ( ! empty( $portfolio_subtitle ) ) { ?>
<span class="qodef-e-subtitle">
	<?php echo esc_html( $portfolio_subtitle ); ?>
</span>
<?php } ?>
