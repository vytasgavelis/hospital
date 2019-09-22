Apie
==========

  2019 NFQ Akademijos stojimo užduotis<br />
  Vytas Gavelis <br />
  Projektas patalpintas: https://hospitalgav.herokuapp.com/index.php <br />
  
Bibliotekos
==========
https://developers.google.com/chart/ <br />

Projekto aprašymas
==========
Projekte dominuoja php kalba, javascript panaudotas piešiant statistiką. MVC nekūriau dėl laiko trūkumo. Stengiausi vadovautis OOP principais, kad padaryti kodą suprantamesnį ir labiau palaikomą.

Kaip veikia
==========
**_Viešai pasiekiami failai_**<br />
<br />
**index.php** <br />
Klientas užsiregistruoja ir gauna nuorodą, kurioje gali valdyti savo apsilankymą. <br />
**board.php** <br />
Švieslentė, kurioje galima matyti pagal datą atrinktus klientus. <br />
**manage.php** <br />
Veikia taip pat kaip board.php tik yra mygtukas, kurį paspaudus klientas yra aptarnaujamas. <br />
**statistics.php** <br />
Pasirinkus specialistą galima matyti jo labiausiai užimtas valandas. <br />
**appointment.php** <br />
Sugeneruota nuoroda klientui, kur jis gali atšaukti arba pavėlinti savo apsilankymą <br />


**_Klasės_**<br />
<br />
**Client.php**<br />
Skirta darbui su klientu.<br />
**ClientService.php**<br />
Veikia panašiai kaip konteineris. Skirta darbui su klientu, kai neturimas kliento objektas, bet turima pvz.: id arba klientų masyvų gražinimui.<br />
**Specialist.php** ir **SpecialistService.php**<br />
Veikia taip pat kaip ir klientų klasės.<br />
**TimeService.php**<br />
Naudojama įdėti apsilankymų laikus į duombazę, apskaičiuoti vidutinį specialisto laukimo laiką ir porą naudingų metodų skirtų paversti laiko formatą į sekundes ir atvirkščiai (šitie metodai turbūt neturėjo čia būti, bet nežinojau į kurią klasę daugiau juos įdėti).<br />

Problemos
==========
Produkcijoje projekte turėtų būti implementuotas laikas kada specialistas dirba, kada ne. Dabar kadangi to nėra, specialistų vidutiniai laikai susidaro kelių dienų ilgio. <br />
Taip pat turėtų būti sukurta prisijungimo sistema specialistams <br />

Kontaktai
==========
gavelisvytas@gmail.com<br />
https://www.linkedin.com/in/vytas-gavelis-8a7438188/

<h1>Ačiū už dėmesį.</h1>
