Tālākais teksts domāts personām ar attiecīgajām zināšanām par programmēšanas pamatiem un ietvaru - Laravel

Kad projekts ir "Klonēts" uz lokālās ierīces, ieiet mapē kurā tas atrodas un izpildīt šīs komandas termināli(katru atsevišķi):
composer i
npm i

Pirms tālākajām darbībām ir nepieciešams nokopēt (.env.example) failu un pārdēvēt par (.env) ar visu, kas taja ir iekšā

Tad Vajag ģenerēt atslēgu izmantojot komandu - php artisan key:generate

Pēc tam izpildīt - php artisan migrate un - php artisan db:seed

Pēc tam, lai palaistu projektu lokāli - php artisan serve un atsevišķā terminālī - npm run dev
Ja ir iespēja var izmantot - composer run dev

Pēc tam ja ir nepieciešamība attiestatīt datubāzi var izmantot - php artisan migrate:fresh --seed

Administratora konts:
E-pasts - admin@example.com
Parole - password

Lai turpmākās darbības butu sekmīgas ir nepieciešami 2 API (ElevenLabs, OpenAI)
abi ir par maksu un (API_KEYS) šeit nebūs norādītas, tāpēc zemāk rakstīto var ignorēt

Lai "sinhronizētu" mp3 failus izmantot pogu, kas pieejama administratora kontam, sākuma skatā un tad termināli izpildīt šo komandu - 
php artisan queue:work --queue=mp3-generation

Lai "sinhronizētu" jaunu valodu vai esošu(ja ir jauni teksti, kas jātūlko), izmantot - php artisan queue:work --queue=text-translation

Lai sagatavotu jaunus "localizācijas" failus izmantot - php artisan lang:prepare (un šeit jāraksta jaunās valodas kods tos var atrast internetā) un lai iztulkotu uz jauno valodu izmantot - php artisan lang:translate (tas pats valodas kods ko izmantoji sagatavošanā)
