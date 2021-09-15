import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import {
  RichText,
  BlockControls,
  InspectorControls,
  AlignmentToolbar,
  PanelColorSettings,
  withColors,
  ContrastChecker,
} from '@wordpress/block-editor';

import classnames from 'classnames';

import {
  Toolbar,
  DropdownMenu,
  PanelBody,
  ToggleControl,
  // ColorPicker,
  // ColorPalette,
  RangeControl,
} from '@wordpress/components';

class Edit extends Component {
  onChangeContent = (content) => {
    // setAttributes({ content: content });
    this.props.setAttributes({ content });
  };

  onChangeAlignment = (textAlignment) => {
    this.props.setAttributes({ textAlignment });
  };
  /*
  onChangeBackgroundColor = (backgroundColor) => {
    this.props.setAttributes({ backgroundColor });
  };

  onChangeTextColor = (textColor) => {
    this.props.setAttributes({ textColor });
  };
  */
  toggleShadow = () => {
    this.props.setAttributes({
      shadow: !this.props.attributes.shadow ? true : false,
    });
  };
  onChangeShadowOpacity = (shadowOpacity) => {
    this.props.setAttributes({ shadowOpacity });
  };

  render() {
    const {
      className,
      attributes,
      setTextColor,
      setBackgroundColor,
      backgroundColor,
      textColor,
    } = this.props;
    // const { content, textAlignment, backgroundColor, textColor } = attributes;
    const { content, textAlignment, shadow, shadowOpacity } = attributes;
    const classes = classnames(className, {
      'has-shadow': shadow,
      [`shadow-opacity-${shadowOpacity * 100}`]: shadowOpacity,
    });

    return (
      <>
        <InspectorControls>
          <PanelColorSettings
            title={__('Color Settings', 'reactwp-blocks')}
            colorSettings={[
              {
                value: backgroundColor.color,
                /*onChange: this.onChangeBackgroundColor,*/
                onChange: setBackgroundColor,
                label: __('Background Color', 'reactwp-blocks'),
              },
              {
                value: textColor.color,
                /*onChange: this.onChangeTextColor,*/
                onChange: setTextColor,
                label: __('Text Color', 'reactwp-blocks'),
              },
            ]}>
            <ContrastChecker
              textColor={textColor.color}
              backgroundColor={backgroundColor.color}></ContrastChecker>
          </PanelColorSettings>

          <PanelBody title={__('Shadow Settings', 'reactwp-blocks')}>
            <ToggleControl
              label={__('Enable Box Shadow', 'reactwp-blocks')}
              onChange={this.toggleShadow}
              checked={shadow}></ToggleControl>
            {/*<ColorPicker
              color='#f03'
              onChangeComplete={(v) => console.log(v)}></ColorPicker>
            <ColorPalette
          colors={[{ color: '#f03' }, { color: 'blue' }]}
          onChange={onChangeBackgroundColor}></ColorPalette>*/}
            {shadow && (
              <RangeControl
                label={__('Shadow Opacity', 'reactwp-blocks')}
                onChange={this.onChangeShadowOpacity}
                value={shadowOpacity}
                min={0.1}
                max={0.4}
                step={0.1}></RangeControl>
            )}
          </PanelBody>
        </InspectorControls>
        <BlockControls
          controls={[
            [
              {
                icon: 'wordpress',
                title: __('test', 'reactwp-blocks'),
                onClick: () => this.onChangeAlignment('right'),
                isActive: false,
              },
            ],
          ]}>
          <AlignmentToolbar
            value={textAlignment}
            onChange={this.onChangeAlignment}></AlignmentToolbar>
          <Toolbar
            label='Toolbar test 1'
            isCollapsed
            controls={[
              [
                {
                  icon: 'wordpress',
                  title: __('test', 'reactwp-blocks'),
                  onClick: () => {},
                  isActive: false,
                },
              ],
              [
                {
                  icon: 'wordpress',
                  title: __('test', 'reactwp-blocks'),
                  onClick: () => {},
                  isActive: false,
                },
              ],
            ]}
          />
          <Toolbar
            label='Toolbar test 2'
            isCollapsed
            controls={[
              [
                {
                  icon: 'wordpress',
                  title: __('test', 'reactwp-blocks'),
                  onClick: () => {},
                  isActive: false,
                },
              ],
            ]}
          />
          {content && content.length > 0 && (
            <Toolbar label='Toolbar test 3'>
              <DropdownMenu
                icon='editor-table'
                label={__('test', 'reactwp-blocks')}
                controls={[
                  [
                    {
                      icon: 'wordpress',
                      title: __('test', 'reactwp-blocks'),
                      onClick: () => {},
                      isActive: false,
                    },
                  ],
                  [
                    {
                      icon: 'wordpress',
                      title: __('test', 'reactwp-blocks'),
                      onClick: () => {},
                      isActive: false,
                    },
                  ],
                ]}></DropdownMenu>
            </Toolbar>
          )}
        </BlockControls>
        <RichText
          className={classes}
          tagName='h4'
          onChange={this.onChangeContent}
          value={content}
          allowedFormats={['bold']}
          style={{
            textAlign: textAlignment,
            backgroundColor: backgroundColor.color,
            color: textColor.color,
          }}
        />
      </>
    );
  }
}

export default withColors('backgroundColor', { textColor: 'color' })(Edit);
