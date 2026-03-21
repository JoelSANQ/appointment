<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 
    'user_id', 
    'blood_type_id',
     'address', 
     'phone_number', 'allergies', 'chronic_conditions', 'surgical_history', 'family_history', 'observations', 'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'];

    public function routeNotificationForWhatsApp()
    {
        return $this->phone_number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
