@if ((config('constants.chat.realtime') ?? false) == true)
    <div wire:poll>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="md:flex">
                    <div class="w-full p-4">
                        <ul>
                            @forelse($chattedWith ?? [] as $user)
                                <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                    <div class="flex ml-2">
                                        <div class="flex flex-col ml-2">
                                            <span class="font-medium text-black">{{ $user->name }}</span>
                                            <span class="text-sm text-gray-400 truncate w-32">
                                                {{ $user->message }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <span class="text-gray-300">{{ $user->last_message_at }}</span>

                                        <span class="{{ ($user->last_message_status == \App\Models\MessageStatus::SEEN) ? 'text-green-400' : 'text-gray-400' }} ">
                                            {{ $user->last_message_status }}
                                        </span>

                                    </div>
                                </li>
                                <hr>
                            @empty
                                <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                    <div class="flex ml-2">
                                        <div class="flex flex-col ml-2">
                                            <span class="font-medium text-black">NO CHAT FOUND YET</span>
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $chattedWith->links() }}
                </div>
            </div>
        </div>
    </div>

@if ((config('constants.chat.realtime') ?? false) == true)
    </div>
@endif
