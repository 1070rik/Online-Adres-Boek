<?php

namespace AdresBoek\Console\Commands;

use Illuminate\Console\Command;
Use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

include_once(app_path() . '/coordsHandler.php');
use AdresBoek\CoordsHandler;

class importTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importTestData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    private function splitSQL($file, $delimiter = ';')
        {
        set_time_limit(0);
        $queries = array();

        if (is_file($file) === true)
        {
            $file = fopen($file, 'r');

            if (is_resource($file) === true)
            {
                $query = array();

                while (feof($file) === false)
                {
                    $query[] = fgets($file);

                    if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
                    {
                        $query = trim(implode('', $query));

                        array_push($queries, $query);

                        while (ob_get_level() > 0)
                        {
                            ob_end_flush();
                        }

                        flush();
                    }

                    if (is_string($query) === true)
                    {
                        $query = array();
                    }
                }

                fclose($file);
            }
        }

        return $queries;
    }

    public function handle()
    {
        Artisan::call('migrate:fresh');

        $sql = file_get_contents('public/sql/fakeData.sql');

        $queries = $this->splitSQL('public/sql/fakeData.sql');

        foreach ($queries as $query){
            DB::insert($query);  
        }

        CoordsHandler::fillAllAddressesCoords();
    }
}
