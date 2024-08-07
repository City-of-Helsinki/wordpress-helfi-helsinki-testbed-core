<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\PersonList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="<?php echo esc_attr( implode( ' ', $entry_classes ) ); ?>">
	<?php
		if ( $thumbnail ) {
			printf(
				'<figure class="wp-block-image is-style-outline">%s</figure>',
				$thumbnail
			);
		}
	?>

	<ul>
	    <li>
			<h3><?php echo esc_html( $title ); ?></h3>
		</li>
		<?php if ( $email ) : ?>
			<li class="person-teaser__email">
				<a href="mailto:<?php echo esc_attr( $email ); ?>">
					<?php echo esc_html( $email ); ?>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( $description ) : ?>
			<li class="person-teaser__description">
				<?php echo wp_kses_post( nl2br($description) ); ?>
			</li>
		<?php endif; ?>
    </ul>
</div>
