((wpBlockEditor) => {
  const {registerBlockStyle} = wpBlockEditor.blocks;
  const {addFilter} = wpBlockEditor.hooks;
  const { __ } = wpBlockEditor.i18n;

  // registerBlockStyle( 'core/paragraph', {
  //   name: 'limited-width',
  //   label: __( 'Limited width', 'helsinki-testbed-core' ),
  // } );

  function helsinkiBlockSupportsBackgroundColor(settings, name) {
    if (typeof settings.attributes !== 'undefined' && isValidHelsinkiBlock(name)) {
      settings.supports = Object.assign(settings.supports, {
        color: {
          background: true,
          text: false,
        }
      });
    }
    return settings;
  }

  function isValidHelsinkiBlock(name) {
    return 'hds-wp/banner' === name;
  }

  addFilter(
  	'blocks.registerBlockType',
  	'helsinki-testbed-core/helsinki-block-background-color-support',
  	helsinkiBlockSupportsBackgroundColor
  );

})(window.wp);
