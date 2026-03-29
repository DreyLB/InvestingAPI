GET|HEAD api/carteira/{carteira}/ativos ...................................................................................... carteira.ativos.index › API\AtivoController@index
POST api/carteira/{carteira}/ativos ...................................................................................... carteira.ativos.store › API\AtivoController@store  
 GET|HEAD api/carteira/{carteira}/ativos/{ativoId} .............................................................................. carteira.ativos.show › API\AtivoController@show  
 PUT|PATCH api/carteira/{carteira}/ativos/{ativoId} .......................................................................... carteira.ativos.update › API\AtivoController@update  
 DELETE api/carteira/{carteira}/ativos/{ativoId} ........................................................................ carteira.ativos.destroy › API\AtivoController@destroy  
 GET|HEAD api/carteiras .......................................................................................................... carteiras.index › API\CarteiraController@index  
 POST api/carteiras .......................................................................................................... carteiras.store › API\CarteiraController@store  
 GET|HEAD api/carteiras/{carteiraId}/alertas ......................................................................................................... API\AlertaController@index  
 POST api/carteiras/{carteiraId}/alertas ......................................................................................................... API\AlertaController@store  
 DELETE api/carteiras/{carteiraId}/alertas/{id} .................................................................................................. API\AlertaController@destroy  
 PATCH api/carteiras/{carteiraId}/alertas/{id}/lido ...................................................................................... API\AlertaController@marcarComoLido  
 GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .................................................................................. API\DividendoController@index  
 POST api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .................................................................................. API\DividendoController@store  
 GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .................................................................................. API\TransacaoController@index  
 POST api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .................................................................................. API\TransacaoController@store  
 POST api/carteiras/{carteiraId}/comprar .................................................................................................... API\TransacaoController@comprar  
 GET|HEAD api/carteiras/{carteiraId}/dividendos ............................................................................................. API\DividendoController@porCarteira  
 DELETE api/carteiras/{carteiraId}/dividendos/{id} ............................................................................................ API\DividendoController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/metas ............................................................................................................. API\MetaController@index  
 POST api/carteiras/{carteiraId}/metas ............................................................................................................. API\MetaController@store  
 PUT api/carteiras/{carteiraId}/metas/{id} ....................................................................................................... API\MetaController@update  
 DELETE api/carteiras/{carteiraId}/metas/{id} ...................................................................................................... API\MetaController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/rendimentos ................................................................................................. API\RendimentoController@index  
 POST api/carteiras/{carteiraId}/rendimentos ................................................................................................. API\RendimentoController@store  
 PUT api/carteiras/{carteiraId}/rendimentos/{id} ........................................................................................... API\RendimentoController@update  
 DELETE api/carteiras/{carteiraId}/rendimentos/{id} .......................................................................................... API\RendimentoController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.index › API\AssetTypeController@index  
 POST api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.store › API\AssetTypeController@store  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ......................................................... carteiras.tipo.ativo.show › API\AssetTypeController@show  
 PUT|PATCH api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ..................................................... carteiras.tipo.ativo.update › API\AssetTypeController@update  
 DELETE api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ................................................... carteiras.tipo.ativo.destroy › API\AssetTypeController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/transacoes ............................................................................................. API\TransacaoController@porCarteira  
 DELETE api/carteiras/{carteiraId}/transacoes/{id} ............................................................................................ API\TransacaoController@destroy  
 GET|HEAD api/carteiras/{carteira} ................................................................................................. carteiras.show › API\CarteiraController@show  
 PUT|PATCH api/carteiras/{carteira} ............................................................................................. carteiras.update › API\CarteiraController@update  
 DELETE api/carteiras/{carteira} ........................................................................................... carteiras.destroy › API\CarteiraController@destroy  
 GET|HEAD api/categorias ....................................................................................................... categorias.index › API\CategoriaController@index  
 POST api/categorias ....................................................................................................... categorias.store › API\CategoriaController@store  
 GET|HEAD api/categorias/{categoria} ............................................................................................. categorias.show › API\CategoriaController@show  
 PUT|PATCH api/categorias/{categoria} ......................................................................................... categorias.update › API\CategoriaController@update  
 DELETE api/categorias/{categoria} ....................................................................................... categorias.destroy › API\CategoriaController@destroy  
 POST api/login .................................................................................................................................... API\UserController@login  
 POST api/logout .................................................................................................................................. API\UserController@logout  
 GET|HEAD api/me .......................................................................................................................................... API\UserController@me  
 POST api/register .............................................................................................................................. API\UserController@register  
 GET|HEAD storage/{path} .......................................................................................................................................... storage.local  
 GET|HEAD up ....................................................................................................................................................................

