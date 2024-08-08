<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wp-block-content-list__pagination">
	<?php echo paginate_links( $args ); ?>
</div>
