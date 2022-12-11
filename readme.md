<p align="center">
  <img width="450px" src="https://getparthenon.com/images/logo.svg">
</p>

<p align="center">
  <h1 style="text-align: center">Export Bundle</h1>
</p>

## Description

A utlity Symfony bundle to help with export data from Symfony applications.

It allows exports by default in the formats `csv` and `xlsx`. With the ability to add support for more formats via custom Exporters.

This bundle allows you to export data via 3 methods: Direct Download, Background Download, Background Email. More info [here](#export-engines)

## Getting Started

To add to your project

`composer require parthenon/export-bundle`

## Example Usage

```php
namespace App\Controller;

use Parthenon\Athena\Export\DefaultDataProvider;
use Parthenon\Export\Engine\EngineInterface;
use Parthenon\Export\Exporter\ExporterManagerInterface;
use Parthenon\Export\Exporter\ExporterManagerInterface;
use Parthenon\Export\Response\ResponseConverterInterface;

class ExportController
{
    public function export(Request $request, EngineInterface $engine, ResponseConverterInterface $responseConverter)
    {
        $exportName = $request->get("name");
        $exportFormat = $request->get("format");

        $exportRequest = new ExportRequest($exportName, $exportFormat, DefaultDataProvider::class, $parameters);

        $response = $engine->process($exportRequest);

        return $responseConverter->convert($response);
    }
}
```

## Documentation

You can find the full documentation in [Parthenon Docs for Export](https://getparthenon.com/docs/next/export/overview)

## Export Engines

### Direct Download 

This is where the export is generated within the HTTP request and a download file is provided.

### Background Download

This is where the export is generated within the background via Symfony Messenger and once the download is generated it's saved to a storage area and then the user can download it.

#### Configuration

The file uploading part of the background download engine is handled by the common module of Parthenon. The full documentation can be found [here](https://getparthenon.com/docs/next/common/upload/).

If you want to save the file to a local folder the configuration below can help.

```yaml
parthenon:
  common:
    uploader:
      default:
        provider: local
        naming_strategy: time_random
        local:  
          path: "%kernel.project_dir%/public/uploads"
```
### Background Email

This is where the export is generated within the background via Symfony Messenger. Once the export is generated it's emailed to the requesting user.

The email sending part of this engine is handled by the Notification module of Parthenon. The full documentation can be found at [here](https://getparthenon.com/docs/next/notification/email)

If you're already using Symfony Mailer and just want that to be used then the configuration below is what is needed.

```yaml
parthenon:
  notification:
    type: symfony
```
