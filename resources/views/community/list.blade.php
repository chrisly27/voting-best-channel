
<ul class="list-group">  
    @if (count($links))
        @foreach ($links as $link)
            <li class="CommunityLink list-group-item">

                <form action="/votes/{{ $link->id }}" method="POST">
                    {{ csrf_field() }}

                    <button class="btn {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}"
                        {{ Auth::guest() ? 'disabled' : '' }}    
                    >
                        {{ $link->votes->count() }}
                    </button>
                </form>

                <a href="/community/{{ $link->channel->slug }}" class="btn label label-default" style="background: {{ $link->channel->color }}">
                    {{ $link->channel->title }}
                </a>

                <a href="{{ $link->link }}" target="_blank">
                    {{ $link->title }}
                </a>

                <small>
                    Contributed by: <a href="#">{{ $link->creator->name }}</a>
                        {{ $link->updated_at->diffForHumans() }}
                </small>
            </li>
        @endforeach                      
    @else
        <li class="Links__link">
            No Contributions Yet.
        </li>
    @endif
</ul>

{{ $links->appends(request()->query())->links() }}