# Catcher
API universal de registros de requisições

## Capturando dados mTLS no Apache
Adicione as linhas de configuração para Apache.
Depende da distro:
- Debian/Ubuntu → default-ssl.conf em /etc/apache2/sites-available/
- CentOS/RHEL/AlmaLinux/Rocky → ssl.conf em /etc/httpd/conf.d/
- Arch Linux → costuma ser httpd-ssl.conf em /etc/httpd/conf/extra/

```
<VirtualHost *:443>

    (...)

    SSLVerifyClient optional_no_ca
    SSLVerifyDepth 1
    SSLOptions +ExportCertData +StdEnvVars
</VirtualHost>
```
