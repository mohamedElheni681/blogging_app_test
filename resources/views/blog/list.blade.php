
    @foreach ($posts as $post)
        <div class="sm:grid w-4/5 mx-auto border-b border-gray-200 card p-4">
            <div>
                <img src="{{ asset('images/' . $post->image_path) }}" alt="">
            </div>
            <div>
                <h2 class="text-gray-700 font-bold text-5xl pb-4">{{ $post->title }}</h2>

                <span class="text-gray-500">By <span class="font-bold italic text-gray-800">{{ $post->user->name }}</span>,&nbsp; {{__('post.created_on')}}&nbsp;{{ date('F j, Y, g:i a', strtotime($post->created_at)) }}</span>

                <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light"><?php echo $post->description ?></p>

                @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)

                    <div class="d-flex", style="justify-content: flex-end;">
                        @can('update-post')
                        <a href="/blog/{{ $post->id }}/edit" class="border-0 bg-white mr-3">
                            <svg style="background-color: #f4f5f7;" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.8787 2.87868L7.29289 11.4645C7.10536 11.652 7 11.9064 7 12.1716V16.1716C7 16.7239 7.44772 17.1716 8 17.1716H12C12.2652 17.1716 12.5196 17.0662 12.7071 16.8787L21.2929 8.29289C22.4645 7.12132 22.4645 5.22183 21.2929 4.05025L20.1213 2.87868C18.9497 1.70711 17.0503 1.70711 15.8787 2.87868ZM19.8787 5.46447L19.9619 5.55867C20.2669 5.95096 20.2392 6.5182 19.8787 6.87868L11.584 15.1716H9V12.5856L17.2929 4.29289C17.6834 3.90237 18.3166 3.90237 18.7071 4.29289L19.8787 5.46447ZM11.0308 4.17157C11.0308 3.61929 10.5831 3.17157 10.0308 3.17157H6L5.78311 3.17619C3.12231 3.28975 1 5.48282 1 8.17157V18.1716L1.00462 18.3885C1.11818 21.0493 3.31125 23.1716 6 23.1716H16L16.2169 23.167C18.8777 23.0534 21 20.8603 21 18.1716V13.2533L20.9933 13.1366C20.9355 12.6393 20.5128 12.2533 20 12.2533C19.4477 12.2533 19 12.701 19 13.2533V18.1716L18.9949 18.3478C18.9037 19.9227 17.5977 21.1716 16 21.1716H6L5.82373 21.1665C4.24892 21.0752 3 19.7693 3 18.1716V8.17157L3.00509 7.9953C3.09634 6.42049 4.40232 5.17157 6 5.17157H10.0308L10.1474 5.16485C10.6448 5.10708 11.0308 4.68441 11.0308 4.17157Z" fill="#0071D1"/>
                            </svg>
                        </a>
                        @endif

                            @can('delete-post')
                                <form action="/blog/{{ $post->id }}" method="POST"  id="{{ $post->id }}">
                                    @csrf
                                    @method('delete')
                                </form>

                                <button  onclick="return deletePost({{ $post->id }});"  class="border-0 bg-white">
                                    <svg  style="background-color: #f4f5f7;" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14 1C15.5977 1 16.9037 2.24892 16.9949 3.82373L17 4V5H19H21C21.5523 5 22 5.44772 22 6C22 6.51284 21.614 6.93551 21.1166 6.99327L21 7H20V20C20 21.5977 18.7511 22.9037 17.1763 22.9949L17 23H7C5.40232 23 4.09634 21.7511 4.00509 20.1763L4 20V7H3C2.44772 7 2 6.55228 2 6C2 5.48716 2.38604 5.06449 2.88338 5.00673L3 5H5H7V4C7 2.40232 8.24892 1.09634 9.82373 1.00509L10 1H14ZM6 7V20C6 20.5128 6.38604 20.9355 6.88338 20.9933L7 21H17C17.5128 21 17.9355 20.614 17.9933 20.1166L18 20V7H16H8H6ZM15 5H9V4L9.00673 3.88338C9.06449 3.38604 9.48716 3 10 3H14L14.1166 3.00673C14.614 3.06449 15 3.48716 15 4V5ZM10 10C10.5128 10 10.9355 10.386 10.9933 10.8834L11 11V17C11 17.5523 10.5523 18 10 18C9.48716 18 9.06449 17.614 9.00673 17.1166L9 17V11C9 10.4477 9.44772 10 10 10ZM14.9933 10.8834C14.9355 10.386 14.5128 10 14 10C13.4477 10 13 10.4477 13 11V17L13.0067 17.1166C13.0645 17.614 13.4872 18 14 18C14.5523 18 15 17.5523 15 17V11L14.9933 10.8834Z" fill="#0071D1"/>
                                    </svg>
                                </button>
                                @endif
                    </div>
                @endif
            </div>
        </div>

    @endforeach



