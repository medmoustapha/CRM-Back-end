<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  return Product::get();
//
        // return DB::select( DB::raw("select distinct sku,sum(price)as total from products group by sku;") );

        //return DB::select( DB::raw("select * from View_QteAchat;") );
    }

    public function depenses()
    {
        return DB::select(DB::raw("SELECT CONVERT(INT,(sum([mnt])))as Depense
                                            FROM [ASM2014web26].[dbo].[M_Depense];"));

    }

    public function topVente()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct [libelleArticle],
        count([libelleArticle])as numbre
          FROM [ASM2014web26].[dbo].[View_AchatVente] group by [libelleArticle] Order by [numbre] desc
          OFFSET 0 ROWS 
        FETCH FIRST 20 ROWS ONLY;"));
    }

    public function topProduit()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct [libelleFamille],
CONVERT(INT,(sum([Qtevendu]))) as Qtevendu
  FROM [ASM2014web26].[dbo].[View_AchatVente] where [libelleFamille] <>''
   group by [libelleFamille] order by [QteVendu] desc
   OFFSET 0 ROWS 
FETCH FIRST 10 ROWS ONLY;"));
    }

    public function ProduitVenduParNombre(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;

        return DB::select(DB::raw("SELECT distinct [libelleFamille],
count(*) as nombre
  FROM [ASM2014web26].[dbo].[View_AchatVente] where [libelleFamille] <>''
  and year([dateDocument])<=$date2 and year([dateDocument])>= $date1
   group by [libelleFamille] ;"));
    }

    public function depenseStation()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct [type],
      sum([montant]) as montant
  FROM [ASM2014web26].[dbo].[View_Depsense_station] 
  group by [type] order by [montant] desc
  OFFSET 0 ROWS 
FETCH FIRST 10 ROWS ONLY;"));
    }

    public function depenseParStationEtDate(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct [type]as typee ,
      sum([montant]) as montant
	  ,year([date])as dated
  FROM [ASM2014web26].[dbo].[View_Depsense_station] 
  where year([date])<=$date2 and year([date])>= $date1
  group by [type],year([date]) order by year([date]) asc ;"));
    }

    public function DateDep()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct year([date])as dated
  FROM [ASM2014web26].[dbo].[View_Depsense_station] 
  where [date]<'2019' order by[dated] asc
   ;"));
    }

    public function DatePvd()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct year([dateDocument])as dated
  FROM [ASM2014web26].[dbo].[View_AchatVente] where year([dateDocument]) <>''
  order by year([dateDocument]) asc;"));
    }

    /*
    TOP CLI v1
    public function TopClient()
     {
         //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

         return DB::select( DB::raw("SELECT distinct([client]),
   CONVERT(INT,(sum([montant])))as montant
   FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
   group by[client]order by[montant] desc
    OFFSET 0 ROWS
 FETCH FIRST 5 ROWS ONLY;") );
     } */
    public function TopClient()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct([client]),
  LEFT(CONVERT(INT,(sum([montant]))),4)as montant
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where [dateDocument]<'2019'
  and [client]<>'Youssef hajjej'and [client]not like'Brand%'
  group by[client]order by[montant] desc
   OFFSET 0 ROWS 
