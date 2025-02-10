<?php

// pdf service generic - v3

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerateService
{
    private $dpi = 300;
    private $a4_short_edge_px = 2480;
    private $a4_long_edge_px = 3507;
    private $orientation = 'portrait';
    private $pdf;
    private $view;
    private $attributes;

    public $pdf_output = null;
    public $header_size = 455;
    public $footer_size = 148;
    public $a4_height_px;
    public $a4_width_px;
    public $inner_height_px;
    public $inner_width_px;
    public $padding = 210;
    public $padding_between_header_footer = 52;
    public $zoom = 35;

    public function __construct($view, $attributes)
    {
        //
        $this->view = $view;
        $this->attributes = $attributes;

        $this->calculateSize();
    }

    public function calculateSize() {
        $this->a4_height_px = $this->orientation == 'portrait' ? $this->a4_long_edge_px : $this->a4_short_edge_px;
        $this->a4_width_px = $this->orientation == 'portrait' ? $this->a4_short_edge_px : $this->a4_long_edge_px;

        // $this->a4_height_px = $this->a4_height_px - $this->header_size - $this->footer_size;

        $this->inner_height_px = $this->a4_height_px - ($this->padding * 2);
        $this->inner_width_px = $this->a4_width_px - ($this->padding * 2);

        $this->inner_height_without_headers_px = $this->a4_height_px - ($this->padding * 2) - $this->footer_size - $this->header_size - ($this->padding_between_header_footer * 2);
        $this->inner_width_without_headers_px = $this->a4_width_px - ($this->padding * 2) - $this->footer_size - $this->header_size;
    }

    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
        $this->calculateSize();
    }

    public function generatePdf()
    {
        $this->pdf_output = true;

        $var_arr = [
            // 'a4_width_px' => $this->orientation == 'portrait' ? $this->a4_short_edge_px : $this->a4_long_edge_px,
            // 'a4_height_px' => $this->orientation == 'portrait' ? $this->a4_long_edge_px : $this->a4_short_edge_px,
            // 'padding' => $this->padding,
            // 'pdf_output' => $this->pdf_output,
            // only for use functions inside the class
            'pdf_service' => $this,
        ];

        // add our own attributes
        $var_arr = array_merge($var_arr, $this->attributes);

        $pdf = Pdf::loadView($this->view, $var_arr);

        // set settings
        $pdf->setOption(['dpi' => $this->dpi, 'defaultFont' => 'sans-serif']);
        $pdf->setPaper('A4', $this->orientation);

        // set global
        $this->pdf = $pdf;

        return $this;
    }

    public function getImagePath($file)
    {
        // $path = 'images_html/logo/'. $file;

        // for pdf gen use the full path
        $prefix_path = $this->pdf_output ? public_path() .'/' : '';

        return $prefix_path . $file;
    }

    public function outputToBrowser()
    {
        return $this->pdf->stream();
    }

    public function outputToString()
    {
        return $this->pdf->output();
    }

    public function download($filename)
    {
        return $this->pdf->download($filename);
    }

    public function returnHtml()
    {
        // guard zoom redirect
        $this->zoom = request()->get('zoom') ?? '35';

        $this->pdf_output = false;

        $var_arr = [
            // 'a4_width_px' => $this->orientation == 'portrait' ? $this->a4_short_edge_px : $this->a4_long_edge_px,
            // 'a4_height_px' => $this->orientation == 'portrait' ? $this->a4_long_edge_px : $this->a4_short_edge_px,
            // 'padding' => $this->padding,
            // 'pdf_output' => $this->pdf_output,
            // 'zoom' => $zoom,
            // only for use functions inside the class
            'pdf_service' => $this,
        ];

        $var_arr = array_merge($var_arr, $this->attributes);

        return view($this->view, $var_arr);
    }
}
