import './style.scss';

import edit from './edit';
import React from 'react';

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

const attributes = {
  title: {
    type: 'string',
    source: 'html',
    selector: 'h3',
  },
  info: {
    type: 'string',
    source: 'html',
    selector: 'p',
  },
  id: {
    type: 'number',
  },
  alt: {
    type: 'string',
    source: 'attribute',
    selector: 'img',
    attribute: 'alt',
    default: '',
  },
  url: {
    type: 'string',
    source: 'attribute',
    selector: 'img',
    attribute: 'src',
  },
  social: {
    type: 'array',
    default: [
      { link: 'https://facebook.com/', icon: 'facebook' },
      { link: 'https://twitter.com/', icon: 'twitter' },
      { link: 'https://m.me.com/', icon: 'facebook-messenger' },
      { link: 'https://linkedin.com/', icon: 'linkedin' },
    ],
    source: 'query',
    selector: '.wp-block-reactwp-blocks-team-member__social ul li',
    query: {
      icon: {
        source: 'attribute',
        attribute: 'data-icon',
      },
      link: {
        source: 'attribute',
        selector: 'a',
        attribute: 'href',
      },
    },
  },
};

registerBlockType('reactwp-blocks/team-member', {
  title: __('Team Member', 'reactwp-blocks'),
  description: __("Block showing the team member's details", 'reactwp-blocks'),
  category: 'reactwp-category',
  icon: (
    <svg height='24px' viewBox='0 0 24 24' width='24px' fill='#000000'>
      <path d='M0 0h24v24H0z' fill='none' />
      <path d='M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z' />
    </svg>
  ),
  // Can only be added to team-members parent block
  parent: ['reactwp-blocks/team-members'],

  supports: {
    reusable: false,
    html: false,
  },

  keywords: [
    __('team', 'reactwp-blocks'),
    __('member', 'reactwp-blocks'),
    __('person', 'reactwp-blocks'),
  ],
  attributes: attributes,
  edit: edit,
  // eslint-disable-next-line react/display-name
  save: ({ attributes }) => {
    const { title, info, url, alt, id, social } = attributes;
    return (
      <div className='col'>
        <div className='card h-100'>
          {url && (
            <img
              src={url}
              alt={alt}
              className={
                id
                  ? `wp-image-${id} card-img-top team-member-profile-photo`
                  : null
              }
            />
          )}
          <div className='card-body'>
            {title && (
              <RichText.Content
                className={'wp-block-reactwp-blocks-team-member__title'}
                tagName='h3'
                value={title}
              />
            )}
            {info && (
              <RichText.Content
                className={'wp-block-reactwp-blocks-team-member__info'}
                tagName='p'
                value={info}
              />
            )}
          </div>
          <div className='card-footer'>
            {social.length > 0 && (
              <div className={'wp-block-reactwp-blocks-team-member__social'}>
                <ul>
                  {social.map((item, index) => {
                    return (
                      <li key={index} data-icon={item.icon}>
                        <a
                          href={item.link}
                          target='_blank'
                          rel='noreferrer noopener'>
                          <i className={`fab fa-${item.icon} fa-2x`}></i>
                        </a>
                      </li>
                    );
                  })}
                </ul>
              </div>
            )}
          </div>
        </div>
      </div>
    );
  },
});
