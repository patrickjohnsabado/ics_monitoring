<?php

namespace App\Imports;

use App\User;
use App\account_information;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FacultyImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            account_information::create([
                'id_number' => $row[0],                        
                'fullname' => $row[1],
                'type' => 'Student'
                
            ]);
            User::create([
                'id_number' => $row[0],                        
                'email' => $row[2],
                'password' => \Hash::make($row[3])
            ]);
        }
        
    }

    public function startRow(): int
    {
        return 2;
    }
}