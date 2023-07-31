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
                            <h1 class="page-header"> {{ $title }}  </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif
                @include('admin.flash_msg')

                <div class="row">
                    <div class="col-xs-12">

                        @if($ad->bids->count())
                            <table class="table table-striped">
                                <tr>
                                    <th>@lang('app.bidder')</th>
                                    <th>@lang('app.bid_amount')</th>
                                    <th>@lang('app.date_time')</th>
                                    <th>#</th>
                                </tr>
                                @foreach($ad->bids as $bid)
                                    <tr>
                                        <td><a href="{{route('bidder_info', $bid->id)}}">@lang('app.bidder') #{{$bid->user_id}}</a> </td>
                                        <td>{{themeqx_price($bid->bid_amount)}}
                                            @if($ad->current_bid()  == $bid->bid_amount)
                                                <span class="label label-success">@lang('app.highest_bid')</span>
                                            @endif
                                        </td>
                                        <td>{{$bid->posting_datetime() }}</td>
                                        <td>
                                            @if( ! $ad->is_bid_accepted())
                                                <a href="javascript:;" class="btn btn-success action" data-ad-id="{{$ad->id}}" data-bid-id="{{$bid->id}}" data-action="accept"><i class="fa fa-check-circle-o"></i> </a>
                                            @endif

                                            <a href="javascript:;" class="btn btn-danger action" data-ad-id="{{$ad->id}}" data-bid-id="{{$bid->id}}"  data-action="delete"><i class="fa fa-trash-o"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        @else
                            <p>@lang('app.there_is_no_bids')</p>
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
            $('.action').on('click', function () {
                var selector = $(this);
                var action = selector.data('action');

                if (action === 'delete'){
                    if (!confirm('{{ trans('app.are_you_sure') }}')) {
                        return;
                    }
                }
                var ad_id = selector.data('ad-id');
                var bid_id = selector.data('bid-id');
                $.ajax({
                    url: '{{ route('bid_action') }}',
                    type: "POST",
                    data: {ad_id: ad_id, bid_id:bid_id, action:action, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            if (action === 'delete') {
                                selector.closest('tr').remove();
                            }else if (action === 'accept'){
                                $('.btn-success.action').remove();
                            }
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
        });

    </script>


@endsection