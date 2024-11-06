# Installation

## Compatibility

| Extension Version  | TYPO3 Core Version | State       |
| -----------------: | :----------------- | :---------- |
| v1.x               | TYPO3 v12 LTS      | stable      |
| v2.x               | TYPO3 v13 LTS      | stable      |
| Git branch `main`  | TYPO3 v13 LTS      | development |

TYPO3 versions before v12 LTS are not supported.

## Dependencies

The AWS CloudFront Manager extension uses the official [AWS SDK for PHP](https://aws.amazon.com/sdk-for-php/) to communicate with the AWS API. The SDK is available as a Composer package and as a separate [TYPO3 extension](https://extensions.typo3.org/extension/aws_sdk_php). Both methods ensure stable and smooth installation and maintenance processes.

## Composer-based TYPO3 Installations

> If your TYPO3 instance uses the classic TYPO3 installation, see section "Classic TYPO3 Installations" below.

Execute the following Composer command in the project directory of your TYPO3 instance to install the extension in a Composer-based TYPO3 installation:

```bash
composer require t3rrific/aws-cloudfront-manager
```

This command resolves dependencies, downloads all required packages (incl. the AWS SDK for PHP), and installs the extension in your TYPO3 system.

To finalize the installation, execute the following TYPO3 CLI command:

```bash
./vendor/bin/typo3 extension:setup
```

This command sets up all extensions and should be executed when you add new extensions to the system. The command performs all required operations, such as database schema changes, etc.

Next step: [configure](../Configuration/README.md) the TYPO3 extension.

## Classic TYPO3 Installations

> Please note that Composer-based setups are the recommended installation methods today.

If your TYPO3 instance uses the classic TYPO3 installation, follow the steps below to download and install the AWS CloudFront Manager extension:

1. Log in to the TYPO3 backend as a user with system maintainer privileges (administrator).
2. Open the Extension Manager (**Admin Tools ➜ Extensions**).
3. Select **Get Extensions** from the dropdown box at the top.
4. Make sure that the list of available extensions (the extension list) is up-to-date.
5. Search for the extension key `aws_sdk_php` and click the **Import and Install** icon at the left-hand side.
6. TYPO3 downloads and installs the "AWS SDK for PHP" extension.
7. Search for the extension key `aws_cloudfront_manager` and click the **Import and Install** icon at the left-hand side.
8. TYPO3 downloads and installs the "AWS CloudFront Manager" extension.

TYPO3 downloads, installs, and automatically activates both extensions by default. Next step: [configure](../Configuration/README.md) the TYPO3 extension.

----
◀ Previous topic: [Screenshots](../Screenshots/README.md) ▪ Next topic: [Configuration](../Configuration/README.md) ▶
