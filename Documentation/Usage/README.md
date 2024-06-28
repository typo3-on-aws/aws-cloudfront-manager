# Usage

## List View

In the TYPO3 backend, go to **Site Management ➜ CloudFront Manager** (see [first screenshot](../Screenshots/README.md) for an example). The subsequent page lists all CloudFront distributions including their distribution ID, domain name (if available), comment/description (if available), and the action buttons **Clear CDN Cache** and **Details**.

The domain name and the comment/description become available once you access the details view at least once. At this point, the extension retrieves the information from AWS and stores them in the database.

## Details View

Click on the button **Details** of a CloudFront distribution in the list view to access the details view of a CloudFront distribution (see [second screenshot](../Screenshots/README.md) for an example).

The extension retrieves the some details about the CloudFront distribution from AWS. For example, the distribution ID, domain name, status, Amazon Resource Name (ARN), last modification date/time, comment/description, price class, supported HTTP method, etc. You can copy some of the values into your clipboard by clicking on the icon right-hand side of the field.

Be aware that all fields of the details view are read-only.

TYPO3 caches the retrieved data internally for one hour by default. You can force a refresh of the data by clicking on the button **Refresh** in the details view. To change the cache expiry time from one hour to a different value, see the [appendix](../Appendix/README.md).

## Clear CDN Cache of a Distribution

You can initiate a CDN cache clear in either the list view or in the details view by clicking the button **Clear CDN Cache** (see [third screenshot](../Screenshots/README.md) for an example).

> It important to understand that Amazon CloudFront caches are not immediately cleared when you request a cache invalidation. Although you receive a confirmation message straight away, it may take up to a few minutes until all CDN nodes worldwide have received the command and cleared their caches.

Read more in the [AWS documentation](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/Invalidation.html).

----
◀ Previous topic: [Configuration](../Configuration/README.md) ▪ Next topic: [Troubleshooting](../Troubleshooting/README.md) ▶
