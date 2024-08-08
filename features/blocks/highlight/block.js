(function(wpBlockEditor){

  const ICONS = ['alert-circle', 'book', 'calendar-clock', 'car', 'car-wifi', 'check', 'clock', 'cogwheel', 'drone', 'ed-tech', 'envelope', 'globe', 'group','heart', 'home', 'home-solar-panels', 'kiertotalous', 'ship', 'speechbubble', 'tree'];

  const colorPalette = [];

  const {registerBlockType, createBlock} = wpBlockEditor.blocks;
  const {createElement, Fragment} = wpBlockEditor.element;
  const { __ } = wpBlockEditor.i18n;
	const {
    useBlockProps,
    InspectorControls,
    PanelColorSettings,
    withColors,
    RichText,
    URLInput
  } = wpBlockEditor.blockEditor;
  const {
    PanelBody,
    PanelRow,
    RadioControl,
  } = wpBlockEditor.components;

  function inspectorControls({
    attributes,
    setAttributes,
    iconColor,
    setIconColor,
    textColor,
    setTextColor
  }) {
    const {iconName} = attributes;

    return createElement(InspectorControls, {},
      createElement(PanelColorSettings, {
        title: __('Colors', 'helsinki-testbed-core'),
        __experimentalIsRenderedInSidebar: true,
        colors: colorPalette,
        colorSettings: [
          {
            colorValue: iconColor.color,
            onChange: setIconColor,
            label: __('Icon color', 'helsinki-testbed-core'),
          },
          {
            colorValue: textColor.color,
            onChange: setTextColor,
            label: __('Text color', 'helsinki-testbed-core'),
          },
        ],
      }),
      createElement(PanelBody, {initialOpen: true},
        createElement(PanelRow, {},
          createElement(RadioControl, {
            label: __('Icon', 'helsinki-testbed-core'),
            selected: iconName,
            onChange: value => setAttributes({iconName: value}),
            options: ICONS.map(name => ({
              value: name,
              label: createElement('svg', {
                className: `icon mask-icon icon--${name} hds-icon--${name} inline-icon`,
                viewBox: '0 0 24 24',
                'aria-label': name,
                style: {
                  width: '30px',
                  height: '30px',
                  backgroundColor: iconColor.color || '#000',
                  fill: iconColor.color || '#000',
                },
              }),
            }))
          })
        )
      )
    );
  }

  function renderBlock({
    attributes,
    setAttributes,
    iconColor,
    textColor
  }) {
    const {iconName, heading, body, linkText, linkUrl} = attributes;

    var wrapClassNames = 'highlight';
    var headingClassNames = 'highlight__heading';
    var bodyClassNames = 'highlight__body';
    var urlClassNames = 'highlight__link-url-input';
    var buttonClassNames = 'wp-block-button is-style-outline highlight__button';
    var buttonLinkClassNames = 'wp-block-button__link';

    if (!!textColor.class) {
      headingClassNames.concat( ' ', textColor.class );
      bodyClassNames.concat( ' ', textColor.class );
      urlClassNames.concat( ' ', textColor.class );
      buttonLinkClassNames.concat( ' ', textColor.class );
    }

    return createElement('div', {className: wrapClassNames},
      createElement('div', {className: 'highlight__columns'},
        createElement('div', {className: 'highlight__column icon-column'},
          createElement('svg', {
            className: `highlight__icon icon mask-icon icon--${iconName} hds-icon--${iconName} inline-icon`,
            viewBox: '0 0 24 24',
            'aria-label': iconName,
            style: {
              width: '30px',
              height: '30px',
              backgroundColor: iconColor.color || '#000',
              fill: iconColor.color || '#000',
            },
          })
        ),
        createElement('div', {className: 'highlight__column body-column'},
          createElement(RichText, {
            placeholder: __('Enter heading', 'helsinki-testbed-core'),
            tagName: 'h2',
            className: headingClassNames,
            value: heading,
            onChange: value => setAttributes({heading: value}),
          }),
          createElement(RichText, {
            placeholder: __('Enter body text', 'helsinki-testbed-core'),
            tagName: 'div',
            className: bodyClassNames,
            value: body,
            onChange: value => setAttributes({body: value}),
          })
        ),
        createElement('div', {className: 'highlight__column button-column'},
          createElement(URLInput, {
            placeholder: __('Enter link url', 'helsinki-testbed-core'),
            tagName: 'div',
            className: urlClassNames,
            value: linkUrl,
            type: 'string',
            onChange: value => setAttributes({linkUrl: value}),
          }),
          createElement('div', {className: buttonClassNames},
            createElement(RichText, {
              placeholder: __('Enter button text', 'helsinki-testbed-core'),
              tagName: 'div',
              className: buttonLinkClassNames,
              value: linkText,
              onChange: value => setAttributes({linkText: value}),
            })
          )
        )
      )
    );
  }

  const BlockEditWithColors = (props) => createElement(Fragment, {},
    inspectorControls(props),
    createElement('div', useBlockProps(), renderBlock(props))
  );

  registerBlockType('hds/highlight', {
    title: __( 'Highlight', 'helsinki-testbed-core' ),
    transforms: {
      to: [{
        type: 'block',
        blocks: ['hds-wp/banner'],
        transform: ({heading, body, iconName, linkText, linkUrl}) => {
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
        },
      }],
    },
    edit: withColors('backgroundColor',
      { textColor: 'color' },
      { iconColor: 'color' },
    )(BlockEditWithColors),
  });

})(window.wp);
