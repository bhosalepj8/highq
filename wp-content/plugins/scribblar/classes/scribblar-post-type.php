<?php
/**
 * Scribblar post types
 *
 * Set up the room custom post type
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.14
 */
register_post_type('room',
		array('labels'	=> array(
                            'name'		            => __('Rooms',	'scribblar'),
                            'singular_name'         => __('Room',	'scribblar'),
                            'add_new_item'          => __('Add New Room',	'scribblar'),
                            'edit_item'             => __('Edit Room',	'scribblar'),
                            'new_item'		        => __('New Room',	'scribblar'),
                            'view_item'			    => __('View Room',	'scribblar'),
                            'search_items'		    => __('Search Rooms',	'scribblar'),
                            'not_found'			    => __('No Rooms Found',	'scribblar'),
                            'not_found_in_trash'    => __('No Rooms Found in Trash', 'scribblar')
                        ),
						'public'		        => true,
						'menu_position'	        => 5,
						'supports'		        => array( 'title', 'revisions' ),
						'has_archive'	        => 'rooms',
						'query_var'		        => false,
						'rewrite'		        => true,
                        'register_meta_box_cb' => 'add_room_metaboxes',
                        'exclude_from_search'   => false
            )
        );
