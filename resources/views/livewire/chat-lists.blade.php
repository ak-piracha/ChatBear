<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
 
                        @forelse( $rooms as $room)
                        <div class="p-6 bg-white border-b border-gray-200">
                            <a href="/chatroom/{{ $room->id}}">{{ $room->name}} </a> 
                            <br/>
                        </div>
                        @empty
                        No Conversations
                        @endforelse
                       
                </div></div></div></div>

</div>
