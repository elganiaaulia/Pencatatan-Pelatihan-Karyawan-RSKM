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
        $explode = explode(" ", $row[0]);
        $email = $explode[0] . '.' . $row[1];
        return new User([
            'role_id' => 2,
            'full_name' => $row[0],
            'NIK' => $row[1],
            'email' => $email,
            'password' => $row[1],
            'unit' => $row[2],
        ]);
    }
}
