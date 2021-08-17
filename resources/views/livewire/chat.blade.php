<div wire:poll>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="background-color:rgb(197, 197, 197)">
                  
                    <h1 style="text-align:center;">{{$second_user->name}}</h1>
                        
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200" >
                        @forelse( $messages as $message)
                        <div class="p-6 bg-white border-b border-gray-200">

                            <label style="color:blue; font-family:verdana" for="user_name">{{ $message->user->name}}</label>  

                            <label style="color:black;" for="user_name">{{ $message->message}}</label>   

                            <br/>
                        </div>
                        @empty
                        No messages yet. Type one Below!
                        @endforelse
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ $messages->links() }}
                            </div>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200" style="background-color:rgb(197, 197, 197)">
                            <form wire:submit.prevent="sendMessage">
                            <input wire:model.defer="message_text" type="text" id="msg_id" name="msg" placeholder="Enter your message here..."  style="width:100%; background-color:white">
                        </form> 
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
