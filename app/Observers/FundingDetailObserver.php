<?php

namespace App\Observers;

use App\Models\FundingDetail;

class FundingDetailObserver
{
    public function updated(FundingDetail $fundingDetail)
    {
        if ($fundingDetail->dana_terkumpul >= $fundingDetail->target_pendanaan) {
           $fundingDetail->project->update(['status' => 'Telah Terdanai']);
       }
   }
}
