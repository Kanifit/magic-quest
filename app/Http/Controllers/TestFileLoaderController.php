<?php

namespace App\Http\Controllers;

use \App\Models\BookTest\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestFileLoaderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file->store('test/uploads', 'public');
        $download = File::create([
            'name'    => 'test',
            'path'    => $path,
            'mime'    => $request->file->getMimeType(),
            'size'    => $request->file->getSize(),
            'step_id' => $request->get('stepId')
        ]);

        return $download->id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookTest\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookTest\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if (!Storage::disk('public')->delete($file->getPath())){
            return;
        }
        if ($file->delete())
        {
            return ['result' => true];
        }

        //
    }
}
