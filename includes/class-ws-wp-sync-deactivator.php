<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 *
 */
class Ws_Wp_Sync_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        //remove daily cron
        $timestamp = wp_next_scheduled('ws_wp_daily_import');
        wp_unschedule_event($timestamp, 'ws_wp_daily_import');
        //remove hourly cron
        $timestamp = wp_next_scheduled('ws_wp_hourly_import');
        wp_unschedule_event($timestamp, 'ws_wp_hourly_import');

	    $timestamp = wp_next_scheduled('ws_wp_two_hours_import');
        wp_unschedule_event($timestamp, 'ws_wp_two_hours_import');

	    $timestamp = wp_next_scheduled('ws_wp_twice_a_day_import');
        wp_unschedule_event($timestamp, 'ws_wp_twice_a_day_import');

	    $timestamp = wp_next_scheduled('ws_wp_six_hours_import');
        wp_unschedule_event($timestamp, 'ws_wp_six_hours_import');

	    $timestamp = wp_next_scheduled('ws_wp_half_hour_import');
        wp_unschedule_event($timestamp, 'ws_wp_half_hour_import');


    }

}
