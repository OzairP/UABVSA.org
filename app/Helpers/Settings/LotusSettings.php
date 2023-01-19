<?php

namespace App\Helpers\Settings;

use DB;
use Log;

class LotusSettings
{

    public static function acceptingNewReservations ()
    {
        return nova_get_setting('lotus_allow_new_reservations');
    }

    public static function studentValidationModeIsAutomatic ()
    {
        return nova_get_setting('lotus_automatic_student_validation');
    }

    public static function studentValidationModeIsManual ()
    {
        return !self::studentValidationModeIsAutomatic();
    }

    public static function studentTicketCapacity ()
    {
        return nova_get_setting('lotus_ticket_student_capacity');
    }

    public static function generalTicketCapacity ()
    {
        return nova_get_setting('lotus_ticket_general_capacity');
    }

    public static function totalTicketCapacity ()
    {
        return self::studentTicketCapacity() + self::generalTicketCapacity();
    }

    public static function stripeTicketPriceId ()
    {
        return nova_get_setting('lotus_stripe_ticket_price_id');
    }

    public static function stripeDonationPriceId ()
    {
        return nova_get_setting('lotus_stripe_donation_price_id');
    }

    public static function hospitalityPacketUrl ()
    {
        $novaSettingsMigrationsRan = DB::table('migrations')->where('migration', '2019_08_13_000000_create_nova_settings_table')->exists();

        if (!$novaSettingsMigrationsRan) {
            Log::warning('LotusSettings::hospitalityPacketUrl() called before nova settings migrations ran.');
            return '/';
        }

        return nova_get_setting('lotus_hospitality_packet_url');
    }

}
