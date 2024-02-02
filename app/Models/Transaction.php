<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payer', // Assuming this is the user_id
        'due_on',
        'vat',
        'is_vat_inclusive',
        'status',
    ];
    protected $casts = [
        'status' => 'string',
    ];

    // Defining the relationship with the User model

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payerUser()
    {
        return $this->belongsTo(User::class, 'payer');
    }


    // Relationship with Payment model (One-to-Many)

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
