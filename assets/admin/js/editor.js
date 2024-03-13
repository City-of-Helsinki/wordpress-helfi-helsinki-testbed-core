(function(wp){
  wp.domReady(function() {
    const blockNames = [
      'core/group',
      'core/media-text',
    ];
    const allowedBlocks = wp.blocks.getBlockTypes().filter(block => blockNames.includes(block.name));

    window.addEventListener('load', event => {
      allowedBlocks.forEach(block => {
        if (! wp.blocks.getBlockType(block.name)) {
          wp.blocks.registerBlockType(block.name, block);
        }
      });
    });
  });
})(window.wp);
