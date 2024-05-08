<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = [];
        $users = User::all();
        foreach ($users as $user) {
            $collection[] = [
                'full_name' => $user->full_name,
                'NIK' => $user->NIK,
                'unit' => $user->unit,
                'email' => $user->email,
            ];
        }

        return collect($collection);
    }

    public function headings(): array
    {
        return [
            'full_name',
            'NIK',
            'unit',
            'email',
        ];
    }
}
