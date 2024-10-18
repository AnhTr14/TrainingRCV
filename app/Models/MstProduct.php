<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstProduct extends Model
{
    protected $table = 'mst_products';

    protected $fillable = ['product_id', 'product_name', 'description', 'product_price', 'is_sales', 'product_image', 'created_by', 'updated_by'];
    
    use HasFactory;

    
}
