# Catcher
API universal de registros de requisições

## Capturando dados mTLS no Apache
Adicione as linhas de configuração para Apache.
- Debian/Ubuntu → default-ssl.conf em /etc/apache2/sites-available/
- CentOS/RHEL/AlmaLinux/Rocky → ssl.conf em /etc/httpd/conf.d/
- Arch Linux → costuma ser httpd-ssl.conf em /etc/httpd/conf/extra/

### Exemplo
```
<VirtualHost *:443>

    (...)

    SSLVerifyClient optional_no_ca
    SSLVerifyDepth 1
    SSLOptions +ExportCertData +StdEnvVars

</VirtualHost>
```
## Capturando dados mTLS no ngnix
Adicione as linhas de configuração para ngnix.
### Debian/Ubuntu

- /etc/nginx/sites-available/ → onde você cria o arquivo de site (ex: catcher.conf).
- /etc/nginx/sites-enabled/ → link simbólico para ativar o site.
- /etc/nginx/nginx.conf → arquivo principal que inclui os acima.
### CentOS/RHEL/AlmaLinux/Rocky
- /etc/nginx/conf.d/ → geralmente você cria arquivos .conf aqui (ex: catcher.conf).
- /etc/nginx/nginx.conf → arquivo principal que inclui conf.d/*.conf.
### Instalação manual (compilada do source)
- costuma ficar em /usr/local/nginx/conf/nginx.conf, e você pode criar sub-arquivos conforme organizar.
### Exemplo
```
server {
    
    (...)

    ssl_verify_client          optional;           # ou “on” se for obrigatório
    ssl_verify_depth           1;

    ssl_verify_client          on;
    ssl_preread               off;

    proxy_set_header X-SSL-Client-Cert $ssl_client_cert;
    proxy_set_header X-SSL-Client-Verify $ssl_client_verify;
    proxy_set_header X-SSL-Client-DN $ssl_client_s_dn;

   (...)

}
```
