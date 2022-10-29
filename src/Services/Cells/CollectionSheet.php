<?php

namespace Lokalkoder\Support\Services\Cells;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class CollectionSheet implements WithMappedCells, WithHeadingRow, ToCollection
{
    public function headingRow(): int
    {
        return 2;
    }

    public function mapping(): array
    {
        return [
            'code'  => 'B2',
            'category' => 'C2',
            'agency' => 'D2',
            'risk' => 'E2',
        ];
    }

    public function collection(Collection $rows)
    {
        return $rows;
    }
}
