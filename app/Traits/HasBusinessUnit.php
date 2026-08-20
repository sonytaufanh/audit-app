<?php

namespace App\Traits;

use App\Models\BusinessUnit;
use Illuminate\Database\Eloquent\Builder;

trait HasBusinessUnit
{
    public static function bootHasBusinessUnit()
    {
        static::addGlobalScope('business_unit', function (Builder $builder) {
            $buId = session('active_business_unit_id');
            if ($buId) {
                $builder->where($builder->getModel()->getTable() . '.business_unit_id', $buId);
            }
        });

        static::creating(function ($model) {
            $buId = session('active_business_unit_id');
            if ($buId && !$model->business_unit_id) {
                $model->business_unit_id = $buId;
            }
        });
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withoutGlobalScope('business_unit')
            ->where($field ?? $this->getRouteKeyName(), $value)
            ->firstOrFail();
    }
}
