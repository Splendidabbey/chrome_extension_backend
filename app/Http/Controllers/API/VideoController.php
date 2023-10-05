<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function uploadChunk(Request $request)   {
        try {
            $videoChunk = $request->file('video_chunk');
            $originalFilename = $request->header('X-Original-Filename'); // Get the original filename from headers
    
            // Generate a unique filename for each chunk (e.g., using a UUID)
            $uniqueFilename = uniqid().'.'.$videoChunk->getClientOriginalExtension();
    
            // Store the video chunk on disk in the 'videos/chunks' directory with the unique filename
            $path = $videoChunk->storeAs('videos/chunks', $uniqueFilename);
    
            return response()->json(['message' => 'Video chunk uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading chunk: ' . $e->getMessage()], 500);
        }
    }
    
}
