<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoModel;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class VideoController extends Controller
{
    public function videos_get($id)
    {
        $img_id = $id;
        $videos = VideoModel::where('img_id',$id)->orderBy('id','desc')->get();
        return view('videos.index', compact('videos','img_id'));
    }

    public function video_create($id)
    {
        $img_id = $id;
        return view('videos.create',compact('img_id'));
    }

    public function store(Request $request)
    {
        $video_thumb = "";
        if ($request->file('video_thumb')) {
            $Video = $request->file('video_thumb');
            $video_thumb = time() ."_" .rand() . '.' . $Video->getClientOriginalExtension();
            $request->file('video_thumb')->storeAs('public/video_thumb', $video_thumb);
            // Video::make($Video)->resize(50, 50)->save(storage_path('app/video_thumb/' . $VideoName)); // Resize the Video to 50x50 pixels
        }
        $VideoName = "";
        if ($request->file('video_url')) {
            $Video = $request->file('video_url');
            $VideoName = time() ."_" .rand() . '.' . $Video->getClientOriginalExtension();
            $request->file('video_url')->storeAs('public/compressed_videos', $VideoName);
            // Video::make($Video)->resize(50, 50)->save(storage_path('app/compressed_videos/' . $VideoName)); // Resize the Video to 50x50 pixels
        }
        $input['video_thumb'] = $video_thumb;
        $input['video_url'] = $VideoName;
        $input['img_id'] = $request->img_id;
        $Video = VideoModel::create($input);
        
        return redirect()->route('videos_get', ['id' => $request->img_id])->with('success', 'Video created successfully.');

    }

    public function edit(VideoModel $Video)
    {
        return view('videos.edit', compact('Video'));
    }

    public function update(Request $request, VideoModel $Video)
    {
        $input = $request->all(); // collect all form inputs first

        // Handle Reachgems
        if ($request->hasFile('video_thumb')) {
            $this->deleteVideoThumb($Video->video_thumb); // still model here
            $thumbFile = $request->file('video_thumb');
            $thumbName = time() . "_" . rand() . '.' . $thumbFile->getClientOriginalExtension();
            $thumbFile->storeAs('public/video_thumb', $thumbName);
            $input['video_thumb'] = $thumbName;
        }

        // Handle video file
        if ($request->hasFile('video_url')) {
            $this->deleteVideo($Video->video_url);
            $videoFile = $request->file('video_url');
            $videoName = time() . "_" . rand() . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->storeAs('public/compressed_videos', $videoName);
            $input['video_url'] = $videoName;
        }

        $Video->update($input); // Now $Video is still the model
        return redirect()->route('videos_get', ['id' => $Video->img_id])->with('success', 'Video created successfully.');
    }

    public function update_video_status(Request $request)
    {
        $id = $request->id;
        $show_status = $request->show_status;
        $Video = VideoModel::where('id',$id)->first();
        $Video->update(['show_status' => $show_status]);
 
        return response('success');
        // return redirect()->route('videos.index')->with('success', 'Status updated successfully.');
    }

    public function video_delete($id)
    {
        $video = VideoModel::find($id);
        if (!$video) {
            return response()->json(['error' => 'Video not found.'], 404);
        }

        $img_id = $video->img_id;
        $this->deleteVideo($video->video_url);
        $this->deleteVideoThumb($video->video_thumb);
        $video->delete();

        return response()->json(['success' => true, 'redirect_url' => route('videos_get', ['id' => $img_id])]);
    }

    protected function deleteVideoThumb($filename)
    {
        $path = 'public/video_thumb/' . $filename;
        // dd($path);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    protected function deleteVideo($filename)
    {
        $path = 'public/compressed_videos/' . $filename;
        // dd($path);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

}