GET|HEAD api/carteira/{carteira}/ativos ...................................................................................... carteira.ativos.index › API\AtivoController@index
POST api/carteira/{carteira}/ativos ...................................................................................... carteira.ativos.store › API\AtivoController@store
GET|HEAD api/carteira/{carteira}/ativos/{ativoId} .............................................................................. carteira.ativos.show › API\AtivoController@show
PUT|PATCH api/carteira/{carteira}/ativos/{ativoId} .......................................................................... carteira.ativos.update › API\AtivoController@update
DELETE api/carteira/{carteira}/ativos/{ativoId} ........................................................................ carteira.ativos.destroy › API\AtivoController@destroy
GET|HEAD api/carteiras .......................................................................................................... carteiras.index › API\CarteiraController@index
POST api/carteiras .......................................................................................................... carteiras.store › API\CarteiraController@store
GET|HEAD api/carteiras/{carteiraId}/alertas ............................................................................... carteiras.alertas.index › API\AlertaController@index
POST api/carteiras/{carteiraId}/alertas ............................................................................... carteiras.alertas.store › API\AlertaController@store
DELETE api/carteiras/{carteiraId}/alertas/{id} ...................................................................... carteiras.alertas.destroy › API\AlertaController@destroy
PATCH api/carteiras/{carteiraId}/alertas/{id}/lido ...................................................................................... API\AlertaController@marcarComoLido  
 GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .............................................. carteiras.ativos.dividendos.index › API\DividendoController@index  
 POST api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .............................................. carteiras.ativos.dividendos.store › API\DividendoController@store  
 DELETE api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos/{id} ..................................... carteiras.ativos.dividendos.destroy › API\DividendoController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .............................................. carteiras.ativos.transacoes.index › API\TransacaoController@index  
 POST api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .............................................. carteiras.ativos.transacoes.store › API\TransacaoController@store  
 DELETE api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes/{id} ..................................... carteiras.ativos.transacoes.destroy › API\TransacaoController@destroy  
 POST api/carteiras/{carteiraId}/comprar .................................................................................................... API\TransacaoController@comprar  
 GET|HEAD api/carteiras/{carteiraId}/dividendos ............................................................................................. API\DividendoController@porCarteira  
 GET|HEAD api/carteiras/{carteiraId}/metas ..................................................................................... carteiras.metas.index › API\MetaController@index  
 POST api/carteiras/{carteiraId}/metas ..................................................................................... carteiras.metas.store › API\MetaController@store  
 PUT|PATCH api/carteiras/{carteiraId}/metas/{id} .............................................................................. carteiras.metas.update › API\MetaController@update  
 DELETE api/carteiras/{carteiraId}/metas/{id} ............................................................................ carteiras.metas.destroy › API\MetaController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/rendimentos ................................................................... carteiras.rendimentos.index › API\RendimentoController@index  
 POST api/carteiras/{carteiraId}/rendimentos ................................................................... carteiras.rendimentos.store › API\RendimentoController@store  
 PUT|PATCH api/carteiras/{carteiraId}/rendimentos/{id} ............................................................ carteiras.rendimentos.update › API\RendimentoController@update  
 DELETE api/carteiras/{carteiraId}/rendimentos/{id} .......................................................... carteiras.rendimentos.destroy › API\RendimentoController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.index › API\AssetTypeController@index  
 POST api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.store › API\AssetTypeController@store  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ......................................................... carteiras.tipo.ativo.show › API\AssetTypeController@show  
 PUT|PATCH api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ..................................................... carteiras.tipo.ativo.update › API\AssetTypeController@update  
 DELETE api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{ativo} ................................................... carteiras.tipo.ativo.destroy › API\AssetTypeController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/transacoes ............................................................................................. API\TransacaoController@porCarteira  
 GET|HEAD api/carteiras/{carteira} ................................................................................................. carteiras.show › API\CarteiraController@show  
 PUT|PATCH api/carteiras/{carteira} ............................................................................................. carteiras.update › API\CarteiraController@update  
 DELETE api/carteiras/{carteira} ........................................................................................... carteiras.destroy › API\CarteiraController@destroy  
 GET|HEAD api/categorias ....................................................................................................... categorias.index › API\CategoriaController@index  
 POST api/categorias ....................................................................................................... categorias.store › API\CategoriaController@store  
 GET|HEAD api/categorias/{categoria} ............................................................................................. categorias.show › API\CategoriaController@show  
 PUT|PATCH api/categorias/{categoria} ......................................................................................... categorias.update › API\CategoriaController@update  
 DELETE api/categorias/{categoria} ....................................................................................... categorias.destroy › API\CategoriaController@destroy  
 POST api/login .................................................................................................................................... API\UserController@login  
 POST api/logout .................................................................................................................................. API\UserController@logout  
 GET|HEAD api/me .......................................................................................................................................... API\UserController@me  
 POST api/register .............................................................................................................................. API\UserController@register  
 GET|HEAD storage/{path} .......................................................................................................................................... storage.local  
 GET|HEAD up ....................................................................................................................................................................

