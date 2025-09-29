<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\MakeContratoTemplate;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Dica: gere um template de contrato padrão com placeholders
Artisan::command('contratos:make-template', function () {
    $this->call(MakeContratoTemplate::class, []);
})->purpose('Gera um template DOCX de contrato do cliente em resources/templates/contratos');
