# Introduction #

The regular meeting minutes denote required actions and evolving
requirements. Also priorities are being discussed

# Details #

Add your content here.  Format your content with:
  * Text in **bold** or _italic_
  * Headings, paragraphs, and lists
  * Automatic links to other wiki pages

Hierbij de zaken die we kort besproken hadden voor de middag
Elke code tekst die ik schrijf is een pseudocode, en hoef je dus niet letterlijk te kopieren bij implementatie.
:
Enumeratietabellen:
> answerenum (id [0-5] int pk, short\_desc varchar uniq, long\_desc varchar)
> pollstate(id [0-3] int pk, short\_desc varchar uniq, long\_desc varchar)
Bijkomende tabellen:
> parameter tabel params (id int pk, name varchar uniq, value (int ? / varchar?) , description varchar, comment varchar)
> pollbatch (id int pk, created datetime, status, comment varchar)
> pollbatchstatus (id [0-4] int pk, short\_desc varchar uniq, long\_desc varchar)
Vergeet ook niet de referentiele integriteit (foreign keys) te waarborgen bij elke tabel waar nodig, zoals oa, bij enumeraties van antwoorden en states.
Nice to have (uitgesteld tot later, voorlopig dus niet mandatory te implementeren)
> Tekstboodschappen in de pagina's komen uit een tabel (id, name, text, comment) zodat deze van daaruit geupdated kunnen worden.
> Hierin voorzien we geen subsitutie van placeholders (vereenvoudiging).

Agenda:
> We willen graag de finalisatie van het datamodel deze week nog zien.
> > + aangevuld met alle select statements voor de views
> > + aangevuld met relevante vragen en een "aanzet" om dit uit het datamodel te halen,
> > > dit laatste is een check op de volledigheid van het datamodel

Volgende week willen we graag PHP implementatie van de schermen zien in een demo versie.

> De volledige flow die een gebruiker ziet (inloggen - eigen vragen - user selectie - stats - reviews - eindrapport)
> een aantal admin schermen + eventuele testschermen om zaken in te vullen te monitoren
> > maak hierbij goed onderscheid tussen de user flow en de admin/test toegang.

> We willen hier voor het user stuk toch een handig ogende interface zien, indien mogelijk. Voor het admin stuk is dat minder kritisch.

Hier maken we nog abstractie van het koppelvormingsproces en algoritme erachter.
> Naast verfijningen op de schermen en lopende zaken, gaan we hiermee vanaf woensdag volgende week (13/08) mee starten.
> We voorzien ook tijd voor het porten/overzetten naar Linux.
> > Belangrijk is steeds code in te checken met subversion

bij vragen kan je bij mij of Johan terecht,