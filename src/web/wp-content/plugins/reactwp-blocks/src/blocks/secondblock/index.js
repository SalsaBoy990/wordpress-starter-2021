import React from 'react';
import classnames from 'classnames';
import { registerBlockType, createBlock } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

//import {  } from '@wordpress/block-editor';
import { RichText, getColorClassName } from '@wordpress/block-editor';

import { omit } from 'lodash';

import Edit from './Edit.js';

import './styles.editor.scss';

// const { registerBlockType } = wp.blocks;
// const { __ } = wp.i18n;

const attributes = {
  content: {
    type: 'string',
    source: 'html',
    selector: 'h4',
  },
  alignment: {
    type: 'string',
  },
  textAlignment: {
    type: 'string',
  },
  backgroundColor: {
    type: 'string',
  },
  textColor: {
    type: 'string',
  },
  customBackgroundColor: {
    type: 'string',
  },
  customTextColor: {
    type: 'string',
  },
  shadow: {
    type: 'boolean',
    default: false,
  },
  shadowOpacity: {
    type: 'number',
    default: 0.3,
  },
};

registerBlockType('reactwp-blocks/secondblock', {
  title: __('Second Block', 'reactwp-blocks'),
  description: __('This Is The Second Block', 'reactwp-blocks'),
  category: 'reactwp-category',
  icon: (
    <svg version='1.1' width='24' height='24' viewBox='0 0 24 24'>
      <path d='M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M15,10.5V9A2,2 0 0,0 13,7H9V17H13A2,2 0 0,0 15,15V13.5C15,12.7 14.3,12 13.5,12C14.3,12 15,11.3 15,10.5M13,15H11V13H13V15M13,11H11V9H13V11Z' />
    </svg>
  ),
  keywords: [__('photo', 'reactwp-blocks'), __('image', 'reactwp-blocks')],

  styles: [
    {
      name: 'rounded',
      label: __('Rounded', 'reactwp-blocks'),
      isDefault: true,
    },
    {
      name: 'outlined',
      label: __('Outlined', 'reactwp-blocks'),
      isDefault: false,
    },
    {
      name: 'squared',
      label: __('Squared', 'reactwp-blocks'),
      isDefault: false,
    },
  ],
  attributes: attributes,
  deprecated: [
    {
      attributes: omit(
        {
          ...attributes,
          alignment: {
            type: 'string',
          },
        },
        ['textAlignment']
      ),
      migrate: (attributes) => {
        return omit(
          {
            ...attributes,
            textAlignment: attributes.alignment,
          },
          ['alignment']
        );
      },
      save: ({ attributes }) => {
        // eslint-disable-next-line react/prop-types
        const {
          content,
          alignment,
          backgroundColor,
          textColor,
          customBackgroundColor,
          customTextColor,
          shadow,
          shadowOpacity,
        } = attributes;

        const backgroundClass = getColorClassName(
          'background-color',
          backgroundColor
        );
        const textClass = getColorClassName('color', textColor);

        const classes = classnames({
          [backgroundClass]: backgroundClass,
          [textClass]: textClass,
          'has-shadow': shadow,
          [`shadow-opacity-${shadowOpacity * 100}`]: shadowOpacity,
        });

        // eslint-disable-next-line react/prop-types
        return (
          <RichText.Content
            tagName='h4'
            value={content}
            className={classes}
            style={{
              textAlign: alignment,
              backgroundColor: backgroundClass
                ? undefined
                : customBackgroundColor,
              color: textClass ? undefined : customTextColor,
            }}
          />
        );
      },
    },
    {
      // supports
      attributes: omit(
        {
          ...attributes,
          content: {
            type: 'string',
            source: 'html',
            selector: 'p',
          },
        },
        ['textAlignment']
      ),
      migrate: (attributes) => {
        return omit(
          {
            ...attributes,
            textAlignment: attributes.alignment,
          },
          ['alignment']
        );
      },
      save: ({ attributes }) => {
        // eslint-disable-next-line react/prop-types
        const {
          content,
          alignment,
          backgroundColor,
          textColor,
          customBackgroundColor,
          customTextColor,
          shadow,
          shadowOpacity,
        } = attributes;

        const backgroundClass = getColorClassName(
          'background-color',
          backgroundColor
        );
        const textClass = getColorClassName('color', textColor);

        //const shadowClass = get('color', textColor);

        const classes = classnames({
          [backgroundClass]: backgroundClass,
          [textClass]: textClass,
          'has-shadow': shadow,
          [`shadow-opacity-${shadowOpacity * 100}`]: shadowOpacity,
        });

        // eslint-disable-next-line react/prop-types
        return (
          <RichText.Content
            tagName='p'
            value={content}
            className={classes}
            style={{
              textAlign: alignment,
              backgroundColor: backgroundClass
                ? undefined
                : customBackgroundColor,
              color: textClass ? undefined : customTextColor,
            }}
          />
        );
      },
    },
  ],

  transforms: {
    from: [
      {
        type: 'block',
        blocks: ['core/paragraph'],
        transform: ({ content, align }) => {
          return createBlock('reactwp-blocks/secondblock', {
            content: content,
            textAlignment: align,
          });
        },
      },
      {
        // shortcuts for creating blocks
        type: 'prefix',
        prefix: '#b',
        transform: () => {
          return createBlock('reactwp-blocks/secondblock');
        },
      },
    ],
    to: [
      {
        type: 'block',
        blocks: ['core/paragraph'],
        isMatch: ({ content }) => {
          return content ? true : false;
        },
        transform: ({ content, textAlignment }) => {
          return createBlock('core/paragraph', {
            content: content,
            align: textAlignment,
          });
        },
      },
    ],
  },
  // eslint-disable-next-line react/display-name, react/prop-types
  edit: Edit,
  // eslint-disable-next-line react/display-name, react/prop-types
  save: ({ attributes }) => {
    // eslint-disable-next-line react/prop-types
    const {
      content,
      textAlignment,
      backgroundColor,
      textColor,
      customBackgroundColor,
      customTextColor,
      shadow,
      shadowOpacity,
    } = attributes;

    const backgroundClass = getColorClassName(
      'background-color',
      backgroundColor
    );
    const textClass = getColorClassName('color', textColor);

    //const shadowClass = get('color', textColor);

    const classes = classnames({
      [backgroundClass]: backgroundClass,
      [textClass]: textClass,
      'has-shadow': shadow,
      [`shadow-opacity-${shadowOpacity * 100}`]: shadowOpacity,
    });

    // eslint-disable-next-line react/prop-types
    return (
      <RichText.Content
        tagName='h4'
        value={content}
        className={classes}
        style={{
          textAlign: textAlignment,
          backgroundColor: backgroundClass ? undefined : customBackgroundColor,
          color: textClass ? undefined : customTextColor,
        }}
      />
    );
  },
});
