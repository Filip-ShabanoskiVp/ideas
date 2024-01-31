@extends("leyout.leyout")

@section("title",'Dashboard')

@section("content")
<div class="row">
    <div class="col-3">
        @include("shared.leftSideBar")
    </div>
    <div class="col-6">
        @include("shared.success_message")
        @include('ideas.shared.submit_idea')
        <hr>
            @forelse ($ideas as $idea)
                <div class="mt-3">
                    @include('ideas.shared.idea_card')
                </div>
            @empty
                 <p class="text-center my-4"> No results found!</p>
            @endforelse
        <div class="mt-3">
            {{ $ideas->withQueryString()->links()}}
        </div>
    </div>
    <div class="col-3">
        @include("shared.searchBar")
        @include("shared.followBox")
    </div>
</div>
@endsection

