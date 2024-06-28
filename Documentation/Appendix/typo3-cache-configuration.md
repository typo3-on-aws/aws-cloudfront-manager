# TYPO3 Cache Configuration

> Please note that the term "cache" on this page refers to the TYPO3 cache and not to the Amazon CloudFront cache.

TYPO3 caches the CloudFront distribution details internally for one hour (3600 seconds) by default. You can change the cache expiry time to a different value (in seconds) by overriding the cache configuration in the `additional.php` file.

In the file `config/system/additional.php` or `typo3conf/system/additional.php`:
```php
// Cache CloudFront distribution details for 1 day (86400 seconds)
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['aws_cloudfront_manager']['options']['defaultLifetime'] = 86400;
```

Typical values are `1` (cache CloudFront distribution details for only one second), `1800` (30 minutes), `3600` (1 hour), `7200` (2 hours), `43200` (12 hours), `86400` (1 day), `345600` (4 days), `604800` (1 week), etc.

TYPO3 uses the `FileBackend` to write the cache data into the local file system by default. You can also adjust this configuration. Read more about cache configuration options in the [TYPO3 documentation](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/CachingFramework/Configuration/Index.html).

----
▲ [Appendix](README.md)
