@extends('adminside.layouts.common')
@section('title', 'Edit Education')
@section('headerscripts')
    <link rel="stylesheet" href="{{admin_assets}}/css/jquery.fancybox.min.css"/>

@stop
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Edit Education</h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{!!route('educations.index')!!}" class="text-muted">Education</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:;" class="text-muted">Edit Education</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">


                        <p>Lorem <strong>ipsum dolor sit</strong> amet, consectetur adipiscing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis <strong>nostrud exercitation</strong> ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.
                        </p>
                        <p>Lorem ipsum dolor sit amet, <strong>consectetur adipiscing elit</strong>, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. <i>Excepteur sint  occaecat</i> cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.
                        </p>
                        <ul>
                            <li>Lorem 1st point </li>
                            <li>Lorem 2nd point </li>
                            <li>Lorem 3rd point </li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, <strong>consectetur adipiscing elit</strong>, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. <i>Excepteur sint  occaecat</i> cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.
                        </p>

                        <div class="card card-custom gutter-b">

                            <div style="padding :0 7px 0 5px;max-width:900px;margin:auto">

                                <textarea id="hero-demo" class="tag-editor-hidden-src"></textarea>
                                <ul class="tag-editor ui-sortable" style="display:none;">
                                    <li style="width:1px">&nbsp;</li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">example tags</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">sortable</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li style="display: block;">
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">autocomplete</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">edit in place</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">tab/cursor navigation</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">duplicate check</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">callbacks</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">copy-paste</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">placeholder</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">public methods</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">custom delimiter</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="tag-editor-spacer">&nbsp;,</div>
                                        <div class="tag-editor-tag">graceful degradation</div>
                                        <div class="tag-editor-delete"><i></i>

                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@stop

@section('footerscripts')

    <script src="{{admin_assets}}/js/jquery.fancybox.min.js"></script>
    <script src="{!!admin_assets!!}/js/pages/crud/forms/widgets/select2.js"></script>
    <script src="{!!admin_assets!!}/js/pages/crud/forms/editors/summernote.js"></script>

    <script src="{!!admin_assets!!}/js/pages/crud/forms/editors/AutoNumeric/AutoNumeric.js"></script>

    <script src="{{admin_assets}}/js/jquery.caret.min.js"></script>


    <script src="{{admin_assets}}/js/jquery-ui.min.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\EducationRequest', "#form_education_edit") !!}

    <script>
        function educationSubmit(mode) {
            $("#desc").val($('#summernote_desc').val());
            $("#short_desc").val($('#summernote_short_desc').val());
            $("#mode").val(mode)
            var theForm = $("#form_education_edit");
            theForm.submit();
        }

        function onChangecb(field, editor, tags) {
            console.log('onChangecb field::')
            console.log(field)

            // debugger;
        }

        function beforeTagSavecb(field, editor, tags, tag, val) {
            console.log('beforeTagSavecb field::')
            console.log(field)
            // debugger;
        }

        function beforeTagDeletecb(field, editor, tags, val) {
            console.log('beforeTagDeletecb field::')
            console.log(field)
            // debugger;
            return true;
        }


        $(document).ready(function () {

            $('#hero-demo').tagEditor({
                delimiter: ',',
                initialTags: ['Hello', 'World', 'Example', 'Tags'],
                placeholder: 'Enter tags ...',
                autocomplete: {
                    delay: 0,
                    position: {
                        collision: 'flip'
                    },
                    source: ['ActionScript', 'AppleScript', 'Asp', 'BASIC', 'C', 'C++', 'CSS', 'Clojure', 'COBOL', 'ColdFusion', 'Erlang', 'Fortran', 'Groovy', 'Haskell', 'HTML', 'Java', 'JavaScript', 'Lisp', 'Perl', 'PHP', 'Python', 'Ruby', 'Scala', 'Scheme']
                },
                clickDelete: false,
                beforeTagSave: beforeTagSavecb,
                beforeTagDelete: beforeTagDeletecb,
                onChange: onChangecb
            });


        });


    </script>
@stop
