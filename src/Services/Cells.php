<?php
namespace Lokalkoder\Support\Services;

use Maatwebsite\Excel\Facades\Excel;
use Lokalkoder\Support\Services\Cells\ImportMultiSheet;

class Cells
{
    public $source;

    public $excel;

    public function __construct(string $filepath)
    {
        $this->source = $filepath;
    }

    public function getSheet(string $worksheets, $formatter = null)
    {
        if ($formatter === null) {
            $sheet = [$worksheets];
        } else {
            $sheet = [$worksheets => $formatter];
        }
        
        return (Excel::toCollection(new ImportMultiSheet($sheet), $this->source))->first();
    }

    public function getCollections(array $worksheets = [])
    {
        return Excel::toCollection(new ImportMultiSheet($worksheets), $this->source);
    }

    public function importToDb(array $worksheets = [])
    {
        return Excel::import(new ImportMultiSheet($worksheets), $this->source);
    }
}
