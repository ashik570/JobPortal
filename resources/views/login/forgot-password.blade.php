@extends('layouts.front')
@section('content')

{{ Form::open(array('url' => 'forgot-password', 'class' => 'validate-form form-horizontal', 'autocomplete'=>'off')) }}


<div class="row">
    <div class="col-md-12 text-center">
        <h3>{{trans('bangla.FORGOT_PASSWORD')}}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2 custom-box">

        <div class="row">
            <div class="col-md-12 text-center forogt-instruction">
                 {{trans('bangla.FORGOT_PASSWORD_INSTRUCTION')}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                 @if(Session::has('error'))
                <div class="text-danger confirmation-error">{{ Session::get('error') }}</div>
                <?php Session::forget('error'); ?>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">                                    
                <input type="{{$inputType}}" name="forgot_text" class="form-control custom-input"  id="forgot_input" value="" required="forgot_text" placeholder="{{ $placeHolder }}" />
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center forgot-input">
                <input type="radio" name="forgot_input"  id="forgot_input_mobile" value="mobile" {{ $mobileChecked }} /> <label for="forgot_input_mobile">{{trans('bangla.MOBILE')}}</label>
                <input type="radio" name="forgot_input"  id="forgot_input_email" value="email" {{ $emailChecked }}  /> <label for="forgot_input_email">{{trans('bangla.EMAIL')}}</label>
            </div>
        </div>

        <div class="row custom-input-div">
            <div class="col-md-12 text-center">
                <button type="submit" id="reg-next" class="btn btn-custom2">{{trans('bangla.NEXT')}}</button>
            </div>
        </div>

    </div>
</div>


{{Form::close()}}

 <script type="text/javascript">
     
     $( "#forgot_input_mobile" ).click(function() {
         $( "#forgot_input" ).val( '' );
         //$( "#forgot_input" ).addClass( "integer-only" )
         $( "#forgot_input" ).attr( "placeholder", "8801XXXXXXXXX" );
          $( "#forgot_input" ).attr( "type", "number" );
});

 $( "#forgot_input_email" ).click(function() {
        $( "#forgot_input" ).val( '' );
        //$( "#forgot_input" ).removeClass( "integer-only" )
         $( "#forgot_input" ).attr( "placeholder", "youremail@example.com" );
         $( "#forgot_input" ).attr( "type", "email" );
});
     
        

    </script>


@stop