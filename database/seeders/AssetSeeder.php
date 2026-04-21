<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
  public function run(): void
  {
    // asset_type_id 1 = Ações
    $acoes = [
      ['ticker' => 'PETR4',  'nome' => 'Petrobras'],
      ['ticker' => 'B3SA3',  'nome' => 'B3'],
      ['ticker' => 'BBDC4',  'nome' => 'Banco Bradesco'],
      ['ticker' => 'GMAT3',  'nome' => 'Grupo Mateus'],
      ['ticker' => 'RAIZ4',  'nome' => 'Raízen'],
      ['ticker' => 'COGN3',  'nome' => 'Cogna'],
      ['ticker' => 'BBAS3',  'nome' => 'Banco do Brasil'],
      ['ticker' => 'ITSA4',  'nome' => 'Itaúsa'],
      ['ticker' => 'LREN3',  'nome' => 'Lojas Renner'],
      ['ticker' => 'CSAN3',  'nome' => 'Cosan'],
      ['ticker' => 'VALE3',  'nome' => 'Vale'],
      ['ticker' => 'ITUB4',  'nome' => 'Itaú Unibanco'],
      ['ticker' => 'ABEV3',  'nome' => 'Ambev'],
      ['ticker' => 'PETR3',  'nome' => 'Petrobras'],
      ['ticker' => 'MGLU3',  'nome' => 'Magazine Luiza'],
      ['ticker' => 'VAMO3',  'nome' => 'Grupo Vamos'],
      ['ticker' => 'BRAV3',  'nome' => '3R Petroleum'],
      ['ticker' => 'ASAI3',  'nome' => 'Assaí'],
      ['ticker' => 'BEEF3',  'nome' => 'Minerva'],
      ['ticker' => 'PRIO3',  'nome' => 'PetroRio'],
      ['ticker' => 'CPLE3',  'nome' => 'Copel'],
      ['ticker' => 'AZTE3',  'nome' => 'AZT Energia'],
      ['ticker' => 'CMIG4',  'nome' => 'Cemig'],
      ['ticker' => 'CXSE3',  'nome' => 'Caixa Seguridade'],
      ['ticker' => 'PCAR3',  'nome' => 'Grupo Pão de Açúcar'],
      ['ticker' => 'CVCB3',  'nome' => 'CVC'],
      ['ticker' => 'CEAB3',  'nome' => 'C&A'],
      ['ticker' => 'CSNA3',  'nome' => 'Siderúrgica Nacional'],
      ['ticker' => 'MBRF3',  'nome' => 'Marfrig'],
      ['ticker' => 'BPAC11', 'nome' => 'Banco BTG Pactual'],
      ['ticker' => 'CMIN3',  'nome' => 'CSN Mineração'],
      ['ticker' => 'NATU3',  'nome' => 'NATURA'],
      ['ticker' => 'BBDC3',  'nome' => 'Banco Bradesco'],
      ['ticker' => 'MRVE3',  'nome' => 'MRV'],
      ['ticker' => 'EMBJ3',  'nome' => 'Embraer'],
      ['ticker' => 'WEGE3',  'nome' => 'WEG'],
      ['ticker' => 'ECOR3',  'nome' => 'EcoRodovias'],
      ['ticker' => 'GGBR4',  'nome' => 'Gerdau'],
      ['ticker' => 'HAPV3',  'nome' => 'Hapvida'],
      ['ticker' => 'RAIL3',  'nome' => 'Rumo'],
      ['ticker' => 'DIRR3',  'nome' => 'Direcional'],
      ['ticker' => 'DASA3',  'nome' => 'Dasa'],
      ['ticker' => 'SMFT3',  'nome' => 'Smart Fit'],
      ['ticker' => 'ONCO3',  'nome' => 'Oncoclínicas'],
      ['ticker' => 'CYRE3',  'nome' => 'Cyrela'],
      ['ticker' => 'POMO4',  'nome' => 'Marcopolo'],
      ['ticker' => 'BBSE3',  'nome' => 'BB Seguridade'],
      ['ticker' => 'EQTL3',  'nome' => 'Equatorial Energia'],
      ['ticker' => 'UGPA3',  'nome' => 'Ultrapar'],
      ['ticker' => 'USIM5',  'nome' => 'Usiminas'],
      ['ticker' => 'GOAU4',  'nome' => 'Metalúrgica Gerdau'],
      ['ticker' => 'BRKM5',  'nome' => 'Braskem'],
      ['ticker' => 'RADL3',  'nome' => 'RaiaDrogasil'],
      ['ticker' => 'ENEV3',  'nome' => 'Eneva'],
      ['ticker' => 'VBBR3',  'nome' => 'Vibra Energia'],
      ['ticker' => 'RECV3',  'nome' => 'PetroRecôncavo'],
      ['ticker' => 'RENT3',  'nome' => 'Localiza'],
      ['ticker' => 'RAPT4',  'nome' => 'Randon'],
      ['ticker' => 'MOVI3',  'nome' => 'Movida'],
      ['ticker' => 'YDUQ3',  'nome' => 'YDUQS'],
      ['ticker' => 'LWSA3',  'nome' => 'Locaweb'],
      ['ticker' => 'ANIM3',  'nome' => 'Ânima Educação'],
      ['ticker' => 'ODPV3',  'nome' => 'Odontoprev'],
      ['ticker' => 'ALOS3',  'nome' => 'Allos'],
      ['ticker' => 'MULT3',  'nome' => 'Multiplan'],
      ['ticker' => 'AMER3',  'nome' => 'Americanas'],
      ['ticker' => 'ENGI11', 'nome' => 'Energisa'],
      ['ticker' => 'SBSP3',  'nome' => 'Sabesp'],
      ['ticker' => 'TOTS3',  'nome' => 'Totvs'],
      ['ticker' => 'SUZB3',  'nome' => 'Suzano'],
      ['ticker' => 'KLBN11', 'nome' => 'Klabin'],
      ['ticker' => 'TIMS3',  'nome' => 'TIM'],
      ['ticker' => 'FLRY3',  'nome' => 'Fleury'],
      ['ticker' => 'VIVA3',  'nome' => 'Vivara'],
      ['ticker' => 'JHSF3',  'nome' => 'JHSF'],
      ['ticker' => 'IGTI11', 'nome' => 'Iguatemi'],
      ['ticker' => 'CSMG3',  'nome' => 'COPASA'],
      ['ticker' => 'VIVT3',  'nome' => 'Vivo'],
      ['ticker' => 'AZZA3',  'nome' => 'Arezzo'],
      ['ticker' => 'PSSA3',  'nome' => 'Porto Seguro'],
      ['ticker' => 'RDOR3',  'nome' => "Rede D'Or"],
      ['ticker' => 'HYPE3',  'nome' => 'Hypera'],
      ['ticker' => 'CBAV3',  'nome' => 'CBA'],
      ['ticker' => 'ALPA4',  'nome' => 'Alpargatas'],
      ['ticker' => 'AURE3',  'nome' => 'Auren Energia'],
      ['ticker' => 'DXCO3',  'nome' => 'Dexco'],
      ['ticker' => 'SLCE3',  'nome' => 'SLC Agrícola'],
      ['ticker' => 'TUPY3',  'nome' => 'Tupy'],
      ['ticker' => 'CPFE3',  'nome' => 'CPFL Energia'],
      ['ticker' => 'BRAP4',  'nome' => 'Bradespar'],
      ['ticker' => 'BRSR6',  'nome' => 'Banrisul'],
      ['ticker' => 'GRND3',  'nome' => 'Grendene'],
      ['ticker' => 'TAEE11', 'nome' => 'Taesa'],
      ['ticker' => 'EGIE3',  'nome' => 'Engie'],
      ['ticker' => 'SANB11', 'nome' => 'Banco Santander'],
      ['ticker' => 'TEND3',  'nome' => 'Construtora Tenda'],
      ['ticker' => 'JSLG3',  'nome' => 'JSL'],
      ['ticker' => 'SAPR4',  'nome' => 'Sanepar'],
      ['ticker' => 'EZTC3',  'nome' => 'EZTEC'],
      ['ticker' => 'NEOE3',  'nome' => 'Neoenergia'],
      ['ticker' => 'MDIA3',  'nome' => 'M. Dias Branco'],
      ['ticker' => 'LIGT3',  'nome' => 'Light'],
      ['ticker' => 'MDNE3',  'nome' => 'Moura Dubeux'],
      ['ticker' => 'IRBR3',  'nome' => 'IRB Brasil RE'],
      ['ticker' => 'CAML3',  'nome' => 'Camil Alimentos'],
      ['ticker' => 'ABCB4',  'nome' => 'Banco ABC Brasil'],
      ['ticker' => 'AGRO3',  'nome' => 'BrasilAgro'],
      ['ticker' => 'CURY3',  'nome' => 'Cury'],
      ['ticker' => 'SMTO3',  'nome' => 'São Martinho'],
      ['ticker' => 'JALL3',  'nome' => 'Jalles Machado'],
      ['ticker' => 'INTB3',  'nome' => 'Intelbras'],
      ['ticker' => 'GGPS3',  'nome' => 'GPS'],
      ['ticker' => 'PLPL3',  'nome' => 'Plano&Plano'],
      ['ticker' => 'PGMN3',  'nome' => 'Pague Menos'],
      ['ticker' => 'LOGG3',  'nome' => 'LOG CP'],
      ['ticker' => 'TGMA3',  'nome' => 'Tegma'],
      ['ticker' => 'VLID3',  'nome' => 'Valid'],
      ['ticker' => 'FRAS3',  'nome' => 'Fras-le'],
      ['ticker' => 'LEVE3',  'nome' => 'Mahle Metal Leve'],
      ['ticker' => 'UNIP6',  'nome' => 'Unipar'],
      ['ticker' => 'RANI3',  'nome' => 'Irani'],
      ['ticker' => 'EVEN3',  'nome' => 'Even'],
      ['ticker' => 'BLAU3',  'nome' => 'Blau Farmacêutica'],
      ['ticker' => 'VIVT3',  'nome' => 'Vivo'],
      ['ticker' => 'PFRM3',  'nome' => 'Profarma'],
      ['ticker' => 'MILS3',  'nome' => 'Mills'],
      ['ticker' => 'TASA4',  'nome' => 'Taurus'],
      ['ticker' => 'SOJA3',  'nome' => 'Boa Safra Sementes'],
      ['ticker' => 'HBSA3',  'nome' => 'Hidrovias do Brasil'],
      ['ticker' => 'CSED3',  'nome' => 'Cruzeiro do Sul Educacional'],
      ['ticker' => 'MOTV3',  'nome' => 'Motiva'],
      ['ticker' => 'TTEN3',  'nome' => '3tentos'],
      ['ticker' => 'VULC3',  'nome' => 'Vulcabras'],
      ['ticker' => 'DESK3',  'nome' => 'Desktop'],
      ['ticker' => 'MYPK3',  'nome' => 'Iochpe-Maxion'],
      ['ticker' => 'ORVR3',  'nome' => 'Orizon'],
      ['ticker' => 'CASH3',  'nome' => 'Méliuz'],
      ['ticker' => 'LAVV3',  'nome' => 'Lavvi Incorporadora'],
      ['ticker' => 'SEER3',  'nome' => 'Ser Educacional'],
      ['ticker' => 'ALLD3',  'nome' => 'Allied'],
      ['ticker' => 'KLBN4',  'nome' => 'Klabin'],
      ['ticker' => 'BHIA3',  'nome' => 'Casas Bahia'],
    ];

    $fiis = [
      // Shoppings
      ['ticker' => 'XPML11', 'name' => 'XP Malls FII',                    'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HGBS11', 'name' => 'Hedge Brasil Shopping FII',       'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VISC11', 'name' => 'Vinci Shopping Centers FII',      'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'MALL11', 'name' => 'Malls Brasil Plural FII',         'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HSML11', 'name' => 'HSI Malls FII',                   'asset_type_id' => 2, 'category_id' => 1],

      // Lajes Corporativas
      ['ticker' => 'HGRE11', 'name' => 'CSHG Real Estate FII',            'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'BRCR11', 'name' => 'BC Fund FII',                     'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RBRP11', 'name' => 'RBR Properties FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'PVBI11', 'name' => 'VBI Prime Properties FII',        'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'PATL11', 'name' => 'Pátria Lajes Corporativas FII',   'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'XPPR11', 'name' => 'XP Properties FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VLOL11', 'name' => 'VBI Logístico FII',               'asset_type_id' => 2, 'category_id' => 1],

      // Logística
      ['ticker' => 'HGLG11', 'name' => 'CSHG Logística FII',             'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'XPLG11', 'name' => 'XP Log FII',                     'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'BRCO11', 'name' => 'Bresco Logística FII',           'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VILG11', 'name' => 'Vinci Logística FII',            'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'LVBI11', 'name' => 'VBI Logístico FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'BTLG11', 'name' => 'BTG Pactual Logística FII',      'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'GGRC11', 'name' => 'GGR Covepi Renda FII',           'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'ALZR11', 'name' => 'Alianza Trust Renda Imob. FII',  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'GARE11', 'name' => 'Guardian Real Estate FII',       'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'TRXF11', 'name' => 'TRX Real Estate FII',            'asset_type_id' => 2, 'category_id' => 1],

      // Papel / CRI
      ['ticker' => 'KNCR11', 'name' => 'Kinea Rendimentos Imob. FII',    'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'KNIP11', 'name' => 'Kinea Índices de Preços FII',    'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'MXRF11', 'name' => 'Maxi Renda FII',                 'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HGCR11', 'name' => 'CSHG Recebíveis Imob. FII',     'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VRTA11', 'name' => 'Fator Verita FII',               'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'BCRI11', 'name' => 'Banestes Recebíveis Imob. FII',  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RBRY11', 'name' => 'RBR Rendimento High Grade FII',  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'IRDM11', 'name' => 'Iridium Recebíveis Imob. FII',   'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RECR11', 'name' => 'REC Recebíveis Imob. FII',       'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RBRR11', 'name' => 'RBR High Grade FII',             'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VGIR11', 'name' => 'Valora RE III FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'TPFT11', 'name' => 'TG Ativo Real FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'CPTS11', 'name' => 'Capitânia Securities II FII',    'asset_type_id' => 2, 'category_id' => 1],

      // Híbridos / Fundo de Fundos
      ['ticker' => 'BPFF11', 'name' => 'Brasil Plural Absoluto FoF FII', 'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'BCFF11', 'name' => 'BTG Pactual Fundo de Fundos FII', 'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RBRF11', 'name' => 'RBR Alpha FoF FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'KFOF11', 'name' => 'Kinea FoF FII',                  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'MGFF11', 'name' => 'Mogno FoF FII',                  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HFOF11', 'name' => 'Hedge Top FoF III FII',          'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'FISD11', 'name' => 'MORE FoF FII',                   'asset_type_id' => 2, 'category_id' => 1],

      // Residencial
      ['ticker' => 'RZAK11', 'name' => 'Riza Arctium Real Estate FII',   'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HOSI11', 'name' => 'Housi FII',                      'asset_type_id' => 2, 'category_id' => 1],

      // Agro / Rural
      ['ticker' => 'RURA11', 'name' => 'Itaú Asset Rural FII',           'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'HRUR11', 'name' => 'Hedge Ativos Rurais FII',        'asset_type_id' => 2, 'category_id' => 1],

      // Educacional / Hospitalar
      ['ticker' => 'HCTR11', 'name' => 'Hectare CE FII',                 'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'NSLU11', 'name' => 'NS Luta CRI FII',                'asset_type_id' => 2, 'category_id' => 1],

      // Outros populares
      ['ticker' => 'KNRI11', 'name' => 'Kinea Renda Imobiliária FII',    'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'JSRE11', 'name' => 'JS Real Estate Multigestão FII', 'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'RBRX11', 'name' => 'RBR Alpha Multiestratégia FII',  'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'XPCI11', 'name' => 'XP Crédito Imobiliário FII',     'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'VINO11', 'name' => 'Vinci Offices FII',              'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'GTWR11', 'name' => 'GreenTowers FII',                'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'URPR11', 'name' => 'Urbana Prime FII',               'asset_type_id' => 2, 'category_id' => 1],
      ['ticker' => 'PORD11', 'name' => 'Polo Recebíveis Imob. FII',      'asset_type_id' => 2, 'category_id' => 1],
    ];

    $now = now();

    foreach ($acoes as $acao) {
      DB::table('assets')->insertOrIgnore([
        'ticker'        => $acao['ticker'],
        'name'          => $acao['nome'],
        'asset_type_id' => 1, // Ações
        'category_id'   => 1, // Renda Variável
        'created_at'    => $now,
        'updated_at'    => $now,
      ]);
    }

    // Mapeia timestamps
    $fiisComTimestamp = array_map(fn($f) => array_merge($f, [
      'created_at' => $now,
      'updated_at' => $now,
    ]), $fiis);

    // Insere sem duplicar (caso rode migrate:refresh sem --seed fresh)
    foreach ($fiisComTimestamp as $fii) {
      DB::table('assets')->updateOrInsert(
        ['ticker' => $fii['ticker']],
        $fii
      );
    }
  }
}
