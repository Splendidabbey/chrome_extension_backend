<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
