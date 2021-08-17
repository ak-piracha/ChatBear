<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-6 bg-white border-b border-gray-200" style="background-color:rgb(197, 197, 197)">
                        <form wire:submit.prevent="addRoom">
                        <input wire:model.defer="room_name" type="text" id="room_id" name="room" placeholder="Enter your room name here..."  style="width:100%; background-color:white">
                    </form> 
                        </div>
                        @forelse( $rooms as $room)
                        <div class="p-6 bg-white border-b border-gray-200">
                            <a href="/chatroom/{{ $room->id}}">{{ $room->name}} </a> 
                            <br/>
                        </div>
                        @empty
                        No Conversations
                        @endforelse
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ $rooms->links() }}
                            </div>
                </div></div></div></div>

</div>
