<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Content;
use App\Http\Resources\BlogResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function blogs()
    {
        $contents = Content::wherePage('blogs')->get();
        $latest = Blog::with('category')->whereStatus(true)->latest('updated_at')->first();

        return view('blogs', compact('contents', 'latest'));
    }

    public function blog(Blog $blog)
    {
        $similar = Blog::whereStatus(true)
            ->where('id', '!=', $blog->id)
            ->where('category_id', $blog->category->id)
            ->inRandomOrder()
            ->take(2)
            ->get();

        return view('blog', compact('blog', 'similar'));
    }

    public function blogsList()
    {
        abort_unless(request()->wantsJson(), 404);

        $query = Blog::latest('updated_at')
            ->when(request('pageName') == 'landing', function ($query) {
                $query->where('id', '!=', Blog::latest('updated_at')->first()->id);
            })
            ->when(request('pageName') == 'innerBlog', function ($query) {
                $query->where('slug', '!=', request('blogSlug'));
            });

        return BlogResource::collection($query->paginate(4));
    }

    // == == == CMS SIDE == == ==
    public function index()
    {
        return view('cms.pages.spa');
    }
    public function create()
    {
        return view('cms.pages.spa');
    }
    public function edit(Blog $blog)
    {
        return view('cms.pages.spa');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('blogs')->get()], 200);
        }
    }

    public function store()
    {
        $attr = request()->validate([
            'banner' => 'required|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'thumbnail' => 'required|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1200,max_height=630',
            'title' => 'required|string|max:255|unique:blogs',
            'category' => 'required|exists:categories,id,deleted_at,NULL',
            'date' => 'required|date',
            'details' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string'
        ]);

        if (request('banner') && request('thumbnail')) {
            $banner = Str::slug(request('alt_text'), '-') . '.' . request()->file('banner')->getClientOriginalExtension();
            $thumbnail = "thumbnail_{$banner}";
        }

        $category = Category::find(request('category'));
        $blog = $category->blogs()->create(array_merge($attr, [
            'banner' => $banner,
            'published_at' => request('date'),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        if (isset($banner)) {
            $path = "blogs/{$blog->slug}";
            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(1920, 614)
                ->save();
            // thumbnail
            request()->file('thumbnail')->storeAs($path, $thumbnail);
            \Image::make(public_path("/storage/{$path}/{$thumbnail}"))
                ->resize(1200, 630, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        return response(['success' => 'Blog successfully created.'], 200);
    }

    public function update(Blog $blog)
    {
        $attr = request()->validate([
            'banner' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1200,max_height=630',
            'title' => ['required', 'string', 'max:255', 'unique:blogs,title,' . $blog->id],
            'category' => 'required|exists:categories,id,deleted_at,NULL',
            'date' => 'required|date',
            'details' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string'
        ]);

        $oldBlog = $blog->replicate();

        $blog->update(array_merge($attr, [
            'category_id' => request('category'),
            'published_at' => request('date'),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        // change folder name if new title
        if ($oldBlog->slug != $blog->slug && Storage::exists('blogs/' . $oldBlog->slug)) {
            Storage::move('blogs/' .  $oldBlog->slug, 'blogs/' .  $blog->slug);
        }

        if (request()->hasFile('banner')) {
            $banner = Str::slug($blog->alt_text, '-') . '.' . request()->file('banner')->getClientOriginalExtension();
            $path = "blogs/{$blog->slug}";

            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save();

            $blog->update(['banner' => $banner]);
        }

        if (request()->hasFile('thumbnail')) {
            $thumbnail = "thumbnail_{$blog->banner}";
            $path = "blogs/{$blog->slug}";

            // thumbnail
            request()->file('thumbnail')->storeAs($path, $thumbnail);
            \Image::make(public_path("/storage/{$path}/{$thumbnail}"))
                ->resize(1200, 320, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        return response([
            'success' => 'Blog successfully updated.',
        ], 200);
    }

    public function destroy(Blog $blog)
    {
        Storage::deleteDirectory("blogs/$blog->slug");
        $blog->delete();

        return response()->json(['success' => 'Blog Successfully Deleted!'], 200);
    }

    public function editBlog(Blog $blog)
    {
        if (request()->wantsJson()) {
            return response([
                'blog' => $blog
            ], 200);
        }
    }

    public function records()
    {
        $query = Blog::with('category');

        return JsonResource::collection($query->paginate(request('per_page')));
    }
}
