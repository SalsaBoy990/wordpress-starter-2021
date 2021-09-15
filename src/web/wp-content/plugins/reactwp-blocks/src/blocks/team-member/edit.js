import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import {
  RichText,
  MediaPlaceholder,
  BlockControls,
  MediaUpload,
  MediaUploadCheck,
  InspectorControls,
  URLInput,
} from '@wordpress/block-editor';

import { isBlobURL } from '@wordpress/blob';

import {
  Spinner,
  withNotices,
  Toolbar,
  ToolbarButton,
  PanelBody,
  TextareaControl,
  SelectControl,
  Dashicon,
  Tooltip,
  TextControl,
} from '@wordpress/components';

import { withSelect } from '@wordpress/data';

import { SortableContainer, SortableElement } from 'react-sortable-hoc';

import arrayMove from 'array-move';

class TeamMemberEdit extends Component {
  state = {
    selectedLink: null,
  };

  componentDidMount() {
    const { attributes, setAttributes } = this.props;
    const { url, id } = attributes;

    if (url && isBlobURL(url) && !id) {
      setAttributes({
        url: '',
        alt: '',
      });
    }
  }

  componentDidUpdate(prevProps) {
    if (prevProps.isSelected && !this.props.isSelected) {
      this.setState({
        selectedLink: null,
      });
    }
  }

  onChangeTitle = (title) => {
    this.props.setAttributes({ title });
  };

  onChangeInfo = (info) => {
    this.props.setAttributes({ info });
  };

  onSelectImage = ({ id, url, alt }) => {
    this.props.setAttributes({
      id,
      url,
      alt,
    });
  };

  onSelectURL = (url) => {
    this.props.setAttributes({
      url,
      id: null,
      alt: '',
    });
  };

  onUploadError = (message) => {
    const { noticeOperations } = this.props;
    noticeOperations.createErrorNotice(message);
  };

  removeImage = () => {
    this.props.setAttributes({
      id: null,
      url: '',
      alt: '',
    });
  };

  updateAlt = (alt) => {
    this.props.setAttributes({ alt: alt });
  };

  getImageSizes = () => {
    const { image, imageSizes } = this.props;
    if (!image) {
      return [];
    }
    let options = [];
    const sizes = image.media_details.sizes;
    for (const key in sizes) {
      const size = sizes[key];
      const imageSize = imageSizes.find((size) => size.slug === key);
      if (imageSize) {
        options.push({
          label: imageSize.name,
          value: size.source_url,
        });
      }
    }
    return options;
  };

  onImageSizeChange = (url) => {
    this.props.setAttributes({ url });
  };

  addNewLink = () => {
    const { attributes, setAttributes } = this.props;
    const { social } = attributes;
    setAttributes({
      social: [...social, { icon: 'wordpress', link: '' }],
    });
    this.setState({
      selectedLink: social.length,
    });
  };

  updateSocialItem = (type, value) => {
    const { attributes, setAttributes } = this.props;
    const { social } = attributes;
    const { selectedLink } = this.state;

    let newSocial = [...social];
    newSocial[selectedLink][type] = value;
    setAttributes({ social: newSocial });
  };

  removeLink = (e) => {
    e.preventDefault();
    const { attributes, setAttributes } = this.props;
    const { social } = attributes;
    const { selectedLink } = this.state;

    setAttributes({
      social: [
        ...social.slice(0, selectedLink),
        ...social.slice(selectedLink + 1),
      ],
    });
    this.setState({
      selectedLink: null,
    });
  };

  onSortEnd = (oldIndex, newIndex) => {
    const { attributes, setAttributes } = this.props;
    const { social } = attributes;

    let newSocial = arrayMove(social, oldIndex, newIndex);
    setAttributes({ social: newSocial });
    this.setState({
      selectedLink: null,
    });
  };

