# Configuration

Once you installed the TYPO3 extension and its dependencies, you have to configure the following items:

1. Allow the TYPO3 instance to execute certain actions against the CloudFront distribution(s).
   - See "AWS Identity and Access Management (IAM)" below.
2. Add the CloudFront distribution ID(s) and URI paths to the TYPO3 instance.
   - See "TYPO3 Configuration" below.
3. Grant backend users access to the TYPO3 backend module (optional).

You typically take care of the first action through the [AWS Management Console](https://aws.amazon.com/console/). The last point (grant backend users access to the TYPO3 backend module) is optional and only required if you want to allow unprivileged users, for example editors, to clear CDN caches. This configuration is not required if only backend users with administrator privileges intend to work with the backend module.

## AWS Identity and Access Management (IAM)

### Instance Profiles vs IAM Users

To allow the TYPO3 instance to request cache invalidations, and to retrieve basic details of specific CloudFront distributions, you define the permissions in the [AWS Identity and Access Management (IAM)](https://aws.amazon.com/iam/).

If your TYPO3 system runs on an EC2 instance in the AWS cloud, you can use an *instance profile* to pass an IAM role to the EC2 instance. Afterwards you create and attach a permission policy to this role. For more information on this topic, see the [AWS IAM User Guide](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_roles_use_switch-role-ec2.html) and the [Amazon EC2 User Guide](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/iam-roles-for-amazon-ec2.html).

If your TYPO3 instance does not run in the AWS Cloud, an alternative option is to create a dedicated user in AWS IAM, and create and attach a permission policy to that user. You must assign an access key to the IAM user. Access keys consist of two parts: an access key ID and a secret access key.

> Best practice is to follow the *least privileges* principle. **Do not** use the AWS root user or a user with elevated permissions.

Further configuration options exist but are out of scope of this documentation.

### Permissions

The AWS CloudFront Manager TYPO3 extension requires permissions to execute the actions listed below.

- CloudFront:
   - `GetDistribution`
   - `CreateInvalidation`

The [appendix](../Appendix/README.md) contains an example policy for AWS IAM.

## TYPO3 Configuration

Once the AWS permissions are in place, continue and add the CloudFront distributions to the TYPO3 instance:

1. Log in to the TYPO3 backend as a user with system maintainer privileges (administrator).
2. Go to the **Web ➜ List** module and open the first page in the page tree (page ID `0`).
3. Click the button **Create new record** at the top.
4. Locate the section **AWS CloudFront Manager** and determine if you have to configure AWS accounts.

If your TYPO3 system runs in the AWS cloud and your EC2 instance uses an *instance profile* with a properly configured IAM role attached to it, you don't need to configure AWS accounts if the role permission policy covers the access actions as described above. Continue with step 5 below.

If you use IAM user(s) with access keys as outlined above, you need to configure the access details (access key ID and secret access key) by adding AWS account record(s) as follows: ➊ Select **AWS Accounts**. ➋ Enter the IAM user's access key ID (for example `AKIAI1234567890EF`). ➌ Enter the IAM user's secret access key (for example `wJalrXUtnFEMI/K7MDENG/bPxRfiCYexample`). ➍ Click **Save**, then **Close**. Continue with the step 3 above but skip creating AWS accounts.

5. Select **CloudFront distributions**.
6. In the tab **General**:
   - Enter the CloudFront distribution ID, e.g. `E1CHAABBCCDDEEFF`.
   - Enter one or multiple paths, each path in a single line. The value `/*` invalidates the entire cache.
7. In the tab **AWS Account**:
   - (Optional) Select a previously created AWS account that has the permissions to interact with the CloudFront distribution.
8. In the tab **Additional Information**:
   - These fields are read-only. TYPO3 will retrieve and store the data on the first access to the detail view of the CloudFront distribution.
9. Save your configuration.

Repeat the process for every CloudFront distribution you want to manage.

## Grant Backend Users Access

You can use TYPO3's backend user and user group configuration to grant any backend user access to the AWS CloudFront Manager backend module.

System maintainers (administrator) have full access to all backend modules and functions anyway. No configuration is required to allow system maintainers clear the cache of a CloudFront distribution or access its details.

If you want to let "normal" backend users access the backend module, edit their backend user group (or create a new user group for them), open the tab **Access List**, and enable the checkbox **Site Management > CloudFront Manager** (`admin_cloudfront_manager`) in the first section **Modules**.

**Do not** enable the items "AWS Accounts" or "CloudFront Distributions" in the section **Tables (listing)** or in the section **Tables (modify)**, unless you know what you're doing. In most installation, these access privileges are reserved for system maintainers (administrators).

Save your configuration changes.

----
◀ Previous topic: [Installation](../Installation/README.md) ▪ Next topic: [Usage](../Usage/README.md) ▶
