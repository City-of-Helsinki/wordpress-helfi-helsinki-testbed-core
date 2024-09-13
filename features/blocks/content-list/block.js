(function(wpBlockEditor){

  const {registerBlockType} = wpBlockEditor.blocks;
  const {createElement, Fragment} = wpBlockEditor.element;
	const {useBlockProps, InspectorControls} = wpBlockEditor.blockEditor;
	const {__} = wpBlockEditor.i18n;
	const compose = wpBlockEditor.compose;
	const ServerSideRender = wpBlockEditor.serverSideRender;
	const {withSelect} = wpBlockEditor.data;
	const {SelectControl, TextControl, CheckboxControl, PanelBody, PanelRow} = wpBlockEditor.components;

  const CategorySelect = compose.compose(
  		withSelect((select, props) => {
        return {
          terms: select('core')
            .getEntityRecords('taxonomy', 'category', {
              per_page: 100
            })
        };
      })
    )(props => {
      const options = [];
			if ( props.terms ) {
				options.push({value: 0, label: __('Select category', 'helsinki-testbed-core')});
				props.terms.forEach((term) => {
					options.push({value: term.id, label: term.name});
				});
			} else {
				options.push({value: 0, label: __('Loading...', 'helsinki-testbed-core')});
			}

      const selectValue = (! props.attributes.category && options[0].value)
        ? options[0].value
        : props.attributes.category;

      return createElement(SelectControl, {
        label: __('Filter by category', 'helsinki-testbed-core'),
        options : options,
        onChange: value => props.setAttributes({category: parseInt(value, 10)}),
        value: selectValue,
      });
    });

  function orderByOptions() {
    return [
      {value: 'date', label: __('Date', 'helsinki-testbed-core')},
      {value: 'title', label: __('Title', 'helsinki-testbed-core')}
    ];
  }

  function orderOptions() {
    return [
      {value: 'DESC', label: __('Descending', 'helsinki-testbed-core')},
      {value: 'ASC', label: __('Ascending', 'helsinki-testbed-core')}
    ];
  }

  function inspectorControls(controls) {
    return createElement(InspectorControls, {},
      createElement(PanelBody, {
          title: __('Settings', 'helsinki-testbed-core'),
          initialOpen: true
        },
        controls.map(block => createElement(PanelRow, {}, block))
      )
    );
  }

  function blockSettings(props) {
    const {attributes, setAttributes} = props;
    const {data, title, category, posts_per_page, order_by, order, use_pagination, exclude_quiet_posts} = attributes;

    const clearLegacyData = (key) => {
      if (data.hasOwnProperty(key)) {
        let dataCopy = {...data};

        delete dataCopy[key];

        setAttributes({data: dataCopy});
      }
    }

    return inspectorControls([
      createElement(TextControl, {
        label: __('Title', 'helsinki-testbed-core'),
        onChange: value => {
          clearLegacyData('title');
          setAttributes({title: value});
        },
        value: title,
      }),
      createElement(CategorySelect, props),
      createElement(TextControl, {
        type: 'number',
        label: __('Number of articles', 'helsinki-testbed-core'),
        value: posts_per_page,
        onChange: value => {
          clearLegacyData('posts_per_page');
          setAttributes({posts_per_page: parseInt(value,10)});
        },
        min: 1,
        step: 1,
      }),
      createElement(SelectControl, {
        label: __('Order by', 'helsinki-testbed-core'),
        options : orderByOptions(),
        onChange: value => {
          clearLegacyData('order_by');
          setAttributes({order_by: value});
        },
        value: order_by,
      }),
      createElement(SelectControl, {
        label: __('Order', 'helsinki-testbed-core'),
        options : orderOptions(),
        onChange: value => {
          clearLegacyData('order');
          setAttributes({order: value});
        },
        value: order,
      }),
      createElement(CheckboxControl, {
        label: __('Use pagination', 'helsinki-testbed-core'),
        checked: use_pagination,
        onChange: () => {
          clearLegacyData('use_pagination');
          setAttributes({use_pagination: ! use_pagination});
        },
      }),
      createElement(CheckboxControl, {
        label: __('Exclude quiet posts', 'helsinki-testbed-core'),
        help: __('Posts marked as "quiet" will not be published to this content list', 'helsinki-testbed-core'),
        checked: exclude_quiet_posts,
        onChange: () => {
          clearLegacyData('exclude_quiet_posts');
          setAttributes({exclude_quiet_posts: ! exclude_quiet_posts})
        },
      }),
    ]);
  }

  function renderBlock(props) {
    return createElement(ServerSideRender, {
      block: 'acf/content-list',
      attributes: {...props.attributes}
    });
  }

  function edit(props) {
    return createElement(Fragment, {},
      blockSettings(props),
      createElement('div', useBlockProps(), renderBlock(props))
    );
  }

  registerBlockType('acf/content-list', {
    title: __( 'Content list', 'helsinki-testbed-core' ),
    edit: edit,
  });

})(window.wp);

function mapLegacyContentListAcfData(block, blockType, innerHTML) {
  if (blockType.name == 'acf/content-list') {

    if ( ! block.title && block.data.title ) {
      block.title = block.data.title;
    }

    if ( ! block.order_by && block.data.order_by ) {
      block.order_by = block.data.order_by.toLowerCase();
    }

    if ( ! block.order && block.data.order ) {
      block.order = block.data.order;
    }

    if ( ! block.category && block.data.category ) {
      block.category = parseInt(block.data.category, 10);
    }

    if ( ! block.posts_per_page && block.data.posts_per_page ) {
      block.posts_per_page = parseInt(block.data.posts_per_page, 10);
    }

    if ( ! block.use_pagination && block.data.use_pagination ) {
      block.use_pagination = block.data.use_pagination == 1;
    }

    if ( ! block.exclude_quiet_posts && block.data.exclude_quiet_posts ) {
      block.exclude_quiet_posts = block.data.exclude_quiet_posts == 1;
    }
  }

  return block;
}
wp.hooks.addFilter(
  'blocks.getBlockAttributes',
  'helsinki-testbed-core/content-list-data-mapping',
  mapLegacyContentListAcfData
);