GET|HEAD api/carteiras .......................................................................................................... carteiras.index › API\CarteiraController@index
POST api/carteiras .......................................................................................................... carteiras.store › API\CarteiraController@store
GET|HEAD api/carteiras/{carteiraId}/alertas ............................................................................... carteiras.alertas.index › API\AlertaController@index
POST api/carteiras/{carteiraId}/alertas ............................................................................... carteiras.alertas.store › API\AlertaController@store
DELETE api/carteiras/{carteiraId}/alertas/{id} ...................................................................... carteiras.alertas.destroy › API\AlertaController@destroy
PATCH api/carteiras/{carteiraId}/alertas/{id}/lido ...................................................................................... API\AlertaController@marcarComoLido
GET|HEAD api/carteiras/{carteiraId}/ativos .................................................................................. carteiras.ativos.index › API\AtivoController@index
POST api/carteiras/{carteiraId}/ativos .................................................................................. carteiras.ativos.store › API\AtivoController@store
GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId} .......................................................................... carteiras.ativos.show › API\AtivoController@show
PUT|PATCH api/carteiras/{carteiraId}/ativos/{ativoId} ...................................................................... carteiras.ativos.update › API\AtivoController@update
DELETE api/carteiras/{carteiraId}/ativos/{ativoId} .................................................................... carteiras.ativos.destroy › API\AtivoController@destroy
GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .............................................. carteiras.ativos.dividendos.index › API\DividendoController@index
POST api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos .............................................. carteiras.ativos.dividendos.store › API\DividendoController@store
DELETE api/carteiras/{carteiraId}/ativos/{ativoId}/dividendos/{id} ..................................... carteiras.ativos.dividendos.destroy › API\DividendoController@destroy
GET|HEAD api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .............................................. carteiras.ativos.transacoes.index › API\TransacaoController@index
POST api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes .............................................. carteiras.ativos.transacoes.store › API\TransacaoController@store
DELETE api/carteiras/{carteiraId}/ativos/{ativoId}/transacoes/{id} ..................................... carteiras.ativos.transacoes.destroy › API\TransacaoController@destroy  
 POST api/carteiras/{carteiraId}/comprar .................................................................................................... API\TransacaoController@comprar  
 GET|HEAD api/carteiras/{carteiraId}/dividendos ............................................................................................. API\DividendoController@porCarteira  
 GET|HEAD api/carteiras/{carteiraId}/metas ..................................................................................... carteiras.metas.index › API\MetaController@index  
 POST api/carteiras/{carteiraId}/metas ..................................................................................... carteiras.metas.store › API\MetaController@store  
 PUT|PATCH api/carteiras/{carteiraId}/metas/{id} .............................................................................. carteiras.metas.update › API\MetaController@update  
 DELETE api/carteiras/{carteiraId}/metas/{id} ............................................................................ carteiras.metas.destroy › API\MetaController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/rendimentos ................................................................... carteiras.rendimentos.index › API\RendimentoController@index  
 POST api/carteiras/{carteiraId}/rendimentos ................................................................... carteiras.rendimentos.store › API\RendimentoController@store  
 PUT|PATCH api/carteiras/{carteiraId}/rendimentos/{id} ............................................................ carteiras.rendimentos.update › API\RendimentoController@update  
 DELETE api/carteiras/{carteiraId}/rendimentos/{id} .......................................................... carteiras.rendimentos.destroy › API\RendimentoController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.index › API\AssetTypeController@index  
 POST api/carteiras/{carteiraId}/tipo/{tipo}/ativo ............................................................... carteiras.tipo.ativo.store › API\AssetTypeController@store  
 GET|HEAD api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{tipoAtivoId} ................................................... carteiras.tipo.ativo.show › API\AssetTypeController@show  
 PUT|PATCH api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{tipoAtivoId} ............................................... carteiras.tipo.ativo.update › API\AssetTypeController@update  
 DELETE api/carteiras/{carteiraId}/tipo/{tipo}/ativo/{tipoAtivoId} ............................................. carteiras.tipo.ativo.destroy › API\AssetTypeController@destroy  
 GET|HEAD api/carteiras/{carteiraId}/transacoes ............................................................................................. API\TransacaoController@porCarteira  
 GET|HEAD api/carteiras/{carteira} ................................................................................................. carteiras.show › API\CarteiraController@show  
 PUT|PATCH api/carteiras/{carteira} ............................................................................................. carteiras.update › API\CarteiraController@update  
 DELETE api/carteiras/{carteira} ........................................................................................... carteiras.destroy › API\CarteiraController@destroy  
 GET|HEAD api/categorias ....................................................................................................... categorias.index › API\CategoriaController@index  
 POST api/categorias ....................................................................................................... categorias.store › API\CategoriaController@store  
 GET|HEAD api/categorias/{categoria} ............................................................................................. categorias.show › API\CategoriaController@show  
 PUT|PATCH api/categorias/{categoria} ......................................................................................... categorias.update › API\CategoriaController@update  
 DELETE api/categorias/{categoria} ....................................................................................... categorias.destroy › API\CategoriaController@destroy  
 POST api/login .................................................................................................................................... API\UserController@login  
 POST api/logout .................................................................................................................................. API\UserController@logout  
 GET|HEAD api/me .......................................................................................................................................... API\UserController@me  
 POST api/register .............................................................................................................................. API\UserController@register  
 GET|HEAD storage/{path} .......................................................................................................................................... storage.local  
 GET|HEAD up ....................................................................................................................................................................