FETCH FIRST 5 ROWS ONLY;"));
    }

    public function NbClient()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT count(distinct([client]))as totatlClt
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement];"));
    }

    public function tabReglement()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT SUBSTRING([commercial],0,7)as commercial
	  ,CONVERT(INT,[mntRegler])as mntRegler
      ,[dateDocument]
      ,[versement]
      ,[libelleArticle]
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where [commercial]<>''and [commercial]<>'asm';"));
    }

    public function ChartComercialDate()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct(year([dateDocument]))as dateDocument
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  order by [dateDocument] asc ;"));
    }

    public function ChartComercialDetail(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $commercial = $request->commercial;

        return DB::select(DB::raw("SELECT [commercial]
      ,[dateDocument]
      ,[codeClasseDocument]
      ,[libelleClasseDocument]
      ,[codeArticle]
      ,[libelleArticle]
      ,[mntNetht]
      ,[mntttc]
      ,[libelleTypeArticle]
      ,[numero]
      ,[montant]
      ,[dateEcheance]
	  ,[dateMouvement]
      ,[versement]
      ,[total_ancien_reglement]
      ,[reste]
      ,[code_clt]
      ,[client]
      ,[code_commercial]
      ,[tauxTva]
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where year([dateDocument])<=$date2 and year([dateDocument])>=$date1
   and [commercial] like '$commercial' ;"));
    }


    public function ChartDistinctComercial()
    {
        return DB::select(DB::raw("SELECT distinct [commercial]
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where  [commercial]<>'' and  [commercial]<>'asm'
  
   ;"));
    }


    public function ChartComercial()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct[commercial],
LEFT(convert(int,sum([mntRegler])),5)as montantTotal
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where [commercial]<>'' and [commercial]<>'asm'
  group by[commercial];"));
    }

    public function DetailReglement()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT [commercial]
	  ,[client]
	  ,CONVERT(INT,[mntRegler])as mntRegler
      ,[dateDocument]
      ,[codeArticle]
      ,[libelleArticle]
	  ,[mntttc]
	  ,[versement]
	  ,[tauxTva]
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where [commercial]<>'' and [commercial]<>'asm' order by [mntttc];"));
    }


    public function FourniProd()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct[NomPrenomFour],
	   [libelleFamille]
      ,sum([QteAchatee]) QteA
      ,year([dateDocument]) as datef
  FROM [ASM2014web26].[dbo].[View_QteAchat]
  where [NomPrenomFour]is not null and  
						[libelleFamille]is not null and
											[libelleFamille] <>''
  group by [NomPrenomFour] ,year([dateDocument]),[libelleFamille]
  order by [NomPrenomFour] asc;"));
    }

    public function CA()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT convert(int,sum([qte]*[prixuVenteTTC]))as CA
  FROM [ASM2014web26].[dbo].[View_All_Exercice]
  where [datecreation]<'2019';"));
    }

    public function DateCmdClte()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct year([dateLigne])as dated
  FROM [ASM2014web26].[dbo].[View_CommandeClt]
  order by[dated] asc
   ;"));
    }

    public function CmdClt(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        return DB::select(DB::raw("SELECT distinct(SUBSTRING([nomPrenomTier],0,12))as nomPrenomTier
	  ,[numordre]
	  ,[idDocument]
      ,SUBSTRING([libelleArticle],0,10)as libelleArticle
      ,CONVERT(INT,[qte])as qte
      ,cast([puht] as decimal(10,2)) as puht
      ,cast([puttc] as decimal(10,2)) as puttc
	  ,cast([mntttc] as decimal(10,2)) as mntttc
      ,cast([mntTva] as decimal(10,2)) as mntTv
      ,convert(date,[dateLigne])as dateligne
  FROM [ASM2014web26].[dbo].[View_CommandeClt]
where year([dateLigne])<=$date2 and year([dateLigne])>= $date1 and
[puht] <>'0' and [puht] is not null and
  [puttc]<>'0' and [puttc]is not null and
  [mntttc]<>'0' and [mntttc]is not null
 
  group by[dateLigne],[nomPrenomTier],[numordre],
  [idDocument],[libelleArticle],[qte],[puht],[puttc],[mntttc],[mntTva]
  order by [dateligne] desc;"));
    }


    public function CAparAnnee()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct (year([datecreation]))as annee,
                            convert(int,sum([qte]*[prixuVenteTTC]))as CA
                              FROM [ASM2014web26].[dbo].[View_All_Exercice]
							  where [datecreation]<'2019'
                              group by year([datecreation]) order by[annee] asc
                              
                              ;"));
    }

    public function nbVente()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT count(*)as total
  FROM [ASM2014web26].[dbo].[View_AchatVente];"));
    }

    public function EvoClient()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct(year([dateDocument])) as datet,
count(distinct[client]) as nombre
  FROM [ASM2014web26].[dbo].[View_Detail_Reglement]
  where [client]is not null and [dateDocument]<'2019'
  group by year([dateDocument]) order by[datet] asc;"));
    }


    public function StockArticle()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct [libelleArticle]
              ,convert(INT,sum([qte])) as qte,
           [prixuVenteHt]
          FROM [ASM2014web26].[dbo].[View_Inv_Stk_sup0]
          where  [prixuVenteHt] <>'0'  and [libelleArticle] not like 'bob%' 
		  and [libelleArticle] not like'conce%'
          group by ([libelleArticle]) ,[prixuVenteHt] order by [qte] desc;"));
    }

    public function DepenseParAnnee()
    {
        //return DB::select( DB::raw("select sum(montant)as depense from View_Depsense_station;") );

        return DB::select(DB::raw("SELECT distinct(year([datedep]))as annee,
sum([mnt])as Depense
  FROM [ASM2014web26].[dbo].[M_Depense]
  group by year([dateDep])order by [annee] asc ;"));
    }

    public function nbEmploye()
    {
        return DB::select(DB::raw("SELECT count(distinct([nomPrenom]))as nombreEmploye
  FROM [ASM2014web26].[dbo].[p_utilisateur];"));

    }

    public function DebitCredit(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        return DB::select(DB::raw("SELECT 
      [idbanque],
      [debit]
      ,[credit]
     ,replace ( [TypeReg] , 'È' ,'e') as TypeReg,
	 CONVERT(date, [dateMouvement]) as dateT,
      [idDevise]
	FROM [ASM2014web26].[dbo].[Releve_Banque] 
	where year([dateMouvement])<=$date2 and year([dateMouvement])>= $date1
	order by [dateMouvement] desc ;"));

    }


    public function DebitCreditDetail(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        return DB::select(DB::raw("SELECT distinct [type]as typee ,
      sum([montant]) as montant,
	  [description],[station]
	  ,convert(date,[date])as dated
  FROM [ASM2014web26].[dbo].[View_Depsense_station] 
  where year([date])<=$date2 and year([date])>= $date1
  group by [type],convert(date,[date]), [description],[station] order by convert(date,[date]) asc ;"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id != null) {
            Product::where('id', $id)->update($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id != null) {
            $product = Product::find($id);
            $product->delete();
        }
    }
}
