"use strict";

(wpBlockEditor => {
  const {
    registerBlockStyle
  } = wpBlockEditor.blocks;
  const {
    __
  } = wpBlockEditor.i18n;
  registerBlockStyle('core/paragraph', {
    name: 'limited-width',
    label: __('Limited width', 'helsinki-testbed-core')
  });
})(window.wp);