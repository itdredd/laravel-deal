<?php

namespace App\Repository;

use App\Models\Deal;

class DealRepository
{
    protected function find($deal) {
        return Deal::find($deal);
    }



}
