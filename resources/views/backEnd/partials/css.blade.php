<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/css/jquery-ui.css') }}" />
{{-- metsimenu --}}
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/metisMenu.css') }}" />

<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/loade.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/app.css') }}" />
<link rel="stylesheet" href="{{asset('public/backEnd/assets/css/croppie.css')}}" />
 @if(userRtlLtl() ==1)
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/rtl/style.css')}}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/rtl/infix.css')}}" />
@else
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/backend_static_style.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/infix.css') }}" />
@endif

<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/vendors_static_style.css') }}" />
<link rel="stylesheet" href="{{asset('public/backEnd/assets/css/preloader.css')}}" />
<link rel="stylesheet" href="{{asset('public/backEnd/assets/css/solid_style.css')}}" />
<link rel="stylesheet" href="{{asset('public/backEnd/multiselect/css/jquery.multiselect.css')}}" />
<link rel="stylesheet" href="{{asset('public/backEnd/multiselect/css/custom_style.css')}}" />
<link rel="stylesheet" href="{{asset('public/backEnd/assets/css/radio_checkbox.css')}}" />

<link rel="stylesheet" href="{{asset('public/css/backend_design_v2.css')}}">
<style>
    *{
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    /* for toastr dynamic start*/
    .toast-success {
        background-color: #4BCF90!important;
    }

    .toast-message {
        color: #FFFFFF;
    }

    .toast-title {
        color: #FFFFFF;

    }

    .toast {
        color: #FFFFFF;
    }

    .toast-error {
        background-color: #FF6D68!important;
    }

    .toast-warning {
        background-color: #E09079!important;
    }
</style>
<style>

    :root {
    --background: #FAFAFA;
    --base_color: #415094;
    --sidebar_bg: #0d0e12;
    --gradient_1: #3091ff;
    --gradient_2: #3091ff;
--gradient_3: #3091ff;
    --text-color: #828bb2;
    --scroll_color: #828bb2;
    --text_white: #FFFFFF;
    --bg_white: #FFFFFF;
    --text_black: #000000;
    --bg_black: #000000;
    --border_color: #EFF2F8;
    --sidebar_active: #9c9c9c;
    --sidebar_hover: #808080;
    --primary-color: #3091ff;
    --card-gradient-cyan: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-violet: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-blue: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-fuchsia: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-cyan-hover: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-violet-hover: linear-gradient(to right, #1e92e0, #1e92e0);
    --card-gradient-blue-hover: linear-gradient(to right, #1e92e0, #60a5fa);
    --card-gradient-fuchsia-hover: linear-gradient(to right, #1e92e0, #1e92e0);
    
    --sidebar-section: #161616;
    --sidebar-nav-link: #000000;
    --transparent: transparent;

    --input_bg: #FFFFFF;
    --success: #4BCF90;
    --danger: #FF6D68;
    --warning: #E09079;
    --red: #d33333;
    --black: #000000;
    --link-hover: #161931;
    --notification_title: rgb(14, 23, 38);
    --notification_time: #3b3f5c99;
    --modalLink_color: #2f2f3be6;
    --profile_text_hover: #2d3253;
    --table_header: rgb(246, 248, 250);
    --box_shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.1) 0px 1px 2px -1px!important;
    }
</style>