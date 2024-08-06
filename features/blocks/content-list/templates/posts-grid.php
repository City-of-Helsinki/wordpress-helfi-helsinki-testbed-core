<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="<?php echo esc_attr( $block_classes ); ?>">
	<?php
		if ( $title ) {
			echo '<h2>' . esc_html( $title ) . '</h2>';
		}
	?>

	<div class="grid">
		<?php
			while( $query->have_posts() ) {
				$query->the_post();
				post_entry();
			}

			wp_reset_postdata();
		?>
	</div>

	<?php
		if ( use_pagination( $attributes ) ) {
			pagination( $query );
		}
	?>

</div>
