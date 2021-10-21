<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Revenue;
use App\User;
use App\Like;
use App\Comment;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $revenue = Revenue::all()->sum('revenue');
        $blogs = Blog::get();
        return view('blog.index', compact('user_info', 'blogs', 'revenue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 && $user_info->identifier != 1)) {

            return abort(404);
        }
        $revenue = Revenue::all()->sum('revenue');
        return view('blog.create', compact('user_info', 'revenue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 && $user_info->identifier != 1)) {
            return abort(404);
        }

        try {
            $request->validate([
                'name' => 'required',
                'short_description' => 'required',
                'content' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            $image = $request->file('thumbnail');
            $image_name = 'Blog' . md5(rand()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path("images/thumbnail"), $image_name);

            if($user_info->identifier == 1) $status = 'Disabled';
            else $status = 'Enabled';
            $blogData = [
                'user_id'           => Auth::id(),
                'name'              => $request->name,
                'slug'              => str_slug($request->name) . '-' . $this->generateRandomString(5),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'thumbnail'         => $image_name,
                'status'            => $status
            ];
            // return $blogData;

            $success = Blog::create($blogData);
            if($user_info->identifier == 1){
                if ($success) return redirect()->route('teacher.profile', Auth::user()->username)->with(['success' => 'Blog Saved Successfully!']); 
                else return redirect()->route('teacher.profile', Auth::user()->username)->with(['danger' => 'Something went wrong!']); 
            }else {
                if ($success) return redirect()->route('blog.index')->with(['success' => 'Blog Saved Successfully!']);
                else return redirect()->route('blog.index')->with(['error' => 'Something went wrong!']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 && $user_info->identifier != 1)) {

            return abort(404);
        }
        $blog = Blog::find($id);
        $revenue = Revenue::all()->sum('revenue');
        return view('blog.edit', compact('user_info', 'blog', 'revenue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 && $user_info->identifier != 1)) {
            return abort(404);
        }

        try {
            $request->validate([
                'name' => 'required',
                'short_description' => 'required',
                'content' => 'required',
            ]);

            $oldData = Blog::find($request->id);

            $image = Blog::where('id', $request->id)->pluck('thumbnail');
            $image_name = sizeof($image) ? $image[0] : null;

            if (isset($request->thumbnail)) {
                $oldImagePath = 'images/thumbnail/' . $oldData->thumbnail;
                File::delete($oldImagePath);


                $image = $request->file('thumbnail');
                $image_name = 'Blog' . md5(rand()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path("images/thumbnail"), $image_name);
            }

            $blogData = [
                'name'              => $request->name,
                'slug'              => $oldData->name == $request->name ? $oldData->slug : str_slug($request->name) . '-' . $this->generateRandomString(5),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'thumbnail'         => $image_name,
                'status'            => $request->status
            ];
            // return $blogData;

            $success = Blog::updateOrCreate(
                ['id' => $request->id],
                $blogData
            );

            if ($success) return redirect()->route('blog.index')->with(['success' => 'Blog Updated Successfully!']);
            else return redirect()->route('blog.index')->with(['error' => 'Something went wrong!']);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->back()->with(['success' => 'Blog Deleted Successfully!']);
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function list()
    {
        // $topBlogs = Blog::with('likes')->with('comments')->where('status', 'Enabled')->limit(3)->get();
        $topBlogs = Blog::with('likes')->with('comments')
                    ->select('*')->selectSub(function ($q) {
                        $q->from('likes')
                            ->whereRaw('likes.model_id = blogs.id')
                            ->selectRaw('count(*)');
                    }, 'likes_count')
                    ->where('status', 'Enabled')
                    ->orderBy('likes_count', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
        $blogs = Blog::with('likes')->with('comments')->where('status', 'Enabled')->orderBy('created_at', 'desc')->paginate(9);

        return view('blog.list', compact('blogs', 'topBlogs'));
    }

    public function blogSingle(Request $request)
    {
        $blog = Blog::with('likes')->with('comments.user')->where('slug', $request->slug)->first();
        $like = 0;
        if (Auth::check()) {
            $like = Like::where('model', 'blog')
                ->where('model_id', $blog->id)
                ->where('user_id', auth()->user()->id)
                ->count();
        }

        if (!isset($blog)) {
            return abort(404);
        }
        return view('blog.single', compact('blog', 'like'));
    }

    public function like(Request $request)
    {
        $like = Like::where('model', 'blog')
            ->where('model_id', $request->model_id)
            ->where('user_id', $request->user_id)
            ->count();
        if ($like) {
            Like::where('model', 'blog')
                ->where('model_id', $request->model_id)
                ->where('user_id', $request->user_id)
                ->delete();
            $blogLikes = Like::where('model', 'blog')->where('model_id', $request->model_id)->count();
            return response()->json([
                'status' => 'unliked',
                'likes' => $blogLikes,
            ]);
        }
        $like = new Like();
        $like->model = 'blog';
        $like->model_id = $request->model_id;
        $like->user_id = $request->user_id;
        $like->save();
        $blogLikes = Like::where('model', 'blog')->where('model_id', $request->model_id)->count();
        return response()->json([
            'status' => 'liked',
            'likes' => $blogLikes,
        ]);
    }

    public function comment(Request $request)
    {
        $comment = new Comment();
        $comment->model = 'blog';
        $comment->comment = $request->comment;
        $comment->model_id = $request->model_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return redirect()->back()->with('success', 'Comment posted Successfully!');
    }
}
