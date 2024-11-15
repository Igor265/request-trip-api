<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TravelRequest extends Model
{

    use Notifiable, HasFactory;

    protected $fillable = [
        'requester_name',
        'requester_email',
        'destination',
        'departure_date',
        'return_date',
        'travel_status_id',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function travelStatus()
    {
        return $this->belongsTo(TravelStatus::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['status'])) {
            $statusId = $this->getStatusId($filters['status']);
            if ($statusId !== null) {
                $query->where('travel_status_id', $statusId);
            }
        }

        if (isset($filters['destino'])) {
            $query->where('destination', 'like', '%' . $filters['destino'] . '%');
        }

        if (isset($filters['data_ida_inicio'])) {
            if (isset($filters['data_ida_fim'])) {
                $query->whereBetween('departure_date', [$filters['data_ida_inicio'], $filters['data_ida_fim']]);
            } else {
                $query->whereDate('departure_date', '>=', $filters['data_ida_inicio']);
            }
        }

        if (isset($filters['data_volta_inicio'])) {
            if (isset($filters['data_volta_fim'])) {
                $query->whereBetween('return_date', [$filters['data_volta_inicio'], $filters['data_volta_fim']]);
            } else {
                $query->whereDate('return_date', '>=', $filters['data_volta_inicio']);
            }
        }

        return $query;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->requester_email;
    }

    public static function getStatusId($status)
    {
        return match ($status) {
            'solicitado' => 1,
            'aprovado' => 2,
            'cancelado' => 3,
            default => null,
        };
    }
}
