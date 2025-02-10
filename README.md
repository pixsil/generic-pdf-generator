
# Generic PDF generator for Laravel

## What is it?

Generate easy pixel perfect PDF's

## Donate

Find this project useful? You can support me with a Paypal donation:

[Make Paypal Donation](https://www.paypal.com/donate/?hosted_button_id=2XCS6R3CTC5BA)

## Installation

For a quick install, run this from your project root:
```bash

```

## Usage

This is a good way to start. This gives also the optertunity to show the PDF in the browser or html:

```php
$pdf_generate_service = new PdfGenerateService('pdf.invoice-pdf', compact('pdfOutput', '', '', ''));

$default_output = 'browser';
$output = $_GET['output'] ?? $default_output;

if (in_array($output, ['download'])) {

} elseif (in_array($output, ['html'])) {

    $rendered_output = $pdf_generate_service->returnHtml();

} elseif (in_array($output, ['browser', 'stream', 'online'])) {

    $rendered_output =  $pdf_generate_service->generatePdf()->outputToBrowser();;
}

return $rendered_output;
```

## Additional knowledge

## Example

Check the example folder for a Vue component example
```
