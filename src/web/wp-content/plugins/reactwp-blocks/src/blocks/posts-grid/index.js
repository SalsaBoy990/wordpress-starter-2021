import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import {
  InnerBlocks,
  InspectorControls,
  useBlockProps,
  __experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

const attributes = {
  columnsM: {
    type: 'number',
    default: 2,
  },
  columnsL: {
    type: 'number',
    default: 3,
  },
  columnsXL: {
    type: 'number',
    default: 4,
  },
  columnsXXL: {
    type: 'number',
    default: 5,
  },
};

registerBlockType('reactwp-blocks/posts-grid', {
  title: __('Posts Grid Layout', 'reactwp-blocks'),
  description: __(
    'Container block showing cards with latest posts by categories',
    'reactwp-blocks'
  ),
  category: 'reactwp-category',
  icon: 'grid-view',
  keywords: [
    __('grid', 'reactwp-blocks'),
    __('posts', 'reactwp-blocks'),
    __('card', 'reactwp-blocks'),
  ],

  supports: {
    html: false,
    align: ['wide', 'full'],
  },
  attributes,

  // eslint-disable-next-line react/display-name
  edit: ({ className, attributes, setAttributes }) => {
    const { columnsM, columnsL, columnsXL, columnsXXL } = attributes;

    // use this hook in order to aviod messing up the grid layout because
    // InnerBlock adds unnecessary wrapping containers around child elements
    // We need a parent div with a class row and child items with class .col inside
    // in order to make bootstrap columns work in Gutenberg

    // this is the class the InnerBlock components needs to have
    const blockProps = useBlockProps({
      className: `${className} row row-cols-1 row-cols-md-${columnsM} row-cols-lg-${columnsM} row-cols-xl-${columnsM} row-cols-xl-${columnsM} g-4  mt-4 mb-4`,
    });

    // only these blocks allowed, add default template
    const innerBlocksProps = useInnerBlocksProps(blockProps, {
      allowedBlocks: ['reactwp-blocks/latest-posts'],
      template: [
        ['reactwp-blocks/latest-posts', { numberOfPosts: 3, postCategory: 1 }],
        ['reactwp-blocks/latest-posts', { numberOfPosts: 3, postCategory: 1 }],
      ],
    });

    return (
      <div>
        <InspectorControls>
          <PanelBody>
            <RangeControl
              label={__('Columns on medium screens', 'reactwp-blocks')}
              value={columnsM}
              onChange={(columnsM) => {
                setAttributes({ columnsM });
              }}
              min={1}
              max={8}></RangeControl>
            <RangeControl
              label={__('Columns on Large screens', 'reactwp-blocks')}
              value={columnsL}
              onChange={(columnsL) => {
                setAttributes({ columnsL });
              }}
              min={1}
              max={8}></RangeControl>
            <RangeControl
              label={__('Columns on XL screens', 'reactwp-blocks')}
              value={columnsXL}
              onChange={(columnsXL) => {
                setAttributes({ columnsXL });
              }}
              min={1}
              max={8}></RangeControl>
            <RangeControl
              label={__('Columns on XXL screens', 'reactwp-blocks')}
              value={columnsXXL}
              onChange={(columnsXXL) => {
                setAttributes({ columnsXXL });
              }}
              min={1}
              max={8}></RangeControl>
          </PanelBody>
        </InspectorControls>
        <div>
          <div {...innerBlocksProps} />
        </div>
      </div>
    );
    // InnerBlocks = templateLock='insert' | 'all'
  },
  // eslint-disable-next-line react/display-name
  save: ({ attributes }) => {
    const { columnsM, columnsL, columnsXL, columnsXXL } = attributes;
    return (
      <div
        className={`row row-cols-1 row-cols-md-${columnsM} row-cols-lg-${columnsL} row-cols-xl-${columnsXL} row-cols-xl-${columnsXXL} g-4 mt-4 mb-4`}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
