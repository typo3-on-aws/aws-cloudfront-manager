# Appendix: AWS IAM Example Policy

See below for an example permission policy for [AWS Identity and Access Management (IAM)](https://aws.amazon.com/iam/). Replace `<ACCOUNT_ID>` with the AWS account ID and `<DISTRIBUTION_ID>` with the CloudFront distribution ID.

```json
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "cloudfront:GetDistribution",
        "cloudfront:CreateInvalidation"
      ],
      "Resource": [
        "arn:aws:cloudfront::<ACCOUNT_ID>:distribution/<DISTRIBUTION_ID>"
      ]
    }
  ]
}
```

If you want to allow the TYPO3 instance to access multiple CloudFront distributions, you can list the ARNs comma-separated in the `Resource` array. For example:

```json
"Resource": [
  "arn:aws:cloudfront::123456789000:distribution/E1AAAABBBBCCCC",
  "arn:aws:cloudfront::123456789000:distribution/E1DDDDEEEEFFFF"
]
```

----
▲ [Appendix](./README.md)
