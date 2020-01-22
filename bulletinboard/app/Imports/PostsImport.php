<?php

namespace App\Imports;

use Auth;
use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator;

class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $auth_id = Auth::user()->id;
        
        return new Post([
            'title' => @$row[0],
            'description' => @$row[1],
            'create_user_id' => $auth_id,
            'updated_user_id' => $auth_id,
        ]);
        $filename = $file->getClientOriginalName();
        $file->move($auth_id.'/csv', $filename);
        $filepath = public_path() . '/'.$auth_id .'/csv/' .$filename;
    }
}
