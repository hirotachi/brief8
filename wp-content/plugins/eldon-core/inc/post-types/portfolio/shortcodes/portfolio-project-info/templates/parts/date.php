<?php
$date = get_the_time( get_option( 'date_format' ), $project_id );

if ( ! empty( $date ) ) { ?>
	<p itemprop="dateCreated" class="entry-date published"><?php echo esc_html( $date ); ?></p>
	<?php
}
