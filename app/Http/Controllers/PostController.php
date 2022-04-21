<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Str;
use DataTables;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;


class PostController extends Controller
{
  private $PAGE_SIZE = 10;
  private $PostYear, $PostMonth;
//   private $PageSize = $PAGE_SIZE;
  private $BaseURL = 'https://l9cua.local.maxbernard.us';
  
  // ==================================
  //
  protected $rules =
  [
    'title'     => 'required',
    'category'  => 'required',
    'tag'       => 'required',
    'content'   => 'required',
    'cover_image' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable|max:2048'
  ];

  // ==================================
  //
  public function __construct()
  {
    $this->middleware('auth');
    $this->PageSize = 10;
    $this->BaseURL = 'https://l9cua.local.maxbernard.us';
  }

  // ==================================
  //  
  public function getPageSize()
  {
    return $this->PageSize; // returns PageSize
  }

  // ==================================
  //  
  public function getBaseURL()
  {
    return $this->BaseURL; // returns BaseURL
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    global $PostYear, $PostMonth, $BaseURL, $PageSize;

    $PostYear = date('Y');
    $PostMonth = date('m');
    $rows = $this->getPageSize();

    // $posts = Post::latest()->get();
    $posts = PostResource::collection(Post::orderBy('id', 'desc')->paginate( $rows ));

    // Build Links and MetaData

    $links = [
      'first'=>$BaseURL . '/posts?page=' . (int)$posts->firstItem(),
      'last'=>$BaseURL . '/posts?page=' . (int)$posts->lastPage(),
      'prev'=>$posts->previousPageUrl(),
      'next'=>$posts->nextPageUrl()
    ];

    $meta = [
      'current_page'=>(int)$posts->currentPage(),
      'from'=>(int)$posts->firstItem(),
      'last_page'=>(int)$posts->lastPage(),
      'path'=>$BaseURL . '/posts',
      'per_page'=>(int)$posts->perPage(),
      'to'=>(int)$posts->lastItem(),
      'total'=>(int)$posts->total()
    ];

    $categories = DB::table('categories')->pluck('name','id');
    $tags = DB::table('tags')->pluck('name','id');

    if ($request->ajax()) {
    //   $data = Post::latest()->get();
      $data = Datatables::of( $posts )
        ->addIndexColumn()
        ->addColumn('action', function($row) {
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);

      return view('posts.index', [
        'data' => $data, 'links'=>$links, 'meta'=>$meta,
        'PostYear'=>$PostYear, 'PostMonth'=>$PostMonth,
        'categories'=>$categories, 'tags'=>$tags
      ]);
    }
    
    // return view('posts.index',compact('posts'));
    return view('posts.index', [
      'data' => $posts, 'links'=>$links, 'meta'=>$meta,
      'PostYear'=>$PostYear, 'PostMonth'=>$PostMonth,
      'categories'=>$categories, 'tags'=>$tags
    ]);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        Book::updateOrCreate(['id' => $request->book_id],
        ['title' => $request->title, 'author' => $request->author]);        
   
        return response()->json(['success'=>'Book saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
      $id = 
        $post = Book::find($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
