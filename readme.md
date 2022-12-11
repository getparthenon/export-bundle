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

## Support

Support is provided via GitHub, Slack, and Email.

If you have a commercial license you will be able to list the GitHub accounts that you want to link to the license. This
means when an issue is created by an account linked to a commercial license they will get priority support. All other
issues will be given best effort support.

* Github: You can make an issue on [getparthenon/monorepo](https://github.com/getparthenon/monorepo/issues/new/choose)
* Email: support@getparthenon.com
* Slack: [Click here](https://join.slack.com/t/parthenonsupport/shared_invite/zt-1kmmuvul0-Ai1Sp6j3SzlF955Z~CD~~Q) to signup

Issues we will provide support and fixes for:

* Defects/Bugs
* Performance issues
* Documentation fixes/improvements
* Lack of flexibility
* Feature requests

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

## FAQ

### Is this Open Source?

Yes. This bundle has been released under the GPL V3 License.

### Why is this Open Source while Parthenon is source available?

This has been released under an open source license for two reasons. One is that data exports is a source of technical debt for many tech teams and I wanted this to be useful to as many people as possible as I feel it really helps solve the issue for many teams.

The other reason is to see the usage and bug reports, etc from an open source version.

### If this is released under GPL and Parthenon contains this code, shouldn't Parthenon legally be GPL?

No. As the copyright holder the GPL license doesn't apply to me and I'm legally entitled to distribute it how I want, relicense it, etc. GPL only affects people who fork this bundle.

### What support is available for this bundle?

This bundle comes with community level support, which is best efforts. You can get a professional support by paying for a Parthenon license. Which is $250 per developer per year.

