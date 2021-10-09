@include('website.layouts.header')

<div class="container">
    <div class="row">
        <!-- Boxes de Acoes -->
        <div class="col-md-12">
            <h2 class="section-heading first-word text-center"><span class="style-1">Contact</span> Us</h2>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <div class="info">
                        <h3 class="title">@lang('english.MAIL_AND_WEBSITE')</h3>
                        <p>
                            <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp {{$targetInfo->email??''}}
                            <br>
                            <br>
                            <i class="fa fa-globe" aria-hidden="true"></i> &nbsp
                            {{$targetInfo->website??''}}
                        </p>

                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                    <div class="info">
                        <h3 class="title">@lang('english.CONTACT')</h3>
                        <p>
                            <i class="fa fa-mobile" aria-hidden="true"></i> &nbsp {{$targetInfo->phone??''}}

                        </p>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                    <div class="info">
                        <h3 class="title">@lang('english.ADDRESS')</h3>
                        <p>
                            <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp {{$targetInfo->address??''}}
                        </p>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>
        <!-- /Boxes de Acoes -->

        <!--My Portfolio  dont Copy this -->

    </div>
</div>

<div class="csti-map">
    <iframe src="@lang('english.GMAP_URL')" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>




<style>

    /* Conatct start */

    .header-title
    {
        text-align: center;
        color:#00bfff;
    }

    #tip
    {
        display:none;
    }

    .fadeIn
    {
        animation-duration: 3s;
    }

    .form-control
    {
        border-radius:0px;
        border:1px solid #EDEDED;
    }

    .form-control:focus
    {
        border:1px solid #00bfff;
    }

    .textarea-contact
    {
        resize:none;
    }

    .btn-send
    {
        border-radius: 0px;
        border:1px solid #00bfff;
        background:#00bfff;
        color:#fff;
    }

    .btn-send:hover
    {
        border:1px solid #00bfff;
        background:#fff;
        color:#00bfff;
        transition:background 0.5s;
    }

    .second-portion
    {
        margin-top:50px;
    }

    @import "//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css";
    @import "http://fonts.googleapis.com/css?family=Roboto:400,500";

    .box > .icon { text-align: center; position: relative; }
    .box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50% !important; background: #00bfff; vertical-align: middle; }
    .box > .icon:hover > .image { background: #333; }
    .box > .icon > .image > i { font-size: 36px !important; color: #fff !important; margin-top:26px; }
    .box > .icon:hover > .image > i { color: white !important; }
    .box > .icon > .info { margin-top: -24px; background: rgba(0, 0, 0, 0.04); border: 1px solid #e0e0e0; padding: 30px 0 10px 0; min-height:163px;}
    .box > .icon:hover > .info { background: rgba(0, 0, 0, 0.04); border-color: #e0e0e0; color: white; }
    .box > .icon > .info > h3.title { font-family: "Robot",sans-serif !important; font-size: 16px; color: #222; font-weight: 700; text-transform: uppercase;}
    .box > .icon > .info > p { font-family: "Robot",sans-serif !important; font-size: 13px; color: #666; line-height: 1.5em; margin: 20px;}
    .box > .icon:hover > .info > h3.title, .box > .icon:hover > .info > p, .box > .icon:hover > .info > .more > a { color: #222; }
    .box > .icon > .info > .more a { font-family: "Robot",sans-serif !important; font-size: 12px; color: #222; line-height: 12px; text-transform: uppercase; text-decoration: none; }
    .box > .icon:hover > .info > .more > a { color: #fff; padding: 6px 8px; background-color: #63B76C; }
    .box .space { height: 30px; }

    .image-icon{
        font-size: 36px;
    }
    @media only screen and (max-width: 768px)
    {
        .contact-form
        {
            margin-top:25px;
        }

        .btn-send
        {
            width: 100%;
            padding:10px;
        }

        .second-portion
        {
            margin-top:25px;
        }
    }
    /* Conatct end */
</style>

@include('website.layouts.footer')
