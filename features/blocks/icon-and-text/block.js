(function(wpBlockEditor){

  const ICONS = [
    'alert-circle', 'book', 'calendar-clock', 'car', 'car-wifi', 'check',
    'clock', 'cogwheel', 'drone', 'ed-tech', 'envelope', 'globe', 'group',
    'heart', 'home', 'home-solar-panels', 'kiertotalous', 'ship', 'speechbubble',
    'tree',
  ];

  const colorPalette = [];

  const {registerBlockType} = wpBlockEditor.blocks;
  const {createElement, Fragment} = wpBlockEditor.element;
  const { __ } = wpBlockEditor.i18n;
	const {
    useBlockProps,
    InspectorControls,
    PanelColorSettings,
    withColors,
    RichText
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
    const {iconName, heading, body} = attributes;

    var wrapClassNames = 'icon-and-text';
    var headingClassNames = 'icon-and-text__heading';
    var bodyClassNames = 'icon-and-text__body';

    if (!!textColor.class) {
      headingClassNames.concat( ' ', textColor.class );
      bodyClassNames.concat( ' ', textColor.class );
    }

    return createElement('div', {classNames: wrapClassNames},
      createElement('svg', {
        className: `icon-and-text__icon icon mask-icon icon--${iconName} hds-icon--${iconName} inline-icon`,
        viewBox: '0 0 24 24',
        'aria-label': iconName,
        style: {
          width: '30px',
          height: '30px',
          backgroundColor: iconColor.color || '#000',
          fill: iconColor.color || '#000',
        },
      }),
      createElement(RichText, {
        placeholder: __('Enter heading', 'helsinki-testbed-core'),
        tagName: 'div',
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
      }),
    );
  }

  const BlockEditWithColors = (props) => createElement(Fragment, {},
    inspectorControls(props),
    createElement('div', useBlockProps(), renderBlock(props))
  );

  registerBlockType('hds/icon-and-text', {
    title: __( 'Icon & Text', 'helsinki-testbed-core' ),
    edit: withColors({ textColor: 'color' },
      { iconColor: 'color' },
    )(BlockEditWithColors),
  });

})(window.wp);
