import { Component } from '@wordpress/element';
//import { __ } from '@wordpress/i18n';

import { withSelect, withDispatch } from '@wordpress/data';

import { compose } from '@wordpress/compose';

class ReduxEdit extends Component {
  render() {
    const { title } = this.props;
    return (
      <div>
        <h2>{title}</h2>
        <input
          type='text'
          value={title}
          onChange={(e) => this.props.onTitleChange(e.target.value)}
        />
      </div>
    );
  }
}

export default compose([
  withSelect((select) => {
    return {
      title: select('core/editor').getEditedPostAttribute('title'),
    };
  }),
  withDispatch((dispatch) => {
    return {
      onTitleChange: (title) =>
        dispatch('core/editor').editPost({ title: title }),
    };
  }),
])(ReduxEdit);
