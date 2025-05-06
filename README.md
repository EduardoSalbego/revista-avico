# Sci Magazines

Repositório dedicado à atividade desenvolvida durante a disciplina de Resolução de Problemas IV de Engenharia de Software na [Universidade Federal do Pampa](https://unipampa.edu.br/). O projeto foi desenvolvido utilizando as seguintes tecnologias:
- **Frontend e backend:** Laravel 8
- **Banco de dados:** MySQL
- **Armazenamento de arquivos na nuvem:** Amazon AWS

## Como começar
Visite a [playlist do projeto no YouTube](https://www.youtube.com/playlist?list=PLCb-PNnEza-rMIRMKW6nJCKdgdlNW9j5q). Lá você irá encontrar tutoriais em vídeo sobre o funcionamento da ferramenta.

Consulte os manuais em links úteis

### Setup básico
- Você irá precisar instalar o [PHP](https://www.php.net/downloads.php) na sua máquina. A versão 8.1.3 é a mais estável no momento em que esse README foi escrito
- Além disso, será necessário instalar o **Composer**. Isso pode ser feito através da seguinte linha de comando:
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
- Instale o [MySQL workbench](https://www.mysql.com/products/workbench/) para poder gerenciar o banco de dados
  - aproveite o momento e já crie um novo banco de dados
- Instale o [Git](https://git-scm.com/downloads) para poder clonar o repositório
- Clone o nosso repositório: `git clone https://github.com/lleafar/rp4-revista.git`

Depois de ter o repositório clonado, você deve [criar](https://github.com/platformsh-templates/laravel/blob/master/.env.example) e configurar o arquivo `.env` com suas credenciais e banco de dados. Após isso, navegue até a raiz do diretório e execute os seguintes comandos:
- `composer require laravel/ui`
- `composer require spatie/laravel-permission`
- `php artisan ui vue --auth`
- `php artisan migrate`
- `php artisan permission:create-role autor`
- `php artisan permission:create-role avaliador`
- `php artisan permission:create-role editor`
- `php artisan permission:create-role editor-chefe`

Feito isso, você está pronto para desenvolver! Para começar, é só digitar `php artisan serve` e navegar até o link descrito no terminal.

## Links úteis:
- [Manual de preparação do ambiente]
(https://docs.google.com/document/d/19FRz9J2dEtc64MuMHPiG-KoAsmU993yj69FbcjDcvTI/edit)
- [Manual de configuração do projeto]
(https://docs.google.com/document/d/1ke6opyfNJOVcT_ICFu3XqSgzb-1nRk2yINpAOz6h8_s/edit)
- [Manual de configuração do banco de dados Remoto](https://docs.google.com/document/d/1RxjuzPYg4K8cTXmcXmvEZUBcsbgZ3hvGvkvELQerpyk/edit?usp=sharing)
- [Playlist do projeto no YouTube](https://www.youtube.com/playlist?list=PLCb-PNnEza-rMIRMKW6nJCKdgdlNW9j5q)
- [Google Docs com os casos de teste](https://docs.google.com/document/d/1tkDkE2oFSVUI8WmJjMFwKF4YJgjJF7NzelGdwYdfMz0/edit?usp=sharing) (para impressão/visualização)
- [Google Sheets com os casos de teste](https://docs.google.com/spreadsheets/d/1gaBzIg9nSHtXxl8clC6qesGCaaXhmjqknoeFpX63YDM/edit#gid=742619467) (para criação/edição)
- [Github testes caixa preta automatizados](https://github.com/BhrunoB8/TestesAutomatizadosRPIV)
