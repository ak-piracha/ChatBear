<div wire:poll>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  
                    <h1>{{$chatwith}}</h1>
                        
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200" >
                        @forelse( $messages as $message)
                        <div class="p-6 bg-white border-b border-gray-200">
                        {{ $message->user->name}} : {{ $message->message}}
                            <br/>
                        </div>
                        @empty
                        No messages yet. Type one Below!
                        @endforelse
                       
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200" >
                            <form wire:submit.prevent="sendMessage">
                            <input wire:model.defer="messageText" type="text" id="msg_id" name="msg" placeholder="Enter your message here..."  style="height:50px; width:95%; background-color: rgb(209, 217, 218)">
                            <input type="submit" value="Submit"><br><br>
                        </form> 
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
