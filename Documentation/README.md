# AWS CloudFront Manager

| **Extension key:**             | `aws_cloudfront_manager`                                                                     |
| :----------------------------- | :------------------------------------------------------------------------------------------- |
| **Package name:**              | `t3rrific/aws-cloudfront-manager`                                                            |
| **Version:**                   | 1.0.x                                                                                        |
| **Code insight:**              | [GitHub repository](https://github.com/typo3-on-aws/aws-cloudfront-manager)                  |
| **Author:**                    | Michael Schams \| [<schams.net>](https://schams.net) \| [t3rrific.com](https://t3rrific.com) |
| **Documentation language:**    | English                                                                                      |
| **Documentation last update:** | 28 June 2024                                                                                |

## Summary

TYPO3 backend module that lets backend users clear the CDN cache of [Amazon CloudFront](https://aws.amazon.com/cloudfront/) distributions (*cache invalidation*).

## Contribution and Support

I am happy to take code contributions as pull requests into consideration (please see the [Git repository](https://github.com/typo3-on-aws/aws-cloudfront-manager) at GitHub). For feature requests, questions, and additional support, feel free to [contact me](https://schams.net).

Please consider to sponsor and support the ongoing development of this open-source TYPO3 extension. This applies specifically if you use the extension in commercial projects.

## Table of Contents

- [Introduction](Introduction/README.md)
- [Screenshots](Screenshots/README.md)
- [Installation](Installation/README.md)
    - Compatibility
    - Dependencies
    - Composer-based TYPO3 Installations
    - Classic TYPO3 Installations
- [Configuration](Configuration/README.md)
    - AWS Identity and Access Management (IAM)
    - TYPO3 Configuration
- [Usage](Usage/README.md)
    - List View
    - Details View
    - Clear CDN Cache of a Distribution
- [Troubleshooting](Troubleshooting/README.md)
    - "Extension Dependency" Error
    - "Missing Configuration" Warning
    - "Access Denied" Errors
- [Appendix](Appendix/README.md)
    - [Limitations](Appendix/limitations.md)
    - [AWS IAM Example Policy](Appendix/aws-iam-example-policy.md)
    - [TYPO3 Cache Configuration](Appendix/typo3-cache-configuration.md)