  render() {
    const { className, attributes, noticeUI, isSelected } = this.props;
    const { title, info, url, alt, id, social } = attributes;

    const SortableList = SortableContainer(() => {
      return (
        <ul>
          {social.map((item, index) => {
            let SortableItem = SortableElement(() => {
              return (
                <li
                  key={index}
                  onClick={() => {
                    this.setState({ selectedLink: index });
                  }}
                  className={
                    this.state.selectedLink === index ? 'is-selected' : null
                  }>
                  <Dashicon icon={item.icon} size={32}></Dashicon>
                </li>
              );
            });
            return <SortableItem key={index} index={index}></SortableItem>;
          })}
          {isSelected && (
            <li className={'wp-block-reactwp-blocks-team-member__addIconLi'}>
              <Tooltip text={__('Add Social Link', 'reactwp-blocks')}>
                <button
                  onClick={this.addNewLink}
                  className={'wp-block-reactwp-blocks-team-member__addIconBtn'}>
                  <Dashicon icon={'plus'} size={32}></Dashicon>
                  Social link
                </button>
              </Tooltip>
            </li>
          )}
        </ul>
      );
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Image settings', 'reactwp-blocks')}>
            {url && !isBlobURL(url) && (
              <TextareaControl
                label={__('Alternative (alt) text', 'reactwp-blocks')}
                value={alt}
                help={__(
                  "Alternative text describes your image to people who can't see it. And a short description with its key details",
                  'reactwp-blocks'
                )}
                onChange={this.updateAlt}></TextareaControl>
            )}
            {id && (
              <SelectControl
                label={__('Image size', 'reactwp-blocks')}
                options={this.getImageSizes()}
                onChange={this.onImageSizeChange}
                value={url}></SelectControl>
            )}
          </PanelBody>
        </InspectorControls>
        <BlockControls>
          {url && (
            <Toolbar label={__('Remove image toolbar', 'reactwp-blocks')}>
              {id && (
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={this.onSelectImage}
                    allowedTypes={['image']}
                    value={id}
                    render={({ open }) => {
                      return (
                        <ToolbarButton
                          className='components-icon-button components-toolbar__control'
                          icon='edit'
                          onClick={open}
                          label={__(
                            'Edit Image',
                            'reactwp-blocks'
                          )}></ToolbarButton>
                      );
                    }}></MediaUpload>
                </MediaUploadCheck>
              )}
              <ToolbarButton
                className='components-icon-button components-toolbar__control'
                icon='trash'
                onClick={this.removeImage}
                label={__('Remove Image', 'reactwp-blocks')}></ToolbarButton>
            </Toolbar>
          )}
        </BlockControls>
        <div className={className}>
          {url ? (
            <>
              <img src={url} alt={alt} />
              {isBlobURL(url) && <Spinner />}
            </>
          ) : (
            <MediaPlaceholder
              icon='format-image'
              onSelect={this.onSelectImage}
              onSelectURL={this.onSelectURL}
              onError={this.onUploadError}
              //accept='image/*'
              allowedTypes={['image']}
              notices={noticeUI}></MediaPlaceholder>
          )}
          <RichText
            className={'wp-block-reactwp-blocks-team-member__title'}
            tagName='h4'
            value={title}
            placeholder={__('Member Name', 'reactwp-blocks')}
            allowedFormats={[]}
            onChange={this.onChangeTitle}></RichText>
          <RichText
            className={'wp-block-reactwp-blocks-team-member__info'}
            tagName='p'
            value={info}
            placeholder={__('Member Info', 'reactwp-blocks')}
            allowedFormats={[]}
            onChange={this.onChangeInfo}></RichText>

          <div className={'wp-block-reactwp-blocks-team-member__social'}>
            <SortableList
              axis='x'
              helperClass={'social-dragging'}
              distance={10}
              onSortEnd={({ oldIndex, newIndex }) =>
                this.onSortEnd(oldIndex, newIndex)
              }></SortableList>
            {/*<ul>
              {social.map((item, index) => {
                return (
                  <li
                    key={index}
                    onClick={() => {
                      this.setState({ selectedLink: index });
                    }}
                    className={
                      this.state.selectedLink === index ? 'is-selected' : null
                    }>
                    <Dashicon icon={item.icon} size={32}></Dashicon>
                  </li>
                );
              })}
              {isSelected && (
                <li
                  className={'wp-block-reactwp-blocks-team-member__addIconLi'}>
                  <Tooltip text={__('Add Item', 'reactwp-blocks')}>
                    <button
                      onClick={this.addNewLink}
                      className={
                        'wp-block-reactwp-blocks-team-member__addIconBtn'
                      }>
                      <Dashicon icon={'plus'} size={32}></Dashicon>
                    </button>
                  </Tooltip>
                </li>
              )}
            </ul>*/}
          </div>
          {this.state.selectedLink !== null && (
            <div className={'wp-block-reactwp-blocks-team-member__linkForm'}>
              <TextControl
                label={__('Icon', 'reactwp-blocks')}
                value={social[this.state.selectedLink].icon}
                onChange={(icon) =>
                  this.updateSocialItem('icon', icon)
                }></TextControl>
              <URLInput
                label={__('URL', 'reactwp-blocks')}
                value={social[this.state.selectedLink].link}
                onChange={(link) =>
                  this.updateSocialItem('link', link)
                }></URLInput>
              <a
                onClick={this.removeLink}
                className={'wp-block-reactwp-blocks-team-member__removeLink'}
                href='#'>
                {__('Remove Link', 'reactwp-blocks')}
              </a>
            </div>
          )}
        </div>
      </>
    );
  }
}

export default withSelect((select, props) => {
  const id = props.attributes.id;
  return {
    image: id ? select('core').getMedia(id) : null,
    imageSizes: select('core/editor').getEditorSettings().imageSizes,
  };
})(withNotices(TeamMemberEdit));
