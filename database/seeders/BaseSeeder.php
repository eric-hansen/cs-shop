<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

abstract class BaseSeeder extends Seeder
{
    public string $model;
    public string $table;

    protected function processCsvData($filename)
    {
        $fileWithPath = base_path('tests/Fixtures/' . $filename . '.csv');

        $filterValue = function ($value) {
            return trim(str_replace('"', '', $value));
        };

        $data = $filterValue(File::lines($fileWithPath)->first());

        /** @var Model $seederModel */
        $seederModel = new $this->model();

        if (!$this->isFileWhitelisted($filename) ||

            // Check to see if any of the model's properties don't exist in the first line of the given file
            collect($seederModel->getFillable())
                ->diff(explode(",", $data))->isNotEmpty()
        ) {
            throw new \InvalidArgumentException(sprintf('File [%s] is not supported by seeder.', $fileWithPath));
        }

        DB::getPdo()->exec(
            sprintf("LOAD DATA LOCAL INFILE '%s' IGNORE INTO TABLE %s
            FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n'
            IGNORE 1 LINES (%s)", 'tests/Fixtures/' . $filename . '.csv', $seederModel->getTable(), $data));
    }

    /**
     * Since we load data in locally, we should check to ensure the provided
     * filename is allowed to be read.  Preventing such cases as a "shippers_info.csv" file
     * from being loaded in, for example.
     * 
     * @param string $filename 
     * @return bool 
     */
    private function isFileWhitelisted(string $filename): bool
    {
        return match ($filename) {
            'users', 'products', 'inventory', 'orders' => true,
            default => false,
        };
    }
}
