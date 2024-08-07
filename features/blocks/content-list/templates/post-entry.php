<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="<?php echo esc_attr( implode( ' ', $entry_classes ) ); ?>">
	<a
		class="teaser__link"
		href="<?php echo esc_url( $permalink ); ?>"
		aria-label="<?php echo esc_attr( $aria_label ); ?>"
		<?php if ( $excerpt ) : ?>
		aria-describedby="teaser-<?php echo esc_attr( $id ); ?>-excerpt"
		<?php endif; ?>
	>
		<?php if ( $label ) : ?>
			<div class="teaser__label">
				<?php echo esc_html( $label ); ?>
			</div>
		<?php endif; ?>

	    <?php if ( $thumbnail ) : ?>
			<div class="teaser__thumbnail">
				<?php echo $thumbnail; ?>
			</div>
	  	<?php else : ?>
			<div class="teaser__thumbnail teaser__thumbnail--placeholder">
				<img src="" alt="<?php echo esc_attr( $label ); ?>" />
			</div>
	    <?php endif; ?>

		<div class="teaser__content">
			<?php
				if ( $title ) {
					echo sprintf(
						'<h%1$d class="teaser__title">
							%2$s
						</h%1$d>',
						$h_level,
						esc_html( $title )
					);
				}
			?>
			<?php if ( $excerpt ) : ?>
				<p class="teaser__excerpt" id="teaser-<?php echo esc_attr( $id ); ?>-excerpt">
					<?php echo esc_html( $excerpt ); ?>
				</p>
			<?php endif; ?>
		</div>
	</a>

	<?php if ( $tags || $categories ) : ?>
		<ul class="teaser__tags">
			<?php foreach( $categories as $category ) : ?>
				<li>
					<a href="<?php echo esc_url( get_category_link($category) ); ?>">
						<?php echo esc_html( $category->name ); ?>
					</a>
				</li>
			<?php endforeach; ?>

			<?php if ( $tags ) : ?>
				<?php foreach( $tags as $tag ) : ?>
					<li>
						<a href="<?php echo esc_url( get_tag_link($tag) ); ?>">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
</div>
