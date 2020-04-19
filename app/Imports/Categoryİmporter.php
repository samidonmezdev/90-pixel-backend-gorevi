<?php

namespace App\Imports;
use App\Models\category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class Categoryİmporter implements toModel
{
    /**
     * @param array $row
     * @return category
     */
    public function collection(array $row)
    {
        return new category([
            'node'=>$row[0],
            'left'=>$row[1],
            'right'=>$row[2]

        ]);
    }

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        // TODO: Implement model() method.
    }
}
