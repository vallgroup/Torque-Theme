<?php

 class Torque_Mega_Menu_Utilities {

   public static $pre_parent_item_handle = 'torque_mega_menu_pre_parent_item';
   public static $post_parent_item_handle = 'torque_mega_menu_post_parent_item';

   public static $pre_child_item_handle = 'torque_mega_menu_pre_child_item';
   public static $post_child_item_handle = 'torque_mega_menu_post_child_item';

   public static function render_parent_items( $parent_items_array ) {
      ob_start();

      foreach ($parent_items_array as $key => $item) {

        $has_children = $item->children && sizeof($item->children) > 0;
      ?>

        <div
          class="torque-mega-menu-item torque-mega-menu-parent-item <?php echo $has_children ? 'has-children' : ''; ?>"
          data-id="<?php echo $item->ID; ?>"
        >

          <?php
          do_action( self::$pre_parent_item_handle, $item );
          ?>

          <a href="<?php echo $item->url; ?>">
            <div class="torque-mega-menu-item-title torque-mega-menu-item-title-parent">
              <?php echo $item->title; ?>
            </div>
          </a>

          <?php if ( $has_children ) { ?>
            <div class="torque-mega-menu-item-has-children-marker" >
            </div>
          <?php }

          do_action( self::$post_parent_item_handle, $item );

          ?>
        </div>

      <?php
      }

      return ob_get_clean();
    }

    public static function render_child_items( $parent_item ) {
       ob_start();

       $items = $parent_item->children;

       foreach ($items as $key => $item) {
       ?>

         <div
           class="torque-mega-menu-item torque-mega-menu-child-item"
           data-id="<?php echo $item->ID; ?>"
           data-parent-id="<?php echo $parent_item->ID; ?>"
         >

           <?php
           do_action( self::$pre_child_item_handle, $item );
           ?>

           <a href="<?php echo $item->url; ?>">
             <div class="torque-mega-menu-item-title torque-mega-menu-item-title-child">
               <?php echo $item->title; ?>
             </div>
           </a>

           <?php
           do_action( self::$post_child_item_handle, $item );
           ?>

         </div>

       <?php
       }

       return ob_get_clean();
     }

		/**
		 * Gets nav menu items with children moved to
		 * 'children' property on parent menu item object.
		 *
		 * Note: currently only supports depth of 1.
		 *
		 * @param  int|string|WP_Term $menu Same as what can be passed to wp_get_nav_menu_items
		 * @return array Array of parent nav menu items with children under children property.
		 */
		public static function get_nav_menu_items_nested( $menu ) {
			$items = wp_get_nav_menu_items( $menu );
			$children = [];

			foreach ($items as $key => $menu_item) {
			  // if the element is a child,
			  // add it to tmp child array sorted by parent id,
			  // and remove from items
			  if ($menu_item->menu_item_parent !== '0') {
			    $children[$menu_item->menu_item_parent][] = $menu_item;
			    unset($items[$key]);
			  }
			  // otherwise initialise a children array on the parent object
			  else {
			    $menu_item->children = [];
			  }
			}

			foreach ($items as $key => &$parent) {
			  $parent_id = (string)$parent->ID;

			  if ( array_key_exists( $parent_id, $children ) ) {
			    $parent->children = $children[$parent_id];
			  }
			}

			return $items;
		}

  }
