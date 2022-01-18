@extends('layouts.app')

@section('content')
<div class="w-4/5 m-auto pt-20">

    <div class="card">
        <div class="card-body">
            <h3 class="card-title w-100">{{__('post.update_post')}}</h3>
            <div class="card-text p-3">
                <form action="/blog/{{ $post->id }}" method="POST" class="form" id="post_form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="required mb-2">{{__('post.title')}}</label>
                        <input type="text" name="title" id="title" value="{{ $post->title }}" placeholder="{{__('post.add_post_title')}}" class="form-control">
                        @include('alerts.feedback', ['field' => 'title'])

                    </div>
                    <div class="mb-3">
                        <label class="required mb-2">{{__('post.description')}}</label>
                        <div name="post_text" id="post_text"></div>
                        <input type="hidden" id="description" name="description" class="form-control" value="{{ old('description', '') }}">
                        @include('alerts.feedback', ['field' => 'description'])
                    </div>
                </form>
                <div id="buttons">
                    <button type="btn" id="store_post" form="post_form" class="btn btn_btn mr-3">
                        <div style="display:flex">
                            <span>{{__('post.save')}}</span>
                            <span class="ms-2">
                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.948 6.111L8.087 9.981L6.602 8.496C6.52132 8.40178 6.42203 8.32526 6.31038 8.27124C6.19872 8.21722 6.0771 8.18687 5.95315 8.18208C5.8292 8.17729 5.7056 8.19818 5.59011 8.24342C5.47462 8.28867 5.36973 8.3573 5.28202 8.44501C5.19431 8.53272 5.12568 8.63761 5.08043 8.75311C5.03518 8.8686 5.0143 8.9922 5.01908 9.11615C5.02387 9.24009 5.05423 9.36171 5.10825 9.47337C5.16227 9.58503 5.23879 9.68431 5.333 9.765L7.448 11.889C7.5321 11.9724 7.63183 12.0384 7.74149 12.0832C7.85114 12.128 7.96856 12.1507 8.087 12.15C8.32311 12.149 8.54937 12.0553 8.717 11.889L13.217 7.389C13.3014 7.30533 13.3683 7.20579 13.414 7.09612C13.4597 6.98644 13.4832 6.86881 13.4832 6.75C13.4832 6.63119 13.4597 6.51355 13.414 6.40388C13.3683 6.29421 13.3014 6.19466 13.217 6.111C13.0484 5.94337 12.8203 5.84929 12.5825 5.84929C12.3447 5.84929 12.1166 5.94337 11.948 6.111ZM9.5 0C7.71997 0 5.97991 0.527841 4.49987 1.51677C3.01983 2.50571 1.86628 3.91131 1.18509 5.55585C0.5039 7.20038 0.32567 9.00998 0.672937 10.7558C1.0202 12.5016 1.87737 14.1053 3.13604 15.364C4.39472 16.6226 5.99836 17.4798 7.74419 17.8271C9.49002 18.1743 11.2996 17.9961 12.9442 17.3149C14.5887 16.6337 15.9943 15.4802 16.9832 14.0001C17.9722 12.5201 18.5 10.78 18.5 9C18.5 7.8181 18.2672 6.64778 17.8149 5.55585C17.3626 4.46392 16.6997 3.47177 15.864 2.63604C15.0282 1.80031 14.0361 1.13738 12.9442 0.685084C11.8522 0.232792 10.6819 0 9.5 0ZM9.5 16.2C8.07598 16.2 6.68393 15.7777 5.4999 14.9866C4.31586 14.1954 3.39302 13.0709 2.84807 11.7553C2.30312 10.4397 2.16054 8.99201 2.43835 7.59535C2.71616 6.19868 3.4019 4.91577 4.40883 3.90883C5.41577 2.90189 6.69869 2.21616 8.09535 1.93835C9.49202 1.66053 10.9397 1.80312 12.2553 2.34807C13.571 2.89302 14.6954 3.81586 15.4866 4.99989C16.2777 6.18393 16.7 7.57597 16.7 9C16.7 10.9096 15.9414 12.7409 14.5912 14.0912C13.2409 15.4414 11.4096 16.2 9.5 16.2Z" fill="white"/>
                                </svg>
                            </span>
                        </div>
                    </button>

                    <a href="/blog" id="cancel" class="btn btn_btn cancel_btn" style="background-color: #c2c7d0; max-height: 47px;">
                        <div style="display:flex">
                            <span>  {{__('post.cancel')}}</span>
                            <span class="ms-2 pt-1">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5539 1.20357C12.2109 0.878948 11.6742 0.878365 11.3306 1.20224L6.87507 5.40087L2.41957 1.20224C2.07588 0.878365 1.53919 0.878948 1.19621 1.20357C0.824339 1.55553 0.824984 2.14778 1.19762 2.49894L5.57608 6.62497L1.19763 10.751C0.824991 11.1022 0.824346 11.6944 1.19622 12.0464C1.5392 12.371 2.07589 12.3716 2.41958 12.0477L6.87507 7.84907L11.3306 12.0477C11.6742 12.3716 12.2109 12.371 12.5539 12.0464C12.9258 11.6944 12.9251 11.1022 12.5525 10.751L8.17406 6.62497L12.5525 2.49894C12.9251 2.14778 12.9258 1.55553 12.5539 1.20357Z" fill="#626E7E"/>
                                    </svg>
                                </span>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script type="">
        function setEditorDescription(quill) {
            const descriptionBodyText = `{!! $post->description !!}`;
            quill.setHTML(descriptionBodyText)
        }

        $(document).ready(function() {

            let quill = initialiseEditor();
            setEditorDescription(quill);

            quill.on('text-change', function() {
                const descriptionBody =  $("#post_text > div.ql-editor").html();
                if(!isEditorEmpty(descriptionBody)){
                    $('#description').val(descriptionBody);
                }
            });

        });

    </script>
@endsection