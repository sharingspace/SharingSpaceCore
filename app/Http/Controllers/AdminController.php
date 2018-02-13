<?php
/**
 * This controller handles all admin actions
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Models\CommunitySubscription;
use App\Models\Community;
use log;


class AdminController extends Controller
{

    /**
     * Returns customer listing
     *
     * @todo Make this use an Ajax call for faster loading
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return View
     */
    public function getCustomerList()
    {
        if (Gate::denies('admin')) {
            abort(404);
        }
        $subscriptions = CommunitySubscription::with('user','community')->where('active','=','1')->orderBy('created_at','DESC')->paginate(100);
        return view('admin/customers')->with('subscriptions', $subscriptions);

    }

   /**
     * Create thumbnails for all entries across all communities
     * Usage: https://openshare.anyshare.app/admin/create_thumbnails
     *
     * @author [D. Linnard] [<dslinnard@yahoo.com>]
     * @since  [v1.0]
     * @return None
     */
    public function createThumbnails()
    {
        $communities = Community::communities();
        echo count($communities)."<br>";;
        foreach ($communities as $communitiy) {
            $entries = $communitiy->entries()->get();

            foreach ($entries as $entry) {
                $image = $entry->media->first();

                if ($image) {
                    echo 'Converting image for entry id ' . $entry->id . ' on share ' . $communitiy->name . '<br>';
                    $path_parts = pathinfo('/assets/uploads/entries/' . $entry->id . '/' . $image->filename);
                    $entry->createThumbnailImage($path_parts['filename'], $path_parts['extension'], public_path().'/assets/uploads/entries/' . $entry->id . '/', 'entries', $entry->id);
                }
            }
        }
    }
}
