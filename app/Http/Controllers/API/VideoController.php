<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function upload(Request $request)    {
        $video = $request->file('video');

        // Validate and store the video on disk using a unique filename
        $path = $video->storeAs('videos', uniqid().'.'.$video->getClientOriginalExtension());

        // You can save the path or other metadata to a database if needed

        return response()->json(['message' => 'Video uploaded successfully']);
    }

    public function uploadChunk(Request $request)   {
        $videoChunk = $request->file('video_chunk');
        $originalFilename = $request->header('X-Original-Filename'); // Get the original filename from headers
    
        // Validate and store the video chunk on disk
        $path = Storage::disk('local')->putFileAs('videos/chunks', $videoChunk, $originalFilename);
    
        return response()->json(['message' => 'Video chunk uploaded successfully']);
    }
}
