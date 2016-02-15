# SilverStripe Quick Feedback

Creates a quick yes/no feedback form which can be added to any page on your site.

## Requirements

- SilverStripe ^3.2

## Installation

```
$ composer require mandrew/silverstripe-quickfeedback
```

This module is configured so that you can use it just by adding something to your templates:

```html
{$QuickFeedbackForm}
```

A controller extension is added to the base `Controller` class, which means this should be available wherever you try it.

If you're having trouble with URLs. stored in the database, you can enable `QuickFeedbackExtension → redirect_field: true` in your YAML config.

## Versioning

This library follows [Semver](http://semver.org). According to Semver, you will be able to upgrade to any minor or patch version of this library without any breaking changes to the public API. Semver also requires that we clearly define the public API for this library.

All methods, with `public` visibility, are part of the public API. All other methods are not part of the public API. Where possible, we'll try to keep `protected` methods backwards-compatible in minor/patch versions, but if you're overriding methods then please test your work before upgrading.

## Reporting Issues

Please [create an issue](http://github.com/mandrew/silverstripe-quickfeedback/issues) for any bugs you've found, or features you're missing.
