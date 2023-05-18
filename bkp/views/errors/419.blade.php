@extends('layouts.backend')

@section('content')
    <div class="admin_page_container">

        <div class="editor_form_wrapper" >

            <h3 class="error_text flex items-center justify-center flex-nowrap p-3">
                Your session is expired !
            </h3>

            <div class="flex items-center justify-center m-5">
                <a class="cursor-pointer" href="{{ url('login') }}">Login</a>
            </div>


        </div> <!-- editor_form_wrapper -->

    </div> <!-- admin_page_container -->

@endsection

