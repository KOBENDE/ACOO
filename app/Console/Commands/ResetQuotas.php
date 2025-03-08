<?php

namespace App\Console\Commands;

use App\Models\Employe;
use Illuminate\Console\Command;

class ResetQuotas extends Command
{
    protected $signature = 'app:reset-quotas';
    protected $description = 'Reset employee vacation and absence quotas';

    public function handle()
    {
        Employe::query()->update(['quota_conges_absences' => 5]);
        $this->info('Quotas de congés et d\'absences réinitialisés avec succès!');
        return Command::SUCCESS;
    }
}