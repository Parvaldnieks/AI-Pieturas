Kad projekts ir "Klonēts" uz lokālās ierīces, ieiet mapē kurā tas atrodas un izpildīt šīs komandas termināli(katru atsevišķi):
composer i
npm i

Pēc tam izpildīt - php artisan migrate
Un - php artisan db:seed
Pēc tam, lai pilnībā attiestatītu datubāzi(nav obligāti) - php artisan migrate:fresh --seed

Administratora konts:
E-pasts - admin@example.com
Parole - password

Lai turpmākās darbības butu sekmīgas ir nepieciešami 2 API (ElevenLabs, OpenAI)
abi ir par maksu

Lai "sinhronizētu" mp3 failus izmantot pogu, kas pieejama administratora kontam, sākuma skatā un tad termināli izpildīt šo komandu - 
php artisan queue:work --queue=mp3-generation

Lai "sinhronizētu" jaunu valodu vai esošu(ja ir jauni teksti, kas jātūlko), izmantot - php artisan queue:work --queue=text-translation

Lai sagatavotu jaunus "localizācijas" failus izmantot - php artisan lang:prepare (un šeit jāraksta jaunās valodas kods tos var atrast internetā) un lai iztulkotu uz jauno valodu izmantot - php artisan lang:translate (tas pats valodas kods ko izmantoji sagatavošanā)
