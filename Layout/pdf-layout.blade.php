{{-- pdf service generic - v2 --}}

<html>
<meta name="robots" content="noindex,nofollow">
<meta charset="UTF-8">
{{--@vite([])--}}

<style>
    @page {
        margin: 0;
    }
    body {
        margin: 0;
        {{--margin-top: {{ $pdf_service->header_size + ($pdf_service->padding * 2) }}px;--}}
        {{--margin-bottom: {{ $pdf_service->footer_size }}px;--}}
        {{--margin-left: 0;--}}
        {{--margin-right: 0;--}}

        @if ($pdf_service->pdf_output == false)
            background-color: darkgray;
        @endif

        @if ($pdf_service->zoom ?? false)
            zoom: {{$pdf_service->zoom}}%;
        @endif

        /** Define now the real margins of every page in the PDF **/
        /* for pdf is this on the body otherwise dont work */
        @if ($pdf_service->pdf_output == true)
            margin: {{ $pdf_service->padding }}px;
            margin-top: {{ ($pdf_service->padding + $pdf_service->header_size + $pdf_service->padding_between_header_footer) }}px;
            margin-bottom: {{ ($pdf_service->padding + $pdf_service->footer_size + $pdf_service->padding_between_header_footer) }}px;
        @endif
    }



    header {
        height: {{ $pdf_service->header_size }}px;
        position: fixed;
        width: {{ $pdf_service->inner_width_px }}px;

        /* for html is this on the body othwise dont work */
        left: {{ $pdf_service->padding }}px;
        right: {{ $pdf_service->padding }}px;
        top: {{ $pdf_service->padding }}px;
        overflow: hidden;

        @if ($pdf_service->pdf_output === false)
            background-color: #F5F5F5;
        @endif
}

    footer {
        height: {{ $pdf_service->footer_size }}px;
        bottom: {{ $pdf_service->padding }}px;
        left: {{ $pdf_service->padding }}px;
        width: {{ $pdf_service->inner_width_px }}px;

        @if ($pdf_service->pdf_output === true)
            position: fixed;
        @else
            background-color: #F5F5F5;
            position: fixed;
        @endif
    }




    /* for mulitple pages */
    .page {
        page-break-after: always;
        background-color: white;

        @if ($pdf_service->pdf_output == true)
            {{-- for this the margin is already applied so use inner--}}
            width: {{ $pdf_service->inner_width_px }}px;
            height: {{ $pdf_service->inner_height_px }}px;
        @else
            {{-- here magin will be applied as left right top bottom px --}}
            width: {{ $pdf_service->a4_width_px }}px;
            height: {{ $pdf_service->a4_height_px }}px;
        @endif
    }
    .inner {
        position: relative;
        height: {{ $pdf_service->inner_height_without_headers_px }}px;
        width: {{ $pdf_service->inner_width_px }}px;

        /* for html is this on the body othwise dont work */
        @if ($pdf_service->pdf_output == true)
            overflow: hidden;
        @else
            left: {{ $pdf_service->padding }}px;
            right: {{ $pdf_service->padding }}px;
            top: {{ $pdf_service->padding + $pdf_service->header_size + $pdf_service->padding_between_header_footer }}px;
            bottom: {{ $pdf_service->padding }}px;
            overflow-y: auto;
            background-color: #F5F5F5;
       @endif
    }

    .page:last-child {
        page-break-after: unset;
    }

    /* font size */
    :root {
        font-size: 48px;
    }
    table {
        font-size: inherit;
    }

    .page-break-before {
        page-break-before: always;
    }
    .page-break-after {
        page-break-after: always;
    }
    .page-break-inside-auto {
        page-break-inside: auto;
    }

    .page-2 {
        /* this is needed for html to show page below */
        position: absolute;
        top: {{ $pdf_service->a4_height_px + 50 }}px;
    }

    .position-absolute {
        position: absolute;
    }
    .align-center {
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
    }
</style>
@yield('style')

<body>
    <header>
        <div class="header">
            @yield('header')
        </div>
    </header>
    <footer>
        <div class="footer">
            @yield('footer')
        </div>
    </footer>
    <div class="page">
        <div class="inner">
            @yield('content')
        </div>
    </div>

</body>
</html>
