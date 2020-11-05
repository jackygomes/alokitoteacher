<?php

namespace App\Http\Controllers;

use App\Order;
use App\Resource;
use App\ResourceCategory;
use App\ResourceDocument;
use App\ResourceVideo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = ResourceCategory::all();
        $userId = Auth::check() ? Auth::user()->id : 0;
        $category = null;

        if(isset($request->category)){
            $category = ResourceCategory::where('id', $request->category)->first();
        }
        if($category){
            $resource_info = Resource::with('user')->where('category_id',$category->id)->where('status', 'Approved')->paginate(12);
        }else {
            $resource_info = Resource::with('user')->where('status', 'Approved')->paginate(12);
        }

        foreach($resource_info as $resource){
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'resource')
                ->where('user_id', $userId)
                ->where('product_id', $resource->id)->count();

            $resource->isBought = $isOrdered ? 1 : 0;
        }

        return view ('resource.resources',compact('categories','resource_info'));
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
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
        $categories = ResourceCategory::all();
        return view('resource.create', compact('user_info', 'categories'));
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
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $this->validate($request, [
            'resource_name'         => 'required',
            'resource_description'  => 'required',
            'resource_price'        => 'required|numeric|max:600',
            'category'              => 'required',
            'thumbnailImage'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $randomText = Str::random(10);
        $slug = Str::slug($request->input('resource_name'), '-');
        $slug = $slug.'-'.$randomText;

        $image = $request->file('thumbnailImage');
        $image_name = $userId.'_resource_'.md5(rand()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path("images/thumbnail"), $image_name);

        try{
            $resourceData = [
                'user_id'       => $userId,
                'category_id'   => $request->category,
                'resource_title'=> isset($request->resource_name) ? $request->resource_name : "",
                'description'   => isset($request->resource_description) ? $request->resource_description : "",
                'price'         => $request->resource_price,
                'slug'          => $slug,
                'thumbnail'     => $image_name,
            ];

            Resource::create($resourceData);


        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        if($user_info->identifier == 1){
            return redirect()->route('teacher.dashboard')->with('success', 'Resource created successfully');
        }elseif($user_info->identifier == 2) {
            return redirect()->route('school.dashboard')->with('success', 'Resource created successfully');
        }else {
            return redirect()->route('dashboard')->with('success', 'Resource created successfully');
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
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }

        $resource = Resource::find($id);

        $videos = DB::table('resource_videos')
            ->select('id', 'video_title as title', DB::raw('1 as type'))
            ->where('resource_id', '=', $resource->id);

        $contents = DB::table('resource_documents')
            ->select('id', 'doc_title as title', DB::raw('2 as type'))
            ->where('resource_id', '=', $resource->id)
            ->union($videos)
            ->get();
//        return count($contents);
        $categories = ResourceCategory::all();

        return view('resource.edit', compact('user_info','resource','contents','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $resource = Resource::find($id);
        if ($resource == null) {
            return abort(404);
        }
        $this->validate($request, [
            'resource_name'         => 'required',
            'resource_description'  => 'required',
            'resource_price'        => 'required|numeric|max:600',
            'category'              => 'required',
        ]);

        if($resource->resource_title != $request->resource_name){
            $randomText = Str::random(10);
            $slug = Str::slug($request->resource_name, '-');
            $slug = $slug.'-'.$randomText;
        } else {
            $slug = $resource->slug;
        }

        $resource->category_id = $request->category;
        $resource->resource_title = $request->resource_name;
        $resource->description = $request->resource_description;
        $resource->price = $request->resource_price;
        $resource->status = $request->status;
        $resource->slug = $slug;

        if(isset($request->thumbnailImage)) {
            $image = $request->file('thumbnailImage');
            $image_name = $userId.'_resource_'.md5(rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path("images/thumbnail"), $image_name);
            $resource->thumbnail = $image_name;
        }

        $resource->save();
        return redirect()->back()->with('success', 'Resource Edited Successfully');
    }

    /** resource video create
     * @param Request $request
     * @param $resoureId
     */
    public function videoCreate(Request $request, $resourceId) {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
        $this->validate($request, [
            'url'           => 'required',
            'title'         => 'required',
        ]);

        try {
            $videoData = [
                'resource_id'   => $resourceId,
                'video_title'   => $request->title,
                'url'           => $request->url,
                'description'   => $request->description,
            ];
            ResourceVideo::create($videoData);

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->back()->with('success', 'Resource Video Created Successfully');
    }

    public function videoUpdate(Request $request, $id) {

        $this->validate($request, [
            'url'           => 'required',
            'title'         => 'required',
        ]);
        try {
            $video = ResourceVideo::find($id);

            $video->video_title = $request->title;
            $video->url = $request->url;
            $video->description = $request->description;

            $video->save();


        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->back()->with('success', 'Resource Video Updated Successfully');

    }

    public function documentCreate(Request $request, $resourceId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1 || $user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $this->validate($request, [
            'title'    => 'required',
            'doc_file' => 'required|mimes:pdf,xlsx,xlsm,xlsb,xltx,xltm,xls,xlt,xml,xlam,xla,xlw,xlr,csv,doc,docx,potx,ppa,pps,ppsx,pptx',
        ]);

        $file = $request->file('doc_file');
        $fileName = '';
        if($file) {
            $fileNameOriginal = explode('.', $file->getClientOriginalName());
            $newNameOriginal = Str::slug($fileNameOriginal[0],'-');
            $fileName = $newNameOriginal.'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path("documents"), $fileName);
        }

        try {
            $documentData = [
                'resource_id'   => $resourceId,
                'doc_title'     => $request->title,
                'description'   => $request->description,
                'file'          => $fileName ? $fileName : null,
            ];
            ResourceDocument::create($documentData);

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->back()->with('success', 'Resource Document Updated Successfully');
    }

    public function documentUpdate(Request $request, $id)
    {
//        return $request->all();
        $this->validate($request, [
            'title'    => 'required',
            'doc_file' => 'file|mimes:pdf,xlsx,xlsm,xlsb,xltx,xltm,xls,xlt,xml,xlam,xla,xlw,xlr,csv,doc,docx,potx,ppa,pps,ppsx,pptx',
        ]);


        try {
            $document = ResourceDocument::find($id);

            $document->doc_title = $request->title;
            $document->description = $request->description;

            $file = $request->file('doc_file');
            if($file) {
                $fileName = '';
                $fileNameOriginal = explode('.', $file->getClientOriginalName());
                $newNameOriginal = Str::slug($fileNameOriginal[0],'-');
                $fileName = $newNameOriginal.'-'.time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path("documents"), $fileName);

                $document->file = $fileName ? $fileName : null;
            }

            $document->save();


        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->back()->with('success', 'Resource Resource Updated Successfully');
    }

    public function load_content(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $resource = $request->resource;

        if ($resource == 'resource' || $resource == 'r') {
            if ($type == 1) {
                return ResourceVideo::find($id);
            } else {
                return ResourceDocument::find($id);
            }
        }
    }

    public function resourceOverview(Request $request) {
        $info = Resource::where('slug', '=', $request->slug)->first();

        $userId = Auth::check() ? Auth::user()->id : 0;
        $isOrdered = Order::where('status', 'paid')
            ->where('product_type', 'resource')
            ->where('user_id', $userId)
            ->where('product_id', $info->id)->first();

        $info->isBought = $isOrdered ? 1 : 0;

        if ($info == null) {
            return abort(404);
        }
        $creator = User::find($info->user_id);
        return view('resource.overview', compact('info','creator'));
    }

    public function resourceView(Request $request) {
        $resource = Resource::where('slug', '=', $request->slug)->first();

        if ($resource == null) {
            return abort(404);
        }

        $videos = DB::table('resource_videos')
            ->select('id', 'video_title as title', DB::raw('1 as type'))
            ->where('resource_id', '=', $resource->id);

        $contents = DB::table('resource_documents')
            ->select('id', 'doc_title as title', DB::raw('2 as type'))
            ->where('resource_id', '=', $resource->id)
            ->union($videos)
            ->get();

//        return $contents;
        return view('resource.view', compact('resource', 'contents'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
