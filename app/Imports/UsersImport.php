<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'id' => $row[0],
            'first_name'     => $row[1],
            'second_name'     => $row[2],
            'third_name'     => $row[3],
            'last_name'     => $row[4],
            'grades'    => $row[5],
            'seating_numbers' => $row[6],
            'email' => $row[7],
            'password' => bcrypt('123456789'),
        ]);
    }

}
