<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $block_classes ) ); ?>">
	<?php
		if ( $title ) {
			echo '<h2 class="wp-block-content-list__title">' . esc_html( $title ) . '</h2>';
		}
	?>

	<div class="wp-block-content-list__entries">
		<?php
			while( $query->have_posts() ) {
				$query->the_post();

				post_entry( get_post(), ($title ? 3 : 2) );
			}

			wp_reset_postdata();
		?>
	</div>

	<?php
		if ( $use_pagination ) {
			pagination( $query, $block_id );
		}
	?>
</div>
