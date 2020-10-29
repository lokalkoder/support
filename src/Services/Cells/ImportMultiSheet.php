<?php
namespace Lokalkoder\Support\Services\Cells;

use ReflectionClass;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Lokalkoder\Support\Services\Cells\CollectionSheet;

class ImportMultiSheet implements WithMultipleSheets
{
    public $headers;

    public function __construct(array $headers = [])
    {
        $this->headers = (Collection::make($headers))->mapWithKeys(function ($header, $key) {
            return $this->prepareHeader($key, $header);
        })->toArray();
    }

    protected function prepareHeader($key, $value)
    {
        if (class_exists($value)) {
            $classObject = new ReflectionClass($value);

            if ($classObject->implementsInterface(ToCollection::class) ||
                $classObject->implementsInterface(ToModel::class) ||
                $classObject->implementsInterface(ToArray::class)) {
                return [$key => $classObject->newInstance()];
            }
        }

        return [$value => new CollectionSheet()];
    }


    public function sheets(): array
    {
        return $this->headers;
    }
}
