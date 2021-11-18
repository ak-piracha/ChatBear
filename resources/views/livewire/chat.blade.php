@if ((config('constants.chat.realtime') ?? false) == true)
    <div wire:poll>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200" style="background-color:rgb(197, 197, 197); position:fixed;left: 50px; width: calc(100% - 100px); top:10% ">

                    <h1 style="text-align:center;">{{$second_user->name}} | Last Seen :  {{$this->interval}}</h1>

                    </div>
                    <div class="p-6 bg-white border-b border-gray-200" style="position:static; top:800px">
                        @forelse( $messages as $message)
                        <div class="p-6 bg-white border-b border-gray-200">

                            <label style="color:rgb(25, 25, 95); font-family:verdana" for="user_name">{{ $message->user->name}}</label>

                            @if ($message->status == 2)
                            <label style="color:rgb(122, 6, 255);" for="user_name">{{ $message->message}} : {{$message->status}}</label>
                            <label style="color:rgb(6, 255, 139);" for="user_name">new</label>
                            @else
                            <label style="color:black;" for="user_name">{{ $message->message}}</label>
                            <label style="color:black; text-align:right" for="user_name">{{$message->created_at}}</label>
                            @endif
                            {{-- <label style="color:pink;" for="user_name">{{ $message->message}} : {{$message->status}}</label> --}}
                            <br/>
                        </div>
                        @empty
                        No messages yet. Type one Below!
                        @endforelse
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ $messages->links() }}
                            </div>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200" style="background-color:rgb(197, 197, 197);  position:fixed;left: 50px; width: calc(100% - 100px); bottom:1%">
                            <form wire:submit.prevent="sendMessage" entype="multipart/form-data">
                            <input wire:model.defer="message_text" type="text" id="msg_id" name="msg" placeholder="Enter your message here..."  style="width:100%; background-color:white">
                        </form>

                        <form wire:submit.prevent="save">
                            <input type="file" wire:model="photo">

                            @error('photo') <span class="error">{{ $message }}</span> @enderror

                            <button type="submit">Save Photo</button>
                        </form>

                            </div>
                </div>
            </div>
        </div>
    </div>

@if ((config('constants.chat.realtime') ?? false) == true)
    </div>
@endif
