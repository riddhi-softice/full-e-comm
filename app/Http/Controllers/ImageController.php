<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// use Spatie\Image\Image;
use Intervention\Image\Facades\Image;
  
class ImageController extends Controller
{
    public function index()
    {
        return view('imageUpload');
    }   
   
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => ['required'],
        ]);
        $imageName = time().'.'.$request->image->extension();  

        // $img = Image::canvas(800, 600, '#0000ff');
        // $img->save(public_path('resized.jpg'));
                
        $uploaded = $request->file('image');
        $format = $uploaded->getClientOriginalExtension(); // jpg, png, webp etc.
        $filename = time() . '.' . $format;
        
        $image = Image::make($uploaded)
            ->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($format, 75)
            ->save(public_path('uploads/' . $filename));

        // $image = Image::make($request->file('image'))->resize(800, 600);
        // $image->save(public_path('resized.jpg'));
        // $image->save(public_path('uploads\resized.jpg'));
        // Image::load($request->image->path())->optimize()->save(public_path('images/'). $imageName);
        
        return back()->with('success', 'You have successfully upload image.')->with('image', $imageName); 
    }
}