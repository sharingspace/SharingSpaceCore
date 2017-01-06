
       <div class="row messageRow message_{{$messageId or 0}} {{$rowClass or null}}">  
          <div class="col-xs-1">
            <a class="member_thumb pull-left" href="{{ route('user.profile', $senderId or null) }}">
              <img class="hidden-xs margin-right-10" src="{{ $avatar or '' }}">
            </a>
          </div>
          <div class="col-xs-8">
            <div class="row">
              <div class="col-xs-12 padding-top-5">
                <strong class="sent_by">{{ $displayName or null }}</strong>
                  <span class="shareName"> / {{ $community or null }}</span>
              </div>
              <div class="col-xs-12 messageText">
                @if (isset($messageText) && strlen($messageText) > 100)
                  <a data-toggle="collapse" data-target="#expand_{{$message->id or null}}">
                  @if (empty($readOn or null))
                    <i class="fa fa-eye-slash fa-lg pull-left text-green margin-top-5"></i>
                  @endif
                @endif
                  {!! Str::limit($messageText, 100) !!}
                @if (isset($messageText) && strlen($messageText) > 100)
                  </a>
                @endif
                <div id="expand_{{$message->id or null}}" class="collapse">
                  {!! $messageText !!}
                </div>
              </div>
            </div>
          </div>

          <div class="col-xs-2">
            <span class="hidden-sm hidden-xs">{{ date('M j, Y g:ia', strtotime($createdAt)) }}</span>
            <span class="visible-sm visible-xs">{{ date('M j, Y', strtotime($createdAt)) }}</span>
          </div>

          <div class="col-xs-1">
            <button class="btn btn-danger btn-sm button_delete" id="messageid_{{$message->id or 0}}">
              <i class="fa fa-trash"></i>
            </button>       
          </div>
        </div>