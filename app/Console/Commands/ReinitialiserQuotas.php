<?php

namespace App\Console\Commands;

use App\Services\QuotaService;
use Illuminate\Console\Command;

class ReinitialiserQuotas extends Command
{
    protected $signature = 'quotas:reinitialiser';
    protected $description = 'Réinitialise les quotas annuels des employés';

    public function handle(QuotaService $quotaService)
    {
        $count = $quotaService->reinitialiserQuotasAnnuels();
        $this->info("{$count} employé(s) ont eu leur quota réinitialisé.");
        
        return Command::SUCCESS;
    }
}