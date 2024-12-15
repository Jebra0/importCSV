<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadFileController extends Controller
{
    public function upload(){
        return view('upload');
    }
    public function store(Request $request){
        $csv = file($request->file);

        //chunking to small files
        $chunks = array_chunk($csv, 1000);

        $path = storage_path('temp_data');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        foreach ($chunks as $key => $chunk) {
            $name = "/tmp{$key}.csv";

            file_put_contents($path.$name, $chunk);
        }
        return redirect()->route('store');
    }

    public function add_data()
    {
        $path = storage_path('temp_data');
        $header = [];
        $files = glob("$path/*.csv");

        foreach ($files as $key => $file) {
            $data = array_map('str_getcsv', file($file));
            if($key === 0){
                $header = $data[0];
                unset($data[0]);
            }
            foreach ($data as $value) {
                $sales_data = array_combine($header, $value);
                Sale::create($sales_data);
            }
            unlink($file);
        }
        return 'done';
    }
}
