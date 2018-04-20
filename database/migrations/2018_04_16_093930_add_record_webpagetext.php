<?php

use RecognitionGame\Models\Webpagetext;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordWebpagetext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $webpagetext = new Webpagetext();
        // $webpagetext->id = 1;
        // $webpagetext->text_hu = 'Magyar';
        // $webpagetext->text_en = 'English';
        // $webpagetext->save();
        Webpagetext::insert(array(
            array(
                'id' => 1,
                'text_hu' => 'Magyar',
                'text_en' => 'English'
            ),array(
                'id' => 2,
                'text_hu' => 'Felismerő Játék',
                'text_en' => 'Recognition Game'
            ),array(
                'id' => 3,
                'text_hu' => 'Kikapcsolódás',
                'text_en' => 'Relax'
            ),array(
                'id' => 4,
                'text_hu' => 'Szórakozás',
                'text_en' => 'Fun'
            ),array(
                'id' => 5,
                'text_hu' => 'Játék',
                'text_en' => 'Game'
            ),array(
                'id' => 12,
                'text_hu' => 'Köszöntő',
                'text_en' => 'Greeting'
            ),array(
                'id' => 13,
                'text_hu' => 'Üdvözöllek ezen az ingyenes online játékoldalon.',
                'text_en' => 'Welcome in this free online game site.'
            ),array(
                'id' => 14,
                'text_hu' => 'A kvíz felépítésű játék folyamán kép alapján kell felismerni pl: ország zászlóját, autót vagy hírességet. Tedd próbára a felismerő képességedet, hogy mennyire figyelsz a körülötted lévő dolgokra, mindezt szórakozás és kikapcsolódás formájában.',
                'text_en' => "Based on images recognize e.g. country's flag, car or celebrity during the quiz based game.Test your recognizing skill, how do you keep attention in your surrounding things with fun and relax."
            ),array(
                'id' => 15,
                'text_hu' => 'Jó játékot kívánok!',
                'text_en' => 'Have a good play!'
            ),array(
                'id' => 39,
                'text_hu' => 'Email',
                'text_en' => 'Email'
            ),array(
                'id' => 43,
                'text_hu' => 'Email mező kötelező',
                'text_en' => 'Email field required'
            ),array(
                'id' => 44,
                'text_hu' => 'Nem megfelelő email',
                'text_en' => 'Bad email'
            ),array(
                'id' => 55,
                'text_hu' => 'Tárgy',
                'text_en' => 'Subject'
            ),array(
                'id' => 56,
                'text_hu' => 'Üzenet',
                'text_en' => 'Message'
            ),array(
                'id' => 57,
                'text_hu' => 'Üzenet elküldése',
                'text_en' => 'Send message'
            ),array(
                'id' => 59,
                'text_hu' => 'Az üzenet elküldésre került. Köszönöm!',
                'text_en' => 'The message has been sent. Thank you!'
            ),array(
                'id' => 60,
                'text_hu' => 'Üzenet mező kötelező',
                'text_en' => 'Message field required'
            ),array(
                'id' => 125,
                'text_hu' => "<strong>Adatkezelő:</strong> Révész Imre<br/><strong>Weboldal:</strong> www.felismerojatek.hu<br/><br/>
                    Tájékoztatom, hogy az Adatkezelő által üzemeltetett weboldal teljes egészében ingyenesen használható, látogatható.<br/><br/>
                    <strong>Toplista:</strong> A weboldalon egy esetben, amennyiben a toplistára kíván feliratkozni a felhasználó, akkor szükséges személyes adatot (továbbiakban: email cím) megadni. Az adatszolgáltatás minden esetben önkéntes, azaz a látogató szabadon dönthet arról, hogy megadja-e a kért email címet.<br/><br/>
                    Az Adatkezelő kijelenti, hogy az email címet kizárólag a toplistán történő megjelenítés céljából használja.<br/><br/>
                    Az érintett az <a class=link href=/contact>recognitiongame@gmail.com </a> elektronikus email címen tájékoztatást kérhet az email címének kezeléséről, kérheti továbbá email címe helyesbítését vagy törlését. Emellett, az adatkezeléssel érintett személyt megilleti a tiltakozási jog, valamint a bírósági jogérvényesítés joga.<br/><br/>
                    A weboldal tartalma az Adatkezelő szellemi tulajdonát képezi, mely az Adatkezelő előzetes írásbeli engedélye nélkül semmilyen formában nem használható fel.<br/><br/>
                    Az adatkezelő megtesz minden szükséges intézkedést annak érdekében, hogy biztosítsa az adatok biztonságos, sérülésmentes kezelését és az ehhez szükséges adatkezelési rendszerek kiépítését, működtetését. Adatkezelő gondoskodik arról, hogy a kezelt adatokhoz illetéktelen személy ne férhessen hozzá, ne hozhassa nyilvánosságra, ne továbbíthassa, valamint azokat ne módosíthassa, törölhesse. Adatkezelő megtesz minden tőle telhetőt annak érdekében, hogy az adatok véletlenül se sérüljenek, illetve semmisüljenek meg.<br/><br/>
                    <strong>Hírlevél:</strong> Az email címre elektronikus hírlevél nem kerül kiküldésre.<br/><br/>
                    <strong>Cookie:</strong> A Weboldalak egyes részei a látogató azonosításának érdekében kisméretű adatfájlokat, ún. cookie-kat használnak, amelyek a látogató számítógépén tárolódnak. A böngésző program segítségével a látogató beállíthatja, meggátolhatja a cookie-kal kapcsolatos tevékenységet, azonban felhívjuk figyelmét arra, hogy a cookie-k használata nélkül előfordulhat, hogy nem képes használni az adott weboldal minden szolgáltatását. Jelen Weboldal látogatásával és annak egyes funkciói használatával Ön hozzájárulását adja ahhoz, hogy az említett cookie-k az Ön számítógépén tárolódjanak és ahhoz az Adatkezelő hozzáférhessen. Ön ugyanakkor bármikor kérheti azok törlését, emellett, böngésző program segítségével beállíthatja és meggátolhatja a cookie-kal kapcsolatos tevékenységet.<br/><br/>
                    <strong>Google Analytics:</strong> Az adott weboldalon a látogatás rögzítése végett a látogató számítógépének internet címe (IP cím), naplózásra kerül, mely adatok tárolása kizárólag statisztikai célokat szolgál. A naplófájlban található adatok nem kerülnek összekapcsolásra egyéb személyes adatokkal, amely alapján Ön személyesen azonosítható lenne.",
                'text_en' => "<strong>Data handler:</strong> Imre Révész<br/>
                    <strong>Website:</strong> www.recognitiongame.com<br/><br/>
                    I would like to inform you that the web site operated by the data handler can be accessed freely. <br/> <br/>
                    <strong>Toplist:</strong> In one case, if you want to subscribe to the toplist, you will need to provide personal information (later: email address). Data is always voluntary, meaning that visitors are free to choose whether to provide the requested email address. <br/> <br/>
                    The data handler declares to use the email address exclusively for display on the toplist. <br/> <br/>
                    The person concerned can contact <a class=link href=/contact> recognitiongame@gmail.com </a> for information on how to handle email address, and may request a correction or deletion of email address. In addition, the person affected by data processing has the right to protest and to enforce the law. <br/> <br/>
                    The content of this website is the intellectual property of the data handler, which can't be used in any form without the prior written permission of the data handler. <br/> <br/>
                    The data handler shall take all necessary measures to ensure the safe and undamaged management of the data and the deployment and operation of the necessary data management systems. The data handler shall ensure that no unauthorized person has access to, disclose, transmit, or modify or delete the data processed. The data handler will do its utmost to ensure that the data are not accidentally damaged or destroyed. <br/> <br/>
                    <strong>Newsletter:</strong> An electronic newsletter will not be sent to the email address. <br/> <br/><strong> Cookies: </strong> Some parts of the Website allow small data files to identify the visitor, cookies that are stored on the visitor's computer. The browser program allows the visitor to set up, prevent cookie activity, but please note that without using cookies, you may not be able to use all the features of that web site. By visiting this Website and using certain features of your site, you consent to these cookies being stored on your computer and accessed by the data handler. You can at any time request deletion, and you can configure and block cookie-related activity by using a browser program. <br/> <br/>
                    <strong> Google Analytics: </strong> The website records the visitor's computer ('IP address'), which data is stored for statistical purposes only. The data in the log file will not be linked to other personal information that will allow you to be personally identifiable."
            ),array(
                'id' => 1000,
                'text_hu' => 'Főoldal',
                'text_en' => 'Home'
            ),array(
                'id' => 1001,
                'text_hu' => 'Kapcsolat',
                'text_en' => 'Contact'
            ),array(
                'id' => 1002,
                'text_hu' => 'Toplista',
                'text_en' => 'Highscore'
            ),array(
                'id' => 1003,
                'text_hu' => 'Adatvédelmi irányelvek',
                'text_en' => 'Privacy policy'
            )
        ));        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
