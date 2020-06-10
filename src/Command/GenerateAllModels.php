<?php

namespace App\Console\Commands;


use Doctrine\Inflector\Inflector;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateAllModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'krlove:generate:all-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all models';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        foreach($tables as $table)
        {
            if($table === 'migrations') continue;
            $className = Str::camel(Str::singular($table));
            $className = ucfirst($className);
            Artisan::call('krlove:generate:model', ['class-name' => $className, '--table-name' => $table,'--namespace'=>'App\Models','--output-path'=>'Models']);
        }
    }
}
