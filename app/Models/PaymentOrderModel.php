<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentOrderModel extends Model
{


    protected $table = 'payment_order';
    public $timestamps = true;
    public $guarded = [];
    public $hidden = [];
    protected $casts = [
        'id'=>'integer'
    ];

}
