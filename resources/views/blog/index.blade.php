@extends('layouts.app')

@section('content')
<div class="w-4/5 m-auto text-center">
    <div class="py-15 border-b border-gray-200">

       <div style="display: flex; justify-content: space-between">
           <div><h1 class="text-6xl">
                   {{$title}}
               </h1></div>

           @if (Auth::check())
               <div style="margin-top: 25px;">
                   <a href="/blog/create" class="bg-blue-500 uppercase text-gray-100 text-xs font-extrabold py-3 px-5 rounded-3xl" style="background-color: #8c3f06;">
                       Create post
                   </a>
               </div>
           @endif
       </div>
        
        <div class="mb-2" style="text-align: center;height: 17px;">
            <span class="dropdown-el">
                <input type="radio" name="sortType" value="Descendante" id="desc"><label for="desc"> {{__('post.descendante')}}</label>
                <input type="radio" name="sortType" value="Ascending" id="asc"><label for="asc">{{__('post.ascending')}}</label>
            </span>
        </div>


    </div>

</div>

@if (session()->has('message'))
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
            {{ session()->get('message') }}
        </p>
    </div>
@endif



<div id="post_list">
    <div class="check-list scrolling-pagination">
        @include('blog.list')
    <div style="display: flex;justify-content: center;">
        {{ $posts->appends(request()->query())->links() }}
    </div>

</div>

</div>


@endsection
@section('js')
    <script type="">

        $(document).ready(function() {

            initialiseJscroll();

            let oldSort = null;
            let oldSavedSort = localStorage.getItem('sort')
            if(oldSavedSort){
                oldSort = oldSavedSort;
                $(`#${oldSort}`).prop("checked", true);
            }else{
                $("#desc").prop("checked", true);
                oldSort = 'desc'
            }

            $('.dropdown-el').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).toggleClass('expanded');
                $('#'+$(e.target).attr('for')).prop('checked',true);

                let sort =   $(e.target).attr('for')


                if(oldSort != sort){
                    oldSort = sort
                    localStorage.setItem('sort',sort)
                    window.location.href =  window.location.pathname + '?' + 'sort=' + sort;
                }

            });

            $(document).click(function() {
                $('.dropdown-el').removeClass('expanded');
            });


        });


    </script>
@endsection