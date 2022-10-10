<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use mtolhuijs\LDS\Exceptions\DatabaseConnectionException;

class SynchronizeTableWithCondition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        db:syncCustom
        { --from= : Synchronize data from this database instead of the one specified in config }
        { --to= : Synchronize data to this database instead of the one specified in config }
        { --t|tables=* : Only run for given table(s) }
        { --st|skip-tables=* : Skip given table(s) }
        { --l|limit= : Limit query rows (defaults to 5000) }
        { --m|migrate : Run migrations before synchronization }
        { --filter : Filter data condition (ex: updated_at >= \'2021-01-01\') }
        { --truncate : Truncate before inserting data }        
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes your \'from\' database with your \'to\' database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            (new \App\Console\Commands\DatabaseSynchronizer(
                $this->option('from') ?? config('database-synchronizer.from'),
                $this->option('to') ?? config('database-synchronizer.to'),
                $this
            ))
                ->setTables($this->getTables())
                ->setSkipTables($this->getSkipTables())
                ->setLimit((int) $this->getLimit())
                ->setOptions($this->options())
                ->run()
            ;
        } catch (DatabaseConnectionException $e) {
            $this->error($e->getMessage());

            return;
        }
    }

    private function getTables()
    {
        return empty($this->option('tables')) ?
            config('database-synchronizer.tables') : $this->option('tables');
    }

    private function getSkipTables()
    {
        return empty($this->option('skip-tables')) ?
            config('database-synchronizer.skip_tables') : $this->option('skip-tables');
    }

    private function getLimit()
    {
        return $this->option('limit') ?? config('database-synchronizer.limit', DatabaseSynchronizer::DEFAULT_LIMIT);
    }
}
