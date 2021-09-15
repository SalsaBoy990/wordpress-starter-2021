import { registerBlockType, createBlock } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

const attributes = {
  columns: {
    type: 'number',
    default: 2,
  },
};

registerBlockType('reactwp-blocks/team-members', {
  title: __('Team Members', 'reactwp-blocks'),
  description: __(
    'Container block showing team member blocks',
    'reactwp-blocks'
  ),
  category: 'reactwp-category',
  icon: 'grid-view',
  keywords: [
    __('team', 'reactwp-blocks'),
    __('member', 'reactwp-blocks'),
    __('person', 'reactwp-blocks'),
  ],

  supports: {
    html: false,
    align: ['wide', 'full'],
  },

  transforms: {
    from: [
      {
        type: 'block',
        blocks: ['core/gallery'],
        transform: ({ columns, images }) => {
          let inner = images.map(({ alt, id, url }) => {
            return createBlock('reactwp-blocks/team-member', {
              alt,
              id: parseInt(id),
              url,
            });
          });
          return createBlock(
            'reactwp-blocks/team-members',
            {
              columns: columns,
            },
            inner
          );
        },
      },
      {
        type: 'block',
        blocks: ['core/image'],
        isMultiBlock: true,
        transform: (attributes) => {
          let inner = attributes.map(({ alt, id, url }) => {
            return createBlock('reactwp-blocks/team-member', { alt, id, url });
          });
          return createBlock(
            'reactwp-blocks/team-members',
            {
              columns: 3,
            },
            inner
          );
        },
      },
    ],
  },

  attributes,

  // eslint-disable-next-line react/display-name
  edit: ({ className, attributes, setAttributes }) => {
    const { columns } = attributes;
    return (
      <div className={`${className} has-${columns}-columns`}>
        <InspectorControls>
          <PanelBody>
            <RangeControl
              label={__('team', 'reactwp-blocks')}
              value={columns}
              onChange={(columns) => {
                setAttributes({ columns: columns });
              }}
              min={1}
              max={4}></RangeControl>
          </PanelBody>
        </InspectorControls>
        <InnerBlocks
          allowedBlocks={['reactwp-blocks/team-member']}
          template={[
            ['reactwp-blocks/team-member', { title: 'John Doe' }],
            ['reactwp-blocks/team-member'],
          ]}
        />
      </div>
    );
    // InnerBlocks = templateLock='insert' | 'all'
  },
  // eslint-disable-next-line react/display-name
  save: ({ attributes }) => {
    const { columns } = attributes;
    return (
      <div className={`has-${columns}-columns`}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
