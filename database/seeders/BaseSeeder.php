<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

abstract class BaseSeeder extends Seeder
{
    public string $model;
    public string $filename;

    public function run()
    {
        $fileWithPath = base_path('tests/Fixtures/' . $this->filename);

        $headerColumns = str_replace('"', '', trim((string)File::lines($fileWithPath)->first()));

        /** @var Model $seederModel */
        $seederModel = new $this->model();

        if (!$this->isFileWhitelisted($this->filename) ||

            // Check to see if any of the model's properties don't exist in the first line of the given file
            collect($seederModel->getFillable())
                ->diff(explode(",", $headerColumns))->isNotEmpty()
        ) {
            throw new \InvalidArgumentException(sprintf('File [%s] is not supported by seeder.', $fileWithPath));
        }

        DB::getPdo()->exec(
            sprintf("LOAD DATA LOCAL INFILE '%s' IGNORE INTO TABLE %s
            FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n'
            IGNORE 1 LINES (%s)", 'tests/Fixtures/' . $this->filename, $seederModel->getTable(), $headerColumns));
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
            'users.csv', 'products.csv', 'inventory.csv', 'orders.csv' => true,
            default => false,
        };
    }
}
