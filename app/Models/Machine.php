<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    /**
     * Table associated with the model
     * 
     * @var string
     */
    protected $table = 'machines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['initial_store', 'machine_number', 'region_id', 'machine_type', 'ip_address', 'status'];

    /**
     * Attributes that are not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id', 'initial_store', 'machine_number', 'machine_type', 'ip_address','status','time_log','data_log','group_server'];

    /**
     * Attributes that should be mutated to date
     * 
     * @var array
     */
    protected $date = ['created_at', 'updated_at'];
}
