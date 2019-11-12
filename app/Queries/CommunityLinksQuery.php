<?php

namespace App\Queries;

use App\CommunityLink;

class CommunityLinksQuery
{
    public function get($sortByPopular, $channel)
    {
        $orderBy = $sortByPopular ? 'votes_count' : 'updated_at';

        return CommunityLink::with('creator', 'channel')
            ->withCount('votes')
            ->forChannel($channel)
            ->groupBy('community_links.id')
            ->orderBy($orderBy, 'desc')
            ->paginate(6);

        }
}