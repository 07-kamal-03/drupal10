<?php

namespace Drupal\customblockmodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provide "themeblock" block
 * 
 * @Block(
 * id = "themeblock",
 * admin_label = @Translation("themeblock"),
 * category = @Translation("themeblock")
 * )
 */
class themeblock extends BlockBase {

    public function build() {
        $renderable = [
          '#theme' => 'themesblock',
          '#test_var' => 'test variable',
        ];
    
        return $renderable;
      }
  
  }


?>
