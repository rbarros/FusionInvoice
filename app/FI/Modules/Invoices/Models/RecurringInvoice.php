<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Models;

use FI\Classes\Date;

class RecurringInvoice extends \Eloquent {

    /**
     * Guarded properties
     * @var array
     */
	protected $guarded = array('id');

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function invoice()
    {
        return $this->belongsTo('FI\Modules\Invoices\Models\Invoice');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
   
    public function getFormattedCreatedAtAttribute()
    {
        return Date::format($this->attributes['created_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Date::format($this->attributes['updated_at']);
    }

    public function getFormattedGenerateAtAttribute()
    {
        return Date::format($this->attributes['generate_at']);
    }
}