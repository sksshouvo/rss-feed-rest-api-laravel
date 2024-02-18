<?php

namespace App\Http\Controllers\RssFeed;

use App\Http\Requests\RssFeedFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RssFeed;
use Log;
use DB;

class RssFeedController extends Controller
{

    public function __construct() {
        $this->rss_feed = new RssFeed;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "index";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function start(RssFeedFormRequest $request)
    {
        $request->validate($request->start());

        $rssFeedLink      = $request->input('rss_feed_link');
        $refreshInterval  = $request->input('refresh_interval');
        $intervalType     = $request->input('interval_type');
        $sessionStartedAt = $request->input('session_started_at');

        try {
            DB::beginTransaction();
            $rssFeed = $this->rss_feed->storeRssFeed(title: $title,link: $link,publishedAt: $publishedAt);
            DB::commit();
            return successResponse($request->bearerToken(), $rssFeed, __('rss_feed.store'), 201);

        } catch (\Exception $e) {

            DB::rollback();
            Log::info($e);
            return errorResponse($e, __('common.error'), 500);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Show";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "destroy";
    }
}
