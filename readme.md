<p align="center">
  <img width="450px" src="https://getparthenon.com/images/logo.svg">
</p>

<p align="center">
  <h1 style="text-align: center">Export Bundle</h1>
</p>

## Description

A utlity Symfony bundle to help with export data from Symfony applications.

It allows exports by default in the formats `csv` and `xlsx`. With the ability to add support for more formats via custom Exporters.

This bundle allows you to export data via 3 methods:

### Direct Download 

This is where the export is generated within the HTTP request and a download file is provided.

### Background Download

This is where the export is generated within the background via Symfony Messenger and once the download is generated it's saved to a storage area and then the user can download it.

### Background Email

This is where the export is generated within the background via Symfony Messenger. Once the export is generated it's emailed to the requesting user.

