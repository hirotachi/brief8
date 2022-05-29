<?php
$short_bio = get_post_meta( get_the_ID(), 'qodef_team_member_bio', true );

if ( ! empty( $short_bio ) ) { ?>
	<p itemprop="description" class="qodef-m-description"><?php echo esc_html( strip_tags( $short_bio ) ); ?></p>
<?php } ?>
