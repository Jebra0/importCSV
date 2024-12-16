<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsvJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class UploadFileController extends Controller
{
    public function upload(){
        return view('upload');
    }
    public function store(Request $request){
        $csv = file($request->file);

        //chunking to small files
        $chunks = array_chunk($csv, 1000);

        // create Batch
        $batch = Bus::batch([])->dispatch();

        $header = [];
        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);

            if($key == 0){
                $header = $data[0];
                unset($data[0]);
            }
            //add each chunk job to the batch
            $batch->add(new ImportCsvJob($data, $header));
        }
        return Bus::findBatch($batch->id);
    }
}
