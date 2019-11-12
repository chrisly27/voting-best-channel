<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommunityLink;
use App\Channel;
use App\Exceptions\CommunityLinkAlreadySubmitted;
use App\Http\Requests\CommunityLinkForm;
use App\Queries\CommunityLinksQuery;

class CommunityLinksController extends Controller
{
    public function index(Channel $channel)
    {
        $links = (new CommunityLinksQuery)->get(
            request()->exists('popular'), $channel
        );


        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community.index', compact('links', 'channels', 'channel'));
    }

    public function store(CommunityLinkForm $form)
    {
        try
        {
            
            $form->persist();

            if(auth()->user()->isTrusted())
            {
                flash()->overlay('Thanks for the contribution!', 'success');
            }
            else
            {
                flash('Thanks!', 'This contribution will be approved shortly');
            }
        } 
        catch (CommunityLinkAlreadySubmitted $e)
        {
            flash()->overlay(
                "We'll instead bump the timestamps and bring that link back to the top. Thanks!",
                "That Link Has Already Been Submitted");
        }

        return back();
    }
}
