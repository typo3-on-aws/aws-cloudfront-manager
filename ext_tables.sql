-- Database schema

CREATE TABLE tx_awscloudfrontmanager_domain_model_awsaccount (
    pid int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    access_key_id varchar(255) DEFAULT '' NOT NULL,
    secret_access_key varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE tx_awscloudfrontmanager_domain_model_distribution (
    distribution_id varchar(255) DEFAULT '' NOT NULL,
    aws_account_id int(11) DEFAULT NULL,
    domain_name varchar(255) DEFAULT NULL,
    comment varchar(255) DEFAULT NULL,
    paths text DEFAULT '' NOT NULL
);
