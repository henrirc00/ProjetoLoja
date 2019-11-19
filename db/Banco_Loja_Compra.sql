select * from usuario; 


insert into usuario(nomeusuario, senha, foto)
values('admin', md5('123'), 'imgusuario/admin.png');


select * from contato;

insert into contato(telefone, email)
values('11-5569-2235','admin@admin.com.br');

select * from endereco;

insert into endereco(logradouro, numero, complemento, bairro, cep)
values('Rua Nova','54','54','arthur-alvim','03591080');

select * from cliente;

insert into cliente(nome, cpf, id_endereco, id_contato, id_usuario)
values('henrique', '48512345612','1','1','1');

select * from produto;

insert into produto(nome, descricao, preco, imagem1, imagem2, imagem3, imagem4)
values('esfiha','esfiha de chocolate', 5.00, 'imgproduto/esfiha1.png','imgproduto/esfiha2.png','imgproduto/esfiha3.png','imgproduto/esfiha4.png');

select * from estoque;

insert into estoque(id_produto, quantidade)
value(1,10),(2,30);

select * from pedido;

insert into pedido(id_cliente) values(1);

select * from detalhepedido; 

insert into detalhepedido(id_pedido, id_produto, quantidade)
values(1,1,3) , (1,2,2);

#<----------------------------------------------------------------->
#Compra 

#Da tabela produto (nomeproduto, preco)
#Da tabela detalhepedido(quantidade)
#A amarração entre as tabelas será feito pelo campo
#id_produto

select d.id_pedido, p.nome, p.preco, d.quantidade, p.preco*d.quantidade 'total'
from produto p inner join detalhepedido d on p.id = d.id_produto;

#Vamos, realizar a soma da coluna total(quantidade do detalhepedido
#Vezes o preco do produto) e para isso iremos usar o comando 
#sum(soma). Para a funçao realizar esta operacao, nos teremos
#os seus produtos. Sendo assim iremos usar outro comando de 
#parametro o campo id_pedido.

select sum(p.preco*d.quantidade) 'Total a pagar' from
produto p inner join detalhepedido d on p.id=d.id_produto
group by d.id_pedido;


select sum(p.preco*d.quantidade) 'Total a pagar',
(sum(p.preco*d.quantidade))/5 'Valor da parcela' from
produto p inner join detalhepedido d on p.id=d.id_produto
group by d.id_pedido;

#O calculo esta dividindo o valor total da parcela 


select * from pagamento;

insert into pagamento(id_pedido, valor, formapagamento, descricao, numeroparcela, valorparcela)
values(1,85,'Cartão de Crédito','N.141-Henrique',5,17);


select * from estoque;

select e.quantidade 'Estoque', d.quantidade 'Vendido' , e.quantidade-d.quantidade 'Atual' 
from estoque e inner join produto p on  p.id = e.id_produto 
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;


select e.quantidade-d.quantidade 
from estoque e inner join produto p on  p.id = e.id_produto 
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;



update estoque set quantidade=(select e.quantidade-d.quantidade 
from estoque e inner join produto p on  p.id = e.id_produto 
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=1) where id_produto=1;


select * from estoque;

select * from detalhepedido;

update estoque
set quantidade=quantidade-
 (select d.quantidade
 from detalhepedido d where d.id_produto=2
 )
 where id_produto=2;
 
 select * from estoque;
 
 
 
 
 
 