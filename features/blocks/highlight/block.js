(function(wpBlockEditor){

  const {registerBlockType, createBlock} = wpBlockEditor.blocks;
  const {createElement} = wpBlockEditor.element;
  const { __ } = wpBlockEditor.i18n;
	const {useBlockProps} = wpBlockEditor.blockEditor;
	const {Button} = wpBlockEditor.components;

  function transformToBanner({heading, body, iconName, linkText, linkUrl}) {
    return createBlock('hds-wp/banner', {
      contentTitle: heading,
      contentText: body,
      contentIcon: iconName,
      buttonText: linkText,
      buttonUrl: linkUrl,
      targetBlank: false,
      isExternalUrl: false,
      anchor: '',
    });
  }

  function edit(props) {
    return createElement('div', useBlockProps(),
      createElement('div', {style: {
          backgroundColor: '#f7f7f7',
          padding: '1rem',
        }},
        createElement('h2', {style: {marginTop: 0}}, __( 'Note!', 'helsinki-testbed-core' )),
        createElement('p', {}, __( 'Legacy Highlight block is not supported anymore.', 'helsinki-testbed-core' )),
        createElement('p', {}, __( 'Please transform this block to Helsinki - Banneri block.', 'helsinki-testbed-core' )),
        createElement(Button, {
          variant: 'primary',
          onClick: () => {
            wp.data.dispatch( 'core/editor' ).replaceBlocks(props.clientId, transformToBanner(props.attributes));
          },
        }, __( 'Transform', 'helsinki-testbed-core' ))
      )
    );
  }

  registerBlockType('hds/highlight', {
    title: __( 'Highlight', 'helsinki-testbed-core' ),
    transforms: {
      to: [{
        type: 'block',
        blocks: ['hds-wp/banner'],
        transform: transformToBanner,
      }],
    },
    edit: edit,
  });

})(window.wp);
