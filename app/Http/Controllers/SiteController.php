<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index()
    {
        //
    }

    public function store(StoreSiteRequest $request, Site $site)
    {
        $site->fill($request->input());
        $site->user_id = Auth::id();
        $site->save();
        return $this->success('站点添加成功', new SiteResource($site));
    }

    public function show(Site $site)
    {
        //
    }


    public function update(UpdateSiteRequest $request, Site $site)
    {
        //
    }

    public function destroy(Site $site)
    {
        //
    }
}
