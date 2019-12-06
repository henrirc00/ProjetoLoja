import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NavController } from '@ionic/angular';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  //url dos produtos cadastrados no postman. Para ser listado na home.page.ts do app.
  private url:string="http://localhost/dbloja/data/produto/listar.php";

  /*
  Vamos receber os produtos cadastrados na forma de json da API
  por meio da url acima.
  O conteúdo que virá será uma lista de objetos, ou seja, uma lista de produtos.
  Para utilizar essa lista na página principal(home.html) estamos usando um Array de objetos
  que receberá os dados da API
  e irá repassar para o nosso laça (*ngFor) na home.  
  */ 
  public produtos:Array<Object>=[];
  constructor(private http:HttpClient, private router:Router) {}

  public navDetalheProduto(id:string) {
    console.log(id);
    this.router.navigate(['detalheproduto',{idprod:id}]);
  }

/*
O comando ngOnInit(ng-> todos os comandos internos do Angular |
  On->Ativar , Ligar | Init->Initialize = Iniciar).
  No momento em que a página home inicializa será feita uma requisição http dentro
  do método ngOnInit para buscar os 
  produtos cadastrados. 
  O comando ngOnInit é iniciado automáticamente, portanto nã é necessário chamar.
*/

  ngOnInit(){

 /*
 Os comandos:
 this -> refere-se a essa classe HomePage e todo o seu conteúdo;
 http-> é um elemento tipado como http client redponsavel por fazer as requisiçoes
 do REST com os verbos: get; post; put e delete. Esse elemento foi declarado no construtor 
 da classe. Construtor é responsável por iniciar a classe com o seu conteúdo;
 get-> significado obter é responsével por chamar o conteúdo da página listar
 com todos os seus produtos.

 ------------------------------------------------------------------------------------
O comando get requisita a url para fazer a chamada dos dados do produtos, por isso é 
passado entre parênteses a url criada no contexto da classe e chamada com o comando 
this.url.
O comando subscriber(Observable) é responsável por recepcionar 
os dados vindos da url listar produtos com todos os seus produtos.
Estes são repassados para o objeto data e seu conteúdo é tratado 
de forma genérica com o comando (data as any) e atribuindo a constante prod. 

Com todos os produtos na constante prod, fazemos a exibição
deste na tela de comsole. 

Mais abaixo, o comando error trata os eventuais erros ocorridos durante
a requisição da API.
 */  
    this.http.get(this.url).subscribe(
      data => {
        const prod = (data as any);
        this.produtos = prod.saida; 
      }, error => {
        console.log("Error ao requisitar a Api" + error);
      }
    )
  }

}
