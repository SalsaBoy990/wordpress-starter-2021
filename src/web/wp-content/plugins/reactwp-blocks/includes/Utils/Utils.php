<?php

namespace Guland\ReactWPBlocks\Utils;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait Utils
{
  /**
   * General utility methods used by all custom blocks
   * 
   * @param string $block
   * @param array $options
   * 
   * @return void
   */
  function registerCustomBlockTypes(string $block, array $options = []): void
  {
    register_block_type(
      'reactwp-blocks/' . $block,
      array_merge(
        array(
          'editor_script' => 'reactwp-blocks-editor-script',
          'script' => 'reactwp-blocks-script',
          'style' => 'reactwp-blocks-style',
          'editor_style' => 'reactwp-blocks-editor-style'
        ),
        $options
      )
    );
  }
}
