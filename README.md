
# gerador de hash


### Explicação da solução apresentada e principais decisões tomadas na implementação


1. Rota para geração do hash

- Para gerar a string aleatoria usamos a função [random_bytes](https://www.php.net/manual/pt_BR/function.random-bytes.php). 

- Para o controle de request adicionamos [Rate Limiter](https://symfony.com/doc/current/rate_limiter.html) que facilita a delimitação de request em um espaço de tempo predefinido.

2. Comando para consulta da rota

- adicionamos [Api Platform](https://symfony.com/doc/current/the-fast-track/en/26-api.html) para facilitar o armazenamento dos Resultados.
- se retonar um status 429, aguarda 60s.


3. Rota de retorno dos resultados

- utilizamos [Api Platform](https://symfony.com/doc/current/the-fast-track/en/26-api.html) para o retorno dos dos resultados.


## Requisitos
- docker 20.x
- php 8.1
- Symfony = 6.1
- composer >= 2.1

# Instalação do projeto
- Dentro da pasta raiz executar: 
  - Subir o container do banco com `docker-compose up -d`
  - execute: `composer install`
  - adicionar a base: ` bin/console doctrine:migrations:migrate `


- rodar o projeto: `symfony server:start --port=8000`, se por alguma razão a porta 8000 não estiver diponivel será necessaria a alteração da porta no `default_uri:`.
    - caminho para configurar: `hash_generator/config/packages/framework.yaml `.



## Documentação da API


#### Retorna itens paginados

```
  GET /api/hashes?page=2
```
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `page`| `int` |  retorna lista paginada de hash                   |

#### Retorna um item
```
  GET /api/hashes/${id}
```

#### Filtrar resultados por numero de tentativas para gerar o hash menores que o numero passado no filtro
```
  GET /api/hashes?page=2&numberOfAttempts[lt]=1000
```
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `numberOfAttempts[lt]`| `int` |  retorna lista paginada de numberOfAttempts que possuem o  atributo counter abaixo do valor informado.|


#### retorna um JSON com hash prefixado, numero de tentativas para gerar e chave.
```
  Post  api/generate_hash
  
  Body :
  {
    "str" : "Test"
  }

```

### salva hash gerado
```
  Post  api/hashes

  Body:
  {
    "batch":           DateTime,
    "input":           string,
    "key":             string,
    "blockNumber":     int,
    "generatedHash":   string,
    "numberOfAttempts":   int,
  }
```

## Console Command
para executar o command, rodar o commando abaixo no terminal do projeto.

`bin/console app:avato:test “teste” --requests=100`


