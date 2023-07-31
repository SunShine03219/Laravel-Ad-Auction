@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="container">
        <div id="wrapper">
            @include('admin.sidebar_menu')
            <div id="page-wrapper">

                @if( ! empty($title))
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> {{ $title }}</h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif

                @include('admin.flash_msg')

                    <div class="row">
                        <div class="col-xs-12">
                            @if($comments->count())

                                <table class="table table-bordered table-striped"  style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.author_name')</th>
                                        <th>@lang('app.comment')</th>
                                        <th>@lang('app.created_at')</th>
                                        <th>@lang('app.actions')</th>
                                    </tr>
                                    </thead>

                                    @foreach($comments as $comment)

                                        <tr>
                                            <td>
                                                <?php

                                                $html = "<p><i class='fa fa-user'></i> {$comment->author_name} </p>";
                                                $html .= "<p><i class='fa fa-envelope-o'></i> {$comment->author_email} </p>";
                                                $html .= "<p><i class='fa fa-map-marker'></i> {$comment->author_ip} </p>";

                                                $label = '<p>';
                                                if ($comment->approved == 1){
                                                    $label .= '<span class="label label-success"><i class="fa fa-check-circle-o"></i> </span>';
                                                }else{
                                                    $label .= '<span class="label label-default"><i class="fa fa-exclamation-circle"></i> </span>';
                                                }

                                                if ($comment->comment_id){
                                                    $label .= '<span class="label label-default"><i class="fa fa-reply"></i> </span>';
                                                }else{
                                                    $label .= '<span class="label label-info"><i class="fa fa-comment-o"></i> </span>';
                                                }

                                                $label .= '</p>';

                                                $html .= $label;

                                                echo $html;
                                                ?>

                                            </td>
                                            <td>
                                                <?php

                                                $html = '';
                                                if ($comment->campaign) {
                                                    $html .= '<blockquote><i><a href="'.route('campaign_single', $comment->campaign->slug).'#comment-'.$comment->id.'" target="_blank">';
                                                    if ($comment->comment_id) {
                                                        $html .= '<i class="fa fa-reply"></i> ';
                                                    } else {
                                                        $html .= '<i class="fa fa-comment-o"></i> ';
                                                    }
                                                    $html .= safe_output($comment->campaign->title);

                                                    $html .= '</a></i></blockquote>';
                                                }
                                                $html .= safe_output($comment->comment);

                                                echo $html;

                                                ?>

                                            </td>
                                            <td>{!! $comment->created_at_datetime() !!}</td>
                                            <td>
                                                <?php
                                                $button = '';

                                                if ($comment->approved != 1){
                                                    $button .= '<a href="javascript:;" class="btn btn-success comment_action" data-action="approve" data-id="'.$comment->id.'"><i class="fa fa-check-circle-o"></i> </a>';
                                                }
                                                $button .= '<a href="javascript:;" class="btn btn-danger comment_action" data-action="trash" data-id="'.$comment->id.'"><i class="fa fa-trash-o"></i> </a>';

                                                echo $button;
                                                ?>
                                            </td>
                                        </tr>


                                    @endforeach


                                </table>

                                {!! $comments->links() !!}

                            @else

                                <div class="alert alert-info">
                                    No data available to show.
                                </div>

                            @endif

                        </div>
                    </div>


            </div>   <!-- /#page-wrapper -->




        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('body').on('click', '.comment_action', function (e) {
                e.preventDefault();

                var $that = $(this);
                if ($that.attr('data-action') === 'trash'){
                    if (!confirm("<?php echo trans('app.are_you_sure') ?>")) {
                        return false;
                    }
                }

                var action = $that.data('action');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('comment_action') }}',
                    data: {comment_id: $that.data('id'), action: action, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {

                            if (action == 'approve'){
                                $that.remove();
                            }else {
                                $that.closest('tr').remove();
                            }


                            var options = {closeButton: true};
                            toastr.success(data.msg, '<?php echo trans('app.success') ?>', options)
                        }
                    }
                });
            });
        });
    </script>

    <script>
        var options = {closeButton : true};
        @if(session('success'))
            toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', options);
        @endif
    </script>
@endsection


