<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller {
    public function getAllVideos() {
        try {
            // Get a list of all video files in the 'videos' directory
            $videoFiles = Storage::disk('local')->files('videos/chunks');

            // Filter out any non-video files if necessary
            $videoFiles = array_filter($videoFiles, function ($file) {
                return preg_match('/\.(mp4|avi|mov)$/', $file); // Adjust the regex pattern for more extensions if needed
            });

            // Create an array to store the video file names and URLs
            $videos = [];

            // Generate URLs for each video file
            foreach ($videoFiles as $videoFile) {
                $videoName = pathinfo($videoFile, PATHINFO_FILENAME);
                $videoUrl = asset('storage/app/videos/chunks/' . $videoFile);
                $videoSize = Storage::disk('local')->size($videoFile);

                $videos[] = [
                    'name' => $videoName,
                    'url' => $videoUrl,
                    'size' => $videoSize,
                ];
            }

            return response()->json(['videos' => $videos]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching videos: ' . $e->getMessage()], 500);
        }
    }
    public function uploadChunk(Request $request) {
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
