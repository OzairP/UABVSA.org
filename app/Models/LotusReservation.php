<?php

namespace App\Models;

use App\Helpers\Settings\LotusSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * App\Models\LotusReservation
 * @property int                             $id
 * @property string                          $holder_type
 * @property string                          $name
 * @property string                          $email
 * @property int                             $tickets
 * @property string|null                     $dietary
 * @property string|null                     $accommodations
 * @property int                             $charged_price
 * @property int                             $pending
 * @property string|null                     $stripe_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|LotusReservation newModelQuery()
 * @method static Builder|LotusReservation newQuery()
 * @method static Builder|LotusReservation query()
 * @method static Builder|LotusReservation whereAccommodations($value)
 * @method static Builder|LotusReservation whereChargedPrice($value)
 * @method static Builder|LotusReservation whereCreatedAt($value)
 * @method static Builder|LotusReservation whereDietary($value)
 * @method static Builder|LotusReservation whereEmail($value)
 * @method static Builder|LotusReservation whereHolderType($value)
 * @method static Builder|LotusReservation whereId($value)
 * @method static Builder|LotusReservation whereName($value)
 * @method static Builder|LotusReservation wherePending($value)
 * @method static Builder|LotusReservation whereStripePaymentId($value)
 * @method static Builder|LotusReservation whereTickets($value)
 * @method static Builder|LotusReservation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null                        $donation
 * @property string|null                     $donation_stripe_payment_id
 * @method static Builder|LotusReservation whereDonation($value)
 * @method static Builder|LotusReservation whereDonationStripePaymentId($value)
 * @property string|null                     $affiliation
 * @method static Builder|LotusReservation whereAffiliation($value)
 */
class LotusReservation extends Model
{

    use HasFactory;

    protected $fillable = [
        'holder_type',
        'name',
        'email',
        'tickets',
        'affiliation',
        'dietary',
        'accommodations',
        'charged_price',
        'pending',
        'stripe_payment_id',
    ];

    public static function acceptingNewReservations ()
    {
        return LotusSettings::acceptingNewReservations();
    }

    public static function countConfirmedReservedTickets ()
    {
        return static::where('pending', FALSE)
                     ->sum('tickets');
    }

    public static function isSoldOut ()
    {
        return static::countReservedTickets() >= LotusSettings::totalTicketCapacity();
    }

    public static function countReservedTickets ()
    {
        return static::sum('tickets');
    }

    public static function isSoldOutForStudents (): bool
    {
        return static::countStudentTickets() >= LotusSettings::studentTicketCapacity();
    }

    public static function countStudentTickets ()
    {
        return static::where('holder_type', 'student')
                     ->sum('tickets');
    }

    public static function isSoldOutForGeneral (): bool
    {
        return static::countGeneralTickets() >= LotusSettings::generalTicketCapacity();
    }

    public static function countGeneralTickets ()
    {
        return static::where('holder_type', 'general')
                     ->sum('tickets');
    }

    public static function remainingTickets ()
    {
        return LotusSettings::totalTicketCapacity() - static::countReservedTickets();
    }

    public static function remainingStudentTickets ()
    {
        return LotusSettings::studentTicketCapacity() - static::where('holder_type', 'student')
                                                              ->sum('tickets');
    }

    public static function remainingGeneralTickets ()
    {
        return LotusSettings::generalTicketCapacity() - static::where('holder_type', 'general')
                                                                         ->sum('tickets');
    }

    public static function createPendingReservation (array $data): LotusReservation
    {
        return static::create(array_merge($data, [
            'pending' => TRUE,
        ]));
    }

    public static function findByEmail (string $email): ?LotusReservation
    {
        return static::where('email', $email)
                     ->first();
    }

    public function isConfirmed (): bool
    {
        return !$this->isPending();
    }

    public function isPending ()
    {
        return $this->pending;
    }

    public function markAsPaid (string $paymentId, int $amount): void
    {
        $this->update([
            'pending'           => FALSE,
            'stripe_payment_id' => $paymentId,
            'charged_price'     => $amount,
        ]);
    }

    public function markAsNotPending (): void
    {
        $this->update([
            'pending' => FALSE,
        ]);
    }

    public function isStudent ()
    {
        return $this->holder_type === 'student';
    }

    public function chargedPrice ()
    {
        return $this->charged_price !== 0 ? $this->charged_price / 100 : 0;
    }

    public function donationAmount ()
    {
        return $this->donation ? $this->donation / 100 : 0;
    }

    public function subTotal () {
        return $this->chargedPrice() + $this->donationAmount();
    }

    /**
     * @param callable|NULL $transform
     *
     * @return array
     */
    public function qrCodes (callable $transform = NULL)
    {
        /** @var \SimpleSoftwareIO\QrCode\Generator $qr */
        $qr = QrCode::format('png')
                    ->errorCorrection('H')
                    ->size(250)
                    ->style('round')
                    ->gradient(54, 105, 85, 48, 94, 76, 'radial')
                    ->backgroundColor(238, 238, 238);

        if ($transform) {
            $qr = $transform($qr);
        }

        $qrCodes = [];

        for ($i = 0; $i < $this->tickets; $i++) {
            $qrCodes[] = $qr->generate("LOTUSRESERVATION{$this->id}_$i");
        }

        return $qrCodes;
    }

    public function generatePDF ()
    {
        return Pdf::loadView('lotus.pdf.ticket', ['reservation' => $this])
                  ->setOption('defaultFont', 'Mukta');
    }

    public function holderTypeFormatted ()
    {
        switch ($this->holder_type) {
            case 'student':
                return 'Student / Faculty';
            case 'general':
                return 'General Admission';
            default:
                return 'Unknown';
        }
    }
}
