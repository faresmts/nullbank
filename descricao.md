# Descrição – Modelo de negócios:

- Agências
  - número (id), 
  - nome, 
  - salário_montante_total
    - (que deve ser calculado / atualizado a cada inserção / atualização / remoção de funcionário na
    agência)
  - cidade 


- Funcionários
  - agência_id (chave externa 1:n) 
  - matrícula (usada também para login), 
  - senha (criptografada), 
  - endereço, 
  - cidade, 
  - cargo (podendo ser gerente, atendente ou caixa), 
  - sexo (masculino ou feminino), 
  - data de nascimento 
  - salário (não podendo este ser menor que R$2.286,00, salário-base da categoria). 


- Dependentes 
  - no máximo 5 para cada funcionário
  - nome completo (único por funcionário)
  - data de nascimento, 
  - parentesco (se filho(a), cônjuge ou genitor(a))
  - idade (que deve ser calculada).


- Clientes
  - pode possuir várias contas bancárias
    - uma por agência 
    - cada conta conjunta pode pertencer a no máximo 2 clientes
  - nome completo
  - RG (com um máximo de 15 dígitos)
  - órgão emissor
  - UF
  - CPF (sendo este o identificador do cliente, contendo 11 dígitos, sem pontos, traços etc)
  - a data de nascimento
  - telefones (podendo ser vários, como residencial, comercial, celular1, celular2 etc, com, no máximo, 11 dígitos cada)
  - e-mails (podendo ser vários também, como particular, comercial etc, cada um com um máximo de 60 caracteres)


- Endereços 
  - tipo de logradouro
  - nome do logradouro
  - número
  - bairro
  - CEP
  - cidade
  - estado


- Contas
  - número da conta (identificador)
  - o saldo
  - a senha (criptografada)
  - o tipo de conta 
    - conta poupança tem uma taxa de juros (percentual) 
    - conta especial tem um limite de crédito
    - conta corrente possui a data de aniversário do contrato como atributo especial)
  - a agência (a qual a conta está vinculada)
  - o gerente (vinculado à conta e que é um funcionário daquela agência)
  - saldo:
    - deve iniciar zerado
    - deve refletir o conjunto de transações que são executadas sobre aquela conta de forma automática
    - o saldo da conta/limite de crédito não pode ficar negativado


- Transações 
  - número da transação – sendo único por conta
  - tipo da transação (saque, depósito, pagamento, estorno ou transferência),
  - data-hora 
  - valor

# Funcionamento do Sistema
- solicitando “Usuário” e “Senha” de acesso ao BD logo na tela inicial.
- três níveis de acesso: 
  - Um de administrador/DBA (sempre com login: Admin e senha: Root), que deve manter o cadastro
  (inserção, remoção, alteração) de todas as entidades / tabelas (descritas acima), além de poder fazer
  todas as consultas disponíveis no sistema. O usuário DBA deverá ser capaz de ter acesso total e
  irrestrito ao sistema, podendo realizar toda e qualquer operação.
  

- Deve existir um controle de login dos funcionários, que é feito a partir da matrícula e da senha,
  onde: 
  - gerentes
    - acesso (leitura e/ou escrita) aos dados das contas que o mesmo gerencia
    - acesso de leitura aos números e saldos das contas de sua mesma agência
  - atendentes 
    - acesso de leitura aos números e saldos das contas de sua mesma agência
  - caixas
    - acesso irrestrito às transações das contas de sua agência podendo efetuar operações sobre as mesmas
    - acesso de leitura aos números e saldos das contas de sua mesma agência

- No caso de cliente com mais de uma conta, o mesmo deve selecionar qual a conta a ser acessada após o login com CPF e senha.
