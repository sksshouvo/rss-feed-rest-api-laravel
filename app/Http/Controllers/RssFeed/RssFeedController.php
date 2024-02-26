<?php

namespace App\Http\Controllers\RssFeed;

use App\Http\Requests\RssFeedFormRequest;
use App\Http\Resources\RssFeedCollection;
use App\Http\Resources\RssFeedResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RssFeedDetail;
use App\Models\RssFeed;
use Log;
use DB;

class RssFeedController extends Controller
{

    public function __construct() {
        $this->rss_feed = new RssFeed;
        $this->rss_feed_detail = new RssFeedDetail;
    }
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        
        try {
            DB::beginTransaction();
            $rssFeedList = $this->rss_feed->list();
            DB::commit();
            return successResponse($request->bearerToken(), new RssFeedResource($rssFeedList), __('rss_feed.list'), 201);

        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency($e);
            return errorResponse($e, __('common.error'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function start(RssFeedFormRequest $request)
    {
        $request->validate($request->start());

        $rssFeedLink      = $request->input('rss_feed_link', NULL);
        $refreshInterval  = $request->input('refresh_interval', NULL);
        $intervalType     = $request->input('interval_type', NULL);
        $sessionStartedAt = $request->input('session_started_at', NULL);
        $rssFeedDetails   = $request->input('rss_feed_details', []);

        try {
            DB::beginTransaction();
            $rssFeed = $this->rss_feed->storeFeed(rssFeedLink: $rssFeedLink, refreshInterval: $refreshInterval, intervalType: $intervalType, sessionStartedAt: $sessionStartedAt);
            $rssFeedDetail = $this->rss_feed_detail->storeRssFeedDetail(rssFeedId: $rssFeed->id, rssFeedDetails: $rssFeedDetails);
            DB::commit();
            return successResponse($request->bearerToken(), new RssFeedResource($rssFeed), __('rss_feed.store'), 201);

        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency($e);
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
    public function stop(RssFeedFormRequest $request)
    {
        $request->validate($request->stop());
        $sessionEndedAt = $request->input('session_ended_at', NULL);

        try {
            DB::beginTransaction();
            $stoppedRssFeed = $this->rss_feed->stopFeed(sessionEndedAt: $sessionEndedAt);
            DB::commit();
            Log::info($stoppedRssFeed);
            return successResponse($request->bearerToken(), new RssFeedResource($stoppedRssFeed), __('rss_feed.stopped'), 201);

        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency($e);
            return errorResponse($e, __('common.error'), 500);
        }
    }

    public function refetch(RssFeedFormRequest $request) {
        
        $request->validate($request->refetch());
        $rssFeedDetails = $request->input('rss_feed_details', []);

        try {
            DB::beginTransaction();
            $this->rss_feed_detail->storeRssFeedDetail(rssFeedId: $request->rss_feed_id, rssFeedDetails: $rssFeedDetails);
            $rssFeedList = $this->rss_feed->list();
            DB::commit();
            return successResponse($request->bearerToken(), new RssFeedResource($rssFeedList), __('rss_feed.store'), 201);

        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency($e);
            return errorResponse($e, __('common.error'), 500);
        }

    }
}
