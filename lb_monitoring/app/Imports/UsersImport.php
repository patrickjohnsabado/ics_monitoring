<?php

namespace App\Imports;

use App\User;
use App\Borrower;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            User::create([
                'name' => $row[0],
            ]);

            User::create([
                'name' => $row[0],
            ]);
        }
    }
}