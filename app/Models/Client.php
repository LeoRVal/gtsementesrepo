<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'address',
        'whatsapp',
        'email'
    ];


    /**
     * Set the specified attribute's value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */

    public function setAttribute($key, $value) {
        if (in_array($key, ['name', 'cnpj', 'address', 'whatsapp', 'email']) && is_string($value)) {
            $value = strtoupper($value);
        }

        parent::setAttribute($key, $value);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
