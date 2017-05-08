<?php
/*
 * ScribblarRoom
 *
 * This class is used to control the room post type
 *
 * @author scribblar
 * @since 1.0.2
 * @version 1.0.14
 */
class ScribblarCron
{

    /**
     * Activate the cron schedule
     *
     * @param void
     *
     * @return void
     */
    static function activate()
    {
        if( !wp_next_scheduled( 'scribblar_hourly_event' ) )
        {
        	wp_schedule_event( time(), 'hourly', 'scribblar_hourly_event' );
        }
    }


    /**
     * Deactivate the cron schedule
     *
     * @param void
     *
     * @return void
     */
    static function deactivate()
    {
        wp_clear_scheduled_hook( 'scribblar_hourly_event' );
    }


    /**
     * Api sync
     *
     * This is used to synchronise the the rooms and users
     *
     * @param void
     *
     * @return void
     */
    static function api_sync()
    {
        self::sync_rooms();
        self::sync_users();
    }


    /**
     * Sync the room custom post type with Scribblar
     *
     * @param void
     *
     * @return void
     */
    static function sync_rooms()
    {
        ScribblarRoom::sync_posts_with_api();
    }


    /**
     * Sync the users with Scribblar
     *
     * @param void
     *
     * @return void
     */
    static function sync_users()
    {
        ScribblarUser::sync_users_with_api();
    }

}
