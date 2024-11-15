<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template"
  data-style="light">

<head>
  @include('auth.layouts.meta')

  <title>@yield('title') | {{ config('env.APP_NAME') }}</title>

  @include('auth.layouts.styles')

  @include('auth.layouts.global-js')

</head>

<body>
  @yield('content')

  @include('auth.layouts.scripts')

  {{-- Dynamically Include Page-Specific JS --}}
  @if (isset($pageJs) && is_array($pageJs))
    @foreach ($pageJs as $jsFile)
        {{-- Dynamically load JS files via @vite --}}
        @vite($jsFile)
    @endforeach
@endif

</body>

</html>