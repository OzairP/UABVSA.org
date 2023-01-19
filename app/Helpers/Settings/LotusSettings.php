<?php

namespace App\Helpers\Settings;

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
        return nova_get_setting('lotus_hospitality_packet_url');
    }

}
