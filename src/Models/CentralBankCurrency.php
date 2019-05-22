<?php


namespace Grechanyuk\CentralBankCurrency\Models;


use Illuminate\Database\Eloquent\Model;

class CentralBankCurrency extends Model
{
    protected $fillable = ['name', 'par', 'cb_code', 'iso_code', 'value'];
}