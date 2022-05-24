<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|void|null
     */
    public function model(array $row)
    {
        $user = User::where('firstname', '=', $row['firstname'])
            ->where('lastname', '=', $row['lastname'])
            ->first();

        if (!$user || is_null($row['notesaddress'])) {
            return;
        }
        $user->lotus_login = $row['notesaddress'];
        $user->save();
        return $user;
    }
}
