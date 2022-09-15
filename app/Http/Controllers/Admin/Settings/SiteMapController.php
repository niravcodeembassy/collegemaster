<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteMapController extends Controller
{
  public function index()
  {
    $this->data['title'] = 'SiteMap';
    $storage  = Storage::disk('public');
    if (!$storage->exists('sitemap.xml')) {
      $storage->put('sitemap.xml', '');
    }
    $site_map = $storage->get('sitemap.xml');
    $this->data['content'] = $site_map;
    return $this->view('admin.settings.sitemap');
  }

  public function store(Request $request)
  {
    $content = $request->content;
    Storage::disk('public')->put('sitemap.xml', $content);
    return redirect()->back()->with('success', 'Sitemap Added successfully');
  }
}